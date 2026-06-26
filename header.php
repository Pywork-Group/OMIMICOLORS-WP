<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OMIMICOLORS
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<header class="header">
		<div class="header__top">
			<div class="container-lg header__top-wrapper">
				<div class="header__contact">
					<?php
					$phone = carbon_get_theme_option('phone');
					$telegram = carbon_get_theme_option('telegram');
					?>
					<div class="header__contact-box">
						<a class="header__contact-phone" href="tel: <?php echo esc_attr($phone); ?>">
							<?php echo esc_html($phone); ?>
						</a>
						<button class="header__contact-button">
							Заказать звонок
						</button>
					</div>
					<a class="header__contact-telegram" href="<?php echo esc_url($telegram); ?>">
						<i class="bi bi-telegram"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="header__content">
			<div class="container-lg header__content-wrapper">
				<nav class="header__menu">
					<button type="button" class="header__burger-toggle">
						<i class="bi bi-list"></i>
					</button>
					<?php
					if (has_nav_menu('header-menu-1')) {
						wp_nav_menu([
							'theme_location' => 'header-menu-1',
							'container' => false,
							'menu_class' => 'header__menu-list',
							'fallback_cb' => false,
						]);
					}
					?>
					<?php
					$logo_id = get_theme_mod('custom_logo');

					if ($logo_id) {
						$logo_url = wp_get_attachment_image_url($logo_id, 'full');
						$logo_alt = get_bloginfo('name');
					}
					?>

					<a href="<?php echo esc_url(home_url('/')); ?>" class="header__menu-logo">
						<?php if (!empty($logo_url)): ?>
							<img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>" />
						<?php else: ?>
							<span class="header__logo-text">
								<?php bloginfo('name'); ?>
							</span>
						<?php endif; ?>
					</a>
					<div class='header__box'>
						<?php
						if (has_nav_menu('header-menu-2')) {
							wp_nav_menu([
								'theme_location' => 'header-menu-2',
								'container' => false,
								'menu_class' => 'header__menu-list',
								'fallback_cb' => false,
							]);
						}
						?>
						<div class="header__buttons">
							<div class="header__button header__search">
								<?php echo do_shortcode('[fibosearch]'); ?>
							</div>
							<?php if (is_user_logged_in()): ?>
								<a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>" class="header__button">
									<i class="bi bi-person"></i>
								</a>
							<?php else: ?>
								<a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="header__button">
									<i class="bi bi-person"></i>
								</a>
							<?php endif; ?>
							<?php
							$wishlist_page = get_page_by_path('wishlist');
							$wishlist_url = $wishlist_page ? get_permalink($wishlist_page->ID) : '#';
							?>
							<a class="header__button header__wishlist" href="<?php echo esc_url($wishlist_url); ?>">
								<i class="bi bi-heart"></i>
							</a>
							<div class="header__button">
								<?php echo do_shortcode('[xoo_wsc_cart]'); ?>
							</div>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</header>