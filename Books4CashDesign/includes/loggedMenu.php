<?php $username = $_SESSION['username']; ?>
<nav class="navbar navbar-default navbar-fixed-top">
        <div class="container" id ="menuContainer">
           
            <div class="navbar-header"><!-- navbar-header -->
            <ul class="nav navbar-nav navbar-left">
            <li> <form class="navbar-form" id="searchForm" action="search.php" method="get">
                    <div class="input-group">
                        
                        <input type="text" class="form-control" name="search" placeholder="Search" id="search" value="<?php 
                            if (isset($_GET['search'])) echo $_GET['search']; ?>">
                            <div class="input-group-btn">
                                 <button class="btn btn-default" type="submit" name"Search" value="Search"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                    </div>
                     <button type="button" class="navbar-btn btn btn-default hidden-xs btn-xs" id ="openCategories">Advanced Options</button><!--toggle categories-->
                    </form></li>
                     
                     
            <li>
                <button type="button" class=" navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                </li>
                <!--Site name for the upper left corner of the site -->
         </ul> 
       
            </div>
		 
            <!-- navbar-header -->
            <div class="collapse navbar-collapse" id="collapse">
                
                <ul class="nav navbar-nav navbar-right" id="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="userPage.php">Account</a></li>
                    <li><a href="#">Messages</a></li>
                    <li><a href="#" class="visible-xs">Search</a></li> 
                    <li>
                    <?php echo "<li><p class=\"navbar-text\"> Welcome, $username</p></li>"; ?>  
                    </li>
                     <li><form action="ad.php">
            <button id="postButton" class="btn btn-default navbar-btn" >Post an Ad</button>
                     </form>
                     </li>                   
                    <li>
                    <form action="includes/logout.php">
                       <button id="login-button" class="btn btn-default navbar-btn dropdown-toggle" >Log out <strong class="caret"></strong></button>
                     </form>
                    </li>      
                </ul>        
            </div><!-- collapse navbar-collapse -->
        </div><!-- container -->
    </nav>