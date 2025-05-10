document.addEventListener('DOMContentLoaded', function() {
    console.log("Cart handler loaded");
    
    // Initialize cart from localStorage for guests
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    updateCartCounter();

    // Add event listeners to all "Add to Cart" buttons
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            console.log("Add to cart button clicked");
            event.preventDefault();
            
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            const productPrice = parseFloat(this.getAttribute('data-product-price'));
            const productImage = this.getAttribute('data-product-image');
            
            addToCart(productId, productName, productPrice, productImage);
        });
    });

    document.querySelectorAll('.buy-now-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            
            const productId = this.getAttribute('data-product-id');
            const addToCartBtn = document.querySelector(`.add-to-cart-btn[data-product-id="${productId}"]`);
            
            if (addToCartBtn) {
                const productName = addToCartBtn.getAttribute('data-product-name');
                const productPrice = parseFloat(addToCartBtn.getAttribute('data-product-price'));
                const productImage = addToCartBtn.getAttribute('data-product-image');
                
                addToCart(productId, productName, productPrice, productImage);
            }
            
            window.location.href = '/delivery';
        });
    });

    function addToCart(productId, productName, productPrice, productImage) {
        const isLoggedIn = document.body.getAttribute('data-logged-in') === 'true';
        
        if (isLoggedIn) {
            console.log("Adding to server cart for logged-in user");
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Server response:", data);
                if (data.success) {
                    updateCartCounter();
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
            });
        } else {
            console.log("Adding to localStorage cart for guest");
            
            const existingItemIndex = cart.findIndex(item => item.id == productId);
            
            if (existingItemIndex !== -1) {
                cart[existingItemIndex].quantity += 1;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage,
                    quantity: 1
                });
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCounter();
        }
    }

    function updateCartCounter() {
        const cartCounter = document.getElementById('cart-counter');
        const cartCounterMobile = document.getElementById('cart-counter-mobile');
        const counters = [cartCounter, cartCounterMobile].filter(Boolean);
        
        if (counters.length === 0) return;
        
        const isLoggedIn = document.body.getAttribute('data-logged-in') === 'true';
        
        if (isLoggedIn) {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    console.log("Cart count from server:", data.count);
                    counters.forEach(counter => {
                        counter.textContent = data.count;
                        counter.style.display = data.count > 0 ? 'block' : 'none';
                    });
                })
                .catch(error => {
                    console.error('Error getting cart count:', error);
                });
        } else {
            const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
            console.log("Cart count from localStorage:", totalItems);
            counters.forEach(counter => {
                counter.textContent = totalItems;
                counter.style.display = totalItems > 0 ? 'block' : 'none';
            });
        }
    }
    
    // Initialize cart counters on page load
    updateCartCounter();
});