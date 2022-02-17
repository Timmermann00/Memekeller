<html>
<?php include_once '../phpClasses/cls_Autoloader.php';

cls_SessionHandling::start();
$name = cls_SessionHandling::ReturnUserNickname();
$User = new cls_UserFunc();
$email = $User->GetEmail($name);
if (isset($_POST["b_save"])) {

    $username = filter_input(INPUT_POST, "username", FILTER_DEFAULT);
    $emailNew = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_DEFAULT);

    if (!($_SESSION['user'] == $username) && ($username != " ")) {
        $User->UpdateName($username);
        $name = $username;
    }
    if (!($email == $emailNew)) {
        $User->UpdateEmail($emailNew);
        $email = $User->GetEmail($name);
    }
    if (($password != " ")) {
        if (strlen($password) >= 4) {
            $User->UpdatePassword($password);
        }
    }
}
?>

<head>
    <meta charset="UTF-8">
       <link rel="stylesheet" type="text/css" href="../CSS_Files/AlterProfile.css" />
    <link rel="icon" type="image/x-icon" href="../MemeData/Logo/MemekellerLogo.jpg" />
    <script type="text/javascript" src="../JS_Files/LogoutFromSession.js"></script>
    <title>Memekeller | Profil bearbeiten</title>

</head>

<script src="AlterJson.js"> </script>

<body onload="ChangeInputs()" class="background">
    <div class="grid-container">
        <div class="user-profile">
            User Profilbild!
        </div>
        <form id="AlterUserForm" method="post" onload="ChangeInputs()">
            <div class="user-information">
                <h1>Profil bearbeiten</h1>
                <div class="textfeld">
                    <input type="text" name="username" id="nickname" value="Benutzername">
                    <span></span>
                    <label>Benutzername</label>
                </div>
                <div class="textfeld">
                    <input type="text" name="password" value=" ">
                    <span></span>
                    <label>Passwort</label>
                </div>
                <div class="textfeld">
                    <input type="email" id="email" name="email" value="E-Mail">
                    <span></span>
                    <label>E-Mail</label>
                </div> 
            </div>
        </form>
        <div class="button_grid">
                        <button class="back_button"  onclick="window.location.href='<?php echo cls_SessionHandling::GetLink();?>'">Back</button>
                        <button form="AlterUserForm" class="save_button" type="submit" name="b_save">Speichern</button>
                       <button class="logout_button" onclick="Logout()">Logout</button>
                </div>
    </div>

    <script>
        function FetchName() {
            var name = <?php echo json_encode($name); ?>;
            return name;
        }

        function FetchEmail() {
            var email = <?php echo json_encode($email); ?>;
            return email;
        }

        function ChangeInputs() {
            document.getElementById("nickname").value = FetchName();
            document.getElementById("email").value = FetchEmail();
        }
    </script>
</body>

</html>