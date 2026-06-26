jQuery(function ($) {
	$(document).on('input', '.catalog__filter-search', function () {
		const val = $(this).val().toLowerCase()

		const $items = $(this).next('ul').find('li')

		$items.each(function () {
			const text = $(this).text().toLowerCase()

			if (text.includes(val)) {
				$(this).show()
			} else {
				$(this).hide()
			}
		})
	})

	$(document).on('click', '.catalog__toggle', function () {
		$('.catalog__filters').addClass('active')
	})
	$(document).on('click', '.catalog__close', function () {
		$('.catalog__filters').removeClass('active')
	})
})
