    <script>
	//code for search function
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
//to get results for a search
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

            $('#livesearch').css({display:'block'});
        
        }
    }
    xmlhttp.open('GET','search.php?search='+str,true);
    
    xmlhttp.send();
}


    </script>


    

            <!-- Blog Entries Column -->
            <div class="col-md-4">

                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class=form-control placeholder="Search" onkeyup="showResult(this.value)">
                        
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    
                    </div>
                    <div id="livesearch" style="padding:10px;width:100%;height:100%;margin:0 auto;overflow:auto;display:none"></div>
                   
                </div>


                <div class="well">
                    <h4>Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Science</a>
                                </li>
                                <li><a href="#">Geography</a>
                                </li>
                                <li><a href="#">History</a>
                                </li>
                          
                            </ul>
                        </div>
                       
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Literature</a>
                                </li>
                                <li><a href="#">Computer Science</a>
                                </li>
                                <li><a href="#">Miscellaneous</a>
                                </li>
                                
                               
                            </ul>
                        </div>
                  
                    </div>
                  
                </div>


                <div class="thumbnail well well-sm">
                    <h4>Stay Updated</h4>

                    <p>Subscribe to our weekly emails and stay updated with all the latest posts!</p>

                    <form action="" method="post" role="form">
                        <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                      </span>
                            <input class="form-control" type="text" id="" name="" placeholder="your@email.com">
                        </div>

                        <input type="submit" value="Subscribe" class="btn btn-large btn-primary" />
                    </form>
                </div>



            </div>
      

