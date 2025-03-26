document.addEventListener("DOMContentLoaded", function () {
    const gameDetailBtn = document.getElementById("gameDetail");
    const gameDialog = document.getElementById("gameDialog");
    const overlay = document.getElementById("overlay");
    const closeDialog = document.getElementById("closeDialog");

    if (gameDetailBtn && gameDialog && overlay && closeDialog) {
        gameDetailBtn.addEventListener("click", function () {
            gameDialog.classList.add("show");
            overlay.classList.add("show");
        });

        closeDialog.addEventListener("click", function () {
            gameDialog.classList.remove("show");
            overlay.classList.remove("show");
        });

        overlay.addEventListener("click", function () {
            gameDialog.classList.remove("show");
            overlay.classList.remove("show");
        });
    } else {
        console.warn("error!");
    }
});