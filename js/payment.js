document.addEventListener("DOMContentLoaded", function () {
    const deliveryInput = document.getElementById("delivery-address");
    const pickupSelect = document.getElementById("pickup-location");
    const paymentDetails = document.getElementById("payment-details");
    const agreement = document.getElementById("agreement");
    const completeOrderBtn = document.getElementById("complete-order");

    const selectedDeliveryMethod = "Courier"; 
    const selectedPaymentMethod = "CreditCard"; 

    if (selectedDeliveryMethod === "Pickup") {
        deliveryInput.classList.add("hidden");
        pickupSelect.classList.remove("hidden");
    }

    if (selectedPaymentMethod === "CreditCard") {
        paymentDetails.classList.remove("hidden");
    }

    agreement.addEventListener("change", function () {
        completeOrderBtn.disabled = !this.checked;
    });
});