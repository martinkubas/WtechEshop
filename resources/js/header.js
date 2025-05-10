function handleSearch(event, inputId) {
    event.preventDefault();
    const input = document.getElementById(inputId);
    const query = input.value.trim();
    if (query) {
        window.location.href = `/search?query=${encodeURIComponent(query)}`;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const formDesktop = document.getElementById("searchFormDesktop");
    const formMobile = document.getElementById("searchFormMobile");

    if (formDesktop) {
        formDesktop.addEventListener("submit", function (e) {
            handleSearch(e, "searchInputDesktop");
        });
    }

    if (formMobile) {
        formMobile.addEventListener("submit", function (e) {
            handleSearch(e, "searchInputMobile");
        });
    }
});
