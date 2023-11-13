$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
        if (forms[0].checkValidity()) {
            var password = document.getElementById("uspass").value;
            $.ajax({
                type: "post",
                url: 'Action/actionSession.php',
                data: $(this).serialize(),
                success: function (response) {
                    var jsonData = JSON.parse(response);

                    // user is logged in successfully in the back-end
                    // let's redirect
                    if (jsonData.success == "1") {
                        registerSuccess();
                    }
                    else if (jsonData.success == "0") {
                        registerFailure();
                    }
                }
            });
        } else {
            forms[0].classList.add('was-validated');
        }
    });
});


function registerSuccess() {
    Swal.fire({
        icon: 'success',
        title: 'Se inicio sesion correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        redireccionarIndex();
    }, 1500);
}


function redireccionarIndex() {
    location.href = "inicio.php"
}

function registerFailure() {
    Swal.fire({
        icon: 'error',
        title: 'La contraseña y/o el usuario no coinciden!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

function recargarPagina() {
    location.reload();
}