<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Adminview | Memekeller</title>
        <link rel="stylesheet" href="../CSS_Files/AdminViewStyling.css" type="text/css">
        <link rel="icon" type="image/x-icon" href="../MemeData/Logo/MemekellerLogo.jpg" />
        <script src="https://use.fontawesome.com/fe459689b4.js"></script>
    <script async src='/cdn-cgi/bm/cv/669835187/api.js'></script></head>
    <body>
       <?php
        include_once '../phpClasses/cls_Autoloader.php';
        cls_SessionHandling::start();  
        $controller=new cls_AdminViewControler();
        echo $controller->CreateBodyOnAction();
       ?>
    </body>
</html>