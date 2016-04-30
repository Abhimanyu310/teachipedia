<?php
session_start();
//include_once('/var/www/html/hw9/hw9-lib.php');
//include_once('project-lib.php');
//connect($db);


include_once('project-lib.php');
connect($db);


$data='

<p>The American Civil War, widely known in the United States as simply the Civil War as well as other names, was a civil war fought from 1861 to 1865 to determine the survival of the Union or independence for the Confederacy.</p>


<img src="http://cdn.historynet.com/wp-content/uploads/2012/11/633x284xBattleOfCorinth.jpg.pagespeed.ic.D4sD0AZNCG.jpg">
<p><a href="https://en.wikipedia.org/wiki/American_Civil_War">Reference</a></p>

';
$new_data=strip_user_data($data);
echo $new_data;

/*echo $post_user,$post_pwd;
var_dump($_SESSION);


if(!isset($_SESSION['authenticated'])){
        authenticate($db,$post_user,$post_pwd);
}
checkAuth();
if(isset($_SESSION['url'])) 
   $url = $_SESSION['url']; // holds url for last page visited.
else 
   $url = "/project"; 
echo $url;
//header("Location: $url"); 

//$query="select * from category where id=0";
$query="select userid from user where username='admin'";
$k=num_of_rows($db,$query);
echo $k;

//var_dump(parse_url('https://100.66.1.53/project/viewpost/testpage'));

/*$input = array("Neo", "Morpheus", "Trinity", "Cypher", "Tank");
$rand_keys = array_rand($input);
echo $input[$rand_keys] . "\n";
echo "<hr>";

echo bin2hex(openssl_random_pseudo_bytes(5));
echo "row count".$row_count;
if(empty($row_count)){echo "EMPTY";}


error_log($post_user,0);
error_log($post_pwd,0);*/
//authenticate($db,$post_user,$post_pwd);

//var_dump($_SESSION);



/*$query="select user.username,posts.postid from posts,user where posts.creatorid=user.userid and version=1";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$creator,$postid);
    while(mysqli_stmt_fetch($stmt)){
        $creator_user[intval($postid)]=$creator;
    }
    mysqli_stmt_close($stmt);
}







else { echo "ERROR";}


echo "<br> here".$creator_user[2]."<hr>";
function tp(){
	return array("a","b");
}

list($a,$b)=tp();
echo $a,$b;

echo `whoami`;
//error_log("Test",0);
//error_log("Test\n\n",3,"/tmp/test.log");
//mail('abhip310@gmail.com','Test','Sup');
*/


/*
$subject = 'subject';
$message = 'message';
$to = 'abhip310@gmail.com';
$type = 'plain'; // or HTML
$charset = 'utf-8';

$mail     = 'no-reply@'.str_replace('www.', '', $_SERVER['SERVER_NAME']);
$uniqid   = md5(uniqid(time()));
$headers  = 'From: '.$mail."\r\n";
$headers .= 'Reply-to: '.$mail."\r\n";
$headers .= 'Return-Path: '.$mail."\r\n";
$headers .= 'Message-ID: <'.$uniqid.'@'.$_SERVER['SERVER_NAME'].">\r\n";
$headers .= 'MIME-Version: 1.0'."\r\n";
$headers .= 'Date: '.gmdate('D, d M Y H:i:s', time())."\r\n";
$headers .= 'X-Priority: 3'."\r\n";
$headers .= 'X-MSMail-Priority: Normal'."\r\n";
$headers .= 'Content-Type: multipart/mixed;boundary="----------'.$uniqid.'"'."\r\n";
$headers .= '------------'.$uniqid."\r\n";
$headers .= 'Content-type: text/'.$type.';charset='.$charset.''."\r\n";
$headers .= 'Content-transfer-encoding: 7bit';

if(!mail($to, $subject, $message, $headers)){
	echo "ERROR";
}
*/

/*
$To = 'abhip310@gmail.com'; 
$Subject = 'Send Email'; 
$Message = 'This example demonstrates how you can send plain text email with PHP'; 
$Headers = "From: sender@yourdomain.com \r\n" . 
"Reply-To: sender@yourdomain.com \r\n" . 
"Content-type: text/html; charset=UTF-8 \r\n"; 
  
if(!mail($To, $Subject, $Message, $Headers)){
	echo "ERROR";
}*/





/*$html = "<html><body><h1>COME ON</h1><p>Work or not</p><p>ok</p></body></html>";
echo "<br>this here<br>";
echo strip_tags($html,'<html><body><h1>');
echo "<br>now using func<br>";
$html = strip_user_data($html);*/
//echo strip_tags($html);
//echo "<p>".$html."</p>";
/*echo "<br>";
$new_salt=bin2hex(openssl_random_pseudo_bytes(32));
echo $new_salt."new salt";
echo "<br>";
$new_pwd="3120";
echo hash('sha256',$new_pwd.$new_salt)

*/
?>
