<?php 
  $currentPage="contact";
  include ('nonce.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Επικοινωνία</title>
  <meta charset="UTF-8">
  <script src="js/loadingscreen.js"></script>
  <script src="js/inputCheck.js" async defer></script>
  <script src="js/LocalDatabase.js" async defer></script>
  <script nonce="<?php echo $nonce; ?>" src="https://www.google.com/recaptcha/api.js?hl=el&onload=initCaptchaScaling" async defer></script>
  <script src="js/captcha_scaling.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
  <div class="content" id="content">
    <?php include('header.php'); ?>
  <div class="formdiv" style="width:45rem;">
    <form action="contact_processing.php" method="post">
      <br>
      <div style="display:flex;">
        <div style="flex: 50%;">
          <label for="name">Όνοματεπώνυμο:</label></div>
        <div style="flex: 50%;">
          <label for="email">email:</label></div>
      </div>
      <div style="display:flex;">
        <div style="flex: 50%;">
          <input type="text" id="name" name="name" required spellcheck="false"></div>
        <div style="flex: 50%;">
          <input type="email" id="email" name="email" spellcheck="false"></div>
      </div>
      <br>
      <label for="comment">Σχόλιο:</label>
      <div class="fieldwrapper">
        <div class="centered-container"><textarea maxlength="300" placeholder="Τί θέλετε να μας πείτε"></textarea></div>
      </div>
      <br><br>
      <div class="fieldwrapper">
        <div class="captcha-container" id="captcha-container">
          <div class="captcha-wrapper" id="captcha-wrapper">
            <div class="g-recaptcha" id="recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" data-callback="enableSubmit" data-expired-callback="disableSubmit"></div>
          </div>
        </div>
      </div>
      <button class="downbttn" id="submitBtn" onclick="inputCheck(event);">Υποβολή</button><br>
    </form>
    <br>
  </div>
  <script>
  </script>
</body>
</html>
