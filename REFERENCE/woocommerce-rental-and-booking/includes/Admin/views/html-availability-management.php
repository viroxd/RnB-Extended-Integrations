<?php global $wpdb; ?>
<div id="availability_product_data" class="panel rental_date_availability woocommerce_options_panel">
    <h4 class="redq-headings"><?php _e('Product Date Availabilities', 'redq-rental') ?></h4>

    <div class="options_group own_availibility">
        <div class="table_grid">
            <table class="widefat">
                <thead style="2px solid #eee;">
                    <tr>
                        <th class="sort" width="1%">&nbsp;</th>
                        <th><?php _e('Block type', 'redq-rental'); ?></th>
                        <th><?php _e('Pickup Datetime', 'redq-rental'); ?></th>
                        <th><?php _e('Dropoff Datetime', 'redq-rental'); ?></th>
                        <!-- <th><?php _e('Row ID', 'redq-rental'); ?></th> -->
                        <th class="remove" width="1%">&nbsp;</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="6">
                            <a href="#" class="button button-primary add_redq_row" data-row="<?php
                                                                                                ob_start();
                                                                                                include('html-own-availability.php');
                                                                                                $html = ob_get_clean();
                                                                                                echo esc_attr($html); ?>">
                                <?php _e('Block Dates', 'redq-rental'); ?>
                            </a>
                            <span class="description"><?php _e('Please select the datetime range to be disabled for the product inventory on specific date range.', 'redq-rental'); ?> </span>
                            <strong><?php _e('FYI: After selecting date from datepicker, please click the time picker also. If you don\'t click time then disable date time will not work properly.', 'redq-rental'); ?></strong>
                        </th>
                    </tr>
                </tfoot>
                <tbody id="availability_rows">
                    <?php

                    $get_availabilities = $wpdb->get_results(
                        $wpdb->prepare(
                            "SELECT * FROM {$wpdb->prefix}rnb_availability WHERE inventory_id = %d AND block_by = %s",
                            $post_id,
                            'CUSTOM'
                        ),
                        ARRAY_A
                    );

                    if (!empty($get_availabilities) && is_array($get_availabilities)) {
                        foreach ($get_availabilities as $availability) {
                            include('html-own-availability.php');
                        }
                    } ?>
                    <input type="hidden" class="redq_availability_remove_id" name="redq_availability_remove_id" value="[]">
                </tbody>
            </table>
        </div>
    </div>
</div>