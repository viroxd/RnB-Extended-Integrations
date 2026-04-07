<?php

if (isset($unique_model) && !empty($unique_model)) {
    $unique_model_name = $unique_model;
} else {
    $unique_model_name = '';
}

if (isset($unique_quantity) && !empty($unique_quantity)) {
    $unique_model_quantity = $unique_model_quantity;
} else {
    $unique_model_quantity = '';
}

// $unique_quantities = get_post_meta($post_id , 'redq_inventory_products_unique_quantities' , true);

// if ( ! empty( $unique_quantities ) && is_array( $unique_quantities ) ) {
// 	foreach ( $unique_quantities as $key => $unique_quantity ) {
// 		include( 'html-rental-inventory-repeatable-data.php' );
// 	}
// }

?>


<div class="rental_inventory redq-remove-rows sort ui-state-default postbox" style="background: none; border: none;">

    <div class="inventory-bar redq-show-bar">
        <h4 class="redq-headings"><?php echo esc_attr($unique_model_name); ?>
            <button style="float: right" type="button" class="remove_row button"><i
                        class="fa fa-trash-o"></i><?php _e('Remove', 'redq-rental'); ?></button>
            <a type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text">Toggle panel: Product Image</span>
                <span class="handlediv toggle-indicator show-or-hide" title="Click to toggle"></span>
            </a>
        </h4>
    </div>

    <div class="rental-inventory redq-hide-row" style="margin: 15px;">
        <?php

        woocommerce_wp_text_input(
            array(
                'id'          => 'rental_products_unique_name',
                'name'        => 'redq_rental_products_unique_name[]',
                'label'       => __('Unique product model', 'redq-rental'),
                'desc_tip'    => 'true',
                'description' => sprintf(__('Hourly price will be applicabe if booking or rental days min 1day', 'redq-rental')),
                'placeholder' => __('Unique product model', 'redq-rental'),
                'type'        => 'text',
                'value'       => $unique_model_name
            )
        );

        woocommerce_wp_text_input(
            array(
                'id'          => 'rental_products_unique_quantity',
                'name'        => 'redq_rental_products_unique_quantity[]',
                'label'       => __('Unique product quantity', 'redq-rental'),
                'desc_tip'    => 'true',
                'description' => sprintf(__('Set the quantity of that unique model available for rent or book', 'redq-rental')),
                'placeholder' => __('Set product quantity', 'redq-rental'),
                'type'        => 'text',
                'value'       => $unique_model_quantity
            )
        );

        ?>


        <?php
        if (isset($key) && $key >= 0) {
            $rnb_cat_key = $key;
            $resource_tax_key = $key;
            $person_post_key = $key;
            $attribute_tax_key = $key;
            $feature_tax_key = $key;
            $sd_tax_key = $key;
            $pickup_tax_key = $key;
            $dropoff_tax_key = $key;
        }
        ?>

        <!-- Select Pickup location for inventory models start -->
        <p class="form-field">
            <?php if (isset($rnb_cat_key) && $rnb_cat_key >= 0): ?>
                <label for="inventory-cat"><?php esc_attr_e('Select Categories', 'redq-rental'); ?></label>
                <?php

                $rnb_cat = get_terms('rnb_categories', array(
                    'hide_empty' => false,
                ));
                $cat_identifiers = get_post_meta(get_the_ID(), 'resource_identifier', true);
                $selected_rnb_cat = rental_iventory_selected_attributes($cat_identifiers, 'rnb_categories', $unique_model_name);

                ?>
                <select multiple="multiple" class="inventory-resources" style="width:350px"
                        name="inventory_cat[<?php if (isset($rnb_cat_key)) {
                            echo $rnb_cat_key;
                        } ?>][]" data-placeholder="<?php esc_attr_e('Set Categories', 'redq-rental'); ?>"
                        title="<?php esc_attr_e('Categories', 'redq-rental') ?>" class="wc-enhanced-select">
                    <?php if (is_array($rnb_cat) && !empty($rnb_cat)): ?>
                        <?php foreach ($rnb_cat as $key => $value) { ?>
                            <option value="<?php echo esc_attr($value->slug); ?>" <?php if (in_array($value->slug, $selected_rnb_cat)) { ?> selected <?php } ?> ><?php echo esc_attr($value->name); ?></option>
                        <?php } ?>
                    <?php endif; ?>
                </select>
            <?php endif; ?>
        </p>


        <!-- Select Pickup location for inventory models start -->
        <p class="form-field">
            <?php if (isset($pickup_tax_key) && $pickup_tax_key >= 0): ?>
                <label for="inventory-person"><?php esc_attr_e('Select Pickup Locations', 'redq-rental'); ?></label>
                <?php

                $pickup_terms = get_terms('pickup_location', array(
                    'hide_empty' => false,
                ));

                $pickup_identifiers = get_post_meta(get_the_ID(), 'resource_identifier', true);
                $selected_pickup_terms = rental_iventory_selected_attributes($pickup_identifiers, 'pickup_location', $unique_model_name);

                ?>
                <select multiple="multiple" class="inventory-resources" style="width:350px"
                        name="inventory_pickup[<?php if (isset($pickup_tax_key)) {
                            echo $pickup_tax_key;
                        } ?>][]" data-placeholder="<?php esc_attr_e('Set pickup locations', 'rental'); ?>"
                        title="<?php esc_attr_e('Pickup Locations', 'rental') ?>" class="wc-enhanced-select">
                    <?php if (is_array($pickup_terms) && !empty($pickup_terms)): ?>
                        <?php foreach ($pickup_terms as $key => $value) { ?>
                            <option value="<?php echo esc_attr($value->slug); ?>" <?php if (in_array($value->slug, $selected_pickup_terms)) { ?> selected <?php } ?> ><?php echo esc_attr($value->name); ?></option>
                        <?php } ?>
                    <?php endif; ?>
                </select>
            <?php endif; ?>
        </p>


        <!-- Select Dropoff location for inventory models start -->
        <p class="form-field">
            <?php if (isset($dropoff_tax_key) && $dropoff_tax_key >= 0): ?>
                <label for="inventory-dropoff-location"><?php esc_attr_e('Select Drop-off Locations', 'redq-rental'); ?></label>
                <?php

                $dropoff_terms = get_terms('dropoff_location', array(
                    'hide_empty' => false,
                ));

                $dropoff_identifiers = get_post_meta(get_the_ID(), 'resource_identifier', true);
                $selected_dropoff_terms = rental_iventory_selected_attributes($dropoff_identifiers, 'dropoff_location', $unique_model_name);

                ?>
                <select multiple="multiple" class="inventory-resources" style="width:350px"
                        name="inventory_dropoff[<?php if (isset($dropoff_tax_key)) {
                            echo $dropoff_tax_key;
                        } ?>][]" data-placeholder="<?php esc_attr_e('Set drop-off locations', 'rental'); ?>"
                        title="<?php esc_attr_e('Dropoff Locations', 'rental') ?>" class="wc-enhanced-select">
                    <?php if (is_array($dropoff_terms) && !empty($dropoff_terms)): ?>
                        <?php foreach ($dropoff_terms as $key => $value) { ?>
                            <option value="<?php echo esc_attr($value->slug); ?>" <?php if (in_array($value->slug, $selected_dropoff_terms)) { ?> selected <?php } ?> ><?php echo esc_attr($value->name); ?></option>
                        <?php } ?>
                    <?php endif; ?>
                </select>
            <?php endif; ?>
        </p>


        <!-- Select resource for inventory models start -->
        <p class="form-field">

            <?php if (isset($resource_tax_key) && $resource_tax_key >= 0): ?>
                <label for="inventory-resources"><?php esc_attr_e('Select Resources', 'redq-rental'); ?></label>
                <?php

                $resoruce_terms = get_terms('resource', array(
                    'hide_empty' => false,
                ));

                $resource_identifiers = get_post_meta(get_the_ID(), 'resource_identifier', true);
                $selected_terms = rental_iventory_selected_attributes($resource_identifiers, 'resource', $unique_model_name);

                ?>
                <select multiple="multiple" class="inventory-resources" style="width:350px"
                        name="inventory_resources[<?php if (isset($resource_tax_key)) {
                            echo $resource_tax_key;
                        } ?>][]" data-placeholder="<?php esc_attr_e('Set payable  resources', 'rental'); ?>"
                        title="<?php esc_attr_e('Resources', 'rental') ?>" class="wc-enhanced-select">
                    <?php if (is_array($resoruce_terms) && !empty($resoruce_terms)): ?>
                        <?php foreach ($resoruce_terms as $akey => $value) { ?>
                            <option value="<?php echo esc_attr($value->slug); ?>" <?php if (in_array($value->slug, $selected_terms)) { ?> selected <?php } ?> ><?php echo esc_attr($value->name); ?></option>
                        <?php } ?>
                    <?php endif; ?>
                </select>
            <?php endif; ?>
        </p>


        <!-- Select person for inventory models start -->
        <p class="form-field">
            <?php if (isset($person_post_key) && $person_post_key >= 0): ?>
                <label for="inventory-person"><?php esc_attr_e('Select Person', 'redq-rental'); ?></label>
                <?php

                $person_terms = get_terms('person', array(
                    'hide_empty' => false,
                ));

                $person_identifiers = get_post_meta(get_the_ID(), 'resource_identifier', true);
                $selected_person_terms = rental_iventory_selected_attributes($person_identifiers, 'person', $unique_model_name);

                ?>
                <select multiple="multiple" class="inventory-resources" style="width:350px"
                        name="inventory_person[<?php if (isset($person_post_key)) {
                            echo $person_post_key;
                        } ?>][]" data-placeholder="<?php esc_attr_e('Set Person', 'rental'); ?>"
                        title="<?php esc_attr_e('Person', 'rental') ?>" class="wc-enhanced-select">
                    <?php if (is_array($person_terms) && !empty($person_terms)): ?>
                        <?php foreach ($person_terms as $key => $value) { ?>
                            <option value="<?php echo esc_attr($value->slug); ?>" <?php if (in_array($value->slug, $selected_person_terms)) { ?> selected <?php } ?> ><?php echo esc_attr($value->name); ?></option>
                        <?php } ?>
                    <?php endif; ?>
                </select>
            <?php endif; ?>
        </p>


        <!-- Select security deposite for inventory models start -->
        <p class="form-field">
            <?php if (isset($sd_tax_key) && $sd_tax_key >= 0): ?>
                <label for="inventory-security-deposite"><?php esc_attr_e('Select Security Deposite', 'redq-rental'); ?></label>
                <?php

                $sd_terms = get_terms('deposite', array(
                    'hide_empty' => false,
                ));

                $sd_identifiers = get_post_meta(get_the_ID(), 'resource_identifier', true);
                $selected_sd_terms = rental_iventory_selected_attributes($sd_identifiers, 'deposite', $unique_model_name);

                ?>
                <select multiple="multiple" class="inventory-resources" style="width:350px"
                        name="inventory_security_deposite[<?php if (isset($sd_tax_key)) {
                            echo $sd_tax_key;
                        } ?>][]" data-placeholder="<?php esc_attr_e('Set security deposites', 'rental'); ?>"
                        title="<?php esc_attr_e('Deposite', 'rental') ?>" class="wc-enhanced-select">
                    <?php if (is_array($sd_terms) && !empty($sd_terms)): ?>
                        <?php foreach ($sd_terms as $key => $value) { ?>
                            <option value="<?php echo esc_attr($value->slug); ?>" <?php if (in_array($value->slug, $selected_sd_terms)) { ?> selected <?php } ?> ><?php echo esc_attr($value->name); ?></option>
                        <?php } ?>
                    <?php endif; ?>
                </select>
            <?php endif; ?>
        </p>


        <!-- Select attribute for inventory models start -->
        <p class="form-field">
            <?php if (isset($attribute_tax_key) && $attribute_tax_key >= 0): ?>
                <label for="inventory-attribute"><?php esc_attr_e('Select Attributes', 'redq-rental'); ?></label>
                <?php

                $attributes_terms = get_terms('attributes', array(
                    'hide_empty' => false,
                ));

                $attribute_identifiers = get_post_meta(get_the_ID(), 'resource_identifier', true);
                $selected_attributes_terms = rental_iventory_selected_attributes($attribute_identifiers, 'attributes', $unique_model_name);

                ?>
                <select multiple="multiple" class="inventory-resources" style="width:350px"
                        name="inventory_attributes[<?php if (isset($attribute_tax_key)) {
                            echo $attribute_tax_key;
                        } ?>][]" data-placeholder="<?php esc_attr_e('Set attributes', 'rental'); ?>"
                        title="<?php esc_attr_e('Attributes', 'rental') ?>" class="wc-enhanced-select">
                    <?php if (is_array($attributes_terms) && !empty($attributes_terms)): ?>
                        <?php foreach ($attributes_terms as $key => $value) { ?>
                            <option value="<?php echo esc_attr($value->slug); ?>" <?php if (in_array($value->slug, $selected_attributes_terms)) { ?> selected <?php } ?> ><?php echo esc_attr($value->name); ?></option>
                        <?php } ?>
                    <?php endif; ?>
                </select>
            <?php endif; ?>
        </p>


        <!-- Select features for inventory models start -->
        <p class="form-field">
            <?php if (isset($feature_tax_key) && $feature_tax_key >= 0): ?>
                <label for="inventory-feature"><?php esc_attr_e('Select Features', 'redq-rental'); ?></label>
                <?php

                $features_terms = get_terms('features', array(
                    'hide_empty' => false,
                ));

                $feature_identifiers = get_post_meta(get_the_ID(), 'resource_identifier', true);
                $selected_features_terms = rental_iventory_selected_attributes($feature_identifiers, 'features', $unique_model_name);

                ?>
                <select multiple="multiple" class="inventory-resources" style="width:350px"
                        name="inventory_features[<?php if (isset($feature_tax_key)) {
                            echo $feature_tax_key;
                        } ?>][]" data-placeholder="<?php esc_attr_e('Set features', 'rental'); ?>"
                        title="<?php esc_attr_e('Features', 'rental') ?>" class="wc-enhanced-select">
                    <?php if (is_array($features_terms) && !empty($features_terms)): ?>
                        <?php foreach ($features_terms as $key => $value) { ?>
                            <option value="<?php echo esc_attr($value->slug); ?>" <?php if (in_array($value->slug, $selected_features_terms)) { ?> selected <?php } ?> ><?php echo esc_attr($value->name); ?></option>
                        <?php } ?>
                    <?php endif; ?>
                </select>
            <?php endif; ?>
        </p>


    </div>
</div>