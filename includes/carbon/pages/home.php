<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {

    Container::make('theme_options', 'Главная страница')
        ->set_page_menu_position(2) // Позиция в админке
        ->set_page_parent('options-general.php') // Можно заменить на null, если отдельное меню
        ->add_tab('Шапка', [
            Field::make('text', 'phone', 'Телефон'),
            Field::make('text', 'email', 'Email'),
            Field::make('text', 'telegram', 'Ссылка на Telegram'),
        ])
        ->add_tab('Hero', [
            Field::make('image', 'home_hero_image', 'Изображение'),
        ])
        ->add_tab('Лучшие предложения', [
            Field::make('text', 'home_products_heading', 'Заголовок'),
            Field::make('complex', 'home_products', 'Продукты')
                ->add_fields([
                    Field::make('association', 'product', 'Выберите продукт')
                        ->set_types([
                            [
                                'type' => 'post',
                                'post_type' => 'product',
                            ],
                        ]),
                ]),
        ])
        ->add_tab('О компании', [
            Field::make('image', 'home_about_image', 'Изображение о компании'),
            Field::make('text', 'home_about_caption', 'Надзаголовок'),
            Field::make('text', 'home_about_heading', 'Заголовок'),
            Field::make('rich_text', 'home_about_description', 'Текст о компании'),
            Field::make('text', 'home_about_button_label', 'Текст кнопки'),
            Field::make('text', 'home_about_button_url', 'Ссылка кнопки'),
        ])
        ->add_tab('Категории', [
            Field::make('complex', 'home_categories', 'Категории')
                ->add_fields([
                    Field::make('association', 'category', 'Выберите категорию')
                        ->set_types([
                            [
                                'type' => 'term',
                                'taxonomy' => 'product_cat',
                            ],
                        ]),
                ]),
        ])
        ->add_tab('Преимущества', [
            Field::make('complex', 'home_advantages', 'Преимущества')
                ->set_max(4)
                ->add_fields([
                    Field::make('image', 'home_advantage_icon', 'Иконка преимущества'),
                    Field::make('text', 'home_advantage_heading', 'Заголовок'),
                    Field::make('textarea', 'home_advantage_description', 'Описание'),
                ]),
        ])
        ->add_tab('Программы обучения', [
            Field::make('association', 'home_courses', 'Курс')
                        ->set_types([
                            [
                                'type' => 'post',
                                'post_type' => 'course',
                            ]
                        ]),
        ])
        ->add_tab('Баннер', [
            Field::make('image', 'home_banner_background', 'Фон'),
            Field::make('text', 'home_banner_caption', 'Надзаголовок'),
            Field::make('text', 'home_banner_heading', 'Заголовок'),
            Field::make('image', 'home_banner_image', 'Изображение внутри баннера'),
            Field::make('textarea', 'home_banner_description', 'Описание'),
            Field::make('text', 'home_banner_button_text', 'Текст кнопки'),
            Field::make('text', 'home_banner_button_link', 'Ссылка кнопки'),
        ])
        ->add_tab('Профессионалы', [
            Field::make('text', 'home_professionals_heading', 'Заголовок'),
            Field::make('rich_text', 'home_professionals_description', 'Описание'),
            Field::make('text', 'home_professionals_button_text', 'Текст кнопки'),
            Field::make('text', 'home_professionals_button_link', 'Ссылка кнопки'),
            Field::make('complex', 'home_professionals_images', 'Изображения')
                ->set_max(4)
                ->add_fields([
                    Field::make('image', 'image', 'Изображение'),
                ]),
            Field::make('file', 'home_professionals_video', 'Видео')
                ->set_type(['video/mp4', 'video/webm']),
        ])
        ->add_tab('Блог', [
            Field::make('text', 'home_blog_heading', 'Заголовок'),
            Field::make('complex', 'home_blog_posts', 'Выбор постов')
                ->set_max(3)
                ->add_fields([
                    Field::make('association', 'post', 'Выберите пост')
                        ->set_types([
                            [
                                'type' => 'post',
                                'post_type' => 'post',
                            ],
                        ]),
                ]),
        ])
        ->add_tab('Галерея', [
            Field::make('text', 'home_gallery_heading', 'Заголовок секции'),
            Field::make('textarea', 'home_gallery_description', 'Описание секции'),
            Field::make('complex', 'home_gallery_items', 'Элементы галереи')
                ->set_max(4)
                ->add_fields([
                    Field::make('text', 'heading', 'Заголовок элемента'),
                    Field::make('complex', 'images', 'Элементы галереи')
                        ->set_max(30)
                        ->add_fields([
                            Field::make('image', 'image', 'Изображение'),
                        ]),
                ]),
        ])
        ->add_tab('SEO', [
            Field::make('rich_text', 'home_seo', 'Контент'),
        ])
        ->add_tab('Футер', [
            Field::make('text', 'footer_city', 'Город'),
            Field::make('text', 'footer_workdays', 'Рабочие дни'),
            Field::make('text', 'footer_map', 'Яндекс координаты'),
            Field::make('complex', 'footer_social', 'Социальные сети')
                ->set_max(10)
                ->add_fields([
                    Field::make('text', 'link', 'Ссылка'),
                    Field::make('text', 'icon', 'Иконка (Font Awesome)'),
                ]),
            Field::make('text', 'footer_copyright', 'Копирайт'),
        ]);
});