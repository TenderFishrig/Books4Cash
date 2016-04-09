<?php $username = $_SESSION['username']; ?>
<nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
           
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse" aria-expanded="true">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" href="#">Books4Cash</a> -->
            </div>

            <div class="navbar-collapse collapse in" id="collapse" aria-expanded="true">

                <form class="navbar-form navbar-left" id="searchForm" action="search.php" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="search" id="search">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit" name"search"="" value="Search"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
                </form>
                
                <ul class="nav navbar-nav">
                <li><button class="navbar-btn btn btn-default hidden-xs btn-xs" id="menu-toggle">Advanced Options</button></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="userPage.php">Account</a></li>
                    <li><a href="message.php">Messages</a></li>
                    <li><a href="#" class="visible-xs">Search</a></li> 
                    <li style="margin-right: 15px;">
                        <form action="ad.php">
                            <button id="postButton" class="btn btn-default navbar-btn">Post an Ad</button>
                        </form>
                    </li>                   
                    <li style="margin-right: 15px;">
                        <form action="includes/logout.php">
                            <button id="login-button" class="btn btn-default navbar-btn dropdown-toggle">Log out <strong class="caret"></strong></button>
                        </form>
                    </li>
                </ul>
            </div>

        </div><!-- container -->
    </nav>

    <script>
        $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>