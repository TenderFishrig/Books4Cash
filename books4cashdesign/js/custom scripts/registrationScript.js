   // Attach a submit handler to the form
        $( "#registerForm" ).submit(function( event ) {
            // Stop form from submitting normally
            event.preventDefault();
  
            if ($(this).find("input[name='username']").val().length == 0)
               $.notify({
              title: '<strong>Error!</strong>',
              message: 'Please, enter a username.',
               
              },{
               type: 'warning',
              offset: {
                  x : 150,
                  y : 200
                },
            
                     
              });
         
            
             if ($(this).find("input[name='email']").val().length == 0)
              {
                
                $.notify({
              title: '<strong>Error!</strong>',
              message: 'Please, enter an email adress.',
               
              },{
               type: 'warning',
              offset: {
                  x : 150,
                  y : 80
                }
              
              });
              }
            
             if ($(this).find("input[name='password']").val().length == 0 || $(this).find("input[name='confirm_password']").val().length == 0)
              {

                   $.notify({
              title: '<strong>Error!</strong>',
              message: 'You must choose a password.',
               
              },{
               type: 'warning',
              offset: {
                  x : 150,
                  y : 80
                }
              
              });
              }
       
         
            if ($(this).find("input[name='password']").val() != $(this).find("input[name='confirm_password']").val()) {
            $.notify({
              title: '<strong>Error!</strong>',
              message: 'Passwords do not match.',
               
              },{
               type: 'danger',
              offset: {
                  x : 150,
                  y : 80
                }
              
              });
            }

            if ($(this).find("input[name='terms']").is(":not(:checked)")) 
            {
          
            $.notify({
            
              message: 'You must agree with our Terms &amp Conditions',
               
              },{
               type: 'info',
              offset: {
                  x : 150,
                  y : 80
                }
              
              });
          }
            
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
            
         
        });

    