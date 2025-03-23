function goBack() {
    let lastValidPage = localStorage.getItem("lastValidPage");

    if (lastValidPage) {
        window.location.href = lastValidPage; 
    } else {
        window.location.href = "../html/index.html"; 
    }
}