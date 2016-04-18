 

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

                <ul class="nav navbar-nav navbar-right" id="menuSelections">
                    <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> Home</a></li>
                    <li>
                    <form action="registration.php">
                        <button id="signup-button" class="btn btn-default navbar-btn">Sign Up</button>
                    </form>
                </li>
                    <li class="dropdown" style="margin-right: 15px;">
                    <button id="login-button" data-toggle="dropdown" class="btn btn-default navbar-btn dropdown-toggle" >Log In <strong class="caret"></strong></button>

                    <div id="logindropdown" class="dropdown-menu" style="padding: 15px;">
                        <form class="form-inline" id="loginForm" action="includes/login.php" method="post">
                           <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input class="form-control" name="username" id="login_username" type="text" placeholder="Username">
                            </div><br>
                            <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input class="form-control" name="password" id="login_password" type="password" placeholder="Password">
                            </div>
                            <input type="submit" value="Log In" name="login" class="btn custombutton">
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

     <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" id="advmodal">
                             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Advanced Search</h4>
                            </div>
                     <div class="modal-body">
                        <form class="form-horizontal" action="search.php" method="get">
                        

                        <div class="input-group adv-search" id="adv_search">
                    <input type="text" class="form-control" placeholder="Search" name="search" id="search" value="">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit" name="Search" value="<?php 
                            if (isset($_GET['search'])) echo $_GET['search']; ?>"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>


                     <div class="form-group adv-search">
                        <label class="control-label" for="email">Category:</label>
                      
                          <select name="searchCategory" id="searchCategory">
                            <option value="0">Any</option>
                         </select>
                      
                      </div>
                        
                     <div class="form-group adv-search">
                        <label class="control-label" for="searchPrice">Category:</label>
                       
                          <select name="searchPrice" id="searchPrice">
                                <option value="0">Any</option>
                                <option value="1">Less than 10</option>
                                <option value="2">Less than 30</option>
                                <option value="3">Less than 50</option>
                            </select>
                      
                      </div>


                        <div class="form-group adv-search">
                            <label class="control-label" for="searchCondition">Category:</label>
                      
                            <select name="searchCondition" id="searchCondition">
                                <option value="0">Any</option>
                                <option value="1">New</option>
                                <option value="2">Used</option>
                                <option value="3">Poor</option>
                            </select>
                           
                        </div>

                        <div class="form-group adv-search">
                            <div class="row">
                            <div class="col-sm-2">
                            <label class="control-label" for="authorSearch">Author:</label>
                            </div>
                            <div class="col-sm-10">
                            <input class="form-control" type="text" id="authorSearch" name="authorSearch">
                            </div>
                           </div>
                        </div>
                    </form>
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default custombutton" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>