
function AllInputsFilled() {
    return $("input[name*='tag']", $("#postForm")).filter(function() {
            return $(this).val().trim() === "";
        }).size() === 0;
}

function AdditionEvent() {
    if (AllInputsFilled()) {
        AddInput();
    }
}

$(document).ready(function (n){
    var items="";
    $.getJSON("includes/getCategories.php",function(data){
        if(data.success) {
            $.each(data.data, function (index, item) {
                if(item.advert_id!=1)
                items += "<option value='" + item.category_id + "'>" + item.category_Description + "</option>";
            });
            $("#category").html(items);
        }
        else{
            if ($(this).find("input[name='title']").val().length == 0) {
                $.notify({
                    title: '<strong>Error!</strong>',
                    message: 'Either server is down or database is down. Please try again later.'

                }, {
                    type: 'warning',
                    offset: {
                        x: 150,
                        y: 80
                    }


                });
            }
        }
    });
});

function AddInput() {
    var cnt = $("input[name*='tag']", $("#postForm")).size() + 1;
    $("<div class='form-group'><label for='tag"+cnt+"'>Tag "+cnt+":</label><input class='form-control' type='text' maxlength='50' name='tag" + cnt+ "' id='tag" + cnt+ "' /></div>").insertAfter("#postForm input[name*='tag']:last");
    $("input", $("#postForm")).unbind("keyup").bind("keyup", function(){ AdditionEvent() });
}

$("input", $("#postForm")).bind("keyup", function(){ AdditionEvent() });

// Attach a submit handler to the form
$( "#postForm" ).submit(function( event ) {
    // Stop form from submitting normally
    event.preventDefault();

    var validator=true;

    if ($(this).find("input[name='title']").val().length == 0) {
        $.notify({
            title: '<strong>Error!</strong>',
            message: 'Please, enter a title.'

        }, {
            type: 'warning',
            offset: {
                x: 150,
                y: 80
            }


        });
        validator=false;
    }


    if ($(this).find("input[name='price']").val().length == 0) {

        $.notify({
            title: '<strong>Error!</strong>',
            message: 'Please, enter price.'

        }, {
            type: 'warning',
            offset: {
                x: 150,
                y: 80
            }

        });
        validator=false;
    }

    if ($(this).find("textarea[name='description']").val().length == 0) {

        $.notify({
            title: '<strong>Error!</strong>',
            message: 'Please, enter a description.'

        }, {
            type: 'warning',
            offset: {
                x: 150,
                y: 80
            }

        });
        validator=false;
    }

    if(validator) {

        var formData = new FormData();
        //TODO add support for multiple files and checks
        formData.append('image', $('input[type=file]')[0].files[0]);

        var tags = $("input[name*='tag']").map(function() {
            return this.value ? this.value : null;
        }).get();
        // Get some values from elements on the page:
        var url = $(this).attr("action");

        if ($(this).find("input[name='author']").val().length != 0) {
            formData.append('author',$(this).find("input[name='author']").val());
        }

        formData.append('title',$(this).find("input[name='title']").val());
        formData.append('price',$(this).find("input[name='price']").val());
        formData.append('description',$(this).find("textarea[name='description']").val());
        formData.append('tags[]',tags);
        formData.append('category',$( "#category option:selected" ).val());
        formData.append('condition',$( "#condition option:selected" ).val());

        // Send the data using post
        var posting =$.ajax({
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: "json"
        });

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

        // Put the results in a div
        posting.done(function (data) {
            if (data.success) {
                $.notify({
                    title: '<strong>Success!</strong>',
                    message: data.message

                }, {
                    type: 'success',
                    offset: {
                        x: 150,
                        y: 80
                    }
                });
            }
            else {
                if($.inArray(1, data.error_code) != -1){
                    $.notify({
                        title: '<strong>Login Error!</strong>',
                        message: 'Please login to post ads.'

                    },{
                        type: 'danger',
                        offset: {
                            x : 150,
                            y : 80
                        }

                    });
                    data.error_code.splice( $.inArray(1,data.error_code) ,1 );
                }
                if($.inArray(2, data.error_code) != -1){
                    $.notify({
                        title: '<strong>Invalid data.</strong>',
                        message: 'Please fill all mandatory fields.'

                    },{
                        type: 'danger',
                        offset: {
                            x : 150,
                            y : 80
                        }

                    });
                    data.error_code.splice( $.inArray(2,data.error_code) ,1 );
                }
                if($.inArray(3, data.error_code) != -1){
                    $.notify({
                        title: '<strong>Error adding advert.</strong>',
                        message: 'Please try again later.'

                    },{
                        type: 'danger',
                        offset: {
                            x : 150,
                            y : 80
                        }

                    });
                    data.error_code.splice( $.inArray(3,data.error_code) ,1 );
                }
            }

        });
    }
});
