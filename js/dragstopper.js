//Για να μην μπορεί ο χρήστης να κάνει drag τις εικόνες που δεν επιτρέπονται
document.addEventListener("DOMContentLoaded", () => {
    document.addEventListener("dragstart", function(e) {
        if (!e.target.classList.contains("draggable")) {
            e.preventDefault();
        }
    });
});