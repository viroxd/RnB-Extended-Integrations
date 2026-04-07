<?php 
    $form_data = [];
    $order_quote_meta = json_decode(stripslashes(get_post_meta($post->ID, 'order_quote_meta', true)), true);
    if(is_null($order_quote_meta) ){
        $order_quote_meta = json_decode(get_post_meta($post->ID, 'order_quote_meta', true), true);
     }  
    if(!empty($order_quote_meta) && is_array($order_quote_meta)){
        foreach($order_quote_meta as $key=>$meta){
           if(isset($meta['forms'])){
            $form_data = $meta['forms'];
           } 
        }
    } 
   $quote_first_name = isset($form_data['quote_first_name']) ?   $form_data['quote_first_name']: '';  
   $quote_last_name = isset($form_data['quote_last_name']) ?   $form_data['quote_last_name']: ''; 
   $quote_name = $quote_first_name.' '.$quote_last_name;
   $quote_email = isset($form_data['quote_email']) ?   $form_data['quote_email']: ''; 
   $quote_phone = isset($form_data['quote_phone']) ?   $form_data['quote_phone']: ''; 
   $quote_message = isset($form_data['quote_message']) ?   $form_data['quote_message']: ''; 
?>
<div class="quote-wrapper">
    <div class="quote-heading">
        <h2 class="quote__heading"><?php echo esc_html__('Quote Id#', 'redq-rental').' '.esc_html($post->ID); ?></h2>
        <p> <?php echo esc_html__('Time# ', 'redq-rental').get_the_title($post->ID) ?></p>
    </div>
    <div class="request-for-a-quote-message">
        <div class="left-content">
            <textarea class="widefat add-quote-message" name="add-quote-message"></textarea>
            <button class="add-message-button button refund-deposit"><?php esc_html_e('ADD MESSAGE', 'redq-rental') ?></button>
    <?php
        $quote_id = $post->ID;
        // Remove the comments_clauses where query here.
        remove_filter('comments_clauses', 'exclude_request_quote_comments_clauses');
        $args = array(
            'post_id' => $quote_id,
            'orderby' => 'comment_ID',
            'order'   => 'DESC',
            'approve' => 'approve',
            'type'    => 'quote_message'
        );
        $comments = get_comments($args); ?>
        <ul class="quote-message">
        <?php foreach ($comments as $comment) : ?>
            <?php
            $list_class = 'message-list';
            $content_class = 'quote-message-content';
            if ($comment->user_id === get_post_field('post_author', $quote_id)) {
                $list_class .= ' customer';
                $content_class .= ' customer';
            }
            ?>
            <li class="<?php echo $list_class ?>">
                <div class="<?php echo $content_class ?>">
                    <?php echo wpautop(wptexturize(wp_kses_post($comment->comment_content))); ?>
                </div>
                <p class="meta">
                    <abbr class="exact-date" title="<?php echo $comment->comment_date; ?>"><?php printf(__('added on %1$s at %2$s', 'redq-rental'), date_i18n(wc_date_format(), strtotime($comment->comment_date)), date_i18n(wc_time_format(), strtotime($comment->comment_date))); ?></abbr>
                    <?php printf(' ' . __('by %s', 'redq-rental'), $comment->comment_author); ?>
                    <!-- <a href="#" class="delete-message"><?php _e('Delete', 'redq-rental'); ?></a> -->
                </p>
            </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <div class="right-content">
             <h2><?php echo esc_html__('Customer details', 'redq-rental'); ?></h2>
             <div class="address">
                    <p><strong><?php echo esc_html__('Name: ', 'redq-rental') ?></strong><span><?php echo esc_html($quote_name); ?></span></p>
                    <p><strong><?php echo esc_html__('Email: ', 'redq-rental') ?></strong><span><?php echo esc_html($quote_email); ?></span></p>
                    <p><strong><?php echo esc_html__('Phone: ', 'redq-rental') ?></strong><span><?php echo esc_html($quote_phone); ?></span></p>
                    <p><strong><?php echo esc_html__('Message: ', 'redq-rental') ?></strong><span><?php echo esc_html($quote_message); ?></span></p>
			 </div>
        </div>
    </div>
</div>