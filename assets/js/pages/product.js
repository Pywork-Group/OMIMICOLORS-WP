jQuery(function ($) {
	const main = new Swiper('.card__gallery', {
		slidesPerView: 1,
		loop: true,
		grabCursor: true,
		speed: 800,
		effect: 'fade',
		fadeEffect: {
			crossFade: true,
		},
		autoplay: {
			delay: 5000,
			disableOnInteraction: false,
		},
		navigation: {
			nextEl: '.card__gallery-next',
			prevEl: '.card__gallery-prev',
		},
		pagination: {
			el: '.card__gallery-dots',
			clickable: true,
		},
	})

	const tabs = document.querySelectorAll('.card__info-tab')
	const blocks = {
		description: document.querySelector('.card__info-description'),
		characteristics: document.querySelector('.card__info-characteristics'),
	}

	tabs.forEach((tab, index) => {
		tab.addEventListener('click', function () {
			tabs.forEach(t => t.classList.remove('picked'))

			this.classList.add('picked')

			Object.values(blocks).forEach(el => {
				if (el) el.classList.remove('picked')
			})

			if (index === 0) {
				blocks.description?.classList.add('picked')
			} else {
				blocks.characteristics?.classList.add('picked')
			}
		})
	})
})
