<!DOCTYPE html>
<html lang="en">
 <head>
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="Stylesheet" type="text/css" href="css/style.css"/>
    <link rel="Stylesheet" type="text/css" href="css/animate.css"/>
    <meta charset="utf-8">
    <meta name="description" content="A page for buying and selling books">
  

    <title>Books4Cash</title>
  </head>
  
  <body>
  
   <?php 
   include("includes/menu.php");
   include("includes/sidebar.php");
   ?>


     <div class="container">
       <div class="row">
          <section class="col-md-6 col-md-offset-4" id="registration">
                <h1>Register</h1>
              <form role="form" id="registerForm" action="includes/register.php">

                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" name="username" id="username">
                    </div>

                    <div class="form-group">
                      <label for="email">Email address:</label>
                      <input type="email" name="email" class="form-control" id="email">
                    </div>

                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password">
                    </div>
                  
                    <div class="form-group" id="confirmation">
                      <label for="confirm_password">Re-enter password</label>
                      <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                    </div>

                  <div class="form-group">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="terms" id="terms">
                          <p>I agree with Terms &amp; Conditions</p>
                        </label>
                      </div>
                    </div>


                       <button id="submit" type="submit" class="btn btn-default">Register</button>
                  <div id="result"></div>
              </form><!--registration form-->


          </section>

       </div>
     </div><!--registration container-->

      

      <footer>
         <address>&copy; Copyright 2016 All Rights Reserved We Hope We Pass</address>
      </footer>

     <script src="js/bootstrap/jquery-2.2.0.min.js"></script>
     <script src="js/bootstrap/bootstrap.min.js"></script>
     <script src="js/custom scripts/script.js"></script>
     <script src="js/custom scripts/EffectsIndex.js"></script>
     <script src="js/bootstrap/bootstrap-notify.min.js"></script>
     <script src="js/custom scripts/registrationScript.js"></script>

     
  </body>
</html>