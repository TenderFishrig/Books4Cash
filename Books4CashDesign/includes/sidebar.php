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
                    </form>
                </div> 
     
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->