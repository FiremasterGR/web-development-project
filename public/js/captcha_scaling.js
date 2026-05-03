/*Για να μην χρησιμοποιώ την έκδοση captcha για το κινητό ή του υπολογιστή αναλόγως, αυτό 
το script κάνει scale το captcha σε σχέση με το μέγεθος του container (που αλλάζεται όντως)*/
function scaleCaptcha() {
  const container = document.querySelector(".captcha-container");
  const box = document.querySelector(".captcha-wrapper");
  const nativeWidth = 304;
  const available = container.clientWidth;
  const scale = Math.min(1, available / nativeWidth);
  box.style.transform = `scale(${scale})`;
}
// Όταν το captcha είναι έτοιμο
function initCaptchaScaling() {
    grecaptcha.ready(() => {
        scaleCaptcha();
    }); 
}
// Όταν το το μονοπάτι της σελίδας είναι έτοιμο
document.addEventListener("DOMContentLoaded", () => {
    initCaptchaScaling();
    disableSubmit();
});
// Αλλάζει το μέγεθος όταν μεγαλώνει ή γυρνάει η οθόνη
window.addEventListener("resize", scaleCaptcha);
window.addEventListener("orientationchange", scaleCaptcha);
function disableSubmit(){
    if (typeof validationState !== "undefined") {
        validationState.captchavalidity = false;
        updsubmitbttn();
    }
    else{document.getElementById("submitBtn").disabled = true;}
}
function enableSubmit(){
    if (typeof validationState !== "undefined") {
        validationState.captchavalidity = true;
        updsubmitbttn();
    }
    else{document.getElementById("submitBtn").disabled = false;}
}