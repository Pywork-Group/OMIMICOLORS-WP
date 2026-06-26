<?php
/*
Template Name: Страница курсов
*/

get_header();

$title = get_the_title();

$items = [];
$items[] = [ 'label' => 'Главная', 'url' => home_url('/') ];
$items[] = [ 'label' => $title, 'url' => '' ];

$posts_per_page = 10;

$args = [
	'post_type' => 'course',
	'post_status' => 'publish',
	'posts_per_page' => $posts_per_page,
	'orderby' => 'date',
	'order' => 'DESC',
	'offset' => 0,
];

$query = new WP_Query($args);
$total = wp_count_posts('course')->publish;
?>

<main class="main">
	<section class="catalog">
		<div class="container-lg">
			<?php get_template_part('components/breadcrumb', null, [ 'items' => $items ]); ?>
			<h1 class="catalog__heading heading">
				<?php echo esc_html($title); ?>
			</h1>

			<div class="catalog__wrapper">

				<ul class="catalog__courses">
					<?php if ($query->have_posts()):
						while ($query->have_posts()): $query->the_post(); ?>

							<?php get_template_part('template-parts/course', null, [
								'course_id' => get_the_ID(),
								'class' => ''
							]); ?>

						<?php endwhile;
						wp_reset_postdata();
					endif; ?>
				</ul>

				<?php if ($total > $posts_per_page): 
					get_template_part('components/loader', null, array(
            'class' => 'courses__catalog-load courses__catalog-loader hidden'
          ));	
				?>
					<button class="courses__catalog-load"
						data-offset="<?php echo $posts_per_page; ?>"
						data-total="<?php echo $total; ?>">
						Загрузить ещё
					</button>
				<?php endif; ?>

			</div>

		</div>
	</section>
</main>

<?php get_footer(); ?>