(function () {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Scrolls to an element with header offset
   */
  const scrollto = (el) => {
    let header = select('#header')
    let offset = header.offsetHeight

    let elementPos = select(el).offsetTop
    window.scrollTo({
      top: elementPos - offset,
      behavior: 'smooth'
    })
  }

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Mobile nav toggle
   */
  on('click', '.mobile-nav-toggle', function (e) {
    select('#navbar').classList.toggle('navbar-mobile')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function (e) {
    if (select('#navbar').classList.contains('navbar-mobile')) {
      e.preventDefault()
      this.nextElementSibling.classList.toggle('dropdown-active')
    }
  }, true)

  /**
   * Scrool with ofset on links with a class name .scrollto
   */
  on('click', '.scrollto', function (e) {
    if (select(this.hash)) {
      e.preventDefault()

      let navbar = select('#navbar')
      if (navbar.classList.contains('navbar-mobile')) {
        navbar.classList.remove('navbar-mobile')
        let navbarToggle = select('.mobile-nav-toggle')
        navbarToggle.classList.toggle('bi-list')
        navbarToggle.classList.toggle('bi-x')
      }
      scrollto(this.hash)
    }
  }, true)

  /**
   * Scroll with ofset on page load with hash links in the url
   */
  window.addEventListener('load', () => {
    if (window.location.hash) {
      if (select(window.location.hash)) {
        scrollto(window.location.hash)
      }
    }
  });

  /**
   * Preloader
   */
  let preloader = select('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove()
    });
  }

  // /**
  //  * Initiate  glightbox 
  //  */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Skills animation
   */
  let skilsContent = select('.skills-content');
  if (skilsContent) {
    new Waypoint({
      element: skilsContent,
      offset: '80%',
      handler: function (direction) {
        let progress = select('.progress .progress-bar', true);
        progress.forEach((el) => {
          el.style.width = el.getAttribute('aria-valuenow') + '%'
        });
      }
    })
  }

  /**
   * Porfolio isotope and filter
   */
  window.addEventListener('load', () => {
    let portfolioContainer = select('.portfolio-container');
    if (portfolioContainer) {
      let portfolioIsotope = new Isotope(portfolioContainer, {
        itemSelector: '.portfolio-item'
      });

      let portfolioFilters = select('#portfolio-flters li', true);

      on('click', '#portfolio-flters li', function (e) {
        e.preventDefault();
        portfolioFilters.forEach(function (el) {
          el.classList.remove('filter-active');
        });
        this.classList.add('filter-active');

        portfolioIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        portfolioIsotope.on('arrangeComplete', function () {
          AOS.refresh()
        });
      }, true);
    }

  });

  // /**
  //  * Initiate galery lightbox 
  //  */
  const portfolioLightbox = GLightbox({
    selector: '.galery-lightbox'
  });

  /**
   * Portfolio details slider
   */
  new Swiper('.portfolio-details-slider', {
    speed: 400,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    }
  });

  /**
   * Animation on scroll
   */
  window.addEventListener('load', () => {
    AOS.init({
      duration: 1000,
      easing: "ease-in-out",
      once: true,
      mirror: false
    });
  });
})()

/**
   * Sidebar Navigation
   */
$('.sub-menu ul').hide();
$(".sub-menu a").click(function () {
  $(this).parent(".sub-menu").children("ul").slideToggle("100");
  $(this).find(".right").toggleClass("ri-subtract-line ri-add-line");
});

/**
   * Shorcut Menu
   */
$(".trigger-shorcut-menu, .overlay").click(function () {
  $(".shorcut-menu").slideToggle();
  $(".overlay").fadeToggle();
});

var $st = $('.pagination');
var $slickEl = $('.center');

$slickEl.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
  var i = (currentSlide ? currentSlide : 0) + 1;
  $st.text(i + ' of ' + slick.slideCount);
});

$slickEl.slick({
  centerMode: true,
  centerPadding: '200px',
  slidesToShow: 1,
  dots: true,
  infinite: true,
  autoplay: true,
  autoplaySpeed: 3000,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});

$('.box-news-slide').slick({
  dots: true,
  infinite: false,
  speed: 300,
  autoplay: true,
  slidesToShow: 3,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '20px',
        slidesToShow: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '20px',
        slidesToShow: 1
      }
    }
  ]
});

$(".list-certificate li").click(function () {
  var get_image = $(this).children("img").attr("src");
  $(this).addClass('active').siblings().removeClass('active');
  $("#current-cert").attr("src", get_image);
});

if ($(window).width() > 1024) {
  $(window).scroll(function (event) {
    var getValScroll = $(window).scrollTop();
    if (getValScroll == 0){
      $("#navbar").fadeIn();
      $("#floating-menu-home").fadeOut();
      $(".large-logo").fadeIn();
      $(".small-logo").fadeOut();
      $("#floating-menu-general").fadeOut();
      $(".general-menu-banner").fadeIn();
    } else {
      $("#navbar").fadeOut();
      $("#floating-menu-home").fadeIn();
      $(".large-logo").fadeOut();
      $(".small-logo").fadeIn();
      $("#floating-menu-general").fadeIn();
      $(".general-menu-banner").fadeOut();
    }
  });
}

$(".accordion").on("click", function () {
  $(this).toggleClass("active");
  $(this).next().slideToggle(200);
});

let heightScreen = $(window).height();
$(".carousel-item, #hero").height(heightScreen);
$(".overlay, .overlay-megamenu").height(heightScreen);

if (typeof $('.list-product') !== undefined) {
  $(".list-product x-button").click(function () {
    $(this).addClass("active");
    $(this).siblings().removeClass("active");
  });

  let isRotated = false;

  $(".list-product x-button").on("click", function () {
    if (!isRotated) {
      isRotated = true;

      //add one class and remove the other
      $(".img-circle").addClass("rotate-180");
      $(".img-circle").removeClass("rotate-180back");
    } else {
      isRotated = false;

      //add one class and remove the other
      $(".img-circle").addClass("rotate-180back");
      $(".img-circle").removeClass("rotate-180");
    }
  });

  $("#urea-link").on('click', function () {
    $("#page-product .box-circle-product:not('.hide')").stop().fadeOut('fast', function () {
      $(this).addClass('hide');
      $('#urea').fadeIn('slow').removeClass('hide');
    });
  });
  $("#amoniak-link").on('click', function () {
    $("#page-product .box-circle-product:not('.hide')").stop().fadeOut('fast', function () {
      $(this).addClass('hide');
      $('#amoniak').fadeIn('slow').removeClass('hide');
    });
  });
  $("#npk-link").on('click', function () {
    $("#page-product .box-circle-product:not('.hide')").stop().fadeOut('fast', function () {
      $(this).addClass('hide');
      $('#npk').fadeIn('slow').removeClass('hide');
    });
  });
}
$(".navbar li").has(".mega-menu").hover(function () {

  $(".overlay-megamenu").css("display", "block");
}, function () {
  $(".overlay-megamenu").css("display", "none");
});

$(".overlay-megamenu").mouseover(function () {
  $(this).css("display", "none");
});

$(document).ready(function () {
  $('#first-accordion').trigger('click');
  const ele1 = document.getElementById('panzoom-1');
  const ele2 = document.getElementById('panzoom-2');
  const btnzoomin1 = document.getElementById('zoom-in-1');
  const btnzoomout1 = document.getElementById('zoom-out-1');

  const btnzoomin2 = document.getElementById('zoom-in-2');
  const btnzoomout2 = document.getElementById('zoom-out-2');

  if (ele1) {
    const panzoom1 = Panzoom(ele1, {
      animate: true,
    });
    btnzoomin1.addEventListener('click', panzoom1.zoomIn);
    btnzoomout1.addEventListener('click', panzoom1.zoomOut);
  }
  if (ele2) {
    const panzoom2 = Panzoom(ele2, {
      animate: true,
    });
    btnzoomin2.addEventListener('click', panzoom2.zoomIn);
    btnzoomout2.addEventListener('click', panzoom2.zoomOut);
  }
});

const otherDirectors = $('.other-directors');
if (typeof otherDirectors !== undefined) {
  $('.other-directors').slick({
    infinite: false,
    slidesToShow: 4,
    slidesToScroll: 2
  });
}

$('.box-report-investor').slick({
  infinite: false,
  slidesToShow: 4,
  slidesToScroll: 2
});


$('.box-items-product').slick({
  centerMode: true,
  centerPadding: '60px',
  slidesToShow: 3,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});

// Highcharts.chart('detail-production', {
//   chart: {
//     type: 'column',
//     backgroundColor: '#E2F2FF',
//   },
//   title: {
//     text: 'Rincian Produksi'
//   },
//   xAxis: {
//     categories: [
//       'Jan',
//       'Feb',
//       'Mar',
//       'Apr',
//       'Mei',
//       'Jun',
//       'Jul',
//       'Agt',
//       'Sept',
//       'Okt',
//       'Nov',
//       'Des'
//     ],
//     crosshair: true
//   },
//   yAxis: {
//     title: {
//       useHTML: true,
//       text: 'Tons'
//     }
//   },
//   tooltip: {
//     headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
//     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
//       '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
//     footerFormat: '</table>',
//     shared: true,
//     useHTML: true
//   },
//   credits: {
//     enabled: false
//   },
//   plotOptions: {
//     column: {
//       pointPadding: 0.2,
//       borderWidth: 0
//     }
//   },
//   series: [{
//     color: '#00519B',
//     name: 'Amoniak',
//     data: [13.93, 13.63, 13.73, 13.67, 14.37, 14.89, 14.56,
//       14.32, 14.13, 13.93, 13.21, 12.16]

//   }, {
//     color: '#74F7FF',
//     name: 'Urea',
//     data: [12.24, 12.24, 11.95, 12.02, 11.65, 11.96, 11.59,
//       11.94, 11.96, 11.59, 11.42, 11.76]

//   }, {
//     color: '#F47920',
//     name: 'NPK',
//     data: [10.00, 9.93, 9.97, 10.01, 10.23, 10.26, 10.00,
//       9.12, 9.36, 8.72, 8.38, 8.69]

//   }]
// });

// Highcharts.chart('target-production', {
//   chart: {
//     type: 'bar',
//     backgroundColor: '#E2F2FF',
//   },
//   title: {
//     text: 'Target Production'
//   },
//   xAxis: {
//     categories: [
//       'Amoniak',
//       'Urea',
//       'NPK',
//     ],
//     title: {
//       text: null
//     }
//   },
//   yAxis: {
//     min: 0,
//     title: {
//       text: 'Berat',
//       align: 'high'
//     },
//     labels: {
//       overflow: 'justify'
//     }
//   },
//   tooltip: {
//     valueSuffix: ' Tons'
//   },
//   plotOptions: {
//     bar: {
//       dataLabels: {
//         enabled: true
//       }
//     }
//   },
//   legend: {
//     layout: 'vertical',
//     align: 'right',
//     verticalAlign: 'top',
//     x: -40,
//     y: 80,
//     floating: true,
//     borderWidth: 1,
//     backgroundColor:
//       Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
//     shadow: true
//   },
//   credits: {
//     enabled: false
//   },
//   series: [{
//     data: [
//       { y: 100, color: '#00519B' },
//       { y: 893, color: '#74F7FF' },
//       { y: 182, color: '#F47920' },
//     ],
//     showInLegend: false,
//     name: '',
//   }]
// });
