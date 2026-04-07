<div id="price_calculation_product_data" class="panel woocommerce_options_panel">

    <?php
    woocommerce_wp_select(array('id' => 'pricing_type', 'label' => __('Set Price Type', 'redq-rental'), 'description' => sprintf(__('Choose a price type - this controls the <a href="%s">schema</a>.', 'redq-rental'), 'http://schema.org/'), 'options' => array(
        'general_pricing' => __('General Pricing', 'redq-rental'),
        'daily_pricing'   => __('Daily Pricing', 'redq-rental'),
        'monthly_pricing' => __('Monthly Pricing', 'redq-rental'),
        'days_range'      => __('Days Range Pricing', 'redq-rental'),
    )));
    ?>

    <div class="location-price show_if_general_pricing">
        <?php
        woocommerce_wp_select(
            array(
                'id'          => 'distance_unit_type',
                'label'       => __('Distance Unit', 'redq-rental'),
                'placeholder' => __('Set Location Distance Unit', 'redq-rental'),
                'description' => sprintf(__('If you select booking layout two then for location unit it will be applied', 'redq-rental')),
                'options'     => array(
                    'kilometer' => __('Kilometer', 'redq-rental'),
                    'mile'      => __('Mile', 'redq-rental'),
                )
            )
        );
        ?>
        <?php
        woocommerce_wp_text_input(
            array(
                'id'          => 'perkilo_price',
                'label'       => __('Distance Unit Price ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'),
                'placeholder' => __('Per Distance Unit Price', 'redq-rental'),
                'type'        => 'text',
                'desc_tip'    => 'true',
                'description' => sprintf(__('If you select booking layout two then for location price it will be applied', 'redq-rental'))
            )
        );
        ?>
    </div>

    <div class="hourly-pricing-panel show_if_general_pricing">
        <?php
        woocommerce_wp_text_input(array('id' => 'hourly_price', 'label' => __('Hourly Price ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'desc_tip' => 'true', 'description' => sprintf(__('Hourly price will be applicabe if booking or rental days min 1day', 'redq-rental'))));
        ?>
    </div>

    <div class="general-pricing-panel show_if_general_pricing">
        <h4 class="redq-headings"><?php _e('Set general pricing plan', 'redq-rental'); ?></h4>
        <?php
        woocommerce_wp_text_input(array('id' => 'general_price', 'label' => __('General Price ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text'));
        ?>
    </div>

    <div class="daily-pricing-panel">
        <h4 class="redq-headings"><?php _e('Set daily pricing Plan', 'redq-rental'); ?></h4>

        <?php
        $daily_pricing = get_post_meta($post_id, 'redq_daily_pricing', true);
        $daily_pricing = $daily_pricing ? $daily_pricing : array();

        if (isset($daily_pricing) && empty($daily_pricing)) {
            $daily_pricing['friday'] = '';
            $daily_pricing['saturday'] = '';
            $daily_pricing['sunday'] = '';
            $daily_pricing['monday'] = '';
            $daily_pricing['tuesday'] = '';
            $daily_pricing['wednesday'] = '';
            $daily_pricing['thursday'] = '';
        }

        woocommerce_wp_text_input(array('id' => 'friday_price', 'label' => __('Friday ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $daily_pricing['friday'],));
        woocommerce_wp_text_input(array('id' => 'saturday_price', 'label' => __('Saturday ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $daily_pricing['saturday'],));
        woocommerce_wp_text_input(array('id' => 'sunday_price', 'label' => __('Sunday ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $daily_pricing['sunday'],));
        woocommerce_wp_text_input(array('id' => 'monday_price', 'label' => __('Monday ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $daily_pricing['monday'],));
        woocommerce_wp_text_input(array('id' => 'tuesday_price', 'label' => __('Tuesday ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $daily_pricing['tuesday'],));
        woocommerce_wp_text_input(array('id' => 'wednesday_price', 'label' => __('Wednesday ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $daily_pricing['wednesday'],));
        woocommerce_wp_text_input(array('id' => 'thursday_price', 'label' => __('Thursday ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $daily_pricing['thursday'],));
        ?>
    </div>

    <div class="monthly-pricing-panel">
        <h4 class="redq-headings"><?php _e('Set monthly pricing plan', 'redq-rental') ?></h4>
        <?php
        $monthly_pricing = get_post_meta($post_id, 'redq_monthly_pricing', true);
        $monthly_pricing = $monthly_pricing ? $monthly_pricing : array();
        if (isset($monthly_pricing) && empty($monthly_pricing)) {
            $monthly_pricing['january'] = '';
            $monthly_pricing['february'] = '';
            $monthly_pricing['march'] = '';
            $monthly_pricing['april'] = '';
            $monthly_pricing['may'] = '';
            $monthly_pricing['june'] = '';
            $monthly_pricing['july'] = '';
            $monthly_pricing['august'] = '';
            $monthly_pricing['september'] = '';
            $monthly_pricing['october'] = '';
            $monthly_pricing['november'] = '';
            $monthly_pricing['december'] = '';
        }

        woocommerce_wp_text_input(array('id' => 'january_price', 'label' => __('January ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['january']));

        woocommerce_wp_text_input(array('id' => 'february_price', 'label' => __('February ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['february']));

        woocommerce_wp_text_input(array('id' => 'march_price', 'label' => __('March ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['march']));

        woocommerce_wp_text_input(array('id' => 'april_price', 'label' => __('April ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['april']));

        woocommerce_wp_text_input(array('id' => 'may_price', 'label' => __('May ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['may']));

        woocommerce_wp_text_input(array('id' => 'june_price', 'label' => __('June ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['june']));

        woocommerce_wp_text_input(array('id' => 'july_price', 'label' => __('July ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['july']));

        woocommerce_wp_text_input(array('id' => 'august_price', 'label' => __('August ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['august']));

        woocommerce_wp_text_input(array('id' => 'september_price', 'label' => __('September ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['september']));

        woocommerce_wp_text_input(array('id' => 'october_price', 'label' => __('October ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['october']));

        woocommerce_wp_text_input(array('id' => 'november_price', 'label' => __('November ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['november']));

        woocommerce_wp_text_input(array('id' => 'december_price', 'label' => __('December ( ' . get_woocommerce_currency_symbol() . ' )', 'redq-rental'), 'placeholder' => __('Enter price here', 'redq-rental'), 'type' => 'text', 'value' => $monthly_pricing['december']));
        ?>
    </div>


    <div class="redq-days-range-panel">
        <h4 class="redq-headings"><?php _e('Set day ranges pricing plans', 'redq-rental') ?></h4>
        <div class="table_grid sortable" id="sortable">
            <table class="widefat">
                <tfoot>
                    <tr>
                        <th>
                            <a href="#" class="button button-primary add_redq_row" data-row="<?php
                                                                                                ob_start();
                                                                                                include('html-days-range-meta.php');
                                                                                                $html = ob_get_clean();
                                                                                                echo esc_attr($html);
                                                                                                ?>"><?php _e('Add Days Range', 'redq-rental'); ?></a>
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
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Rental Inventory Tab -->
<div id="rental_inventory_product_data" class="panel woocommerce_options_panel">

    <?php

    /**
     * Delete unwanted post or posts for inventory
     *
     * @since 2.0.0
     * @var object
     */
    $resource_identifiers = get_post_meta($post_id, 'resource_identifier', true);
    $selected_terms = array();

    $args = array(
        'post_type'      => 'Inventory',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'ASC',
        'post_status'    => 'publish'
    );

    $inventories = get_posts($args);

    $formatted_inventories = [];
    foreach ($inventories as $key => $inventory) {
        $formatted_inventories[$inventory->ID] = $inventory->post_title;
    }

    wp_reset_postdata();

    ?>

    <div class="redq-rental-inventory-panel">
        <div class="table_grid" id="sortable">

            <?php

            $selected_inventories = rnb_get_product_inventory_id($post_id);

            if (is_rental_product($post_id) && !empty($selected_inventories)) {
                $result = rnb_get_product_price($post_id);
                $price = $result['price'];

                woocommerce_wp_text_input(
                    array(
                        'label'     => '',
                        'type'      => 'hidden',
                        'data_type' => 'decimal',
                        'id'        => '_regular_price',
                        'class'     => 'redq_product_price',
                        'value'     => $price
                    )
                );
            }

            rnb_multi_select_field(
                array(
                    'id'          => '_redq_product_inventory',
                    'name'        => '_redq_product_inventory[]',
                    'label'       => __('Choose Inventories', 'redq-rental'),
                    'options'     => $formatted_inventories,
                    'value'       => !empty($selected_inventories) && is_array($selected_inventories) ? $selected_inventories : []
                )
            );
            ?>

        </div>


        <div class="inventory-list">
            <h4> <?php echo esc_html__('Inventory Details', 'redq-rental'); ?> </h4>
            <ul class="list">
                <?php foreach ($selected_inventories as $inventory) : ?>
                    <li>
                        <a href="<?php echo esc_url(get_edit_post_link($inventory)); ?>"><?php echo get_the_title($inventory); ?> </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>

</div>


<!-- price discount Tab -->
<div id="price_discount_product_data" class="panel woocommerce_options_panel">
    <div class="redq-price-discount-panel">
        <h4 class="redq-headings"><?php _e('Set price discount depending on day length', 'redq-rental') ?></h4>
        <div class="table_grid sortable" id="sortable">
            <table class="widefat">
                <tfoot>
                    <tr>
                        <th>
                            <a href="#" class="button button-primary add_redq_row" data-row="<?php
                                                                                                ob_start();
                                                                                                include('html-price-discount-meta.php');
                                                                                                $html = ob_get_clean();
                                                                                                echo esc_attr($html);
                                                                                                ?>"><?php _e('Add Price Discount', 'redq-rental'); ?></a>
                        </th>
                    </tr>
                </tfoot>
                <tbody id="resource_availability_rows">
                    <?php
                    $price_discounts = get_post_meta($post_id, 'redq_price_discount_cost', true);
                    if (!empty($price_discounts) && is_array($price_discounts)) {
                        foreach ($price_discounts as $price_discount) {
                            include('html-price-discount-meta.php');
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<!-- settgins field  -->
<div id="product_settings_data" class="panel woocommerce_options_panel">
    <h4 class="redq-headings"><?php _e('Settings of this product', 'redq-rental'); ?></h4>
    <?php include('html-product-settings-data.php'); ?>
</div>