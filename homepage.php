	<div id='home-page'>	
<?php

echo "<hr>";

$query="select o1.postid,o1.max_version, o2.title as title_of_max, o2.data as data_of_max from 
	(select postid,max(version) as max_version from posts group by postid) as o1  
	join posts as o2 on 
	(o2.version=o1.max_version and o2.postid=o1.postid) 
	group by o1.postid order by createdtime desc limit 10";
if($stmt=mysqli_prepare($db,$query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$postid,$max_version,$title,$data);
	while(mysqli_stmt_fetch($stmt)){
		echo "<a href='viewpost.php?p=$postid&v=$max_version'>
			<div id='home-post-title".$postid."'>$title</div>
	        <div id='home-post-data".$postid."'>".substr(htmlspecialchars($data),0,100)."</div>
			</a><hr>
		
		";
	}
}

?>
	</div>
