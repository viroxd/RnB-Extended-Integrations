
<script type="text/template" id="tmpl-wc-modal-view-order">
    <div class="wc-backbone-modal wc-order-preview">
        <div class="wc-backbone-modal-content">
            <section class="wc-backbone-modal-main" role="main">
                <header class="wc-backbone-modal-header">
                    <mark class="order-status status-{{ data.status }}"><span>{{ data.status_name }}</span></mark>
                    <?php /* translators: %s: order ID */ ?>
                    <h1><?php echo esc_html(sprintf(__('Order #%s', 'redq-rental'), '{{ data.order_number }}')); ?></h1>
                    <button class="modal-close modal-close-link dashicons dashicons-no-alt">
                        <span class="screen-reader-text"><?php esc_html_e('Close modal panel', 'redq-rental'); ?></span>
                    </button>
                </header>
                <article>
                    <?php do_action('woocommerce_admin_order_preview_start'); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment 
                    ?>

                    <div class="wc-order-preview-addresses">
                        <div class="wc-order-preview-address">
                            <h2><?php esc_html_e('Billing details', 'redq-rental'); ?></h2>
                            {{{ data.formatted_billing_address }}}

                            <# if ( data.data.billing.email ) { #>
                                <strong><?php esc_html_e('Email', 'redq-rental'); ?></strong>
                                <a href="mailto:{{ data.data.billing.email }}">{{ data.data.billing.email }}</a>
                            <# } #>

                            <# if ( data.data.billing.phone ) { #>
                                <strong><?php esc_html_e('Phone', 'redq-rental'); ?></strong>
                                <a href="tel:{{ data.data.billing.phone }}">{{ data.data.billing.phone }}</a>
                            <# } #>

                            <# if ( data.payment_via ) { #>
                                <strong><?php esc_html_e('Payment via', 'redq-rental'); ?></strong>
                                {{{ data.payment_via }}}
                            <# } #>
                        </div>
                        <# if ( data.needs_shipping ) { #>
                            <div class="wc-order-preview-address">
                                <h2><?php esc_html_e('Shipping details', 'redq-rental'); ?></h2>
                                <# if ( data.ship_to_billing ) { #>
                                    {{{ data.formatted_billing_address }}}
                                <# } else { #>
                                    <a href="{{ data.shipping_address_map_url }}" target="_blank">{{{ data.formatted_shipping_address }}}</a>
                                <# } #>

                                <# if ( data.shipping_via ) { #>
                                    <strong><?php esc_html_e('Shipping method', 'redq-rental'); ?></strong>
                                    {{ data.shipping_via }}
                                <# } #>
                            </div>
                        <# } #>

                        <# if ( data.data.customer_note ) { #>
                            <div class="wc-order-preview-note">
                                <strong><?php esc_html_e('Note', 'redq-rental'); ?></strong>
                                {{ data.data.customer_note }}
                            </div>
                        <# } #>
                    </div>

                    {{{ data.item_html }}}

                    <?php do_action('woocommerce_admin_order_preview_end'); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment 
                    ?>
                </article>
                <footer>
                    <div class="inner">
                        {{{ data.actions_html }}}

                        <a class="button button-primary button-large" aria-label="<?php esc_attr_e('Edit this order', 'redq-rental'); ?>" href="<?php echo $order_edit_url_placeholder; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                                                                                                                                ?>"><?php esc_html_e('Edit', 'redq-rental'); ?></a>
                    </div>
                </footer>
            </section>
        </div>
    </div>
    <div class="wc-backbone-modal-backdrop modal-close"></div>
</script>