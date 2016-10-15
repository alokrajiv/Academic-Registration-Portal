
/*=============================================================
    Authour URL: www.designbootstrap.com

    http://www.designbootstrap.com/

    License: MIT

    http://opensource.org/licenses/MIT

    100% Free To use For Personal And Commercial Use.

    IN EXCHANGE JUST TELL PEOPLE ABOUT THIS WEBSITE
   
========================================================  */

$(document).ready(function () {

    // FOR SCROLL ANIMATIONS
    window.scrollReveal = new scrollReveal();

    // SCROLL SCRIPTS 
        $('.scroll-me a').bind('click', function (event) { //just pass scroll-me class and start scrolling
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1000, 'easeInOutQuad');
        event.preventDefault();
        });

    //COLLAPSE HEADER ON SCRLL
        $(window).scroll(function () {
            if ($(".navbar").offset().top > 40) {
                $(".navbar-fixed-top").addClass("navbar-pad-original");
            } else {
                $(".navbar-fixed-top").removeClass("navbar-pad-original");
            }
        });

    //FANCY BOX PLUGIN SCRIPT FOR POPUP IMAGE
       /* $('.fancybox-media').fancybox({
            openEffect: 'elastic',
            closeEffect: 'elastic',
            helpers: {
                title: {
                    type: 'inside'
                },
                overlay: {
                  locked: false
                }
            }
        });*/

    //ISOTOPE  PLUGIN SCRIPT FOR FILTER FUCNTIONALITY
      /*  $(window).load(function () {
            var $container = $('#portfolio-div');
            $container.isotope({
                filter: '*',
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
            $('.caegories a').click(function () {
                $('.caegories .active').removeClass('active');
                $(this).addClass('active');
                var selector = $(this).attr('data-filter');
                $container.isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    }
                });
                return false;
            });

        });

    //CLIENTS SLIDER
        $("#clients-slider").carousel({
            interval: 2000 //TIME IN MILLI SECONDS
        }); */

});
