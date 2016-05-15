<?php
session_start();
session_regenerate_id();


include_once('header.php');
include_once('project-lib.php');
connect($db);

if(!isset($_SESSION['authenticated'])){
        authenticate($db,$post_user,$post_pwd);
}
checkAuth();

if(!$_SESSION['admin']){
    error();
    exit;
}


$query="select userid,username,level from user";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt,$userid,$username,$level);


echo '<div class="container">
  <div class="row">
    
        
        <div class="col-md-6 col-md-offset-3">
        <h4>User privileges</h4>
		<form method=post action=userprivileges.php>
        <div class="table-responsive">

                
              <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead>
                   

                   <th>Username</th>
                    <th>Admin User</th>
					

                      <th>Privileges User</th>
                      <th>Normal User</th>
                       
                   </thead>
    <tbody>
';






    while(mysqli_stmt_fetch($stmt)){
        


echo '
    <tr>
   
    <td>'.$username.'</td>
    <td>
		<div class="radio">
        	<label>';
if($level=="1"){
        	   echo '	<input type="radio" name="user_level'.$userid.'" id="user_level'.$userid.'" value="admin" checked>';
        }
	else{
			echo '   <input type="radio" name="user_level'.$userid.'" id="user_level'.$userid.'" value="admin">';

}

  echo'	</label>
        </div></td>

';







echo '    <td>
<div class="radio">
            <label>';
if($level=="2"){
               echo '   <input type="radio" name="user_level'.$userid.'" id="user_level'.$userid.'" value="privileged" checked>';
        } 
    else{
            echo '   <input type="radio" name="user_level'.$userid.'" id="user_level'.$userid.'" value="privileged">';

}

          


 echo ' </label>
        </div>	
</td>
';


  



echo '
    <td>
<div class="radio">
            <label>';
               
if($level=="3"){
               echo '   <input type="radio" name="user_level'.$userid.'" id="user_level'.$userid.'" value="normal" checked>';
        } 
    else{
            echo '   <input type="radio" name="user_level'.$userid.'" id="user_level'.$userid.'" value="normal">';

}


           echo ' </label>
        </div>

</td>
    </tr>
  <input type=hidden name=userid value='.$userid.'>  
';











}
    echo "</tbody></table>

            </div></form></div></div></div>";

    mysqli_stmt_close($stmt);
}










include_once('footer.php');

?>
