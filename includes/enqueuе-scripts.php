<?php
function omimicolors_scripts() {
    wp_dequeue_style('select2');
    wp_dequeue_style('woocommerce-select2');

    wp_deregister_style('select2');
    wp_deregister_style('woocommerce-select2');
    
    wp_enqueue_script(
        'omimicolors-font-awesome',
        'https://kit.fontawesome.com/632443de9e.js',
        array(),
        _S_VERSION,
        true
    );

    wp_enqueue_style(
        'omimicolors-style',
        get_stylesheet_uri(),
        array(),
        _S_VERSION
    );
    wp_style_add_data('omimicolors-style', 'rtl', 'replace');

    wp_enqueue_style(
        'omimicolors-reset-style',
        get_template_directory_uri() . '/assets/styles/reset.css',
        array(),
        _S_VERSION
    );

    wp_enqueue_style(
        'omimicolors-global-style',
        get_template_directory_uri() . '/assets/styles/global.css',
        array(),
        _S_VERSION
    );

    wp_enqueue_style(
        'omimicolors-parts-style',
        get_template_directory_uri() . '/assets/styles/parts.css',
        array(),
        _S_VERSION
    );

     wp_enqueue_style(
            'omimicolors-media-style',
            get_template_directory_uri() . '/assets/styles/media.css',
            array(),
            _S_VERSION
        );

    wp_enqueue_script(
        'omimicolors-imask-script',
            'https://cdnjs.cloudflare.com/ajax/libs/imask/7.6.1/imask.min.js',
        [],
        null,
        true
    );



    if ( is_front_page() ) {
        wp_enqueue_style(
            'omimicolors-home-main-style',
            get_template_directory_uri() . '/assets/styles/pages/home/style.css',
            array(),
            _S_VERSION
        );

        wp_enqueue_style(
            'omimicolors-home-media-style',
            get_template_directory_uri() . '/assets/styles/pages/home/media.css',
            array(),
            _S_VERSION
        );

        wp_enqueue_style('lightgallery-css', 'https://cdn.jsdelivr.net/npm/lightgallery@2/css/lightgallery-bundle.min.css');
        wp_enqueue_script('lightgallery-js', 'https://cdn.jsdelivr.net/npm/lightgallery@2/lightgallery.umd.js', [], null, true);
        wp_enqueue_script('lg-zoom', 'https://cdn.jsdelivr.net/npm/lightgallery@2/plugins/zoom/lg-zoom.umd.js', ['lightgallery-js'], null, true);
        wp_enqueue_script('lg-thumbnail', 'https://cdn.jsdelivr.net/npm/lightgallery@2/plugins/thumbnail/lg-thumbnail.umd.js', ['lightgallery-js'], null, true);
        wp_enqueue_script('lg-fullscreen', 'https://cdn.jsdelivr.net/npm/lightgallery@2/plugins/fullscreen/lg-fullscreen.umd.js', ['lightgallery-js'], null, true);

        wp_enqueue_style(
        'omimicolors-swiper-style',
        'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css',
        array(),
        null
        );

        wp_enqueue_script(
            'omimicolors-swiper-script',
            'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js',
            array(),
            null,
            true
        );

         wp_enqueue_script(
            'omimicolors-home-script',
            get_template_directory_uri() . '/assets/js/pages/home.js',
            array('jquery', 'omimicolors-swiper-script', 'omimicolors-imask-script'),
            null,
            true
        );
    }

        if ( is_product() ) {
        wp_enqueue_style(
            'omimicolors-product-main-style',
            get_template_directory_uri() . '/assets/styles/pages/product/style.css',
            array(),
            _S_VERSION
        );

        wp_enqueue_style(
            'omimicolors-product-media-style',
            get_template_directory_uri() . '/assets/styles/pages/product/media.css',
            array(),
            _S_VERSION
        );

                wp_enqueue_style('lightgallery-css', 'https://cdn.jsdelivr.net/npm/lightgallery@2/css/lightgallery-bundle.min.css');
        wp_enqueue_script('lightgallery-js', 'https://cdn.jsdelivr.net/npm/lightgallery@2/lightgallery.umd.js', [], null, true);
        wp_enqueue_script('lg-zoom', 'https://cdn.jsdelivr.net/npm/lightgallery@2/plugins/zoom/lg-zoom.umd.js', ['lightgallery-js'], null, true);
        wp_enqueue_script('lg-thumbnail', 'https://cdn.jsdelivr.net/npm/lightgallery@2/plugins/thumbnail/lg-thumbnail.umd.js', ['lightgallery-js'], null, true);
        wp_enqueue_script('lg-fullscreen', 'https://cdn.jsdelivr.net/npm/lightgallery@2/plugins/fullscreen/lg-fullscreen.umd.js', ['lightgallery-js'], null, true);

        wp_enqueue_style(
        'omimicolors-swiper-style',
        'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css',
        array(),
        null
        );

        wp_enqueue_script(
            'omimicolors-swiper-script',
            'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js',
            array(),
            null,
            true
        );

         wp_enqueue_script(
            'omimicolors-product-script',
            get_template_directory_uri() . '/assets/js/pages/product.js',
            array('jquery', 'omimicolors-swiper-script'),
            null,
            true
        );
        }

    if ( is_shop() || is_product_category() ) {
        wp_enqueue_style(
            'omimicolors-shop-main-style',
            get_template_directory_uri() . '/assets/styles/pages/shop/style.css',
            array(),
            _S_VERSION
        );

        wp_enqueue_style(
            'omimicolors-shop-media-style',
            get_template_directory_uri() . '/assets/styles/pages/shop/media.css',
            array(),
            _S_VERSION
        );

        wp_enqueue_script(
            'omimicolors-shop-script',
            get_template_directory_uri() . '/assets/js/pages/shop.js',
            array('jquery'),
            null,
            true
        );
    }

    if(is_page_template('courses.php')) {
        wp_enqueue_style(
            'omimicolors-courses-main-style',
            get_template_directory_uri() . '/assets/styles/pages/courses/style.css',
            array(),
            _S_VERSION
        );
         wp_enqueue_style(
            'omimicolors-courses-media-style',
            get_template_directory_uri() . '/assets/styles/pages/courses/media.css',
            array(),
            _S_VERSION
        );
    }

    if(is_page_template('blog.php')) {
        wp_enqueue_style(
            'omimicolors-blog-main-style',
            get_template_directory_uri() . '/assets/styles/pages/blog/style.css',
            array(),
            _S_VERSION
        );
        wp_enqueue_style(
            'omimicolors-blog-media-style',
            get_template_directory_uri() . '/assets/styles/pages/blog/media.css',
            array(),
            _S_VERSION
        );
    }

        if(is_page_template('wishlist.php')) {
        wp_enqueue_style(
            'omimicolors-wishlist-main-style',
            get_template_directory_uri() . '/assets/styles/pages/wishlist/style.css',
            array(),
            _S_VERSION
        );
        wp_enqueue_style(
            'omimicolors-wishlist-media-style',
            get_template_directory_uri() . '/assets/styles/pages/wishlist/media.css',
            array(),
            _S_VERSION
        );
    }

    if(is_single()) {
        wp_enqueue_style(
            'omimicolors-post-main-style',
            get_template_directory_uri() . '/assets/styles/pages/post/style.css',
            array(),
            _S_VERSION
        );
        wp_enqueue_style(
            'omimicolors-post-media-style',
            get_template_directory_uri() . '/assets/styles/pages/post/media.css',
            array(),
            _S_VERSION
        );
    }
    
    if(is_404()) {
        wp_enqueue_style(
            'omimicolors-error-main-style',
            get_template_directory_uri() . '/assets/styles/pages/error/style.css',
            array(),
            _S_VERSION
        );
    }

    if (is_page()) {
	wp_enqueue_style(
		'omimicolors-page-main-style',
		get_template_directory_uri() . '/assets/styles/pages/page/style.css',
		array(),
		_S_VERSION
	);

	wp_enqueue_style(
		'omimicolors-page-media-style',
		get_template_directory_uri() . '/assets/styles/pages/page/media.css',
		array(),
		_S_VERSION
	);
}
            wp_enqueue_script(
        'omimicolors-app-script',
        get_template_directory_uri() . '/assets/js/app.js',
        array('jquery'),
        null,
        true
    );

 wp_enqueue_script(
    'omimicolors-ajax-script',
    get_template_directory_uri() . '/assets/js/ajax.js',
   array('jquery', 'omimicolors-imask-script'),
    null,
    true
);

wp_localize_script('omimicolors-ajax-script', 'my_ajax', [
        'ajax_url' => admin_url("admin-ajax.php")
    ]);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'omimicolors_scripts');

add_action('wp_footer', function() {
    ?>
    <script type="module" src="https://cdn.jsdelivr.net/npm/@videojs/html/cdn/video.js"></script>
    <?php
});