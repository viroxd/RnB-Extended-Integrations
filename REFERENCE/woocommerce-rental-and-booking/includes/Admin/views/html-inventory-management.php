<div id="price_calculation_product_data" class="panel woocommerce_options_panel">
    <?php
    woocommerce_wp_text_input(
        array(
            'id'                => 'quantity',
            'label'             => __('Set Quantity', 'redq-rental'),
            'placeholder'       => __('Add inventory quantity', 'redq-rental'),
            'type'              => 'number',
            'custom_attributes' => array(
                'required' => 'required',
                'step'     => '1',
                'min'      => '1'
            ),
            'desc_tip'          => 'true',
            'description'       => sprintf(__('Minimum 1 is required for each invenotry to work with.', 'redq-rental'))
        )
    ); ?>

    <div class="location-price show_if_general_pricing">
        <?php
        woocommerce_wp_select(
            array(
                'id'          => 'distance_unit_type',
                'label'       => __('Distance Unit', 'redq-rental'),
                'placeholder' => __('Set Location Distance Unit', 'redq-rental'),
                'description' => sprintf(__('If you select booking layout two then for location unit it will be applied', 'redq-rental')),
                'desc_tip'    => 'true',
                'options'     => array(
                    'kilometer' => __('Kilometer', 'redq-rental'),
                    'mile'      => __('Mile', 'redq-rental'),
                )
            )
        ); ?>
        <?php
        woocommerce_wp_text_input(
            array(
                'id'                => 'perkilo_price',
                'label'             => sprintf(__('Distance Unit Price ( %s )', 'redq-rental'), $currency),
                'placeholder'       => __('Per Distance Unit Price', 'redq-rental'),
                'type'              => 'number',
                'custom_attributes' => array(
                    'step' => '0.01',
                    'min'  => '0'
                ),
                'desc_tip'          => 'true',
                'description'       => sprintf(__('If you select booking layout two then for location price it will be applied', 'redq-rental'))
            )
        ); ?>
    </div>

    <!-- Daily pricing plans -->
    <h4 class="redq-headings"><?php esc_html_e('Configure Day Pricing Plans', 'redq-rental'); ?></h4>

    <?php

    $price_type_options = [
        'general_pricing' => __('General Pricing', 'redq-rental'),
        'daily_pricing'   => __('Daily Pricing', 'redq-rental'),
        'monthly_pricing' => __('Monthly Pricing', 'redq-rental'),
        'days_range'      => __('Days Range Pricing', 'redq-rental'),
        'flat_hours'      => __('Flat Hour Pricing', 'redq-rental'),
    ];

    woocommerce_wp_select([
        'id'          => 'pricing_type',
        'label'       => __('Set Price Type', 'redq-rental'),
        'description' => sprintf(__('Choose a price type - this controls the <a href = "%s">Details</a>.', 'redq-rental'), 'https: //rnb-doc.vercel.app/price-calculation'),
        'options'     => apply_filters('rnb_pricing_types', $price_type_options)
    ]);

    ?>

    <?php do_action('rnb_before_pricing_type_panel', $post_id); ?>

    <div class="general-pricing-panel show_if_general_pricing">
        <h4 class="redq-headings"><?php _e('Set general pricing plan', 'redq-rental'); ?></h4>
        <?php
        woocommerce_wp_text_input(array(
            'id'                => 'general_price',
            'label'             => sprintf(__('General Price ( %s )', 'redq-rental'), $currency),
            'placeholder'       => __('Enter price here', 'redq-rental'),
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '0.01',
                'min'  => '0'
            ),
        )); ?>
    </div>

    <div class="daily-pricing-panel">
        <h4 class="redq-headings"><?php _e('Set daily pricing Plan', 'redq-rental'); ?></h4>
        <?php
        $weeks = ['friday', 'saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday'];


        $daily_pricing = get_post_meta($post_id, 'redq_daily_pricing', true);
        $daily_pricing = $daily_pricing ? $daily_pricing : array();

        foreach ($weeks as $key => $day) {
            woocommerce_wp_text_input(array(
                'id'                => $day . '_price',
                'label'             => __(ucfirst($day) . ' ( ' . $currency . ' )', 'redq-rental'),
                'placeholder'       => __('Enter price here', 'redq-rental'),
                'type'              => 'number',
                'custom_attributes' => array(
                    'step' => '0.01',
                    'min'  => '0'
                ),
                'value'             => isset($daily_pricing[$weeks[$key]]) ? $daily_pricing[$weeks[$key]] : 0,
            ));
        } ?>
    </div>

    <div class="monthly-pricing-panel">
        <h4 class="redq-headings"><?php _e('Set monthly pricing plan', 'redq-rental') ?></h4>
        <?php
        $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

        $monthly_pricing = get_post_meta($post_id, 'redq_monthly_pricing', true);
        $monthly_pricing = $monthly_pricing ? $monthly_pricing : array();

        foreach ($months as $key => $month) {
            woocommerce_wp_text_input(array(
                'id'                => $month . '_price',
                'label'             => __(ucfirst($month) . ' ( ' . $currency . ' )', 'redq-rental'),
                'placeholder'       => __('Enter price here', 'redq-rental'),
                'type'              => 'number',
                'custom_attributes' => array(
                    'step' => '0.01',
                    'min'  => '0'
                ),
                'value'             => isset($monthly_pricing[$months[$key]]) ? $monthly_pricing[$months[$key]] : 0,
            ));
        } ?>
    </div>


    <div class="redq-days-range-panel">
        <h4 class="redq-headings"><?php _e('Set day ranges pricing plans', 'redq-rental') ?></h4>
        <div class="table_grid sortable" id="sortable">
            <table class="widefat">
                <tfoot>
                    <tr>
                        <th>
                            <a href="#" class="button button-primary add_redq_row" data-row="
                            <?php
                            ob_start();
                            include('html-days-range-meta.php');
                            $html = ob_get_clean();
                            echo esc_attr($html); ?>">
                                <?php _e('Add Days Range', 'redq-rental'); ?>
                            </a>
                        </th>
                    </tr>
                </tfoot>
                <tbody id="resource_availability_rows">
                    <?php
                    $days_range = get_post_meta($post_id, 'redq_day_ranges_cost', true);
                    if (!empty($days_range) && is_array($days_range)) {
                        foreach ($days_range as $day_range) {
                            include('html-days-range-meta.php');
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php do_action('rnb_after_pricing_type_panel', $post_id); ?>

    <!-- Starting hourly pricing plan -->
    <h4 class="redq-headings"><?php esc_html_e('Configure Hourly Pricing Plans', 'redq-rental'); ?></h4>
    <?php
    woocommerce_wp_select(
        array(
            'id'          => 'hourly_pricing_type',
            'label'       => __('Set Hourly Price Type', 'redq-rental'),
            'description' => sprintf(__('Choose a price type - this controls the <a href = "%s">Details</a>.', 'redq-rental'), 'https: //rnb-doc.vercel.app/price-calculation'),
            'options'     => array(
                'hourly_general' => __('General Hourly Pricing', 'redq-rental'),
                'hourly_range'   => __('Hourly Range Pricing', 'redq-rental'),
            )
        )
    ); ?>

    <div class="redq-hourly-general-panel show_if_general_pricing">
        <?php
        woocommerce_wp_text_input(array(
            'id'                => 'hourly_price',
            'label'             => sprintf(__('Hourly Price ( %s )', 'redq-rental'), $currency),
            'placeholder'       => __('Enter price here', 'redq-rental'),
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => '0.01',
                'min'  => '0'
            ),
            'desc_tip'          => 'true',
            'description'       => sprintf(__(
                'Hourly price will be applicable if booking or rental days min 1day',
                'redq-rental'
            ))
        )); ?>
    </div>

    <div class="redq-hourly-range-panel">
        <h4 class="redq-headings"><?php _e('Set hourly ranges pricing plans', 'redq-rental') ?></h4>
        <div class="table_grid sortable" id="sortable">
            <table class="widefat">
                <tfoot>
                    <tr>
                        <th>
                            <a href="#" class="button button-primary add_redq_row" data-row="<?php
                                                                                                ob_start();
                                                                                                include('html-hourly-range-meta.php');
                                                                                                $html = ob_get_clean();
                                                                                                echo esc_attr($html); ?>"><?php _e('Add Hourly Range', 'redq-rental'); ?></a>
                        </th>
                    </tr>
                </tfoot>
                <tbody id="resource_availability_rows">
                    <?php
                    $hourly_ranges = get_post_meta($post_id, 'redq_hourly_ranges_cost', true);
                    if (!empty($hourly_ranges) && is_array($hourly_ranges)) {
                        foreach ($hourly_ranges as $hourly_range) {
                            include('html-hourly-range-meta.php');
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <input type="hidden" name="inventory_meta_saving" value="true" />

</div>