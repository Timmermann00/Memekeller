<?php
include_once '../phpClasses/cls_Autoloader.php';
 $memeheadline= filter_input(INPUT_POST,"headline",FILTER_DEFAULT);
 $memeheadline.='%';
 
 $dbconnection = new cls_DBCon();
 $res=$dbconnection->ReturnJSONForJS($memeheadline);
 echo $res;

