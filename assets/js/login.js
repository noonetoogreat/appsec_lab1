$(document).ready(function () {
    "use strict";
    $("#submit").click(function () {

        var username = $("#username").val();
        var password = $("#password").val();
        var token = $("#token").val();

        if ((username === "") || (password === "")) {
            $("#message").html("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Please enter a username and a password</div>");
        } else {
            $.ajax({
                type: "POST",
                url: "api/checklogin.php",
                data: "myusername=" + username + "&mypassword=" + password + "&token=" + token,
                dataType: 'JSON',
                success: function (html) {
                    //console.log(html.response + ' ' + html.username);
                    if (html.response === 'true') {
                        location.assign("profile.php");
                        location.reload();
                        return html.username;
                    } else {
                        $("#message").html(html.response);
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
