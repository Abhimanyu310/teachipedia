<?php
include_once('project-lib.php');
connect($db);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    error();
}

//check if username is available
$query="select userid from user where username='".$reg_user."'";
$result=num_of_rows($db,$query);

if($result != 0){
	echo "Username is not available";
}

?>
