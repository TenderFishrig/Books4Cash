<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="Stylesheet" type="text/css" href="css/style.css"/>
    <link rel="Stylesheet" type="text/css" href="css/animate.css"/>
	  <meta charset="utf-8">
	  <meta name="description" content="A page for buying and selling books">
	

	  <title>Post an Ad</title>
  </head>
	
	<body>
		
    <?php 

   if(isset($_SESSION['username']))
    {

   include("includes/loggedMenu.php");
   	
    }

    include("includes/sidebar.php");
   ?>
       
          <header class="banner">
             <div class= "container-fluid">
             <p class="container-fluid">Books4Cash</p>
             </div>
          </header>
           

           <div class="container"><!--Ad form-->

           <div class="row">
              <section class="col-xs-6 col-md-4 col-md-offset-3">
                
               <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
           
               <div class="form-group">          
                <label for="title">Title:</label>
                <input class="form-control" type="text" id="title" name="title">
               </div>

                   <div class="form-group">
                <label for="price">Price:</label>  
                <div class="input-group">
                <input class="form-control" type="number" id="price" name="price">
                <div class="input-group-addon">£</div>
                </div>
               </div>
               
               <div class="form-group">             
                <label for="description">Description:</label></br>
                <textarea name="description" rows="5" cols='50'></textarea>
               </div>
               
               <div class="form-control-file"> 
                <label for="photo">Photo:</label>
                <input type="file" name="image" />
               </div>
              

              <div>
               <div class="form-group">  
                <label for="tag1">Tag 1:</label>
                <input class="form-control" type="text" id="tag1" maxlength="50" name="tag1">
               </div>
              
               <div class="form-group"> 
                <label for="tag2">Tag 2:</label>
                <input class="form-control" type="text" id="tag2" maxlength="50" name="tag2">
               </div>
              
               <div class="form-group"> 
                <label for="tag3">Tag 3:</label>
                <input class="form-control" type="text" id="tag3" maxlength="50" name="tag3">
               </div>
               
               <div class="form-group"> 
                <label for="tag4">Tag 4:</label>
                <input class="form-control" type="text" id="tag4" maxlength="50" name="tag4">
               </div>
               
               <div class="form-group"> 
                <label for="tag5">Tag 5:</label>
               <input class="form-control" type="text" id="tag5" maxlength="50" name="tag5">
                </div>

                </div>

                <div class="form-group">
                <input class="form-control" type="submit" name="submit" value="Submit ad!" />
                </div>

            </form>
  <?php include("includes/post.php"); ?>
            </section>
            </div>

           </div><!--Ad form-->
           
     <footer>
         <address>&copy; Copyright 2016 All Rights Reserved We Hope We Pass</address>
     </footer>

     <script src="js/bootstrap/jquery-2.2.0.min.js"></script>
     <script src="js/bootstrap/bootstrap.min.js"></script>
     <script src="js/custom scripts/script.js"></script>
     <script src="js/custom scripts/EffectsIndex.js"></script>
     <script src="js/bootstrap/bootstrap-notify.min.js"></script>

  </body>
</html>

