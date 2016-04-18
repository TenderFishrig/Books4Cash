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
                <li><button class="navbar-btn btn btn-default hidden-xs btn-xs" data-toggle="modal" data-target="#myModal">Advanced Options</button></li>
                </ul>

                <ul class="nav navbar-nav navbar-right" id="menuSelections">
                   
                   <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> Home</a></li>
                    <li><a href="userPage.php"><i class="glyphicon glyphicon-user"></i> Account</a></li>
                    <li><a href="message.php"><i class="glyphicon glyphicon-envelope"></i> Messages</a></li>
                   
                       <li> <form action="ad.php">
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