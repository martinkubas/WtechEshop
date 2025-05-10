document.addEventListener('DOMContentLoaded', function() {
    const isLoggedIn = document.body.getAttribute('data-logged-in') === 'true';
    
    if (!isLoggedIn) {
        const cartDataField = document.getElementById('cart_data');
        const cartData = localStorage.getItem('cart') || '[]';
        console.log('Setting cart_data to:', cartData);
        if (cartDataField) {
            cartDataField.value = cartData;
        }

        const orderItemsContainer = document.getElementById('order-items-container');
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        let total = 0;
        
        
        cart.forEach(item => {
            const subtotal = item.price * item.quantity;
            total += subtotal;
            
            const orderItemEl = document.createElement('div');
            orderItemEl.className = 'order-item';
            orderItemEl.innerHTML = `
                <div class="order-item-image">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="order-item-details">
                    <h4>${item.name}</h4>
                    <div class="order-item-meta">
                        <span class="quantity">Qty: ${item.quantity}</span>
                        <span class="price">$${item.price.toFixed(2)}</span>
                    </div>
                    <div class="subtotal">
                        $${subtotal.toFixed(2)}
                    </div>
                </div>
            `;
            
            orderItemsContainer.appendChild(orderItemEl);
        });
        
        document.getElementById('order-subtotal').textContent = total.toFixed(2);
        document.getElementById('order-total').textContent = total.toFixed(2);
    }
    
    const deliveryOptions = document.querySelectorAll('input[name="delivery_method"]');
    const deliveryAddressContainer = document.getElementById('delivery-address-container');
    const deliveryAddressInput = document.getElementById('delivery_address');
    //if delivery is pickup, remove address
    deliveryOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.value === 'pickup') {

                deliveryAddressContainer.classList.add('d-none');
                if (deliveryAddressInput) {
                    deliveryAddressInput.removeAttribute('required');
                }
            } else {

                deliveryAddressContainer.classList.remove('d-none');
                if (deliveryAddressInput) {
                    deliveryAddressInput.setAttribute('required', '');
                }
            }
            
            const shippingCost = parseFloat(this.dataset.price) || 0;
            document.getElementById('order-shipping').textContent = shippingCost.toFixed(2);
            
            const subtotal = parseFloat(document.getElementById('order-subtotal').textContent);
            const total = subtotal + shippingCost;
            document.getElementById('order-total').textContent = total.toFixed(2);
        });
    });
    
    // card details based on payment method
    const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
    const cardDetailsContainer = document.getElementById('card-details-container');
    const cardInputs = cardDetailsContainer ? cardDetailsContainer.querySelectorAll('input') : [];
    
    paymentOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.value === 'card') {
                cardDetailsContainer.classList.remove('d-none');
                cardInputs.forEach(input => input.setAttribute('required', ''));
            } else {
                cardDetailsContainer.classList.add('d-none');
                cardInputs.forEach(input => input.removeAttribute('required'));
            }
        });
    });
    
    const checkoutForm = document.getElementById('checkout-form');
    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked');
        if (!deliveryMethod) {
            alert('Please select a delivery method');
            return;
        }
        
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethod) {
            alert('Please select a payment method');
            return;
        }
        
        if (paymentMethod.value === 'card') {
            const cardNumber = document.getElementById('card_number').value;
            const cardExpiry = document.getElementById('card_expiry').value;
            const cardCvv = document.getElementById('card_cvv').value;
            
            if (!cardNumber || !cardExpiry || !cardCvv) {
                alert('Please fill in all card details');
                return;
            }
        }
        
        if (!isLoggedIn) {
            const cartDataField = document.getElementById('cart_data');
            if (cartDataField) {
                cartDataField.value = localStorage.getItem('cart') || '[]';
            }
            
            localStorage.removeItem('cart');
            sessionStorage.removeItem('clearCart');
        }
        this.submit();
    });
});