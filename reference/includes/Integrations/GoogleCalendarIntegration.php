<?php

namespace REDQ_RnB\Integration;

use Carbon\Carbon;
use WC_Integration, WC_Logger, WC_Order, DateTime;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Google Calendar Integration - FIXED VERSION
 *
 * @version 4.0.2
 * @since 4.0.1
 * @return void
 */
class GoogleCalendarIntegration extends WC_Integration
{
    public $notice_title;
    public $notice_desc;
    public $docs_uri;
    protected $oauth_uri;
    protected $calendars_uri;
    protected $api_scope;
    protected $redirect_uri;
    public $client_id;
    protected $client_secret;
    protected $calendar_id;
    protected $enable_auto_sync;
    protected $debug;
    protected $log;

    /**
     * Google Calendar Initialization and required hooks
     */
    public function __construct()
    {
        $this->id                 = 'google_calendar';
        $this->plugin_id          = 'redq_rental_';
        $this->notice_title       = __('Connect RnB With Google Calendar To Trace Orders', 'redq-rental');
        $this->notice_desc = __('You need to do following things to get your required calendar credentials ', 'redq-rental');

        // Required End points
        $protocol = is_ssl() ? 'https' : null;
        $this->docs_uri = 'https://redq.gitbooks.io/woocommerce-rental-and-booking/content/google-calendar-integration.html';
        $this->oauth_uri     = 'https://accounts.google.com/o/oauth2/';
        $this->calendars_uri = 'https://www.googleapis.com/calendar/v3/calendars/';
        $this->api_scope     = 'https://www.googleapis.com/auth/calendar';
        $this->redirect_uri  = WC()->api_request_url('redq_rental_google_calendar', $protocol);

        // Required Credentials
        $this->client_id        = $this->get_option('client_id');
        $this->client_secret    = $this->get_option('client_secret');
        $this->calendar_id      = $this->get_option('calendar_id');
        $this->enable_auto_sync = $this->get_option('enable_auto_sync', 'no');
        $this->debug            = 'yes';

        // FIX: Initialize logger FIRST before any other operations
        if ('yes' === $this->debug) {
            if (class_exists('WC_Logger')) {
                $this->log = new WC_Logger();
            } else {
                $this->log = WC()->logger();
            }
        }

        // Admin Settings and forms
        $this->init_form_fields();
        $this->init_settings();

        add_action('woocommerce_update_options_integration_' . $this->id, array($this, 'process_admin_options'));
        add_action('woocommerce_api_redq_rental_google_calendar', array($this, 'rnb_oauth_redirect'));
        
        // FIX: Only add hooks if credentials are properly configured and auto sync is enabled
        if ($this->is_properly_configured() && 'yes' === $this->enable_auto_sync) {
            add_action('woocommerce_order_status_changed', array($this, 'rnb_google_cal_order_sync'), 10, 3);
            add_action('rnb_order_status_changed', array($this, 'rnb_google_cal_order_sync'), 10, 3);
            add_action('trashed_post', array($this, 'rnb_sync_trashed_booking'));
            add_action('untrashed_post', array($this, 'rnb_sync_non_trashed_booking'));
            
            // FIX: Add hook for new orders
            add_action('woocommerce_thankyou', array($this, 'rnb_google_cal_new_order_sync'), 10, 1);
        }

        if (is_admin()) {
            add_action('admin_notices', array($this, 'rnb_admin_notices'));
        }
    }

    /**
     * FIX: Check if Google Calendar is properly configured
     *
     * @return bool
     */
    private function is_properly_configured()
    {
        if (empty($this->client_id) || empty($this->client_secret) || empty($this->calendar_id)) {
            if ('yes' === $this->debug && $this->log) {
                $this->log->add($this->id, 'Google Calendar not properly configured. Missing credentials.');
            }
            return false;
        }

        $access_token = $this->get_calendar_access_token();
        if (empty($access_token)) {
            if ('yes' === $this->debug && $this->log) {
                $this->log->add($this->id, 'No access token available. Please authenticate.');
            }
            return false;
        }

        return true;
    }

    /**
     * Initialize integration settings form fields.
     *
     * @version 4.0.1
     * @since 4.0.1
     * @return void
     */
    public function init_form_fields()
    {
        $this->form_fields = array(
            'client_id' => array(
                'title'       => __('Google Client ID', 'redq-rental'),
                'type'        => 'text',
                'description' => __('Enter your Google Client ID.', 'redq-rental'),
                'default'     => '',
            ),
            'client_secret' => array(
                'title'       => __('Google Client Secret', 'redq-rental'),
                'type'        => 'text',
                'description' => __('Enter your Google Client Secret.', 'redq-rental'),
                'default'     => '',
            ),
            'calendar_id' => array(
                'title'       => __('Google Calendar ID', 'redq-rental'),
                'type'        => 'text',
                'description' => __('Enter your Calendar ID (e.g., "primary" or your calendar email).', 'redq-rental'),
                'default'     => 'primary',
            ),
            'enable_auto_sync' => array(
                'title'       => __('Enable Auto Sync', 'redq-rental'),
                'type'        => 'checkbox',
                'label'       => __('Enable automatic synchronization with Google Calendar', 'redq-rental'),
                'description' => __('When enabled, bookings will automatically sync with your Google Calendar when orders are placed, updated, or cancelled.', 'redq-rental'),
                'default'     => 'no',
                'desc_tip'    => true,
            ),
            'authorization' => array(
                'title'       => __('Authentication', 'redq-rental'),
                'type'        => 'google_calendar_authorization',
            ),
        );
    }

    /**
     * Validate the Google Calendar Authorization field.
     *
     * @param  mixed $key
     * @version 4.0.1
     * @since 4.0.1
     *
     * @return string
     */
    public function validate_google_calendar_authorization_field($key)
    {
        return '';
    }

    /**
     * Generate the google Calendar Authorization field.
     *
     * @param  mixed $key
     * @param  array $data
     * @version 4.0.1
     * @since 4.0.1
     *
     * @return string
     */
    public function generate_google_calendar_authorization_html($key, $data)
    {
        $options       = $this->plugin_id . $this->id . '_';
        $id            = $options . $key;
        $client_id     = isset($_POST[$options . 'client_id']) ? sanitize_text_field($_POST[$options . 'client_id']) : $this->client_id;
        $client_secret = isset($_POST[$options . 'client_secret']) ? sanitize_text_field($_POST[$options . 'client_secret']) : $this->client_secret;
        $calendar_id   = isset($_POST[$options . 'calendar_id']) ? sanitize_text_field($_POST[$options . 'calendar_id']) : $this->calendar_id;
        $enable_auto_sync = isset($_POST[$options . 'enable_auto_sync']) ? 'yes' : $this->enable_auto_sync;
        $access_token  = $this->get_calendar_access_token();

        ob_start();

?>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <?php echo wp_kses_post($data['title']); ?>
            </th>
            <td class="forminp">
                <?php
                if (!$access_token && ($client_id && $client_secret && $calendar_id)) :
                    $oauth_url = add_query_arg(
                        array(
                            'scope'           => $this->api_scope,
                            'redirect_uri'    => $this->redirect_uri,
                            'response_type'   => 'code',
                            'client_id'       => $client_id,
                            'approval_prompt' => 'force',
                            'access_type'     => 'offline',
                        ),
                        $this->oauth_uri . 'auth'
                    );
                ?>
                    <p class="submit"><a class="button button-primary" href="<?php echo esc_url($oauth_url); ?>"><?php esc_html_e('Connect with Google', 'redq-rental'); ?></a></p>
                <?php elseif ($access_token) : ?>
                    <p style="color: #46b450; font-weight: bold;">✅ <?php esc_html_e('Successfully authenticated.', 'redq-rental'); ?> 
                    <?php if ('yes' === $enable_auto_sync) : ?>
                        <?php esc_html_e('Auto sync is enabled!', 'redq-rental'); ?>
                    <?php else : ?>
                        <span style="color: #dc3232;"><?php esc_html_e('Auto sync is disabled.', 'redq-rental'); ?></span>
                    <?php endif; ?>
                    </p>
                    <p class="submit"><a class="button button-primary" href="<?php echo esc_url(add_query_arg(array('logout' => 'true'), $this->redirect_uri)); ?>"><?php esc_html_e('Disconnect', 'redq-rental'); ?></a></p>
                <?php else : ?>
                    <p style="color: #dc3232;"><?php esc_html_e('Unable to authenticate. Please enter your Client ID, Client Secret and Calendar ID, then click "Save changes".', 'redq-rental'); ?></p>
                <?php endif; ?>
            </td>
        </tr>
<?php
        return ob_get_clean();
    }

    /**
     * Admin Options.
     * @version 4.0.1
     * @since 4.0.1
     *
     * @return string
     */
    public function admin_options()
    {
        echo '<h3>' . $this->notice_title . '</h3>';
        echo wpautop($this->notice_desc);

        echo '<p>' . sprintf(__('First you need to create a project in %1$s. After creating project, you must enable the <strong>Google Calendar API</strong> in <strong>Your Project > Library</strong>, Then go to <strong>Your Project > Credentials > Create Credentials</strong> & create an OAuth Client ID for a <strong>Web application</strong> and set the <strong>Authorized redirect URIs</strong> as <code>%2$s</code>.', 'redq-rental'), '<a href="https://console.developers.google.com/project" target="_blank">' . __('Google Developers Console', 'redq-rental') . '</a>', $this->redirect_uri) . '</p>';

        echo '<strong>' . sprintf(__('Please visit our online docs ' . '<a href="%1$s" target="_blank">' . __('Online Docs', 'redq-rental') . '</a>' . ' to get more idea', 'redq-rental'), $this->docs_uri) . '</strong>';

        echo '<table class="form-table">';
        $this->generate_settings_html();
        echo '</table>';

        echo '<div><input type="hidden" name="section" value="' . $this->id . '" /></div>';
    }

    /**
     * Get Access Token For Google Calendar.
     *
     * @param  string $code Authorization code.
     * @version 4.0.1
     * @since 4.0.1
     *
     * @return string Access token.
     */
    protected function get_calendar_access_token($code = '')
    {

        if ('yes' === $this->debug && $this->log) {
            $this->log->add($this->id, 'Getting Google API Access Token...');
        }

        $access_token = get_transient('redq_rental_gcalendar_access_token');

        if (!$code && false !== $access_token) {
            if ('yes' === $this->debug && $this->log) {
                $this->log->add($this->id, 'Access Token recovered by transients: ' . print_r($access_token, true));
            }
            return $access_token;
        }

        $refresh_token = get_option('redq_rental_gcalendar_refresh_token');

        if (!$code && $refresh_token) {

            if ('yes' === $this->debug && $this->log) {
                $this->log->add($this->id, 'Generating a new Access Token...');
            }

            $data = array(
                'client_id'     => $this->client_id,
                'client_secret' => $this->client_secret,
                'refresh_token' => $refresh_token,
                'grant_type'    => 'refresh_token',
            );

            $params = array(
                'body'      => http_build_query($data),
                'sslverify' => false,
                'timeout'   => 60,
                'headers'   => array(
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ),
            );

            $response = wp_remote_post($this->oauth_uri . 'token', $params);

            if (!is_wp_error($response) && 200 == $response['response']['code'] && 'OK' == $response['response']['message']) {
                $response_data = json_decode($response['body']);
                $access_token  = sanitize_text_field($response_data->access_token);

                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Google API Access Token generated successfully: ' . print_r($access_token, true));
                }

                // Set the transient.
                set_transient('redq_rental_gcalendar_access_token', $access_token, 3500);

                return $access_token;
            } else {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Error while generating the Access Token: ' . print_r($response, true));
                }
            }
        } elseif ('' != $code) {

            if ('yes' === $this->debug && $this->log) {
                $this->log->add($this->id, 'Renewing the Access Token...');
            }

            $data = array(
                'code'          => $code,
                'client_id'     => $this->client_id,
                'client_secret' => $this->client_secret,
                'redirect_uri'  => $this->redirect_uri,
                'grant_type'    => 'authorization_code',
            );

            $params = array(
                'body'      => http_build_query($data),
                'sslverify' => false,
                'timeout'   => 60,
                'headers'   => array(
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ),
            );

            $response = wp_remote_post($this->oauth_uri . 'token', $params);

            if (!is_wp_error($response) && 200 == $response['response']['code'] && 'OK' == $response['response']['message']) {
                $response_data = json_decode($response['body']);
                $access_token  = sanitize_text_field($response_data->access_token);

                // Add refresh token.
                update_option('redq_rental_gcalendar_refresh_token', $response_data->refresh_token);

                // Set the transient.
                set_transient('redq_rental_gcalendar_access_token', $access_token, 3500);

                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Google API Access Token renewed successfully: ' . print_r($access_token, true));
                }
                return $access_token;
            } else {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Error while renewing the Access Token: ' . print_r($response, true));
                }
            }
        }

        if ('yes' === $this->debug && $this->log) {
            $this->log->add($this->id, 'Failed to retrieve and generate the Access Token');
        }

        return '';
    }

    /**
     * OAuth Logout.
     *
     * @version 4.0.1
     * @since 4.0.1
     *
     * @return bool
     */
    protected function oauth_logout()
    {
        if ('yes' === $this->debug && $this->log) {
            $this->log->add($this->id, 'Leaving the Google Calendar app...');
        }

        $refresh_token = get_option('redq_rental_gcalendar_refresh_token');

        if ($refresh_token) {
            $params = array(
                'sslverify' => false,
                'timeout'   => 60,
                'headers'   => array(
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ),
            );

            $response = wp_remote_get($this->oauth_uri . 'revoke?token=' . $refresh_token, $params);

            if (!is_wp_error($response) && 200 == $response['response']['code'] && 'OK' == $response['response']['message']) {
                delete_option('redq_rental_gcalendar_refresh_token');
                delete_transient('redq_rental_gcalendar_access_token');

                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Leave the Google Calendar app successfully');
                }

                return true;
            } else {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Error when leaving the Google Calendar app: ' . print_r($response, true));
                }
            }
        }

        if ('yes' === $this->debug && $this->log) {
            $this->log->add($this->id, 'Failed to leave the Google Calendar app');
        }

        return false;
    }

    /**
     * Process the oauth redirect.
     *
     * @version 4.0.1
     * @since 4.0.1
     *
     * @return void
     */
    public function rnb_oauth_redirect()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('Permission denied!', 'redq-rental'));
        }

        $redirect_args = array(
            'page'    => 'wc-settings',
            'tab'     => 'integration',
            'section' => $this->id,
        );

        // OAuth.
        if (isset($_GET['code'])) {
            $code         = sanitize_text_field($_GET['code']);
            $access_token = $this->get_calendar_access_token($code);

            if ('' != $access_token) {
                $redirect_args['wc_gcalendar_oauth'] = 'success';

                wp_redirect(add_query_arg($redirect_args, admin_url('admin.php')), 301);
                exit;
            }
        }
        if (isset($_GET['error'])) {

            $redirect_args['wc_gcalendar_oauth'] = 'fail';

            wp_redirect(add_query_arg($redirect_args, admin_url('admin.php')), 301);
            exit;
        }

        // Logout.
        if (isset($_GET['logout'])) {
            $logout = $this->oauth_logout();
            $redirect_args['wc_gcalendar_logout'] = ($logout) ? 'success' : 'fail';

            wp_redirect(add_query_arg($redirect_args, admin_url('admin.php')), 301);
            exit;
        }

        wp_die(__('Invalid request!', 'redq-rental'));
    }

    /**
     * Display admin screen notices.
     *
     * @version 4.0.1
     * @since 4.0.1
     *
     * @return string
     */
    public function rnb_admin_notices()
    {
        $screen = get_current_screen();

        if ('woocommerce_page_wc-settings' == $screen->id && isset($_GET['wc_gcalendar_oauth'])) {
            if ('success' == $_GET['wc_gcalendar_oauth']) {
                echo '<div class="updated fade"><p><strong>' . __('Google Calendar', 'redq-rental') . '</strong> ' . __('Successfully Authenticated! Sync is now active.', 'redq-rental') . '</p></div>';
            } else {
                echo '<div class="error fade"><p><strong>' . __('Google Calendar', 'redq-rental') . '</strong> ' . __('Failed to Authenticate to your account, please try again', 'redq-rental') . '</p></div>';
            }
        }

        if ('woocommerce_page_wc-settings' == $screen->id && isset($_GET['wc_gcalendar_logout'])) {
            if ('success' == $_GET['wc_gcalendar_logout']) {
                echo '<div class="updated fade"><p><strong>' . __('Google Calendar', 'redq-rental') . '</strong> ' . __('Account disconnected successfully!', 'redq-rental') . '</p></div>';
            } else {
                echo '<div class="error fade"><p><strong>' . __('Google Calendar', 'redq-rental') . '</strong> ' . __('Failed to disconnect to your account, please try again', 'redq-rental') . '</p></div>';
            }
        }
    }

    /**
     * FIX: Sync new order to Google Calendar
     *
     * @param int $order_id
     * @return void
     */
    public function rnb_google_cal_new_order_sync($order_id)
    {
        if (!$order_id) {
            return;
        }

        $order = wc_get_order($order_id);
        if (!$order) {
            return;
        }

        // Sync the order with status
        $this->rnb_google_cal_order_sync($order_id, '', $order->get_status());
    }

    /**
     * Updates date availability with status of order - FIXED VERSION
     *
     * @version 4.0.2
     * @since 4.0.1
     *
     * @param int $order_id
     * @param string $old_status
     * @param string $new_status
     * @return bool
     */
    public function rnb_google_cal_order_sync($order_id, $old_status, $new_status)
    {
        try {
            $order = wc_get_order($order_id);

            if (!$order) {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Order not found: ' . $order_id);
                }
                return false;
            }

            if ($order->get_status() === 'rnb-fake-order') {
                return false;
            }

            $items = $order->get_items();

            if (empty($items)) {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'No items in order: ' . $order_id);
                }
                return false;
            }

            $billing_email = $order->get_billing_email();
            $email         = $billing_email ? $billing_email : get_option('admin_email');

            foreach ($items as $item_id => $item) {

                $product_id = $item->get_data()['product_id'];
                $product = wc_get_product($product_id);
                
                if (empty($product) || $product->get_type() !== 'redq_rental') {
                    continue;
                }

                // FIX: Better data preparation with validation
                $item_data = rnb_prepare_calendar_item_data($item, $order_id, $order);

                if (empty($item_data['start']) || empty($item_data['end'])) {
                    if ('yes' === $this->debug && $this->log) {
                        $this->log->add($this->id, 'Missing start or end date for order: ' . $order_id . ', item: ' . $item_id);
                    }
                    continue;
                }

                $start       = $item_data['start'];
                $end         = isset($item_data['return_date']) ? $item_data['return_date'] : $item_data['end'];
                $start_time  = isset($item_data['start_time']) ? $item_data['start_time'] : '';
                $end_time    = isset($item_data['return_time']) ? $item_data['return_time'] : '';
                $end_time = $end_time === '24:00' ? '23:59' : $end_time;

                $description = isset($item_data['description']) ? $item_data['description'] : '';

                // FIX: Use WordPress timezone
                $timezone = wp_timezone_string();

                if (!empty($start_time) && !empty($end_time)) {
                    $start_info = [
                        'dateTime' => $start . 'T' . date("H:i:s", strtotime($start_time)),
                        'timeZone' => $timezone
                    ];
                    $end_info   = [
                        'dateTime' => $end . 'T' . date("H:i:s", strtotime($end_time)),
                        'timeZone' => $timezone
                    ];
                } else {
                    $start_info = ['date' => $start];
                    $end_info   = ['date' => $end];
                }

                $data = [
                    'summary'     => get_the_title($product_id) . ' | ' . esc_html__('Order Status', 'redq-rental') . ': [ ' . $new_status . ' ]',
                    'description' => $description,
                    'colorId'     => $this->get_status_color_id($new_status),
                    'attendees'   => [['email' => $email]],
                    'start'       => $start_info,
                    'end'         => $end_info
                ];

                if ($new_status !== 'cancelled' && $new_status !== 'failed') :
                    $this->rnb_sync_booking($order_id, $item_id, $data);
                else :
                    $this->rnb_remove_booking($order_id, $item_id);
                endif;
            }

            return true;

        } catch (\Exception $e) {
            if ('yes' === $this->debug && $this->log) {
                $this->log->add($this->id, 'Exception in order sync: ' . $e->getMessage());
            }
            return false;
        }
    }

    /**
     * FIX: Get color ID for order status
     *
     * @param string $status
     * @return string
     */
    private function get_status_color_id($status)
    {
        $color_map = [
            'pending'    => '5',  // Yellow
            'processing' => '9',  // Blue
            'on-hold'    => '6',  // Orange
            'completed'  => '10', // Green
            'cancelled'  => '11', // Red
            'refunded'   => '8',  // Gray
            'failed'     => '4'   // Pink
        ];

        return isset($color_map[$status]) ? $color_map[$status] : '1';
    }

    /**
     * Sync Booking with Google Calendar when booking status changed - FIXED VERSION
     *
     * @version 4.0.2
     * @since 4.0.1
     *
     * @param  int $order_id Order ID
     * @param  int $item_id Item ID
     * @param  array $data Booking Data
     *
     * @return bool
     */
    public function rnb_sync_booking($order_id, $item_id, $data)
    {
        try {
            // FIX: Validate calendar ID
            if (empty($this->calendar_id)) {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Calendar ID is empty. Cannot sync.');
                }
                return false;
            }

            $api_url      = $this->calendars_uri . $this->calendar_id . '/events';
            $access_token = $this->get_calendar_access_token();

            // FIX: Validate access token
            if (empty($access_token)) {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Access token is empty. Cannot sync order: ' . $order_id);
                }
                return false;
            }

            $event_id = wc_get_order_item_meta($item_id, 'redq_google_cal_sync_id', true);

            // Connection params.
            $params = array(
                'method'    => 'POST',
                'body'      => json_encode(apply_filters('woocommerce_bookings_gcalendar_sync', $data)),
                'sslverify' => false,
                'timeout'   => 60,
                'headers'   => array(
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token,
                ),
            );

            // Update event.
            if ($event_id) {
                $api_url .= '/' . $event_id;
                $params['method'] = 'PUT';
                
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Updating existing event: ' . $event_id . ' for order: ' . $order_id);
                }
            } else {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Creating new event for order: ' . $order_id);
                }
            }

            $response = wp_remote_post($api_url, $params);

            if (is_wp_error($response)) {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'WP Error while syncing order #' . $order_id . ': ' . $response->get_error_message());
                }
                return false;
            }

            $response_code = wp_remote_retrieve_response_code($response);
            $response_body = wp_remote_retrieve_body($response);

            if ($response_code == 200 || $response_code == 201) {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Booking synchronized successfully for order #' . $order_id);
                }
                // Updated the Google Calendar event ID
                $response_data = json_decode($response_body, true);
                if (isset($response_data['id'])) {
                    wc_update_order_item_meta($item_id, 'redq_google_cal_sync_id', $response_data['id']);
                }
                return true;
            } else {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Error while synchronizing order #' . $order_id . '. Response code: ' . $response_code . '. Response: ' . $response_body);
                }
                return false;
            }

        } catch (\Exception $e) {
            if ('yes' === $this->debug && $this->log) {
                $this->log->add($this->id, 'Exception while syncing order #' . $order_id . ': ' . $e->getMessage());
            }
            return false;
        }
    }


    /**
     * Removed booking from calendar - FIXED VERSION
     *
     * @version 4.0.2
     * @since 4.0.1
     * @param  int $order_id Order ID
     * @param  int $item_id Item ID
     *
     * @return bool
     */
    public function rnb_remove_booking($order_id, $item_id)
    {
        try {
            $event_id = wc_get_order_item_meta($item_id, 'redq_google_cal_sync_id', true);

            if (!$event_id) {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'No event ID found for order #' . $order_id . ', item #' . $item_id);
                }
                return false;
            }

            $api_url      = $this->calendars_uri . $this->calendar_id . '/events/' . $event_id;
            $access_token = $this->get_calendar_access_token();

            if (empty($access_token)) {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Access token is empty. Cannot remove event.');
                }
                return false;
            }

            $params = array(
                'method'    => 'DELETE',
                'sslverify' => false,
                'timeout'   => 60,
                'headers'   => array(
                    'Authorization' => 'Bearer ' . $access_token,
                ),
            );

            $response = wp_remote_post($api_url, $params);

            if (is_wp_error($response)) {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'WP Error while removing booking #' . $order_id . ': ' . $response->get_error_message());
                }
                return false;
            }

            $response_code = wp_remote_retrieve_response_code($response);

            if ($response_code == 204 || $response_code == 410) { // 410 = already deleted
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Booking removed successfully from calendar for order #' . $order_id);
                }
                // Remove the event ID from order meta
                wc_delete_order_item_meta($item_id, 'redq_google_cal_sync_id');
                return true;
            } else {
                if ('yes' === $this->debug && $this->log) {
                    $this->log->add($this->id, 'Error while removing booking #' . $order_id . '. Response code: ' . $response_code);
                }
                return false;
            }

        } catch (\Exception $e) {
            if ('yes' === $this->debug && $this->log) {
                $this->log->add($this->id, 'Exception while removing booking #' . $order_id . ': ' . $e->getMessage());
            }
            return false;
        }
    }


    /**
     * Retrieve booking from when restore order and sync with GCal
     *
     * @param  int $order_id Order ID
     * @version 4.0.1
     * @since 4.0.1
     *
     * @return void
     */
    public function rnb_sync_non_trashed_booking($order_id)
    {
        $post_type = get_post_type($order_id);
        if (isset($post_type) && $post_type === 'shop_order') :
            $order = wc_get_order($order_id);
            if (!$order) {
                return;
            }

            // FIX: Use the main sync method
            $this->rnb_google_cal_order_sync($order_id, '', $order->get_status());
        endif;
    }

    /**
     * Remove/cancel the booking in Google Calendar
     *
     * @param  int $order_id Order ID
     * @version 4.0.1
     * @since 4.0.1
     *
     * @return void
     */
    public function rnb_sync_trashed_booking($order_id)
    {

        $post_type = get_post_type($order_id);

        if (isset($post_type) && $post_type === 'shop_order') :
            $order = wc_get_order($order_id);
            if (!$order) {
                return;
            }
            
            $items = $order->get_items();
            if (isset($items) && !empty($items)) {
                foreach ($items as $item_key => $item_value) {
                    $item_id = $item_key;
                    $item_data = $item_value->get_data();
                    $product_id = $item_data['product_id'];
                    $product = wc_get_product($product_id);
                    $product_type = $product ? $product->get_type() : '';
                    if (isset($product_type) && $product_type === 'redq_rental') {
                        $this->rnb_remove_booking($order_id, $item_id);
                    }
                }
            }
        endif;
    }


    /**
     * Check array key from multi-dimentional array
     *
     * @version 4.0.1
     * @since 4.0.1
     *
     * @return int
     */
    public function get_multidimentional_array_index($products, $field, $value)
    {
        foreach ($products as $key => $product) {
            if ($product->$field === $value)
                return $key;
        }
        return false;
    }
}

