$(function () {
    /*
    * RIGHT MENU
     */
    $("#show-right-bar").on("click", function (event) {
        $("#right-bar").show(400);
    });

    $("#hide-right-bar").on("click", function (event) {
        $("#right-bar").hide(400);
    });


    /*
    * SUB MENU
     */
    $("div.container-items div.item").on("click", function (e) {
        e.preventDefault();

        if ($(this).data().action) {
            console.log($(this).data());
            window.location.href = $(this).data().action;
            return;
        }

        $(".sub-items").stop().slideUp();

        let subItem = $(this).parents(".container-items").find(".sub-items");

        subItem.stop().slideToggle();

        if (subItem.css("position") == "absolute") {
            let topPosition = subItem.parent().find(".item").offset().top;
            subItem.css("top", topPosition);
        }

    });

    $("div.sub-items").on("mouseleave", function () {

        if ($(this).css("position") == "absolute") {
            $(".sub-items").stop().slideUp();
        }


    });


    /**
     * LOGOFF
     */

    $("#logoff").on("click", function () {
        ajax("http://localhost/template_total/auth/logoff", [], "post");
    });

    /**
     * TABLE FUNCTIONS
     */

    $("table.sortable").sortable({
        items: 'tr',
        cursor: 'pointer',
        axis: 'y',
        dropOnEmpty: false,
        /*
        start: function (e, ui) {
            ui.item.addClass("selected");
        },
        stop: function (e, ui) {
            ui.item.removeClass("selected");
            $(this).find("tr").each(function (index) {
                if (index > 0) {
                    $(this).find("td").eq(2).html(index);
                }
            });
        } */
    });


    /**
     * SELECT BOX
     */

    const selectedBox = $(".selected-box");
    const optionsContainer = $(".options-container");

    const options = $(".option");

    selectedBox.on("click", function (e) {
        $(this).parent().find(".options-container").toggleClass("active");
    });

    options.on("click", function () {
        $(this).parents(".select-box").find(".selected-box").html($(this).find("label").html());
        $(this).parent().removeClass("active");
    });

    optionsContainer.on("mouseleave", function () {
        $(this).removeClass("active");
    });


});



function ajax(url, data, type) {
    $.ajax({
        url: url,
        data: data,
        type: type,
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
                setInterval(function () {
                    window.location.href = response.redirect.url;
                }, 2000);
            }
        }
    });
}

/**
 * FUNCTIONS
 */

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

function setMenuActual($idMenu, $idLink) {

    if (window.innerWidth > 1400) {
        $($idMenu).parent().find("i").css({
            color: "#0bbe35",
            opacity: .7
        });
        if ($idLink !== "not_a") {
            $($idMenu).css("display", "block");
        }

        $($idLink).css({
            color: "#0bbe35",
            opacity: .7
        });
    } else {
        $($idMenu).parent().find("i").css("color", "#0bbe35");
        $($idLink).css({
            color: "#0bbe35",
            opacity: .7
        });
        $($idMenu).css("display", "none");
    }
}
