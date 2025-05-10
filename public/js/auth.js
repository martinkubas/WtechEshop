document.addEventListener('DOMContentLoaded', function() {
    console.log("Auth.js loaded");
    
    const logoutLinks = document.querySelectorAll('a[href*="logout"]');
    logoutLinks.forEach(link => {
        link.addEventListener('click', function() {
            console.log("Logging out, clearing localStorage cart");
            localStorage.removeItem('cart');
        });
    });
});