$(document).ready(function () {
	var swiper = new Swiper(".article-swiper", {
	slidesPerView: 3,
	spaceBetween: 10,
	navigation: {
	  nextEl: ".article-slider-next",
	  prevEl: ".article-slider-prev",
	},

	pagination: {
        el: '.swiper-pagination',
        clickable: true,
        renderBullet: function (index, className) {
          return '<span class="' + className + '">' + (index + 1) + '</span>';
        },
      },
	breakpoints: {
	  0: {
		slidesPerView: 1,
		spaceBetween: 10,
	  },
	  992: {
		slidesPerView: 2,
		spaceBetween: 20,
	  },
	  1200: {
		slidesPerView: 3,
		spaceBetween: 10,
	  },
	  1451: {
		slidesPerView: 3,
		spaceBetween: 30,
	  },
	},
  });
  if (slidesCountArt === 0) {
	$(".articlestitle").addClass("nodisplay");
  }
  else {
	$(".articlestitle").removeClass("nodisplay");
  }
});