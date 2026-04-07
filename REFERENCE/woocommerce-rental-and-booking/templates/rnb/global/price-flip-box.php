<?php
global $product;
$product_id = '';
if($product){
    $product_id = $product->get_id();
}elseif(isset($args['product_id']) && $args['product_id'] != ''){
    $product_id = $args['product_id'];
}
$inventories = rnb_get_product_inventory_id($product_id);
$displays = redq_rental_get_settings($product_id, 'display');
$displays = $displays['display'];
$labels = redq_rental_get_settings($product_id, 'labels', array('price_info'));
$labels = $labels['labels'];
?>

<?php if (isset($displays['flip_box']) && $displays['flip_box'] !== 'closed') : ?>
    <div class="rnb-pricing-plan-button">
        <span class="rnb-pricing-plan">
            <button class="rnb-pricing-plan-link" type="button">
                <i class="fas fa-caret-down"></i> &nbsp;
                <?php echo esc_attr($labels['flipbox_info']); ?>
            </button>
        </span>
    </div>
<?php endif; ?>
<?php
foreach ($inventories as $inventory) :
    $pricing_type = get_post_meta($inventory, 'pricing_type', true);
    if (isset($displays['flip_box']) && $displays['flip_box'] !== 'closed') :
        global $product;

        $pricing = redq_rental_get_pricing_data($inventory);
        $pricing = apply_filters('rnb_show_product_pricing_info', $pricing);
        $price_info_top = get_option('rnb_flipbox_price_top_info', 'yes');
        $flip_box = $price_info_top && $price_info_top === 'yes' ? ['back', 'front'] : ['front', 'back'];
?>
        <div class="price-showing">
            <div class="<?php echo esc_attr($flip_box[1]); ?>">
                <div class="item-pricing">
                    <h5> <?php echo esc_html__('Day based pricing : ', 'redq-rental'); ?><?php echo get_the_title($inventory); ?></h5>
                    <?php if ($pricing['pricing_type'] === 'general_pricing') : ?>
                        <?php $general_price = $pricing['general_pricing']; ?>
                        <div class="rnb-pricing-wrap">
                            <div class="day-ranges-pricing-plan">
                                <span class="range-days"> <?php echo wc_price($general_price); ?><?php _e(' / days', 'redq-rental'); ?> </span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($pricing['pricing_type'] === 'days_range') : ?>
                        <?php $pricing_plans = $pricing['days_range']; ?>
                        <div class="rnb-pricing-wrap">
                            <?php if (is_array($pricing_plans) && !empty($pricing_plans)) { ?>
                                <?php foreach ($pricing_plans as $key => $value) { ?>
                                    <?php $rate = $value['cost_applicable'] === 'fixed' ? esc_html__('Fixed', 'redq-rental') : esc_html__('/ Day', 'redq-rental'); ?>
                                    <div class="day-ranges-pricing-plan">
                                        <span class="range-days"><?php echo esc_attr($value['min_days']); ?> - <?php echo esc_attr($value['max_days']); ?> <?php _e('days :', 'redq-rental'); ?> </span>
                                        <span class="range-price"><strong><?php echo wc_price($value['range_cost']); ?></strong> <?php echo esc_attr($rate); ?></span>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($pricing['pricing_type'] === 'daily_pricing') : ?>
                        <?php
                        $daily_pricing = $pricing['daily_pricing'];
                        $day_names = redq_rental_day_names();
                        ?>
                        <div class="rnb-pricing-wrap">
                            <?php if (is_array($daily_pricing) && !empty($daily_pricing)) { ?>
                                <?php foreach ($daily_pricing as $key => $value) { ?>
                                    <div class="day-ranges-pricing-plan">
                                        <span class="day"><?php echo esc_attr(ucfirst($day_names[$key])); ?> </span>
                                        <span class="day-price"><strong> - <?php echo wc_price($value); ?></strong></span>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($pricing['pricing_type'] === 'monthly_pricing') : ?>
                        <?php
                        $monthly_pricing = $pricing['monthly_pricing'];
                        $month_names = redq_rental_month_names();
                        ?>
                        <div class="rnb-pricing-wrap">
                            <?php if (is_array($monthly_pricing) && !empty($monthly_pricing)) { ?>
                                <?php foreach ($monthly_pricing as $key => $value) { ?>
                                    <div class="day-ranges-pricing-plan">
                                        <span class="month"><?php echo ucfirst($month_names[$key]); ?> </span>
                                        <span class="month-price"><strong> - <?php echo wc_price($value); ?></strong></span>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    if ($pricing['hourly_pricing_type'] === 'hourly_range') :
                        $pricing_plans = $pricing['hourly_range'];
                        if (is_array($pricing_plans) && !empty($pricing_plans)) : ?>
                            <h5><?php echo esc_html__('Hourly based pricing', 'redq-rental'); ?></h5>
                            <div class="rnb-pricing-wrap">
                                <?php foreach ($pricing_plans as $key => $value) : ?>
                                    <?php $rate = $value['cost_applicable'] === 'fixed' ? esc_html__('Fixed', 'redq-rental') : esc_html__('/ Hour', 'redq-rental'); ?>
                                    <div class="day-ranges-pricing-plan">
                                        <span class="range-days"><?php echo esc_attr($value['min_hours']); ?> - <?php echo esc_attr($value['max_hours']); ?> <?php _e('Hours :', 'redq-rental'); ?> </span>
                                        <span class="range-price"><strong><?php echo wc_price($value['range_cost']); ?></strong> <?php echo esc_attr($rate); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                    <?php
                        endif;
                    endif;
                    ?>

                    <?php if ($pricing['hourly_pricing_type'] === 'hourly_general') : ?>
                        <?php $general_hourly_price = $pricing['hourly_general']; ?>
                        <?php if (!empty($general_hourly_price)) : ?>
                            <h5><?php echo esc_html__('Hourly based pricing', 'redq-rental'); ?></h5>
                            <p class="hourly-general"><?php echo wc_price($general_hourly_price); ?>
                                / <?php echo esc_html__('per hour', 'redq-rental'); ?>
                            </p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <?php if (isset($displays['discount']) && $displays['discount'] !== 'closed') : ?>
                    <div class="rnb-discount-wrap">
                        <div class="discount-portion">
                            <?php $price_discounts = $pricing['price_discount']; ?>
                            <?php if (isset($price_discounts) && !empty($price_discounts) && is_array($price_discounts)) : ?>
                                <h5><?php echo esc_html__('Discount Rates', 'redq-rental'); ?></h5>
                                <?php foreach ($price_discounts as $key => $value) { ?>
                                    <?php
                                    if ($value['discount_type'] === 'percentage') {
                                        $rate = esc_html__('%', 'redq-rental');
                                        $amount = $value['discount_amount'];
                                    } else {
                                        $rate = esc_html__('Fixed', 'redq-rental');
                                        $amount = wc_price($value['discount_amount']);
                                    }
                                    ?>
                                    <div class="discount-plan">
                                        <span class="range-days"><?php echo esc_attr($value['min_days']); ?> - <?php echo esc_attr($value['max_days']); ?> <?php _e('days :', 'redq-rental'); ?> </span>
                                        <span class="range-price"><strong><?php echo $amount; ?></strong> <?php echo esc_attr($rate); ?></span>
                                    </div>
                                <?php } ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php do_action('pricing_info_after', $inventory); ?>
            </div>
        </div>
<?php endif;
endforeach;
