<?php
session_start();
include_once('project-lib.php');
connect($db);


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    error();
}


$new_user=mysqli_real_escape_string($db,$reg_user);
$new_pwd=mysqli_real_escape_string($db,$reg_pwd);
$new_email=mysqli_real_escape_string($db,$reg_email);
$new_salt=bin2hex(openssl_random_pseudo_bytes(32));
$epass=hash('sha256',$new_pwd.$new_salt);
$query="insert into user set username=?,email=?,password=?,salt=?,level=3";
if($stmt=mysqli_prepare($db,$query)){
	mysqli_stmt_bind_param($stmt,"ssss",$new_user,$new_email,$epass,$new_salt);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}
else{echo "ERROR";}

header("Location: login.php");






?>
