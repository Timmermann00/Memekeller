<?php

include_once '../phpClasses/cls_Autoloader.php';
 $memeid= filter_input(INPUT_POST,"bildId",FILTER_VALIDATE_INT);
 $options=array("options"=>array("default"=>-1,"min_range"=>-1,"max_range"=>1));
 $useraction = filter_input(INPUT_POST,"review",FILTER_VALIDATE_INT,$options);
 
 $dbconnection = new cls_DBCon();
 $res=$dbconnection->InsertUserRating($memeid, $useraction);
 echo $res;
 
 

