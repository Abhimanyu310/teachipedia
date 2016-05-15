<?php
include_once('header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4" >
            <div class="error-template" style="text-align:center">
                <h1>
                    Oops!</h1>
                <h2>
                    There was an error!</h2>
                <div class="error-details">
                    This could be a server problem or you may not be authorized to access this page
                </div>
                <div class="error-actions" style="margin-top:15px">
                    <a href="index.php" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                        Go to homepage</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include_once('footer.php');
?>
