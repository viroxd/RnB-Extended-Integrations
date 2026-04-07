<div class="rnb-setting-fields rnb-condition-fields">

    <?php do_action('rnb_before_local_conditions_settings', $post_id); ?>

    <?php

    $date_format = get_post_meta($post_id, 'redq_calendar_date_format', true);
    woocommerce_wp_select(
        array(
            'id'          => 'choose_date_format',
            'label'       => __('Date Format', 'redq-rental'),
            'description' => __('Date will display in this format all place in rental product', 'redq-rental'),
            'desc_tip'    => true,
            'options'     => array(
                'm/d/Y' => __('m/d/Y', 'redq-rental'),
                'd/m/Y' => __('d/m/Y', 'redq-rental'),
                'Y/m/d' => __('Y/m/d', 'redq-rental'),
            ),
            'value'       => $date_format
        )
    );

    $time_format = get_post_meta($post_id, 'redq_calendar_time_format', true);
    woocommerce_wp_select(
        array(
            'id'          => 'choose_time_format',
            'label'       => __('Time Format', 'redq-rental'),
            'description' => __('This will be applicable in the time picker field in product page', 'redq-rental'),
            'options'     => array(
                '24-hours' => __('24 Hours', 'redq-rental'),
                '12-hours' => __('12 Hours', 'redq-rental'),
            ),
            'value'       => $time_format
        )
    );

    $max_time_late = get_post_meta($post_id, 'redq_max_time_late', true);
    woocommerce_wp_text_input(
        array(
            'id'                => 'max_time_late',
            'name'              => 'redq_max_time_late',
            'label'             => __('Max Hour Late', 'redq-rental'),
            'description'       => __('Another day will count if customer returns by exceeding this no. of hour. Suppose you set the hour as 2. Now if a customer place an order from  10/10/2018 at 10:00 to 12/10/2018 at 12:00 he will be charged for 2 days ( although here is 50 hours means 2days and 2 hours). Now if he returns after 12/10/2018 at 12:00 then he will be charged for 3days ', 'redq-rental'),
            'desc_tip'          => true,
            'placeholder'       => __('E.g. - 2 (floating value is not allowed)', 'redq-rental'),
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min'  => '0'
            ),
            'value'             => $max_time_late,
        )
    );

    $rnb_pay_extra_hours = get_post_meta($post_id, 'rnb_pay_extra_hours', true);
    woocommerce_wp_select(
        array(
            'id'          => 'rnb_pay_extra_hours',
            'label'       => __('Pay Extra Hours', 'redq-rental'),
            'description' => __('If you make this option as yes then customer has to pay for extra hours in hourly pricing plan.', 'redq-rental'),
            'options'     => array(
                'yes' => __('Yes', 'redq-rental'),
                'no'  => __('No', 'redq-rental'),
            ),
            'value'       => $rnb_pay_extra_hours
        )
    );

    $single_day_booking = get_post_meta($post_id, 'redq_rental_local_enable_single_day_time_based_booking', true);
    if (isset($single_day_booking) && empty($single_day_booking)) {
        $single_day_booking = 'open';
    }
    woocommerce_wp_checkbox(
        array(
            'id'          => 'redq_rental_local_enable_single_day_time_based_booking',
            'label'       => __('Single Day Booking', 'redq-rental'),
            'desc_tip'    => true,
            'description' => sprintf(__('Checked : If pickup and return date are same then it counts as 1-day. Also select this for single date. FYI : Set max time late as at least 0 for this. UnChecked : If pickup and return date are same then it counts as 0-day. Also select this for single date. ', 'redq-rental')),
            'cbvalue'     => 'open',
            'value'       => esc_attr($single_day_booking),
        )
    );

    $include_trailing_date = get_post_meta($post_id, 'rnb_include_trailing_date', true);
    if (isset($include_trailing_date) && empty($include_trailing_date)) {
        $include_trailing_date = 'open';
    }
    woocommerce_wp_checkbox(
        array(
            'id'          => 'rnb_include_trailing_date',
            'label'       => __('Enable Trailing Date', 'redq-rental'),
            'desc_tip'    => true,
            'description' => sprintf(__('Checked : if pickup & return time are disabled then pickup date and return date will count as individual date. Also make sure that you set pay extra hour option as no. UnChecked : if pickup & return time are disabled then pickup date and return date will count as previous manner means without 24-hours separate date will not count', 'redq-rental')),
            'cbvalue'     => 'open',
            'value'       => esc_attr($include_trailing_date),
        )
    );

    $max_rental_days = get_post_meta($post_id, 'redq_max_rental_days', true);
    woocommerce_wp_text_input(
        array(
            'id'                => 'max_rental_days',
            'name'              => 'redq_max_rental_days',
            'label'             => __('Maximum Booking Days', 'redq-rental'),
            'placeholder'       => __('E.g. - 5', 'redq-rental'),
            'description'       => __('No. of days that customer must have to select during placing an order otherwise he will not be allowed to place an order', 'redq-rental'),
            'desc_tip'          => true,
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min'  => '0'
            ),
            'value'             => $max_rental_days,
        )
    );


    $min_rental_days = get_post_meta($post_id, 'redq_min_rental_days', true);
    woocommerce_wp_text_input(
        array(
            'id'                => 'min_rental_days',
            'name'              => 'redq_min_rental_days',
            'label'             => __('Minimum Booking Days', 'redq-rental'),
            'placeholder'       => __('E.g. - 1', 'redq-rental'),
            'description'       => __('No. of days that customer must have to select during placing an order otherwise he will not be allowed to place an order', 'redq-rental'),
            'desc_tip'          => true,
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min'  => '0'
            ),
            'value'             => $min_rental_days,
        )
    );
    $max_rental_hours = get_post_meta($post_id, 'redq_max_rental_hours', true);
    woocommerce_wp_text_input(
        array(
            'id'                => 'max_rental_hours',
            'name'              => 'redq_max_rental_hours',
            'label'             => __('Maximum Booking Hours', 'redq-rental'),
            'placeholder'       => __('E.g. - 15', 'redq-rental'),
            'description'       => __('No. of hours that customer must have to select during placing an order otherwise he will not be allowed to place an order', 'redq-rental'),
            'desc_tip'          => true,
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min'  => '0'
            ),
            'value'             => $max_rental_hours,
        )
    );


    $min_rental_hours = get_post_meta($post_id, 'redq_min_rental_hours', true);
    woocommerce_wp_text_input(
        array(
            'id'                => 'min_rental_hours',
            'name'              => 'redq_min_rental_hours',
            'label'             => __('Minimum Booking Hours', 'redq-rental'),
            'placeholder'       => __('E.g. - 10', 'redq-rental'),
            'description'       => __('No. of hours that customer must have to select during placing an order otherwise he will not be allowed to place an order', 'redq-rental'),
            'desc_tip'          => true,
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min'  => '0'
            ),
            'value'             => $min_rental_hours,
        )
    );

    $starting_block_days = get_post_meta($post_id, 'redq_rental_starting_block_dates', true);
    woocommerce_wp_text_input(
        array(
            'id'                => 'starting_block_days',
            'name'              => 'redq_rental_starting_block_dates',
            'label'             => __('Initially blocked dates in calendar', 'redq-rental'),
            'placeholder'       => __('E.g. - 2', 'redq-rental'),
            'description'       => __('If you set the value as 2, When someone open the calendar in product page if today is 10/10/2018 then customer will see the initially bookable date as 12/10/2018', 'redq-rental'),
            'desc_tip'          => true,
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min'  => '0'
            ),
            'value'             => $starting_block_days,
        )
    );

    $pre_booking_block_days = get_post_meta($post_id, 'redq_rental_before_booking_block_dates', true);
    woocommerce_wp_text_input(
        array(
            'id'                => 'pre_booking_block_days',
            'name'              => 'redq_rental_before_booking_block_dates',
            'label'             => __('Pre Booking Block Days', 'redq-rental'),
            'placeholder'       => __('E.g. - 2', 'redq-rental'),
            'description'       => __('Selected no. of days will be blocked automatically after a booking order and customer will not be charged for extra these days. Suppose you set the value 2. Now if any customer books date from 10/10/18 to 12/10/18 then after completing the order 08/10/18 to 10/10/18 date will be disabled in calendar for this order. Although customer will not be charged for these extra 2 days', 'redq-rental'),
            'desc_tip'          => true,
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min'  => '0'
            ),
            'value'             => $pre_booking_block_days,
        )
    );


    $post_booking_block_days = get_post_meta($post_id, 'redq_rental_post_booking_block_dates', true);
    woocommerce_wp_text_input(
        array(
            'id'                => 'post_booking_block_days',
            'name'              => 'redq_rental_post_booking_block_dates',
            'label'             => __('Post Booking Block Days', 'redq-rental'),
            'placeholder'       => __('E.g. - 2', 'redq-rental'),
            'description'       => __('Selected no. of days will be blocked automatically after a booking and customer will not be charged for extra these days. Suppose you set the value 2. Now if any customer books date from 10/10/18 to 12/10/18 then after completing the order 10/10/18 to 14/10/18 date will be disabled in calendar for this order. Although customer will not be charged for these extra 2 days', 'redq-rental'),
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min'  => '0'
            ),
            'desc_tip'          => true,
            'value'             => $post_booking_block_days,
        )
    );

    $pre_booking_block_hours = get_post_meta($post_id, 'redq_rental_before_booking_block_hours', true);
    woocommerce_wp_text_input(
        array(
            'id'                => 'pre_booking_block_hours',
            'name'              => 'redq_rental_before_booking_block_hours',
            'label'             => __('Pre Booking Block Hours', 'redq-rental'),
            'placeholder'       => __('E.g. - 2', 'redq-rental'),
            'description'       => __('Selected no. of hours will be blocked automatically after a booking order and customer will not be charged for extra these hours. Suppose you set the value 2. Now if any customer books date from 10am to 12pm then after completing the order 8am to 10am date will be disabled in calendar for this order. Although customer will not be charged for these extra 2 hours', 'redq-rental'),
            'desc_tip'          => true,
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min'  => '0'
            ),
            'value'             => $pre_booking_block_hours,
        )
    );


    $post_booking_block_hours = get_post_meta($post_id, 'redq_rental_post_booking_block_hours', true);
    woocommerce_wp_text_input(
        array(
            'id'                => 'post_booking_block_hours',
            'name'              => 'redq_rental_post_booking_block_hours',
            'label'             => __('Post Booking Block Hours', 'redq-rental'),
            'placeholder'       => __('E.g. - 2', 'redq-rental'),
            'description'       => __('Selected no. of hours will be blocked automatically after a booking and customer will not be charged for extra these hours. Suppose you set the value 2. Now if any customer books date from 10am to 12pm then after completing the order 8am to 2pm date will be disabled in calendar for this order. Although customer will not be charged for these extra 2 hours', 'redq-rental'),
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min'  => '0'
            ),
            'desc_tip'          => true,
            'value'             => $post_booking_block_hours,
        )
    );

    $time_interval = get_post_meta($post_id, 'redq_time_interval', true);
    woocommerce_wp_text_input(
        array(
            'id'                => 'time_interval',
            'name'              => 'redq_time_interval',
            'label'             => __('Time Interval', 'redq-rental'),
            'placeholder'       => __('Time Interval in mins E.g. - 20', 'redq-rental'),
            'description'       => __('Time Interval in mins E.g. - 20. Time interval will not work if you use allowed times options', 'redq-rental'),
            'type'              => 'number',
            'data_type'         => 'decimal',
            'custom_attributes' => array(
                'step' => '1',
                'min'  => '0',
                'max'  => '60'
            ),
            'desc_tip'          => true,
            'value'             => $time_interval,
        )
    );

    woocommerce_wp_select(
        array(
            'id'          => 'rnb_show_price_type',
            'name'        => 'rnb_show_price_type',
            'label'       => __('Show Product Pricing', 'redq-rental'),
            'description' => __('If you set the value as yes then date or range of dates will be blocked after placing an order depending on no. of inventories. If you set the value as no then date will not be blocked after placing the order', 'redq-rental'),
            'desc_tip'    => true,
            'options'     => array(
                'daily'  => __('Daily Pricing', 'redq-rental'),
                'hourly' => __('Hourly Pricing', 'redq-rental'),
            ),
            'value'       => get_post_meta($post_id, 'rnb_show_price_type', true)
        )
    );


    $redq_allowed_times = get_post_meta($post_id, 'redq_allowed_times', true);
    woocommerce_wp_textarea_input(
        array(
            'id'          => 'redq_allowed_times',
            'name'        => 'redq_allowed_times',
            'label'       => __('Allowed Times', 'redq-rental'),
            'placeholder' => __('Enter allowed time in comma separated format like 10:00, 12:00 (For 24 hour time format) or 10:00 am, 11:00 am (For 12 hour time format. Use space before am or pm) ', 'redq-rental'),
            'description' => __('Enter allowed time in comma separated format like 10:00, 12:00 (For 24 hour time format) or 10:00 am, 11:00 am (For 12 hour time format. Use space before am or pm) ', 'redq-rental'),
            'type'        => 'textarea',
            'desc_tip'    => true,
            'value'       => $redq_allowed_times,
        )
    );

    $booking_layout = get_post_meta($post_id, 'rnb_booking_layout', true);
    woocommerce_wp_select(
        array(
            'id'          => 'rnb_booking_layout',
            'label'       => __('Choose Booking Layout', 'redq-rental'),
            'description' => __('Choose your booking page layout. Either it will be normal view or modal view', 'redq-rental'),
            'options'     => array(
                'layout_one' => __('Normal Layout', 'redq-rental'),
                'layout_two' => __('Modal Layout', 'redq-rental'),
            ),
            'desc_tip'    => true,
            'value'       => $booking_layout
        )
    );

    $days = array(
        0 => esc_html__('Sunday', 'redq-rental'),
        1 => esc_html__('Monday', 'redq-rental'),
        2 => esc_html__('Tuesday', 'redq-rental'),
        3 => esc_html__('Wednesday', 'redq-rental'),
        4 => esc_html__('Thursday', 'redq-rental'),
        5 => esc_html__('Friday', 'redq-rental'),
        6 => esc_html__('Saturday', 'redq-rental'),
    );

    $rental_off_days = get_post_meta($post_id, 'redq_rental_off_days', true);

    if (isset($rental_off_days) && empty($rental_off_days)) {
        $rental_off_days = array();
    }

    ?>

    <p class="form-field">
        <label for="weekend"><?php esc_attr_e('Select Weekends', 'redq-rental'); ?></label>
        <select multiple="multiple" class="inventory-resources" style="width:350px" name="redq_rental_off_days[]" data-placeholder="<?php esc_attr_e('Choose off days', 'woocommerce'); ?>" title="<?php esc_attr_e('Weekends', 'woocommerce') ?>" class="wc-enhanced-select">
            <?php if (is_array($days) && !empty($days)) : ?>
                <?php foreach ($days as $key => $value) { ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php if (in_array($key, $rental_off_days)) { ?> selected <?php
                                                                                                                        } ?>>
                        <?php echo esc_attr($value); ?>
                    </option>
                <?php
                } ?>
            <?php endif; ?>
        </select>
    </p>

    <?php do_action('rnb_after_local_conditions_settings', $post_id); ?>
</div>