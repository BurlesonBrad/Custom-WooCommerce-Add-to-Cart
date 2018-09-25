<?php
/*
Plugin Name: Custom WooCommerce Add to Cart
Description: A simple plugin to change the button text on a product per product basis.
Author: Brad Griffin
Contributors: BurlesonBrad
Version: 1.0
*/

// Add the Settings Field
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_button_text_field' );

// Save the Settings Field
add_action( 'woocommerce_process_product_meta', 'woo_save_button_text_field' );

// Change Button Text on the Single Product Page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_woocommerce_product_add_to_cart_text' );

// Change Button Text on the Archive Product Pages
add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );

/**
 * Add the custom field to the Edit Product page 
 */
function woo_add_button_text_field() { 
	
	echo '<div class="options_group">';
	
	// Custom fields will be created here...
	woocommerce_wp_text_input( 
		array( 
			'id'          => 'custom-add-to-cart-text', 
			'label'       => __( 'Custom Add to Cart Text', 'woocommerce' ), 
			'placeholder' => 'Add to Cart',
			'desc_tip'    => 'true',
			'description' => __( 'Enter any text here that will override the original Add to Cart button text.', 'woocommerce' ) 
		)
	);	
	
	echo '</div>';	

}

/**
 * Save our custom product fields
 */
function woo_save_button_text_field( $post_id ) {	

	update_post_meta( $post_id, 'custom-add-to-cart-text', esc_attr( $_POST['custom-add-to-cart-text'] ) );

}

/**
 * Change the button text on a per product basis
 */
function custom_woocommerce_product_add_to_cart_text( $text ) {
	return get_post_meta( get_the_ID(), 'custom-add-to-cart-text', true ) !== "" ? get_post_meta( get_the_ID(), 'custom-add-to-cart-text', true ) : $text;
}

