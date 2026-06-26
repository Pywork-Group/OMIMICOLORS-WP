<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
    Container::make('post_meta', 'Настройки товара')
        ->where('post_type', '=', 'product')
        ->add_fields([
            Field::make('checkbox', 'recommended_badge', 'Рекомендуемый товар')
                ->set_option_value('yes'),

            Field::make('file', 'video', 'Видео товара')
                ->set_type(['video'])
                ->set_value_type('url'),
        ]);
});