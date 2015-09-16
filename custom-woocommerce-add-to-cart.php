<?php
/*
Plugin Name: Custom WooCommerce Add to Cart
Description: A simple plugin to change the button text on a product per product basis.
Author: Brad Griffen
Contributors: BurlesonBrad
Version: 1.0
*/

// Add the Settings Field
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_button_text_field' );

// Save the Settings Field
add_action( 'woocommerce_process_product_meta', 'woo_save_button_text_field' );

// Alter the buttons accordingly
add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_woocommerce_product_add_to_cart_text' );
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
 * Allows us to retrieve the custom values on a per product basis
 * 
 * @access public
 * @return string Either the custom text or defaults to 'Add to Cart'
 */
function custom_woocommerce_product_add_to_cart_text() {
	$customText = get_post_meta( get_the_ID(), 'custom-add-to-cart-text', true );
	
	if ( empty( $customText ) )
		return __( 'Add to Cart', 'woocommerce' );
		
	// If we don't return anything then it defaults to what was already set, 
	// this would allow someone else to override the text and us not mess it up down the road	
}
