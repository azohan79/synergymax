<?php
function synergymax_styles_scripts()
{
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
    wp_enqueue_style('splide-style', get_template_directory_uri() . '/assets/css/splide.min.css');
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




class Synergymax_Walker_Nav extends Walker_Nav_Menu
{
    private $combine_items = array("About Us", "Partnership");
    private $combine_items_right = array("Events", "News", "Contacts");
    private $open_combined = false;
    private $open_combined_right = false;

    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<ul class="sub-menu">';
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
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

    function end_el(&$output, $item, $depth = 0, $args = null)
    {
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


function register_synergymax_menus()
{
    register_nav_menus(array(
        'primary'   => __('Левое меню'),
        'secondary' => __('Правое меню')
    ));
}
add_action('after_setup_theme', 'register_synergymax_menus');

function create_news_post_type()
{
    register_post_type(
        'news',
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

function register_synergymax_footer_menus()
{
    register_nav_menus(array(
        'footer_catalog'   => __('Footer: Catalog Menu'),
        'footer_business'  => __('Footer: Business Menu'),
        'footer_clients'   => __('Footer: Clients Menu'),
        'footer_social'    => __('Footer: Social Menu'),
        'footer_services'  => __('Footer: Services Menu'),
    ));
}
add_action('after_setup_theme', 'register_synergymax_footer_menus');


class Synergymax_Walker_Footer extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<ul class="sub-menu">';
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $output .= '<li class="footer__list-item"><a href="' . esc_url($item->url) . '" class="footer__list-link">' . esc_html($item->title) . '</a></li>';
    }
}

function synergymax_customize_register($wp_customize)
{
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

function synergymax_customize_wholesale($wp_customize)
{
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

function synergymax_get_variation_data()
{
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

function custom_breadcrumbs()
{
    if (!is_front_page()) {
        echo '<div class="body__container">     
            <div class="menuBack">
                <a href="' . get_permalink(wc_get_page_id('shop')) . '" class="menuBack__back">
                    <div class="menuBack__back-arrow">
                        <img src="' . get_template_directory_uri() . '/assets/icons/arrows/Chevron-Right.svg" alt="chevron">
                    </div>
                    <div class="menuBack__back-name">Back</div>
                </a>
            </div>
        </div>';
    }
}
add_action('wp_head', 'custom_breadcrumbs');


function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');



add_action('wp_ajax_update_cart_item_quantity', 'update_cart_item_quantity');
add_action('wp_ajax_nopriv_update_cart_item_quantity', 'update_cart_item_quantity');

function update_cart_item_quantity()
{
    check_ajax_referer('update-cart-quantity', 'security');
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $quantity = intval($_POST['quantity']);
    WC()->cart->set_quantity($cart_item_key, $quantity);
    wp_send_json_success();
}

add_action('wp_ajax_get_cart_total', 'get_cart_total');
add_action('wp_ajax_nopriv_get_cart_total', 'get_cart_total');

function get_cart_total()
{
    check_ajax_referer('get-cart-total', 'security');
    $cart_total = WC()->cart->get_cart_total();
    $cart_total_clean = html_entity_decode(wp_strip_all_tags($cart_total)); // Удаляем HTML-теги и сущности
    wp_send_json_success([
        'cart_total' => $cart_total_clean
    ]);
}

add_filter('woocommerce_checkout_fields', 'customize_checkout_fields', 9999);

function customize_checkout_fields($fields) {
    // Удаляем ненужные поля
    unset($fields['billing']['billing_first_name']);
    unset($fields['billing']['billing_last_name']);

    // Настройка полей с приоритетом
    $fields['billing']['billing_country'] = array_merge($fields['billing']['billing_country'], [
        'label' => 'Country',
        'placeholder' => 'Россия',
        'type' => 'text',
        'priority' => 10
    ]);

    $fields['billing']['billing_state'] = [
        'label' => 'Province ',
        'placeholder' => 'Стерлитамак',
        'type' => 'text',
        'required' => true,
        'class' => ['form-row-wide'],
        'priority' => 20
    ];

    $fields['billing']['billing_city'] = [
        'label' => 'City',
        'placeholder' => 'Проспект Карла Маркса',
        'required' => true,
        'class' => ['form-row-wide'],
        'priority' => 30
    ];

    $fields['billing']['billing_postcode'] = [
        'label' => 'Index',
        'placeholder' => '24',
        'required' => true,
        'class' => ['form-row-wide'],
        'priority' => 40
    ];

    $fields['billing']['billing_address_1'] = [
        'label' => 'Street',
        'placeholder' => 'Проспект Карла Маркса',
        'required' => true,
        'class' => ['form-row-wide'],
        'priority' => 50
    ];

    $fields['billing']['billing_address_2'] = [
        'label' => 'House number',
        'placeholder' => '24',
        'required' => true,
        'class' => ['form-row-wide'],
        'priority' => 60
    ];

    $fields['billing']['billing_phone'] = [
        'label' => 'Phone',
        'placeholder' => '+7 (997) 999-77-717',
        'required' => true,
        'class' => ['form-row-wide'],
        'priority' => 70
    ];

    $fields['billing']['billing_email'] = [
        'label' => 'E-mail address',
        'placeholder' => 'rus.ster.km24@apoditclinic.ru',
        'required' => true,
        'class' => ['form-row-wide'],
        'priority' => 80
    ];

    // Убедимся, что все поля имеют priority
    foreach ($fields['billing'] as $key => &$field) {
        if (!isset($field['priority'])) {
            $field['priority'] = 999;
        }
    }

    // Принудительная сортировка
    uasort($fields['billing'], function($a, $b) {
        return ($a['priority'] ?? 999) <=> ($b['priority'] ?? 999);
    });

    return $fields;
}
add_filter('woocommerce_default_address_fields', 'custom_override_default_address_fields');

function custom_override_default_address_fields($fields) {
    // Пример изменения label и placeholder
    $fields['country']['label'] = 'Country';
    $fields['country']['placeholder'] = 'Россия';
    $fields['country']['priority'] = 10;

    $fields['state']['label'] = 'Province ';
    $fields['state']['placeholder'] = 'Башкортостан';
    $fields['state']['required'] = true;
    $fields['state']['priority'] = 20;

    $fields['city']['label'] = 'City';
    $fields['city']['placeholder'] = 'Стерлитамак';
    $fields['city']['priority'] = 30;

    $fields['postcode']['label'] = 'Index';
    $fields['postcode']['placeholder'] = '453100';
    $fields['postcode']['priority'] = 40;

    $fields['address_1']['label'] = 'Street';
    $fields['address_1']['placeholder'] = 'Проспект Карла Маркса';
    $fields['address_1']['priority'] = 50;

    $fields['address_2']['label'] = 'House number';
    $fields['address_2']['placeholder'] = '24';
    $fields['address_2']['required'] = true;
    $fields['address_2']['priority'] = 60;

    return $fields;
}
add_filter( 'woocommerce_form_field', 'add_custom_class_to_checkout_labels', 10, 4 );
function add_custom_class_to_checkout_labels( $field_html, $key, $args, $value ) {
	// Если label уже имеет class — добавим к нему, иначе создадим
	if ( strpos( $field_html, 'class=' ) !== false ) {
		$field_html = preg_replace(
			'/<label([^>]+class=")([^"]*)"/',
			'<label$1$2 delivery__label-title"',
			$field_html
		);
	} else {
		$field_html = preg_replace(
			'/<label([^>]*)>/',
			'<label$1 class="delivery__label-title">',
			$field_html
		);
	}
	return $field_html;
}

//временно отключу некоторые пункты в меню 

function synergymax_disable_links_in_item($menu_item) {
    $disabled_items = array('Contacts', 'Events', 'Academy', 'Partnership');

    // Сверяем заголовок пункта меню
    if ( in_array($menu_item->title, $disabled_items) ) {
        $menu_item->url = '#'; 
    }
    return $menu_item;
}
add_filter('wp_setup_nav_menu_item', 'synergymax_disable_links_in_item', 20);
