$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "api/getimages.php",
        //data: form_data,
        dataType: 'JSON',
        success: function (html) {
            console.log(html);
            if (html.response_status === true) {
                $("#message").html();
                var row_count = 0;
                var i = 0;
                var image_count = 0;
                var content = "";
                var index_count = 1;
                var pagination_content = ""
                if (html.count == 0) {
                    $("#message").html("");
                    $("#content").html("<h2>No image uploaded yet</h2>");
                    return true;
                }
                while(image_count <= html.count) {
                    if (index_count == 1){
                        class_text = 'class="active"';
                    }
                    else {
                        class_text = "";
                    }
                    pagination_content += '\
                            <li '+ class_text +' >\
                                <a class="image-index" href="#" data-index=' + index_count + ' data-minimum=' + image_count.toString() + ' data-maximum=' + (image_count+10).toString() + ' >' + index_count + '</a>\
                            </li>';
                    index_count ++;
                    image_count += 10;
                }

                $("#pagination-list").html(pagination_content);

                content += '<div class="row">';
                for (i = html.response.length - 1; i >= 0; i--) {

                    content += '\
                        <div class="col-md-6 portfolio-item">\
                            <a href="">\
                                <img class="img-responsive" src="'+ html.response[i]['filename'] +'" alt="">\
                            </a>\
                            <h3>' +  html.response[i]['user']  + '</h3>\
                            <p>' + html.response[i]['date'] + '</p>\
                        </div>';
                    if (i%2 == 0) {
                        content += '\
                        </div>\
                        <div class="row">\
                        '
                    }
                }
                $("#message").html("");
                $("#content").html(content);
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
    /*
    $('.image-index').click(function() {

        alert("hi");
        alert(this.data('index'));
        return false;
    });
    */
    $("#pagination-list").on("click", "a", function(event){
        var previous_tab = $('.active');
        var current_tab = $(this);
        var minimum = $(this).data('minimum');
        var maximum = $(this).data('maximum');
        
        $.ajax({
            type: "GET",
            url: "api/getimages.php",
            data: "minimum=" + minimum + "&maximum=" + maximum,
            dataType: 'JSON',
            success: function (html) {
                $("#content").html("");
                console.log(html);
                if (html.response_status === true) {
                    $("#message").html("");
                    previous_tab.removeClass("active");
                    current_tab.parent().addClass("active");
                    var row_count = 0;
                    var i = 0;
                    var image_count = 0;
                    var content = "";
                    var index_count = 1;
                    var pagination_content = ""

                    content += '<div class="row">';
                    for (i = html.response.length - 1; i >= 0; i--) {

                        content += '\
                            <div class="col-md-6 portfolio-item">\
                                <a href="">\
                                    <img class="img-responsive" src="'+ html.response[i]['filename'] +'" alt="">\
                                </a>\
                                <h3>' +  html.response[i]['user']  + '</h3>\
                                <p>' + html.response[i]['date'] + '</p>\
                            </div>';
                        if (i%2 == 0) {
                            content += '\
                            </div>\
                            <div class="row">\
                            '
                        }
                    }
                    $("#message").html("");
                    $("#content").html(content);
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
        return false;
    });
});
        


