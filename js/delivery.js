function validateForm() {
    // Get all the necessary form elements
    const nameInput = document.querySelector('input[type="text"]');
    const emailInput = document.querySelector('input[type="email"]');
    const phoneInput = document.querySelector('input[type="tel"]');
    const deliveryOptions = document.querySelectorAll('input[name="delivery"]');
    const paymentOptions = document.querySelectorAll('input[name="payment"]');

    // Check if all required fields are filled
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

    // Check if a delivery method is selected
    let isDeliverySelected = false;
    deliveryOptions.forEach(option => {
        if (option.checked) isDeliverySelected = true;
    });

    if (!isDeliverySelected) {
        alert('Please select a delivery method');
        return false;
    }

    // Check if a payment method is selected
    let isPaymentSelected = false;
    paymentOptions.forEach(option => {
        if (option.checked) isPaymentSelected = true;
    });

    if (!isPaymentSelected) {
        alert('Please select a payment method');
        return false;
    }

    // If all fields are valid, redirect to the payment page
    window.location.href = 'payment.html';
    return true;
}