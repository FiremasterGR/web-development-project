<?php 
$currentPage="propertyinsert";
include ('nonce.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Πώληση Ακινήτων</title>
  <meta charset="UTF-8">
  <script src="js/InputClear.js" async defer></script>
  <script src="js/inputCheck.js" async defer></script>
  <script src="js/lightbox.js" async defer></script>
  <script src="js/LocalDatabase.js" async defer></script>
  <script src="js/numrestrict.js" async defer></script>
  <link rel="stylesheet" href="css/style2.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body onload="LoadSessionData()">
  <div class="content" id="content">
  <div id="lightbox">
    <img src="" alt="Large view" id="lightbox-img">
    <div id="lightbox-alert">
      <p id="alertmessage">Είστε σίγουροι ότι θέλετε να κάνετε εκκαθάριση όλων των πεδίων;</p>
      <div style="display:flex;">
        <div class="flexbox" style="flex: 50%;"><button class="downbttn" onclick="ClearAll();">Ναι</button></div>
        <div class="flexbox" style="flex: 50%;"><button class="downbttn" onclick="lightbox.style.display='none';">Όχι</button></div>
      </div>
    </div>
  </div>
    <?php include('header.php'); ?>
  <div class="formdiv" style="width:50rem;">
    <form onsubmit="" action="house_selling3.html" method="post">
      <br>
      <h3>Κόστος Ακινήτου:</h3>
      <div style="display:flex;">
        <div style="flex: 50%;">
          <label>Πώληση ή Ενοικίαση:
            <span class="asterisk" id="trigger2">
              <img src="pictures/asterisk.png" alt="αστερίσκος" style="width:100%; height:100%;">
              <p class="speechbubble" id="bubbletrigger2">Εάν το ακίνητο είναι για πώληση ή ενοικίαση. Εάν θέλετε να είναι και τα 2, τότε πρέπει να συμπληρώσετε την φόρμα 1 φορά με το ακίνητο για ενοικίαση και 1 για πώληση</p>
            </span>
            </label>
        </div>
        <div style="flex: 50%;">
          <label>Δικαίωμα Διαπραγμάτευσης:
            <span class="asterisk" id="trigger1">
              <img src="pictures/asterisk.png" alt="αστερίσκος">
              <p class="speechbubble" id="bubbletrigger1">Εάν ο πιθανός πελάτης έχει δικαίωμα να διαπραγματευτεί μια καλύτερη τιμή. Εάν επιλέξετε όχι, ουσιαστικά η τιμή που δώσατε είναι η τελική σας τιμή. Εάν επιλέξετε όχι, ΠΡΕΠΕΙ να βάλετε κόστος κάτω</p>
            </span>
          </label>
        </div>
      </div>
      <div style="display:flex;">
        <div style="flex: 50%;"><label class="RadioContainer" style="margin-right:1rem;">Πώληση<input type="radio" name="group1" id="Πώληση" class="radiobox" checked="checked" value="Πώληση"><span class="RadioCheckmark"></span></label></div>
        <div style="flex: 50%;"><label class="RadioContainer">Ναι<input type="radio" name="group2" id="Ναι" class="radiobox" checked="checked" value="Ναι"><span class="RadioCheckmark"></span></label></div>
      </div>
      <div style="display:flex;">
        <div style="flex: 50%;"><label class="RadioContainer">Ενοικίαση<input type="radio" name="group1" id="Ενοικίαση" class="radiobox" checked="checked" value="Ενοικίαση"><span class="RadioCheckmark"></span></label></div>
        <div style="flex: 50%;"><label class="RadioContainer">Όχι<input type="radio" name="group2" id="Όχι" class="radiobox" checked="checked" value="Όχι"><span class="RadioCheckmark"></span></label></div>
      </div>
      <br><br>
      <div style="display:flex;">
        <div style="flex: 50%;"><label id="costlabel">Κόστος:</label></div>
      </div>
      <div style="display:flex;">
        <div style="flex: 50%;"><input class="numinput1" type="text" id="cost" name="cost" spellcheck="false" placeholder="Σε ευρώ"></div>
      </div>
      <div style="flex:50%;"><p style="display:none;" id="costperm2"></p></div>
      <h3>Εικόνες:
        <span class="asterisk" id="trigger3">
          <img src="pictures/asterisk.png" alt="αστερίσκος">
          <p class="speechbubble" id="bubbletrigger3" style="width:18rem;">Σε αυτό το πεδίο βάζετε εικόνες για το σπίτι. Οι εικόνες δεν πρέπει να είναι πάνω από 5MB. Σημαντική είναι η πρώτη εικόνα καθώς αυτή θα φαίνεται στη σελίδα αναζήτησης. Μπορείτε να σύρετε εικόνες που βάλατε σε άλλες εικόνες για να ανταλλάξουν θέσεις.</p>
        </span>
      </h3>
      <div class="grid-table" id="previewcontainer">
        <label for="imageUpload" id="dropArea">
          <input type="file" id="imageUpload" name="imageUpload" accept="image/*" hidden="">
          <p style="margin:1rem; margin-top:1.5rem;">Πατήστε εδώ ή σύρετε μια εικόνα</p>
        </label>
      </div>
      <div style="display:block">
        <button class="downbttn" id="submitBtn" onclick="inputCheck(event);">Υποβολή</button>
        <button class="downbttn" onclick="InputClear(event);">Εκκαθάριση</button>
        <button class="downbttn" onclick="event.preventDefault(); window.location.href = 'http://localhost/Important/house_selling1.php';">Πίσω</button>
      </div>
    </form>
    <br>
  </div>
  <script>
    var cost=document.getElementById("cost");
    var costperm2=document.getElementById("costperm2");
    var costlabel=document.getElementById("costlabel");
    const radiogroup1 = document.querySelectorAll('input[name="group1"]');
    const radiogroup2 = document.querySelectorAll('input[name="group2"]');
    //η πρώτη ομάδα κουμπιών (Αγορά/Πώληση) αλλάζει το τι γράφει το η ετικέτα κόστους
    radiogroup1.forEach(radio => {
      radio.addEventListener('change', radios1);
    });
    function radios1(){
      if (this.checked){
        if (this.id=="Πώληση"){costlabel.innerHTML="Κόστος:"}
        else{costlabel.innerHTML="Κόστος ανά Μήνα:"}
      }
    }
    var checkedRadio = document.querySelector('input[name="group1"]:checked');
    if (checkedRadio) radios1.call(checkedRadio);
    //η δεύτερη ομάδα κουμπιών (Ναι/Όχι) αλλάζει το εάν είναι υποχρεωτικό το κόστος
    radiogroup2.forEach(radio => {
      radio.addEventListener('change', radios2);
    });
    function radios2(){
      if (this.checked){
        if (this.id=="Όχι"){cost.placeholder="Σε ευρώ"; cost.classList.remove("optional");}
        else{cost.placeholder="Σε ευρώ (προαιρετικό)"; cost.classList.add("optional");}
      }
    }
    var checkedRadio = document.querySelector('input[name="group2"]:checked');
    //εμφανίζεται το κόστος ανά τετραγωνικό όταν ο χρήστης γράψει μια τιμή
    if (checkedRadio) radios2.call(checkedRadio);
    cost.addEventListener("input", Costperm2);
    function Costperm2(){
      //το setTimeout το έβαλα γιατί έτρεχε πρίν το numrestrict στο numrestrict.js και το τελευταίο νούμερο μπορούσε να γίνει γράμμα στο κόστος ανά τετραγωνικό
      setTimeout(() => {
        if (cost.value!=""){
          costperm2.style.display = "block";
          costperm2.innerHTML=cost.value+" ευρώ ανά τετραγωνικό."; 
        }
        else{
          //εξαφανίζει το κόστος ανά τετραγωνικό όταν δεν πρέπει να υπάρχει
          costperm2.style.display="none";
        }
      }, 0);
    }
    Costperm2();
  </script>
  <script>
    //αρχικοποιούνται μεταβλητές για την εισαγωγή, μεταφορά, διαγραφή και αποθήκευση εικόνων
    var num=1;
    var draggedImg = null;
    const input = document.getElementById("imageUpload");
    const maxSize = 5 * 1024 * 1024; //5 ΜΒ
    var parent=document.getElementById("previewcontainer");
    dropArea=document.getElementById("dropArea");
    dropArea.addEventListener("change", () => addimage(input.files[0], true));
    //tosave υπάρχει για να μην αποθηκεύονται οι εικόνες όταν ο χρήστης φορτώνει τη σελίδα σπαταλώντας πόρους (οι εικόνες αποθηκεύονται στην indexedDB με το LocalDatabase.js)
    function addimage(file, tosave){
      if (file.size < maxSize) {
        //δημιουργείται η εικόνα (target), to container που θα είναι η εικόνα μαζί με το κουμπί διαγραφής. 
        var container = Object.assign(document.createElement("div"), {id:"imgcontainer" + num, className: "imgcontainer"});
        var target = Object.assign(document.createElement("img"), {id: "preview" + num, src: "", className: "previewimage draggable", draggable:true, alt: "Image preview"});
        var removebttn = Object.assign(document.createElement("img"), {id: "removebttn" + num, src: "pictures/removebttn.png", className: "removebttn", alt: "Image remove", onclick: function() { imgremove(this.id); }});
        //μπαίνει η εικόνα και το κουμπί στο container
        container.appendChild(target);
        container.appendChild(removebttn);
        //το container με την εικόνα και το κουμπί μπαίνει στο μεγαλύτερο container (τώρα δημιουργείται)
        parent.insertBefore(container, parent.lastElementChild);
        img=document.getElementById("preview"+num);
        //το "lightbox" εμφανίζεται
        var lightbox=document.getElementById("lightbox");
        var lightboxImg=document.getElementById("lightbox-img");
        img.addEventListener("click", function() {
          lightbox.style.display = "flex";
          lightboxImg.style.display = "block";
          lightboxImg.src = this.src;
          document.body.style.overflow = "hidden";
        });
        //για να μπορεί ο χρήστης να ανταλλάζει θέσεις εικόνων
        img.addEventListener('dragstart', (e) => {
          draggedImg = e.target;
          swapimage=e.target.id;
          e.dataTransfer.setData('text/plain', '');
        });
        img.addEventListener('drop', (e) => {
          //η σελίδα θα μετατρεπώταν στην εικόνα χωρίς αυτό
          e.preventDefault();
          //ελέγχεται εάν οι 2 εικόνες δεν είναι ολόιδιες (εάν ο χρήστης βάλει την εικόνα στον εαυτό της)
          if (draggedImg !== e.target) {
            var tempSrc = draggedImg.src;
            draggedImg.src = e.target.src;
            e.target.src = tempSrc;
            //το swapimages είναι στο LocalDatabase.js
            swapimages(swapimage, e.target.id);
          }
          draggedImg = null;
        });
        //δεν μπορούσα να χρησιμοποιήσω το img, αλλιώς μόνο η τελευταία εικόνα αποθηκευόταν σωστά
        var preview = document.getElementById("preview"+num);
        var reader = new FileReader();
        reader.onload = e => {
          preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
        if (tosave){
          saveimages("preview"+num,input.files[0], file.name);
        }
        num=num+1;
      }
      else{
        alert("Εικόνα πάνω από 5MB. Παρακαλώ συμπιέστε την (υπάρχουν σελίδες συμπίεσης εικόνας στο διαδίκτυο) ή εισάγετε διαφορετική εικόνα");
      }
    }
    dropArea.addEventListener("dragover", function(e) {
      e.preventDefault();
    });
    document.body.addEventListener("dragover", function(e) {
      e.preventDefault();
    });
    document.body.addEventListener("drop", function(e) {
      e.preventDefault();
    });
    dropArea.addEventListener("drop", function(e) {
      e.preventDefault();
      input.files=e.dataTransfer.files;
      if (input.files[0].type.startsWith("image/")) {
        addimage(input.files[0], true);
      }
    });
    function imgremove(x){
      target2=x.match(/\d+/)[0];
      document.getElementById("imgcontainer"+target2).remove();
      deleteimage("preview"+target2);
      for (var i=Number(target2)+1; i<num; i++){
        document.getElementById("removebttn"+i).id=("removebttn"+(i-1));
        document.getElementById("preview"+i).id=("preview"+(i-1));
        document.getElementById("imgcontainer"+i).id=("imgcontainer"+(i-1));
      }
      num=num-1;
    }
  </script>
</body>
</html>
