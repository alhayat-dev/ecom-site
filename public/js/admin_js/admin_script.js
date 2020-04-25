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

    // Make section active or inactive

    $( ".updateSectionStatus" ).click( function() {
        var status = $( this ).text();
        var section_id = $( this ).attr('section_id');

        $.ajax({
            url: "/admin/update-section-status",
            type: "Post",
            data: { status, section_id},
            success: function (res) {
                if (res.status == 0){
                    $("#section-" + res.section_id).text("Inactive");
                }else if( res.status == 1){
                    $("#section-" + res.section_id).text("Active");

                }
            },
            error: function () {
                console.log("errors");
            }
        });

    });

    // Make category active or inactive

    $( ".updateCategoryStatus" ).click( function() {
        var status = $( this ).text();
        var category_id = $( this ).attr('category_id');

        $.ajax({
            url: "/admin/update-category-status",
            type: "Post",
            data: { status, category_id},
            success: function (res) {
                if (res.status == 0){
                    $("#category-" + res.category_id).text("Inactive");
                }else if( res.status == 1){
                    $("#category-" + res.category_id).text("Active");
                }
            },
            error: function () {
                console.log("errors");
            }
        });

    });

});
