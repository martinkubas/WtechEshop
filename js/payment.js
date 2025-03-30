document.addEventListener("DOMContentLoaded", function () {
    const deliveryInput = document.getElementById("delivery-address");
    const pickupSelect = document.getElementById("pickup-location");
    const paymentDetails = document.getElementById("payment-details");
    const agreement = document.getElementById("agreement");
    const completeOrderBtn = document.getElementById("complete-order");

    // Example: Simulating selection from the previous page
    const selectedDeliveryMethod = "Courier"; // Change this dynamically
    const selectedPaymentMethod = "CreditCard"; // Change this dynamically

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