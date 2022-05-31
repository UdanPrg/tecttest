<?php
// Conect Functions from parent theme
// if (!function_exists("parent_function_name")) { parent_function_name() { ...} }

function mytheme_add_woocommerce_support() {
add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

function relatedProductLimitWoo($args){
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
}

add_filter( 'woocommerce_output_related_products_args', 'relatedProductLimitWoo', 20 );
