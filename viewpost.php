<?php
session_start(); 
$_SESSION['url'] = $_SERVER['REQUEST_URI']; 

include_once('project-lib.php');
include_once('header.php');
connect($db);



//if no such post, then error
$k=num_of_rows($db,"select max_version from version where postid=$p");

if($k == 0){
    header("Location: error.php");
    exit;
}
if(!$v) {

    $query = "select max_version from version where postid=$p";
    if ($stmt = mysqli_prepare($db, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $p);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $version);
        while (mysqli_stmt_fetch($stmt)) {
            $v = $version;
            $max_version=$version;
        }
        mysqli_stmt_close($stmt);
    }
}





$query = "select postid,title,data,version from posts where postid=? and version=?";
if ($stmt = mysqli_prepare($db, $query)) {
    mysqli_stmt_bind_param($stmt, "ss", $p, $v);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $postid, $title, $data, $version);
    while (mysqli_stmt_fetch($stmt)) {
        $postid = $postid;
        $title = $title;
        $data = $data;
        $version = $version;
    }
    mysqli_stmt_close($stmt);
}


if ($v) {
    $query = "select max(version) from posts where postid=?";
    if ($stmt = mysqli_prepare($db, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $postid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $max_version);
        while (mysqli_stmt_fetch($stmt)) {
            $postid = $postid;
            $max_version = $max_version;
        }
        mysqli_stmt_close($stmt);
    }
}

$query="select user.username,user.userid from posts,user where posts.creatorid=user.userid and postid=? and version=1";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"s",$postid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$creator,$creatorid);
    while(mysqli_stmt_fetch($stmt)){
        $creator=$creator;
		$creatorid=$creatorid;
    }
	mysqli_stmt_close($stmt);
}




$query="select user.username,posts.createdtime from posts,user where posts.version=? and posts.postid=? and posts.creatorid=user.userid";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"ss",$max_version,$postid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$modified_by,$modified_at);
    while(mysqli_stmt_fetch($stmt)){
        $modified_by=$modified_by;
		$modified_at=$modified_at;
    }
	mysqli_stmt_close($stmt);
}





echo '

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>


<script src="https://apis.google.com/js/platform.js" async defer></script>


<div class="container">

        <div class="row">

            
            <div class="col-lg-8">

                

                <h1>'.$title.'</h1>

               
                <p class="lead">
                    by '.$creator.'
';					
//check user privileges before showing these functions
if(isset($_SESSION['authenticated'])){
	echo ' <a href="viewposthistory.php?p='.$postid.'" class="btn btn-info">View Edit History</a>';

	if($_SESSION['userid']==$creatorid || $_SESSION['user_level']<3){

					echo '				
					<a href="editpost.php?p='.$postid.'&v='.$version.'" class="btn btn-info">Edit Post</a>';
					if ($version!=$max_version){
    					echo '
						 <a href="restorepost.php?p='.$postid.'&v='.$version.'" class="btn btn-info">Restore this version</a>';
					}

		if($_SESSION['admin']){
			echo '              
                    <a href="deletepost.php?p='.$postid.'" class="btn btn-danger">Delete Post</a>';
		}
	}
}
$fb_share='https://www.facebook.com/dialog/share?appId=641730879263211&href=http://ec2-52-39-86-99.us-west-2.compute.amazonaws.com/teachipedia/viewpost.php?p='.$postid.'&v='.$max_version;
$google_share='https://plus.google.com/share?url=http://ec2-52-39-86-99.us-west-2.compute.amazonaws.com/teachipedia/viewpost.php?p='.$postid.'&v='.$max_version;
		echo '
                </p>

                <hr>

                
                <p><span class="glyphicon glyphicon-time"></span> Last modified by '.$modified_by.' on '.$modified_at.'</p>
                
                <hr>
                
                
                 <p> <a href='.$fb_share.' onclick="javascript:window.open(this.href,
  \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;" title="Share to Facebook"><img
  src="http://www.randomgoat.com/images/facebook-tab.png" alt="Share on Google+"/></a>
                
                <a href='.$google_share.' onclick="javascript:window.open(this.href,
  \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;" title="Share to Google+"><img
  src="https://www.gstatic.com/images/icons/gplus-32.png" alt="Share on Google+"/></a></p>

                
                

  
  

  
  

  
  


 
  
                <hr>



                <hr>

                
                <p>'.$data.'</p>

                <hr>
';

if(isset($_SESSION['authenticated'])){
echo '
                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method=post action=addcomments.php>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" name=post_comment></textarea>
                        </div>
						<input type=hidden name=p value='.$postid.'><input type=hidden name=v value='.$version.'>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>
';
}
else{
echo '			<div class=well><h4>Please <a href=login.php>login</a> to post comments</h4></div>
';
}

$query="select comment.id,comment.comments,comment.time,user.username from comment,user where user.userid=comment.userid  and postid=? order by comment.time desc";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"s",$postid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$commentid,$comment,$time,$user);
    while(mysqli_stmt_fetch($stmt)){
      
echo '
            

                <!-- Comment -->
                <div class="media">
                    <div class="media-body">
                       	 <h4 class="media-heading">'.$user.'
                            <small>'.$time.'</small> 
';


if($_SESSION['admin']){
echo '							<small><a href="deletecomment.php?p='.$postid.'&c='.$commentid.'">Delete comment</a></small>';

}

echo '
                        </h4>
				'.$comment.'
                </div></div>';

    }
    mysqli_stmt_close($stmt);
}


             
echo '
          </div>

';

include_once('sidebar.php');

echo "</div></div>";



include_once('footer.php');

?>

