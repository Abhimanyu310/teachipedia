<?php
include_once('project-lib.php');
connect($db);


$query="select category.postid,title from category,posts where category.name=? and category.postid=posts.postid";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_bind_param($stmt,"s",$category);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$postid,$title);
    while(mysqli_stmt_fetch($stmt)){
		$post_ids[]=$postid;
		$titles[intval($postid)]=$title;
	}
}

$query="select postid,max(version),title from posts group by title";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$postid,$title);
    while(mysqli_stmt_fetch($stmt)){
        $post_ids[]=$postid;
        $titles[intval($postid)]=$title;
    }
}


echo '
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <h2>
                        Search results for category <span class="text-navy">"Category"</span>
                    </h2>

        

                    <div class="hr-line-dashed"></div>
                    <div class="search-result">
                        <h3><a href="#">Bootdey</a></h3>
                        <a href="#" class="search-link">www.bootdey.com</a>
                        <p>

                        </p>
                    </div>

                    <div class="hr-line-dashed"></div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>


';


?>
