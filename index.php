<?php
get_header();
?>

<main class="main">

    <!-- Hero секция -->
    <?php
    $hero_image_id = carbon_get_theme_option('home_hero_image');
    $hero_image_alt = get_post_meta($hero_image_id, '_wp_attachment_image_alt', true);
    $hero_image_url = wp_get_attachment_url($hero_image_id);
    ?>
    <?php if ($hero_image_id): ?>
        <section class="hero">
            <div class="container-lg">
                <div class="hero__wrapper">
                    <img src="<?php echo esc_url($hero_image_url); ?>" alt="<?php echo esc_attr($hero_image_alt); ?>">
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php

    $products_heading = carbon_get_theme_option('home_products-heading');
    $selected_products = carbon_get_theme_option('home_products');

    if (empty($selected_products)) {
        $products = wc_get_products(array(
            'limit' => 10,
            'orderby' => 'total_sales',
            'order' => 'DESC',
            'status' => 'publish',
        ));
    } else {
        $products = array();
        foreach ($selected_products as $item) {
            $product = wc_get_product($item['product']);
            if ($product) {
                $products[] = $product;
            }
        }
    }
    ?>

    <?php if (!empty($products)): ?>
        <section class="catalog">
            <div class="container-lg catalog__wrapper">
                <div class="catalog__head">
                    <h2 class="catalog__heading heading">
                        <?php echo esc_html($products_heading ?: 'Лучшие предложения'); ?>
                    </h2>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="catalog__more">Весь
                        каталог</a>
                </div>

                <ul class="catalog__products">
                    <?php
                    foreach ($products as $product) {
                        get_template_part('template-parts/product', null, array(
                            'product' => $product,
                            'class' => 'catalog__product'
                        ));
                    }
                    ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>

    <?php
    $about_image_id = carbon_get_theme_option('home_about_image');
    $about_image_alt = get_post_meta($about_image_id, '_wp_attachment_image_alt', true);
    $about_image_url = wp_get_attachment_url($about_image_id);
    $about_caption = carbon_get_theme_option('home_about_caption');
    $about_heading = carbon_get_theme_option('home_about_heading');
    $about_description = carbon_get_theme_option('home_about_description');
    ?>
    <?php if ($about_heading || $about_description || $about_image_id): ?>
        <section class="about">
            <div class="container-md about__wrapper">
                <?php if ($about_image_id): ?>
                    <div class='about__thumbnail'>
                        <img src="<?php echo esc_url($about_image_url); ?>" alt="<?php echo esc_attr($about_image_alt); ?>">
                    </div>
                <?php endif; ?>
                <div class="about__box">
                    <?php if ($about_caption): ?>
                        <div class="about__box-caption"><?php echo esc_html($about_caption); ?></div>
                    <?php endif; ?>
                    <?php if ($about_heading): ?>
                        <h3 class="about__box-heading heading"><?php echo esc_html($about_heading); ?></h3>
                    <?php endif; ?>
                    <?php if ($about_description): ?>
                        <div class="about__box-description"><?php echo wp_kses_post($about_description); ?></div>
                    <?php endif; ?>
                    <?php
                    $button_label = carbon_get_theme_option('home_about_button_label');
                    $button_url = carbon_get_theme_option('home_about_button_url');

                    if ($button_label && $button_url): ?>
                        <a class="about__box-button primary-btn" href="<?php echo esc_url($button_url); ?>">
                            <?php echo esc_html($button_label); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
    $selected_categories = carbon_get_theme_option('home_categories');

    if (empty($selected_categories)) {
        $args = array(
            'taxonomy' => 'product_cat',
            'orderby' => 'date',
            'order' => 'DESC',
            'number' => 4,
            'parent' => 0
        );
        $categories = get_terms($args);
    } else {
        $categories = array();
        foreach ($selected_categories as $cat_item) {
            if (!empty($cat_item['category'])) {
                $categories[] = $cat_item['category'];
            }
        }
    }

    if ($categories): ?>
        <section class="catalog">
            <div class="container-md catalog__wrapper">
                <div class="catalog__head">
                    <h2 class="catalog__heading heading">Категории товаров</h2>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="catalog__more">Весь каталог</a>
                </div>
                <ul class="catalog__categories">
                    <?php foreach ($categories as $category):
                        if (!$category)
                            continue;
                        get_template_part('template-parts/category', null, array('category' => $category, 'class' => 'catalog__category'));
                    endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>

    <?php
    $advantages = carbon_get_theme_option('home_advantages');
    if ($advantages): ?>
        <section class="advantages">
            <div class="container-md advantages__wrapper">
                <ul class="advantages__list">
                    <?php foreach ($advantages as $adv):
                        $advantage_image_id = $adv['home_advantage_icon'];
                        $advantage_image_alt = get_post_meta($advantage_image_id, '_wp_attachment_image_alt', true);
                        $advantage_image_url = wp_get_attachment_url($advantage_image_id);
                        $advantage_heading = esc_html($adv['home_advantage_heading']);
                        $advantage_description = esc_html($adv['home_advantage_description']);
                        ?>
                        <li class="advantages__item">
                            <?php if ($adv['home_advantage_icon']): ?>
                                <img src="<?php echo esc_url($advantage_image_url); ?>"
                                    alt="<?php echo esc_attr($advantage_image_alt); ?>">
                            <?php endif; ?>
                            <h4 class="advantages__item-heading"><?php echo $advantage_heading; ?></h4>
                            <p class="advantages__item-description"><?php echo $advantage_description; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>

    <?php
    $courses = carbon_get_theme_option('home_courses');
    ?>

    <?php if ($courses): ?>
        <section class="courses">
            <div class="container-md courses__wrapper">
                <div class="courses__head">
                    <?php
                        $course_id = $courses[0]['id'];    
                        $course_name = carbon_get_post_meta($course_id, 'course_name');
                    ?>
                    <h3 class="courses__heading heading"> <?php echo esc_html($course_name); ?> </h3>
                    <ul class="courses__tabs">
                        <?php foreach ($courses as $index => $course):
                            $course_id = $course['id'];    
                            $course_tab = carbon_get_post_meta($course_id, 'course_tab');
                        ?>
                            <li class="courses__tab <?php echo $index === 0 ? 'picked' : ''; ?>" data-tab="<?php echo esc_attr($index); ?>">
                                <?php echo esc_html($course_tab); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class='courses__slider'>
                    <div class="courses__swiper swiper">
                        <ul class="courses__slides swiper-wrapper">

                            <?php foreach ($courses as $course): ?>

                                <?php
                                $post_id = $course['id'];
                                ?>

                                <?php
                                get_template_part(
                                    'template-parts/course',
                                    null,
                                    [
                                        'course_id' => $post_id,
                                        'class' => 'swiper-slide'
                                    ]
                                );
                                ?>

                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>

            </div>
        </section>
    <?php endif; ?>

    <?php

    $banner_background_id = carbon_get_theme_option('home_banner_background');
    $banner_background_alt = get_post_meta($banner_background_id, '_wp_attachment_image_alt', true);
    $banner_background_url = wp_get_attachment_url($banner_background_id);

    $banner_caption = carbon_get_theme_option('home_banner_caption');
    $banner_heading = carbon_get_theme_option('home_banner_heading');

    $banner_image_id = carbon_get_theme_option('home_banner_image');
    $banner_image_alt = get_post_meta($banner_image_id, '_wp_attachment_image_alt', true);
    $banner_image_url = wp_get_attachment_url($banner_image_id);

    $banner_description = carbon_get_theme_option('home_banner_description');
    $banner_button_text = carbon_get_theme_option('home_banner_button_text');
    $banner_button_link = carbon_get_theme_option('home_banner_button_link');
    ?>

    <?php if ($banner_background_id): ?>
        <section class="banner">
            <div class="container-md">
                <div class="banner__wrapper">
                    <?php if ($banner_background_url): ?>
                        <img src="<?php echo esc_url($banner_background_url); ?>"
                            alt="<?php echo esc_attr($banner_background_alt); ?>">
                    <?php endif; ?>

                    <div class="banner__box">
                        <div class="banner__info">
                            <?php if ($banner_caption): ?>
                                <h5 class="banner__info-caption"><?php echo esc_html($banner_caption); ?></h5>
                            <?php endif; ?>
                            <?php if ($banner_heading): ?>
                                <h4 class="banner__info-heading"><?php echo esc_html($banner_heading); ?></h4>
                            <?php endif; ?>
                        </div>

                        <?php if ($banner_image_url): ?>
                            <img src="<?php echo esc_url($banner_image_url); ?>"
                                alt="<?php echo esc_attr($banner_image_alt); ?>">
                        <?php endif; ?>

                        <div class="banner__info">
                            <?php if ($banner_description): ?>
                                <p class="banner__info-description"><?php echo wp_kses_post($banner_description); ?></p>
                            <?php endif; ?>

                            <?php if ($banner_button_text && $banner_button_link): ?>
                                <a href="<?php echo esc_url($banner_button_link); ?>" class="banner__info-button">
                                    <?php echo esc_html($banner_button_text); ?>
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
    $heading = carbon_get_theme_option('home_professionals_heading');
    $description = carbon_get_theme_option('home_professionals_description');
    $button_text = carbon_get_theme_option('home_professionals_button_text');
    $button_link = carbon_get_theme_option('home_professionals_button_link');
    $images = carbon_get_theme_option('home_professionals_images');
    $video_id = carbon_get_theme_option('home_professionals_video');
    $video_url = $video_id ? wp_get_attachment_url($video_id) : '';

    if ($heading || $description):
        ?>
        <section class="professionals">
            <div class="container-md professionals__wrapper">
                <div class="professionals__content">
                    <div class="professionals__box">
                        <?php if ($heading): ?>
                            <h5 class="professionals__box-heading"><?php echo esc_html($heading); ?></h5>
                        <?php endif; ?>

                        <?php if ($description): ?>
                            <p class="professionals__box-description"><?php echo wp_kses_post($description); ?></p>
                        <?php endif; ?>

                        <?php if ($button_text && $button_link): ?>
                            <a href="<?php echo esc_url($button_link); ?>" class="professionals__box-button primary-btn">
                                <?php echo esc_html($button_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if ($images): ?>
                        <ul class="professionals__images">
                            <?php foreach ($images as $img):
                                $img_url = wp_get_attachment_url($img['image']);
                                $img_alt = !empty($img['alt']) ? $img['alt'] : '';
                                ?>
                                <li class="professionals__image">
                                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>">
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php if ($video_url): ?>
                        <div class="professionals__video">
                            <video-player>
                                <video-skin>
                                    <video src="<?php echo esc_url($video_url); ?>" playsinline></video>
                                </video-skin>
                            </video-player>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
    $blog_heading = carbon_get_theme_option('home_blog_heading');
    $blog_posts_cf = carbon_get_theme_option('home_blog_posts');

    $cf_ids = [];
    if ($blog_posts_cf) {
        foreach ($blog_posts_cf as $p) {
            $cf_ids[] = is_object($p['post']) ? $p['post']->ID : $p['post'];
        }
    }

    $initial_posts = [];
    $posts_per_page = 3;

    if ($cf_ids) {
        $initial_posts = array_slice($cf_ids, 0, $posts_per_page);
        $total_cf = count($cf_ids);
    } else {
        $initial_posts = get_posts([
            'post_type' => 'post',
            'posts_per_page' => $posts_per_page,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'fields' => 'ids',
        ]);
        $total_cf = 0;
    }

    $total_wp = wp_count_posts('post')->publish - count($cf_ids);

    $posts_to_show = $initial_posts;

    if ($initial_posts):
        ?>
        <section class="catalog">
            <div class="container-md">
                <div class="catalog__head">
                    <?php if ($blog_heading): ?>
                        <h3 class="catalog__heading heading"><?php echo esc_html($blog_heading); ?></h3>
                    <?php endif; ?>
                    <?php
                    $blog_page_id = get_option('page_for_posts');

                    $blog_url = $blog_page_id
                        ? get_permalink($blog_page_id)
                        : home_url('/');
                    ?>
                    <a href="<?php echo esc_url($blog_url); ?>" class="catalog__more">
                        Все статьи
                    </a>
                </div>

                <div class="blog__catalog">
                    <ul class="blog__posts">
                        <?php
                        foreach ($posts_to_show as $post_id) {
                            $post = get_post($post_id);
                            setup_postdata($post);
                            get_template_part('template-parts/post', null, ['post' => $post, 'class' => 'blog__post']);
                        }
                        wp_reset_postdata();
                        ?>
                    </ul>
                    <?php
                    if (count($posts_to_show) < $total_cf + $total_wp):
                        get_template_part('components/loader', null, array(
                            'class' => 'blog__catalog-load blog__catalog-loader hidden'
                        ));
                        ?>
                        <button class="blog__catalog-load" data-offset="<?php echo count($posts_to_show); ?>"
                            data-cf-count="<?php echo $total_cf; ?>" data-cf-total="<?php echo $total_cf; ?>"
                            data-wp-total="<?php echo $total_wp; ?>" data-shown="<?php echo implode(',', $posts_to_show); ?>">
                            Загрузить еще
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
    $gallery_heading = carbon_get_theme_option('home_gallery_heading');
    $gallery_description = carbon_get_theme_option('home_gallery_description');
    $gallery_items = carbon_get_theme_option('home_gallery_items');
    if ($gallery_items):
        ?>
        <section class="gallery">
            <div class="container-md gallery__wrapper">
                <div class="catalog__head">
                    <div class="gallery__head-box">
                        <?php if ($gallery_heading): ?>
                            <h3 class="gallery__heading heading"><?php echo esc_html($gallery_heading); ?></h3>
                        <?php endif; ?>
                        <?php if ($gallery_description): ?>
                            <p class="gallery__description"><?php echo wp_kses_post($gallery_description); ?></p>
                        <?php endif; ?>
                    </div>
                    <a href="#" class="catalog__more">Все фото и видео</a>
                </div>

                <ul class="gallery__items">
                    <?php foreach ($gallery_items as $index => $item): ?>
                        <?php if (!empty($item['images'])): ?>
                            <li class="gallery__item lightgallery">

                                <?php
                                $main = $item['images'][0];
                                $main_url = wp_get_attachment_url($main['image']);
                                $main_thumb = wp_get_attachment_image_src($main['image'], 'thumbnail')[0];
                                $main_alt = get_post_meta($main['image'], '_wp_attachment_image_alt', true);
                                ?>

                                <a class="gallery__item-card" href="<?php echo esc_url($main_url); ?>"
                                    data-src="<?php echo esc_url($main_url); ?>" data-thumb="<?php echo esc_url($main_thumb); ?>">

                                    <img src="<?php echo esc_url($main_url); ?>" alt="<?php echo esc_attr($main_alt); ?>">

                                    <div class="gallery__item-box">
                                        <div class="gallery__item-count">
                                            <?php echo count($item['images']); ?> фото
                                        </div>

                                        <?php if (!empty($item['heading'])): ?>
                                            <h4 class="gallery__item-heading">
                                                <?php echo esc_html($item['heading']); ?>
                                            </h4>
                                        <?php endif; ?>
                                    </div>
                                </a>

                                <?php foreach ($item['images'] as $i => $img):
                                    if ($i === 0)
                                        continue;
                                    $url = wp_get_attachment_url($img['image']);
                                    ?>
                                    <a href="<?php echo esc_url($url); ?>" data-src="<?php echo esc_url($url); ?>"
                                        data-thumb="<?php echo esc_url($url); ?>" style="display:none;">
                                        <img src="<?php echo esc_url($url); ?>">
                                    </a>
                                <?php endforeach; ?>

                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>

            </div>
        </section>
    <?php endif; ?>

    <?php
    $seo_content = carbon_get_theme_option('home_seo');
    if ($seo_content):
        ?>
        <section class="seo">
            <div class="container-md seo__wrapper">
                <?php echo wp_kses_post($seo_content); ?>
            </div>
        </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>