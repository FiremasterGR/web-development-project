var request = indexedDB.open("LocalDatabase", 1);
var db;
request.onupgradeneeded = function(event) {
    db = event.target.result;
    if (!db.objectStoreNames.contains("values")) {
        db.createObjectStore("values", { keyPath: "id" });
    }
    if (!db.objectStoreNames.contains("images")) {
        db.createObjectStore("images", { keyPath: "id"});
    }
};
request.onerror = function() {
    console.error("Σφάλμα ", request.error,"\n Εάν μπορείτε, παρακαλώ αντιγράψτε το σφάλμα και στείλτε το στην φόρμα επικοινωνίας. Σας ευχαριστούμε και λυπούμαστε για οποιαδήποτε αναστάτωση...");
};
request.onsuccess = function(event) {
    db = event.target.result;
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);}
    else {
        start();
    }
};
function start(){
    window.savevalues = function(event) {
        //εάν είναι για αποστολή φόρμας την στέλνει στο τέλος
        if (event){
            console.log(event);
            event.preventDefault();
            var form = event.currentTarget;
        }
        var transaction1 = db.transaction("values", "readwrite");
        var store1 = transaction1.objectStore("values");
        document.querySelectorAll("input:not([type='radio'], [type='file'])").forEach(input => {
            if (!input.id) return;
            store1.put({ id: input.id, value: input.value ?? "" });
        });
        document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
            store1.put({ id: radio.name, value: radio.value ?? "" });
        });
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            if (!checkbox.id) return;
            store1.put({ id: checkbox.id, checked: checkbox.checked });
        });
        if (event){
            form.submit();
        }
    }
    //Εάν ξαναέρθει στην φόρμα ο χρήστης (πχ ε'αν κοπεί το ρεύμα) να μην τα ξαναγράφει όλα
    setInterval(savevalues, 10000);
    function loadvalues(){
        var transaction1 = db.transaction("values", "readwrite");
        var store1 = transaction1.objectStore("values");
        document.querySelectorAll("input:not([type='radio'], [type='file'])").forEach(input => {
            if (!input.id) return;
            var request=store1.get(input.id);
            request.onsuccess = function() {
                if (request.result) {
                    input.value = request.result.value ?? "";
                    input.dispatchEvent(new Event("input"));
                }
            };
            request.onerror = function(event) {
                console.error("Σφάλμα φόρτωσης τιμών:", event.target.error, "\n Εάν μπορείτε, παρακαλώ αντιγράψτε το σφάλμα και στείλτε το στην φόρμα επικοινωνίας. Σας ευχαριστούμε και λυπούμαστε για κάθε πρόβλημα");
                return;
            };
        });
        document.querySelectorAll("input[type='radio']").forEach(radio => {
            if (!radio.name) return;
            var request = store1.get(radio.name);
            request.onsuccess = function() {
                if (request.result) {
                    radio.checked = radio.value === request.result.value;
                    radio.dispatchEvent(new Event("change"));
                }
            };
            request.onerror = function(event) {
                console.error("Σφάλμα φόρτωσης τιμών:", event.target.error, "\n Εάν μπορείτε, παρακαλώ αντιγράψτε το σφάλμα και στείλτε το στην φόρμα επικοινωνίας. Σας ευχαριστούμε και λυπούμαστε για κάθε πρόβλημα");
                return;
            };
        });
        document.querySelectorAll("input[type='checkbox']").forEach(checkbox => {
            if (!checkbox.id) return;
            const request = store1.get(checkbox.id);
            request.onsuccess = () => {
                if (request.result && "checked" in request.result) {
                    checkbox.checked = request.result.checked;
                    checkbox.dispatchEvent(new Event("change"));
                }
            };
            request.onerror = event => {
                console.error("Error loading checkbox:", event.target.error);
            };
        });
        if (document.getElementById("previewcontainer")){
        var transaction2 = db.transaction("images", "readwrite");
        var store2 = transaction2.objectStore("images");
        var cursor = store2.openCursor();
        cursor.onsuccess = function (e) {
            var nextcursor = e.target.result;
            if (nextcursor) {
                var image = nextcursor.value.file;
                addimage(image, false);
                nextcursor.continue();
                request.onerror = function(event) {
                    console.error("Σφάλμα φόρτωσης εικόνων:", event.target.error, "\n Εάν μπορείτε, παρακαλώ αντιγράψτε το σφάλμα και στείλτε το στην φόρμα επικοινωνίας. Σας ευχαριστούμε και λυπούμαστε για κάθε πρόβλημα");
                return;
                };
            }
        }}
    }
    loadvalues();
}
function deletevalues(todelete){
    var transaction1 = db.transaction("values", "readwrite");
    var store1 = transaction1.objectStore("values");
    store1.delete(todelete);
}
function deleteradios(name){
    var transaction1 = db.transaction("values", "readwrite");
    var store1 = transaction1.objectStore("values");
    store1.delete(name);
}
function deleteimage(image){
    var transaction2 = db.transaction("images", "readwrite");
    var store2 = transaction2.objectStore("images");
    if (image=="all"){
        clearRequest = store2.clear();
    }
    else{
        var deletion = store2.delete(image);
        deletion.onerror = function(event) {
            console.error("Failed to remove input:", event.target.error);
        };
        deletion.onsuccess = function() {
            var counter = 1;
            var cursor = store2.openCursor();
            cursor.onsuccess = function(event) {
                target=image.match(/\d+/)[0];
                var nextcursor = event.target.result;
                if (nextcursor) {
                    if (counter>target){
                        var sameimage = nextcursor.value;
                        var newId = "preview" + (counter - 1);
                        if (sameimage.id !== newId) {
                            nextcursor.delete();
                            store2.put({ id: newId, file: sameimage.file });
                        }
                    }
                    counter=counter+1;
                    nextcursor.continue();
                }
            }
        }
    }
}
function saveimages(imageid, image, name){
    var transaction2 = db.transaction("images", "readwrite");
    var store2 = transaction2.objectStore("images");
    put=store2.put({ id: imageid, file: image, name: name });
}
function swapimages(imageid1, imageid2){
    var transaction2 = db.transaction("images", "readwrite");
    var store2 = transaction2.objectStore("images");
    var request1 = store2.get(imageid1);
    request1.onsuccess = function () {
        var image1 = request1.result;
        var request2=store2.get(imageid2);
        request2.onsuccess = function () {
            var image2 = request2.result;
            put2=store2.put({ id: imageid2, file: image1.file});
            put1=store2.put({ id: imageid1, file: image2.file});
        }
    }
}
function deletevaluesall(){
    var transaction1 = db.transaction("values", "readwrite");
    var store1 = transaction1.objectStore("values");
    clearRequest1 = store1.clear();
    var transaction2 = db.transaction("images", "readwrite");
    var store2 = transaction2.objectStore("images");
    clearRequest2 = store2.clear();
}
document.querySelector("form").addEventListener("submit", function(e) {
    savevalues(e);
});