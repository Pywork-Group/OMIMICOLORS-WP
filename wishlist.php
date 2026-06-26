<?php
/*
Template Name: Избранное
*/

get_header();

$items = [];
$items[] = [
	'label' => 'Главная',
	'url' => home_url('/')
];
$items[] = [
	'label' => 'Избранное',
];
?>
<section class="catalog">
	<div class="container-lg catalog__wrapper">
		<?php
		get_template_part('components/breadcrumb', null, [
			'items' => $items,
		]);
		?>
		<div class="catalog__head">
			<h2 class="catalog__heading heading">
				<?php the_title(); ?>
			</h2>
			<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="catalog__more">Весь
				каталог</a>
		</div>

		<ul class="catalog__products">
			<?php
			$wishlist_products_ids = [];

			if (function_exists('YITH_WCWL') && class_exists('YITH_WCWL_Wishlist_Factory')) {

				$wishlist = YITH_WCWL_Wishlist_Factory::get_current_wishlist();

				if ($wishlist) {
					$items = $wishlist->get_items();

					if (!empty($items)) {
						foreach ($items as $item) {
							$wishlist_products_ids[] = $item->get_product_id();
						}
					}
				}
			}
			
			if (!empty($wishlist_products_ids)) {

				$query = new WP_Query([
					'post_type' => 'product',
					'post__in' => $wishlist_products_ids,
					'orderby' => 'post__in'
				]);

				while ($query->have_posts()) {
					$query->the_post();
					global $product;

					get_template_part('template-parts/product', null, array(
						'product' => $product,
						'class' => 'catalog__product'
					));
				}

				wp_reset_postdata();

			} else {
				echo '<p>В избранном пока ничего нет</p>';
			}
			?>
		</ul>
	</div>
</section>

<?php
get_footer();
?>