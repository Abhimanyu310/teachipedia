<?php
session_start();
session_regenerate_id();
include_once('project-lib.php');
connect($db);

if(!isset($_SESSION['authenticated'])){
        authenticate($db,$post_user,$post_pwd);
}
checkAuth();


$query="select creatorid from posts where postid=? and version=1";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"s",$p);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$creatorid);
    while(mysqli_stmt_fetch($stmt)){
        $creatorid=$creatorid;
    }
}


//check if user has privileges

if($_SESSION['user_level'] > 2){
	if($_SESSION['userid'] != $creatorid){
		header("Location: /project/error.php");
		exit;
	}
}


$query="select max(version) from posts where postid=?";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"s",$p);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$max_version);
    while(mysqli_stmt_fetch($stmt)){
        $next_version=$max_version+1;
    }
}

$query="select postid,title,data from posts where postid=? and version=?";
if($stmt=mysqli_prepare($db,$query)){
    mysqli_stmt_bind_param($stmt,"ss",$p,$v);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$postid,$title,$data);
    while(mysqli_stmt_fetch($stmt)){
        $postid=$postid;
        $title=$title;
        $data=$data;
    }
    mysqli_stmt_close($stmt);
}


$query="insert into posts set postid=?,title=?, data=?, creatorid =?, createdtime=now(), version=?";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"sssss",$postid,$title,$data,$_SESSION['userid'],$next_version);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


header("Location: /project/viewpost.php?p=$postid&v=$next_version");

?>
