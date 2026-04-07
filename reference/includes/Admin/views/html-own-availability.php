<?php

global $wpdb;

if (!isset($availability))
    $availability = array();
// 	$availability['type'] = 'custom_date';
$post_id = get_the_ID();
$parent_id = wp_get_post_parent_id($post_id);
$conditions = redq_rental_get_settings($parent_id, 'conditions');
$conditional_data = $conditions['conditions'];
$output_date_format = $conditional_data['date_format'];
$euro_date_format = $conditional_data['euro_format'];

?>

<tr data-id="<?php echo (isset($availability['id'])) ? $availability['id'] : '' ?>">
    <td class="sort">&nbsp;</td>
    <td>
        <div class="select rental_availability_type">
            <select name="redq_availability_block_by[]">
                <option value="CUSTOM" <?php echo (isset($availability['block_by']) && $availability['block_by'] == 'CUSTOM') ? 'selected' : ''; ?>><?php _e('Custom Block', 'redq-rental'); ?></option>
                <!-- <option value="FRONTEND_ORDER" <?php echo (isset($availability['block_by']) && $availability['block_by'] == 'FRONTEND_ORDER') ? 'selected' : ''; ?>><?php _e('Frontend Order', 'redq-rental'); ?></option> -->
                <!-- <option value="BACKEND_ORDER" <?php echo (isset($availability['block_by']) && $availability['block_by'] == 'BACKEND_ORDER') ? 'selected' : ''; ?>><?php _e('Backend Order', 'redq-rental'); ?></option> -->
            </select>
        </div>
    </td>
    <td>
        <div class="from_date inventory-form-to-input">
            <input type="text" style="border: 1px solid #ddd;" class="rnb-date-picker"
                   name="redq_availability_pickup_datetime[]"
                   value="<?php if (!empty($availability['pickup_datetime'])) echo $availability['pickup_datetime']; ?>"
                   autocomplete="off"/>
        </div>
    </td>
    <td>
        <div class="to_date inventory-form-to-input">
            <input type="text" style="border: 1px solid #ddd;" class="rnb-date-picker"
                   name="redq_availability_dropoff_datetime[]"
                   value="<?php if (!empty($availability['return_datetime'])) echo $availability['return_datetime']; ?>"
                   autocomplete="off"/>
        </div>
    </td>
    <td class="inventory-remove">
        <div class="select">
            <input type="hidden" name="redq_availability_row_id[]"
                   value="<?php echo (isset($availability['id'])) ? $availability['id'] : '' ?>">
        </div>
        <button type="btn"><span class="dashicons dashicons-trash"></span></button>
    </td>
</tr>
