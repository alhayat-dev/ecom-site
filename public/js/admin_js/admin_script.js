$(document).ready(function() {
    // Check admin password is correct or not
    console.log( "ready!" );

    $("#current_password").keyup(function () {
        var current_password = $("#current_password").val();
        $.ajax({
            type: "post",
            url: "/admin/check-current-password",
            data: {current_password},
            success: function (res) {
                if (res == "false"){
                    $("#checkCurrentpassword").html("<span style='color: red;'>current password is incorrect</span>")
                }else if(res == "true"){
                    $("#checkCurrentpassword").html("<span style='color: green;'>current password is correct</span>")
                }
            },
            error: function () {
                alert("errors");
            }
        });
    });
});
