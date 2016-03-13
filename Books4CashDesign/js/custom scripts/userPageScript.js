var originalData;

function updateView (n){
    originalData=new Array();
    $.getJSON("includes/getUserData.php",function(data){
        $('#dataUpdateForm').trigger("reset");
        if(data.success) {
            $.each(data.data, function (index, item) {
                $('#'+index).val(item);
                originalData[index]=item;
            });
        }
        else{

            $.notify({
                title: '<strong>Error!</strong>',
                message: 'Database is down. Please try again later.'

            }, {
                type: 'warning',
                offset: {
                    x: 150,
                    y: 80
                }
            });

        }
    }).fail(function(n){
        $.notify({
            title: '<strong>Error!</strong>',
            message: 'Server is down. Please try again later.'

        }, {
            type: 'warning',
            offset: {
                x: 150,
                y: 80
            }
        });
    });}

$(document).ready(updateView());

$( "#dataUpdateForm" ).submit(function( event ) {
    // Stop form from submitting normally
    event.preventDefault();

    var validator=true;

    if ($(this).find("input[name='password']").val().length < 6  && $(this).find("input[name='password']").val().length!=0) {

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

    if(validator) {
        var updateSecondary = false;
        var formData = new FormData();
        if ($("#dataUpdateForm").find("input[name='firstname']").val().length > 0 &&
            originalData['firstname'] != $("#dataUpdateForm").find("input[name='firstname']").val()) {
            formData.append('firstname', $("#dataUpdateForm").find("input[name='firstname']").val());
            updateSecondary = true;
        }

        if ($("#dataUpdateForm").find("input[name='surname']").val().length > 0 &&
            originalData['surname'] != $("#dataUpdateForm").find("input[name='surname']").val()) {
            formData.append('surname', $("#dataUpdateForm").find("input[name='surname']").val());
            updateSecondary = true;
        }

        if ($("#dataUpdateForm").find("input[name='city']").val().length > 0 &&
            originalData['city'] != $("#dataUpdateForm").find("input[name='city']").val()) {
            formData.append('city', $("#dataUpdateForm").find("input[name='city']").val());
            updateSecondary = true;
        }
        if (updateSecondary) {
            var posting = $.ajax({
                url: "includes/additionalUserInfo.php",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json'
            });

            posting.fail(function (n) {
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

            posting.done(function (moredata) {
                if (moredata.success) {
                    updateView();
                    $.notify({
                        title: '<strong>Success!</strong>',
                        message: 'Secondary data updated successfully.'

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
                        moredata.error_code.splice($.inArray(1, moredata.error_code), 1);
                    }
                }
            });
        }

        formData = new FormData();
        var updateImportant=false;
        if($( "#dataUpdateForm" ).find("input[name='password']").val().length>0){
            formData.append('new_password',$( "#dataUpdateForm" ).find("input[name='password']").val());
            updateImportant=true;
        }

        if($( "#dataUpdateForm" ).find("input[name='email']").val().length>0  &&
            originalData['email']!=$( "#dataUpdateForm" ).find("input[name='email']").val()){
            formData.append('email',$( "#dataUpdateForm" ).find("input[name='email']").val());
            updateImportant=true;
        }
        if(updateImportant) {
            formData.append('password', $("#dataUpdateForm").find("input[name='old_password']").val());

            posting = $.ajax({
                url: "includes/updateImportant.php",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json'
            });

            posting.fail(function (n) {
                $.notify({
                    title: '<strong>Error!</strong>',
                    message: "Unable to update password and/or email. Please try again later."

                }, {
                    type: 'warning',
                    offset: {
                        x: 150,
                        y: 80
                    }
                });
            });

            posting.done(function (moredata) {
                if (moredata.success) {
                    updateView();
                    $.notify({
                        title: '<strong>Success!</strong>',
                        message: 'Password and email info was updated.'

                    }, {
                        type: 'success',
                        offset: {
                            x: 150,
                            y: 80
                        }
                    });
                }
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
                    moredata.error_code.splice($.inArray(1, moredata.error_code), 1);
                }
                if ($.inArray(2, moredata.error_code) != -1) {
                    $.notify({
                        title: '<strong>Error!</strong>',
                        message: 'Please provide your password or login.'

                    }, {
                        type: 'warning',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                    moredata.error_code.splice($.inArray(2, moredata.error_code), 1);
                }
                if ($.inArray(3, moredata.error_code) != -1) {
                    $.notify({
                        title: '<strong>Incorrect password!</strong>',
                        message: 'You have provided incorrect password. Please try again.'

                    }, {
                        type: 'warning',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                    moredata.error_code.splice($.inArray(3, moredata.error_code), 1);
                }
                if ($.inArray(4, moredata.error_code) != -1) {
                    $.notify({
                        title: '<strong>Invalid new password!</strong>',
                        message: 'New password you selected is to short.'

                    }, {
                        type: 'warning',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                    moredata.error_code.splice($.inArray(4, moredata.error_code), 1);
                }
                if ($.inArray(5, moredata.error_code) != -1) {
                    $.notify({
                        title: '<strong>Invalid new email!</strong>',
                        message: 'New email you selected is not valid.'

                    }, {
                        type: 'warning',
                        offset: {
                            x: 150,
                            y: 80
                        }

                    });
                    moredata.error_code.splice($.inArray(5, moredata.error_code), 1);
                }
            });
        }
    }
});