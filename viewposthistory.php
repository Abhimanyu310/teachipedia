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


//find post title and creator
$query="select title,creatorid from posts where postid=? and version=1 limit 1";
if($stmt=mysqli_prepare($db,$query)){
    mysqli_stmt_bind_param($stmt,"s",$p);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$title,$creatorid);
    while(mysqli_stmt_fetch($stmt)){
        $title=$title;
		$creatorid=$creatorid;
    }
    mysqli_stmt_close($stmt);
}


//get post history in a table
$query="select postid,data,createdtime,version from posts where postid=? order by version desc";
if($stmt=mysqli_prepare($db,$query)){
    mysqli_stmt_bind_param($stmt,"s",$p);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$postid,$data,$createdtime,$version);


echo '<div class="container">
  <div class="row">
    
        
        <div class="col-md-6 col-md-offset-3">
        <h4>Topic: '.$title.'</h4>
        <div class="table-responsive">

                
              <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead>
                   

                   <th>Last modified</th>
                    <th>Content</th>

                      <th>Edit</th>
                      
                       <th>View</th>
                   </thead>
    <tbody>
';


    while(mysqli_stmt_fetch($stmt)){
        echo '
    <tr>
   
    <td>'.$createdtime.'</td>
    <td>'.substr(strip_tags($data),0,50).'</td>

';





//check before showing these functions
if(isset($_SESSION['authenticated'])){
	if($_SESSION['userid']==$creatorid || $_SESSION['user_level']<3){


echo '    <td><a href="editpost.php?p='.$postid.'&v='.$version.'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a></td>
';


	}
	else{
echo '		<td><a title="You cannot edit this post" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a></td>
';
	}

}



echo '
    <td><a href="viewpost.php?p='.$postid.'&v='.$version.'" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-list-alt"></span></a></td>
    </tr>
    
';


    }
	echo "</tbody></table>
			</div></div></div></div>";


    mysqli_stmt_close($stmt);
}

include_once('footer.php');
?>



