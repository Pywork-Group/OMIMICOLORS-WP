<!-- https://dribbble.com/shots/26471970-Shopify-Product-Page-Design-High-Converting-Supplement-PDP -->
<?php
get_header();

$product = wc_get_product(get_the_ID());

if (!$product)
	return;

$selected_variation_id = isset($_GET['variation_id']) ? intval($_GET['variation_id']) : 0;

$items = [];
$items[] = [
	'label' => 'Главная',
	'url' => home_url('/')
];
$items[] = [
	'label' => 'Каталог',
	'url' => get_permalink(wc_get_page_id('shop'))
];

$product_id = $product->get_id();
$terms = get_the_terms($product_id, 'product_cat');

if ($terms && !is_wp_error($terms)) {

	usort($terms, function ($a, $b) {
		return count(get_ancestors($b->term_id, 'product_cat')) - count(get_ancestors($a->term_id, 'product_cat'));
	});

	$term = $terms[0];

	$parents = get_ancestors($term->term_id, 'product_cat');
	$parents = array_reverse($parents);

	foreach ($parents as $parent_id) {
		$parent = get_term($parent_id, 'product_cat');

		if ($parent && !is_wp_error($parent)) {
			$items[] = [
				'label' => $parent->name,
				'url' => get_term_link($parent)
			];
		}
	}

	$items[] = [
		'label' => $term->name,
		'url' => get_term_link($term)
	];

	$term_ids = wp_list_pluck($terms, 'term_id');

	$args = [
		'post_type' => 'product',
		'posts_per_page' => 10,
		'post_status' => 'publish',
		'meta_key' => 'total_sales',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'post__not_in' => [$product_id],
		'tax_query' => [
			[
				'taxonomy' => 'product_cat',
				'field' => 'term_id',
				'terms' => $term_ids
			]
		]
	];

	$query = new WP_Query($args);
}

$items[] = [
	'label' => get_the_title($product_id),
	'url' => ''
];

$gallery_ids = get_post_meta($product_id, '_product_image_gallery', true);
$gallery_ids = $gallery_ids ? explode(',', $gallery_ids) : [];

$media_ids = [];

if (has_post_thumbnail($product_id)) {
	$media_ids[] = get_post_thumbnail_id($product_id);
}

$media_ids = array_merge($media_ids, $gallery_ids);
$variation_id = 0;
$in_stock = $product->is_in_stock();

if ($product->is_type('variable')) {
	$variations = $product->get_available_variations();

	if (!empty($variations)) {
		if ($selected_variation_id) {
			$variation = wc_get_product($selected_variation_id);

			if ($variation && $variation->exists()) {
				$variation_id = $variation->get_id();
			} else {
				$variation_id = $variations[0]['variation_id'];
				$variation = wc_get_product($variation_id);
			}
		} else {
			$variation_id = $variations[0]['variation_id'];
			$variation = wc_get_product($variation_id);
		}

		$regular_price = $variation->get_regular_price() ?: 0;
		$sale_price = $variation->get_sale_price() ?: 0;
		$image_id = $variation->get_image_id() ?: $product->get_image_id();

		$sale_to = get_post_meta($variation->get_id(), '_sale_price_dates_to', true);
		$sale_from = get_post_meta($variation->get_id(), '_sale_price_dates_from', true);

	} else {
		$regular_price = $sale_price = 0;
		$image_id = $product->get_image_id();
		$sale_to = $sale_from = 0;
	}
}

$average_rating = $product->get_average_rating();
$rating_count = $product->get_rating_count();

$now = current_time('timestamp', true);
$sale_to = (int) $sale_to;
$is_sale = $sale_price && $sale_price < $regular_price;
$has_timer = $is_sale && $sale_to && $sale_to > $now;

$total_sales = $product->get_total_sales();
$product_date = strtotime($product->get_date_created());
$is_new = ($now - $product_date) <= WEEK_IN_SECONDS;
$is_hit = $total_sales >= 10;
$recommended = carbon_get_post_meta($product->get_id(), 'recommended_badge');
$video = carbon_get_post_meta($product_id, 'video');
?>

<main class="main">
	<section class="card">
		<div class="container-lg">
			<?php
			get_template_part('components/breadcrumb', null, [
				'items' => $items,
			]);
			?>
			<div class="card__wrapper">
				<?php if (!empty($media_ids)) { ?>
					<div class="card__media">
						<div class="card__favorites primary-btn">
							<?php echo do_shortcode('[yith_wcwl_add_to_wishlist 
    product_id="' . $product_id . '" 
]'); ?>
						</div>
						<div class="card__gallery swiper">
							<div class="card__gallery-wrapper swiper-wrapper">
								<?php foreach ($media_ids as $id): ?>
									<div class="card__gallery-item swiper-slide">
										<?php echo wp_get_attachment_image($id, 'large'); ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
						<button type='button' class="card__gallery-prev"><i class="fa-solid fa-arrow-left"></i></button>
						<button type='button' class="card__gallery-next"><i class="fa-solid fa-arrow-right"></i></button>
						<div class="card__gallery-dots swiper-pagination"></div>
					</div>
				<?php } ?>
				<div class="card__details">
					<div class="card__head">
						<div class="card__head-box">
							<div class="card__badges badges">
								<?php if ($is_sale): ?>
									<span class="card__badge badge-sale">Акция</span>
								<?php endif; ?>

								<?php if ($is_hit): ?>
									<span class="card__badge badge-hit">Хит</span>
								<?php endif; ?>

								<?php if ($is_new): ?>
									<span class="card__badge badge-new">Новинка</span>
								<?php endif; ?>

								<?php if ($recommended): ?>
									<span class="card__badge badge-recommended">Советуем</span>
								<?php endif; ?>

								<?php if ($has_timer): ?>
									<div class="card__badge badge-timer" data-sale-to="<?php echo esc_attr($sale_to); ?>">
										<i class="bi bi-lightning-fill"></i>
										<span class="timer"></span>
									</div>
								<?php endif; ?>
							</div>
							<div class="card__reviews">
								<i class="bi bi-star-fill"></i>
								<span class="card__reviews-avg"><?php echo $average_rating; ?></span>
								<a href="#reviews" class="card__reviews-count">
									<?php echo $rating_count; ?> отзывов
								</a>
							</div>
						</div>
						<h1 class="card__heading">
							<?php echo esc_html($product->get_name()); ?>
						</h1>
					</div>
					<div class="card__body">
						<div class="card__price">
							<?php if ($sale_price && $sale_price != $regular_price): ?>
								<div class="card__price-current"><?php echo wc_price($sale_price); ?> /шт</div>
								<div class="card__price-sale"><?php echo wc_price($regular_price); ?></div>
								<div class="card__price-off">
									-<?php echo round((($regular_price - $sale_price) / $regular_price) * 100); ?>%
								</div>
							<?php else: ?>
								<div class="card__price-current"><?php echo wc_price($regular_price); ?> /шт</div>
							<?php endif; ?>
						</div>
						<div class="card__stock <?php echo $in_stock ? 'in-stock' : 'out-of-stock'; ?>">
							<i class="fa-solid <?php echo $in_stock ? 'fa-circle-check' : 'fa-circle-xmark'; ?>"></i>
							<span><?php echo $in_stock ? 'В наличии' : 'Нет в наличии'; ?></span>
						</div>
						<?php if (!empty($variations)): ?>
							<ul class="card__variations">
								<?php foreach ($variations as $var):
									$variation = wc_get_product($var['variation_id']);

									if (!$variation)
										continue;

									$is_current = $variation_id === $variation->get_id();
									$img_id = $variation->get_image_id() ?: $product->get_image_id();
									$url = add_query_arg([
										'variation_id' => $variation->get_id()
									], get_permalink($product_id));
									?>
									<li class="card__variation">
										<?php if ($is_current): ?>
											<div class="card__variation-link current">
												<?php echo wp_get_attachment_image($img_id, 'medium'); ?>
											</div>
										<?php else: ?>
											<a href="<?php echo esc_url($url); ?>" class="card__variation-link">
												<?php echo wp_get_attachment_image($img_id, 'medium'); ?>
											</a>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<div class="card__info">
							<div class="card__info-tabs">
								<button type='button' class="card__info-tab picked">
									Описание
								</button>
								<button type='button' class="card__info-tab">
									Характеристики
								</button>
							</div>
							<div class="card__info-items">
								<div class="card__info-description picked">
									<?php echo apply_filters('the_content', $product->get_description()); ?>
								</div>
								<ul class="card__info-characteristics">
									<?php
									$attributes = $product->get_attributes();

									if (!empty($attributes)):
										foreach ($attributes as $attribute):

											if ($attribute->is_taxonomy()) {
												$terms = wc_get_product_terms(
													$product->get_id(),
													$attribute->get_name(),
													['fields' => 'names']
												);
												$value = implode(', ', $terms);
												$label = wc_attribute_label($attribute->get_name());
											} else {
												$label = $attribute->get_name();
												$value = implode(', ', $attribute->get_options());
											}
											?>
											<li class="card__info-characteristic">
												<span>
													<?php echo esc_html($label); ?>:
												</span>
												<span>
													<?php echo esc_html($value); ?>
												</span>
											</li>
											<?php
										endforeach;
									endif;
									?>
								</ul>
							</div>
						</div>
					</div>
					<div class="card__foot">
						<?php
						get_template_part('components/loader', null, array(
							'class' => 'card__cart-loader loader primary-btn hidden'
						));
						?>
						<?php
						if ($in_stock) {
							if ($product->is_type('variable') && !empty($variations)) {
								$first_variation = $variation_id
		? wc_get_product($variation_id)
		: wc_get_product($variations[0]['variation_id']);
								$product_id = $first_variation->get_id();
								$product_sku = $first_variation->get_sku();
								$add_to_cart_url = $first_variation->add_to_cart_url();
							} else {
								$product_id = $product->get_id();
								$product_sku = $product->get_sku();
								$add_to_cart_url = $product->add_to_cart_url();
							}
							echo sprintf(
								'<a href="%s" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart card__cart primary-btn" data-product_id="%s" data-product_sku="%s" aria-label="Добавить %s в корзину" rel="nofollow">
								<i class="fa-solid fa-cart-plus"></i>
								<span>В корзину</span>
							</a>',
								esc_url($add_to_cart_url),
								esc_attr($product_id),
								esc_attr($product_sku),
								esc_attr($product->get_name())
							);
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php if ($video) { ?>
		<section class='video'>
			<div class="container-lg">
				<div class="video__wrapper">
					<video-player>
						<video-skin>
							<video src="<?php echo esc_url($video); ?>" playsinline></video>
						</video-skin>
					</video-player>
				</div>
			</div>
		</section>
	<?php } ?>
	<?php if ($query->have_posts()) { ?>
		<section class="catalog">
			<div class="container-lg catalog__wrapper">
				<div class="catalog__head">
					<h2 class="catalog__heading heading">
						Похожие товары
					</h2>
					<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="catalog__more">Весь
						каталог</a>
				</div>

				<ul class="catalog__products">
					<?php while ($query->have_posts()) {
						$query->the_post();
						global $product;

						get_template_part('template-parts/product', null, array(
							'product' => $product,
							'class' => 'catalog__product'
						));

						wp_reset_postdata();
					} ?>
				</ul>
			</div>
		</section>
	<?php } ?>
</main>

<?php get_footer(); ?>