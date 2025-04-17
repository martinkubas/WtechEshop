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

document.getElementById("searchFormDesktop")?.addEventListener("submit", handleSearch);
document.getElementById("searchFormMobile")?.addEventListener("submit", handleSearch);

const categoryText = document.querySelector(".category-text");
const customDropdown = document.querySelector(".custom-dropdown");

if (categoryText && customDropdown) {
    categoryText.addEventListener("mouseover", function () {
        customDropdown.style.display = "block";
    });

    customDropdown.addEventListener("mouseleave", function () {
        customDropdown.style.display = "none";
    });
}

function savePage(){
    let currentPage = window.location.href;
    if (!currentPage.includes("login.html") && !currentPage.includes("signup.html")) {
        localStorage.setItem("lastValidPage", currentPage);
    }
}


document.addEventListener("DOMContentLoaded", savePage);