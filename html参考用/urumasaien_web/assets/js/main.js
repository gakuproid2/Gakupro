/**
* Template Name: Techie - v2.2.1
* Template URL: https://bootstrapmade.com/techie-free-skin-bootstrap-3/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
!(function($) {
  "use strict";
  // Preloader
  $(window).on('load', function() {

    var height=$("#header").height();
    $("body").css("margin-top", height+5);

    if ($('#preloader').length) {
      $('#preloader').delay(100).fadeOut('slow', function() {
        $(this).remove();
      });
    }
  });

  $(window).on('resize', function() {

    var height=$("#header").height();
    $("body").css("margin-top", height+5);

    if ($('#preloader').length) {
      $('#preloader').delay(100).fadeOut('slow', function() {
        $(this).remove();
      });
    }
  });
 
    //Header表示・非表示
    $('#displaystate_change').on('click', function() {

      // const header = document.getElementById("header");       
      const header = document.getElementById("corporateallinfo");       
  
      if(header.style.display==""){
  
        $('#displaystate_change_icon').addClass('fa-sort-down');      
        $('#displaystate_change_icon').removeClass('fa-sort-up');      

        header.style.display ="none";      
  
      }else{
    
        $('#displaystate_change_icon').addClass('fa-sort-up');      
        $('#displaystate_change_icon').removeClass('fa-sort-down');
        header.style.display ="";

      }
      var height=$("#header").height();   
      $("body").css("margin-top", height+5);
    });

  // Smooth scroll for the navigation menu and links with .scrollto classes
  var scrolltoOffset = $('#header').outerHeight() - 16;
  if (window.matchMedia("(max-width: 991px)").matches) {
    scrolltoOffset += 16;
  }

  // Activate smooth scroll on page load with hash links in the url
  $(document).ready(function() {
    if (window.location.hash) {
      var initial_nav = window.location.hash;
      if ($(initial_nav).length) {
        var scrollto = $(initial_nav).offset().top - scrolltoOffset;
        $('html, body').animate({
          scrollTop: scrollto
        }, 1500, 'easeInOutExpo');
      }
    }
  });

  // Navigation active state on scroll
    // Toggle .header-scrolled class to #header when page is scrolled
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('#header').addClass('header-scrolled');
    } else {
      $('#header').removeClass('header-scrolled');
    }
  });

  if ($(window).scrollTop() > 100) {
    $('#header').addClass('header-scrolled');
  }

  // jQuery counterUp
  $('[data-toggle="counter-up"]').counterUp({
    delay: 10,
    time: 1000
  });

  // Testimonials carousel (uses the Owl Carousel library)
  $(".testimonials-carousel").owlCarousel({
    autoplay: true,
    dots: true,
    loop: true,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 2
      },
      900: {
        items: 3
      }
    }
  });

  

  // Init AOS
  function aos_init() {
    AOS.init({
      duration: 1000,
      once: true
    });
  }
  $(window).on('load', function() {
    aos_init();
  });



})(jQuery);