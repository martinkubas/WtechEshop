document.getElementById("see-more").addEventListener("click", function(event) {
    let moreGenres = document.getElementById("more-genres");
    
    if (moreGenres.style.display === "none") {
        moreGenres.style.display = "block";
        this.textContent = "See less..."; 
    } else {
        moreGenres.style.display = "none";
        this.textContent = "See more...";
    }
});