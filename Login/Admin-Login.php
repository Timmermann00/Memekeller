<?php 
    include '../phpClasses/cls_Autoloader.php';
    cls_SessionHandling::start();
?>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="../CSS_Files/AdminViewStyling.css">
  <link rel="stylesheet" type="text/css" href="../CSS_Files/LoginRegister.css">
  <link rel="icon" type="image/x-icon" href="../MemeData/Logo/MemekellerLogo.jpg" />
  <title>Admin-Login | Memekeller</title>
</head>

<body class="background">
  <div class="center">
    <h1>Memekeller - Login</h1>
    <form method="post">
      <div class="textfeld">
        <input type="password" name="psw" placeholder=" " required>
        <span></span>
        <label>Passwort</label>
      </div>
      <button type="submit" name="b_submit">Einloggen</button>
      <?php

      if (isset($_POST["b_submit"])) {
        $psw = filter_input(INPUT_POST, "psw", FILTER_DEFAULT);
        $tmp = new cls_UserLogin();
        if ($tmp->ValidateAdminLogin($psw)) {
          header("Location: ../FrontEndHtmlPhp/AdminView.php");
        }
      }

      ?>
    </form>
    <div style="padding: 0px 40px 10px">
      <a href='<?php echo cls_SessionHandling::GetLink() ?>'>
        <button class="GoBackbuton">Go back</button>
      </a>
    </div>
  </div>
</body>

</html>