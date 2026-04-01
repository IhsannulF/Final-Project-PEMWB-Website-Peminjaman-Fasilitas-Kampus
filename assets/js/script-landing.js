$(document).ready(function () {
  "use strict";

  // 1. Efek Sticky Header saat di-scroll
  $(window).on("scroll", function () {
    if ($(window).scrollTop() > 50) {
      $(".header-area").addClass("header-sticky");
    } else {
      $(".header-area").removeClass("header-sticky");
    }
  });

  // 2. Efek Smooth Scroll saat link di menu atau tombol ditekan
  $('a[href^="#"]').on("click", function (e) {
    e.preventDefault();

    // Update menu active class
    $(".nav-link").removeClass("active");
    $(this).addClass("active");

    var target = this.hash;
    var $target = $(target);

    if ($target.length) {
      $("html, body")
        .stop()
        .animate(
          {
            scrollTop: $target.offset().top - 80, // Offset dikurangi tinggi header
          },
          800,
          "swing",
        );
    }
  });

  // 3. Highlight menu aktif berdasarkan posisi scroll
  $(window).on("scroll", function () {
    var scrollPos = $(document).scrollTop() + 100;
    $(".nav-link").each(function () {
      var currLink = $(this);
      var refElement = $(currLink.attr("href"));
      if (refElement.length) {
        if (
          refElement.position().top <= scrollPos &&
          refElement.position().top + refElement.height() > scrollPos
        ) {
          $(".nav-link").removeClass("active");
          currLink.addClass("active");
        }
      }
    });
  });
});
