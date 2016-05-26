<?php

isset($_REQUEST['s']) ? $s = strip_tags($_REQUEST['s']) : $s = "";
isset($_REQUEST['p']) ? $p = strip_tags($_REQUEST['p']) : $p = "";
isset($_REQUEST['c']) ? $c = strip_tags($_REQUEST['c']) : $c = "";
isset($_REQUEST['v']) ? $v = strip_tags($_REQUEST['v']) : $v = "";
isset($_REQUEST['a']) ? $a = strip_tags($_REQUEST['a']) : $a = "";
isset($_REQUEST['page']) ? $page = strip_tags($_REQUEST['page']) : $page = "";
isset($_REQUEST['row_count']) ? $row_count = strip_tags($_REQUEST['row_count']) : $row_count = "";
isset($_REQUEST['search']) ? $search = strip_tags($_REQUEST['search']) : $search = "";
isset($_REQUEST['post_topic']) ? $post_topic = strip_tags($_REQUEST['post_topic']) : $post_topic = "";
isset($_REQUEST['post_data']) ? $post_data = strip_user_data($_REQUEST['post_data']) : $post_data = "";
isset($_REQUEST['post_urllink']) ? $post_urllink = strip_tags($_REQUEST['post_urllink']) : $post_urllink = "";
isset($_REQUEST['post_category']) ? $post_category = strip_tags($_REQUEST['post_category']) : $post_category = "";
isset($_REQUEST['post_comment']) ? $post_comment = strip_tags($_REQUEST['post_comment']) : $post_comment = "";
isset($_REQUEST['edit_topic']) ? $edit_topic = strip_tags($_REQUEST['edit_topic']) : $edit_topic = "";
isset($_REQUEST['edit_data']) ? $edit_data = strip_user_data($_REQUEST['edit_data']) : $edit_data = "";
isset($_REQUEST['edit_urllink']) ? $edit_urllink = strip_tags($_REQUEST['edit_urllink']) : $edit_urllink = "";
isset($_REQUEST['post_user']) ? $post_user = strip_tags($_REQUEST['post_user']) : $post_user = "";
isset($_REQUEST['post_pwd']) ? $post_pwd = strip_tags($_REQUEST['post_pwd']) : $post_pwd = "";
isset($_REQUEST['post_email']) ? $post_email = strip_tags($_REQUEST['post_email']) : $post_email = "";
isset($_REQUEST['new_user']) ? $new_user = strip_tags($_REQUEST['new_user']) : $new_user = "";
isset($_REQUEST['new_pwd']) ? $new_pwd = strip_tags($_REQUEST['new_pwd']) : $new_pwd = "";
isset($_REQUEST['new_email']) ? $new_email = strip_tags($_REQUEST['new_email']) : $new_email = "";
isset($_REQUEST['uid']) ? $uid = strip_tags($_REQUEST['uid']) : $uid = "";
isset($_REQUEST['update_pwd']) ? $update_pwd = strip_tags($_REQUEST['update_pwd']) : $update_pwd = "";
isset($_REQUEST['reg_user']) ? $reg_user = strip_tags($_REQUEST['reg_user']) : $reg_user = "";
isset($_REQUEST['reg_pwd']) ? $reg_pwd = strip_tags($_REQUEST['reg_pwd']) : $reg_pwd = "";
isset($_REQUEST['reg_email']) ? $reg_email = strip_tags($_REQUEST['reg_email']) : $reg_email = "";




$white_list=array(
1 => "198.18.0.154" 
);


function strip_user_data($html){
	$white_list_tags=array("html","body","br","hr","h1","p","pre","img","h2","h3","h4","h5","a","b","i","u","table","tr","td","th","caption","li","ol","ul");
	$dom = new DOMDocument();
	$dom->loadHTML($html);
	$dom_elements = $dom->getElementsByTagName('*');
	$remove = [];
	foreach($dom_elements as $item){
		if(!in_array($item->nodeName,$white_list_tags)){
		$remove[] = $item;
		}
	}	
	foreach ($remove as $item){
		$item->parentNode->removeChild($item);
	}
/*	$html = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));
	
*/	//$html = $dom->saveHTML();
	return $html;
}





function check_if_empty($a){
	if(empty($a)){
		
		header("Location: login.php");
		exit;
	}
}

function in_white_list($ip){
	if(in_array($ip, $GLOBALS['white_list'])){

		return True;
	}
	return False;


}

function time_before($db, $time_interval){ // check arbitrary intervals
	if($stmt = mysqli_prepare($db,"select date_sub(now(), INTERVAL 1 HOUR)")){
		mysqli_stmt_execute($stmt);
	    mysqli_stmt_bind_result($stmt,$time_before);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	
		return $time_before;
	}
}


function failed_logins($db, $from_time){
	$query="select count(*) as num from login where ip=? and action=? and date>? group by ip";
    if($stmt = mysqli_prepare($db,$query)){
		$action="Fail";
    	mysqli_stmt_bind_param($stmt,"sss",$_SERVER['REMOTE_ADDR'],$action,$from_time);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$failed_attempts);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);

		return $failed_attempts;

	}
}	



function allow_login($userid,$email,$level){
	session_regenerate_id();
	$_SESSION['userid']=$userid;
	$_SESSION['email']=$email;
	$_SESSION['authenticated']="yes";
	$_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
	$_SESSION['HTTP_USER_AGENT']=md5($_SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT']);
	$_SESSION['created']=time();
	$_SESSION['last_activity']=time();
	$_SESSION['user_level']=$level;
	if($level==1){
		$_SESSION['admin']=True;
	}
	else{
		$_SESSION['admin']=False;
	}


}



function check_password($db,$user,$pass){

	list($db_userid,$db_password,$db_salt,$db_email,$level) = password_user_info($db,$user);
	
	$epass=hash('sha256',$pass.$db_salt);

	if($epass == $db_password){

		allow_login($db_userid,$db_email,$level);
		log_to_db($db,"Success",$user);
	}
	else{

		log_to_db($db,"Fail",$user);
		$msg="***ERROR*** Teachipedia App has a failed login attemp from ".$_SERVER['REMOTE_ADDR']." by user ".$user;
		error_log($msg,0);
		login();
		exit;
	}

}

function password_user_info($db,$user){
	$query="select userid,email,password,salt,level from user where username=?";
	if($stmt = mysqli_prepare($db,$query)){
		mysqli_stmt_bind_param($stmt,"s",$user);
 		mysqli_stmt_execute($stmt);	
  		mysqli_stmt_bind_result($stmt,$userid,$email,$password,$salt,$level);
		while(mysqli_stmt_fetch($stmt)){
			$userid=$userid;
			$password=$password;
			$salt=$salt;
			$email=$email;
			$level=$level;
		}
		mysqli_stmt_close($stmt);
		return array($userid,$password,$salt,$email,$level);
	}

}

/*authenticate a user and create its session object*/
function authenticate($db,$postUser,$postPass){


	# do not proceed if username is blank
	check_if_empty($postUser);

	# check if ip in whitelist
	$allow=in_white_list($_SERVER['REMOTE_ADDR']);

	# if not in whitelist, check for no of failed logins in last hour and block if >5
	if(!$allow){

		$last_hour = time_before($db, "1 HOUR");

		$failed_attempts = failed_logins($db,$last_hour);
		if($failed_attempts>5){

			header("Location: login.php");
			exit;
		}
	}
	
	check_password($db,$postUser,$postPass);
}




function log_to_db($db,$result,$postUser) { // log the logins to db
	$query="insert into login set ip=?,date=now(),user=?,action=?";
	if($stmt = mysqli_prepare($db,$query)){
		mysqli_stmt_bind_param($stmt,"sss",$_SERVER['REMOTE_ADDR'],$postUser,$result);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	


} 


function connect(&$db){  //connect to the db
    $mycnf="/etc/teachipedia.conf";
   // $mycnf="/etc/projectssl-mysql.conf";
	//$mycnf="/etc/hw9-mysql.conf";
    /*if(!file_exists($mycnf)){
        echo "Error file not found: $mycnf";
    }*/

    $mysql_ini_array=parse_ini_file($mycnf);
    $db_host=$mysql_ini_array["host"];
    $db_user=$mysql_ini_array["user"];
    $db_pass=$mysql_ini_array["pass"];
    $db_port=$mysql_ini_array["port"];
    $db_name=$mysql_ini_array["dbName"];
    $db = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

    if(!$db) {
        print "Error connecting to DB: " . mysqli_connect_error();
        exit;
    }

    /*$db=mysqli_init();
	//$db_sslca='etc/mysql-ssl/ca.pem';
    $db_sslkey='/etc/mysql-ssl/client-key.pem';
    $db_sslcert='/etc/mysql-ssl/client-cert.pem';
	//$db_ssl='/etc/mysql-ssl';
    mysqli_ssl_set($db,$db_sslkey,$db_sslcert,NULL,NULL,NULL);
    mysqli_real_connect($db,$db_host,$db_user,$db_pass,$db_name,$db_port);
    if(mysqli_connect_errno()){
        print "DB Error: " . mysqli_connect_error();
        exit;

    }*/
}


/*returns the number of rows in a query result*/
function num_of_rows($db,$query){
	if($result = mysqli_query($db, $query)){

    /* determine number of rows result set */
    $no_of_rows = mysqli_num_rows($result);

    /* close result set */
    mysqli_free_result($result);
	return $no_of_rows;

	}
}










/*Check if properly authenticated and no attempt to hack a session is made*/
function checkAuth(){
	/*Check if the user agent and server address is same as used to log in*/
	check_http_user_agent();

	/*Check if the remote address is same*/
	check_remote_address();


	/*Check if session timed out after 30 mins*/
	check_timeout();


	/*Check that the request is not from a phishing site*/
//	check_request_method();


	$_SESSION['last_activity']=time();
}


function icheck($i) { //Check for numeric
	if ($i != null) {
		if(!is_numeric($i)) {
			logout();
			//error() and log to error
			print "<b> ERROR: </b> 
			Invalid Syntax.";
			exit;
		}
	}
}


function check_http_user_agent(){
	if(isset($_SESSION['HTTP_USER_AGENT'])){
		if($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
		
			logout();
		}
	
	}
	else {

		logout();
	}
}

function check_remote_address(){
	if(isset($_SESSION['ip'])){
		if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){error_log("3",0);

			logout();
		}
	}
	else {

		logout();
	}
}

function check_timeout(){
	if(isset($_SESSION['last_activity'])){
		if(time() - $_SESSION['last_activity'] > 1800) {


			logout();
		}
	}
	else {


		logout();
	}
}

/*function check_request_method(){
	if(isset($_SERVER["REQUEST_METHOD"])){
		if(isset($_SERVER["HTTP_REFERER"])){
			$origin = "https://100.66.1.53";
			if(substr($_SERVER["HTTP_REFERER"],0,strlen($origin)) != $origin){


				logout();
			}
		}
		else {

			logout();
		}
	}
	else {

		logout();
	}
}
*/




function error() { // logs out the user
	header("Location: error.php");
	exit;
}

function login() {
	header("Location: login.php");
}

function logout() { // logs out the user
	header("Location: logout.php");
}


?>
