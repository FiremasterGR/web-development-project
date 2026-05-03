function inputCheck(e){
    //ελέγχει εάν τα υποχρεωτικά πεδία είναι συμπληρωμένα ΠΡΙΝ στείλει την φόρμα
    e.preventDefault();
    //μετακινεί την κάμερα μόνο στο πρώτο ασυμπλήρωτο πεδίο που βρίσκει (το χρησιμοποιώ και για να δώ εάν θα σταλθεί η φόρμα)
    var firstfound=false;
    
    document.querySelectorAll("input:not(.optional), textarea:not(.optional)").forEach(input => {
        if (!input.value){
            if (!firstfound){
                firstfound=true;
                input.scrollIntoView({ behavior: "smooth", block: "center" });
            }
            //εάν ο χρήστης είχε focus σε ένα κενό πεδίο (μπορούσε να γράψει), το σταματάει
            input.blur();
            input.classList.add("emptyinput");
            input.addEventListener("click",() => {
                input.classList.remove("emptyinput");}
                //εκτελεί μόνο μια φορά
                ,{once: true });
        }
    });
    if (!firstfound){
        //στέλνει τη φόρμα εάν όλα τα πεδία είναι συμπληρωμένα
        var form = e.currentTarget.form;
        form.requestSubmit();
    }
}
document.querySelectorAll(".englishonly").forEach(englishonly=>{
    englishonly.addEventListener("input", ()=>{
        englishonly.value = englishonly.value.replace(/[^a-zA-Z0-9]/g, '');
    }); 
});
document.querySelectorAll(".emailsonly").forEach(englishonly=>{
    englishonly.addEventListener("input", ()=>{
        englishonly.value = englishonly.value.replace(/[^a-zA-Z0-9@.]/g, '');
    }); 
});
document.querySelectorAll(".numsonly").forEach(numsonly=>{
    numsonly.addEventListener("input", ()=>{
        numsonly.value = numsonly.value.replace(/[^0-9]/g, '');
    }); 
});

document.getElementById("submitBtn").addEventListener("click", function(e) {
    inputCheck(e);
});