 

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
                <li><button type="button" class="navbar-btn btn btn-default hidden-xs btn-xs" id="openCategories">Advanced Options</button></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">Home</a></li>
                    <li>
                    <form action="registration.php">
                        <button id="signup-button" class="btn btn-default navbar-btn">Sign Up</button>
                    </form>
                </li>
                    <li class="dropdown" style="margin-right: 15px;">
                    <button id="login-button" data-toggle="dropdown" class="btn btn-default navbar-btn dropdown-toggle" >Log In <strong class="caret"></strong></button>

                    <div id="logindropdown" class="dropdown-menu" style="padding: 15px;">
                        <form class="form-inline" id="loginForm" action="includes/login.php" method="post">
                            <div class="form-group">
                                <label for="login_username">Username:</label>
                                <input class="form-control" name="username" id="login_username" type="text" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="login_password">Password:</label>
                                <input class="form-control" name="password" id="login_password" type="password" placeholder="Password">
                            </div>
                            <input type="submit" value="Log In" name="login" id="custombutton" class="btn">
                            <div class="form-group">
                                <label><input type="checkbox" name="rememberme"> Remember me</label>
                                <div id="result"></div>
                            </div>

                        </form><!--login form-->
                        <script src="js/bootstrap/jquery-2.2.0.min.js"></script>
                        <script src="js/custom scripts/loginScript.js"></script>
                        <script src="js/bootstrap/bootstrap-notify.min.js"></script>
                    </div>
                </li><!--Login dropdown-->
                   
                </ul>
            </div>

        </div><!-- container -->
    </nav>