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


//delete comment
$query="delete from comment where id=?";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"s",$c);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: ".$_SESSION['url']."");
//header("Location: /project/viewpost.php?p=$postid&v=$next_version");



?>
