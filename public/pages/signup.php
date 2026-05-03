<?php 
$currentPage="signup";
include ('nonce.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Εγγραφή</title>
  <meta charset="UTF-8">
  <script nonce="<?php echo $nonce; ?>" src="https://www.google.com/recaptcha/api.js?hl=el&onload=initCaptchaScaling" async defer></script>
  <script src="js/captcha_scaling.js" async defer></script>
  <script src="js/numrestrict.js" async defer></script>
  <script src="js/visibilitychange.js" async defer></script>
  <script src="js/inputCheck.js" async defer></script>
  <script src="js/LocalDatabase.js" async defer></script>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style4.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
  <div class="content" id="content">
    <?php include('header.php'); ?>
    <div class="formdiv">
      <h3>Παρακαλώ συμπληρώστε τα στοιχεία για να εγγραφτείτε </h3>
      <form action="SignupProcessing.php" method="post">
        <label for="username">Όνομα χρήστη:</label>
        <div class="fieldwrapper">
          <div><img src="pictures/usericon.png" class="minimage" alt="όνομα χρήστη"></div>
          <div><input type="text" class="englishonly" id="username" name="username" required spellcheck="false" placeholder="username1"></div>
          <!--Είναι πιο βολικό να βάλω αυτο το div παρά να φτιάχνω ολόκληρο στυλ για ενα div αριστερά και στο κέντρο-->
          <div></div>
        </div>
        <p id="usernameerror" class="error">Όνομα χρήστη είναι από 8 εώς 30 χαρακτήρες<br></p>
        <label for="password">Κωδικός πρόσβασης:</label>
        <div class="fieldwrapper">
          <div><img src="pictures/passicon.png" class="minimage" alt="κωδικός"></div>
          <div><input type="password" class="englishonly" id="password1" name="password" required spellcheck="false" placeholder="MyPassword1" class="numsandletters"></div>
          <div><img class="minimage passimage" id="passwordvisibility1" src="pictures/password_invisible.png" alt="ορατότηα"></div>
        </div>
        <p id="passworderror" class="error">Κωδικός είναι από 8 εώς 30 χαρακτήρες<br></p>
        <h2>Ο κωδικός πρέπει να περιέχει:</h2>
        <p class="info" id="letter">1 <b>μικρό</b> γράμμα</p>
        <p class="info" id="capital">1 <b>Κεφαλαίο</b> γράμμα</p>
        <p class="info" id="number">1 <b>νούμερο</b></p>
        <p class="info" id="length">Από <b>8 εώς 30 Χαρακτήρες.</b></p>
        <label for="passwordvalidation">Επιβεβαίωση κωδικού:</label>
        <div class="fieldwrapper">
          <div><img src="pictures/passconfirmation.png" class="minimage" alt="επιβεβαίωση"></div>
          <div><input type="password" class="englishonly" required id="password2" name="password_confirm" spellcheck="false" class="numsandletters"></div>
          <div><img class="minimage passimage" id="passwordvisibility2" src="pictures/password_invisible.png" alt="ορατότητα"></div>
        </div>
        <p id="diffpass" class="error">Οι κωδικοί δεν είναι ίδιοι</p>
        <label for="phone">Τηλέφωνο:</label>
        <div class="fieldwrapper">
          <div><img src="pictures/phone.png" class="minimage" alt="τηλέφωνο"></div>
          <div><input type="tel" id="phone" class="numsonly" name="phone" spellcheck="false" pattern="[0-9]{10}" placeholder="6912345678/2101234567"></div>
          <div></div>
        </div>
        <p id="phoneerror" class="error">Μέγεθος κινητού/τηλεφώνου είναι 10 χαρακτήρες<br></p>
        <label for="email">email:</label>
        <div class="fieldwrapper">
          <div><img src="pictures/email.png" class="minimage" alt="email"></div>
          <div><input type="email" class="emailsonly" id="email" name="email" spellcheck="false" placeholder="myemail@domain.com"></div>
          <div></div>
        </div>
        <p id="emailerror" class="error">Οι διευθύνσεις email είναι εώς 320 χαρακτήρες...<br></p>
        <div class="fieldwrapper">
          <div class="captcha-container" id="captcha-container">
            <div class="captcha-wrapper" id="captcha-wrapper">
              <div class="g-recaptcha" id="recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" data-callback="enableSubmit" data-expired-callback="disableSubmit"></div>
            </div>
          </div>
        </div>
        <div>
          <label class="CheckmarkContainer">
            <input type="checkbox" name="remember" id="rememberMe" class="optional"> Να με θυμάσαι</input>
            <span class="checkmark"></span>
          </label>
        </div><br>
        <button class="downbttn" id="submitBtn">Υποβολή</button>
      </form>
      <br>
    </div>
  </div>
  <script nonce="<?php echo $nonce; ?>">
    var username = document.getElementById("username");
    var phone = document.getElementById("phone");
    var email = document.getElementById("email");
    var password1 = document.getElementById("password1");
    var password2 = document.getElementById("password2");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");
    let validationState = {
    hasLower: false,
    hasUpper: false,
    hasNumber: false,
    hasLength: false,
    passwordsMatch: false,
    captchavalidity: false,
    emailCorrect: false,
    phoneCorrect: false,
    usernameCorrect: false
    };
    password1.addEventListener('input', function () {
    // Έλεγχος μικρών γραμμάτων
    var lowerCaseLetters = /[a-z]/g;
    if(password1.value.match(lowerCaseLetters)) {
      validationState.hasLower=true;
      document.getElementById('letter').style.color="green";
    } else {
      validationState.hasLower=false;
      document.getElementById('letter').style.color="red";
    }
  
    // Έλεγχος κεφαλαίων γραμμάτων
    var upperCaseLetters = /[A-Z]/g;
    if(password1.value.match(upperCaseLetters)) {
      validationState.hasUpper=true;
      capital.style.color="green";
    } else {
      validationState.hasUpper=false;
      capital.style.color="red";
    }

    // Έλεγχος αριθμών
    var numbers = /[0-9]/g;
    if(password1.value.match(numbers)) {  
      validationState.hasNumber=true;
      number.style.color="green";
    } else {
      validationState.hasNumber=false;
      number.style.color="red";
    }
  
    // Έλεγχος μεγέθους κωδικού
    if(password1.value.length >= 8 && password1.value.length <= 30) {
      validationState.hasLength=true;
      length.style.color="green";
    } else {
      validationState.hasLength=false;
      length.style.color="red";
    }
    checkpass();
    });
    password2.addEventListener('input', checkpass);
    function checkpass(){
      // Έλεγχος λάθος κωδικού
      if (password1.value!=password2.value){
        validationState.passwordsMatch=false;
        document.getElementById("diffpass").style.display="block";
      }
      else{
        validationState.passwordsMatch=true;
        document.getElementById("diffpass").style.display="none";
      }
      updsubmitbttn();
    }
    document.getElementById("diffpass").style.display="none";
    //έλεγχος email
    email.addEventListener('input', function(){
      if(email.checkValidity()){
        validationState.emailCorrect=true;
        document.getElementById("emailerror").style.display="none";
      }
      else{
        validationState.emailCorrect=false;
        document.getElementById("emailerror").style.display="block";
      }
      updsubmitbttn();
    });
    document.getElementById("emailerror").style.display="none";
    //έλεγχος ονόματος χρήστη
    username.addEventListener('input', function(){
      if (username.value.length >= 8 && username.value.length <= 30){
        validationState.usernameCorrect=true;
        document.getElementById("usernameerror").style.display="none";
      }
      else{
        validationState.usernameCorrect=false;
        document.getElementById("usernameerror").style.display="block";
      }
      updsubmitbttn();
    });
    document.getElementById("usernameerror").style.display="none";
    // Έλεγχος κινητού
    phone.addEventListener('input', function(){
      if (phone.value.length==10){
        validationState.phoneCorrect=true;
        document.getElementById("phoneerror").style.display="none";
      }
      else{
        validationState.phoneCorrect=false;
        document.getElementById("phoneerror").style.display="block";
      }
      updsubmitbttn();
    });
    document.getElementById("phoneerror").style.display="none";
    function updsubmitbttn(){
      // Ελέγχει εάν όλα είναι σωστά
      if (!Object.values(validationState).every(v => v === true)) {
        document.getElementById("submitBtn").disabled = true;
      }
      else {
        document.getElementById("submitBtn").disabled = false;
      }
    }
  </script>
</body>
</html>
