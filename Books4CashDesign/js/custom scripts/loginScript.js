// Attach a submit handler to the form
$( "#loginForm" ).submit(function( event ) {
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        term = $form.find("input[name='username']").val(),
        term2 = $form.find("input[name='password']").val(),
        term3 = $form.find("input[name='rememberme']").val(),
        url = $form.attr("action");

    // Send the data using post
    var posting = $.post(url, {username: term, password: term2, rememberme: term3});

    posting.fail(function(n){
        $.notify({
            title: '<strong>Error!</strong>',
            message: "Unable to connect to the server.",

        }, {
            type: 'warning',
            offset: {
                x: 150,
                y: 80
            }
        });
    });

    posting.done(function (data, status, xhr) {
        if(data.success) {
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
        else if(data.error_code==1){
            $.notify({
                title: '<strong>Login Error!</strong>',
                message: 'Invalid login information.',

            },{
                type: 'danger',
                offset: {
                    x : 150,
                    y : 80
                }

            });
        }
        else if(data.error_code==2){
            $.notify({
                title: '<strong>Server Error!</strong>',
                message: data.message,

            },{
                type: 'danger',
                offset: {
                    x : 150,
                    y : 80
                }

            });
        }
        else {
            $.notify({
                title: '<strong>Apocalypse!</strong>',
                message: 'No idea but something is not working.',

            },{
                type: 'danger',
                offset: {
                    x : 150,
                    y : 80
                }

            });
        }
    });

});