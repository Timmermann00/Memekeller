<?php
include '../phpClasses/cls_Autoloader.php';


?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <meta charset="UTF-8">
    <title>Home | Memekeller</title>
    <link rel="icon" type="image/x-icon" href="../MemeData/Logo/MemekellerLogo.jpg" />
    <link rel="stylesheet" href="../CSS_Files/StartViewStyling.css?x=4" type="text/css">
    <script type="text/javascript" src="../JS_Files/FilterByHeadline.js"></script>
    <script src="https://use.fontawesome.com/fe459689b4.js"></script>
</head>

<body>
    <?php
    $StartpageController = new cls_StartPageController();
    echo $StartpageController->CreateBodyOnAction();
    ?>
</body>

</html>