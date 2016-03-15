<!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav" id="toggle">
           
                <li class="sidebar-brand">
                   
                </li>
                <li>
                 <div id="form">
                    
                    <form action="search.php" method="get">
                        <label for="search">Enter your search term</label>
                        <input type="text" name="search" id="search" value="<?php 
                            if (isset($_GET['search'])) echo $_GET['search']; ?>">
                        <input type="submit" name="Search" value="Search">

                        <div class="form-group">
                            <label for="searchCategory">Category:</label>
                            <select name="searchCategory" id="searchCategory">
                                <option value="0">Any</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="searchPrice">Category:</label>
                            <select name="searchPrice" id="searchPrice">
                                <option value="0">Any</option>
                                <option value="1">Less than 10</option>
                                <option value="2">Less than 30</option>
                                <option value="3">Less than 50</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="searchCondition">Category:</label>
                            <select name="searchCondition" id="searchCondition">
                                <option value="0">Any</option>
                                <option value="1">New</option>
                                <option value="2">Used</option>
                                <option value="3">Poor</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="authorSearch">Author:</label>
                            <input class="form-control" type="text" id="authorSearch" name="authorSearch">
                        </div>
                    </form>
                </div> 
     
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
        <script src="js/bootstrap/jquery-2.2.0.min.js"></script>
        <script src="js/custom scripts/getCategories.js"></script>