jQuery(function ($) {
	$('.header__contact-button').on('click', function () {
		let popup = $(`
<div class="popup callback-popup">
    <div class="popup__modal">
        <div class="popup__head">
            <h3 class="popup__heading heading">Заказать звонок</h3>
            <button type="button" class="popup__close"><i class="fa-solid fa-xmark"></i></button>
        </div>
				<div class="popup__message"></div>
        <form class="popup__form">
				 		<input class="popup__form-input" type="text" name="name" placeholder="Ваше имя" required>
            <input class="popup__form-input phone-input" type="text" name="phone" placeholder="+7 (___) ___-__-__" required>
            <textarea class="popup__form-textarea" name="comment" placeholder="Комментарий (Опционально)"></textarea>
            <button class="popup__form-submit primary-btn" type="submit">Отправить</button>
						<div class="popup__form-loader primary-btn hidden">
							<svg fill="#FFFFFFFF" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".25"/><path d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z"><animateTransform attributeName="transform" type="rotate" dur="0.75s" values="0 12 12;360 12 12" repeatCount="indefinite"/></path></svg>
						</div>
        </form>
    </div>
</div>`).appendTo('body')

		let phoneInput = popup.find('.phone-input')[0]
		IMask(phoneInput, { mask: '+{7} (000) 000-00-00' })

		popup.find('.popup__close').on('click', function () {
			popup.remove()
		})

		popup.find('.popup__form').on('submit', function (e) {
			e.preventDefault()
			let $form = $(this)

			let name = $form.find('input[name="name"]').val().trim()
			let phone = $form.find('input[name="phone"]').val().trim()
			let comment = $form.find('textarea[name="comment"]').val().trim()

			if (!name) {
				popup.find('.popup__message').text('Введите имя')
				return
			}

			if (!/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/.test(phone)) {
				popup.find('.popup__message').text('Введите корректный номер телефона')
				return
			}

			let wordsCount = comment.split(/\s+/).filter(w => w.length > 0).length
			if (wordsCount > 100) {
				popup
					.find('.popup__message')
					.text('Комментарий не должен превышать 100 слов')
				return
			}

			var $btn = $('.popup__form-submit')
			var $loader = $btn.siblings('.popup__form-loader')
			$loader.toggleClass('hidden')
			$btn.toggleClass('hidden')

			$.ajax({
				url: my_ajax.ajax_url,
				type: 'POST',
				data: {
					action: 'send_callback',
					name: name,
					phone: phone,
					comment: comment,
				},
				dataType: 'json',
				success: function (res) {
					popup.find('.popup__message').text(res.message)
					if (res.status === 'success') $form[0].reset()

					$loader.toggleClass('hidden')
					$btn.toggleClass('hidden')
				},
				error: function () {
					popup
						.find('.popup__message')
						.text('Ошибка отправки. Попробуйте позже.')

					$loader.toggleClass('hidden')
					$btn.toggleClass('hidden')
				},
			})
		})
	})

	$(document).on('click', '.course__button', function () {
		let courseName = $(this).closest('.course').data('name')

		let popup = $(`
<div class="popup education-popup">
    <div class="popup__modal">
        <div class="popup__head">
            <h3 class="popup__heading heading">Записаться на курс</h3>
            <button type="button" class="popup__close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="popup__message"></div>
        <form class="popup__form">
            <input class="popup__form-input" type="text" name="name" placeholder="Ваше имя" required>
            <input class="popup__form-input phone-input" type="text" name="phone" placeholder="+7 (___) ___-__-__" required>
            <textarea class="popup__form-textarea" name="comment" placeholder="Комментарий (Опционально)"></textarea>
            <button class="popup__form-submit primary-btn" type="submit">Записаться</button>
						<div class="popup__form-loader primary-btn hidden">
							<svg fill="#FFFFFFFF" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".25"/><path d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z"><animateTransform attributeName="transform" type="rotate" dur="0.75s" values="0 12 12;360 12 12" repeatCount="indefinite"/></path></svg>
						</div>
        </form>
    </div>
</div>`).appendTo('body')

		let phoneInput = popup.find('.phone-input')[0]
		IMask(phoneInput, { mask: '+{7} (000) 000-00-00' })

		popup.find('.popup__close').on('click', function () {
			popup.remove()
		})

		popup.find('.popup__form').on('submit', function (e) {
			e.preventDefault()
			let $form = $(this)
			let name = $form.find('input[name="name"]').val().trim()
			let phone = $form.find('input[name="phone"]').val().trim()
			let comment = $form.find('textarea[name="comment"]').val().trim()

			if (!name) {
				popup.find('.popup__message').text('Введите имя')
				return
			}

			if (!/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/.test(phone)) {
				popup.find('.popup__message').text('Введите корректный номер телефона')
				return
			}

			var $btn = $('.popup__form-submit')
			var $loader = $btn.siblings('.popup__form-loader')
			$loader.toggleClass('hidden')
			$btn.toggleClass('hidden')

			$.ajax({
				url: my_ajax.ajax_url,
				type: 'POST',
				data: {
					action: 'send_education',
					name: name,
					phone: phone,
					comment: comment,
					course: courseName,
				},
				dataType: 'json',
				success: function (res) {
					popup.find('.popup__message').text(res.message)
					if (res.status === 'success') $form[0].reset()

					$loader.toggleClass('hidden')
					$btn.toggleClass('hidden')
				},
				error: function () {
					popup
						.find('.popup__message')
						.text('Ошибка отправки. Попробуйте позже.')

					$loader.toggleClass('hidden')
					$btn.toggleClass('hidden')
				},
			})
		})
	})

	$('.blog__catalog').on('click', '.blog__catalog-load', function () {
		const button = $(this)
		const loader = button.siblings('.blog__catalog-loader')

		loader.removeClass('hidden')
		button.addClass('hidden')

		let offset = parseInt(button.data('offset'))
		const posts_per_page = 3
		const cf_total = parseInt(button.data('cf-total'))
		const wp_total = parseInt(button.data('wp-total'))
		let shown = button.data('shown').toString().split(',').map(Number)
		const cf_ids = button.data('cf-count') > 0 ? shown.slice(0, cf_total) : []

		$.ajax({
			url: my_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'load_more_posts',
				offset: offset,
				posts_per_page: posts_per_page,
				shown: shown.join(','),
				cf_ids: cf_ids.join(','),
			},
			success: function (response) {
				if (response.trim() !== '') {
					$('.blog__posts').append(response)

					let new_ids = $(response)
						.map(function () {
							return parseInt($(this).data('id'))
						})
						.get()

					shown = shown.concat(new_ids)
					button.data('shown', shown.join(','))
					offset += new_ids.length
					button.data('offset', offset)

					const total_posts = cf_total + wp_total

					if (shown.length >= total_posts) {
						loader.addClass('hidden')
						button.addClass('hidden')
					} else {
						loader.addClass('hidden')
						button.removeClass('hidden')
					}
				} else {
					loader.addClass('hidden')
					button.addClass('hidden')
				}
			},
			error: function () {
				loader.addClass('hidden')
				button.removeClass('hidden')
			},
		})
	})

	$('.catalog__wrapper').on('click', '.courses__catalog-load', function () {
		const button = $(this)
		const loader = button.siblings('.courses__catalog-loader')

		loader.removeClass('hidden')
		button.addClass('hidden')

		let offset = parseInt(button.data('offset'))
		const posts_per_page = 10
		const total = parseInt(button.data('total'))

		$.ajax({
			url: my_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'load_more_courses',
				offset: offset,
				posts_per_page: posts_per_page,
			},
			success: function (response) {
				if (response.trim() !== '') {
					$('.catalog__courses').append(response)

					offset += posts_per_page
					button.data('offset', offset)

					if (offset >= total) {
						loader.addClass('hidden')
						button.addClass('hidden')
					} else {
						loader.addClass('hidden')
						button.removeClass('hidden')
					}
				} else {
					loader.addClass('hidden')
					button.addClass('hidden')
				}
			},

			error: function () {
				loader.addClass('hidden')
				button.removeClass('hidden')
			},
		})
	})

	$('.catalog__wrapper').on('click', '.catalog__load', function () {
		const button = $(this)
		const loader = button.siblings('.catalog__loader')

		loader.removeClass('hidden')
		button.addClass('hidden')

		let offset = parseInt(button.data('offset'))
		const posts_per_page = 10
		const total = parseInt(button.data('total'))

		$.ajax({
			url: my_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'load_more_blog_posts',
				offset: offset,
				posts_per_page: posts_per_page,
			},
			success: function (response) {
				if (response.trim() !== '') {
					$('.catalog__posts').append(response)

					offset += posts_per_page
					button.data('offset', offset)

					if (offset >= total) {
						loader.addClass('hidden')
						button.addClass('hidden')
					} else {
						loader.addClass('hidden')
						button.removeClass('hidden')
					}
				} else {
					loader.addClass('hidden')
					button.addClass('hidden')
				}
			},

			error: function () {
				loader.addClass('hidden')
				button.removeClass('hidden')
			},
		})
	})
})
