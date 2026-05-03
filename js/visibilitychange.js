//Αλλάζει την ορατότητα από και προς password 
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".passimage").forEach(passimage=> {
      passimage.addEventListener("click", function() {
        visibilitychange(this.id);
      })
    });
});
function visibilitychange(sender){
    var target = document.getElementById("password"+sender.match(/\d+/)[0]);
    if (target.type=="password"){
        target.type="text";
    }
    else{
        target.type="password";
    }
    if (document.getElementById(sender).getAttribute('src') === 'pictures/password_invisible.png'){
        document.getElementById(sender).src="pictures/password_visible.png";
    }
    else{
        document.getElementById(sender).src="pictures/password_invisible.png";
    }
}