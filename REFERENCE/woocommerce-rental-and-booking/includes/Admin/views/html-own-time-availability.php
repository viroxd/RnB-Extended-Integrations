<?php

if (!isset($availability['type']))
    $availability['type'] = 'custom_time';
?>

<tr>
    <td class="sort">&nbsp;</td>
    <td>
        <div class="from_date">
            <input type="text" style="border: 1px solid #ddd;" class="rnb-date-picker"
                   name="redq_rental_time_availability_date[]"
                   value="<?php if (!empty($availability['date'])) echo $availability['date'] ?>"/>
        </div>
    </td>
    <td>
        <div class="from_time">
            <input type="time" style="border: 1px solid #ddd;" class="time-picker"
                   name="redq_rental_time_availability_from_time[]"
                   value="<?php if (!empty($availability['from'])) echo $availability['from'] ?>"/>
        </div>
    </td>
    <td>
        <div class="to_date">
            <input type="time" style="border: 1px solid #ddd;" class="time-picker"
                   name="redq_rental_time_availability_to_time[]"
                   value="<?php if (!empty($availability['to'])) echo $availability['to'] ?>"/>
        </div>
    </td>
    <td>
        <div class="select">
            <select name="redq_time_availability_rentable[]">
                <option value="no" <?php selected(isset($availability['rentable']) && $availability['rentable'] == 'no', true) ?>><?php _e('Not', 'redq-rental'); ?></option>
                <!-- <option value="yes" <?php //selected( isset( $availability['bookable'] ) && $availability['bookable'] == 'yes', true )
                ?>><?php _e('Yes', 'redq-rental'); ?></option> -->
            </select>
        </div>
    </td>
    <td class="remove">
        <button type="btn" class="btn"><?php _e('delete', 'redq-rental'); ?></button>
    </td>
</tr>