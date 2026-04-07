<?php

global $wpdb;

if (!isset($season))
    $season = array();

$post_id = get_the_ID();
$parent_id = wp_get_post_parent_id($post_id);
$conditions = redq_rental_get_settings($parent_id, 'conditions');
$conditional_data = $conditions['conditions'];
$output_date_format = $conditional_data['date_format'];
$euro_date_format = $conditional_data['euro_format'];

?>

<tr data-id="<?php echo (isset($season['id'])) ? $season['id'] : '' ?>">
    <td class="dashicons dashicons-move" style="cursor: move;">&nbsp;</td>
    <td>
        <div class="select rental_availability_type">
            <input type="number" name="redq_seasonal_multiplier[]" step="0.001"
                   value="<?php if (!empty($season['multiplier'])) echo $season['multiplier']; ?>">
        </div>
    </td>
    <td>
        <div class="from_date inventory-form-to-input">
            <input type="text" style="border: 1px solid #ddd;" class="rnb-date-picker"
                   name="redq_seasonal_start_datetime[]"
                   value="<?php if (!empty($season['start_datetime'])) echo $season['start_datetime']; ?>"
                   autocomplete="off"/>
        </div>
    </td>
    <td>
        <div class="to_date inventory-form-to-input">
            <input type="text" style="border: 1px solid #ddd;" class="rnb-date-picker"
                   name="redq_seasonal_end_datetime[]"
                   value="<?php if (!empty($season['end_datetime'])) echo $season['end_datetime']; ?>"
                   autocomplete="off"/>
        </div>
    </td>
    <td>
        <div class="select">
            <input type="hidden" name="redq_seasonal_row_id[]"
                   value="<?php echo (isset($season['id'])) ? $season['id'] : '' ?>">
        </div>
    </td>
    <td class="inventory-remove">
        <button type="btn"><span class="dashicons dashicons-trash"></span></button>
    </td>
</tr>
