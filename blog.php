<?php
/*
Template Name: Страница блога
*/

get_header();

$title = get_the_title();

$items = [];
$items[] = ['label' => 'Главная', 'url' => home_url('/')];
$items[] = ['label' => $title, 'url' => ''];

$posts_per_page = 10;

$args = [
	'post_type' => 'post',
	'posts_per_page' => $posts_per_page,
	'post_status' => 'publish',
	'orderby' => 'date',
	'order' => 'DESC',
];

$initial_posts = get_posts($args);
$total_wp = wp_count_posts('post')->publish;
?>

<main class="main">
	<section class="catalog blog__catalog">
		<div class="container-lg">

			<?php get_template_part('components/breadcrumb', null, ['items' => $items]); ?>

			<h1 class="catalog__heading heading"><?php echo esc_html($title); ?></h1>

			<div class="catalog__wrapper">

				<ul class="catalog__posts">
					<?php
					foreach ($initial_posts as $post):
						setup_postdata($post);

						get_template_part('template-parts/post', null, [
							'post' => $post,
							'class' => 'catalog__post'
						]);

					endforeach;

					wp_reset_postdata();
					?>
				</ul>

				<?php if (count($initial_posts) < $total_wp): ?>

					<?php
					get_template_part('components/loader', null, array(
						'class' => 'catalog__load catalog__loader hidden'
					));
					?>

					<button class="catalog__load" data-offset="<?php echo count($initial_posts); ?>"
						data-total="<?php echo $total_wp; ?>">
						Загрузить еще
					</button>

				<?php endif; ?>

			</div>
		</div>
	</section>
</main>

<?php
get_footer();