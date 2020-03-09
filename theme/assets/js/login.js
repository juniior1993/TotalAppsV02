$(function () {

    $("form#login").on("submit", function (e) {
        e.preventDefault();
        clearMessages();

        let email = $(this).find("#email").val();
        let passwd = $(this).find("#password").val();

        if (!checkEmail(email)) {
            showMessage("Informe um email valido!", "emailTempFail", "error", 3000);
        }
        if (!checkPassword(passwd)) {
            showMessage("A senha deve conter entre 6 e 12 caracteres!", "passwordTempFail", "error", 3000);
        }

        if (checkEmail(email) && checkPassword(passwd)) {

            let action = $(this).attr("action");
            let data = $(this).serialize();

            $.ajax({
                url: action,
                data: data,
                type: "post",
                dataType: "json",
                beforeSend: function (e) {

                },
                success: function (response) {
                    if (response.messages) {
                        let counter = 1;
                        response.messages.forEach(function (msg) {
                            showMessage(msg.message, "message_" + counter, msg.type, 3000);
                            counter++;
                        })
                    }

                    if (response.redirect) {
                        let interval = 1;

                        let intervalTimer = setInterval(function () {
                            if (--interval === 0) {
                                clearInterval(intervalTimer);
                                window.location.href = response.redirect.url;
                            }
                        }, 2000);
                    }
                }
            });
        }

    });

    $("#email").on("change keyup", function (e) {
        if (checkEmail($(this).val())) {
            $(this).parent().find("i").css("color", "green");
        } else {
            $(this).parent().find("i").css("color", "#474b6c");
        }
    });
    $("#password").on("change keyup", function (e) {
        if (checkPassword($(this).val())) {
            $(this).parent().find("i").css("color", "green");
        } else {
            $(this).parent().find("i").css("color", "#474b6c");
        }
    });


    /**************
     * FUNCTIONS **
     *************/

    /**
     * Validate email
     * @param email
     * @returns {boolean}
     */

    function checkEmail(email) {
        return !(email == ""
            || email.indexOf('@') == -1
            || email.indexOf('.') == -1);

    }

    /**
     * Validate password
     * @param passwd
     * @returns {boolean}
     */
    function checkPassword(passwd) {
        return !(passwd.length < 6 || passwd.length > 12);

    }

    /**
     * Show message in screen and remove
     * @param message
     * @param id
     * @param type
     * @param time
     */
    function showMessage(message, id, type, time) {
        $("#message").append(`<span class='message ${type}' id="${id}">${message}</span>`);

        setTimeout(function () {
            $("#" + id).slideUp(400);
        }, time, function () {
            $("#" + id).remove();
        });
    }

    function clearMessages() {
        $("#message").find(".message").remove();
    }


    /*
    QUANDO CARREGAR A PAGINA
     */

    let redirectBeforeLogin = null;

    window.onload = function () {
        $.ajax({
            url: "http://localhost/template_total/hasFlash",
            type: "get",
            dataType: "json",
            beforeSend: function (e) {

            },
            success: function (flash) {
                if (flash.messages) {
                    let counter = 1;
                    flash.messages.forEach(function (msg) {
                        showMessage(msg.message, "message_" + counter, msg.type, 3000);
                        counter++;
                    })
                }
            }

        });
    }

});