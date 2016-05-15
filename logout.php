<?php
session_start();

if(isset($_SESSION['authenticated'])){
	session_destroy();
	}
if(isset($_SESSION['url'])){
	$url = $_SESSION['url']; // holds url for last page visited.
}
else{
   	$url = "index.php";
}

header("Location: $url");



?>

