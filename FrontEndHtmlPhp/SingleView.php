<?php
include_once '../phpClasses/cls_Autoloader.php';

cls_SessionHandling::start();
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Singleview | Memekeller</title>
    <link rel="stylesheet" href="../CSS_Files/SingleViewStyling.css?x=4" type="text/css" />
    <link rel="icon" type="image/x-icon" href="../MemeData/Logo/MemekellerLogo.jpg" />
    <script type="text/javascript" src="../JS_Files/LikeDislikeBtn.js"></script>
    <script src="https://use.fontawesome.com/fe459689b4.js"></script>
</head>

<body>
    <?php
    $controller = new cls_SingleViewController();
    echo $controller->CreateBodyOnAction();
    ?>
    <script>
        AddEvents();
        CheckForReviewStatus();
    </script>
</body>

</html>