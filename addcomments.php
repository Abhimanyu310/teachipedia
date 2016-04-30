<?php
session_start();
session_regenerate_id();
$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
include_once('project-lib.php');
connect($db);

//check if request is post
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    error();
}

//authentication is required
if(!isset($_SESSION['authenticated'])){
        authenticate($db,$post_user,$post_pwd);
}
checkAuth();

//add comment
$query="insert into comment set postid=?,comments=?,userid=?,time=now()";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"sss",$p,$post_comment,$_SESSION['userid']);
    mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

//redirect to the post
header("Location: /project/viewpost.php?p=$p&v=$v");


?>
