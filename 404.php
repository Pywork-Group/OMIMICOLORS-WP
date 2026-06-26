<?php
get_header();
?>

<main class="main">
	<section class="error">
		<div class="container-lg">
			<div class="error__wrapper">
				<h1 class="error__heading">404</h1>
				<p class="error__description">
					Страница не найдена или была удалена
				</p>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="error__button primary-btn">
					На главную
				</a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();