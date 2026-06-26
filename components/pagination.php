<?php
$total_pages = $args['total_pages'] ?? null;
$class = $args['class'] ?? '';

if ($total_pages > 1): ?>
	<div class="pagination <?php echo esc_attr($class); ?>">
		<?php
		$params = $_GET;
		$current = $params['page'] ?? 1;

		unset($params['page']);

		function build_page_link($page, $params)
		{
			$params['page'] = $page;
			return '?' . http_build_query($params);
		}

		for ($i = 1; $i <= $total_pages; $i++) {

			if ($i == 1 || $i == $total_pages || ($i >= $current - 2 && $i <= $current + 2)) {

				if ($i == $current) {
					echo '<span class="pagination__current">' . $i . '</span>';
				} else {
					echo '<a class="pagination__button" href="' . build_page_link($i, $params) . '">' . $i . '</a>';
				}

			} elseif ($i == 2 || $i == $total_pages - 1) {
				echo '<span class="pagination__dots">...</span>';
			}
		}
		?>
	</div>
<?php endif; ?>