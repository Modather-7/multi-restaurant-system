// ==========================================================================
// Authentication Simulation Layer
// ==========================================================================

const AuthSystem = {
    init() {
        const loginForm = document.querySelector('form action onsubmit'); // الإمساك بالفورم
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const title = document.title.toLowerCase();
                if (title.includes('login')) {
                    e.preventDefault();
                    alert('🎉 Login successful! Welcome to Zingo Chicken.');
                    window.location.href = 'index.html';
                } else if (title.includes('register') || title.includes('create account')) {
                    e.preventDefault();
                    alert('🚀 Account created successfully! Please login.');
                    window.location.href = 'login.html';
                }
            });
        });
    }
};