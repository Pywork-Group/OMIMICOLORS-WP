jQuery(function ($) {
	const coursesSwiper = new Swiper('.courses__swiper', {
		loop: true,
		navigation: {
			nextEl: '.courses__slider-next',
			prevEl: '.courses__slider-prev',
		},
		autoplay: {
			delay: 5000,
			disableOnInteraction: false,
		},
		speed: 800,
	})

	$('.courses__tab').on('click', function () {
		const index = $(this).data('tab')

		coursesSwiper.slideToLoop(index)

		$('.courses__tab').removeClass('picked')
		$(this).addClass('picked')
	})

	coursesSwiper.on('slideChange', function () {
		const realIndex = coursesSwiper.realIndex

		$('.courses__tab').removeClass('picked')
		$('.courses__tab[data-tab="' + realIndex + '"]').addClass('picked')

		const $currentSlide = $(coursesSwiper.slides[realIndex])

		const courseName = $currentSlide.data('name')

		$('.courses__heading').text(courseName)
	})
})
