document.addEventListener("click", function() {
    if ($(".categories").hasClass("active")) {
        $(".categories").removeClass("active");
        $(".categories>ul>li").removeClass("active");
    }
});
$(document).ready(function() {
    $(".header-top-right li").click(function(e) {
        e.stopPropagation();
        if ($(this).hasClass("active")) {
            $(".header-top-right li").removeClass("active");
        } else {
            $(".header-top-right li").removeClass("active");
            $(this).addClass("active");
        }
    });
    $(".header-top-right li").hover(function() {
        $(".header-top-right li").removeClass("active");
        $(this).addClass("active");
    }, function() {
        $(".header-top-right li").removeClass("active");
    });

    $(".btn-categories").click(function(e) {
        e.stopPropagation();
        if ($(".categories").hasClass("active")) {
            $(".categories").removeClass("active");
        } else {
            $(".categories").addClass("active");
        }
    });

    $(".categories>ul>li").click(function(e) {
        e.stopPropagation();
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
        } else {
            $(".categories>ul>li").removeClass("active");
            $(this).addClass("active");
        }
    });

    $("#close-categories").click(function(e) {
        e.stopPropagation();
        $(".categories").removeClass("active");
        $(".categories>ul>li").removeClass("active");
    });

    $(".nav-item.dropdown").click(function(e) {
        e.stopPropagation();
        if ($(this).hasClass("show")) {
            $(".nav-item.dropdown").removeClass("show");
            $(".dropdown-menu").removeClass("show");
        } else {
            $(".nav-item.dropdown").removeClass("show");
            $(".dropdown-menu").removeClass("show");
            $(this).find('.dropdown-menu').addClass("show");;
            $(this).addClass("show");
        }
    });

    $(".btn-tab-login").click(function(e) {
        e.stopPropagation();
        if (!$(this).hasClass("active")) {
            $(".btn-tab-cs button").removeClass("active");
            $('#tab-login, #tab-signup').removeClass("active");
            $(this).addClass("active");
            $("#" + $(this).data("tab")).addClass("active");
        }
    });

    $("#close-nav").click(function(e) {
        $('.navbar-collapse').collapse('hide');
    });

    $('.slider-home').slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        autoplay: true,
        autoplaySpeed: 4000
    });

    $(".product-list-items .slider, .product-list-items2").slick({
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 4,
        autoplay: true,
        autoplaySpeed: 4000,
        nextArrow: $('.arrow-slider-custom .prev'),
        prevArrow: $('.arrow-slider-custom .next'),
        responsive: [{
            breakpoint: 1000,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
            }
        }, {
            breakpoint: 768,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
            }
        }]
    });

    $(function() {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: 'linear', // Scroll to top easing (see http://easings.net/)
            animation: 'fade', // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });
});