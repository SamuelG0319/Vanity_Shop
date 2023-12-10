const checkbox = document.getElementById('check-24');
const box = document.getElementById('company_code');

checkbox.addEventListener('click', function handleClick() {
    if (checkbox.checked) {
        box.style.display = 'block';
    } else {
        box.style.display = 'none';
    }
});

$(document).ready(function () {
    $('#username').blur(function () {
        var username = $(this).val();

        $.ajax({
            url: 'check.php',
            method: "POST",
            data: { user_name: username },
            success: function (data) {
                if (data != '0') {
                    $('#check_username').html('<span class="text-danger">Usuario no disponible</span>');
                    $('#signup').attr("disabled", true);
                } else {
                    $('#check_username').html('<span class="text-success">Usuario disponible</span>');
                    $('#signup').attr("disabled", false);
                }
            }
        });
    });
});


