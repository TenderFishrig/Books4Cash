$(document).ready(function (n){
    var items="";
    $.getJSON("includes/getCategories.php",function(data){
        if(data.success) {
            items += "<option value='0'>Any</option>";
            $.each(data.data, function (index, item) {
                items += "<option value='" + item.category_id + "'>" + item.category_Description + "</option>";
            });
            $("#searchCategory").html(items);
        }
    });
});
