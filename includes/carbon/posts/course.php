<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {

    Container::make('post_meta', 'Настройки курса')
        ->where('post_type', '=', 'course')
        ->add_fields([

            Field::make('text', 'course_tab', 'Кнопка'),
            Field::make('text', 'course_name', 'Название'),
            
            Field::make('image', 'course_image', 'Изображение слайда'),

            Field::make('rich_text', 'course_description_1', 'Описание 1'),
            Field::make('rich_text', 'course_description_2', 'Описание 2'),

            Field::make('complex', 'course_prices', 'Цены')
                ->set_max(5)
                ->add_fields([
                    Field::make('text', 'course_price_amount', 'Сумма'),
                    Field::make('text', 'course_price_note', 'Примечание'),
                ]),

            Field::make('text', 'course_button', 'Текст кнопки'),

        ]);

});