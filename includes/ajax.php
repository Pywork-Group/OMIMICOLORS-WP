<?php
add_action('wp_ajax_load_more_posts', 'load_more_posts_ajax');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_ajax');

function load_more_posts_ajax()
{
    $offset = intval($_POST['offset'] ?? 0);
    $posts_per_page = intval($_POST['posts_per_page'] ?? 3);

    $shown = isset($_POST['shown']) ? array_map('intval', explode(',', $_POST['shown'])) : [];
    $cf_ids = isset($_POST['cf_ids']) ? array_map('intval', explode(',', $_POST['cf_ids'])) : [];
    $cf_total = count($cf_ids);

    $new_posts = [];

    if ($offset < $cf_total) {
        $cf_slice = array_slice($cf_ids, $offset, $posts_per_page);
        $new_posts = $cf_slice;
        $offset += count($cf_slice);
    }

    if (count($new_posts) < $posts_per_page) {
        $remaining = $posts_per_page - count($new_posts);
        $exclude_ids = array_merge($shown, $cf_ids);

        $wp_posts = get_posts([
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => $remaining,
            'post__not_in' => $exclude_ids,
            'fields' => 'ids',
        ]);

        $new_posts = array_merge($new_posts, $wp_posts);
        $offset += count($wp_posts);
    }

    foreach ($new_posts as $i => $post_id) {
        $post = get_post($post_id);
        setup_postdata($post);
        get_template_part('template-parts/post', null, ['post' => $post, 'class' => 'blog__post']);
    }
    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_send_callback', 'send_callback_ajax');
add_action('wp_ajax_nopriv_send_callback', 'send_callback_ajax');

function send_callback_ajax()
{
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $comment = isset($_POST['comment']) ? sanitize_textarea_field($_POST['comment']) : '';

    $to = carbon_get_theme_option('email');
    $subject = "Заказ звонка с сайта";
    $message = "Имя: $name\nНомер телефона: $phone\nКомментарий: $comment";
    $headers = "From: no-reply@" . $_SERVER['SERVER_NAME'] . "\r\n";

    if (wp_mail($to, $subject, $message, $headers)) {
        wp_send_json(['status' => 'success', 'message' => 'Спасибо! Мы вам перезвоним.']);
    } else {
        wp_send_json(['status' => 'error', 'message' => 'Ошибка отправки. Попробуйте позже.']);
    }

    wp_die();
}

add_action('wp_ajax_send_education', 'send_education_ajax');
add_action('wp_ajax_nopriv_send_education', 'send_education_ajax');

function send_education_ajax()
{
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $comment = isset($_POST['comment']) ? sanitize_textarea_field($_POST['comment']) : '';
    $course = isset($_POST['course']) ? sanitize_text_field($_POST['course']) : '';

    $to = carbon_get_theme_option('email');
    $subject = "Запись на курс: $course";
    $message = "Имя: $name\nНомер телефона: $phone\nКомментарий: $comment\nКурс: $course";
    $headers = "From: no-reply@" . $_SERVER['SERVER_NAME'] . "\r\n";

    if (wp_mail($to, $subject, $message, $headers)) {
        wp_send_json(['status' => 'success', 'message' => 'Спасибо! Мы свяжемся с вами.']);
    } else {
        wp_send_json(['status' => 'error', 'message' => 'Ошибка отправки. Попробуйте позже.']);
    }
    wp_die();
}

add_action('wp_ajax_load_more_courses', 'load_more_courses');
add_action('wp_ajax_nopriv_load_more_courses', 'load_more_courses');

function load_more_courses() {

	$offset = intval($_POST['offset']);
	$posts_per_page = 10;

	$args = [
		'post_type' => 'course',
		'post_status' => 'publish',
		'posts_per_page' => $posts_per_page,
		'offset' => $offset,
		'orderby' => 'date',
		'order' => 'DESC',
	];

	$query = new WP_Query($args);

	ob_start();

	if ($query->have_posts()):
		while ($query->have_posts()): $query->the_post(); ?>

			<?php get_template_part('template-parts/course', null, [
				'course_id' => get_the_ID(),
				'class' => ''
			]); ?>

		<?php endwhile;
	endif;

	wp_reset_postdata();

	echo ob_get_clean();
	wp_die();
}

add_action('wp_ajax_load_more_blog_posts', 'load_more_blog_posts');
add_action('wp_ajax_nopriv_load_more_blog_posts', 'load_more_blog_posts');

function load_more_blog_posts() {

	$offset = intval($_POST['offset']);
	$posts_per_page = 10;

	$args = [
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => $posts_per_page,
		'offset' => $offset,
		'orderby' => 'date',
		'order' => 'DESC',
	];

	$query = new WP_Query($args);

	ob_start();

	if ($query->have_posts()):
		while ($query->have_posts()): $query->the_post(); ?>

			<?php get_template_part('template-parts/post', null, [
				'post' => get_post(),
				'class' => 'catalog__post'
			]); ?>

		<?php endwhile;
	endif;

	wp_reset_postdata();

	echo ob_get_clean();
	wp_die();
}