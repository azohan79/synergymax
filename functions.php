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

}
add_action('wp_enqueue_scripts', 'synergymax_styles_scripts');

class Synergymax_Walker_Nav extends Walker_Nav_Menu
{
    // Левая часть
    private $combine_items = array("Sobre", "Asociación");
    // Правая часть
    private $combine_items_right = array("Eventos", "Noticas", "Contactos");

    private $open_combined = false;
    private $open_combined_right = false;

    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<ul class="sub-menu">';
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        // Левая часть
        if ( in_array($item->title, $this->combine_items, true) ) {
            if (!$this->open_combined) {
                $output .= '<li class="header__item">';
                $this->open_combined = true;
            }
            $output .= '<a href="' . esc_url($item->url) . '" class="header__link">' 
                . esc_html($item->title) . '</a> ';
            return;
        }

        // Правая часть
        if ( in_array($item->title, $this->combine_items_right, true) ) {
            if (!$this->open_combined_right) {
                $output .= '<li class="header__item header__item-last">';
                $this->open_combined_right = true;
            }
            $output .= '<a href="' . esc_url($item->url) . '" class="header__link">'
                . esc_html($item->title) . '</a> ';
            return;
        }

        // Обычный пункт
        $output .= '<li class="header__item"><a href="' . esc_url($item->url) . '" class="header__link">' 
                 . esc_html($item->title) . '</a></li>';
    }

    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        // Закрываем общий <li> слева
        if ( $item->title === "Asociación" && $this->open_combined ) {
            $output .= '</li>';
            $this->open_combined = false;
        }

        // Закрываем общий <li> справа
        if ( $item->title === "Contactos" && $this->open_combined_right ) {
            $output .= '</li>';
            $this->open_combined_right = false;
        }
    }
}


// Регистрируем меню
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
        'label' => 'País',
        'placeholder' => 'Espana',
        'type' => 'text',
        'priority' => 10
    ]);

    $fields['billing']['billing_state'] = [
        'label' => 'Province ',
        'placeholder' => 'Valencia',
        'type' => 'text',
        'required' => true,
        'class' => ['form-row-wide'],
        'priority' => 20
    ];

    $fields['billing']['billing_city'] = [
        'label' => 'Ciudad',
        'placeholder' => 'Valencia',
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
        'label' => 'Calle',
        'placeholder' => 'Calle Mayor',
        'required' => true,
        'class' => ['form-row-wide'],
        'priority' => 50
    ];

    $fields['billing']['billing_address_2'] = [
        'label' => 'Número de casa',
        'placeholder' => '24',
        'required' => true,
        'class' => ['form-row-wide'],
        'priority' => 60
    ];

    $fields['billing']['billing_phone'] = [
        'label' => 'Teléfono',
        'placeholder' => '+34 (997) 999-77-717',
        'required' => true,
        'class' => ['form-row-wide'],
        'priority' => 70
    ];

    $fields['billing']['billing_email'] = [
        'label' => 'Correo electrónico',
        'placeholder' => 'ster.km24@synergymax.es',
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
    $fields['country']['placeholder'] = 'Espana';
    $fields['country']['priority'] = 10;

    $fields['state']['label'] = 'Province ';
    $fields['state']['placeholder'] = 'Valencia';
    $fields['state']['required'] = true;
    $fields['state']['priority'] = 20;

    $fields['city']['label'] = 'City';
    $fields['city']['placeholder'] = 'Valencia';
    $fields['city']['priority'] = 30;

    $fields['postcode']['label'] = 'Index';
    $fields['postcode']['placeholder'] = '45500';
    $fields['postcode']['priority'] = 40;

    $fields['address_1']['label'] = 'Street';
    $fields['address_1']['placeholder'] = 'Calle mayor';
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
    $disabled_items = array('Contactos', 'Eventos', 'Academia', 'Asociación');

    // Сверяем заголовок пункта меню
    if ( in_array($menu_item->title, $disabled_items) ) {
        $menu_item->url = '#'; 
    }
    return $menu_item;
}
add_filter('wp_setup_nav_menu_item', 'synergymax_disable_links_in_item', 20);


// Добавляем новый метод сортировки от старых товаров к новым
add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_oldest_to_newest_ordering_args' );
function custom_oldest_to_newest_ordering_args( $args ) {
    if ( isset( $_GET['orderby'] ) && $_GET['orderby'] === 'oldest_to_newest' ) {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    }
    return $args;
}

// Добавляем опцию в выпадающий список сортировки
add_filter( 'woocommerce_catalog_orderby', 'add_oldest_to_newest_orderby_option' );
function add_oldest_to_newest_orderby_option( $orderby ) {
    $orderby['oldest_to_newest'] = 'По порядку добавления (сначала старые)';
    return $orderby;
}

// Устанавливаем сортировку по умолчанию (от старых к новым)
add_filter('woocommerce_default_catalog_orderby', 'set_default_catalog_orderby');

function set_default_catalog_orderby() {
    return 'oldest_to_newest'; 
}

