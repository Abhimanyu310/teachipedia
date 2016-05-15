<?php
session_start();
session_regenerate_id();

include_once('header.php');
include_once('project-lib.php');
connect($db);

if(!isset($_SESSION['authenticated'])){
        authenticate($db,$post_user,$post_pwd);
}
checkAuth();

if(!$_SESSION['admin']){
    error();
    exit;
}





header("Location: admindashboard.php");



?>

