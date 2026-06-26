<?php 


require_once get_template_directory() . '/vendor/autoload.php';

add_action('after_setup_theme', function() {
    \Carbon_Fields\Carbon_Fields::boot();
});

add_action('init', function () {

    register_post_type('course', [
        'labels' => [
            'name' => 'Курсы',
            'singular_name' => 'Курс',
            'add_new' => 'Добавить курс',
            'add_new_item' => 'Добавить новый курс',
            'edit_item' => 'Редактировать курс',
            'view_item' => 'Посмотреть курс',
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'course'],
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
    ]);

});

require_once get_template_directory() . '/includes/carbon/pages/home.php';
require_once get_template_directory() . '/includes/carbon/posts/course.php';
require_once get_template_directory() . '/includes/carbon/posts/product.php';