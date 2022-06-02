<?php
// Conect Functions from parent theme
// if (!function_exists("parent_function_name")) { parent_function_name() { ...} }

/**
 * # Function add theme suport woocommerce
 */
function mytheme_add_woocommerce_support() {
add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

/**
 * # Function arguments to filter limited related products
 */
function relatedProductLimitWoo($args){
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'relatedProductLimitWoo', 20 );

/**
 * # Function to create custom field
 */
function wooProductCF() {
    global $woocommerce, $post;
    echo '<div class="product_custom_field">';
    woocommerce_wp_text_input(
        array(
            'id'          => '_cf_disp_en_tienda',
            'label'       => __( 'Disponible en Tienda', 'woocommerce' ),
            'placeholder' => 'ej. Tienda Guatemala',
            'desc_tip'    => 'true'
        )
    );
    echo '</div>';
}
// The code for displaying WooCommerce Product Custom Fields
add_action( 'woocommerce_product_options_general_product_data', 'wooProductCF' ); 

/**
 * # Function to save in data base
 */
function wooProductCF_save($post_id)
{
    // Custom Product Text Field
    $textField_disponibleEnTienda = $_POST['_cf_disp_en_tienda'];
    if (!empty($textField_disponibleEnTienda))
        update_post_meta($post_id, '_cf_disp_en_tienda', esc_attr($textField_disponibleEnTienda));
}
// Following code Saves  WooCommerce Product Custom Fields
add_action( 'woocommerce_process_product_meta', 'wooProductCF_save');

function wooProductCF_display(){
    global $post;

    $product = wc_get_product($post->ID);
    $cf_woo_title = $product->get_meta('_cf_disp_en_tienda');
    if ($cf_woo_title) {
        printf(
            '<p id="_cf_disp_en_tienda"><strong>Disponible en: </strong>'.$cf_woo_title.'</p>',
        );
    }
}
add_action('woocommerce_single_product_summary', 'wooProductCF_display', 21);


/**
 * # En Tienda CF
 */
function cf_enTienda(){
    $args = array(
        'id' => 'customfield_enTienda',
        'label' => __('Add WooCommerce Custom Fields', 'cwoa'),
    );
    woocommerce_wp_text_input($args);
}
add_action('woocommerce_product_options_general_product_data', 'cf_enTienda');

function save_cf_enTienda($post_id){
    $product = wc_get_product($post_id);
    $cf_woo_title = isset($_POST['customfield_enTienda']) ? $_POST['customfield_enTienda'] : '';
    $product->update_meta_data('customfield_enTienda', sanitize_text_field($cf_woo_title));
    $product->save();
}
add_action('woocommerce_process_product_meta', 'save_cf_enTienda');

function customfield_enTienda_display(){
    global $post;

    $product = wc_get_product($post->ID);
    $cf_woo_title = $product->get_meta('customfield_enTienda');
    if ($cf_woo_title) {
        printf(
            '<div><label>%s</label><input type="text" id="cf_enTienda_title" name="cf_enTienda_title" value=""></div>',
            esc_html($cf_woo_title)
        );
    }
}

add_action('woocommerce_before_add_to_cart_button', 'customfield_enTienda_display');

// Disable all stylesheets Woo
// --> add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// function testwc() {
//     global $woocommerce;
//     return print_r($woocommerce->get('products/producto/playstation-4/', ['_jsonp' => 'tagDetails']));
// }