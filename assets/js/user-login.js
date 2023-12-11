function loginUser() {
    var username = $("#username").val();
    var password = $("#password").val();

    $.ajax({
        type: "POST",
        url: "login.php",
        data: {
            signin: true,
            username: username,
            password: password
        },
        dataType: 'json',
        success: function (response) {
            alert(response.message);

            /* - User found on db - */
            if (response.status === "success") {
                window.location.href = "index.php";
            }
        }
    });
}

$(document).ready(function () {
    $("#login-form").submit(function (e) {
        e.preventDefault();
        loginUser();
    });
});
