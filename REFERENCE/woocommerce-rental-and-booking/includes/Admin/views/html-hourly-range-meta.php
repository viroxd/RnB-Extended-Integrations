<?php
$post_id = get_the_ID();
$min_hours = isset($hourly_range['min_hours']) && !empty($hourly_range['min_hours']) ? $hourly_range['min_hours'] : '';
$max_hours = isset($hourly_range['max_hours']) && !empty($hourly_range['max_hours']) ? $hourly_range['max_hours'] : '';
$range_cost = isset($hourly_range['range_cost']) && !empty($hourly_range['range_cost']) ? $hourly_range['range_cost'] : '';
$cost_applicable = isset($hourly_range['cost_applicable']) && !empty($hourly_range['cost_applicable']) ? $hourly_range['cost_applicable'] : '';
?>
<div class="hourly_range_group redq-remove-rows sort ui-state-default" style="background: none; border: none;">
    <div class="redq-show-bar">
        <h4 class="redq-headings"> <?php _e('Hours', 'redq-rental'); ?> ( <?php echo esc_attr($min_hours); ?>
            - <?php echo esc_attr($max_hours); ?> ) <?php _e('-  Cost', 'redq-rental'); ?>
            : <?php echo esc_attr($range_cost); ?><?php echo esc_attr(get_woocommerce_currency_symbol()); ?>
            <button style="float: right" type="button" class="remove_row button"><i class="fa fa-trash-o"></i><?php _e('Remove', 'redq-rental'); ?></button>
            <a type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text">Toggle panel: Product Image</span>
                <span class="handlediv toggle-indicator show-or-hide" title="Click to toggle"></span>
            </a>
        </h4>
    </div>
    <div class="redq-hide-row" style="margin: 15px;">
        <?php
        $pricing_type = get_post_meta($post_id, 'pricing_type', true);
        $custom_attr_min = $pricing_type === 'flat_hours' ? array('step' => 1, 'min' => 1,) : array('step' => 1, 'min' => 1, 'max' => 24);
        $custom_attr_max = $pricing_type === 'flat_hours' ? array('step' => 1, 'min' => 1,) : array('step' => 1, 'min' => 1);
        $custom_attr_min['required'] = 'required';
        $custom_attr_max['required'] = 'required';

        woocommerce_wp_text_input(
            array(
                'id'                => 'min_hours',
                'name'              => 'redq_min_hours[]',
                'label'             => __('Min Hours', 'redq-rental'),
                'placeholder'       => __('Hours', 'redq-rental'),
                'type'              => 'number',
                'custom_attributes' => $custom_attr_min,
                'value'             => $min_hours,
            )
        );
        woocommerce_wp_text_input(
            array(
                'id'                => 'max_hours',
                'name'              => 'redq_max_hours[]',
                'label'             => __('Max Hours', 'redq-rental'),
                'placeholder'       => __('Hours', 'redq-rental'),
                'type'              => 'number',
                'custom_attributes' => $custom_attr_max,
                'value'             => $max_hours,
            )
        );
        woocommerce_wp_text_input(
            array(
                'id'                => 'hourly_range_cost',
                'name'              => 'redq_hourly_range_cost[]',
                'label'             => __('Hourly Range Cost ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'),
                'placeholder'       => __('Cost', 'redq-rental'),
                'type'              => 'number',
                'custom_attributes' => array(
                    'required' => 'required',
                    'step'     => '0.01',
                    'min'      => '0'
                ),
                'value'             => $range_cost,
            )
        );
        woocommerce_wp_select(
            array(
                'id'          => 'hourly_range_cost_applicable',
                'name'        => 'redq_hourly_range_cost_applicable[]',
                'label'       => __('Applicable', 'redq-rental'),
                'description' => sprintf(__('This will be applicable during booking cost calculation', 'redq-rental'), 'redq-rental'),
                'options'     => array(
                    ''         => __('Select Type', 'redq-rental'),
                    'per_hour' => __('Per Hour', 'redq-rental'),
                    'fixed'    => __('Fixed', 'redq-rental'),
                ),
                'value'       => $cost_applicable,
            )
        );
        ?>
    </div>
</div>