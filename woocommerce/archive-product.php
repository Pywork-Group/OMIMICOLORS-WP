<?php
get_header();

$page = $_GET['page'] ?? 1;
$search = $_GET['s'] ?? '';
$stock = $_GET['stock'] ?? '';
$sort = $_GET['sort'] ?? 'hit';
$price_min = $_GET['price_min'] ?? '';
$price_max = $_GET['price_max'] ?? '';
$items = [];

$items[] = [
    'label' => 'Главная',
    'url' => home_url('/')
];

$items[] = [
    'label' => 'Каталог',
    'url' => !is_shop() ? get_permalink(wc_get_page_id('shop')) : ''
];

if (is_product_category()) {
    $current = get_queried_object();

    if (!empty($current->parent)) {
        $parent = get_term($current->parent, 'product_cat');

        $items[] = [
            'label' => $parent->name,
            'url' => get_term_link($parent)
        ];
    }

    $items[] = [
        'label' => $current->name
    ];
}

$tax_query = [
    'relation' => 'AND'
];

$meta_query = [];
$current_cat = get_queried_object();

if (is_product_category() && !empty($current_cat->term_id)) {
    $tax_query[] = [
        'taxonomy' => 'product_cat',
        'field' => 'term_id',
        'terms' => $current_cat->term_id
    ];
}

$orderby = 'menu_order';
$order = 'ASC';
$meta_key = '';

switch ($sort) {

    case 'new':
        $orderby = 'date';
        $order = 'DESC';
        break;

    case 'hit':
        $meta_key = 'total_sales';
        $orderby = 'meta_value_num';
        $order = 'DESC';
        break;

    case 'recommended':
        $meta_key = 'recommended_badge';
        $orderby = 'meta_value';
        break;

    case 'sale':
        $meta_query[] = [
            'key' => '_sale_price',
            'value' => 0,
            'compare' => '>',
            'type' => 'NUMERIC'
        ];
        break;
}

if ($stock === 'instock') {
    $meta_query[] = [
        'key' => '_stock_status',
        'value' => 'instock'
    ];
}

foreach ($_GET as $key => $value) {
    if (strpos($key, 'pa_') === 0 && !empty($value)) {
        $tax_query[] = [
            'taxonomy' => $key,
            'field' => 'slug',
            'terms' => $value
        ];
    }
}

if ($price_min || $price_max) {

    $min_price = $price_min ?: 0;
    $max_price = $price_max ?: 999999999;

    $meta_query[] = [
        'key' => '_price',
        'value' => [(float)$min_price, (float)$max_price],
        'compare' => 'BETWEEN',
        'type' => 'NUMERIC'
    ];
}

$is_shop = is_shop();
$is_category = is_product_category();

$parent_categories = get_terms([
    'taxonomy' => 'product_cat',
    'parent' => 0,
    'hide_empty' => false
]);

$child_categories = [];

if ($is_category && !empty($current_cat->term_id)) {
    $child_categories = get_terms([
        'taxonomy' => 'product_cat',
        'parent' => $current_cat->term_id,
        'hide_empty' => false
    ]);
}

$args = [
    'post_type' => 'product',
    'paged' => $page,
    'posts_per_page' => 24,
    's' => $search,
    'meta_query' => $meta_query,
    'tax_query' => $tax_query,
    'orderby' => $orderby,
    'order' => $order,
    'meta_key' => $meta_key
];

$query = new WP_Query($args);
?>

<main class="main">
	<section class="catalog">
		<div class="container-lg">
            <?php
            get_template_part('components/breadcrumb', null, [
                'items' => $items
            ]);
            ?>
            <h1 class="catalog__heading heading">
                <?php
                if (is_product_category()) {
                    echo single_term_title('', false) . ' (' . $query->found_posts . ' товаров)';
                } else {
                    echo 'Весь каталог (' . $query->found_posts . ' товаров)';
                }
                ?>
            </h1>

			<div class="catalog__wrapper">
        <div class="catalog__filters">
            <button type='button' class="catalog__close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            				<form class="catalog__filters-form">



                <?php if (($is_shop && !empty($parent_categories)) || ($is_category && !empty($child_categories))): ?>
                <div class="catalog__filter">
                    <h4 class='catalog__filter-heading'>Категории</h4>
                    <input class="catalog__filter-search" type="text" placeholder="Поиск...">
                    <ul class="catalog__filter-list">

                        <?php
                        $cats = $is_category ? $child_categories : $parent_categories;

                        foreach ($cats as $cat): ?>
                            <li class="catalog__filter-item">
                                <a class="catalog__filter-link"
                                   href="<?php echo get_term_link($cat); ?>">
                                    <?php echo $cat->name; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
                <?php endif; ?>

               <div class="catalog__filter">
    <h4 class='catalog__filter-heading'>Цена</h4>

    <div class="catalog__filter-fields">
        <input class='catalog__filter-field' type="number"
               name="price_min"
               placeholder="От"
               value="<?php echo esc_attr($_GET['price_min'] ?? ''); ?>">

        <input class='catalog__filter-field' type="number"
               name="price_max"
               placeholder="До"
               value="<?php echo esc_attr($_GET['price_max'] ?? ''); ?>">
    </div>
</div>

          <?php
          $allowed_filters = ['pa_color', 'pa_volume'];

$attributes = wc_get_attribute_taxonomies();

foreach ($attributes as $attr) {

    $taxonomy = 'pa_' . $attr->attribute_name;

    if (!in_array($taxonomy, $allowed_filters)) {
        continue;
    }

    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false
    ]);

    $selected_terms = $_GET[$taxonomy] ?? [];
          ?>

          <div class="catalog__filter">
            <h4 class='catalog__filter-heading'><?php echo $attr->attribute_label; ?></h4>
            <input class="catalog__filter-search" type="text" placeholder="Поиск...">
            <ul class="catalog__filter-list">
              <?php foreach ($terms as $term): ?>
              <li class="catalog__filter-item">
                <label class="catalog__filter-label">
                  <input class="catalog__filter-checkbox"
                         type="checkbox"
                         name="<?php echo $taxonomy; ?>[]"
                         value="<?php echo $term->slug; ?>"
                         <?php checked(in_array($term->slug, (array)$selected_terms)); ?>>
                  <?php echo $term->name; ?>
                </label>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <?php } ?>

          <button class='catalog__filters-submit primary-btn' type="submit">
              Применить
          </button>

          <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>"
             class="catalog__filters-reset primary-btn-border">
              Сбросить
          </a>

        </form>
                </div>

				<div class="catalog__box">
                    <div class="catalog__head">
                <button type='button' class="catalog__toggle">
                    <i class="fa-solid fa-sliders"></i>
                </button>
					<form class='catalog__search' method="GET">
						<input class='catalog__search-field' type="text" name="s" value="<?php echo esc_attr($search); ?>" placeholder='Поиск...'>
						<button class='catalog__search-submit' type="submit"><i class="fa-brands fa-sistrix"></i></button>
					</form>
                    </div>


					<div class="catalog__feed">

					<?php if ($query->have_posts()): ?>

						<ul class="catalog__products">
							<?php while ($query->have_posts()): $query->the_post();
								global $product;
								get_template_part('template-parts/product', null, [
									'product' => $product,
									'class' => 'catalog__product'
								]);
							endwhile; ?>
						</ul>
                        <?php
                        get_template_part('components/pagination', null, [
							'total_pages' => $query->max_num_pages,
							'class' => 'catalog__pagination'
						]);
                        ?>
					<?php else: ?>
						<p class="catalog__empty">😕 Товары не найдены</p>
					<?php endif; ?>

					</div>

				</div>

			</div>
		</div>
	</section>
</main>

<?php
wp_reset_postdata();
get_footer();