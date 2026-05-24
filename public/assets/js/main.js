// ==========================================================================
// FoodGrids Master Controller - Clean & Production Ready
// ==========================================================================

document.addEventListener('DOMContentLoaded', () => {
    CartEngine.updateCartBadges();
    
    if (typeof AuthSystem !== 'undefined') {
        AuthSystem.init();
    }

    if (document.title.toLowerCase().includes('menu')) {
        UIEngine.setupCategoryTabs();
        UIEngine.renderMenuGrid('all');
    }
    
    if (document.getElementById('cart-items')) {
        CartEngine.renderCartPage();
    }
    
    if (document.getElementById('checkout-summary-container')) {
        CartEngine.renderCheckoutSummary();
    }

    const currentPath = window.location.pathname.split("/").pop() || "index.html";
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    
    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href');
        link.classList.remove('active-page');
        
        if (linkHref === currentPath) {
            link.classList.add('active-page');
        }
    });
    
    const contactForm = document.querySelector('form');
    if (document.title.toLowerCase().includes('contact') && contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('System Message: Your transmission parameters were recorded.');
            contactForm.reset();
        });
    }
});