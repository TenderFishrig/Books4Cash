var originalData;

function AllInputsFilled() {
    return $("input[name*='tag']", $("#advertUpdateForm")).filter(function() {
            return $(this).val().trim() === "";
        }).size() === 0;
}

function AdditionEvent() {
    if (AllInputsFilled()) {
        AddInput();
    }
}

$("input", $("#advertUpdateForm")).bind("keyup", function(){ AdditionEvent()});

$(document).ready(function (n){
    var items="";
    $.getJSON("includes/getCategories.php",function(data){
        if(data.success) {
            $.each(data.data, function (index, item) {
                if(item.advert_id!=1)
                    items += "<option value='" + item.category_id + "'>" + item.category_Description + "</option>";
            });
            $("#category").html(items);
            updateView();
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

function updateView (){
    $('#tagSpace input[name!="tag0"]').next().remove();

    originalData=new Array();
    var formData = new FormData();

    formData.append("advert_id",($( "#advert_id" ).val()));

    var posting = $.ajax({
        url: "includes/getAdvertData.php",
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'json'
    });
    posting.done(function(data){
        $('#advertUpdateForm').trigger("reset");
        if(data.success) {
            $.each(data.tags, function (index,item) {
                $('#tag'+index).val(item);
                if($('#tag'+(index+1)).val()==undefined)
                    AddInput();
            });
            $( "#title" ).val(data.advert_data.advert_bookname);
            originalData["title"]=data.advert_data.advert_bookname;
            $( "#author" ).val(data.advert_data.advert_bookauthor);
            originalData["author"]=data.advert_data.advert_bookauthor;
            $( "#description" ).val(data.advert_data.advert_description);
            originalData["description"]=data.advert_data.advert_description;
            $( "#price" ).val(data.advert_data.advert_price);
            originalData["price"]=data.advert_data.advert_price;
            $( "#category" ).val(data.advert_data.advert_category);
            originalData["category"]=data.advert_data.advert_category;
            $( "#condition" ).val(data.advert_data.advert_condition);
            originalData["condition"]=data.advert_data.advert_condition;
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
    });
    posting.fail(function(n){
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
    });
}

function AddInput() {
    var cnt = $("input[name*='tag']", $("#advertUpdateForm")).size();
    $("<div class='form-group'><label for='tag"+cnt+"'>Tag "+(cnt+1)+":</label><input class='form-control' type='text' maxlength='50' name='tag" + cnt+ "' id='tag" + cnt+ "' /></div>").insertAfter("#advertUpdateForm input[name*='tag']:last");
    $("input", $("#advertUpdateForm")).unbind("keyup").bind("keyup", function(){ AdditionEvent() });
}

// Attach a submit handler to the form
$( "#advertUpdateForm" ).submit(function( event ) {
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
        formData.append("advert_id",($( "#advert_id" ).val()));

        if($('input[type=file]')[0].files[0]!=null) {
            formData.append('image', $('input[type=file]')[0].files[0]);
        }

        var tags = $("input[name*='tag']").map(function() {
            return this.value ? this.value : null;
        }).get();
        // Get some values from elements on the page:

        if ($(this).find("input[name='author']").val().length != 0 && $(this).find("input[name='author']").val()!=originalData['author']) {
            formData.append('author',$(this).find("input[name='author']").val());
        }

        if($(this).find("input[name='title']").val()!=originalData['title'])
            formData.append('title',$(this).find("input[name='title']").val());
        if($(this).find("input[name='price']").val()!=originalData['price'])
            formData.append('price',$(this).find("input[name='price']").val());
        if($(this).find("textarea[name='description']").val()!=originalData['description'])
            formData.append('description',$(this).find("textarea[name='description']").val());
        formData.append('tags[]',tags);
        formData.append('category',$( "#category option:selected" ).val());
        formData.append('condition',$( "#condition option:selected" ).val());

        // Send the data using post
        var posting = $.ajax({
            url: "includes/updateAdvertData.php",
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'json'
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
                    message: 'Advert was successfully updated.'

                }, {
                    type: 'success',
                    offset: {
                        x: 150,
                        y: 80
                    }
                });
                setTimeout( updateView(),  1000);
            }
            else {
                if($.inArray(1, data.error_code) != -1){
                    $.notify({
                        title: '<strong>Login Error!</strong>',
                        message: 'Please login to edit ads.'

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
                        title: '<strong>Error updating advert.</strong>',
                        message: 'Please try again later.'

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
                        title: '<strong>Error updating advert.</strong>',
                        message: 'Invalid advert id.'

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

