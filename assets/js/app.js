jQuery(function ($) {
	$('.header__burger-toggle').on('click', function () {
		$('.header__burger').remove()

		let $mobileMenu = $('<ul class="header__burger-menu"></ul>')

		$('.header__menu-list').each(function () {
			let $items = $(this).children().clone()
			$mobileMenu.append($items)
		})

		let $burger = $('<div class="header__burger"></div>')

		let $closeBtn = $(
			'<button class="header__burger-close"><i class="bi bi-x-lg"></i></button>',
		)

		$closeBtn.on('click', function () {
			$burger.remove()
		})

		$burger.append($closeBtn)
		$burger.append($mobileMenu)

		$('.header__content-wrapper').append($burger)
	})

	$('.badges').each(function () {
		var $badgesWrapper = $(this)
		var $timerBadge = $badgesWrapper.find('.badge-timer')
		var $saleBadge = $badgesWrapper.find('.badge-sale')

		if (!$timerBadge.length) return

		var endTime = parseInt($timerBadge.data('sale-to'))
		if (!endTime || isNaN(endTime)) return
		endTime *= 1000

		var $timerEl = $timerBadge.find('.timer')

		function updateTimer() {
			var now = new Date().getTime()
			var distance = endTime - now

			if (distance <= 0) {
				$timerBadge.remove()
				$saleBadge.remove()
			} else {
				var days = Math.floor(distance / (1000 * 60 * 60 * 24))
				var hours = Math.floor(
					(distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60),
				)
				var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
				var seconds = Math.floor((distance % (1000 * 60)) / 1000)

				$timerEl.text(
					days + ' д. ' + hours + ' ч. ' + minutes + ' м. ' + seconds + ' с.',
				)
			}
		}

		updateTimer()
		setInterval(updateTimer, 1000)
	})

	$(document).on('click', '.add_to_cart_button', function () {
		var $btn = $(this)
		var $loader = $btn.siblings('.loader')
		$loader.removeClass('hidden')
		$btn.addClass('hidden')
	})

	$(document.body).on(
		'added_to_cart',
		function (event, fragments, cart_hash, $button) {
			var $btn = $button
			var $loader = $btn.siblings('.loader')
			$loader.toggleClass('hidden')
			$btn.toggleClass('hidden')
		},
	)

	document.querySelectorAll('.lightgallery').forEach(function (gallery) {
		lightGallery(gallery, {
			plugins: [lgZoom, lgThumbnail, lgFullscreen],
			speed: 500,
			thumbnail: true,
			zoom: true,
			fullScreen: true,
			selector: 'a',
		})
	})
})
