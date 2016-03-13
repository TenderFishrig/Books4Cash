// Attach a submit handler to the form
$( "#registerForm" ).submit(function( event ) {
    // Stop form from submitting normally
    event.preventDefault();

    var validator=true;

    if ($(this).find("input[name='username']").val().length == 0) {
        $.notify({
            title: '<strong>Error!</strong>',
            message: 'Please, enter a username.'

        }, {
            type: 'warning',
            offset: {
                x: 150,
                y: 80
            }
        });
        validator=false;
    }


    if ($(this).find("input[name='email']").val().length == 0) {

        $.notify({
            title: '<strong>Error!</strong>',
            message: 'Please, enter an email adress.'

        }, {
            type: 'warning',
            offset: {
                x: 150,
                y: 80
            }

        });
        validator=false;
    }

    if ($(this).find("input[name='password']").val().length < 6) {

        $.notify({
            title: '<strong>Error!</strong>',
            message: 'Password is too short! Please select password with 6 or more characters.'

        }, {
            type: 'warning',
            offset: {
                x: 150,
                y: 80
            }

        });
        validator=false;
    }


    if ($(this).find("input[name='password']").val() !== $(this).find("input[name='confirm_password']").val()) {
        $.notify({
            title: '<strong>Error!</strong>',
            message: 'Passwords do not match.'

        }, {
            type: 'danger',
            offset: {
                x: 150,
                y: 80
            }

        });
        validator=false;
    }

    if ($(this).find("input[name='terms']").is(":not(:checked)")) {

        $.notify({

            message: 'You must agree with our Terms &amp Conditions'

        }, {
            type: 'info',
            offset: {
                x: 150,
                y: 80
            }

        });
        validator=false;
    }

    if(validator) {
        // Get some values from elements on the page:

        var $form = $(this),
            term = $form.find("input[name='username']").val(),
            term2 = $form.find("input[name='password']").val(),
            term3 = $form.find("input[name='email']").val(),
            url = $form.attr("action");

        // Send the data using post
        var posting = $.post(url, {username: term, password: term2, email: term3});

        posting.fail(function(n){
            $.notify({
                title: '<strong>Error!</strong>',
                message: "Unable to connect to the server."

            }, {
                type: 'warning',
                offset: {
                    x: 150,
                    y: 80
                }
            });
        });

        posting.done(function (data) {
            if (data.success) {

                var formData = new FormData();

                if($( "#registerForm" ).find("input[name='firstname']").val().length>0){
                    formData.append('firstname',$( "#registerForm" ).find("input[name='firstname']").val());
                }

                if($( "#registerForm" ).find("input[name='lastname']").val().length>0){
                    formData.append('surname',$( "#registerForm" ).find("input[name='lastname']").val());
                }

                if($( "#registerForm" ).find("input[name='city']").val().length>0){
                    formData.append('city',$( "#registerForm" ).find("input[name='city']").val());
                }

                var posting =$.ajax({
                    url: "includes/additionalUserInfo.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType: "json"
                });

                posting.fail(function(n){
                    $.notify({
                        title: '<strong>Error!</strong>',
                        message: "Unable to update additional user data. Please try again later."

                    }, {
                        type: 'warning',
                        offset: {
                            x: 150,
                            y: 80
                        }
                    });
                });

                posting.done(function(moredata){
                    if(moredata.success) {
                        setTimeout(function () {
                            document.location.assign("./index.php");
                        }, 2000);
                        $.notify({
                            title: '<strong>Success!</strong>',
                            message: 'Page will be refreshed shortly.'

                        }, {
                            type: 'success',
                            offset: {
                                x: 150,
                                y: 80
                            }
                        });

                    }
                    else {
                        if ($.inArray(1, moredata.error_code) != -1) {
                            $.notify({
                                title: '<strong>Server Error!</strong>',
                                message: 'Server was unable to record additional user data.' +
                                'Please try again later'

                            }, {
                                type: 'warning',
                                offset: {
                                    x: 150,
                                    y: 80
                                }

                            });
                            moredata.error_code.splice( $.inArray(1,moredata.error_code) ,1 );
                        }
                    }
                });

            }
            else {
                if ($.inArray(1, data.error_code) != -1) {
                    $.notify({
                        title: '<strong>Invalid Username!</strong>',
                        message: 'Username already in use.'

                    }, {
                        type: 'warning',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                    data.error_code.splice( $.inArray(1,data.error_code) ,1 );
                }
                if ($.inArray(2, data.error_code) != -1) {
                    $.notify({
                        title: '<strong>Invalid Email!</strong>',
                        message: 'Email already in use.'

                    }, {
                        type: 'warning',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                    data.error_code.splice( $.inArray(2,data.error_code) ,1 );
                }
                if ($.inArray(3, data.error_code) != -1) {
                    $.notify({
                        title: '<strong>Server error!</strong>',
                        message: data.message

                    }, {
                        type: 'danger',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                    data.error_code.splice( $.inArray(3,data.error_code) ,1 );
                }
                if ($.inArray(4, data.error_code) != -1) {
                    $.notify({
                        title: '<strong>Apocalypse!</strong>',
                        message: 'No idea but something is not working.'

                    }, {
                        type: 'danger',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                    data.error_code.splice( $.inArray(4,data.error_code) ,1 );
                }
                if(data.error_code.length!=0){
                    $.notify({
                        title: '<strong>Undefined Error!</strong>',
                        message: 'You should not see this!'

                    }, {
                        type: 'danger',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                }
            }
        });
    }
});