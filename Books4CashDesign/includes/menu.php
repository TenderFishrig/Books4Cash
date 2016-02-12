<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header"><!-- navbar-header -->
            <button class="navbar-btn btn btn-default hidden-xs" id ="openCategories">Categories</button><!--toggle categories-->
            <button type="button" class=" navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!--Site name for the upper left corner of the site -->
            <a class="navbar-brand visible-xs" href="index.php">Books4Cash </a>

        </div>

        <!-- navbar-header -->
        <div class="collapse navbar-collapse" id="collapse">

            <ul class="nav navbar-nav navbar-right" id="menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="#" class="visible-xs">Categories</a></li>
                <li>
                    <form action="registration.php">
                        <button id="signup-button" class="btn btn-default navbar-btn">Sign Up</button>
                    </form>
                </li>

                <li class="dropdown">
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
        </div><!-- collapse navbar-collapse -->
    </div><!-- container -->
</nav>

