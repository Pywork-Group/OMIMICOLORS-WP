<?php 
$footer_map       = carbon_get_theme_option('footer_map');
$footer_social    = carbon_get_theme_option('footer_social');
$footer_copyright = carbon_get_theme_option('footer_copyright');
$phone            = carbon_get_theme_option('phone');
$email            = carbon_get_theme_option('email');
$footer_city      = carbon_get_theme_option('footer_city');
$footer_workdays  = carbon_get_theme_option('footer_workdays');
?>

<footer class="footer">
    <div class="container-md footer__wrapper">
        <div class="footer__content">

            <!-- Меню футера -->
            <div class="footer__cols">
                <?php
                $footer_menus = ['footer-menu-1', 'footer-menu-2', 'footer-menu-3'];

                foreach ( $footer_menus as $theme_location ) {
                    if ( has_nav_menu( $theme_location ) ) {
                        $locations = get_nav_menu_locations();
                        $menu_id   = $locations[ $theme_location ];
                        $menu_obj  = wp_get_nav_menu_object( $menu_id );
                ?>
                    <div class="footer__col">
                        <?php if ( $menu_obj ) { ?>
                            <h3 class="footer__col-title"><?php echo esc_html( $menu_obj->name ); ?></h3>
                        <?php } ?>

                        <?php
                        wp_nav_menu([
                            'theme_location' => $theme_location,
                            'container'      => false,
                            'menu_class'     => 'footer__col-list',
                            'fallback_cb'    => false,
                        ]);
                        ?>
                    </div>
                <?php
                    }
                }
                ?>
                 <div class="footer__col">
                        <h3 class="footer__col-title">Контакты</h3>
                        <ul class="footer__col-list">
                            <li>
                                 <a href="tel: <?php echo esc_attr($phone); ?>" class="footer__col-phone">
                            <?php echo esc_html($phone); ?>
                        </a>
                            </li>
                            <li>
                                <?php echo esc_html($footer_city); ?>
                            </li>
                             <li>
                                <?php echo esc_html($footer_workdays); ?>
                            </li>
                             <li>
                                <a href="mailto: <?php echo esc_attr($$email); ?>">
                            <?php echo esc_html($email); ?>
                        </a>
                            </li>
                        </ul>
                       
                    </div>
            </div>

            <!-- Карта -->
            <?php if ( $footer_map ) : ?>
                <iframe class="footer__map" width="100%" height="auto" src="https://yandex.ru/map-widget/v1/?ll=<?php echo esc_attr($footer_map); ?>&amp;z=16&amp;pt=<?php echo esc_attr($footer_map); ?>&amp;lang=ru_RU" allowfullscreen></iframe>
            <?php endif; ?>
        </div>
        <?php if ( $footer_social ) : ?>
                <ul class="footer__social">
                    <?php foreach ( $footer_social as $social ) : ?>
                        <li class="footer__social-item">
                            <a href="<?php echo esc_url($social['link']); ?>" class="footer__social-link">
                                <?php echo $social['icon']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        <!-- Нижняя часть футера -->
        <div class="footer__bottom">
            <div class="footer__bottom-copy">
                <?php echo esc_html($footer_copyright); ?>
            </div>

            <?php 
            // Платежные методы WooCommerce
            if ( class_exists('WC_Payment_Gateways') ) {
                $payment_gateways = WC()->payment_gateways()->payment_gateways();
                $methods = [];

                foreach ( $payment_gateways as $gateway ) {
                    $icon = $gateway->get_icon();
                    if ( $icon ) {
                        $methods[] = $icon;
                    }
                }
            }

            if ( ! empty($methods) ) : ?>
                <ul class="footer__bottom-methods">
                    <?php foreach ( $methods as $method_icon ) : ?>
                        <li class="footer__bottom-method">
                            <?php echo wp_kses_post($method_icon); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>