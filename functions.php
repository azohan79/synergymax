<?php
function synergymax_styles_scripts() {
    // Подключение основного стиля темы
    wp_enqueue_style(
        'theme-style',
        get_template_directory_uri() . '/assets/css/style.min.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/style.min.css'),
        'all'
    );

    // Подключение кастомного стиля
    wp_enqueue_style(
        'custom-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/main.css'),
        'all'
    );

    // ✅ Подключаем Splide.js (ДО `script.js`)
    wp_enqueue_script(
        'splide-js',
        'https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js',
        array(),
        null, // Нет версии, берем последнюю
        true  // Загружаем в footer
    );

    // Подключение основного скрипта темы
    wp_enqueue_script(
        'main-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array('jquery', 'splide-js'), // ❗️ Добавляем 'splide-js' как зависимость
        filemtime(get_template_directory() . '/assets/js/script.js'),
        true
    );

    // Подключение wishlist.js
    wp_enqueue_script(
        'wishlist-js',
        get_template_directory_uri() . '/assets/js/wishlist.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/wishlist.js'),
        true
    );
}

add_action('wp_enqueue_scripts', 'synergymax_styles_scripts');




class Synergymax_Walker_Nav extends Walker_Nav_Menu {
    private $combine_items = array("About Us", "Partnership");
    private $combine_items_right = array("Events", "News", "Contacts");
    private $open_combined = false;
    private $open_combined_right = false;

    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="sub-menu">';
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = implode(' ', $item->classes);

        // Объединяем "About Us" и "Partnership" в одном <li>
        if (in_array($item->title, $this->combine_items)) {
            if (!$this->open_combined) {
                $output .= '<li class="header__item">';
                $this->open_combined = true;
            }
            $output .= '<a href="' . esc_url($item->url) . '" class="header__link">' . esc_html($item->title) . '</a> ';
            return; // Не закрываем <li> здесь
        }

        // Объединяем "Events", "News" и "Contacts" в одном <li>
        if (in_array($item->title, $this->combine_items_right)) {
            if (!$this->open_combined_right) {
                $output .= '<li class="header__item header__item-last">';
                $this->open_combined_right = true;
            }
            $output .= '<a href="' . esc_url($item->url) . '" class="header__link">' . esc_html($item->title) . '</a> ';
            return;
        }

        // Обычные пункты меню
        $output .= '<li class="header__item"><a href="' . esc_url($item->url) . '" class="header__link">' . esc_html($item->title) . '</a></li>';
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        // Закрываем объединенные пункты только после последнего элемента группы
        if ($item->title == "Partnership" && $this->open_combined) {
            $output .= '</li>';
            $this->open_combined = false;
        }
        if ($item->title == "Contacts" && $this->open_combined_right) {
            $output .= '</li>';
            $this->open_combined_right = false;
        }
    }
}


function register_synergymax_menus() {
    register_nav_menus(array(
        'primary'   => __('Левое меню'),
        'secondary' => __('Правое меню')
    ));
}
add_action('after_setup_theme', 'register_synergymax_menus');

function create_news_post_type() {
    register_post_type('news',
        array(
            'labels'      => array(
                'name'          => __('News'),
                'singular_name' => __('News'),
            ),
            'public'      => true,
            'has_archive' => true,
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
            'rewrite'     => array('slug' => 'news'),
        )
    );
}
add_action('init', 'create_news_post_type');

function register_synergymax_footer_menus() {
    register_nav_menus(array(
        'footer_catalog'   => __('Footer: Catalog Menu'),
        'footer_business'  => __('Footer: Business Menu'),
        'footer_clients'   => __('Footer: Clients Menu'),
        'footer_social'    => __('Footer: Social Menu'),
        'footer_services'  => __('Footer: Services Menu'),
    ));
}
add_action('after_setup_theme', 'register_synergymax_footer_menus');


class Synergymax_Walker_Footer extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="sub-menu">';
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '<li class="footer__list-item"><a href="' . esc_url($item->url) . '" class="footer__list-link">' . esc_html($item->title) . '</a></li>';
    }
}

function synergymax_customize_register($wp_customize) {
    // Заголовок блока "Годовщина"
    $wp_customize->add_setting('report_title', array(
        'default'   => 'В августе нам исполнилось 3 года!',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('report_title', array(
        'label'    => 'Заголовок блока "Годовщина"',
        'section'  => 'synergymax_report_section',
        'type'     => 'text',
    ));

    // Описание блока
    $wp_customize->add_setting('report_description', array(
        'default'   => 'Посмотрите фото и видео-отчет о том, как компания Synergy Max отпраздновала своё трехлетие. Катания на яхте и многое другое.',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('report_description', array(
        'label'    => 'Описание блока "Годовщина"',
        'section'  => 'synergymax_report_section',
        'type'     => 'textarea',
    ));

    // Текст кнопки
    $wp_customize->add_setting('report_button_text', array(
        'default'   => 'Смотреть',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('report_button_text', array(
        'label'    => 'Текст кнопки',
        'section'  => 'synergymax_report_section',
        'type'     => 'text',
    ));

    // Добавляем секцию в Customizer
    $wp_customize->add_section('synergymax_report_section', array(
        'title'    => 'Настройки блока "Годовщина"',
        'priority' => 30,
    ));
}
add_action('customize_register', 'synergymax_customize_register');

function synergymax_customize_wholesale($wp_customize) {
    // Заголовок блока "Оптовые закупки"
    $wp_customize->add_setting('wholesale_title', array(
        'default'   => 'Are you interested in wholesale purchase?',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('wholesale_title', array(
        'label'    => 'Заголовок блока "Оптовые закупки"',
        'section'  => 'synergymax_wholesale_section',
        'type'     => 'text',
    ));

    // Описание блока
    $wp_customize->add_setting('wholesale_description', array(
        'default'   => 'Submit a request for a quote and we will give you an interesting offer.',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('wholesale_description', array(
        'label'    => 'Описание блока "Оптовые закупки"',
        'section'  => 'synergymax_wholesale_section',
        'type'     => 'textarea',
    ));

    // Текст кнопки
    $wp_customize->add_setting('wholesale_button_text', array(
        'default'   => 'Submit',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('wholesale_button_text', array(
        'label'    => 'Текст кнопки',
        'section'  => 'synergymax_wholesale_section',
        'type'     => 'text',
    ));

    // Ссылка кнопки
    $wp_customize->add_setting('wholesale_button_link', array(
        'default'   => '#',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('wholesale_button_link', array(
        'label'    => 'Ссылка кнопки',
        'section'  => 'synergymax_wholesale_section',
        'type'     => 'url',
    ));

    // Добавляем секцию в Customizer
    $wp_customize->add_section('synergymax_wholesale_section', array(
        'title'    => 'Настройки блока "Оптовые закупки"',
        'priority' => 31,
    ));
}
add_action('customize_register', 'synergymax_customize_wholesale');

function synergymax_get_variation_data() {
    if (!isset($_POST['variation_id'])) {
        wp_send_json_error();
    }

    $variation = wc_get_product((int) $_POST['variation_id']);

    if (!$variation) {
        wp_send_json_error();
    }

    wp_send_json_success([
        'price_html' => $variation->get_price_html(),
        'sku'        => $variation->get_sku(),
        'barcode'    => get_post_meta($variation->get_id(), '_barcode', true), // Добавляем meta-поле barcode
    ]);
}
add_action('wp_ajax_get_variation', 'synergymax_get_variation_data');
add_action('wp_ajax_nopriv_get_variation', 'synergymax_get_variation_data');

function custom_breadcrumbs() {
    if (!is_front_page()) {
        echo '<div class="body__container">     
            <div class="menuBack">
                <a href="'. get_permalink(wc_get_page_id('shop')) .'" class="menuBack__back">
                    <div class="menuBack__back-arrow">
                        <img src="'. get_template_directory_uri() .'/assets/icons/arrows/Chevron-Right.svg" alt="chevron">
                    </div>
                    <div class="menuBack__back-name">Back</div>
                </a>
            </div>
        </div>';
    }
}
add_action('wp_head', 'custom_breadcrumbs');
