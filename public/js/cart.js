document.addEventListener('DOMContentLoaded', function() {
    console.log("Cart.js loaded");
    
    const cartItemsContainer = document.getElementById('cart-items-container');
    const cartTotal = document.getElementById('cart-total');
    const proceedButton = document.getElementById('proceed-to-payment');
    
    let cartItems = [];
    const isLoggedIn = document.body.dataset.loggedIn === 'true';
    
    initCart();
    
    function initCart() {
        console.log("User logged in:", isLoggedIn);
        
        if (isLoggedIn) {
            updateCartTotal();
            setupEventListeners();
        } else {
            loadCartFromLocalStorage();
            
            if (cartItems.length === 0) {
                renderEmptyCart();
            } else {
                renderGuestCart();
            }
        }
    }
    
    function loadCartFromLocalStorage() {
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            cartItems = JSON.parse(savedCart);
            console.log("Loaded cart items:", cartItems.length);
        }
    }
    
    function saveCartToLocalStorage() {
        localStorage.setItem('cart', JSON.stringify(cartItems));
    }
    
    function renderEmptyCart() {
        const cartContainer = document.querySelector('.cart-container');
        if (!cartContainer) return;
        
        const cartWrapper = cartContainer.parentElement;
        if (!cartWrapper) return;
        
        cartWrapper.innerHTML = `
            <div class="empty-cart-container">
                <div class="empty-cart">
                    <i class="bi bi-cart-x empty-cart-icon"></i>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added any games to your cart yet.</p>
                </div>
                <div class="cart-footer">
                    <button onclick="window.location.href='${window.location.origin}'" class="btn">Back to Shopping</button>
                    <span>Total: $0.00</span>
                    <button class="btn disabled-btn" disabled>Proceed to Payment</button>
                </div>
            </div>
        `;
    }
    
    function renderGuestCart() {
        if (!cartItemsContainer) return;
        
        cartItemsContainer.innerHTML = '';
 
        cartItems.forEach(item => {
            const cartItemElement = document.createElement('div');
            cartItemElement.className = 'cart-item';
            cartItemElement.dataset.id = item.id;
            cartItemElement.dataset.price = item.price;
            
            cartItemElement.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="item-image">
                <div class="item-name">${item.name}</div>
                <div class="quantity-control">
                    <button class="quantity-btn minus">-</button>
                    <input type="text" value="${item.quantity}" class="quantity-input" min="1">
                    <button class="quantity-btn plus">+</button>
                </div>
                <span class="item-price">$${parseFloat(item.price).toFixed(2)}</span>
                <button class="remove-item">&times;</button>
            `;
            
            cartItemsContainer.appendChild(cartItemElement);
        });
        
        updateCartTotal();
        setupEventListeners();
    }
    
    function updateCartTotal() {
        if (!cartTotal) return;
        
        let total = 0;
        
        if (isLoggedIn) {
            document.querySelectorAll('.cart-item').forEach(item => {
                const price = parseFloat(item.dataset.price);
                const quantity = parseInt(item.querySelector('.quantity-input').value);
                total += price * quantity;
            });
        } else {
            cartItems.forEach(item => {
                total += item.price * item.quantity;
            });
        }
        
        cartTotal.textContent = total.toFixed(2);
    }
    
    function setupEventListeners() {
        document.addEventListener('click', handleCartClicks);
        document.addEventListener('change', handleCartChanges);
    }
    
    function handleCartClicks(e) {
        if (e.target.classList.contains('minus')) {
            const input = e.target.nextElementSibling;
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
                updateItemQuantity(e.target.closest('.cart-item'));
            }
        }
        
        if (e.target.classList.contains('plus')) {
            const input = e.target.previousElementSibling;
            input.value = parseInt(input.value) + 1;
            updateItemQuantity(e.target.closest('.cart-item'));
        }
        
        if (e.target.classList.contains('remove-item')) {
            removeItem(e.target.closest('.cart-item'));
        }
    }
    
    function handleCartChanges(e) {
        if (e.target.classList.contains('quantity-input')) {
            let value = parseInt(e.target.value);
            if (isNaN(value) || value < 1) {
                e.target.value = 1;
            }
            updateItemQuantity(e.target.closest('.cart-item'));
        }
    }
    
    function updateItemQuantity(cartItem) {
        const productId = cartItem.dataset.id;
        const quantity = parseInt(cartItem.querySelector('.quantity-input').value);
        
        if (isLoggedIn) {
            updateServerCart(productId, quantity);
        } else {
            const itemIndex = cartItems.findIndex(item => item.id == productId);
            if (itemIndex !== -1) {
                cartItems[itemIndex].quantity = quantity;
                saveCartToLocalStorage();
            }
        }
        
        updateCartTotal();
    }
    
    function updateServerCart(productId, quantity) {
        fetch('/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .catch(error => {
            console.error("Error updating cart:", error);
        });
    }
    
    function removeItem(cartItem) {
        const productId = cartItem.dataset.id;
        
        if (isLoggedIn) {
            fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId
                })
            });
        } else {
            cartItems = cartItems.filter(item => item.id != productId);
            saveCartToLocalStorage();
        }
        
        cartItem.remove();
        updateCartTotal();
        
        if (document.querySelectorAll('.cart-item').length === 0) {
            renderEmptyCart();
        }
    }
});