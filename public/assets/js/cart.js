// ==========================================================================
// FoodGrids Cart Engine - Isolated Multi-Tenant Operations
// ==========================================================================

const CartEngine = {
    storageKey: 'foodgrids_isolated_tenant_cart',

    getCart() {
        const cart = localStorage.getItem(this.storageKey);
        return cart ? JSON.parse(cart) : [];
    },

    saveCart(cart) {
        localStorage.setItem(this.storageKey, JSON.stringify(cart));
        this.updateCartBadges();
    },

    addToCart(productId, quantity = 1, note = '') {
        const product = FoodGridsMenuData.products.find(p => p.id === parseInt(productId));
        if (!product) return;

        let cart = this.getCart();
        const existingItemIndex = cart.findIndex(item => item.product_id === product.id);

        if (existingItemIndex > -1) {
            cart[existingItemIndex].quantity += parseInt(quantity);
            // تحديث الملاحظة لو العميل كتب حاجة جديدة
            if(note) cart[existingItemIndex].note = note;
        } else {
            cart.push({
                product_id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: parseInt(quantity),
                note: note
            });
        }
        this.saveCart(cart);
        alert(`System Confirmation: ${product.name} successfully added to your cart.`);
    },

    alterQty(productId, delta) {
        let cart = this.getCart();
        const idx = cart.findIndex(item => item.product_id === parseInt(productId));
        if (idx > -1) {
            cart[idx].quantity += parseInt(delta);
            if (cart[idx].quantity <= 0) {
                cart.splice(idx, 1);
            }
            this.saveCart(cart);
            this.renderCartPage();
            this.renderCheckoutSummary();
        }
    },

    removeItem(productId) {
        let cart = this.getCart();
        cart = cart.filter(item => item.product_id !== parseInt(productId));
        this.saveCart(cart);
        this.renderCartPage();
        this.renderCheckoutSummary();
    },

    getCartTotals() {
        const cart = this.getCart();
        const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
        const deliveryFee = subtotal > 0 ? 30 : 0;
        return { subtotal, deliveryFee, total: subtotal + deliveryFee };
    },

    updateCartBadges() {
        const cart = this.getCart();
        const totalItems = cart.reduce((total, item) => total + item.quantity, 0);

        // بنستهدف فقط الزرار اللي جوة ال Navbar
        const navbarCartBtn = document.querySelector('.navbar-nav .btn-gold');

        if (navbarCartBtn) {
            navbarCartBtn.innerHTML = `Cart <span class="badge bg-danger ms-2 rounded-pill">${totalItems}</span>`;
        }
    },

    renderCartPage() {
        const cartTableBody = document.getElementById('cart-items');
        if (!cartTableBody) return;

        const cart = this.getCart();
        if (cart.length === 0) {
            cartTableBody.innerHTML = `<tr><td colspan="4" class="text-center py-5 text-muted">Cart inventory records are zero.<br><a href="product-grids.html" class="btn btn-gold btn-sm mt-3">Return To Menu</a></td></tr>`;
            this.drawSummarySidebar(0, 0, 0);
            return;
        }

        let html = '';
        cart.forEach(item => {
            html += `
                <tr>
                    <td class="px-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="${item.image}" class="rounded-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <h6 class="mb-0 fw-bold text-dark">${item.name}</h6>
                        </div>
                    </td>
                    <td class="fw-semibold text-dark">${item.price} EGP</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-start gap-2">
                            <button class="btn btn-sm btn-outline-dark px-2 py-0 fw-bold" onclick="CartEngine.alterQty(${item.product_id}, -1)">-</button>
                            <span class="fw-bold px-1">${item.quantity}</span>
                            <button class="btn btn-sm btn-outline-dark px-2 py-0 fw-bold" onclick="CartEngine.alterQty(${item.product_id}, 1)">+</button>
                        </div>
                    </td>
                    <td class="text-end px-4">
                        <button class="btn btn-sm btn-link text-danger text-decoration-none fw-semibold" onclick="CartEngine.removeItem(${item.product_id})">Remove</button>
                    </td>
                </tr>
            `;
        });
        cartTableBody.innerHTML = html;
        const totals = this.getCartTotals();
        this.drawSummarySidebar(totals.subtotal, totals.deliveryFee, totals.total);
    },

    drawSummarySidebar(subtotal, delivery, total) {
        const container = document.getElementById('cart-summary-container');
        if (!container) return;
        container.innerHTML = `
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white sticky-summary">
                <h4 class="fw-bold text-dark mb-4">Cart Summary</h4>
                <div class="d-flex justify-content-between mb-2 fs-6">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-bold text-dark">${subtotal} EGP</span>
                </div>
                <div class="d-flex justify-content-between mb-3 fs-6">
                    <span class="text-muted">Delivery Logs</span>
                    <span class="fw-bold text-success">${delivery} EGP</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4 fs-5">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold text-gold">${total} EGP</span>
                </div>
                <a href="checkout.html" class="btn btn-dark btn-lg w-100 rounded-3 py-3 fw-semibold shadow-sm ${total === 0 ? 'disabled' : ''}">Proceed To Checkout</a>
            </div>
        `;
    },

    renderCheckoutSummary() {
        const container = document.getElementById('checkout-summary-container');
        if (!container) return;
        const cart = this.getCart();
        const totals = this.getCartTotals();

        let itemsHtml = '';
        cart.forEach(item => {
            itemsHtml += `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">${item.name}</h6>
                        <small class="text-muted">Quantity: ${item.quantity}</small>
                    </div>
                    <span class="fw-semibold text-dark">${item.price * item.quantity} EGP</span>
                </div>
            `;
        });

        container.innerHTML = `
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white sticky-summary">
                <h4 class="fw-bold mb-4 text-dark border-bottom pb-2">Order Inventory</h4>
                ${itemsHtml || '<p class="text-muted text-center py-3">No inventory items logs found.</p>'}
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-semibold text-dark">${totals.subtotal} EGP</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Delivery Logs</span>
                    <span class="fw-semibold text-success">${totals.deliveryFee} EGP</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-5 text-gold">${totals.total} EGP</span>
                </div>
            </div>
        `;
    }
};

window.addToCart = function(id, qty = 1, note = null) {
    CartEngine.addToCart(id, qty, note);
};
