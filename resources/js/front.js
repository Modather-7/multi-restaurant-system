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
        return document.body && document.body.getAttribute('data-authenticated') === '1' ? '1' : '0';
    }

    function focusFirstError(pane) {
        const slots = pane.querySelectorAll('[data-error-for]');
        for (const slot of slots) {
            if (slot.textContent.trim() !== '') {
                const fieldName = slot.getAttribute('data-error-for');
                const field = pane.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    field.focus();
                    return true;
                }
            }
        }
        return false;
    }

    // ---- Focus trap جوه الـ modal ----
    function trapFocus(e) {
        if (!overlay || overlay.hidden || e.key !== 'Tab') return;

        const visiblePane = Array.prototype.find.call(panes, function (p) {
            return !p.hidden;
        });
        if (!visiblePane) return;

        const focusableSelector = 'input, button, select, textarea, [href], [tabindex]:not([tabindex="-1"])';
        const focusable = Array.prototype.filter.call(
            overlay.querySelectorAll(focusableSelector),
            function (el) { return el.offsetParent !== null; } // visible only
        );
        if (focusable.length === 0) return;

        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (e.shiftKey && document.activeElement === first) {
            e.preventDefault();
            last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
            e.preventDefault();
            first.focus();
        }
    }

document.addEventListener('keydown', trapFocus);

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

            if (visiblePane && !focusFirstError(visiblePane)) {
                const focusTarget =
                    visiblePane.querySelector(
                        'input, button, select, textarea, [href], [tabindex]:not([tabindex="-1"])'
                    ) || overlay.querySelector('.auth-close');
                focusTarget?.focus();
            }
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
        document.querySelector('main')?.setAttribute('inert', '');
    }

    function closeAuthModal() {
        clearDialogParam();
        document.querySelector('main')?.removeAttribute('inert');

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

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.auth-btn');
        if (!btn) return;

        e.preventDefault();
        if (currentAuthState() === '1') return;

        let dialog = null;
        try {
            dialog = new URL(btn.href, window.location.origin).searchParams.get('dialog');
        } catch (err) {
            dialog = null;
        }
        if (dialog) openAuthModal(dialog);
    });

    // ---- Form Submit: تنظيف الرابط قبل الـ POST ------------------------

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

    // ---- Deep-link / Initial load / Validation Auto-open -----------------

    (function handleInitialState() {
        if (currentAuthState() === '1') {
            clearDialogParam();
            return;
        }

        const url = new URL(window.location.href);
        const urlDialog = url.searchParams.get('dialog');
        const autoOpen = overlay ? overlay.getAttribute('data-auto-open') : null;
        const dialog = autoOpen || urlDialog;

        if (!dialog) return;

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

// ---- Sync & BFcache Guard (بدون Infinite Loop) ------------------------

function getDomAuthState() {
    return document.body && document.body.getAttribute('data-authenticated') === '1' ? '1' : '0';
}

function isBackForwardNavigation(event) {
    if (event && event.persisted) return true;

    const navEntries = performance.getEntriesByType('navigation');
    if (navEntries.length && navEntries[0].type) {
        return navEntries[0].type === 'back_forward';
    }

    if (performance.navigation) {
        return performance.navigation.type === 2;
    }
    return false;
}

window.addEventListener('pageshow', function (event) {
    let known = null;
    try {
        known = sessionStorage.getItem('auth_state');
    } catch (e) {}

    const cached = getDomAuthState();

    // لا يتم عمل Reload إلا إذا كان الرجوع بـ Back/Forward وهناك اختلاف حقيقي
    if (isBackForwardNavigation(event) && known !== null && known !== cached) {
        const url = new URL(window.location.href);
        if (url.searchParams.has('dialog')) {
            url.searchParams.delete('dialog');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
        window.location.reload();
        return;
    }

    // في التحميل العادي يتم دائماً تحديث الـ marker لمنع الـ Loop
    try {
        sessionStorage.setItem('auth_state', cached);
    } catch (e) {}
});
