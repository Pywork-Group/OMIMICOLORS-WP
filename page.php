<?php
get_header();
?>
<main class="main">
	<section class="page<?php
	if (is_account_page()) {
		echo is_user_logged_in() ? ' account' : ' auth';
	}
?>">
		<div class="container-lg">
			<div class="page__wrapper">
				<?php if (!is_account_page()): ?>
					<h1 class="page__heading heading">
						<?php the_title(); ?>
					</h1>
				<?php endif; ?>
				<div class="page__content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();