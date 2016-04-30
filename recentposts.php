<?php
require_once('project-lib.php');
connect($db);

$max_posts=4;

$sql="select o1.postid,o1.max_version, o2.title as title_of_max, o2.data as data_of_max from 
    (select postid,max(version) as max_version from posts group by postid) as o1  
    join posts as o2 on 
    (o2.version=o1.max_version and o2.postid=o1.postid) 
    group by o1.postid order by createdtime desc";



$current_page=1;
if(!empty($page)){
	$current_page=$page;
}

$start=($current_page-1)*$max_posts;
if($start<0){
	$start=0;
}

if(empty($row_count)){
    $row_count=num_of_rows($db,$sql);
}




$query="select user.username,posts.postid from posts,user where posts.creatorid=user.userid and version=1";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$creator_user,$postid);
    while(mysqli_stmt_fetch($stmt)){
        $creator[intval($postid)]=$creator_user;
    }
    mysqli_stmt_close($stmt);
}








$query=$sql." limit ".$start.",".$max_posts;
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$postid,$max_version,$title,$data);
	$pages=ceil($row_count/$max_posts);
	$output='';
	$output.='<input type="hidden" class="pagenum" value="'.$current_page.'"><input type="hidden" class="total-page" value="'.$pages.'">';
	while(mysqli_stmt_fetch($stmt)){
        $output.='
            <h2>
                    <a href="/project/viewpost.php?p='.$postid.'&v='.$max_version.'">'.$title.'</a>
                </h2>
                <p class="lead">
                    by '.$creator[intval($postid)].'
                </p>
                
               
                <p>'.substr(strip_tags($data),0,200).'</p>
                <a class="btn btn-primary" href="/project/viewpost.php?p='.$postid.'&v='.$max_version.'">
					Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>



			';
    }



}
//sleep(1);
print $output;
?>
