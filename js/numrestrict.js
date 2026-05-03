document.addEventListener("DOMContentLoaded", () => {
    //μόνο θετικοί αριθμοί
    const allowedRegex1 = /^[0-9]*$/;
    document.querySelectorAll('.numinput1').forEach(input => {
        //για να μπορέσω να αφεραίσω το EventListener
        input._handler1 = () => onlypositives(input);
        input.addEventListener('input', input._handler1);
    });
    function onlypositives(input){
        if (!allowedRegex1.test(input.value)) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }
    }
    //θετικοί και αρνητικοί
    const allowedRegex2 = /^-?\d+$/;
    document.querySelectorAll('.numinput2').forEach(input => {
        input._handler2 = () => onlynums(input);
        input.addEventListener('input', input._handler2);
    });
    function onlynums(input){
        if (!allowedRegex2.test(input.value)) {
            input.value = input.value.replace(/[^\d-]/g, '');
            input.value = input.value.replace(/(?!^)-/g, '');
        }
    }
    //μοντίβο τύπου ((αριθμός θετικό/αρνητικός), - ,(αριθμός θετικός)) πχ -3-1, 1-2
    document.querySelectorAll(".numinput3").forEach(input => {
        input._handler3 = () => numpattern(input);
        input.addEventListener('input', input._handler3);
    });
    function numpattern(input) {
        var value = input.value.replace(/[^0-9\-\–]/g, '');
        var leadingDash = '';
        if (value.startsWith('-')){
            leadingDash = '-';
            value = value.slice(1);
        }
        value = value.replace(/^-+/, '');
        const parts = value.split(/[-–]/);
        if (parts.length > 1){
            value = leadingDash + parts[0] + '–' + parts.slice(1).join('');
        }
        else{
            value = leadingDash + parts[0];
        }
        input.value = value;
    }
    //γράμματα και νούμερα
    const allowedRegex3 = /^[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]*$/;
    document.querySelectorAll('.numsandletters').forEach(input => {
        input._handler4 = () => numsandletters(input);
        input.addEventListener('input', input._handler4);
    });
    function numsandletters(input){
        if (!allowedRegex3.test(input.value)) {
            input.value = input.value.replace(/[^A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g, '');
        }
    }
});