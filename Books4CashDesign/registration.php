<!DOCTYPE html>
<html lang="en">
 <head>
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="Stylesheet" type="text/css" href="css/style.css"/>
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
              <form role="form" id="registerForm" action="../register.php">

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
                      		<input type="checkbox" value="">
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

     <script src="js/jquery-2.2.0.min.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/script.js"></script>
     <script src="js/EffectsIndex.js"></script>

    <script>
        // Attach a submit handler to the form
        $( "#registerForm" ).submit(function( event ) {
            // Stop form from submitting normally
            event.preventDefault();

            if ($(this).find("input[name='password']").val() != $(this).find("input[name='confirm_password']").val()) {
            $(this).find("input[name='confirm_password']").removeClass('default')
            } else {
                // Get some values from elements on the page:
                var $form = $(this),
                        term = $form.find("input[name='username']").val(),
                        term2 = $form.find("input[name='password']").val(),
                        term3 = $form.find("input[name='email']").val(),
                        url = $form.attr("action");

                // Send the data using post
                var posting = $.post(url, {username: term, password: term2, email: term3});

                // Put the results in a div
                posting.done(function (data) {
                    $("#result").empty().append(data);
                });
            }

        });

    </script>
  </body>
</html>