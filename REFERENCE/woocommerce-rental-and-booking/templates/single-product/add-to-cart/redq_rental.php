<?php

/**
 * Redq rental product add to cart
 *
 * @author 		redqteam
 * @package 	RedqTeam/Templates
 * @version     1.0.0
 * @since       1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}



global $product;
$product_id = $product->get_ID();


$displays = redq_rental_get_settings($product_id, 'display');
$conditional_data = redq_rental_get_settings($product_id, 'conditions');
$conditional_data = $conditional_data['conditions'];
$displays = $displays['display'];

rnb_template_hooks();

/**
 * rnb_before_add_to_cart_form hook.
 *
 * @hooked rnb_price_flip_box - 10
 */
do_action('rnb_before_add_to_cart_form');

?>
<form class="cart rnb-cart" method="post" enctype='multipart/form-data' novalidate>
    <?php

    if ($conditional_data['booking_layout'] === 'layout_one') {
        /**
         * rnb_before_add_to_cart_form hook.
         *
         * @hooked rnb_price_flip_box - 10
         * @hooked rnb_pickup_locations - 10
         * @hooked rnb_return_locations - 10
         * @hooked rnb_pickup_datetimes - 10
         * @hooked rnb_payable_resources - 10
         * @hooked rnb_payable_persons - 10
         * @hooked rnb_payable_deposits - 10
         */
        do_action('rnb_main_rental_content');
    }


    /**
     * woocommerce_before_add_to_cart_button hook.
     *
     */
    do_action('woocommerce_before_add_to_cart_button');
    ?>

    <input type="hidden" name="currency-symbol" class="currency-symbol" value="<?php echo get_woocommerce_currency_symbol(); ?>">
    <input type="hidden" class="product_id" name="add-to-cart" value="<?php echo esc_attr($product_id); ?>" />
    <input type="hidden" class="quote_price" name="quote_price" value="0" />

    <?php
    if ($conditional_data['booking_layout'] === 'layout_one') :
        /**
         * rnb_plain_booking_button hook.
         *
         * @hooked rnb_direct_booking - 10
         * @hooked rnb_request_quote - 20
         */
        do_action('rnb_plain_booking_button');
    else :
        /**
         * rnb_modal_booking hook.
         *
         * @hooked rnb_modal_booking - 10
         */
        do_action('rnb_modal_booking');
    endif;

    /**
     * woocommerce_after_add_to_cart_button hook.
     *
     */
    if (!rnb_is_product_built_with_elementor($product_id)) {
        do_action('woocommerce_after_add_to_cart_button');
    }
    ?>
</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>