<?php
  session_start();
  //εάν δεν είναι συνδεδεμένος ο χρήστης εξαφανίζεται το user
  $logged = !empty($_SESSION['username']);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/dragstopper.js" async defer></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style nonce="<?= $nonce ?>">
  :root {
    --header-height: calc(20vmin/min(1,max(0.75,var(--aspect-ratio))));
  }
  .header{
    display: flex;
    justify-content: space-between;
    background-color: rgb(206, 255, 243);
    height: var(--header-height);
    border-bottom-style: solid;
    border-width: calc(var(--header-height) *0.01);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    width: 100%;
    transform: translateY(0);
    will-change: transform;
  }
  .dropdown-content{
    /* Στοιχίζεται προς τα κάτω και στο ίδιο μήκος με το πάνω */
    display: grid;
    /* Το χρησιμοποιώ για να μπορώ να κάνω transition το ύψος. Εάν χρησιμοποιούσα 
    max-height: default ή κάτι παρόμοιο, η αλλαγή γινόταν κατευθείαν */
    grid-template-rows: 0fr;
    transition: grid-template-rows 0.4s ease, background-color 0s 0s;
    position: absolute; /* default; JS will switch to fixed when showing */
    flex-direction: column;
    top: 100%;
    left: 0;
    /* Είναι αόρατο μέχρι να γίνει το πάνω ή το ίδιο hover (χρήση javascript) */
    overflow: hidden;
    /* Ομαλή αλλαγή */
    box-sizing: border-box;
    background: white;
  }
  .dropdown-content > div {
    min-height: 0;
    overflow: hidden;
  }
  .dropdown{
    /* άγκυρα */
    position: relative;
    display: flex;
    flex-direction: column;
  }
  .menudiv{
    display: flex;
    justify-content:flex-end;
    align-items: flex-end;
    width: auto;
    max-width: 45vw;
    height:60%;
    margin-bottom: calc(var(--header-height) * 0.05);
  }
  .menu{
    width: max-content;
    display: flex;
    overflow-x: auto;
    overflow-y: hidden;
    scroll-behavior: smooth;
    user-select: none;
    cursor: grab;
    -webkit-overflow-scrolling: touch;
    align-items: flex-end;
    height:100%;
  }
 .menu:active {
    cursor: grabbing;
  }
  /* κινητό */
  .menu:not(.scrolling) .dropdown.down .dropdown-content {
    /* Το dropdown-content παίρνει το μέγιστο ύψος που έπρεπε να έχει. */
    grid-template-rows: 1fr; 
    /* Όταν κατεβαίνει και ανεβαίνει το dropdown-content, Τα borders και το περιεχόμενο 
    εμφανίζονται με διαφορετική ταχύτητα. Αυτό δεν ήταν σκόπιμο εξαρχής αλλά το κράτησα */
    background: transparent;
    transition: grid-template-rows 0.4s ease, background-color 0s 0.35s;
  }
  /* υπολογιστής */
  .has-mouse .menu:not(:active):not(.scrolling) .dropdown.down .dropdown-content {
    grid-template-rows: 1fr;
    background: transparent;
    transition: grid-template-rows 0.4s ease, background-color 0s 0.35s;
  }
  .menu a{
    box-sizing: border-box;
    height: calc(var(--header-height) *0.55);
    width: calc(var(--header-height) *1.1);
    min-width: calc(var(--header-height) *1.1);
    max-width: calc(var(--header-height) *1.1);
    font-size: max(calc(var(--header-height) * 0.16));
    background-color: white;
    border: calc(var(--header-height) *0.01) solid black;
    border-radius: calc(var(--header-height) *0.035);
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    line-height: 1;
  }
  #logo{
    height:90%;
    aspect-ratio: 2;
  }
  #userdisplay{
    display:none;
    justify-content:space-between;
    align-items:center;
    gap:0.4vw;
    height:25%;
    padding:0 0.25vw;
    border: calc(var(--header-height) *0.01) solid black;
    border-radius: calc(var(--header-height) *0.035);
    background-color:rgb(252, 254, 255);
    margin-top: calc(var(--header-height) * 0.05);
  }
  #logolink{
    margin-left: 1%;
    display: flex;
    align-items: center;
  }
  #userdisplayname{
    font-size: max(calc(var(--header-height) * 0.10));
    text-align: center;
  }
  #userdisplayimage{
    width: calc(var(--header-height)*0.20);
    height: calc(var(--header-height)*0.20);
  }
  .HeaderSpacer{
    height: calc(var(--header-height) + 2rem);
  }
  .right{
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    height: 100%;
    margin-right: 1%;
  }
  </style>
</head>
<body>
  <div class="header">
    <a href="houses.php" id="logolink"><img id="logo" src="pictures/logo.png" alt="Error picture"></a>
    <div class="right">
      <div id="userdisplay">
        <img src="pictures/usericon.png" id="userdisplayimage" alt="όνομα χρήστη">
        <p id="userdisplayname">Όνομα Χρήστη</p>
      </div>
      <div class="menudiv">
        <div class="menu">
          <!--Αρχική-->
          <a href="home.php" class="<?= $currentPage === 'home' ? 'current' : '' ?>" id="home">Αρχική</a>
          <!--Λογαριασμός-->
          <div class="dropdown">
            <a href="#" class="doNothingLink">Λογαριασμός</a>
            <div class="dropdown-content">
              <div>
                <a href="login.php" class="<?= $currentPage === 'login' ? 'current' : '' ?>" id="login">Σύνδεση</a>
                <a href="signup.php" class="<?= $currentPage === 'signup' ? 'current' : '' ?>" id="signup">Εγγραφή</a>
              </div>
            </div>
          </div>
          <!--Ακίνητα-->
          <div class="dropdown">
            <a href="#" class="doNothingLink">Ακίνητα</a>
            <div class="dropdown-content">
              <div>
                <a href="properties.php" class="<?= $currentPage === 'properties' ? 'current' : '' ?>" id="properties">Διαθέσιμα Ακίνητα</a>
                <a href="myproperties.php" class="<?= $currentPage === 'myproperties' ? 'current' : '' ?>" id="myproperties">Τα Ακίνητά μου</a>
                <a href="house_selling1.php" class="<?= $currentPage === 'propertyinsert' ? 'current' : '' ?>" id="propertyinsert">Καταχώρηση Ακινήτου</a>
              </div>
            </div>
          </div>
          <!--Επικοινωνία-->
          <a href="contact.php" class="<?= $currentPage === 'contact' ? 'current' : '' ?>" id="contact">Επικοινωνία</a>
        </div>
      </div>
    </div>
  </div>
  <div class="HeaderSpacer"></div>
  <script nonce="<?php echo $nonce; ?>">
    var header = document.querySelector(".header");
    var menu=document.querySelector(".menu");
    var clicktodrop=!window.matchMedia('(hover: hover)').matches;
    /*Dropdown που πεύτει με hover και τοποθετεί το dropdown-content κάτω από το dropdown 
    ακριβώς χωρίς να επηρεάζεται το menu ή να δημιουργείται vertical scrolling από κάτω*/
    var clickstop=false;
    function moveContent(drop){
      const dc = drop.querySelector('.dropdown-content');
      if (dc){
        if (dc.offsetHeight>0 || drop.classList.contains("down")){
          const droprect = drop.getBoundingClientRect();
          // place directly under the trigger element
          if (header){
            const headerRect =header.getBoundingClientRect();
            dc.style.top = (droprect.bottom-headerRect.top) + 'px';
            dc.style.left = (droprect.left-headerRect.left) + 'px';
          }
          else{
            dc.style.top = (droprect.bottom) + 'px';
            dc.style.left = (droprect.left) + 'px';
          }
        }
      }
    }
    // για το κινητό, κεντράρει την επιλογή
    function HorizontalFocus(target, container){
     var containerPosition = container.getBoundingClientRect();
     var targetPosition = target.getBoundingClientRect();
     container.scrollLeft +=(targetPosition.left + targetPosition.width / 2)-(containerPosition.left + containerPosition.width / 2);
    }
    function handledrop(e, drop) {
      if(clicktodrop){
        //εάν το πρώτο παιδί είναι ο σύνδεσμος που πάτηση ο χρήστης, δεν λειτουργεί
        if (drop.querySelector(':scope > a').contains(e.target) && !e.target.classList.contains("down")){
          e.preventDefault();
        }
        HorizontalFocus(drop, menu);
      }
      drop.classList.toggle('down');
      moveContent(drop);
    }
    //Αποφασίζει εάν θα κάνει κλικ για να πέσει το dropdown-content ή hover.
    var current=null
    document.querySelectorAll('.dropdown').forEach(drop => {
      const dc = drop.querySelector('.dropdown-content');
      dc.style.position = 'fixed';
      window.addEventListener('resize', (e)=> {moveContent(drop);});
      menu.addEventListener('scroll', (e)=>{moveContent(drop);});
      if (!clicktodrop){
        drop.addEventListener('mouseenter', (e) => {
          handledrop(e, drop);
        });
        drop.addEventListener('mouseleave', (e) => {
          handledrop(e, drop);
          drop.classList.remove('down');
        });
      }
      else{
        drop.addEventListener('click', (e) => {
          if(document.querySelector('.dropdown.down')){document.querySelector('.dropdown.down').classList.remove("down");}
          handledrop(e, drop);
        });
      }
    });
    //Για το κινητό, όταν ο χρήστης κάνει κλικ κάπου αλλού, το dropdown-content φεύγει
    if (clicktodrop){
      document.addEventListener('click', (e) => {
      if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown.down').forEach(drop => {
          drop.classList.remove('down');
        });
      }
      });
    }
    //Αποτρέπει το "current" από το να αλλάζει σελίδα και κάνει και το doNothingLink να έχει το ίδιο στυλ με το current.
    document.querySelectorAll(".current").forEach(current =>{current.addEventListener('click', (e) => {e.preventDefault();});});
    const dropdown = document.querySelector(".current").closest('.dropdown');
    if (dropdown) {
      const doNothingLink = dropdown.querySelector('.doNothingLink');
      doNothingLink.classList.add('current');
    }
    // Αποτρέπει τα doNothingLinks από το να αλλάζουν σελίδα
    document.querySelectorAll('.doNothingLink').forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
      });
    });
    if (clicktodrop){
      var lastScrollY = window.scrollY;
      //offset=0 είναι πλήρως κάτω το header
      var offset = 0;
      var header = document.querySelector(".header");
      var headerHeight = header.offsetHeight;
      function movableheader(){
        var currentScrollY = window.scrollY;
        var scrollchange = currentScrollY - lastScrollY;
        // Εάν ο χρήστης δεν είναι στο τέλος της σελίδας
        if(window.innerHeight + currentScrollY >= document.documentElement.scrollHeight-1) {
          header.style.transition="transform 0.3s ease-out";
          offset = offset - headerHeight;
        }
        //αλλιώς
        else{
          header.style.transition="transform 0s ease-out";
          offset = offset + scrollchange;
        }
        // Κρατάει το header ανάμεσα σε πλήρες ορατό (0 offset) και πλήρες αόρατο (headerHeight)
        offset = Math.max(0, Math.min(offset, headerHeight));
        //εάν το header είναι πλήρως αόρατο, τα dropdown-content φεύγουνε και πρέπει ο χρήστης να τα ξαναπατήσει
        if(offset==(headerHeight)){
          document.querySelectorAll(".dropdown.down").forEach(drop => {
            drop.classList.remove("down");
          });
        }
        //εάν το header δεν είναι πλήρως ορατό, τα dropdown-content φεύγουνε άμεσα αλλά μπορούν να ξαναεμφανιστούν
        else if(offset!=0){
          document.querySelectorAll(".dropdown-content").forEach(dc => {
            dc.style.maxHeight="0px";
            dc.style.gridTemplateRows="0fr";
          });
        }
        //ξαναεμφανίζεται το dropdown-content εάν το header δεν είχε γίνει πλήρως αόρατο
        else{
          document.querySelectorAll(".dropdown-content").forEach(dc => {
            dc.style.maxHeight=null;
            dc.style.gridTemplateRows=null;
          });
        }
        // Εφάρμοση του transform με αρνητικό πρόσημο (γιατί πάει πάνω)
        header.style.transform = `translateY(${-offset}px)`;
        lastScrollY = currentScrollY;
      }
      window.addEventListener("scroll", movableheader);
      window.addEventListener("resize", () => {
        //όταν αλλάζει το μέγεθος ή γυρνάει η οθόνη μετακινεί το header και τα dropdown-content
        requestAnimationFrame(() => {
          headerHeight = header.offsetHeight;
          offset = Math.min(offset, headerHeight);
          header.style.transform = `translateY(${-offset}px)`;
          document.querySelectorAll('.dropdown.down').forEach(drop => moveContent(drop));
        });
      });
      //για όταν φορτώνει η σελίδα, να φαίνεται το header.
      window.addEventListener("load", ()=>{
        header.style.transform = `translateY(0px)`;
        offset = 0;
      });
      header.addEventListener("click", ()=>{offset=0; movableheader();});
    }
    //το "πετάω" αυτό εδώ για να μην κάνω ολόκληρο αρχείο. Είναι για το κινητό όταν είναι σε Landscape για να μην κάνει ο χρήστης συνεχώς Scroll.
    document.querySelectorAll('input').forEach(input => {
      input.addEventListener('focus', () => {
        input.scrollIntoView({ behavior: 'smooth', block: 'center' });
      });
    });
    //για το header
    function updateAspectRatio() {
      const aspectRatio = window.innerWidth / window.innerHeight;
      document.documentElement.style.setProperty('--aspect-ratio', aspectRatio);
      console.log('Width:', window.innerWidth, 'Height:', window.innerHeight, 'Aspect:', aspectRatio);
    }
    window.addEventListener('resize', updateAspectRatio);
    window.addEventListener('load', updateAspectRatio);
    if (<?php echo $logged ? 'true' : 'false';?>){
      document.getElementById("userdisplay").style.display="flex";
      document.querySelector(".right").style.flexDirection="column";
    }
    //για να μην το βάλω στη φόρμα και την χαλάσω
    document.addEventListener("DOMContentLoaded", () => {
      document.querySelector("form").addEventListener("submit", function(e) {
        savevalues(e);
      });
    });
  </script>
</body>
</html>
