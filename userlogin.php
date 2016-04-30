<?php
session_start();

include_once('project-lib.php');
connect($db);

if(!isset($_SESSION['authenticated'])){
        authenticate($db,$post_user,$post_pwd);
}
checkAuth();
if(isset($_SESSION['url'])){
	$url = $_SESSION['url']; // holds url for last page visited.
}
else{
   	$url = "/project";
}
header("Location: $url"); 













?>
