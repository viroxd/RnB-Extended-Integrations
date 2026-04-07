<?php

/**
 * View Quote
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  redqteam
 * @package RedQRental/Templates
 * @version 2.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}
if ($quote_id === '') { ?>
    <div class="woocommerce-error"><?php esc_html_e('Invalid quote.', 'redq-rental') ?> <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="wc-forward"><?php esc_html_e('My Account', 'redq-rental') ?></a></div>
<?php
    exit;
}
// global $post;
$quote = get_post($quote_id);

if ($quote->post_author == get_current_user_id()) { ?>
    <p>
        <?php
        printf(
            __('Quote #%1$s request was placed on %2$s and is currently %3$s.', 'redq-rental'),
            '<mark class="order-number">' . $quote_id . '</mark>',
            '<mark class="order-date">' . date_i18n(get_option('date_format'), strtotime($quote->post_date)) . '</mark>',
            '<mark class="order-status">' . redq_get_quote_status_name($quote->post_status) . '</mark>'
        );
        ?>
    </p>

    <h2><?php _e('Quote Details', 'redq-rental'); ?></h2>

    <table class="shop_table order_details">
        <thead>
            <tr>
                <th class="product-name"><?php _e('Product', 'redq-rental'); ?></th>
                <th class="product-total"><?php _e('Total', 'redq-rental'); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr class="order_item">
                <td class="product-name">
                    <?php echo get_the_title(get_post_meta($quote_id, 'add-to-cart', true)) ?> <strong class="product-quantity">× 1</strong>
                    <?php $quote_metas = json_decode(get_post_meta($quote_id, 'order_quote_meta', true), true); ?>
                    <dl class="variation">
                        <?php
                        $product_id = get_post_meta($quote_id, '_product_id', true);
                        $get_labels = redq_rental_get_settings($product_id, 'labels', array('pickup_location', 'return_location', 'pickup_date', 'return_date', 'resources', 'categories', 'person', 'deposites'));
                        $labels = $get_labels['labels'];

                        foreach ($quote_metas as $meta) {
                            if (isset($meta['name'])) {
                                switch ($meta['name']) {
                                    case 'add-to-cart':
                                    case 'cat_quantity':
                                    case 'quote_price':
                                    case 'cat_quantity[]':
                                    case 'rnb[]':
                                        break;

                                    case 'booking_inventory':
                                        if (!empty($meta['value'])) :
                                            echo '<dt style="float: left;margin-right: 10px;">' . esc_html__('Inventory', 'redq-rental') . ':</dt>';
                                            echo '<dd><p><strong>' . get_the_title($meta['value']) . '</strong></p></dd>';
                                        endif;
                                        break;

                                    case 'pickup_location':
                                        $meta['value'] = rnb_check_if_terms_exist($meta['value'], true, 'pickup_location');
                                        if (!empty( $meta['value'])) :
                                            $pickup_location       = get_pickup_location_data($meta['value'], 'pickup_location');
                                            $pickup_location_title = $labels['pickup_location'];
                                            $pickup_location_data  = explode('|', $pickup_location);
                                            $pickup_value = $pickup_location_data[1] . ' ( ' . wc_price($pickup_location_data[2]) . ' )';

                                            echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($pickup_location_title) . ':</dt>';
                                            echo '<dd><p><strong>' . $pickup_value . '</strong></p></dd>';
                                        endif;
                                        break;

                                    case 'dropoff_location':
                                        $meta['value'] = rnb_check_if_terms_exist($meta['value'], true, 'dropoff_location');
                                        if (!empty($meta['value'])) :
                                            $dropoff_location      = get_dropoff_location_data($meta['value'], 'dropoff_location');
                                            $return_location_title = $labels['return_location'];
                                            $return_location_data  = explode('|', $dropoff_location);
                                            $return_value          = $return_location_data[1] . ' ( ' . wc_price($return_location_data[2]) . ' )';

                                            echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($return_location_title) . ':</dt>';
                                            echo '<dd><p><strong>' . $return_value . '</strong></p></dd>';
                                        endif;
                                        break;

                                    case 'pickup_date':
                                        if (!empty($meta['value'])) :
                                            $pickup_date_title = $labels['pickup_date'];
                                            $pickup_date_value = $meta['value'];
                                            echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($pickup_date_title) . ':</dt>';
                                            echo '<dd><p><strong>' . $pickup_date_value . '</strong></p></dd>';
                                        endif;
                                        break;

                                    case 'pickup_time':
                                        if (!empty($meta['value'])) :
                                            $pickup_time_title = $labels['pickup_time'];
                                            $pickup_time_value = $meta['value'] ? $meta['value'] : '';
                                            echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($pickup_time_title) . ':</dt>';
                                            echo '<dd><p><strong>' . $pickup_time_value . '</strong></p></dd>';
                                        endif;
                                        break;

                                    case 'dropoff_date':
                                        if (!empty($meta['value'])) :
                                            $return_date_title = $labels['return_date'];
                                            $return_date_value = $meta['value'] ? $meta['value'] : '';
                                            echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($return_date_title) . ':</dt>';
                                            echo '<dd><p><strong>' . $return_date_value . '</strong></p></dd>';
                                        endif;
                                        break;

                                    case 'dropoff_time':
                                        if (!empty($meta['value'])) :
                                            $return_time_title = $labels['return_time'];
                                            $return_time_value = $meta['value'] ? $meta['value'] : '';
                                            echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($return_time_title) . ':</dt>';
                                            echo '<dd><p><strong>' . $return_time_value . '</strong></p></dd>';
                                        endif;
                                        break;

                                    case 'additional_adults_info':
                                        $meta['value'] = rnb_check_if_terms_exist($meta['value'], true, 'person');
                                        if (!empty($meta['value'])) :
                                            $adult = get_person_data($meta['value'], 'person');
                                            $person_title = $labels['adults'];
                                            $dval = explode('|', $adult);
                                            $person_value = $dval[0] . ' ( ' . wc_price($dval[1]) . ' - ' . $dval[2] . ' )';
                                            echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($person_title) . ':</dt>';
                                            echo '<dd><p><strong>' . $person_value . '</strong></p></dd>';
                                        endif;
                                        break;

                                    case 'additional_childs_info':
                                        $meta['value'] = rnb_check_if_terms_exist($meta['value'], true, 'person');
                                        if (!empty($meta['value'])) :
                                            $child = get_person_data($meta['value'], 'person');
                                            $person_title = $labels['childs'];
                                            $dval = explode('|', $child);
                                            $person_value = $dval[0] . ' ( ' . wc_price($dval[1]) . ' - ' . $dval[2] . ' )';
                                            echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($person_title) . ':</dt>';
                                            echo '<dd><p><strong>' . $person_value . '</strong></p></dd>';
                                        endif;
                                        break;

                                    case 'extras':
                                        $meta['value'] = rnb_check_if_terms_exist($meta['value'], false, 'resource');
                                        $resources = get_resource_data($meta['value'], 'resource');
                                        $resources_title = $labels['resource'];
                                        $resource_name = '';
                                        $payable_resource = array();
                                        foreach ($resources as $key => $value) {
                                            $extras = explode('|', $value);
                                            $payable_resource[$key]['resource_name'] = $extras[0];
                                            $payable_resource[$key]['resource_cost'] = $extras[1];
                                            $payable_resource[$key]['cost_multiply'] = $extras[2];
                                            $payable_resource[$key]['resource_hourly_cost'] = $extras[3];
                                        }
                                        foreach ($payable_resource as $key => $value) {
                                            if ($value['cost_multiply'] === 'per_day') {
                                                $resource_name .= $value['resource_name'] . ' ( ' . wc_price($value['resource_cost']) . ' - ' . __('Per Day', 'redq-rental') . ' )' . ' , <br> ';
                                            } else {
                                                $resource_name .= $value['resource_name'] . ' ( ' . wc_price($value['resource_cost']) . ' - ' . __('One Time', 'redq-rental') . ' )' . ' , <br> ';
                                            }
                                        }
                                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($resources_title) . ':</dt>';
                                        echo '<dd><p><strong>' . $resource_name . '</strong></p></dd>';
                                        break;

                                    case 'categories':
                                        $meta['value'] = rnb_check_if_terms_exist($meta['value'], false, 'rnb_categories');
                                        $categories = get_category_data($meta['value'],  'rnb_categories');
                                        $categories_title = $labels['categories'];
                                        $category_name = '';
                                        $payable_category = array();
                                        foreach ($categories as $key => $value) {
                                            $category = explode('|', $value);
                                            $payable_category[$key]['category_name'] = $category[0];
                                            $payable_category[$key]['category_cost'] = $category[1];
                                            $payable_category[$key]['cost_multiply'] = $category[2];
                                            $payable_category[$key]['category_hourly_cost'] = $category[3];
                                            $payable_category[$key]['category_qty'] = $category[4];
                                        }
                                        foreach ($payable_category as $key => $value) {
                                            if ($value['cost_multiply'] === 'per_day') {
                                                $category_name .= $value['category_name'] . ' ( ' . wc_price($value['category_cost']) . ' - ' . __('Per Day', 'redq-rental') . ' )' . ' * ' . $value['category_qty'] . ' , <br> ';
                                            } else {
                                                $category_name .= $value['category_name'] . ' ( ' . wc_price($value['category_cost']) . ' - ' . __('One Time', 'redq-rental') . ' )' . ' * ' . $value['category_qty'] . ' , <br> ';
                                            }
                                        }
                                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($categories_title) . ':</dt>';
                                        echo '<dd><p><strong>' . $category_name . '</strong></p></dd>';
                                        break;

                                    case 'security_deposites':
                                        $meta['value'] = rnb_check_if_terms_exist($meta['value'], false, 'deposite');

                                        $deposits = get_deposit_data($meta['value'], 'deposite');
                                        $deposits_title = $labels['deposite'];
                                        $deposite_name = '';
                                        $payable_deposits = array();
                                        foreach ($deposits as $key => $value) {
                                            $extras = explode('|', $value);
                                            $payable_deposits[$key]['deposite_name'] = $extras[0];
                                            $payable_deposits[$key]['deposite_cost'] = $extras[1];
                                            $payable_deposits[$key]['cost_multiply'] = $extras[2];
                                            $payable_deposits[$key]['deposite_hourly_cost'] = $extras[3];
                                        }
                                        foreach ($payable_deposits as $key => $value) {
                                            if ($value['cost_multiply'] === 'per_day') {
                                                $deposite_name .= $value['deposite_name'] . ' ( ' . wc_price($value['deposite_cost']) . ' - ' . __('Per Day', 'redq-rental') . ' )' . ' , <br> ';
                                            } else {
                                                $deposite_name .= $value['deposite_name'] . ' ( ' . wc_price($value['deposite_cost']) . ' - ' . __('One Time', 'redq-rental') . ' )' . ' , <br> ';
                                            }
                                        }
                                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($deposits_title) . ':</dt>';
                                        echo '<dd><p><strong>' . $deposite_name . '</strong></p></dd>';

                                        break;
                                    case 'inventory_quantity':
                                        echo '<dt style="float: left;margin-right: 10px;">' . esc_html__('Quantity', 'redq-rental') . ':</dt>';
                                        echo '<dd><p><strong>' . $meta['value'] . '</strong></p></dd>';
                                        break;

                                    default:
                                        $meta_name = ucfirst(str_replace('-', ' ', $meta['name']));
                                        echo '<dt style="float: left;margin-right: 10px;">' . $meta_name . ':</dt>';
                                        echo '<dd><p><strong>' . $meta['value'] . '</strong></p></dd>';
                                        break;
                                }
                            }
                        }
                        ?>
                    </dl>
                </td>
                <td class="product-total">
                    <span class="woocommerce-Price-amount amount">
                        <?php echo wc_price(get_post_meta($quote_id, '_quote_price', true)); ?>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>

    <?php
    if ($quote->post_status === 'quote-accepted') :
        $book_now     = true;
        $product_id   = get_post_meta($quote_id, 'add-to-cart', true);
        $wc_cart_data = WC()->cart->get_cart();

        if (!empty($wc_cart_data)) {
            foreach ($wc_cart_data as $cart_item) {
                if (isset($cart_item['rental_data'])) {
                    $rental_data = $cart_item['rental_data'];
                    foreach ($rental_data as $key => $value) {
                        if ($key === 'quote_id') {
                            if ($value === $quote_id) {
                                $book_now = false;
                            }
                        }
                    }
                }
            }
        }

        $has_order = get_post_meta($quote_id, '_rnb_rfq_order_id', true);
    ?>

        <?php if (!empty($has_order)) :  ?>
            <div class="rnb-rfq-success alert alert-success" role="alert">
                <?php echo esc_html__('Quote has been booked already', 'redq-rental'); ?>
            </div>
        <?php else : ?>

            <?php if ($book_now) { ?>
                <form class="ajax_cart" method="post">
                    <input type="hidden" name="quote_id" value="<?php echo $quote_id ?>">
                    <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                    <div class="cta-button">
                        <button type="submit" class="ajax_add_to_cart_buttons btn-book-now button alt">Book Now</button>
                    </div>
                </form>
            <?php } else { ?>
                <?php
                $cart_url     = wc_get_cart_url();
                $checkout_url = wc_get_checkout_url();
                ?>
                <div class="woocommerce-message">
                    <p><?php esc_html_e('This order is already in your cart. You can checkout the cart from here.', 'redq-rental') ?></p>
                    <p><a href="<?php echo esc_url($cart_url); ?>" class="button wc-forward" style="float: left"><?php esc_html_e('View Cart', 'redq-rental') ?></a></p>
                    <p><a href="<?php echo esc_url($checkout_url); ?>" class="checkout-button button alt wc-forward"><?php esc_html_e('Proceed to Checkout', 'redq-rental') ?></a></p>
                </div>
            <?php } ?>
        <?php endif ?>

    <?php endif; ?>



    <?php
    // Remove the comments_clauses where query here.
    remove_filter('comments_clauses', 'exclude_request_quote_comments_clauses');
    $args = array(
        'post_id' => $quote_id,
        'orderby' => 'comment_ID',
        'order'   => 'DESC',
        'approve' => 'approve',
        'type'    => 'quote_message'
    );
    $comments = get_comments($args); ?>
    <h3><?php esc_html_e('Messages', 'redq-rental') ?></h3>
    <?php do_action('redq_rental_reply_submit'); ?>
    <form class="quote-reply-form" method="post">
        <input type="hidden" name="quote-reply-id" value="<?php echo $quote_id ?>" />
        <p><textarea name="quote-reply-message" placeholder="<?php esc_html_e('Your message', 'redq-rental') ?>" required="true"></textarea></p>
        <?php wp_nonce_field('quote_reply_action', 'quote_reply_nonce_field'); ?>
        <p><button type="submit"><?php esc_html_e('Reply Message', 'redq-rental') ?></button></p>
    </form>

    <ul class="quote-message">
        <?php foreach ($comments as $comment) : ?>
            <?php
            $list_class = 'message-list';
            $content_class = 'quote-message-content';
            if ($comment->user_id === get_post_field('post_author', $quote_id)) {
                $list_class .= ' customer';
                $content_class .= ' customer';
            }
            ?>
            <li class="<?php echo $list_class ?>">
                <div class="<?php echo $content_class ?>">
                    <?php echo wpautop(wptexturize(wp_kses_post($comment->comment_content))); ?>
                </div>
                <p class="meta">
                    <abbr class="exact-date" title="<?php echo $comment->comment_date; ?>"><?php printf(__('added on %1$s at %2$s', 'redq-rental'), date_i18n(wc_date_format(), strtotime($comment->comment_date)), date_i18n(wc_time_format(), strtotime($comment->comment_date))); ?></abbr>
                    <?php printf(' ' . __('by %s', 'redq-rental'), $comment->comment_author); ?>
                </p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php
} else { ?>
    <p><?php esc_html_e('Sorry! Quote does not found.') ?></p>
<?php
} // end if quote author
?>