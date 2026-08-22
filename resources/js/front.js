document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.querySelector('[data-auth-overlay]');
    const panes = overlay ? overlay.querySelectorAll('[data-auth-pane]') : [];
    let lastFocused = null;

    // ---- Helpers ---------------------------------------------------------

    function normalizeDialog(value) {
        return (value || '').trim().toUpperCase();
    }

    function lockBodyScroll() {
        document.body.style.overflow = 'hidden';
    }

    function unlockBodyScroll() {
        document.body.style.overflow = '';
    }

    function currentAuthState() {
        return document.body.getAttribute('data-authenticated') === '1' ? '1' : '0';
    }

    function showPane(dialog) {
        if (!overlay) return;

        const target = normalizeDialog(dialog);
        let matched = false;

        panes.forEach(function (pane) {
            const isMatch = normalizeDialog(pane.dataset.authPane) === target;
            pane.hidden = !isMatch;
            if (isMatch) matched = true;
        });

        overlay.hidden = !matched;

        if (matched) {
            lockBodyScroll();
            const visiblePane = Array.prototype.find.call(panes, function (p) {
                return !p.hidden;
            });
            const focusTarget =
                (visiblePane && visiblePane.querySelector(
                    'input, button, select, textarea, [href], [tabindex]:not([tabindex="-1"])'
                )) || overlay.querySelector('.auth-close');
            focusTarget?.focus();
        } else {
            unlockBodyScroll();
        }
    }

    function setDialogParam(dialog) {
        const url = new URL(window.location.href);
        url.searchParams.set('dialog', normalizeDialog(dialog));
        window.history.replaceState({}, document.title, url.pathname + url.search);
    }

    function clearDialogParam() {
        const url = new URL(window.location.href);
        if (url.searchParams.has('dialog')) {
            url.searchParams.delete('dialog');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
    }

    function openAuthModal(dialog) {
        lastFocused = document.activeElement;
        setDialogParam(dialog);
        showPane(dialog);
    }

    function closeAuthModal() {
        clearDialogParam();

        if (overlay) {
            overlay.hidden = true;
            panes.forEach(function (pane) {
                pane.hidden = true;
            });
        }

        unlockBodyScroll();

        if (lastFocused && typeof lastFocused.focus === 'function') {
            lastFocused.focus();
        }
        lastFocused = null;
    }

    // ---- Open: intercept the auth links ---------------------------------

    document.querySelectorAll('.auth-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            if (currentAuthState() === '1') return; // حماية إضافية لو مسجل بالفعل

            let dialog = null;
            try {
                dialog = new URL(btn.href).searchParams.get('dialog');
            } catch (err) {
                dialog = null;
            }
            if (dialog) openAuthModal(dialog);
        });
    });

    // ---- Form Submit: تنظيف الرابط قبل الـ POST عشان ميتسجلش في الـ History ----

    if (overlay) {
        overlay.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('submit', function () {
                clearDialogParam();
            });
        });
    }

    // ---- Close: X button + backdrop click + Escape ----------------------

    if (overlay) {
        const closeButton = overlay.querySelector('.auth-close');
        closeButton?.addEventListener('click', closeAuthModal);

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                closeAuthModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !overlay.hidden) {
                closeAuthModal();
            }
        });
    }

    // ---- Deep-link / Initial load ---------------------------------------

    (function handleInitialState() {
        const url = new URL(window.location.href);
        const dialog = url.searchParams.get('dialog');

        if (!dialog) return;

        if (currentAuthState() === '1') {
            clearDialogParam();
            return;
        }

        openAuthModal(dialog);
    })();

    // ---- User dropdown --------------------------------------------------

    const userDropdown = document.getElementById('userDropdown');
    const userDropdownMenu = document.getElementById('userDropdownMenu');

    if (userDropdown && userDropdownMenu) {
        userDropdown.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const isShown = userDropdownMenu.classList.contains('show');

            userDropdown.classList.remove('show');
            userDropdownMenu.classList.remove('show');
            userDropdown.setAttribute('aria-expanded', 'false');

            if (!isShown) {
                userDropdown.classList.add('show');
                userDropdownMenu.classList.add('show');
                userDropdown.setAttribute('aria-expanded', 'true');
            }
        });

        document.addEventListener('click', function (e) {
            if (
                !userDropdown.contains(e.target) &&
                !userDropdownMenu.contains(e.target)
            ) {
                userDropdown.classList.remove('show');
                userDropdownMenu.classList.remove('show');
                userDropdown.setAttribute('aria-expanded', 'false');
            }
        });
    }
});

// ---- Sync & BFcache Guard --------------------------------------------

function getDomAuthState() {
    return document.body ? (document.body.getAttribute('data-authenticated') === '1' ? '1' : '0') : '0';
}

(function syncAuthMarker() {
    try {
        sessionStorage.setItem('auth_state', getDomAuthState());
    } catch (e) {}
})();

window.addEventListener('pageshow', function (event) {
    if (!event.persisted) return;

    let known = null;
    try {
        known = sessionStorage.getItem('auth_state');
    } catch (e) {}

    const cached = getDomAuthState();

    if (known !== null && known !== cached) {
        const url = new URL(window.location.href);
        if (url.searchParams.has('dialog')) {
            url.searchParams.delete('dialog');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
        window.location.reload();
    }
});
