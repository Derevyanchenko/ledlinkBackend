// ready

window.onload = function () {
    lax.init()

    // Add a driver that we use to control our animations
    lax.addDriver('scrollY', function () {
      return window.scrollY
    });

    // Add animation bindings to elements
    lax.addElements('.parallax-lamp-small', {
      scrollY: {
        translateY: [
            ["elInY", "elCenterY"],
            {
                479: [0, 155], // Screen width < 500
                567: [0, 173], // Screen width < 500
                767: [0, 200], // Screen width < 500
                991: [0, 275], // Screen width > 500 and < 900
                1200: [0, 300], // Screen width > 900
                1366: [0, 337], // Screen width > 900
                2500: [-25, 290], // Screen width > 900
            },
        ],
        translateX: [
            ["elInY", "elCenterY"],
            {
                767: [0, 40], // Screen width < 500
                991: [0, 75], // Screen width > 500 and < 900
                2500: [0, 40], // Screen width > 900
            },
        ],
      },
    },
    {             
        style: {
            transform: '3000ms scale ease-in-out',
        },   
    },
    )
  }

$(document).ready(function() {

    Scrollbar.initAll({
        alwaysShowTracks: true,
      });

    // $('.galleryPage__grid').masonry({
    //     // options
    //     itemSelector: '.galleryPage__item',
    //     // columnWidth: 364,
    //     singleMode: false,
    //     isResizable: true,
    //     isAnimated: true,
    //   });

  $(".woocommerce-ordering select").niceSelect();

if ( document.getElementsByClassName( 'swiper-container' ) ) {
  var mySwiper = new Swiper('.swiper-container', {
    loop: true,
    speed: 1000,
    // autoplay: {
    //     delay: 3000,
    // },
    initialSlide: 6,
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    coverflowEffect: {
        rotate: 0,
        stretch: 150,
        depth: 360,
        modifier: 1,
        slideShadows: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

});
}

  // burger

  $(".open-menu-js").on("click", function() {
    $(".mobileMenu-overlay").addClass("open");
    $("body, html").css("overflow-x", "hidden");
  });

    // lazy scroll to section

  $('a[href*="#"]').click(function() {
    var target = $(this.hash);
    if (target.length) {
      $('html, body').animate({
        scrollTop: target.offset().top
      }, 1000);
      $(".mobileMenu-overlay").removeClass("open");
      return false;
    }
  });
  
  // burger close

  $(".mobileMenu__close").on("click", function() {
    $(".mobileMenu-overlay").removeClass("open");
    $("body, html").css("overflow-x", "auto");
  });

  if ( $(' .footer__menu li ').length > 6 ) {
    $( '.footer__menu' ).addClass( 'column-2' );
  } else if ( $(' .footer__menu li ').length > 12 ) {
    $( '.footer__menu' ).addClass( 'column-3' );
  } else {
    return true;
  }
    

});


document.addEventListener('touchmove', function (){
  var scrollTop = window.pageYOffset;
}, false);

// resize
var flag = true;
var initialSmallLampStartPos;

$(window).on("scroll", function() {

      // fixed header
  var header = $(".header");

  if ( $(this).scrollTop() > 80 ) {

    if ( ! header.hasClass( "fixed" ) ) {
      header.addClass( "fixed" );
    }
  } else {
    if ( header.hasClass( "fixed" ) ) {
      header.removeClass( "fixed" );
    }
  }
});


$(window).on("load resize", function() {

    // other
    if ( $(window).width() <= 991 ) {

        $(".menu-item-has-children > a").on("click", function(e) {
            e.preventDefault();
        });

        $(".menu-item-has-children").on("click", function() {
            if ( ! $(this).find(".sub-menu").hasClass( "open" ) ) {
                $(this).find(".sub-menu").addClass( "open" );
            } else {
                var redirectUrl = $(this).find("a").attr("href");
                window.location.href = redirectUrl;
                
                $(this).find(".sub-menu").removeClass( "open" );
            }
        });

    }

});