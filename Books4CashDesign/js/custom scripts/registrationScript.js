// Attach a submit handler to the form
$( "#registerForm" ).submit(function( event ) {
    // Stop form from submitting normally
    event.preventDefault();

    var validator=true;

    if ($(this).find("input[name='username']").val().length == 0) {
        $.notify({
            title: '<strong>Error!</strong>',
            message: 'Please, enter a username.',

        }, {
            type: 'warning',
            offset: {
                x: 150,
                y: 80
            },


        });
        validator=false;
    }


    if ($(this).find("input[name='email']").val().length == 0) {

        $.notify({
            title: '<strong>Error!</strong>',
            message: 'Please, enter an email adress.',

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
            message: 'Password is too short! Please select password with 6 or more characters.',

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
            message: 'Passwords do not match.',

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

            message: 'You must agree with our Terms &amp Conditions',

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

        // Put the results in a div
        posting.done(function (data) {
            if (data.success) {
                setTimeout(function () {
                    document.location.assign("./index.php");
                }, 2000);
                $.notify({
                    title: '<strong>Success!</strong>',
                    message: 'I\'m so impressed.',

                }, {
                    type: 'success',
                    offset: {
                        x: 150,
                        y: 80
                    }
                });
            }
            else {
                if ($.inArray(1, data.error_code) != -1) {
                    $.notify({
                        title: '<strong>Invalid Username!</strong>',
                        message: 'Username already in use.',

                    }, {
                        type: 'warning',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                }
                if ($.inArray(2, data.error_code) != -1) {
                    $.notify({
                        title: '<strong>Invalid Email!</strong>',
                        message: 'Email already in use.',

                    }, {
                        type: 'warning',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                }
                if ($.inArray(3, data.error_code) != -1) {
                    $.notify({
                        title: '<strong>Server error!</strong>',
                        message: data.message,

                    }, {
                        type: 'danger',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                }
                if ($.inArray(4, data.error_code) != -1) {
                    $.notify({
                        title: '<strong>Apocalypse!</strong>',
                        message: 'No idea but something is not working.',

                    }, {
                        type: 'danger',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                }
                if(data.error_code.length!=0){
                    $.notify({
                        title: '<strong>Undefined Error!</strong>',
                        message: 'You should not see this!',

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