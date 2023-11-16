// script.js

$(document).ready(function () {
    // Disable form submission on enter key press
    $('#form-login').keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            validateForm();
        }
    });

    // Validate form on submit
    $('#form-login').submit(function (e) {
        e.preventDefault();
        validateForm();
    });

    function validateForm() {
        // Reset validation feedback
        $('.form-control').removeClass('is-invalid');

        // Validate username
        let username = $('#usnombre').val();
        if (username.trim() === '') {
            $('#usnombre').addClass('is-invalid');
            return;
        }

        // Validate password
        let password = $('#uspass').val();
        if (password.trim() === '') {
            $('#uspass').addClass('is-invalid');
            return;
        }

        // If all validations pass, submit the form
        $('#form-login').unbind('submit').submit();
    }
});
