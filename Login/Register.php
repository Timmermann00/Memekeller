<?php 
include_once "../phpClasses/cls_UserLogin.php";
?>



<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="../CSS_Files/LoginRegister.css" />
  <link rel="icon" type="image/x-icon" href="../MemeData/Logo/MemekellerLogo.jpg" />
  <title>Memekeller | Registrierung</title>
  <script type="text/javascript" src="../JS_Files/ValidatePassword.js"></script>
</head>
<body>
  <div class="center">
    <h1>Memekeller - Registrierung</h1>
    <form method="post">
      <div class="textfeld">
        <input type="text" name="username" id="name" placeholder=" " required>
        <span></span>
        <label>Benutzername</label>
      </div>
      <div class="textfeld">
        <input type="email" name="email" placeholder=" " required>
        <span></span>
        <label>E-Mail</label>
      </div>
      <div class="textfeld">
        <input type="password" id="password1" name="password1" placeholder=" " required>
        <span></span>
        <label>Passwort</label>
      </div>
      <div class="textfeld">
        <input type="password" id="password2" name="password2" placeholder=" " required>
        <span></span>
        <label>Passwort wiederholen</label>
      </div>
       <?php 
      if (isset($_POST["b_submit"])) {
        $tmp = new cls_UserLogin();
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password1", FILTER_DEFAULT);
        $username = filter_input(INPUT_POST, "username", FILTER_DEFAULT);
        if($tmp->AddUser($email, $password, $username))
        {
            header("Location: ../Login/Meme-Login.php");
        }
      }
      ?>  
      <button type="submit" onclick="return chkPassword();" id="b_submit" name="b_submit"><strong>Registrieren</strong></button>
      <div class="weiterleitung">
        Sie haben bereits einen Account? <br> <a href="Meme-Login.php"> Hier einloggen</a>
      </div>
    </form>
  </div>
</body>
</html>
    
