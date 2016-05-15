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


//delete from posts
$query="delete from posts where postid=?";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"s",$p);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//delete from comments
$query="delete from comment where postid=?";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"s",$p);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//delete from category
$query="delete from category where postid=?";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"s",$p);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


//delete from urlname
$query="delete from urlname where postid=?";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"s",$p);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: index.php");

?>
