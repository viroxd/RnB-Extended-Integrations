<ul class="quote_actions submitbox">
    <li class="wide" id="quote-status">
        <label><?php esc_html_e('Quote Status', 'redq-rental') ?></label>
        <?php
        $quote_statuses = apply_filters(
            'redq_get_request_quote_post_statuses',
            array(
                'quote-pending'    => _x('Pending', 'Quote status', 'redq-rental'),
                'quote-processing' => _x('Processing', 'Quote status', 'redq-rental'),
                'quote-on-hold'    => _x('On Hold', 'Quote status', 'redq-rental'),
                'quote-accepted'   => _x('Accepted', 'Quote status', 'redq-rental'),
                'quote-completed'  => _x('Completed', 'Quote status', 'redq-rental'),
                'quote-cancelled'  => _x('Cancelled', 'Quote status', 'redq-rental'),
            )
        );
        ?>
        <select name="post_status">
            <?php foreach ($quote_statuses as $key => $value) : ?>
                <option value="<?php echo $key ?>" <?php echo ($post->post_status === $key) ? 'selected="selected"' : '' ?>><?php echo $value ?></option>
            <?php endforeach; ?>
        </select>
    </li>
    <li class="wide">
        <label><?php esc_html_e('Price', 'redq-rental') ?>
            (<?php echo esc_attr(get_post_meta($post->ID, 'currency-symbol', true)) ?>)</label>
        <?php
        $price = get_post_meta($post->ID, '_quote_price', true);
        ?>
        <input type="text" class="redq_input_price" name="quote_price" value="<?php echo $price ?>">
        <input type="hidden" name="previous_post_status" value="<?php echo $post->post_status ?>">
    </li>
    <li class="wide last">
        <div id="delete-action">
            <?php
            if (current_user_can('delete_post', $post->ID)) {
                if (!EMPTY_TRASH_DAYS) {
                    $delete_text = __('Delete Permanently', 'redq-rental');
                } else {
                    $delete_text = __('Move to Trash', 'redq-rental');
                }
            ?>
                <a class="submitdelete deletion" href="<?php echo esc_url(get_delete_post_link($post->ID)); ?>">
                    <?php echo $delete_text; ?>
                </a>
            <?php } ?>
        </div>
        <input type="submit" class="button save_quote button-primary tips" name="save" value="<?php esc_html_e('Update Quote', 'redq-rental'); ?>" data-tip="<?php esc_html_e('Update the %s', 'redq-rental'); ?>" />
    </li>
</ul>