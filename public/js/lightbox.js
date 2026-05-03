/*αυτό είναι για όταν ο χρήστης κάνει κλικ σε μια εικόνα που σκοτεινιάζει το background και
στη μέση της οθόνης φαίνεται μια μεγαλύτερη έκδοση της εικόνας (αυτό είναι το lightbox) 
Το χρησιμοποιώ και για ειδοποίηση εκκαθάρισης δεδομένων γιατί είναι βολικό*/
document.addEventListener("DOMContentLoaded", () => {
    var lightbox=document.getElementById("lightbox");
    var lightboxImg=document.getElementById("lightbox-img");
    var lightboxAlert=document.getElementById("lightbox-alert");
    //για να φύγει από το "lightbox" ο χρήστης, κάνει κλίκ οπουδήποτε
    lightbox.addEventListener("click", () => {
        lightbox.style.display = "none";
        if (lightboxImg){
            lightboxImg.style.display = "none";
            lightboxImg.src = "";
            lightboxImg.addEventListener("click", function(event) {
                event.stopPropagation();
            });
        }
        lightboxAlert.style.display = "none";
        document.body.style.overflow = "";
    });
    
    lightboxAlert.addEventListener("click", function(event) {
        event.stopPropagation();
    });
});