<?php
session_start();
session_regenerate_id(); 
$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
include_once('header.php');
include_once('project-lib.php');
connect($db);
if(!isset($_SESSION['authenticated'])){
        authenticate($db,$post_user,$post_pwd);
}
checkAuth();
//if a=1, then post data and add to database
if($a==1){
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
   		error();
	}	
	$post_urllink=bin2hex(openssl_random_pseudo_bytes(12));
    $query="insert into urlname set urllink=?";
    if($stmt=mysqli_prepare($db,$query)) {
        mysqli_stmt_bind_param($stmt,"s",$post_urllink);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }



    $query="select postid from urlname where urllink=?";
    if($stmt=mysqli_prepare($db,$query)){
        mysqli_stmt_bind_param($stmt,"s",$post_urllink);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $last_postid);
        mysqli_stmt_fetch($stmt);
        $next_postid=$last_postid;
        mysqli_stmt_close($stmt);
    }

    $query="insert into category set postid=?, name=?";
    if($stmt=mysqli_prepare($db,$query)) {
        mysqli_stmt_bind_param($stmt,"ss",$next_postid,$post_category);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }




    $query="insert into posts set postid=?,title=?, data=?, creatorid =?, createdtime=now(), version=1";
    if($stmt=mysqli_prepare($db,$query)) {
        mysqli_stmt_bind_param($stmt,"ssss",$next_postid,$post_topic,$post_data,$_SESSION['userid']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

	header("Location: /project/viewpost.php?p=$next_postid&v=1");
}



include_once('addpost.html');

include_once('footer.php');
?>
