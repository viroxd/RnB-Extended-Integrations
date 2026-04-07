<div class="rnb-setting-fields rnb-validation-fields">
    <?php
    $required_pickup_loc = get_post_meta($post_id, 'redq_rental_local_required_pickup_location', true);
    if (empty($required_pickup_loc)) {
        $required_pickup_loc = 'closed';
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_required_pickup_location',
            'label'   => __('Required Pickup Location [Not applicable for modal layout]', 'redq-rental'),
            'description'       => __('If there is no pickup location field on this product then this option will not work', 'redq-rental'),
            'desc_tip'          => true,
            'cbvalue' => 'open',
            'value'   => esc_attr($required_pickup_loc),
        )
    );

    $required_return_loc = get_post_meta($post_id, 'redq_rental_local_required_return_location', true);
    if (empty($required_return_loc)) {
        $required_return_loc = 'closed';
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_required_return_location',
            'label'   => __('Required Return Location [Not applicable for modal layout]', 'redq-rental'),
            'description'       => __('If there is no return location field on this product then this option will not work', 'redq-rental'),
            'desc_tip'          => true,
            'cbvalue' => 'open',
            'value'   => esc_attr($required_return_loc),
        )
    );

    $required_person = get_post_meta($post_id, 'redq_rental_local_required_person', true);
    if (empty($required_person)) {
        $required_person = 'closed';
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_local_required_person',
            'label'   => __('Required Adult', 'redq-rental'),
            'description'       => __('If there is no adult field on this product then this option will not work', 'redq-rental'),
            'desc_tip'          => true,
            'cbvalue' => 'open',
            'value'   => esc_attr($required_person),
        )
    );

    $required_pickup_time = get_post_meta($post_id, 'redq_rental_required_local_pickup_time', true);
    if (empty($required_pickup_time)) {
        $required_pickup_time = 'closed';
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_required_local_pickup_time',
            'label'   => __('Required Pickup Time', 'redq-rental'),
            'description'       => __('Please enable pickup time option from display settings. Otherwise this option will not work', 'redq-rental'),
            'desc_tip'          => true,
            'cbvalue' => 'open',
            'value'   => esc_attr($required_pickup_time),
        )
    );

    $required_return_time = get_post_meta($post_id, 'redq_rental_required_local_return_time', true);
    if (empty($required_return_time)) {
        $required_return_time = 'closed';
    }

    woocommerce_wp_checkbox(
        array(
            'id'      => 'redq_rental_required_local_return_time',
            'label'   => __('Required Return Time', 'redq-rental'),
            'description'       => __('Please enable return time option from display settings. Otherwise this option will not work', 'redq-rental'),
            'desc_tip'          => true,
            'cbvalue' => 'open',
            'value'   => esc_attr($required_return_time),
        )
    );
    ?>
    <div class="table_grid">
        <h4 class="redq-headings"><?php _e('Daily Basis Opening & Closing Time', 'redq-rental') ?></h4>
        <p><?php echo esc_html__('Enter time in the following format. 10:00 or 23:30 or 24:00 etc (For 24-hour time format) and 10:00 am or 1:30 pm or 2:00 pm etc (For 12-hour time format. Space before am or pm is important)', 'redq-rental'); ?> </p>
        <table class="widefat">

            <tbody id="availability_rows">
                <tr>
                    <td class="sort">&nbsp;</td>
                    <td>
                        <div class="day-name">
                            <?php esc_attr_e('Friday', 'redq-rental'); ?>
                        </div>
                    </td>
                    <td>
                        <div class="fri-min-time-outer">
                            <?php $fri_min_time = get_post_meta($post_id, 'redq_rental_fri_min_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="redq_rental_fri_min_time" value="<?php echo esc_attr($fri_min_time); ?>" />
                        </div>
                    </td>
                    <td>
                        <div class="max-time-outer">
                            <?php $fri_max_time = get_post_meta($post_id, 'redq_rental_fri_max_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="redq_rental_fri_max_time" value="<?php echo esc_attr($fri_max_time); ?>" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sort">&nbsp;</td>
                    <td>
                        <div class="day-name">
                            <?php esc_attr_e('Saturday', 'redq-rental'); ?>
                        </div>
                    </td>
                    <td>
                        <div class="fri-min-time-outer">
                            <?php $sat_min_time = get_post_meta($post_id, 'redq_rental_sat_min_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="redq_rental_sat_min_time" value="<?php echo esc_attr($sat_min_time); ?>" />
                        </div>
                    </td>
                    <td>
                        <div class="max-time-outer">
                            <?php $sat_max_time = get_post_meta($post_id, 'redq_rental_sat_max_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="redq_rental_sat_max_time" value="<?php echo esc_attr($sat_max_time); ?>" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sort">&nbsp;</td>
                    <td>
                        <div class="day-name">
                            <?php esc_attr_e('Sunday', 'redq-rental'); ?>
                        </div>
                    </td>
                    <td>
                        <div class="fri-min-time-outer">
                            <?php $sun_min_time = get_post_meta($post_id, 'redq_rental_sun_min_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="redq_rental_sun_min_time" value="<?php echo esc_attr($sun_min_time); ?>" />
                        </div>
                    </td>
                    <td>
                        <div class="max-time-outer">
                            <?php $sun_max_time = get_post_meta($post_id, 'redq_rental_sun_max_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="redq_rental_sun_max_time" value="<?php echo esc_attr($sun_max_time); ?>" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sort">&nbsp;</td>
                    <td>
                        <div class="day-name">
                            <?php esc_attr_e('Monday', 'redq-rental'); ?>
                        </div>
                    </td>
                    <td>
                        <div class="fri-min-time-outer">
                            <?php $mon_min_time = get_post_meta($post_id, 'redq_rental_mon_min_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="redq_rental_mon_min_time" value="<?php echo esc_attr($mon_min_time); ?>" />
                        </div>
                    </td>
                    <td>
                        <div class="max-time-outer">
                            <?php $mon_max_time = get_post_meta($post_id, 'redq_rental_mon_max_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="redq_rental_mon_max_time" value="<?php echo esc_attr($mon_max_time); ?>" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sort">&nbsp;</td>
                    <td>
                        <div class="day-name">
                            <?php esc_attr_e('Tuesday', 'redq-rental'); ?>
                        </div>
                    </td>
                    <td>
                        <div class="fri-min-time-outer">
                            <?php $thu_min_time = get_post_meta($post_id, 'redq_rental_thu_min_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="redq_rental_thu_min_time" value="<?php echo esc_attr($thu_min_time); ?>" />
                        </div>
                    </td>
                    <td>
                        <div class="max-time-outer">
                            <?php $thu_max_time = get_post_meta($post_id, 'redq_rental_thu_max_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="redq_rental_thu_max_time" value="<?php echo esc_attr($thu_max_time); ?>" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sort">&nbsp;</td>
                    <td>
                        <div class="day-name">
                            <?php esc_attr_e('Wednesday', 'redq-rental'); ?>
                        </div>
                    </td>
                    <td>
                        <div class="fri-min-time-outer">
                            <?php $wed_min_time = get_post_meta($post_id, 'redq_rental_wed_min_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="redq_rental_wed_min_time" value="<?php echo esc_attr($wed_min_time); ?>" />
                        </div>
                    </td>
                    <td>
                        <div class="max-time-outer">
                            <?php $wed_max_time = get_post_meta($post_id, 'redq_rental_wed_max_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="redq_rental_wed_max_time" value="<?php echo esc_attr($wed_max_time); ?>" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sort">&nbsp;</td>
                    <td>
                        <div class="day-name">
                            <?php esc_attr_e('Thursday', 'redq-rental'); ?>
                        </div>
                    </td>
                    <td>
                        <div class="fri-min-time-outer">
                            <?php $thur_min_time = get_post_meta($post_id, 'redq_rental_thur_min_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="redq_rental_thur_min_time" value="<?php echo esc_attr($thur_min_time); ?>" />
                        </div>
                    </td>
                    <td>
                        <div class="max-time-outer">
                            <?php $thur_max_time = get_post_meta($post_id, 'redq_rental_thur_max_time', true); ?>
                            <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="redq_rental_thur_max_time" value="<?php echo esc_attr($thur_max_time); ?>" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>