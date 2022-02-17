<?php 
    include_once "../phpClasses/cls_Autoloader.php";
?>

<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="../CSS_Files/LoginRegister.css">
  <link rel="icon" type="image/x-icon" href="../MemeData/Logo/MemekellerLogo.jpg" />
  <link rel="icon" type="image/x-icon" href="../MemeData/Logo/MemekellerLogo.jpg" />
  <title>Login | Memekeller</title>
</head>

<body class="background">
  <div class="center">
    <h1>Memekeller - Login</h1>
    <form method="post">
      <div class="textfeld">
        <input type="text" name="uname" placeholder=" " required>
        <span></span>
        <label>Benutzername</label>
      </div>
      <div class="textfeld">
        <input type="password" name="psw" placeholder=" " required>
        <span></span>
        <label>Passwort</label>
      </div>
      <button type="submit" name="b_submit">Einloggen</button>

      <?php
      include_once "..\phpClasses\cls_SessionHandling.php";

      cls_SessionHandling::start();

      

      if (isset($_POST["b_submit"])) {
        $tmp = new cls_UserLogin();
        $username = filter_input(INPUT_POST, "uname", FILTER_DEFAULT);
        $psw = filter_input(INPUT_POST, "psw", FILTER_DEFAULT);
        if ($tmp->ValidateUserForLogin($username, $psw)) {
          cls_SessionHandling::AddUser($username);
          header("Location:" . cls_SessionHandling::GetLink());
        }
      }
      ?>

      <div class="weiterleitung">
        Noch keinen Account? <a href="Register.php"> Hier registrieren</a>
      </div>
      <div class="weiterleitung">
        Sie sind ein Admin? <a href="Admin-Login.php"> Hier einloggen</a>
      </div>
    </form>
    <div style="padding: 0px 40px 10px">
      <a href='<?php echo cls_SessionHandling::GetLink() ?>'>
        <button class="GoBackbuton">Go back</button>
      </a>
    </div>
  </div>
</body>

</html>