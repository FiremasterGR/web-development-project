//Για να μην το βάζω σε κάθε σελίδα...
document.addEventListener("DOMContentLoaded", () => {
    var content = document.getElementById('content');
    content.insertAdjacentHTML('beforeend', `
        <div class="loading-screen" id="loadingScreen">
        <div class="loader"></div>
        </div>`
    );
window.onload=function(){
    var loadingScreen = document.getElementById('loadingScreen');
    //Μέχρι τα 500ms ο χρήστης δεν μπορεί να κάνει κλικ πουθενά (για να μην πατήσει κάτι καταλάθως)
    loadingScreen.style.opacity = '0';
    content.style.display = 'block';
    setTimeout(() => loadingScreen.style.display='none', 500);
}});