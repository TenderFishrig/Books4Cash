function deleteAdvert(n){
    var formData = new FormData();
    formData.append("advert_id",n);

    var posting = $.ajax({
        url: "includes/deleteAdvert.php",
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'json'
    });

    posting.fail(function (n) {
        $.notify({
            title: '<strong>Error!</strong>',
            message: "Unable to update server data."

        }, {
            type: 'warning',
            offset: {
                x: 150,
                y: 80
            }
        });
    });

    posting.done(function (moredata) {
        if (moredata == 0) {
            $( "#book"+n).empty();
            $.notify({
                title: '<strong>Success!</strong>',
                message: 'Advert was deleted.'

            }, {
                type: 'success',
                offset: {
                    x: 150,
                    y: 80
                }
            });
        }
        else {
            $.notify({
                title: '<strong>Error!</strong>',
                message: "Unable to update server data."

            }, {
                type: 'warning',
                offset: {
                    x: 150,
                    y: 80
                }
            });
        }
    });
}
