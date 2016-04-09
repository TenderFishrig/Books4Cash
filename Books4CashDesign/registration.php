<!DOCTYPE html>
<html lang="en">
 <head>
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="Stylesheet" type="text/css" href="css/style.css"/>
    <link rel="Stylesheet" type="text/css" href="css/animate.css"/>
    <meta charset="utf-8">
    <meta name="description" content="A page for buying and selling books">
  

    <title>Registration</title>
  </head>
  
  <body>
  
   <?php 
   include("includes/menu.php");
   include("includes/sidebar.php");
   ?>


     <div class="container">
       <div class="row">
          <div class="panel panel-default col-lg-offset-3" id="registration" style="width: 40%">
                <div class="panel-heading">Register</div>
                  <div class="panel-body">
                  <form role="form" id="registerForm" action="includes/register.php">

                    <div class="form-group">
                      <label for="username">Username:*</label>
                      <input type="text" class="form-control" name="username" id="username">
                    </div>

                    <div class="form-group">
                      <label for="firstname">First name:</label>
                      <input type="text" class="form-control" name="firstname" id="firstname">
                    </div>


                    <div class="form-group">
                      <label for="lastname">Last name:</label>
                      <input type="text" class="form-control" name="lastname" id="lastname">
                    </div>


                    <div class="form-group">
                      <label for="city">City:</label>
                      <input type="text" class="form-control" name="city" id="city">
                    </div>

                    <div class="form-group">
                      <label for="email">Email address:*</label>
                      <input type="email" name="email" class="form-control" id="email">
                    </div>

                    <div class="form-group">
                      <label for="password">Password:*</label>
                      <input type="password" class="form-control" name="password" id="password">
                    </div>
                  
                    <div class="form-group" id="confirmation">
                      <label for="confirm_password">Re-enter password:*</label>
                      <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                    </div>

                  <div class="form-group">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="terms" id="terms">
                          <p>I agree with <a href ="#termsModal"   data-toggle="modal" data-target="#termsModal">Terms &amp; Conditions</a></p>
                        </label>
                      </div>
                    </div>

                  <!-- Modal -->
          <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="termsModal">Terms &amp; Conditions</h4>
                </div>
                <div class="modal-body">
                <p style="text-align: justify;">The correctness and accuracy of the information posted on our book advertisements is subject to, and responsibility of, the owner. Books4Cash takes no responsibility for books that are not as stated.  Sellers are not permitted to post advertisements for books that are not completely authentic to the description they have provided. This would be a breach of the site rules.
              Books4Cash have recommended a public place (i.e. the local Student Union) to make an exchange. We take no responsibility or liability for any such events that transpire at an exchange. The risk is purely in the hands of the buyer and seller.</p>

              <p style="text-align: justify;"><strong>We endeavour to keep the website up and running smoothly. However, Books4Cash takes no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control.</strong></p>

              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>             
                </div>
              </div>
            </div>
          </div>

                       <button id="submit" type="submit" class="btn btn-default">Register</button>
              </form><!--registration form-->

            </div>
          </div>

       </div>
     </div><!--registration container-->

      

      <footer>
         <address>&copy; Copyright 2016 All Rights Reserved We Hope We Pass</address>
      </footer>

     <script src="js/bootstrap/jquery-2.2.0.min.js"></script>
     <script src="js/bootstrap/bootstrap.min.js"></script>
     <script src="js/custom scripts/EffectsIndex.js"></script>
     <script src="js/bootstrap/bootstrap-notify.min.js"></script>
     <script src="js/custom scripts/registrationScript.js"></script>

     
  </body>
</html>