<tr>
    <th><?php echo esc_html__($field['title']); ?></th>
    <td>
        <div class="table_grid">
            <p><?php echo esc_html__($field['desc']); ?></p>
            <br>
            <table class="widefat">

                <tbody id="availability_rows">
                    <tr>
                        <td class="sort">&nbsp;</td>
                        <td>
                            <div class="day-name">
                                <?php esc_attr_e('Friday', 'redq-rental'); ?>
                            </div>
                        </td>
                        <td>
                            <div class="fri-min-time-outer">
                                <?php $fri_min_time = !empty($value['fri_min']) ? $value['fri_min'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="<?php echo $field['id'] . '[fri_min]'; ?>" value="<?php echo esc_attr($fri_min_time); ?>" />
                            </div>
                        </td>
                        <td>
                            <div class="max-time-outer">
                                <?php $fri_max_time = !empty($value['fri_max']) ? $value['fri_max'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="<?php echo $field['id'] . '[fri_max]'; ?>" value="<?php echo esc_attr($fri_max_time); ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="sort">&nbsp;</td>
                        <td>
                            <div class="day-name">
                                <?php esc_attr_e('Saturday', 'redq-rental'); ?>
                            </div>
                        </td>
                        <td>
                            <div class="fri-min-time-outer">
                                <?php $sat_min_time = !empty($value['sat_min']) ? $value['sat_min'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="<?php echo $field['id'] . '[sat_min]'; ?>" value="<?php echo esc_attr($sat_min_time); ?>" />
                            </div>
                        </td>
                        <td>
                            <div class="max-time-outer">
                                <?php $sat_max_time = !empty($value['sat_max']) ? $value['sat_max'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="<?php echo $field['id'] . '[sat_max]'; ?>" value="<?php echo esc_attr($sat_max_time); ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="sort">&nbsp;</td>
                        <td>
                            <div class="day-name">
                                <?php esc_attr_e('Sunday', 'redq-rental'); ?>
                            </div>
                        </td>
                        <td>
                            <div class="fri-min-time-outer">
                                <?php $sun_min_time = !empty($value['sun_min']) ? $value['sun_min'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="<?php echo $field['id'] . '[sun_min]'; ?>" value="<?php echo esc_attr($sun_min_time); ?>" />
                            </div>
                        </td>
                        <td>
                            <div class="max-time-outer">
                                <?php $sun_max_time = !empty($value['sun_max']) ? $value['sun_max'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="<?php echo $field['id'] . '[sun_max]'; ?>" value="<?php echo esc_attr($sun_max_time); ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="sort">&nbsp;</td>
                        <td>
                            <div class="day-name">
                                <?php esc_attr_e('Monday', 'redq-rental'); ?>
                            </div>
                        </td>
                        <td>
                            <div class="fri-min-time-outer">
                                <?php $mon_min_time = !empty($value['mon_min']) ? $value['mon_min'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="<?php echo $field['id'] . '[mon_min]'; ?>" value="<?php echo esc_attr($mon_min_time); ?>" />
                            </div>
                        </td>
                        <td>
                            <div class="max-time-outer">
                                <?php $mon_max_time = !empty($value['mon_max']) ? $value['mon_max'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="<?php echo $field['id'] . '[mon_max]'; ?>" value="<?php echo esc_attr($mon_max_time); ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="sort">&nbsp;</td>
                        <td>
                            <div class="day-name">
                                <?php esc_attr_e('Tuesday', 'redq-rental'); ?>
                            </div>
                        </td>
                        <td>
                            <div class="fri-min-time-outer">
                                <?php $thu_min_time = !empty($value['thu_min']) ? $value['thu_min'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="<?php echo $field['id'] . '[thu_min]'; ?>" value="<?php echo esc_attr($thu_min_time); ?>" />
                            </div>
                        </td>
                        <td>
                            <div class="max-time-outer">
                                <?php $thu_max_time = !empty($value['thu_max']) ? $value['thu_max'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="<?php echo $field['id'] . '[thu_max]'; ?>" value="<?php echo esc_attr($thu_max_time); ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="sort">&nbsp;</td>
                        <td>
                            <div class="day-name">
                                <?php esc_attr_e('Wednesday', 'redq-rental'); ?>
                            </div>
                        </td>
                        <td>
                            <div class="fri-min-time-outer">
                                <?php $wed_min_time = !empty($value['wed_min']) ? $value['wed_min'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="<?php echo $field['id'] . '[wed_min]'; ?>" value="<?php echo esc_attr($wed_min_time); ?>" />
                            </div>
                        </td>
                        <td>
                            <div class="max-time-outer">
                                <?php $wed_max_time = !empty($value['wed_max']) ? $value['wed_max'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="<?php echo $field['id'] . '[wed_max]'; ?>" value="<?php echo esc_attr($wed_max_time); ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="sort">&nbsp;</td>
                        <td>
                            <div class="day-name">
                                <?php esc_attr_e('Thursday', 'redq-rental'); ?>
                            </div>
                        </td>
                        <td>
                            <div class="fri-min-time-outer">
                                <?php $thur_min_time = !empty($value['thur_min']) ? $value['thur_min'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Min Time', 'redq-rental'); ?>" class="min-time" name="<?php echo $field['id'] . '[thur_min]'; ?>" value="<?php echo esc_attr($thur_min_time); ?>" />
                            </div>
                        </td>
                        <td>
                            <div class="max-time-outer">
                                <?php $thur_max_time = !empty($value['thur_max']) ? $value['thur_max'] : ''; ?>
                                <input type="text" placeholder="<?php esc_attr_e('Max Time', 'redq-rental'); ?>" class="max-time" name="<?php echo $field['id'] . '[thur_max]'; ?>" value="<?php echo esc_attr($thur_max_time); ?>" />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </td>
</tr>