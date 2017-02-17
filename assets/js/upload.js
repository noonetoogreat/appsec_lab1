$(document).ready(function () {
    "use strict";
    $("#submit").click(function () {

        var photo = $('#photo').prop('files')[0];
        var photocomment = $("#photocomment").val();
        var photoname = $("#photoname").val();
        var token = $("#token").val();

        var form_data = new FormData();                  
        form_data.append('photo', photo);
            form_data.append('photoname', photoname);
            form_data.append('photocomment', photocomment);
            form_data.append('token', token);

        if (photoname === "") {
            $("#message").html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please enter the filename and select a file to upload.</div>');
        } else {

            $.ajax({
                type: "POST",
                url: "api/checkupload.php",
                data: form_data,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (html) {
                    console.log(html);
                    $("#message").html(html.response);
                    if (html.response_status === true) {
                        $("#success-image").attr("src", 'tmp/' + html.image);
                    } 
                },
                error: function (textStatus, errorThrown) {
                    console.log(textStatus);
                    console.log(errorThrown);
                },
                beforeSend: function () {
                    $("#message").html("<p class='text-center'><img src='assets/images/ajax-loader.gif'></p>");
                }
            });
        }
        
        return false;
    });
});
