$(document).ready(function () {
    // AJAX call to load the user's images
    $.ajax({
        type: "GET",
        url: "api/getownimages.php",
        dataType: 'JSON',
        success: function (html) {
            if (html.response_status === true) {
                $("#message").html("");
                if (html.count == 0) {
                    $("#message").html("");
                    $("#content").html("<h2>No image uploaded yet</h2>");
                    return true;
                }
                var row_count = 0;
                var i = 0;
                var content = "";
                for (i = html.response.length - 1; i >= 0; i--) {
                    content += '\
                    <div class="row">\
                        <div class="col-md-offset-3 col-md-6 portfolio-item">\
                            <a href="">\
                                <img class="img-responsive" src="'+ html.response[i]['url'] +'" alt="">\
                            </a>\
                            <br/>\
                            <p class="lead">' + html.response[i]['comment'] + '</p>\
                            <p><div class="delete-button btn btn-primary" data-delete="' + html.response[i]['filename'] + '" role="button">Delete</div>\
                            <br>\
                            <br>\
                            <textarea name="recomment" id="recomment" type="text" class="form-control comment-image-'+ i +'" placeholder="'+html.response[i]['comment']+'" rows=4></textarea>\
                            <p><div class="comment-button btn btn-primary" data-comment="' + html.response[i]['filename'] + '" data-commentinput=' + i + ' role="button">Update Comment</div>\
                            <div id="message"></div>\
                            </form>\
                            \
                        </div>\
                    </div>';
                }

                $("#message").html("");
                $("#content").html(content);
            } else {

                var response = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>There has been an error in processing your form. Please try again.</div>'
                $("#message").html(response);
            }
        },
        error: function (textStatus, errorThrown) {
            console.log(textStatus);
            console.log(errorThrown);
            var response = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>There has been an error in processing your form. Please try again.</div>'
            $("#message").html(response);
        },
        beforeSend: function () {
        $("#message").html("<p class='text-center'><img src='assets/images/ajax-loader.gif'></p>");
        }
    });

    // AJAX call to delete an image
    $("#content").on("click", ".delete-button", function(event){
        var confirm = window.confirm("Are you sure you want to delete the image? This action cannot be undone.");
        if (confirm == true) {
            filename = $(this).data('delete');
            $.ajax({
                type: "POST",
                url: "api/deleteimage.php",
                data: "file="+filename,
                dataType: 'JSON',
                success: function (html) {
                    console.log(html);
                    if (html.response_status === true) {
                        location.reload();
                    } else {
                                //$("#message").html(html.response);
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
    });

    // AJAX call to change the comment
    $("#content").on("click", ".comment-button", function(event){
        comment_field_id = $(this).data("commentinput");
        comment_field = $(".comment-image-" + comment_field_id).val();
        filename = $(this).data("comment");

        if (comment_field != "") {
            $.ajax({
                type: "POST",
                url: "api/updatecomment.php",
                data: "file=" + filename + "&comment=" + comment_field,
                dataType: 'JSON',
                success: function (html) {
                    console.log(html);
                    if (html.response_status === true) {
                        location.reload();
                    } else {
                        //$("#message").html(html.response);
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
    });
});
        


