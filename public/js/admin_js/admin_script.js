$(document).ready(function() {

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

    // Append Category Level
    $('#section_id').change(function () {
        var section_id = $(this).val();
        $.ajax({
            type: 'post',
            url: '/admin/append-categories-level',
            data: { section_id: section_id},
            success: function (res) {
                $('#appendCategoriesLevel').html(res);
            },
            error: function () {
                alert("Error...");
            }
        });
    });

    // Simple jQuery Alert

    /*
    $('.confirmDelete').click(function () {
        var name = $(this).attr('name');
        if (confirm("Are you sure that you want to delete this " + name + " ? ")){
            return true;
        }
        return false;
    });
    */

    // Category Delete using sweet alert

    $('.confirmDelete').click(function () {
        var record = $(this).attr('record');
        var recordId = $(this).attr('recordId');


        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.location.href = "/admin/delete-" + record + "/" + recordId;
            }
        });
    });

    // Make product active or inactive

    $( ".updateProductStatus" ).click( function() {
        var status = $( this ).text();
        var product_id = $( this ).attr('product_id');

        $.ajax({
            url: "/admin/update-product-status",
            type: "post",
            data: { status: status, product_id: product_id},
            success: function (res) {
                if (res.status == 0){
                    $("#product-" + res.product_id).text("Inactive");
                }else if( res.status == 1){
                    $("#product-" + res.product_id).text("Active");
                }
            },
            error: function () {
                console.log("errors");
            }
        });

    });


});
