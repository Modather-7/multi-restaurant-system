document.addEventListener('DOMContentLoaded', function () {
    const closeButton = document.querySelector('.auth-close');
    const overlay = document.querySelector('.auth-overlay');

    function closeAuthModal() {
        if (overlay) {
            let url = new URL(window.location.href);

            if (url.searchParams.has('dialog')) {
                url.searchParams.delete('dialog');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            }

            overlay.remove();
        }
    }

    closeButton?.addEventListener('click', closeAuthModal);

    if (overlay) {
        document.addEventListener('click', function (e) {
            if (e.target === overlay) {
                closeAuthModal();
            }
        });
    }

    if (window.isAuthenticated) {
        let url = new URL(window.location.href);

        if (url.searchParams.has('dialog')) {
            url.searchParams.delete('dialog');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
    }

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

window.addEventListener('pageshow', function (event) {
    if (
        event.persisted ||
        (typeof window.performance !== 'undefined' &&
            window.performance.navigation.type === 2)
    ) {
        window.location.reload();
    }
});
