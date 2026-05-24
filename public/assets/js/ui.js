// ==========================================================================
// FoodGrids UI Rendering - Premium Dynamic Layout Injection
// ==========================================================================

const UIEngine = {
    renderMenuGrid(categoryId = 'all') {
        const menuGrid = document.querySelector('.row.g-4');
        if (!menuGrid || !document.title.toLowerCase().includes('menu')) return;

        let filteredProducts = FoodGridsMenuData.products;
        if (categoryId !== 'all') {
            filteredProducts = FoodGridsMenuData.products.filter(p => p.category_id === categoryId);
        }

        let html = '';
        filteredProducts.forEach(product => {
            html += `
                <div class="col-md-6 col-lg-4">
                    <div class="product-card bg-white">
                        <img src="${product.image}" class="img-fluid product-image" alt="${product.name}">
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-dark text-capitalize">${product.category_id}</span>
                                <span class="text-success small fw-semibold">● Verified Available</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">${product.name}</h5>
                            <p class="text-muted small mb-4" style="min-height: 40px;">${product.description}</p>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <span class="fw-bold fs-4 text-dark">${product.price} <small class="fs-6 text-muted fw-normal">EGP</small></span>
                                <button onclick="CartEngine.addToCart(${product.id}, 1)" class="btn btn-dark btn-sm px-3 rounded-2">Add To Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        menuGrid.innerHTML = html || `<div class="col-12 text-center py-5 text-muted">No operational items found inside this parameters category registry.</div>`;
    },

    setupCategoryTabs() {
        const tabsContainer = document.querySelector('.nav-pills');
        if (!tabsContainer) return;

        let html = '';
        FoodGridsMenuData.categories.forEach((cat, index) => {
            html += `
                <li class="nav-item">
                    <a href="#" class="nav-link ${index === 0 ? 'active' : ''} rounded-pill px-4" data-category="${cat.id}">
                        ${cat.name}
                    </a>
                </li>
            `;
        });
        tabsContainer.innerHTML = html;

        tabsContainer.querySelectorAll('.nav-link').forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                tabsContainer.querySelectorAll('.nav-link').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                const catId = tab.getAttribute('data-category');
                this.renderMenuGrid(catId);
            });
        });
    }
};