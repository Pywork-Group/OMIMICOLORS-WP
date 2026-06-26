<?php
$product = $args['product'] ?? null;
if (!$product)
    return;

$product_id = $product->get_id();
$variation_id = 0;
$class = $args['class'] ?? '';
$in_stock = $product->is_in_stock();

if ($product->is_type('variable')) {
    $variations = $product->get_available_variations();
    if (!empty($variations)) {
        $variation_id = $variations[0]['variation_id'];
        $variation = wc_get_product($variation_id);

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
} else {
    $regular_price = $product->get_regular_price() ?: 0;
    $sale_price = $product->get_sale_price() ?: 0;
    $image_id = $product->get_image_id();

    $sale_to = get_post_meta($product->get_id(), '_sale_price_dates_to', true);
    $sale_from = get_post_meta($product->get_id(), '_sale_price_dates_from', true);
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
?>

<li class="product <?php echo esc_attr($class); ?>">
    <div class="product__card">
        <div class="product__favorites primary-btn">
            <?php echo do_shortcode('[yith_wcwl_add_to_wishlist 
    product_id="' . $product_id . '" 
]'); ?>
        </div>
        <a class='product__link' href="<?php echo get_permalink($product->get_id()); ?>">
            <div class="product__thumbnail">
                <?php if ($image_id) {
                    echo wp_get_attachment_image($image_id, 'medium');
                } ?>
                <div class="product__badges badges">
                    <?php if ($is_sale): ?>
                        <span class="product__badge badge-sale">Акция</span>
                    <?php endif; ?>

                    <?php if ($is_hit): ?>
                        <span class="product__badge badge-hit">Хит</span>
                    <?php endif; ?>

                    <?php if ($is_new): ?>
                        <span class="product__badge badge-new">Новинка</span>
                    <?php endif; ?>

                    <?php if ($recommended): ?>
                        <span class="product__badge badge-recommended">Советуем</span>
                    <?php endif; ?>

                    <?php if ($has_timer): ?>
                        <div class="product__badge badge-timer" data-sale-to="<?php echo esc_attr($sale_to); ?>">
                            <i class="bi bi-lightning-fill"></i>
                            <span class="timer"></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="product__details">
                <div class="product__price">
                    <?php if ($sale_price && $sale_price != $regular_price): ?>
                        <div class="product__price-current"><?php echo wc_price($sale_price); ?> /шт</div>
                        <div class="product__price-sale"><?php echo wc_price($regular_price); ?></div>
                        <div class="product__price-off">
                            -<?php echo round((($regular_price - $sale_price) / $regular_price) * 100); ?>%
                        </div>
                    <?php else: ?>
                        <div class="product__price-current"><?php echo wc_price($regular_price); ?> /шт</div>
                    <?php endif; ?>
                </div>

                <h3 class='product__name'><?php echo esc_html($product->get_name()); ?></h3>

                <div class="product__stats">
                    <div class="product__rating">
                        <i class="bi bi-star-fill"></i>
                        <span><?php echo $average_rating; ?></span>
                    </div>
                    <div class="product__comments">
                        <i class="bi bi-chat"></i>
                        <span><?php echo $rating_count; ?></span>
                    </div>
                    <div class="product__stock <?php echo $in_stock ? 'in-stock' : 'out-of-stock'; ?>">
                        <i class="fa-solid <?php echo $in_stock ? 'fa-circle-check' : 'fa-circle-xmark'; ?>"></i>
                        <span><?php echo $in_stock ? 'В наличии' : 'Нет в наличии'; ?></span>
                    </div>
                </div>
            </div>
        </a>
        <?php
        get_template_part('components/loader', null, array(
            'class' => 'product__cart-loader loader primary-btn hidden'
        ));
        ?>
        <?php
        if ($in_stock) {
            if ($product->is_type('variable') && !empty($variations)) {
                $first_variation = wc_get_product($variations[0]['variation_id']);
                $product_id = $first_variation->get_id();
                $product_sku = $first_variation->get_sku();
                $add_to_cart_url = $first_variation->add_to_cart_url();
            } else {
                $product_id = $product->get_id();
                $product_sku = $product->get_sku();
                $add_to_cart_url = $product->add_to_cart_url();
            }
            echo sprintf(
                '<a href="%s" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart product__cart primary-btn" data-product_id="%s" data-product_sku="%s" aria-label="Добавить %s в корзину" rel="nofollow">
            В корзину
        </a>',
                esc_url($add_to_cart_url),
                esc_attr($product_id),
                esc_attr($product_sku),
                esc_attr($product->get_name())
            );

        }
        ?>
    </div>
</li>