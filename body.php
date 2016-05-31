</head>



<body>

<!-- Navigation -->
<nav id="navbar" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Teachipedia</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav" style="float:none;">
                <li>
                    <a href="addpost.php">Add a post</a>
                </li>
                <li>
                    <a href="lucky.php" title="View a random post">Feeling lucky</a>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">More<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="about.php">About</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                        <li><a href="#contact">Contact</a></li>

                    </ul>
                </li>


                <?php

                if(isset($_SESSION['authenticated'])){


                    echo "              <li class=logout id=logout style=\"float:right;\">
                        <a  href=\"logout.php\">Logout</a>
                    </li>
";
                    if($_SESSION['admin']){

                        echo "<li class=admin id=admin style=\"float:right;\">
                        <a  href=\"admindashboard.php\">Admin Dashboard</a>
                    </li>

		";
                    }

                }
                else{

                    echo "              <li class=login id=login style=\"float:right;\">
                        <a  href=\"login.php\">Login</a>
                    </li>
                    <li class=register id=register style=float:right;>
                        <a href=\"register.php\">Register</a>
                    </li>
                  
";}

                ?>

            </ul>

        </div>

    </div>

</nav>

