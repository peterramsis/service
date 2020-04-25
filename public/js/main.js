$(function() {



    $(".iconserach").on("click", function() {
        $(".search").toggle(1000);

    });

    $(".icon-cart").on("click", function() {


        $(".cart").toggleClass("isVisible");

        if ($(".cart").hasClass("isVisible")) {
            $(".cart").animate({
                right: 0
            }, 500);
        } else {
            $(".cart").animate({
                right: "-400px"
            }, 500);
        }

    });

    $(".cart-close").on("click", function(e) {
        e.preventDefault();
        $(".cart").animate({
            right: "-400px"
        }, 500);
    });


    $(document).on("click", ".btn-close", function() {
        $(this).parents(".body-model").hide(100);
    });
    $(document).on("click", ".open-model-cart", function() {
        $(this).parents(".ws-model-cart").find(".body-model").show();


        // Calculates the correct position of the image and moves it at the center of the visible part of page.

    });

    $(document).on("click", ".tabs-list li", function() {
        $(this).addClass("active").siblings().removeClass();

        $(".content-list > div").hide();
        $($(this).data("content")).show();


    });


    $(".fa-searchengin").on("click", function() {
        $(this).toggleClass("isVisibleSearch");

        if ($(this).hasClass("isVisibleSearch")) {
            $(".form-search").css({ "display": "block" }).animate({
                "width": "95%",
            }, 1000);
        } else {
            $(".form-search").css({ "display": "none" }).animate({
                "width": "0%"

            }, 1000);


        }

    });






})