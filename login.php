<?php
 
include_once('header.php');
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

			<a class="btn btn-block btn-social btn-facebook">
				<i class="fa fa-facebook"></i> Sign in with Facebook
			</a>
			<a class="btn btn-block btn-social btn-google-plus">
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

