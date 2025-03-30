function validateForm() {
    const nameInput = document.querySelector('input[type="text"]');
    const emailInput = document.querySelector('input[type="email"]');
    const phoneInput = document.querySelector('input[type="tel"]');
    const deliveryOptions = document.querySelectorAll('input[name="delivery"]');
    const paymentOptions = document.querySelectorAll('input[name="payment"]');

    if (!nameInput.value.trim()) {
        alert('Please enter your name');
        return false;
    }

    if (!emailInput.value.trim()) {
        alert('Please enter your email');
        return false;
    }

    if (!phoneInput.value.trim()) {
        alert('Please enter your phone number');
        return false;
    }

    let isDeliverySelected = false;
    deliveryOptions.forEach(option => {
        if (option.checked) isDeliverySelected = true;
    });

    if (!isDeliverySelected) {
        alert('Please select a delivery method');
        return false;
    }

    let isPaymentSelected = false;
    paymentOptions.forEach(option => {
        if (option.checked) isPaymentSelected = true;
    });

    if (!isPaymentSelected) {
        alert('Please select a payment method');
        return false;
    }

    window.location.href = 'payment.html';
    return true;
}