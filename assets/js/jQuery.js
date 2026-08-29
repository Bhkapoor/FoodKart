
// REGISTER
$('#userform').on('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "/phpfolder/Restaurant/login/register.php", // FIXED
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(data){
            $("#message").html(data);

            if (data.includes("Register Successfully")) {
                $('#userform')[0].reset();
            }
        },

        error: function(xhr){
            $("#message").html("Error: " + xhr.responseText);
        }
    });
});


// LOGIN
$("#userform2").on('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "/phpfolder/Restaurant/login/login.php", 
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(data){
            console.log("LOGIN RESPONSE:", data);
            $("#message1").html(data);

            if (data.trim() === "admin") {
                window.location.href = "/phpfolder/Restaurant/dashboard/admindash.php";
                $('#userform2')[0].reset();
            }
             else if (data.trim() === "restaurant") {
                window.location.href = "/phpfolder/Restaurant/dashboard/resdash.php";
                $('#userform2')[0].reset();
            }
              else if(data.trim() === "user") {
                window.location.href = "/phpfolder/Restaurant/dashboard/userdash.php";
                $('#userform2')[0].reset();
            }else{
                console.log( "error");
            }

            
        },

        error: function(){
            $("#message1").html("Error");
        }
    });
});

// forgot password
$('#userform3').on('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "/phpfolder/Restaurant/login/forgotpass.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(data){
            $("#message2").html(data);

            if (data.includes("Reset link")) {
                $('#userform3')[0].reset();
            }
        },

        error: function(xhr){
            $("#message2").html("Error: " + xhr.responseText);
        }
    });
});
 
// create new password
$('#userform4').on('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url:window.location.href,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(data){
            $("#message3").html(data);

          
                $('#userform4')[0].reset();
            
            
        },

        error: function(xhr){
            $("#message3").html("Error: " + xhr.responseText);
        }
    });
});


//    cart page
    // $(document).ready(function() {
    //     $('.add-to-cart-btn').on('click', function() {
    //         var foodId = $(this).data('id');
    //         var button = $(this);

    //         $.ajax({
    //             url: "/php-folder/Restaurant/dashboard/cart.php",
    //             type: 'POST',
    //             data: { 
    //                 action: 'add_to_cart', 
    //                 food_id: foodId 
    //             },
    //             success: function(response) {
    //                 if (response.trim() === 'success') {
    //                  Swal.fire({
    //                  title: "Congratulations!",
    //                  text: "Item added to cart",
    //                  icon: "success"
    //                  });
    //                     button.removeClass('btn-outline-warning').addClass('btn-success').text('Added');
    //                 } else {
    //                     alert('error');
    //                 }
    //             }
    //         });
    //     });
    // });
    
// myOrder page




