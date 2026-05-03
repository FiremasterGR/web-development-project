<?php 
$currentPage="propertyinsert";
include ('nonce.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Πώληση Ακινήτων</title>
  <meta charset="UTF-8">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDX3bwqHh6SloyF2jKqcYwAwelFnMvL2Yo&libraries=places&language=el&loading=async&callback=initMap"></script>
  <script src="js/loadingscreen.js"></script>
  <script src="js/inputCheck.js" async defer></script>
  <script src="js/InputClear.js" async defer></script>
  <script src="js/numrestrict.js" async defer></script>
  <script src="js/lightbox.js"></script>
  <script src="js/LocalDatabase.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <div class="content" id="content">
  <div id="lightbox">
    <div id="lightbox-alert">
      <p id="alertmessage">Είστε σίγουροι ότι θέλετε να κάνετε εκκαθάριση όλων των πεδίων;</p>
      <div style="display:flex;">
        <div class="flexbox" style="flex: 50%;"><button class="downbttn" onclick="ClearAll();">Ναι</button></div>
        <div class="flexbox" style="flex: 50%;"><button class="downbttn" onclick="lightbox.style.display='none';">Όχι</button></div>
      </div>
    </div>
  </div>
  <?php include('header.php'); ?>
  <div class="formdiv" style="width: min(50rem, 80vw);">
    <form action="house_selling2.php" method="post">
      <br>
      <h3>Στοιχεία Ακινήτου:</h3>
      <div style="display:flex;">
        <div style="flex: 50%;"><label>Τύπος ακινήτου:</label></div>
        <div style="flex: 50%;"><label>Διεύθυνση:</label></div>
      </div>
      <div style="display:flex;">
        <div style="flex: 50%;">
          <div style="flex-direction: column;" class="flexbox">
            <div class="DropList">
              <input type="text" id="propertylist" readonly placeholder="Κάντε κλικ για επιλογές">
              <ul id="sublist">
                <li>Σπίτι</li>
                <li>Διαμέρισμα</li>
                <li>Εμπορικός Χώρος (μέρος κτηρίου)</li>
                <li>Εμπορικός Χώρος (πλήρες κτήριο)</li>
                <li>Γκαρσονιέρα</li>
                <li>Έπαυλη</li>
              </ul>
            </div>
            <p id="propertydesc" style="max-width:20rem;"></p>
          </div>
        </div>
        <div style="flex: 50%;">
          <input type="text" id="address" name="address" spellcheck="false" placeholder="Ανδριανουπόλεως 13">
        </div>
      </div><br>
      <div style="display:flex;">
        <div style="flex: 50%;"><label>Ταχυδρομικός κώδηκας</label></div>
        <div style="flex: 50%;"><label>Πόλη</label></div>
      </div>
      <div style="display:flex;">
        <div style="flex: 50%;"><input class="numinput1" type="text" id="TK" name="TK" spellcheck="false" placeholder="11855"></div>
        <div style="flex: 50%;"><input type="text" id="city" name="city" spellcheck="false" placeholder="Αθήνα"></div>
      </div>
      <br><br>
      <div style="display:flex;">
        <div style="flex: 50%;"><label>Περιοχή:</label></div>
        <div style="flex: 50%;"><label>Τετραγωνικά Μέτρα:</label></div>
      </div>
      <div style="display:flex;">
        <div style="flex: 50%;"><input type="sublocality" id="sublocality" name="sublocality" spellcheck="false" placeholder="Μαρούσι"></div>
        <div style="flex: 50%;"><input class="numinput1" type="text" id="TM" name="TM" spellcheck="false" placeholder="100"></div>
      </div><br><br>
      <div style="display:flex; flex-direction:column;">
        <div style="flex: 50%;"><label id="floorlabel">Όροφος:</label></div>
        <div style="flex: 50%;"><input class="numinput3" type="text" id="floor" name="floor" spellcheck="false" placeholder="1"></div>
      </div>
      <div id="extrainfo">
        <br>
        <h3>Επιπλέον στοιχεία:</h3>
        <div style="display:flex;">
          <div style="flex: 50%;"><label>Αριθμός Μπάνιων:</label></div>
          <div style="flex: 50%;"><label>Αριθμός Υπνοδωματίων:</label></div>
        </div>
        <div style="display:flex;">
          <div style="flex: 50%;"><input class="numinput1" type="text" id="bathrooms" name="bathrooms" spellcheck="false" placeholder="1"></div>
          <div style="flex: 50%;"><input class="numinput1" type="text" id="bedrooms" name="bedrooms" spellcheck="false" placeholder="1"></div>
        </div><br><br>
        <div style="display:flex; flex-direction:column;">
          <div style="flex: 50%;"><label id="floorlabel">Αριθμός Διαμερίσματος:</label></div>
          <div style="flex: 50%;"><input class="numinput1" type="text" id="apartmentnum" name="apartmentnum" spellcheck="false" placeholder="1"></div>
        </div>
      </div>
      <br><br>
      <div style="display:block;">
        <button class="downbttn" id="submitBtn" onclick="inputCheck(event);">Υποβολή</button>
        <button class="downbttn" onclick="InputClear(event);">Εκκαθάριση</button>
      </div>
    </form>
    <br>
  </div>
  <script>
    function initMap(){
      var searchInput = document.getElementById("address");
      var autocomplete = new google.maps.places.Autocomplete(searchInput, { 
        types: ["geocode"],
        componentRestrictions: { country: "gr" }
      });
      autocomplete.addListener("place_changed", function () {
        var near_place = autocomplete.getPlace();
        var street="";
        var number = "";
        for (var i = 0; i < near_place.address_components.length; i++) {
          var component = near_place.address_components[i];
          var types = component.types;
          if (types.includes("route")) street = component.long_name;
          if (types.includes("street_number")) number = component.long_name;
          if (types.includes("postal_code")) document.getElementById("TK").value = component.long_name.replace(/[^0-9]/g, '');
          if (types.includes("locality"))document.getElementById("city").value = component.long_name;
          if (types.includes("sublocality") || types.includes("sublocality_level_1")) sublocality = component.long_name;}
        searchInput.value=(street+" "+number);
      });
      var searchInput2 = document.getElementById("sublocality");
      var autocomplete2 = new google.maps.places.Autocomplete(searchInput2, {
        types: ["(regions)"],
        componentRestrictions: { country: "gr" }
      });
      autocomplete2.addListener("place_changed", function () {
        var near_place = autocomplete2.getPlace();
        var sublocality="";
        for (var i = 0; i < near_place.address_components.length; i++) {
          var component = near_place.address_components[i];
          var types = component.types;
          if (!sublocality && types.includes("locality")) sublocality = component.long_name;
          if (types.includes("sublocality")) sublocality = component.long_name;
        }
        searchInput2.value=sublocality;
      });
    }
  </script>
  <script>
    var input = document.getElementById("propertylist");
    var list = document.getElementById("sublist");
    input.addEventListener("click", () => {
      if (list.classList.contains("open")){
        list.classList.remove("open");
      }
      else{
        list.classList.toggle("open");
      }
    });
    input.addEventListener("input", () => {
      propertydesc(input.value);
    });
    list.addEventListener("click", (e) => {
      if (e.target.tagName === "LI") {
        input.value = e.target.textContent;
        propertydesc(e.target.textContent);
        list.classList.remove("open");
      }
    });
    document.addEventListener("click", (e) => {
      if (!e.target.closest(".DropList")) {
        list.classList.remove("open");
      }
    });
  </script>
  <script>
    var floor=document.getElementById("floor");
    var desc=document.getElementById("propertydesc");
    var floorlabel=document.getElementById("floorlabel");
    var numinputs=["numinput1","numinput2","numinput3"];
    function propertydesc(selection){
      var target=numinputs.find(c=>floor.classList.contains(c));
      if (selection=="Σπίτι"){
        desc.innerHTML="Κτήριο που προορίζεται για ιδιωτική κατοίκηση. Δεν αποτελέται από πολλά διαμερίσματα ή είναι ένα από αυτά. Μπορεί και να χρησιμοποιηθεί για παροχή υπηρεσιών (πχ οδοντιατρείο)";
        floorlabel.innerHTML="Όροφοι";
        optionalextra(false);
        floor.classList.replace(target,"numinput1");
      }
      else if (selection=="Διαμέρισμα"){
        desc.innerHTML="Μέρος πολυώροφου κτηρίου που προορίζεται για ιδιωτική κατοίκηση. Μπορεί και να χρησιμοποιηθεί για παροχή υπηρεσιών (πχ μικρό οδοντιατρείο)";
        floorlabel.innerHTML="Όροφος";
        optionalextra(false);
        floor.classList.replace(target,"numinput2");
      }
      else if (selection=="Εμπορικός Χώρος (μέρος κτηρίου)"){
        desc.innerHTML="Μέρος πολυώροφου κτηρίου που προορίζεται για παραγωγή/παροχή αγαθών ή παροχή υπηρεσιών. Από μονοώροφο φαρμακείο σε πολυώροφο κτήριο, σε ολόκληρο εργαστήριο ή αποθήκη που είναι μέρος κτηρίου.";
        floorlabel.innerHTML="Όροφος / Όροφοι";
        optionalextra(true);
        floor.classList.replace(target,"numinput3");
      }
      else if (selection=="Εμπορικός Χώρος (πλήρες κτήριο)"){
        desc.innerHTML="Κτήριο που προορίζεται για παραγωγή/παροχή αγαθών ή παροχή υπηρεσιών. Από μονοώροφο καφενείο σε μονοώροφο κτήριο, σε μεγάλη αποθήκη ή εργοστάσιο.";
        floorlabel.innerHTML="Όροφοι";
        optionalextra(true);
        floor.classList.replace(target,"numinput1");
      }
      else if (selection=="Γκαρσονιέρα"){
        desc.innerHTML="Μέρος πολυώροφου κτηρίου που προορίζεται για ιδιωτική κατοίκηση. Πολύ μιρκό σε διαστάσεις και αποτελείται μόνο από τα βασικά αλλά έχει πολύ χαμηλό κόστος.";
        floorlabel.innerHTML="Όροφος";
        optionalextra(true);
        floor.classList.replace(target,"numinput2");
      }
      else if (selection=="Έπαυλη"){
        desc.innerHTML="Κτήριο που προορίζεται για ιδιωτική κατοίκηση. Συνήθως πολυτελής, πολυώροφο με πολλά δωμάτια και κήπο, αλλά ακριβό.";
        floorlabel.innerHTML="Όροφοι";
        optionalextra(false);
        floor.classList.replace(target,"numinput1");
      }
      else desc.innerHTML="";
      if (floor.classList.contains("numinput1")){
        floor.placeholder="πχ 1 ή 2 ...";
      }
      else if (floor.classList.contains("numinput2")){
        floor.placeholder="πχ -1(ος), 0(ος), 2(ος)...";
      }
      else if (floor.classList.contains("numinput3")){
        floor.placeholder="πχ -1 ή 1 ή '-2 – 3'...";
      }
    }
    window.onload=function(){
      LoadSessionData();
      propertydesc(document.getElementById("propertylist").value);
    }
    function optionalextra(bool){
      if (bool){
        document.getElementById("extrainfo").style.display="none";
        document.getElementById("bathrooms").classList.add("optional");
        document.getElementById("bedrooms").classList.add("optional");
        document.getElementById("apartmentnum").classList.add("optional");
        document.getElementById("bathrooms").value="";
        document.getElementById("bedrooms").value="";
        document.getElementById("apartmentnum").value="";
      }
      else{
        document.getElementById("extrainfo").style.display="block";
        document.getElementById("bathrooms").classList.remove("optional");
        document.getElementById("bedrooms").classList.remove("optional");
        document.getElementById("apartmentnum").classList.remove("optional");
      }
    }
  </script>
</body>
</html>
