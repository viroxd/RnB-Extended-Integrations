<div id="screen-meta" class="metabox-prefs">
    <div id="screen-options-wrap" class="" tabindex="-1" aria-label="Screen Options Tab">
        <form id="adv-settings" method="post" class="rnb-advance-settings">
            <input type="hidden" id="rnb_order_admin_list" name="rnb_order_admin_list" value="<?php echo esc_attr(wp_create_nonce('rnb_order_admin_list')); ?>">
            <fieldset class="metabox-prefs">
                <legend><?php echo esc_html__('Columns', 'redq-rental'); ?></legend>
                <?php
                $default_columns =  $this->get_columns();
                $should_display_column = get_option('rnb_screen_order_columns', array_keys($default_columns));

                unset($default_columns['cb']);
                foreach ($default_columns as $key => $column) {
                    $checked = (in_array($key, $should_display_column)) ? $key : '';  ?>
                    <label>
                        <input class="hide-column-tog" name="<?php echo esc_attr($key); ?>-hide" type="checkbox" id="<?php echo esc_attr($key); ?>-hide" value="<?php echo esc_attr($key); ?>" <?php checked($checked, $key); ?>><?php echo esc_html($column); ?>
                    </label>
                <?php } ?>
            </fieldset>
            <fieldset class="screen-options">
                <legend><?php echo esc_html__('Pagination', 'redq-rental'); ?></legend>
                <?php $get_post_per_page = get_option('rnb_admin_order_list_per_page', get_option('posts_per_page')); ?>
                <label for="edit_shop_order_per_page"><?php esc_html_e('Number of items per page:', 'redq-rental'); ?></label>
                <input type="number" step="1" min="1" max="999" class="screen-per-page" name="rnb_admin_order_list_per_page" id="edit_rnb_shop_order_per_page" maxlength="3" value="<?php echo esc_attr($get_post_per_page); ?>">
            </fieldset>
            <p class="submit">
                <input type="submit" name="screen-options-apply" id="screen-options-apply" class="button button-primary" value="Apply">
            </p>
        </form>
    </div>
</div>
<div id="screen-meta-links">
    <div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
        <button type="button" id="show-settings-link" class="button show-settings" aria-controls="screen-options-wrap" aria-expanded="false">Screen Options</button>
    </div>
</div>