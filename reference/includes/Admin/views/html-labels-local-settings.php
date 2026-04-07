<div class="rnb-setting-fields rnb-label-fields">
    <?php
    $inventory_title = get_post_meta($post_id, 'rnb_inventory_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'rnb_inventory_title',
            'name'        => 'rnb_inventory_title',
            'label'       => __('Choose Inventory', 'redq-rental'),
            'placeholder' => __('Choose Inventory', 'redq-rental'),
            'type'        => 'text',
            'value'       => $inventory_title,
        )
    );



    $flip_pricing_plan_text = get_post_meta($post_id, 'redq_flip_pricing_plan_text', true);

    woocommerce_wp_text_input(
        array(
            'id'          => 'flip_pricing_plan_text',
            'name'        => 'redq_flip_pricing_plan_text',
            'label'       => __('Show Pricing Info Heading Text', 'redq-rental'),
            'placeholder' => __('Show Pricing Info Heading Text', 'redq-rental'),
            'type'        => 'text',
            'value'       => $flip_pricing_plan_text,
        )
    );

    $unit_price = get_post_meta($post_id, 'rnb_unit_price', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'rnb_unit_price',
            'name'        => 'rnb_unit_price',
            'label'       => __('Unit Price Text', 'redq-rental'),
            'placeholder' => __('Per Day', 'redq-rental'),
            'type'        => 'text',
            'value'       => $unit_price,
        )
    );

    $pickup_location_heading_title = get_post_meta($post_id, 'redq_pickup_location_heading_title', true);

    woocommerce_wp_text_input(
        array(
            'id'          => 'pickup_location_heading_title',
            'name'        => 'redq_pickup_location_heading_title',
            'label'       => __('Pickup Location Heading Title', 'redq-rental'),
            'placeholder' => __('pickup location title', 'redq-rental'),
            'type'        => 'text',
            'value'       => $pickup_location_heading_title,
        )
    );


    $redq_pickup_loc_placeholder = get_post_meta($post_id, 'redq_pickup_loc_placeholder', true);

    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_pickup_loc_placeholder',
            'name'        => 'redq_pickup_loc_placeholder',
            'label'       => __('Pickup Location Placeholder', 'redq-rental'),
            'placeholder' => __('pickup location placeholder', 'redq-rental'),
            'type'        => 'text',
            'value'       => $redq_pickup_loc_placeholder,
        )
    );

    $dropoff_location_heading_title = get_post_meta($post_id, 'redq_dropoff_location_heading_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'dropoff_location_heading_title',
            'name'        => 'redq_dropoff_location_heading_title',
            'label'       => __('Dropoff Location Heading Title', 'redq-rental'),
            'placeholder' => __('Dropoff location title', 'redq-rental'),
            'type'        => 'text',
            'value'       => $dropoff_location_heading_title,
        )
    );

    $redq_return_loc_placeholder = get_post_meta($post_id, 'redq_return_loc_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_return_loc_placeholder',
            'name'        => 'redq_return_loc_placeholder',
            'label'       => __('Dropoff Location Placeholder', 'redq-rental'),
            'placeholder' => __('Dropoff location placeholder', 'redq-rental'),
            'type'        => 'text',
            'value'       => $redq_return_loc_placeholder,
        )
    );

    $pickup_date_heading_title = get_post_meta($post_id, 'redq_pickup_date_heading_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'pickup_date_heading_title',
            'name'        => 'redq_pickup_date_heading_title',
            'label'       => __('Pickup Date Heading Title', 'redq-rental'),
            'placeholder' => __('Pickup date title', 'redq-rental'),
            'type'        => 'text',
            'value'       => $pickup_date_heading_title,
        )
    );


    $pickup_date_placeholder = get_post_meta($post_id, 'redq_pickup_date_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'pickup_date_placeholder',
            'name'        => 'redq_pickup_date_placeholder',
            'label'       => __('Pickup Date Placeholder', 'redq-rental'),
            'placeholder' => __('Pickup date placeholder', 'redq-rental'),
            'type'        => 'text',
            'value'       => $pickup_date_placeholder,
        )
    );


    $pickup_time_placeholder = get_post_meta($post_id, 'redq_pickup_time_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'pickup_time_placeholder',
            'name'        => 'redq_pickup_time_placeholder',
            'label'       => __('Pickup Time Placeholder', 'redq-rental'),
            'placeholder' => __('Pickup date placeholder', 'redq-rental'),
            'type'        => 'text',
            'value'       => $pickup_time_placeholder,
        )
    );


    $dropoff_date_heading_title = get_post_meta($post_id, 'redq_dropoff_date_heading_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'dropoff_date_heading_title',
            'name'        => 'redq_dropoff_date_heading_title',
            'label'       => __('Dropoff Date Heading Title', 'redq-rental'),
            'placeholder' => __('Dropoff date title', 'redq-rental'),
            'type'        => 'text',
            'value'       => $dropoff_date_heading_title,
        )
    );


    $dropoff_date_placeholder = get_post_meta($post_id, 'redq_dropoff_date_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'dropoff_date_placeholder',
            'name'        => 'redq_dropoff_date_placeholder',
            'label'       => __('Drop-off Date Placeholder', 'redq-rental'),
            'placeholder' => __('Drop-off date placeholder', 'redq-rental'),
            'type'        => 'text',
            'value'       => $dropoff_date_placeholder,
        )
    );


    $dropoff_time_placeholder = get_post_meta($post_id, 'redq_dropoff_time_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'dropoff_time_placeholder',
            'name'        => 'redq_dropoff_time_placeholder',
            'label'       => __('Drop-off Time Placeholder', 'redq-rental'),
            'placeholder' => __('Drop-off time placeholder', 'redq-rental'),
            'type'        => 'text',
            'value'       => $dropoff_time_placeholder,
        )
    );

    $rnb_quantity_title = get_post_meta($post_id, 'rnb_quantity_label', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'rnb_quantity_title',
            'name'        => 'rnb_quantity_label',
            'label'       => __('Quantity Heading Title', 'redq-rental'),
            'placeholder' => __('Quantity title', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rnb_quantity_title,
        )
    );

    $rnb_cat_heading_title = get_post_meta($post_id, 'redq_rnb_cat_heading', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'rnb_cat_heading_title',
            'name'        => 'redq_rnb_cat_heading',
            'label'       => __('Category Heading Title', 'redq-rental'),
            'placeholder' => __('Category title', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rnb_cat_heading_title,
        )
    );

    $resources_heading_title = get_post_meta($post_id, 'redq_resources_heading_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'resources_heading_title',
            'name'        => 'redq_resources_heading_title',
            'label'       => __('Resources Heading Title', 'redq-rental'),
            'placeholder' => __('Resources title', 'redq-rental'),
            'type'        => 'text',
            'value'       => $resources_heading_title,
        )
    );

    $adults_heading_title = get_post_meta($post_id, 'redq_adults_heading_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'adults_heading_title',
            'name'        => 'redq_adults_heading_title',
            'label'       => __('Adults Heading Title', 'redq-rental'),
            'placeholder' => __('Adults title', 'redq-rental'),
            'type'        => 'text',
            'value'       => $adults_heading_title,
        )
    );

    $adults_placeholder = get_post_meta($post_id, 'redq_adults_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'adults_placeholder',
            'name'        => 'redq_adults_placeholder',
            'label'       => __('Adults Placeholder', 'redq-rental'),
            'placeholder' => __('Adults placeholder', 'redq-rental'),
            'type'        => 'text',
            'value'       => $adults_placeholder,
        )
    );

    $childs_heading_title = get_post_meta($post_id, 'redq_childs_heading_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'childs_heading_title',
            'name'        => 'redq_childs_heading_title',
            'label'       => __('Childs Heading Title', 'redq-rental'),
            'placeholder' => __('Childs title', 'redq-rental'),
            'type'        => 'text',
            'value'       => $childs_heading_title,
        )
    );

    $childs_placeholder = get_post_meta($post_id, 'redq_childs_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'childs_placeholder',
            'name'        => 'redq_childs_placeholder',
            'label'       => __('Childs Placeholder', 'redq-rental'),
            'placeholder' => __('Childs placeholder', 'redq-rental'),
            'type'        => 'text',
            'value'       => $childs_placeholder,
        )
    );


    $security_deposite_heading_title = get_post_meta($post_id, 'redq_security_deposite_heading_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'security_deposite_heading_title',
            'name'        => 'redq_security_deposite_heading_title',
            'label'       => __('Security Deposite Heading Title', 'redq-rental'),
            'placeholder' => __('Security deposite title', 'redq-rental'),
            'type'        => 'text',
            'value'       => $security_deposite_heading_title,
        )
    );

    $invalid_date_range_notice = get_post_meta($post_id, 'rnb_invalid_date_range_notice', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'rnb_invalid_date_range_notice',
            'name'        => 'rnb_invalid_date_range_notice',
            'label'       => __('Invalid Date Range Notice', 'redq-rental'),
            'placeholder' => __('Invalid Date Range Notice', 'redq-rental'),
            'type'        => 'text',
            'value'       => $invalid_date_range_notice,
        )
    );
    $max_day_notice = get_post_meta($post_id, 'rnb_max_day_notice', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'rnb_max_day_notice',
            'name'        => 'rnb_max_day_notice',
            'label'       => __('Max Day Notice', 'redq-rental'),
            'placeholder' => __('Max Day Notice', 'redq-rental'),
            'type'        => 'text',
            'value'       => $max_day_notice,
        )
    );
    $min_day_notice = get_post_meta($post_id, 'rnb_min_day_notice', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'rnb_min_day_notice',
            'name'        => 'rnb_min_day_notice',
            'label'       => __('Min Day Notice', 'redq-rental'),
            'placeholder' => __('Min Day Notice', 'redq-rental'),
            'type'        => 'text',
            'value'       => $min_day_notice,
        )
    );
    $max_hour_notice = get_post_meta($post_id, 'rnb_max_hour_notice', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'rnb_max_hour_notice',
            'name'        => 'rnb_max_hour_notice',
            'label'       => __('Max Hour Notice', 'redq-rental'),
            'placeholder' => __('Max Hour Notice', 'redq-rental'),
            'type'        => 'text',
            'value'       => $max_hour_notice,
        )
    );
    $min_hour_notice = get_post_meta($post_id, 'rnb_min_hour_notice', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'rnb_min_hour_notice',
            'name'        => 'rnb_min_hour_notice',
            'label'       => __('Min Hour Notice', 'redq-rental'),
            'placeholder' => __('Min Hour Notice', 'redq-rental'),
            'type'        => 'text',
            'value'       => $min_hour_notice,
        )
    );
    $quantity_notice = get_post_meta($post_id, 'rnb_quantity_notice', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'rnb_quantity_notice',
            'name'        => 'rnb_quantity_notice',
            'label'       => __('Invalid Quantity', 'redq-rental'),
            'placeholder' => __('Invalid Quantity', 'redq-rental'),
            'type'        => 'text',
            'value'       => $quantity_notice,
        )
    );


    $book_now_button_text = get_post_meta($post_id, 'redq_book_now_button_text', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'book_now_button_text',
            'name'        => 'redq_book_now_button_text',
            'label'       => __('Book Now Button Text', 'redq-rental'),
            'placeholder' => __('Book now button text', 'redq-rental'),
            'type'        => 'text',
            'value'       => $book_now_button_text,
        )
    );

    $rfq_button_text = get_post_meta($post_id, 'redq_rfq_button_text', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'rfq_button_text',
            'name'        => 'redq_rfq_button_text',
            'label'       => __('Request For Quote Button Text', 'redq-rental'),
            'placeholder' => __('Request For Quote Button Text', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_button_text,
        )
    );

    $rfq_username_title = get_post_meta($post_id, 'redq_username_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_username_title',
            'name'        => 'redq_username_title',
            'label'       => __('RFQ username title', 'redq-rental'),
            'placeholder' => __('Username', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_username_title,
        )
    );

    $rfq_username_placeholder = get_post_meta($post_id, 'redq_username_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_username_placeholder',
            'name'        => 'redq_username_placeholder',
            'label'       => __('RFQ username placeholder', 'redq-rental'),
            'placeholder' => __('Username', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_username_placeholder,
        )
    );

    $rfq_password_title = get_post_meta($post_id, 'redq_password_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_password_title',
            'name'        => 'redq_password_title',
            'label'       => __('RFQ password title', 'redq-rental'),
            'placeholder' => __('Password', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_password_title,
        )
    );

    $rfq_password_placeholder = get_post_meta($post_id, 'redq_password_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_password_placeholder',
            'name'        => 'redq_password_placeholder',
            'label'       => __('RFQ password placeholder', 'redq-rental'),
            'placeholder' => __('Password', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_password_placeholder,
        )
    );

    $rfq_first_name_title = get_post_meta($post_id, 'redq_first_name_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_first_name_title',
            'name'        => 'redq_first_name_title',
            'label'       => __('RFQ first Name title', 'redq-rental'),
            'placeholder' => __('First Name', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_first_name_title,
        )
    );

    $rfq_first_name_placeholder = get_post_meta($post_id, 'redq_first_name_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_first_name_placeholder',
            'name'        => 'redq_first_name_placeholder',
            'label'       => __('RFQ first Name placeholder', 'redq-rental'),
            'placeholder' => __('First Name', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_first_name_placeholder,
        )
    );

    $rfq_last_name_title = get_post_meta($post_id, 'redq_last_name_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_last_name_title',
            'name'        => 'redq_last_name_title',
            'label'       => __('RFQ last Name title', 'redq-rental'),
            'placeholder' => __('Last Name', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_last_name_title,
        )
    );

    $rfq_last_name_placeholder = get_post_meta($post_id, 'redq_last_name_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_last_name_placeholder',
            'name'        => 'redq_last_name_placeholder',
            'label'       => __('RFQ last Name placeholder', 'redq-rental'),
            'placeholder' => __('Last Name', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_last_name_placeholder,
        )
    );

    $rfq_email_title = get_post_meta($post_id, 'redq_email_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_email_title',
            'name'        => 'redq_email_title',
            'label'       => __('RFQ email title', 'redq-rental'),
            'placeholder' => __('Email', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_email_title,
        )
    );

    $rfq_email_placeholder = get_post_meta($post_id, 'redq_email_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_email_placeholder',
            'name'        => 'redq_email_placeholder',
            'label'       => __('RFQ email placeholder', 'redq-rental'),
            'placeholder' => __('Email', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_email_placeholder,
        )
    );

    $rfq_phone_title = get_post_meta($post_id, 'redq_phone_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_phone_title',
            'name'        => 'redq_phone_title',
            'label'       => __('RFQ phone title', 'redq-rental'),
            'placeholder' => __('Phone', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_phone_title,
        )
    );

    $rfq_phone_placeholder = get_post_meta($post_id, 'redq_phone_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_phone_placeholder',
            'name'        => 'redq_phone_placeholder',
            'label'       => __('RFQ phone placeholder', 'redq-rental'),
            'placeholder' => __('Phone', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_phone_placeholder,
        )
    );

    $rfq_message_title = get_post_meta($post_id, 'redq_message_title', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_message_title',
            'name'        => 'redq_message_title',
            'label'       => __('RFQ message title', 'redq-rental'),
            'placeholder' => __('Message', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_message_title,
        )
    );

    $rfq_message_placeholder = get_post_meta($post_id, 'redq_message_placeholder', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_message_placeholder',
            'name'        => 'redq_message_placeholder',
            'label'       => __('RFQ message placeholder', 'redq-rental'),
            'placeholder' => __('Message', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_message_placeholder,
        )
    );

    $rfq_submit_button_text = get_post_meta($post_id, 'redq_submit_button_text', true);
    woocommerce_wp_text_input(
        array(
            'id'          => 'redq_submit_button_text',
            'name'        => 'redq_submit_button_text',
            'label'       => __('RFQ submit button text', 'redq-rental'),
            'placeholder' => __('Submit', 'redq-rental'),
            'type'        => 'text',
            'value'       => $rfq_submit_button_text,
        )
    );
    ?>
</div>