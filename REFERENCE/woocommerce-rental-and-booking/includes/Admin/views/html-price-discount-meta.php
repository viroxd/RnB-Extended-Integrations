<?php
$min_days = isset($price_discount['min_days']) && !empty($price_discount['min_days']) ? $price_discount['min_days'] : '';
$max_days = isset($price_discount['max_days']) && !empty($price_discount['max_days']) ? $price_discount['max_days'] : '';
$discount_type = isset($price_discount['discount_type']) && !empty($price_discount['discount_type']) ? $price_discount['discount_type'] : '';
$discount_amount = isset($price_discount['discount_amount']) && !empty($price_discount['discount_amount']) ? $price_discount['discount_amount'] : '';
?>
<div class="price_discount_group redq-remove-rows sort ui-state-default" style="background: none; border: none;">
    <div class="redq-show-bar">
        <h4 class="redq-headings"> <?php _e('Days', 'redq-rental'); ?> ( <?php echo esc_attr($min_days); ?>
            - <?php echo esc_attr($max_days); ?> ) <?php _e('-  Discount', 'redq-rental'); ?>
            : <?php if ($discount_type != 'percentage') : ?><?php echo esc_attr($discount_amount); ?><?php echo esc_attr(get_woocommerce_currency_symbol()); ?><?php else : ?><?php echo esc_attr($discount_amount); ?>% <?php endif; ?>
            <button style="float: right" type="button" class="remove_row button"><i
                        class="fa fa-trash-o"></i><?php _e('Remove', 'redq-rental'); ?></button>
            <a type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text">Toggle panel: Product Image</span>
                <span class="handlediv toggle-indicator show-or-hide" title="Click to toggle"></span>
            </a>
        </h4>
    </div>
    <div class="redq-hide-row" style="margin: 15px;">
        <?php
        woocommerce_wp_text_input(
            array(
                'id'                => 'price_discount_min_days',
                'name'              => 'redq_price_discount_min_days[]',
                'label'             => __('Min Days', 'redq-rental'),
                'placeholder'       => __('Days', 'redq-rental'),
                'type'              => 'number',
                'custom_attributes' => array(
                    'required' => 'required',
                    'step'     => '1',
                    'min'      => '1'
                ),
                'value'             => $min_days,
            )
        );
        woocommerce_wp_text_input(
            array(
                'id'                => 'price_discount_max_days',
                'name'              => 'redq_price_discount_max_days[]',
                'label'             => __('Max Days', 'redq-rental'),
                'placeholder'       => __('days', 'redq-rental'),
                'type'              => 'number',
                'custom_attributes' => array(
                    'required' => 'required',
                    'step'     => '1',
                    'min'      => '1'
                ),
                'value'             => $max_days,
            )
        );
        woocommerce_wp_select(
            array(
                'id'          => 'price_discount_type',
                'name'        => 'redq_price_discount_type[]',
                'label'       => __('Discount Type', 'redq-rental'),
                'description' => sprintf(__('This will be applicable during booking cost calculation', 'redq-rental'), 'http://schema.org/'),
                'options'     => array(
                    ''           => __('Select type', 'redq-rental'),
                    'percentage' => __('Percentage', 'redq-rental'),
                    'fixed'      => __('Fixed Price', 'redq-rental'),
                ),
                'value'       => $discount_type,
            )
        );
        woocommerce_wp_text_input(
            array(
                'id'                => 'price_discount',
                'name'              => 'redq_price_discount[]',
                'label'             => __('Discount Amount ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'),
                'placeholder'       => __('Discount amount', 'redq-rental'),
                'type'              => 'number',
                'custom_attributes' => array(
                    'required' => 'required',
                    'step'     => '0.01',
                    'min'      => '0'
                ),
                'value'             => $discount_amount,
            )
        );
        ?>
    </div>
</div>