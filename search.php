<?php
include_once('project-lib.php');
connect($db);

$result="";
if(preg_match("/[A-Z  | a-z | 0-9]+/", $search)){ 
	$query="select postid,max(version),title from posts where title like '%".$search."%' group by title order by createdtime";
	if($stmt=mysqli_prepare($db,$query)){
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$postid,$version,$title);
		while(mysqli_stmt_fetch($stmt)){
			if($result==""){
				$result="<a href='viewpost.php?p=$postid&v=$version'>$title</a>";	
			}
			else{
				$result=$result."<br><a href='viewpost.php?p=$postid&v=$version'>$title</a>";
			}
		}
		mysqli_stmt_close($stmt);
	}

}

if ($result==""){
	$result="no suggestions";
}
echo $result;


?>
