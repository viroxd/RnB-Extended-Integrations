<div class="user-password-container">
    <p><?php echo esc_html__('Hi,', 'redq-rental'); ?></p>
    <p style="margin-top: 30px;"> <?php echo esc_html__('This password has been generated automatically by the system. You may change it in My Account -> Account details page.', 'redq-rental'); ?> </p>

    <div class="details" style="margin-top: 30px;">
        <p><?php echo esc_html__('username:', 'redq-rental'); ?> <?php echo $mail_data['username']; ?></p>
        <p><?php echo esc_html__('password:', 'redq-rental'); ?> <?php echo $mail_data['password']; ?></p>
    </div>

    <p style="margin-top: 30px;"><?php echo esc_html__('Thank You,', 'redq-rental'); ?></p>
</div>