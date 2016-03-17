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
                    message: 'Either server is down or database is down. Please try again later.',

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
                $('#tag'+index).prop('disabled',true);
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
