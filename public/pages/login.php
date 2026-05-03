<?php 
  $currentPage="login";
  include ('nonce.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Σύνδεση</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="js/visibilitychange.js" async defer></script>
  <script src="js/inputCheck.js" async defer></script>
  <script src="js/dragstopper.js" async defer></script>
</head>
<body>
  <div class="content" id="content">
    <?php include('header.php'); ?>
    <div class="formdiv">
      <h3>Παρακαλώ εισάγετε όνομα χρήστη και κωδικό για να συνδεθείτε</h3>
      <form action="login_processing.php" method="post">
        <label>Όνομα χρήστη:</label>
        <div class="fieldwrapper">
          <div><img src="pictures/usericon.png" class="minimage" alt="όνομα χρήστη"></div>
          <div><input type="text" id="username" name="username" spellcheck="false"></div>
          <div></div>
        </div><br>
        <label>Κωδικός πρόσβασης:</label>
        <div class="fieldwrapper">
          <div><img src="pictures/passicon.png" class="minimage" alt="κωδικός"></div>
          <div><input type="password" id="password1" name="password1" spellcheck="false"></div>
          <div><img class="minimage passimage" id="passwordvisibility1" src="pictures/password_invisible.png" alt="κωδικός" onclick="visibilitychange(this.id)"></div>
        </div><br>
        <p class="error" id="password_error">Λάθος όνομα χρήστη ή κωδηκος</p>
        <button class="downbttn" id="submit" onclick="inputCheck(event);">Υποβολή</button><br>
      </form>
      <p style="font-size: 1.25rem; padding-bottom:2rem;">Δέν έχετε λογαριασμό; Κάντε εγγραφή <a href="signup.php">εδώ</a></p>
    </div>
  </div>
</body>
</html>
