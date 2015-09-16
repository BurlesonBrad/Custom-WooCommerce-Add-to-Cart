<?php
/*
Plugin Name: Custom WooCommerce Add to Cart
Description: A simple plugin to change the button text on a product per product basis.
Author: Brad Griffen
Contributors: BurlesonBrad
Version: 1.0
*/

// Display Fields
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );

// Save Fields
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );

// Alter the buttons accordingly
add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_woocommerce_product_add_to_cart_text' );
add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );

/**
 * Add our custom fields to the Edit Product page 
 * 
 * @access public
 * @return void
 */
function woo_add_custom_general_fields() { 
	global $woocommerce, $post;
	
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
 * 
 * @access public
 * @param mixed $post_id
 * @return void
 */
function woo_add_custom_general_fields_save( $post_id ) {	
	// Save our custom Add to Cart text
	update_post_meta( $post_id, 'custom-add-to-cart-text', esc_attr( $_POST['custom-add-to-cart-text'] ) ); // When empty we want to wipe it out
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
