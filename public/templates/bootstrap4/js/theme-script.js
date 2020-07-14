/* ------------------------------------------------
  Project:   Ekocart - Multi-purpose E-commerce Html5 Template
  Author:    ThemeHt
------------------------------------------------ */
/* ------------------------
    Table of Contents

  1. Predefined Variables
  2. Preloader  
  3. FullScreen
  4. Counter
  5. Owl carousel
  6. Dropdown
  7. Isotope
  8. Magnific Popup
  9. Fixed Header
  10. Text Color, Background Color And Image
  11. Contact Form
  12. ProgressBar
  13. Parallax
  14. Countdown
  15. Rangeslider
  16. Btnproduct
  17. LightSlider
  18. Wow Animation
  19. Particles
  20. Window load and functions
  

------------------------ */

"use strict";

/*------------------------------------
  HT Predefined Variables
--------------------------------------*/
var $window = $(window),
    $document = $(document),
    $body = $('body'),
    $fullScreen = $('.fullscreen-banner') || $('.section-fullscreen'),
    $halfScreen = $('.halfscreen-banner');

//Check if function exists
$.fn.exists = function () {
  return this.length > 0;
};


/*------------------------------------
  HT PreLoader
--------------------------------------*/
function preloader() {
   $('#ht-preloader').fadeOut();
};

/*------------------------------------
  HT FullScreen
--------------------------------------*/
function fullScreen() {
    if ($fullScreen.exists()) {
        $fullScreen.each(function () {
        var $elem = $(this),
        elemHeight = $window.height();
        if($window.width() < 768 ) $elem.css('height', elemHeight/ 1);
        else $elem.css('height', elemHeight);
        });
        }
        if ($halfScreen.exists()) {
        $halfScreen.each(function () {
        var $elem = $(this),
        elemHeight = $window.height();
        $elem.css('height', elemHeight / 2);
        });
    }
};


/*------------------------------------
  HT Banner Slider
--------------------------------------*/
function bannerslider() {
$('.banner-slider').each( function() {
  var $carousel = $(this);
  $carousel.owlCarousel({
      items:1,
      loop : true,
      dots : $carousel.data("dots"),
      nav : $carousel.data("nav"),
      margin : $carousel.data("margin"), 
      animateIn: 'fadeIn',
      animateOut: 'fadeOut',   
      autoplay : true,
      autoplayTimeout : 6000,
      navText : [ '<span class="las la-arrow-left"><span>', '<span class="las la-arrow-right"></span>' ],
  });
});
};

/*------------------------------------
  HT Owl Carousel
--------------------------------------*/
function owlcarousel() {
$('.owl-carousel').each( function() {
  var $carousel = $(this);
  $carousel.owlCarousel({
      items : $carousel.data("items"),
      slideBy : $carousel.data("slideby"),
      center : $carousel.data("center"),
      loop : true,
      margin : $carousel.data("margin"),
      dots : $carousel.data("dots"),
      nav : $carousel.data("nav"),      
      autoplay : $carousel.data("autoplay"),
      autoplayTimeout : $carousel.data("autoplay-timeout"),
      navText : [ '<span class="la la-angle-left"><span>', '<span class="la la-angle-right"></span>' ],
      responsive: {
        0:{items: $carousel.data('xs-items') ? $carousel.data('xs-items') : 1},
        576:{items: $carousel.data('sm-items')},
        768:{items: $carousel.data('md-items')},
        1024:{items: $carousel.data('lg-items')},
        1200:{items: $carousel.data("items")}
      },
  });
});
};


/*------------------------------------
  HT Dropdown
--------------------------------------*/  
function dropdown() {
    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
  if (!$(this).next().hasClass('show')) {
    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
  }
  var $subMenu = $(this).next(".dropdown-menu");
  $subMenu.toggleClass('show');

  $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
    $('.dropdown-submenu .show').removeClass("show");
  });

  return false;
});
};

/*------------------------------------
  HT Scroll to top
--------------------------------------*/
function scrolltop() {
  var pxShow = 300,
    goTopButton = $(".scroll-top")
    // Show or hide the button
  if ($(window).scrollTop() >= pxShow) goTopButton.addClass('scroll-visible');
  $(window).on('scroll', function () {
    if ($(window).scrollTop() >= pxShow) {
      if (!goTopButton.hasClass('scroll-visible')) goTopButton.addClass('scroll-visible')
    } else {
      goTopButton.removeClass('scroll-visible')
    }
  });
  $('.smoothscroll').on('click', function (e) {
    $('body,html').animate({
      scrollTop: 0
    }, 3000);
    return false;
  });
};


/*------------------------------------
  HT Fixed Header
--------------------------------------*/
function fxheader() {
  $(window).on('scroll', function () {
    if ($(window).scrollTop() >= 300) {
      $('#header-wrap').addClass('fixed-header');
    } else {
      $('#header-wrap').removeClass('fixed-header');
    }
  });
};


/*------------------------------------------
  HT Text Color, Background Color And Image
---------------------------------------------*/
function databgcolor() {
    $('[data-bg-color]').each(function(index, el) {
     $(el).css('background-color', $(el).data('bg-color'));  
    });
    $('[data-text-color]').each(function(index, el) {
     $(el).css('color', $(el).data('text-color'));  
    });
    $('[data-bg-img]').each(function() {
     $(this).css('background-image', 'url(' + $(this).data("bg-img") + ')');
    });
};


/*------------------------------------
  HT Contact Form
--------------------------------------*/
function contactform() { 
    $('#contact-form').validator();

    // when the form is submitted
    $('#contact-form').on('submit', function (e) {

    // if the validator does not prevent form submit
    if (!e.isDefaultPrevented()) {
        var url = "php/contact.php";

        // POST values in the background the the script URL
        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(),
            success: function (data)
            {
            // data = JSON object that contact.php returns

            // we recieve the type of the message: success x danger and apply it to the 
            var messageAlert = 'alert-' + data.type;
            var messageText = data.message;

            // let's compose Bootstrap alert box HTML
            var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
            
            // If we have messageAlert and messageText
            if (messageAlert && messageText) {
                // inject the alert to .messages div in our form
                $('#contact-form').find('.messages').html(alertBox).show().delay(2000).fadeOut('slow');
                // empty the form
                $('#contact-form')[0].reset();
            }
          }
        });
        return false;
    }
 })    
};


/*------------------------------------
  HT Parallax
--------------------------------------*/
function parallax() {
  $(".parallaxie").parallaxie({
      speed: 0.4,
      offset: 0,
  });
};


/*------------------------------------
  HT Countdown
--------------------------------------*/
function countdown() {
  $('.countdown').each(function () {
    var $this = $(this),
      finalDate = $(this).data('countdown');
    $this.countdown(finalDate, function (event) {
      $(this).html(event.strftime('<li><span>%-D</span><p>d</p></li>' + '<li><span>%-H</span><p>h</p></li>' + '<li><span>%-M</span><p>m</p></li>' + '<li><span>%S</span><p>s</p></li>'));
    });
  });
};


/*------------------------------------
  HT btnproduct
--------------------------------------*/
function btnproduct() {
  $('.btn-product-up').on('click', function (e) {
    e.preventDefault();
    var numProduct = Number($(this).next().val());
    if (numProduct > 1) $(this).next().val(numProduct - 1);
  });
  $('.btn-product-down').on('click', function (e) {
    e.preventDefault();
    var numProduct = Number($(this).prev().val());
    $(this).prev().val(numProduct + 1);
  }); 
};


/*------------------------------------
  HT LightSlider
--------------------------------------*/
function lightSlider() {
   $('#imageGallery').lightSlider({
    gallery:true,
    item:1,
    verticalHeight:450,
    thumbItem:4,
    slideMargin:0,
    speed:600,
    autoplay: true,
  });  

   $('[data-toggle="tooltip"]').tooltip()
};


/*------------------------------------
  HT Wow Animation
--------------------------------------*/
function mailmodal() {
    $('#mailchimpModal').modal('show');
}


/*------------------------------------
  HT Wow Animation
--------------------------------------*/
function wowanimation() {
    var wow = new WOW({
        boxClass: 'wow',
        animateClass: 'animated',
        offset: 0,
        mobile: false,
        live: true
    });
    wow.init();
}

/*------------------------------------
  HT Window load and functions
--------------------------------------*/
$(document).ready(function() {
    fullScreen(),
    bannerslider(),
    owlcarousel(),
    dropdown(),
    scrolltop(),
    fxheader(),
    databgcolor(),  
    contactform(),
    parallax(),
    countdown(),
    btnproduct(),
    lightSlider();
});


$window.resize(function() {
});


$(window).on('load', function() {
    preloader(),
    mailmodal(),
    wowanimation();
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  e.target // newly activated tab
  e.relatedTarget // previous active tab
  $(".owl-carousel").trigger('refresh.owl.carousel');
});