<?php
$uid_message = get_option('rnb_uid_error_message');
if (empty($uid_message)) {
    update_option('rnb_uid_error_message', 'U29ycnkhIExpY2Vuc2Uga2V5IGlzIG5vdCBhY3RpdmF0ZWQ=');
}
$link =  apply_filters('rnb_license_key_link', 'https://rnb-doc.vercel.app/envato-licence');
$status = $uid_code && $activation_status ? 'Active' : 'Inactive';
$statusClass = $uid_code && $activation_status ? 'active' : 'inactive';
?>

<div class="redq-setup-wizard-activation-form rnb-dashboard rnb-dashboard-wrapper">
    <h2 class="title"><?php esc_html_e('License Status', 'redq-rental'); ?>:
        <span class="<?php echo esc_attr($statusClass); ?>"><?php echo esc_attr($status); ?></span>
    </h2>

    <p class="description"> <?php echo sprintf(__('To obtain the license key, kindly proceed by <a target="_blank" href="%s"> following this link </a>.', 'turbo'), $link); ?> </p>

    <form class="license-activation-form" method="post">
        <input placeholder="<?php esc_attr_e('Theme purchase code.', 'redq-rental'); ?>" class="license-key" type="text" name="license_key" value="<?php echo esc_attr($masked_code); ?>" required="">
        <?php wp_nonce_field('rnb-uid-security'); ?>
        <?php if ($uid_code && $activation_status) : ?>
            <input class="deactivate-input" type="hidden" name="deactivate" value="1" />
            <button type="submit" class="deactivate-btn">
                <?php esc_html_e('Deactivate', 'redq-rental'); ?>
                <?php $this->loader(); ?>
            </button>
        <?php else : ?>
            <button type="submit" class="activate-btn">
                <?php esc_html_e('Activate', 'redq-rental'); ?>
                <?php $this->loader(); ?>
            </button>
        <?php endif; ?>
    </form>

    <div class="purchase-link" style="text-align: center; margin-top: 30px;">
        <?php
        echo sprintf(
            "<p>%s <a target='_blank' href='%s'>%s</a></p>",
            __("To ensure your site's proper functioning and security, only purchase a valid license for the RnB - WooCommerce Rental & Booking System from", 'your-text-domain'),
            'https://1.envato.market/vYx3v',
            __("Codecanyon", 'your-text-domain')
        );
        ?>
    </div>


</div>