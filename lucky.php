<?php
session_start(); 
$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
include_once('project-lib.php');
connect($db);

$query="select postid from urlname";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$post_ids);
    while(mysqli_stmt_fetch($stmt)){
        $postids[]=$post_ids;
	//	echo $post_ids;
    }
    mysqli_stmt_close($stmt);
}
//select random postid
$postid=array_rand($postids);

$query="select version from posts where postid=? order by version desc limit 1";
if($stmt=mysqli_prepare($db,$query)) {
	mysqli_stmt_bind_param($stmt,"s",$postids[$postid]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$version);
    while(mysqli_stmt_fetch($stmt)){
        $version=$version;
    }
    mysqli_stmt_close($stmt);
}


header("Location: /project/viewpost.php?p=".$postids[$postid]."&v=$version");

?>
