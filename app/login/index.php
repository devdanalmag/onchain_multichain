<?php 

    $_GET["settings"]="YES";
    
    require_once("../home/includes/route.php");

    $design = $data->logindesign;
    $color = $data->sitecolor;
    $name = $data->sitename;

    include("login".$design.".php");

?>