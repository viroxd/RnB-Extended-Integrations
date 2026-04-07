<?php
$admin_url = get_admin_url();
$post_id = get_the_id();
?>
<div id="rnb_setting_tabs">

    <ul>
        <li><a href="#showorhide"><?php esc_attr_e('Display', 'redq-rental'); ?></a></li>
        <li><a href="#physical_appearence"><?php esc_attr_e('Labels', 'redq-rental'); ?></a></li>
        <li><a href="#logical_appearence"><?php esc_attr_e('Conditions', 'redq-rental'); ?></a></li>
        <li><a href="#validation"><?php esc_attr_e('Validations', 'redq-rental'); ?></a></li>
    </ul>

    <div id="showorhide">
        <?php
        $display_url = esc_url($admin_url) . 'admin.php?page=wc-settings&tab=rnb_settings&section=display';
        $value = get_post_meta($post_id, 'rnb_settings_for_display', true);
        woocommerce_wp_select(
            array(
                'id'          => 'rnb_settings_for_display',
                'label'       => __('Choose Settings For Display Tab', 'redq-rental'),
                'description' => sprintf(__('Please configure the display settings from <strong> ' . '<a href="%1$s" target="_blank"> ' . __('Global Settings', 'redq-rental') . '</a>' . ' </strong>panel.', 'redq-rental'), $display_url),
                'options'     => array(
                    'global' => __('Global Settings', 'redq-rental'),
                    'local'  => __('Local Settings', 'redq-rental'),
                ),
                //'desc_tip' => true,
                'value'       => $value
            )
        );
        include_once 'html-display-local-settings.php';
        ?>
    </div>

    <div id="physical_appearence">
        <?php
        $labels_url = esc_url($admin_url) . 'admin.php?page=wc-settings&tab=rnb_settings&section=labels';
        $value = get_post_meta($post_id, 'rnb_settings_for_labels', true);
        woocommerce_wp_select(
            array(
                'id'          => 'rnb_settings_for_labels',
                'label'       => __('Choose Settings For Labels Tab', 'redq-rental'),
                'description' => sprintf(__('Please configure labels the settings from <strong> ' . '<a href="%1$s" target="_blank"> ' . __('Global Settings', 'redq-rental') . '</a>' . ' </strong>panel.', 'redq-rental'), $labels_url),
                'options'     => array(
                    'global' => __('Global Settings', 'redq-rental'),
                    'local'  => __('Local Settings', 'redq-rental'),
                ),
                'value'       => $value
            )
        );
        include_once 'html-labels-local-settings.php';
        ?>
    </div>

    <div id="logical_appearence">
        <?php
        do_action('rnb_before_logical_apearence');

        $conditions_url = esc_url($admin_url) . 'admin.php?page=wc-settings&tab=rnb_settings&section=conditions';
        $value = get_post_meta($post_id, 'rnb_settings_for_conditions', true);
        woocommerce_wp_select(
            array(
                'id'          => 'rnb_settings_for_conditions',
                'label'       => __('Choose Settings For Conditions Tab', 'redq-rental'),
                'description' => sprintf(__('Please configure the conditions settings from <strong> ' . '<a href="%1$s" target="_blank"> ' . __('Global Settings', 'redq-rental') . '</a>' . ' </strong>panel.', 'redq-rental'), $conditions_url),
                'options'     => array(
                    'global' => __('Global Settings', 'redq-rental'),
                    'local'  => __('Local Settings', 'redq-rental'),
                ),
                //'desc_tip' => true,
                'value'       => $value
            )
        );
        include_once 'html-condition-local-settings.php';
        do_action('rnb_after_logical_appearence');
        ?>
    </div>

    <div id="validation">
        <?php
        $validations_url = esc_url($admin_url) . 'admin.php?page=wc-settings&tab=rnb_settings&section=validations';
        $value = get_post_meta($post_id, 'rnb_settings_for_validations', true);
        woocommerce_wp_select(
            array(
                'id'          => 'rnb_settings_for_validations',
                'label'       => __('Choose Settings For Validations Tab', 'redq-rental'),
                'description' => sprintf(__('Please configure the validation settings from <strong> ' . '<a href="%1$s" target="_blank"> ' . __('Global Settings', 'redq-rental') . '</a>' . ' </strong>panel.', 'redq-rental'), $validations_url),
                'options'     => array(
                    'global' => __('Global Settings', 'redq-rental'),
                    'local'  => __('Local Settings', 'redq-rental'),
                ),
                //'desc_tip' => true,
                'value'       => $value
            )
        );
        include_once 'html-validation-local-settings.php';
        ?>
    </div>

</div>