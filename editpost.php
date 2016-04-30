<?php
session_start();
session_regenerate_id();
include_once('project-lib.php');
include_once('header.php');
connect($db);


if(!isset($_SESSION['authenticated'])){
        authenticate($db,$post_user,$post_pwd);
}
checkAuth();


$query="select creatorid from posts where postid=? and version=1";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"s",$p);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$creatorid);
    while(mysqli_stmt_fetch($stmt)){
        $creatorid=$creatorid;
    }
}
//check user privilege
if($_SESSION['user_level'] > 2){
    if($_SESSION['userid'] != $creatorid){
        header("Location: /project/error.php");
        exit;
    }
}



//if a=2, then edit the post
if($a==2){
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    	error();
	}
    $query="select postid,max(version),title from posts where postid=?";
    if($stmt=mysqli_prepare($db,$query)) {
        mysqli_stmt_bind_param($stmt,"s",$p);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$postid,$max_version,$title);
        while(mysqli_stmt_fetch($stmt)){
            $postid=$postid;
            $version=$max_version+1;
			$title=$title;
        }
    }


    $query="insert into posts set postid=?,title=?, data=?, creatorid =?, createdtime=now(), version=?";
    if($stmt=mysqli_prepare($db,$query)) {
        mysqli_stmt_bind_param($stmt,"sssss",$p,$title,$edit_data,$_SESSION['userid'],$version);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
/*    $query="update urlname set urllink=? where postid=?";
    if($stmt=mysqli_prepare($db,$query)){
            mysqli_stmt_bind_param($stmt,"ss",$edit_urllink,$p);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
*/
	header("Location: /project/viewpost.php?p=$p&v=$version");

}



//render the form to edit the post


$query="select postid,title,data,version from posts where postid=? and version=?";
if($stmt=mysqli_prepare($db,$query)){
    mysqli_stmt_bind_param($stmt,"ss",$p,$v);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$postid,$title,$data,$version);
    while(mysqli_stmt_fetch($stmt)){
        $postid=$postid;
        $title=$title;
        $data=$data;
		$version=$version;
    }
    mysqli_stmt_close($stmt);
}

$query="select urllink from urlname where postid=?";
if($stmt=mysqli_prepare($db,$query)){
    mysqli_stmt_bind_param($stmt,"s",$p);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$urllink);
    while(mysqli_stmt_fetch($stmt)){
        $urllink=$urllink;
    }
    mysqli_stmt_close($stmt);
}


$query="select name from category where postid=?";
if($stmt=mysqli_prepare($db,$query)){
    mysqli_stmt_bind_param($stmt,"s",$p);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$category);
    while(mysqli_stmt_fetch($stmt)){
        $category=$category;
    }
    mysqli_stmt_close($stmt);
}




echo '



<div class="container">
    <div class="row">
        <form method=post action=editpost.php?a=2>
        <div class="col-lg-8">


                <fieldset class="form-group">
                    <label for="edit_topic">Topic</label>
                    <input type="text" name=edit_topic id=edit_topic class="form-control" value="'.$title.'" disabled>
                    <small class="text-muted">You cannot change the name of the post.</small>
                </fieldset>


                <fieldset class="form-group">
                    <label for="edit_data">Edit the content</label>
                    <textarea class="form-control" name=edit_data id="edit_data" rows="15">'.htmlspecialchars($data).'</textarea>
               

                </fieldset>


        </div>

        <div class="col-md-4">



<div class="form-group">
                                    <label>Category</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="post_category" id="post_category1" value="option1" disabled>Science
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="post_category" id="post_category2" value="option2" disabled>Geography
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="post_category" id="post_category3" value="option3" disabled>History
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="post_category" id="post_category4" value="option4" disabled>Literature
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="post_category" id="post_category5" value="option5" disabled>Computer Science
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="post_category" id="post_category6" value="option6" disabled>Miscellaneous
                                        </label>
                                    </div>
                                </div>


                <button type="submit" name=submit id=submit class="btn btn-primary">Save</button>






        </div>
    <input type=hidden name=p value='.$postid.'><input type=hidden name=v value='.$version.'>

            </form>

    </div>
</div>

';

echo "<script>";
if($category == "Science"){echo 'document.getElementById("post_category1").checked = true;';}
elseif($category == "Geography"){echo 'document.getElementById("post_category2").checked = true;';}
elseif($category == "History"){echo 'document.getElementById("post_category3").checked = true;';}
elseif($category == "Literature"){echo 'document.getElementById("post_category4").checked = true;';}
elseif($category == "Computer Science"){echo 'document.getElementById("post_category5").checked = true;';}
else{echo 'document.getElementById("post_category6").checked = true;';}

echo "</script>";



echo '

<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script>
        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
</script>



';




include_once('footer.php');
?>


