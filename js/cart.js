// Recalculates the total price when the page loads.
document.addEventListener("DOMContentLoaded", function () {
    updateCartTotal(); 
});  

// Ensures only numeric input in quantity fields and updates the total price.
document.querySelectorAll(".quantity-control input").forEach(input => {
    input.addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, '');
        let value = parseInt(this.value);
        
        if (isNaN(value) || value < 1) {this.value = 1;}
        updateCartTotal();
    });

    // Blocks invalid characters during input.
    input.addEventListener("keydown", function (event) {
        if (
            event.key.length === 1 &&
            !/[0-9]/.test(event.key) &&
            event.key !== "Backspace" &&
            event.key !== "ArrowLeft" &&
            event.key !== "ArrowRight" &&
            event.key !== "Delete"
        ) {event.preventDefault();}
    });
});

// Changes the quantity of an item and updates the total price.
function changeQuantity(button, change) {
    let quantityInput = button.parentElement.querySelector("input");
    let newQuantity = parseInt(quantityInput.value) + change;

    if (newQuantity < 1) return;

    quantityInput.value = newQuantity;

    updateCartTotal();
}

// Removes an item from the cart and updates the total price.
function removeItem(button) {
    button.closest(".cart-item").remove();
    updateCartTotal();
}

// Calculates and updates the total price of all items in the cart.
function updateCartTotal() {
    let total = 0;
    let items = document.querySelectorAll(".cart-item");

    items.forEach(item => {
        let price = parseFloat(item.getAttribute("data-price"));
        let quantity = parseInt(item.querySelector("input").value);
        total += price * quantity;
    });

    document.getElementById("cart-current-price").textContent = total.toFixed(2);
}
