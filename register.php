<?php
include_once('header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <form method=post action=adduser.php>
                <fieldset class="form-group">
                    <label for="reg_user">Username <span class="reg_user-validation validation-error" id="user-availability-status"></span></label>
                    <input type="text" name=reg_user id=reg_user class="form-control" placeholder="Enter username" onkeyup=validate()>
					<small class="text-muted">Enter a unique username</small>
                </fieldset>
                <fieldset class="form-group">
                    <label for="reg_pwd">Password <span class="reg_pwd-validation validation-error"></span></label>
                    <input type="password" name=reg_pwd id="reg_pwd" class="form-control" placeholder="Enter password" onkeyup=validate()>
					<small class="text-muted">Must be at least 6 characters</small>

                </fieldset>
                <fieldset class="form-group">
                    <label for="reg_pwdconfirm">Confirm Password <span class="reg_pwdconfirm-validation validation-error"></span></label>
                    <input type="password" name=reg_pwdconfirm class="form-control" id="reg_pwdconfirm" placeholder="Enter password again" onkeyup=validate()>
                </fieldset>
                <fieldset class="form-group">
                    <label for="reg_email">Email address <span class="reg_email-validation validation-error"></span></label>
                    <input type="text" name=reg_email class="form-control" id="reg_email" placeholder="Enter email" onkeyup=validate()>
                    <small class="text-muted">Must be valid. We'll never share your email with anyone</small>
                </fieldset>


                <button type="submit" name=submit id=submit class="btn btn-primary" disabled="disabled">Register now</button>
            </form>

        </div>
    </div>
</div>



<script>
	//validate user input
    function validate() {
        
        var valid = true;
        valid = checkEmpty($("#reg_user"));
        valid = valid && checkEmpty($("#reg_pwd"));
		valid = valid && checkPwd($("#reg_pwd"));
		valid = valid && pwdMatch($("#reg_pwdconfirm"));
		valid = valid && checkEmail($("#reg_email"));    
		checkAvailability();
		
        $("#submit").attr("disabled",true);
       
		 if(valid) {
            $("#submit").attr("disabled",false);
        }   
    }


	//check if username available using ajax	
	function checkAvailability() {
		jQuery.ajax({
			url: "checkusername.php",
			data:'reg_user='+$("#reg_user").val(),
			type: "POST",
			success:function(data){
				if(data=="Username is not available"){
					$("#submit").attr("disabled",true);
					
				}
				$("#user-availability-status").html(data);
				$("#user-availability-status").css("color","red");
				$("#user-availability-status").css("border","red");
			},
			error:function (){}
		});
	}


//check if email is valid using regex
function checkEmail(obj) {
		var result = true;
		
		var name = $(obj).attr("name");
		$("."+name+"-validation").html("");	
		$(obj).css("border","");
		
		result = checkEmpty(obj);
		
		if(!result) {
			$(obj).css("border","#FF0000 1px solid");
			$("."+name+"-validation").html("Required");
			return false;
		}
		
		var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,3})+$/;
		result = email_regex.test($(obj).val());
		
		if(!result) {
			$(obj).css("border","#FF0000 1px solid");
			$("."+name+"-validation").html("Invalid");
			return false;
		}
		
		return result;	
	}


//check if both passwords match
	function pwdMatch(obj){
		var name = $(obj).attr("name");
        $("."+name+"-validation").html(""); 
        $(obj).css("border","");
		if(($(obj)).val() != ($("#reg_pwd")).val()){
            $(obj).css("border","#FF0000 1px solid");
            $("."+name+"-validation").html("Passwords do not match!");
            $("."+name+"-validation").css("color","red");
            return false;
		}
		return true;

	
	}		
//check if empty
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
//check password length
	function checkPwd(obj){
		var name = $(obj).attr("name");
        $("."+name+"-validation").html(""); 
        $(obj).css("border","");
		if(($(obj)).val().length < 6){
			
            $(obj).css("border","#FF0000 1px solid");
            $("."+name+"-validation").html("Must be at least 6 characters");
            $("."+name+"-validation").css("color","red");

			return false;
		}
		return true;
}
</script>









<?php
include_once('footer.php');
?>
