<?php
session_start();
include_once('header.php');
require_once ('libraries/Google/autoload.php');


$client = new Google_Client();
$client->setAuthConfigFile('client_secret_teachipedia.json');
$client->addScope("email");
$client->addScope("profile");
$client->setRedirectUri("http://localhost/teachipedia/login.php");

$service = new Google_Service_Oauth2($client);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	$client->setAccessToken($_SESSION['access_token']);
}

if (isset($_REQUEST['logout'])) {
	unset($_SESSION['access_token']);
	$client->revokeToken();
	header('Location: login.php');
}


if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	header('Location: login.php');
	exit;
}




if ($client->getAccessToken()) {
	error_log("User is logged in",0);
	$user = $service->userinfo->get();
	$_SESSION['access_token'] = $client->getAccessToken();
	print_r($user);
	/*CHECK USER EXISTS N ALL AND THEN LOGIN...MEANS SET SESSION FOR LOGIN AND THEN REDIRECT TO SESSION URL*/
	if(isset($_SESSION['url'])){
		$url = $_SESSION['url']; // holds url for last page visited.
	}
	else{
		$url = "index.php";
	}


	header("Location: $url");

} else {
	$authUrl = $client->createAuthUrl();
}



?>
<link href="css/sign-in-buttons.css" rel="stylesheet">
<div class="container">
	<div class="row">
    	<div class="col-lg-4 col-lg-offset-3">
			<form method=post action=userlogin.php enctype="multipart/form-data">
			
				<fieldset>
					<legend>Please login to continue</legend>
 				<fieldset class="form-group">
    				<label for="post_user">Username <span class="post_user-validation validation-error"></span></label>
   					<input type="text" name=post_user class="form-control" id=post_user placeholder="Enter username" onkeyup=validate()>
    			</fieldset>
  				<fieldset class="form-group">
    				<label for="post_pwd">Password <span class="post_pwd-validation validation-error"></span></label></label>
    				<input type="password" name=post_pwd class="form-control" id=post_pwd placeholder="Enter Password" onkeyup=validate()> 
  				</fieldset>

				<button type="submit" name=submit id=submit class="btn btn-primary" disabled="disabled">Login</button>
				<small class="text-muted">Not a member yet? <a id=register href=register.php>Register</a> now!</small>
			</fieldset>
			</form>
			<hr>
		</div>


		<div class="col-sm-4 col-sm-offset-1 social-buttons">
			<h4>OR use the following</h4>

			<a class="btn btn-block btn-social btn-facebook" href="">
				<i class="fa fa-facebook"></i> Sign in with Facebook
			</a>
			<a class="btn btn-block btn-social btn-google-plus" href="<?php echo $authUrl; ?>">
				<i class="fa fa-google-plus"></i> Sign in with Google
			</a>
		</div>

	</div>
</div>


<script>
	function validate() {
		
		var valid = true;
		valid = checkEmpty($("#post_user"));
		valid = valid && checkEmpty($("#post_pwd"));	
		$("#submit").attr("disabled",true);
		if(valid) {
			$("#submit").attr("disabled",false);
		}	
	}
	function checkEmpty(obj) {
		var name = $(obj).attr("name");
		$("."+name+"-validation").html("");	
		$(obj).css("border","");
		if($(obj).val() == "") {
			$(obj).css("border","#FF0000 1px solid");
			$("."+name+"-validation").html("Required");
			$("."+name+"-validation").css("color","red");
			return false;
		}
		
		return true;	
	}
</script>


<?php
include_once('footer.php');
?>

