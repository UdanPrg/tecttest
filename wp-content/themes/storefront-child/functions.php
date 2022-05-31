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
add_action( 'woocommerce_process_product_meta', 'wooProductCF_save' );

// Disable all stylesheets Woo
// --> add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );