<?php 
session_start(); 

/*
Name	: index.php
Purpose	: A php page that displays the teachipedia database from the database server. There are special funtions for the admin user and 
			privileged user.
Author	: Abhimanyu Ambastha; abhimanyu.ambastha@colorado.edu
Version : 1.0
Date	: 04/24/2016
Files   : 
		addcomments.php -  this file adds comments to the post
		addpost.html - this file renders a form to add a post
		addpost.php - this file adds a new post
		adduser.php - this file registers a new user
		checkusername.php - this file is the server side script to check username availability
		editpost.php - this file renders a form and posts to itself to edit a post
		error.php - the error page if something is not right
		footer.php - this file contains the footer html syntax
		header.php - this file contains the header html syntax
		index.php - this file which is the homepage
		login.php - renders the page for a login prompt
		logout.php - logs out the user
		lucky.php - this file handles the lucky post
		project-lib.php - this library file contains the helper functions for the main index.php file
		recentposts.php - this file sends recent posts back to the client as requested by ajax
		register.php - renders the form for a user to register
		restore.php - this file restores a post to its previous version
		searchbycategory.php - this file handles the search by category
		search.php - this file handles the search by title
		sidebar.php - includes the sidebar functions
		test.php - a file for testing cases. Used for development
		userlogin.php - this file checks if user is properly logged in and then redirects to the requesting page
		viewposthistory.php - this file shows the history for a post
		viewpost.php - this file shows a post along with its comments


*/ 




$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
include_once('header.php'); 
include_once('project-lib.php'); 
connect($db); 

//ajax to get posts dynamically
echo '


<script>
    function getresult(url) {
        $.ajax({
            url: url,
            type: "GET",
            data:  {row_count:$(".total-page").val()},
            beforeSend: function(){
            $("#loader-icon").show();
            },
            complete: function(){
            $("#loader-icon").hide();
            },
            success: function(data){
            $("#faq-result").append(data);
            },
            error: function(){}             
       });
    }

    function load_more(){
        console.log("from button");
        if($(".pagenum:last").val() < $(".total-page").val()) {
			console.log("loaded");
            var pagenum = parseInt($(".pagenum:last").val()) + 1;
            getresult("recentposts.php?page="+pagenum);
        }
        else{
			console.log("no more");
            $("#load-more").text("No more posts");
			$("#load-more-button").hide();
        }
     
        
    }


</script>
';


//search function
echo "

<script>
function showResult(str) {
	if (str.length==0) { 
		document.getElementById('livesearch').innerHTML='';
		document.getElementById('livesearch').style.border='0px';
		return;
	}
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else {  // code for IE6, IE5
		xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById('livesearch').innerHTML=xmlhttp.responseText;
			document.getElementById('livesearch').style.border='none';
		
		}
	}
	xmlhttp.open('GET','search.php?search='+str,true);
	
	xmlhttp.send();
}

</script>
";
 
 

echo '

<script type="text/javascript" src="https://code.jquery.com/jquery-1.2.6.pack.js"></script>
<script>
$(document).ready(function(){
	function getresult(url) {
		$.ajax({
			url: url,
			type: "GET",
			data:  {row_count:$(".total-page").val()},
			beforeSend: function(){
			$("#loader-icon").show();
			},
			complete: function(){
			$("#loader-icon").hide();
			},
			success: function(data){
			$("#faq-result").append(data);
			},
			error: function(){} 	        
	   });
	}
	$(window).scroll(function(){
		if ($(window).scrollTop() == $(document).height() - $(window).height()){
			if($(".pagenum:last").val() <= $(".total-page").val()) {
				var pagenum = parseInt($(".pagenum:last").val()) + 1;
				getresult("recentposts.php?page="+pagenum);
			}
		}
		
		
		
	}); 
});



</script>
	';





echo '
    <div class="container">
        <div class="row">           
            <div class="col-md-8" id="faq-result">
                <h1 class="page-header">
                   Teachipedia Latest Posts                    
                
				<small>Teach Yourself</small>
				</h1>
';
include 'recentposts.php';

echo '</div>';

include_once('sidebar.php');

echo '
        </div>
        <!-- /.row -->

        <hr>
	</div>
';

echo '
	<div class="container" id="load-more">
		<div class="row">	

        	<div class="col-md-4">
				<button id="load-more-button" type="button" class="btn btn-primary" onClick=load_more()>See older <span class="glyphicon glyphicon-chevron-down"></span></button>
			</div>
		</div>
	</div>
';







include_once('footer.php');
?>
