<?php get_header(); ?>

<?php
if (is_single()) {
	set_post_views(get_the_ID());
}

$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
$categories = get_the_category();
$date = get_the_date();
$views = get_post_views(get_the_ID());
?>

<main class="main">
	<section class="single">
		<div class="container-lg">
			<div class="single__wrapper">
				<div class="single__thumbnail">
					<?php if ($thumbnail): ?>
						<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php the_title(); ?>">
					<?php endif; ?>
				</div>
				<div class="single__content">

					<ul class="single__terms">

						<?php if ($categories): ?>
							<li class="single__term">
								<?php echo esc_html($categories[0]->name); ?>
							</li>
						<?php endif; ?>

						<li class="single__term">
							<?php echo esc_html($date); ?>
						</li>

						<li class="single__term">
							<i class="fa-solid fa-eye"></i>
							<span><?php echo $views; ?></span>
						</li>

					</ul>
					<div class="single__body">
						<?php the_content(); ?>
					</div>
					<div class="single__share">
						<span>Поделиться:</span>
						<?php echo do_shortcode('[Sassy_Social_Share]'); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>