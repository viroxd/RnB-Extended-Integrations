<?php
// wp_enqueue_scripts('woocommerce_admin_styles');
$product_id = get_post_meta($post->ID, 'add-to-cart', true);
$product = wc_get_product($product_id);
if ($product) {
    $get_labels = redq_rental_get_settings($product_id, 'labels', array('pickup_location', 'return_location', 'pickup_date', 'return_date', 'resources', 'categories', 'person', 'deposites'));
    $labels = $get_labels['labels'];
    $order_quote_meta = json_decode(stripslashes(get_post_meta($post->ID, 'order_quote_meta', true)), true);
    if (is_null($order_quote_meta)) {
        $order_quote_meta = json_decode(get_post_meta($post->ID, 'order_quote_meta', true), true);
    }
?>
    <div id="woocommerce-order-items">
        <div class="woocommerce_order_items_wrapper wc-order-items-editable">
            <table class="woocommerce_order_items">
                <thead>
                    <tr>
                        <th><?php echo esc_html__('Item', 'redq-rental'); ?></th>
                        <th><?php echo esc_html__('Quote Price', 'redq-rental'); ?></th>
                        <th><?php echo esc_html__('Qty', 'redq-rental'); ?></th>
                        <th><?php echo esc_html__('Total', 'redq-rental'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="view">
                                <table cellspacing="0" class="display_meta">
                                    <tbody>
                                        <tr>
                                            <td class="thumb">
                                                <div class="wc-order-item-thumbnail">
                                                    <?php if (has_post_thumbnail($product_id)) {
                                                        echo get_the_post_thumbnail($product_id, 'thumbnail');
                                                    } else {
                                                    ?>
                                                        <span class="dashicons dashicons-format-image"></span>
                                                    <?php }
                                                    ?>

                                                </div>
                                            </td>
                                            <td>
                                                <a href="<?php echo esc_url(get_the_permalink($product->get_id())); ?>" class="quote-title">
                                                    <?php echo esc_html($product->get_title()); ?>
                                                </a>
                                                <div class="view">
                                                    <?php
                                                    $contacts = array();
                                                    $price_data = [];
                                                    foreach ($order_quote_meta as $meta) {
                                                        if (isset($meta['name'])) {
                                                            switch ($meta['name']) {
                                                                case 'add-to-cart':
                                                                case 'cat_quantity':
                                                                case 'currency-symbol':
                                                                case 'rnb[]':
                                                                    break;
                                                                case 'booking_inventory':
                                                                    if (!empty($meta['value'])) :
                                                                        echo '<dt style="float: left;margin-right: 10px;">' . esc_html__('Inventory', 'redq-rental') . ':</dt>';
                                                                        echo '<dd><p>' . get_the_title($meta['value']) . '</p></dd>';
                                                                    endif;
                                                                    break;

                                                                case 'pickup_location':
                                                                    $meta['value'] = rnb_check_if_terms_exist($meta['value'], true, 'pickup_location');
                                                                    if (!empty($meta['value'])) :
                                                                        $pickup_location       = get_pickup_location_data($meta['value'], 'pickup_location');
                                                                        $pickup_location_title = $labels['pickup_location'];
                                                                        $pickup_location_data  = explode('|', $pickup_location);
                                                                        $pickup_value = $pickup_location_data[1] . ' ( ' . wc_price($pickup_location_data[2]) . ' )';

                                                                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($pickup_location_title) . ':</dt>';
                                                                        echo '<dd><p>' . $pickup_value . '</p></dd>';
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
                                                                        echo '<dd><p>' . $return_value . '</p></dd>';
                                                                    endif;
                                                                    break;

                                                                case 'pickup_date':
                                                                    if (!empty($meta['value'])) :
                                                                        $pickup_date_title = $labels['pickup_date'];
                                                                        $pickup_date_value = $meta['value'];
                                                                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($pickup_date_title) . ':</dt>';
                                                                        echo '<dd><p>' . $pickup_date_value . '</p></dd>';
                                                                    endif;
                                                                    break;

                                                                case 'pickup_time':
                                                                    if (!empty($meta['value'])) :
                                                                        $pickup_time_title = $labels['pickup_time'];
                                                                        $pickup_time_value = $meta['value'] ? $meta['value'] : '';
                                                                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($pickup_time_title) . ':</dt>';
                                                                        echo '<dd><p>' . $pickup_time_value . '</p></dd>';
                                                                    endif;
                                                                    break;

                                                                case 'dropoff_date':
                                                                    if (!empty($meta['value'])) :
                                                                        $return_date_title = $labels['return_date'];
                                                                        $return_date_value = $meta['value'] ? $meta['value'] : '';
                                                                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($return_date_title) . ':</dt>';
                                                                        echo '<dd><p>' . $return_date_value . '</p></dd>';
                                                                    endif;
                                                                    break;

                                                                case 'dropoff_time':
                                                                    if (!empty($meta['value'])) :
                                                                        $return_time_title = $labels['return_time'];
                                                                        $return_time_value = $meta['value'] ? $meta['value'] : '';
                                                                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($return_time_title) . ':</dt>';
                                                                        echo '<dd><p>' . $return_time_value . '</p></dd>';
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
                                                                        echo '<dd><p>' . $person_value . '</p></dd>';
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
                                                                        echo '<dd><p>' . $person_value . '</p></dd>';
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
                                                                    echo '<dd><p>' . $resource_name . '</p></dd>';
                                                                    break;

                                                                case 'categories':
                                                                    $meta['value'] = rnb_check_if_terms_exist($meta['value'], false, 'rnb_categories');
                                                                    $categories = get_category_data($meta['value'], 'rnb_categories');
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
                                                                            $category_name .= $value['category_name'] . ' ( ' . wc_price($value['category_cost']) . ' - ' . __('Per Day', 'redq-rental') . ' )' . ' * ' . $value['category_qty'] . ' <span class="qdot">, </span> <br> ';
                                                                        } else {
                                                                            $category_name .= $value['category_name'] . ' ( ' . wc_price($value['category_cost']) . ' - ' . __('One Time', 'redq-rental') . ' )' . ' * ' . $value['category_qty'] . ' <span class="qdot">, </span> <br> ';
                                                                        }
                                                                    }
                                                                    echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($categories_title) . ':</dt>';
                                                                    echo '<dd><p>' . $category_name . '</p></dd>';
                                                                    break;

                                                                case 'cat_quantity[]':
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
                                                                    echo '<dd><p>' . $deposite_name . '</p></dd>';
                                                                    break;

                                                                case 'inventory_quantity':
                                                                    $price_data['quantity'] = $meta['value'];
                                                                    break;

                                                                case 'quote_price':
                                                                    $price_data['quote_price'] = $meta['value'];
                                                                    break;

                                                                default:
                                                                    $meta_name = ucfirst(str_replace('-', ' ', $meta['name']));
                                                                    echo '<dt style="float: left;margin-right: 10px;">' . $meta_name . ':</dt>';
                                                                    echo '<dd><p>' . $meta['value'] . '</p></dd>';
                                                                    break;
                                                            }
                                                        }
                                                        if (isset($meta['forms'])) {
                                                            $contacts = $meta['forms'];
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                        <td>
                            <?php
                            if (isset($price_data['quote_price'])) {
                                echo  wc_price($price_data['quote_price']);
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if (isset($price_data['quantity'])) {
                                echo esc_html($price_data['quantity']);
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if (isset($price_data['quantity']) && $price_data['quote_price']) {
                                $total_price = (int) $price_data['quote_price'] * (int) $price_data['quantity'];
                                echo  wc_price($total_price);
                            }
                            ?>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>