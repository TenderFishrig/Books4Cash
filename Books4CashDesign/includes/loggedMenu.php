<?php $username = $_SESSION['username']; ?>
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
                    <li><a href="#">Account</a></li>
                    <li><a href="#">Messages</a></li>
                    <li><a href="#" class="visible-xs">Categories</a></li> 
                    <?php echo "<li><p class=\"navbar-text\"> Welcome, $username</p></li>"; ?>                     
                    <li>
                    <form action="includes/logout.php">
                       <button id="login-button" class="btn btn-default navbar-btn dropdown-toggle" >Log out <strong class="caret"></strong></button>
                     </form>
                    </li>      
                </ul>        
            </div><!-- collapse navbar-collapse -->
        </div><!-- container -->
    </nav>