<div class="rnb-setting-fields rnb-display-fields">
    <?php
    $show_pickup_date = get_post_meta($post_id, 'redq_rental_local_show_pickup_date', true);
    if (empty($show_pickup_date)) {
        $pickupdate = get_option('rnb_show_pickup_date');
        if (empty($pickupdate)) {
            $show_pickup_date = 'open';
        } else {
            if (get_option('rnb_show_pickup_date') === 'yes') {
                $show_pickup_date = 'open';
            } else {
                $show_pickup_date = 'closed';
            }
        }
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_show_pickup_date',
            'label'   => __('Show Pickup Date', 'redq-rental'),
            'cbvalue' => 'open',
            'value'   => esc_attr($show_pickup_date),
        )
    );

    $show_pickup_time = get_post_meta($post_id, 'redq_rental_local_show_pickup_time', true);
    if (empty($show_pickup_time)) {
        $pickuptime = get_option('rnb_show_pickup_time');
        if (empty($pickuptime)) {
            $show_pickup_time = 'open';
        } else {
            if (get_option('rnb_show_pickup_time') === 'yes') {
                $show_pickup_time = 'open';
            } else {
                $show_pickup_time = 'closed';
            }
        }
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_show_pickup_time',
            'label'   => __('Show Pickup Time', 'redq-rental'),
            'cbvalue' => 'open',
            'value'   => esc_attr($show_pickup_time),
        )
    );

    $show_dropoff_date = get_post_meta($post_id, 'redq_rental_local_show_dropoff_date', true);
    if (empty($show_dropoff_date)) {
        $dropoffdate = get_option('rnb_show_dropoff_date');
        if (empty($dropoffdate)) {
            $show_dropoff_date = 'open';
        } else {
            if (get_option('rnb_show_dropoff_date') === 'yes') {
                $show_dropoff_date = 'open';
            } else {
                $show_dropoff_date = 'closed';
            }
        }
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_show_dropoff_date',
            'label'   => __('Show Dropoff Date', 'redq-rental'),
            'cbvalue' => 'open',
            'value'   => esc_attr($show_dropoff_date),
        )
    );

    $show_dropoff_time = get_post_meta($post_id, 'redq_rental_local_show_dropoff_time', true);
    if (empty($show_dropoff_time)) {
        $dropofftime = get_option('rnb_show_dropoff_time');
        if (empty($dropofftime)) {
            $show_dropoff_time = 'open';
        } else {
            if (get_option('rnb_show_dropoff_time') === 'yes') {
                $show_dropoff_time = 'open';
            } else {
                $show_dropoff_time = 'closed';
            }
        }
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_show_dropoff_time',
            'label'   => __('Show Dropoff Time', 'redq-rental'),
            'cbvalue' => 'open',
            'value'   => esc_attr($show_dropoff_time),
        )
    );


    $enable_quantity = get_post_meta($post_id, 'rnb_enable_quantity', true);
    if (empty($enable_quantity)) {
        $qty = get_option('rnb_enable_quantity');
        if (empty($qty)) {
            $enable_quantity = 'open';
        } else {
            if (get_option('rnb_enable_quantity') === 'yes') {
                $enable_quantity = 'open';
            } else {
                $enable_quantity = 'closed';
            }
        }
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'rnb_enable_quantity',
            'label'   => __('Enable Quantity', 'redq-rental'),
            'cbvalue' => 'open',
            'value'   => esc_attr($enable_quantity),
        )
    );


    $show_pricing_flip_box = get_post_meta($post_id, 'redq_rental_local_show_pricing_flip_box', true);
    if (empty($show_pricing_flip_box)) {
        $flipbox = get_option('rnb_enable_price_flipbox');
        if (empty($flipbox)) {
            $show_pricing_flip_box = 'open';
        } else {
            if (get_option('rnb_enable_price_flipbox') === 'yes') {
                $show_pricing_flip_box = 'open';
            } else {
                $show_pricing_flip_box = 'closed';
            }
        }
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_show_pricing_flip_box',
            'label'   => __('Show pricing flip box', 'redq-rental'),
            'cbvalue' => 'open',
            'value'   => esc_attr($show_pricing_flip_box),
        )
    );

    $show_price_discount_on_days = get_post_meta($post_id, 'redq_rental_local_show_price_discount_on_days', true);
    if (empty($show_price_discount_on_days)) {
        $discount = get_option('rnb_enable_price_discount');
        if (empty($discount)) {
            $show_price_discount_on_days = 'open';
        } else {
            if (get_option('rnb_enable_price_discount') === 'yes') {
                $show_price_discount_on_days = 'open';
            } else {
                $show_price_discount_on_days = 'closed';
            }
        }
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_show_price_discount_on_days',
            'label'   => __('Show price discount', 'redq-rental'),
            'cbvalue' => 'open',
            'value'   => esc_attr($show_price_discount_on_days),
        )
    );


    $show_price_instance_payment = get_post_meta($post_id, 'redq_rental_local_show_price_instance_payment', true);
    if (empty($show_price_instance_payment)) {
        $instance_payment = get_option('rnb_enable_instance_payment');
        if (empty($instance_payment)) {
            $show_price_instance_payment = 'open';
        } else {
            if (get_option('rnb_enable_instance_payment') === 'yes') {
                $show_price_instance_payment = 'open';
            } else {
                $show_price_instance_payment = 'closed';
            }
        }
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_show_price_instance_payment',
            'label'   => __('Show instance payment', 'redq-rental'),
            'cbvalue' => 'open',
            'value'   => esc_attr($show_price_instance_payment),
        )
    );

    $show_request_quote = get_post_meta($post_id, 'redq_rental_local_show_request_quote', true);
    if (empty($show_request_quote)) {
        $show_request_quote_global = get_option('rnb_enable_rft_endpoint');
        if (empty($show_request_quote_global)) {
            $show_request_quote = 'closed';
        } else {
            if ($show_request_quote_global === 'yes') {
                $show_request_quote = 'open';
            } else {
                $show_request_quote = 'closed';
            }
        }
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_show_request_quote',
            'label'   => __('Show Quote Request', 'redq-rental'),
            'cbvalue' => 'open',
            'value'   => esc_attr($show_request_quote),
        )
    );

    $show_book_now = get_post_meta($post_id, 'redq_rental_local_show_book_now', true);
    if (empty($show_book_now)) {
        $disable_book_now = get_option('rnb_enable_book_now_btn');
        if (empty($disable_book_now)) {
            $show_book_now = 'open';
        } else {
            if (get_option('rnb_enable_book_now_btn') === 'yes') {
                $show_book_now = 'closed';
            } else {
                $show_book_now = 'open';
            }
        }
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_show_book_now',
            'label'   => __('Show Book Now', 'redq-rental'),
            'cbvalue' => 'open',
            'value'   => esc_attr($show_book_now),
        )
    );
    ?>
</div>