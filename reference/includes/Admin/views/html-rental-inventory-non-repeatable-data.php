<?php

$inventory_product_count = get_post_meta(get_the_ID(), 'redq_rental_inventory_count', true);

woocommerce_wp_text_input(
    array(
        'id'                => 'rental_inventory_count',
        'name'              => 'rental_inventory_count',
        'label'             => __('Inventory Qty', 'redq-rental'),
        'placeholder'       => __('Inventory Qty', 'redq-rental'),
        'type'              => 'number',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0'
        ),
        'value'             => $inventory_product_count,
    )
);