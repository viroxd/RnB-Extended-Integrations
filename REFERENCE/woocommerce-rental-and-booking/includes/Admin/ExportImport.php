<?php
declare(strict_types=1);
namespace REDQ_RnB\Admin;


use REDQ_RnB\Traits\Admin_Trait;
use REDQ_RnB\Traits\Import_Export;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class ExportImport {
    use Import_Export;
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'register_export_import_submenu' ] );
        add_action( 'admin_init', [ $this, 'handle_export_import_actions' ] );
        add_action( 'wp_ajax_rnb_export_settings', [ $this, 'export_settings' ] );
        add_action( 'wp_ajax_rnb_import_settings', [ $this, 'redq_rental_import_settings_ajax_handler' ] );
        add_action( 'admin_post_rnb_export_products_csv', [ $this, 'handle_export_products_csv' ] );
        add_action( 'admin_post_rnb_import_products_csv', [ $this, 'handle_import_products_csv' ] );
        add_action( 'wp_ajax_rnb_export_inventory_csv', [ $this, 'handle_export_inventory_csv' ] );
        add_action( 'wp_ajax_rnb_import_inventory_csv', [ $this, 'handle_import_inventory_csv' ] );
    }

    /**
     * Register Export/Import submenu under RnB Dashboard
     */
    public function register_export_import_submenu() {
        add_submenu_page(
            'rnb_dashboard',
            esc_html__( 'Import/Export', 'redq-rental' ),
            esc_html__( 'Import/Export', 'redq-rental' ),
            'manage_woocommerce',
            'rnb_export_import',
            [ $this, 'render_export_import_page' ]
        );
    }

    /**
     * Render the Export/Import admin page with tabs
     */
    public function render_export_import_page() {
        $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'export';

        ?>
        <div class="wrap">
            <h1><?php echo esc_html__( 'Import/Export', 'redq-rental' ); ?></h1>
            <?php
            // Inline notices via query args
            if ( isset( $_GET['rnb_ie_notice'] ) ) {
                $class = isset($_GET['type']) && $_GET['type'] === 'error' ? 'notice-error' : 'notice-success';
                echo '<div class="notice ' . esc_attr($class) . '"><p>' . esc_html( wp_unslash( $_GET['rnb_ie_notice'] ) ) . '</p></div>';
            }
            ?>
            <h2 class="nav-tab-wrapper">
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=rnb_export_import&tab=export' ) ); ?>" class="nav-tab <?php echo ( $active_tab === 'export' ) ? 'nav-tab-active' : ''; ?>">
                    <?php echo esc_html__( 'Export', 'redq-rental' ); ?>
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=rnb_export_import&tab=import' ) ); ?>" class="nav-tab <?php echo ( $active_tab === 'import' ) ? 'nav-tab-active' : ''; ?>">
                    <?php echo esc_html__( 'Import', 'redq-rental' ); ?>
                </a>
            </h2>
            <div class="rnb-export-import-tab-content">
                <?php
                if ( $active_tab === 'export' ) {
                    $this->render_export_tab();
                } else {
                    $this->render_import_tab();
                }
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render Export Tab
     */
    private function render_export_tab() {
        ?>
        <div class="rnb-export-section">
            <h3><?php esc_html_e('Export Settings', 'redq-rental'); ?></h3>
            <form id="rnb-settings-export-form">
                <?php wp_nonce_field('rnb_export_import_nonce', 'nonce'); ?>
                <p class="submit">
                    <button type="submit" class="button button-primary" id="rnb-export-settings-btn">
                        <?php esc_html_e('Export Settings', 'redq-rental'); ?>
                    </button>
                </p>
            </form>
            <div id="rnb-export-result"></div>
        </div>

        <div class="rnb-export-section">
            <h3><?php esc_html_e('Export Products & Inventories', 'redq-rental'); ?></h3>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('rnb_export_product', 'rnb_export_product_nonce'); ?>
                <input type="hidden" name="action" value="rnb_export_products_csv" />
                <p class="submit">
                    <button type="submit" class="button">
                        <?php esc_html_e('Export Products (CSV)', 'redq-rental'); ?>
                    </button>
                </p>
            </form>
        </div>

        <div class="rnb-export-section">
            <h3><?php esc_html_e('Export Inventories Only', 'redq-rental'); ?></h3>
            <form id="rnb-inventory-export-form">
                <?php wp_nonce_field('rnb_export_import_nonce', 'nonce'); ?>
                <p class="submit">
                    <button type="submit" class="button" id="rnb-export-inventory-btn">
                        <?php esc_html_e('Export Inventories (CSV)', 'redq-rental'); ?>
                    </button>
                </p>
            </form>
            <div id="rnb-inventory-export-result"></div>
        </div>
        <?php
    }

    /**
     * Render Import Tab
     */
    private function render_import_tab() {
        ?>
        <h3><?php echo esc_html__( 'Import RNB Settings', 'redq-rental' ); ?></h3>
        <div id="rnb-ie-status" class="notice" style="display:none; margin: 10px 0; padding: 10px;"></div>
        <form id="rnb-import-settings-form" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field( 'rnb_import_settings', 'rnb_import_settings_nonce' ); ?>
            <input type="file" name="rnb_import_settings_file" accept=".json,.csv" required>
            <button type="submit" name="rnb_import_settings_action" value="settings" class="button button-primary" id="rnb-import-settings-btn">
                <?php echo esc_html__( 'Import Settings', 'redq-rental' ); ?>
            </button>
            <p class="description"><?php echo esc_html__( 'Upload a previously exported RnB settings JSON file. Only plugin options will be imported (keys prefixed with rnb_).', 'redq-rental' ); ?></p>
        </form>
        <div id="rnb-settings-import-result"></div>
        <hr>
        <h3><?php echo esc_html__( 'Import Products', 'redq-rental' ); ?></h3>
        <form method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
            <?php wp_nonce_field( 'rnb_import_product', 'rnb_import_product_nonce' ); ?>
            <input type="hidden" name="action" value="rnb_import_products_csv" />
            <input type="file" name="rnb_import_product_file" accept=".csv" required>
            <button type="submit" class="button">
                <?php echo esc_html__( 'Import Products (CSV)', 'redq-rental' ); ?>
            </button>
        </form>
        <hr>
        <h3><?php echo esc_html__( 'Import Inventories Only', 'redq-rental' ); ?></h3>
        <form id="rnb-inventory-import-form" enctype="multipart/form-data">
            <?php wp_nonce_field('rnb_export_import_nonce', 'nonce'); ?>
            <input type="file" name="rnb_inventory_file" accept=".csv" required>
            <button type="submit" class="button" id="rnb-import-inventory-btn">
                <?php echo esc_html__( 'Import Inventories (CSV)', 'redq-rental' ); ?>
            </button>
        </form>
        <div id="rnb-inventory-import-result"></div>
        <?php
    }

    /**
     * Handle Export/Import Actions (stub for now)
     */
    public function handle_export_import_actions() {
        // Export handlers
        if ( isset( $_POST['rnb_export_action'] ) ) {
            $action = sanitize_text_field( wp_unslash( $_POST['rnb_export_action'] ) );
            switch ( $action ) {
                case 'settings':
                    // TODO: Implement export settings logic
                    break;
                case 'product':
                    // handled via admin-post to stream file
                    break;
                case 'inventory':
                    // TODO: Implement export inventory logic
                    break;
            }
        }

        // Import handlers
        if ( isset( $_POST['rnb_import_action'] ) ) {
            $action = sanitize_text_field( wp_unslash( $_POST['rnb_import_action'] ) );
            switch ( $action ) {
                case 'settings':
                    // TODO: Implement import settings logic
                    break;
                case 'product':
                    // handled via admin-post
                    break;
                case 'inventory':
                    // TODO: Implement import inventory logic
                    break;
            }
        }
    }

    /**
     * Export all redq_rental products with meta and attached inventory data as CSV
     */
    public function handle_export_products_csv() {
        if ( ! current_user_can('manage_woocommerce') ) {
            wp_die( esc_html__('You do not have permission to export.', 'redq-rental') );
        }
        if ( ! isset($_POST['rnb_export_product_nonce']) || ! wp_verify_nonce( $_POST['rnb_export_product_nonce'], 'rnb_export_product' ) ) {
            wp_die( esc_html__('Security check failed.', 'redq-rental') );
        }

        // Fetch all products; we'll filter by product type at runtime.
        $args = [
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'any',
            'fields'         => 'ids',
            'no_found_rows'  => true,
        ];

        $query = new \WP_Query($args);
        if ( empty($query->posts) ) {
            wp_safe_redirect( add_query_arg(['page' => 'rnb_export_import', 'tab' => 'export', 'rnb_ie_notice' => rawurlencode(esc_html__('No products found to export.', 'redq-rental'))], admin_url('admin.php')) );
            exit;
        }

        $products = [];
        foreach ( $query->posts as $product_id_loop ) {
            $product = wc_get_product($product_id_loop);
            if ( ! $product || $product->get_type() !== 'redq_rental' ) {
                continue;
            }

            $meta = get_post_meta($product_id_loop);
            // Flatten meta (take first value where single)
            $flat_meta = [];
            foreach ($meta as $k => $v) {
                $flat_meta[$k] = is_array($v) ? ( count($v) === 1 ? maybe_unserialize($v[0]) : maybe_serialize(array_map('maybe_unserialize', $v)) ) : $v;
            }

            // Attached inventory IDs via helper
            $inventory_ids = function_exists('rnb_get_product_inventory_id') ? rnb_get_product_inventory_id($product_id_loop) : [];

            // Collect inventory data
            $inventories = [];
            if ( ! empty($inventory_ids) ) {
                foreach ($inventory_ids as $inv_id) {
                    $inv_meta = get_post_meta($inv_id);
                    $flat_inv_meta = [];
                    foreach ($inv_meta as $ik => $iv) {
                        $flat_inv_meta[$ik] = is_array($iv) ? ( count($iv) === 1 ? maybe_unserialize($iv[0]) : maybe_serialize(array_map('maybe_unserialize', $iv)) ) : $iv;
                    }

                    // Collect taxonomy terms with term meta per inventory
                    $tax_map = [];
                    if ( function_exists('rnb_get_inventory_taxonomies') ) {
                        $tax_defs = rnb_get_inventory_taxonomies();
                        $taxonomies = is_array($tax_defs) ? array_map(function($t){ return $t['taxonomy']; }, $tax_defs) : [];
                        foreach ($taxonomies as $tax) {
                            $term_objs = wp_get_post_terms($inv_id, $tax, ['fields' => 'all']);
                            if ( is_wp_error($term_objs) || empty($term_objs) ) { continue; }
                            $tax_map[$tax] = [];
                            foreach ($term_objs as $term) {
                                $term_meta_all = get_term_meta($term->term_id);
                                $flat_term_meta = [];
                                foreach ($term_meta_all as $tmk => $tmv) {
                                    $flat_term_meta[$tmk] = is_array($tmv) ? ( count($tmv) === 1 ? maybe_unserialize($tmv[0]) : maybe_serialize(array_map('maybe_unserialize', $tmv)) ) : $tmv;
                                }
                                $tax_map[$tax][] = [
                                    'term_id' => (int) $term->term_id,
                                    'slug'    => $term->slug,
                                    'name'    => $term->name,
                                    'meta'    => $flat_term_meta,
                                ];
                            }
                        }
                    }

                    $inventories[] = [
                        'inventory_id'    => $inv_id,
                        'inventory_title' => get_the_title($inv_id),
                        'meta'            => $flat_inv_meta,
                        'terms'           => $tax_map,
                    ];
                }
            }

            $products[] = [
                'product_id'       => $product_id_loop,
                'product_sku'      => $product->get_sku(),
                'product_name'     => get_the_title($product_id_loop),
                'product_status'   => get_post_status($product_id_loop),
                'product_meta'     => wp_json_encode($flat_meta),
                'inventory_ids'    => implode('|', $inventory_ids),
                'inventory_payload'=> wp_json_encode($inventories),
            ];
        }

        // Output CSV
        if (! headers_sent()) {
            nocache_headers();
            header('Content-Type: text/csv; charset=' . get_option('blog_charset'));
            header('Content-Disposition: attachment; filename=rnb-products-export-' . date('Ymd-His') . '.csv');
        }

        $out = fopen('php://output', 'w');
        if ($out === false) {
            wp_die( esc_html__('Failed to open output stream.', 'redq-rental') );
        }
        // Header
        fputcsv($out, ['product_id','product_sku','product_name','product_status','product_meta','inventory_ids','inventory_payload']);
        foreach ($products as $row) {
            fputcsv($out, $row);
        }
        fflush($out);
        fclose($out);
        exit;
    }

    /**
     * Import products CSV and create/update inventories and mapping
     */
    public function handle_import_products_csv() {
        if ( ! current_user_can('manage_woocommerce') ) {
            wp_die( esc_html__('You do not have permission to import.', 'redq-rental') );
        }
        if ( ! isset($_POST['rnb_import_product_nonce']) || ! wp_verify_nonce( $_POST['rnb_import_product_nonce'], 'rnb_import_product' ) ) {
            wp_die( esc_html__('Security check failed.', 'redq-rental') );
        }
        if ( ! isset($_FILES['rnb_import_product_file']) || $_FILES['rnb_import_product_file']['error'] !== UPLOAD_ERR_OK ) {
            wp_die( esc_html__('CSV upload failed.', 'redq-rental') );
        }

        $file = fopen($_FILES['rnb_import_product_file']['tmp_name'], 'r');
        if ( ! $file ) {
            wp_die( esc_html__('Unable to read CSV.', 'redq-rental') );
        }

        $header = fgetcsv($file);
        $expected = ['product_id','product_sku','product_name','product_status','product_meta','inventory_ids','inventory_payload'];
        if ( array_map('trim', $header) !== $expected ) {
            fclose($file);
            wp_die( esc_html__('Invalid CSV header.', 'redq-rental') );
        }

        global $wpdb;
        $pivot_table = $wpdb->prefix . 'rnb_inventory_product';
        $imported = 0;
        while (($data = fgetcsv($file)) !== false) {
            list($product_id, $sku, $name, $status, $product_meta_json, $inventory_ids_str, $inventory_payload_json) = $data;

            $product_id = absint($product_id);
            $product_exists = $product_id && get_post($product_id);

            // Create or update product
            $postarr = [
                'ID'          => $product_exists ? $product_id : 0,
                'post_type'   => 'product',
                'post_title'  => $name,
                'post_status' => $status ?: 'publish',
            ];
            if ( $product_exists ) {
                wp_update_post($postarr);
            } else {
                $product_id = wp_insert_post($postarr);
            }
            if ( is_wp_error($product_id) || ! $product_id ) {
                continue;
            }

            // Ensure product type redq_rental
            $product = wc_get_product($product_id);
            if ( ! $product ) {
                $product = new \WC_Product_Simple($product_id);
            }
            wp_set_object_terms($product_id, 'redq_rental', 'product_type');
            if ( ! empty($sku) ) {
                wc_update_product_stock_status($product_id, 'instock');
                update_post_meta($product_id, '_sku', $sku);
            }

            // Apply product meta
            $product_meta = json_decode($product_meta_json, true);
            if ( is_array($product_meta) ) {
                foreach ($product_meta as $mk => $mv) {
                    update_post_meta($product_id, $mk, $mv);
                }
            }

            // Inventories: create/update and map
            $inventory_payload = json_decode($inventory_payload_json, true);
            $new_inventory_ids = [];
            if ( is_array($inventory_payload) ) {
                foreach ($inventory_payload as $inv) {
                    $inv_id = isset($inv['inventory_id']) ? absint($inv['inventory_id']) : 0;
                    $inv_title = isset($inv['inventory_title']) ? $inv['inventory_title'] : ('Inventory for #' . $product_id);
                    $inv_post = [
                        'ID'          => ( get_post_type($inv_id) === 'inventory' ? $inv_id : 0 ),
                        'post_type'   => 'inventory',
                        'post_title'  => $inv_title,
                        'post_status' => 'publish',
                    ];
                    if ( $inv_post['ID'] ) {
                        $inv_id = wp_update_post($inv_post);
                    } else {
                        $inv_id = wp_insert_post($inv_post);
                    }
                    if ( is_wp_error($inv_id) || ! $inv_id ) {
                        continue;
                    }
                    // Apply inventory meta
                    if ( isset($inv['meta']) && is_array($inv['meta']) ) {
                        foreach ($inv['meta'] as $ik => $iv) {
                            update_post_meta($inv_id, $ik, $iv);
                        }
                    } else {
                        // Backward compatibility with earlier export payloads without 'meta' wrapper
                        foreach ($inv as $ik => $iv) {
                            if ( in_array($ik, ['inventory_id','inventory_title','terms'], true) ) { continue; }
                            update_post_meta($inv_id, $ik, $iv);
                        }
                    }

                    // Apply taxonomy terms and their term meta
                    if ( isset($inv['terms']) && is_array($inv['terms']) ) {
                        foreach ($inv['terms'] as $tax => $terms ) {
                            if ( empty($terms) || ! taxonomy_exists($tax) ) { continue; }
                            $term_ids = [];
                            foreach ($terms as $t ) {
                                $term_id = 0;
                                // Try to find term by ID first
                                if ( isset($t['term_id']) && term_exists((int) $t['term_id'], $tax) ) {
                                    $term_id = (int) $t['term_id'];
                                } else {
                                    // Fallback: by slug or name
                                    $by_slug = isset($t['slug']) ? get_term_by('slug', sanitize_title($t['slug']), $tax) : false;
                                    $by_name = (!$by_slug && isset($t['name'])) ? get_term_by('name', $t['name'], $tax) : false;
                                    if ( $by_slug ) { $term_id = (int) $by_slug->term_id; }
                                    if ( ! $term_id && $by_name ) { $term_id = (int) $by_name->term_id; }
                                    if ( ! $term_id && isset($t['name']) ) {
                                        $created = wp_insert_term($t['name'], $tax, [ 'slug' => isset($t['slug']) ? $t['slug'] : '' ]);
                                        if ( ! is_wp_error($created) ) { $term_id = (int) $created['term_id']; }
                                    }
                                }
                                if ( $term_id ) {
                                    $term_ids[] = $term_id;
                                    if ( isset($t['meta']) && is_array($t['meta']) ) {
                                        foreach ($t['meta'] as $mk => $mv) {
                                            update_term_meta($term_id, $mk, $mv);
                                        }
                                    }
                                }
                            }
                            if ( ! empty($term_ids) ) {
                                wp_set_object_terms($inv_id, $term_ids, $tax, false);
                            }
                        }
                    }
                    // Normalize pricing meta and clear caches so price works immediately
                    $this->normalize_inventory_pricing_meta((int) $inv_id);
                    // Trigger save_post hook to ensure all hooks run
                    do_action('save_post', $inv_id, get_post($inv_id));
                    do_action('save_post_inventory', $inv_id, get_post($inv_id), true);
                    
                    // Force update the inventory post to trigger all WordPress mechanisms
                    $inventory_post = get_post($inv_id);
                    if ($inventory_post) {
                        wp_update_post([
                            'ID' => $inv_id,
                            'post_title' => $inventory_post->post_title,
                            'post_content' => $inventory_post->post_content,
                            'post_status' => $inventory_post->post_status
                        ]);
                    }
                    
                    $new_inventory_ids[] = $inv_id;
                }
            }

            // Map product <-> inventories (reset mapping)
            if ( ! empty($new_inventory_ids) ) {
                // Delete existing
                $wpdb->delete($pivot_table, ['product' => $product_id]);
                foreach ($new_inventory_ids as $nid) {
                    $wpdb->insert($pivot_table, ['inventory' => $nid, 'product' => $product_id]);
                }
            }

            $imported++;
        }
        fclose($file);

        wp_safe_redirect( add_query_arg(['page' => 'rnb_export_import', 'tab' => 'import', 'rnb_ie_notice' => rawurlencode(sprintf(esc_html__('%d products imported.', 'redq-rental'), $imported))], admin_url('admin.php')) );
        exit;
    }

    /**
     * AJAX handler for inventory CSV export
     */
    public function handle_export_inventory_csv() {
        // Debug logging
        error_log('RnB Debug: Inventory export started');
        
        if (!check_ajax_referer('rnb_export_import_nonce', 'nonce', false)) {
            error_log('RnB Debug: Nonce check failed');
            wp_send_json_error(['message' => esc_html__('Security check failed.', 'redq-rental')]);
        }
        
        if (!current_user_can('manage_woocommerce')) {
            error_log('RnB Debug: Insufficient permissions');
            wp_send_json_error(['message' => esc_html__('Insufficient permissions.', 'redq-rental')]);
        }
        
        error_log('RnB Debug: Getting inventory posts');
        
        // Get all inventory posts
        $inventories = get_posts([
            'post_type' => 'inventory',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ]);
        
        error_log('RnB Debug: Found ' . count($inventories) . ' inventories');
        
        if (empty($inventories)) {
            error_log('RnB Debug: No inventories found');
            wp_send_json_error(['message' => esc_html__('No inventories found to export.', 'redq-rental')]);
        }
        
        $csv_data = [];
        $csv_data[] = [
            'inventory_id', 'inventory_title', 'inventory_status', 'inventory_meta', 'inventory_terms'
        ];
        
        foreach ($inventories as $inventory) {
            $inventory_id = $inventory->ID;
            
            // Get all inventory meta
            $inventory_meta = get_post_meta($inventory_id);
            $flattened_inventory_meta = [];
            foreach ($inventory_meta as $key => $value) {
                $flattened_inventory_meta[$key] = maybe_unserialize($value[0]);
            }
            
            // Get all inventory terms and their meta
            $inventory_terms = [];
            $taxonomies = rnb_get_inventory_taxonomies();
            foreach ($taxonomies as $tax_info) {
                $terms = get_the_terms($inventory_id, $tax_info['taxonomy']);
                if (!is_wp_error($terms) && !empty($terms)) {
                    $term_data = [];
                    foreach ($terms as $term) {
                        $term_meta = get_term_meta($term->term_id);
                        $flattened_term_meta = [];
                        foreach ($term_meta as $meta_key => $meta_value) {
                            $flattened_term_meta[$meta_key] = maybe_unserialize($meta_value[0]);
                        }
                        $term_data[] = [
                            'term_id' => $term->term_id,
                            'slug' => $term->slug,
                            'name' => $term->name,
                            'meta' => $flattened_term_meta
                        ];
                    }
                    $inventory_terms[$tax_info['taxonomy']] = $term_data;
                }
            }
            
            $csv_data[] = [
                $inventory_id,
                $inventory->post_title,
                $inventory->post_status,
                json_encode($flattened_inventory_meta),
                json_encode($inventory_terms)
            ];
        }
        
        error_log('RnB Debug: Generated CSV data with ' . count($csv_data) . ' rows');
        
        // Generate CSV content
        $csv_content = '';
        foreach ($csv_data as $row) {
            $csv_content .= '"' . implode('","', array_map(function($field) {
                return str_replace('"', '""', (string) $field);
            }, $row)) . '"' . "\n";
        }
        
        error_log('RnB Debug: CSV content length: ' . strlen($csv_content));
        
        // Send CSV as download
        $filename = 'inventory-export-' . date('Y-m-d-H-i-s') . '.csv';
        
        error_log('RnB Debug: Sending success response');
        
        wp_send_json_success([
            'csv_content' => $csv_content,
            'filename' => $filename
        ]);
    }

    /**
     * AJAX handler for inventory CSV import
     */
    public function handle_import_inventory_csv() {
        check_ajax_referer('rnb_export_import_nonce', 'nonce');
        
        if (!current_user_can('manage_woocommerce')) {
            wp_send_json_error(['message' => esc_html__('Insufficient permissions.', 'redq-rental')]);
        }
        
        if (!isset($_FILES['rnb_inventory_file']) || $_FILES['rnb_inventory_file']['error'] !== UPLOAD_ERR_OK) {
            wp_send_json_error(['message' => esc_html__('File upload failed.', 'redq-rental')]);
        }
        
        $file = $_FILES['rnb_inventory_file'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if ($file_ext !== 'csv') {
            wp_send_json_error(['message' => esc_html__('Invalid file format. Please upload a CSV file.', 'redq-rental')]);
        }
        
        // Read CSV file
        $csv_data = [];
        if (($handle = fopen($file['tmp_name'], 'r')) !== false) {
            $headers = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $csv_data[] = array_combine($headers, $data);
            }
            fclose($handle);
        }
        
        if (empty($csv_data)) {
            wp_send_json_error(['message' => esc_html__('No data found in CSV file.', 'redq-rental')]);
        }
        
        $imported = 0;
        $errors = [];
        
        foreach ($csv_data as $row) {
            try {
                $result = $this->import_single_inventory($row);
                if ($result['success']) {
                    $imported++;
                } else {
                    $errors[] = $result['message'];
                }
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }
        
        $message = sprintf(esc_html__('%d inventories imported successfully.', 'redq-rental'), $imported);
        if (!empty($errors)) {
            $message .= ' ' . sprintf(esc_html__('%d errors occurred.', 'redq-rental'), count($errors));
        }
        
        wp_send_json_success([
            'message' => $message,
            'imported' => $imported,
            'errors' => $errors
        ]);
    }
    
    /**
     * Import a single inventory from CSV row
     */
    private function import_single_inventory($row) {
        // Extract inventory data
        $inventory_id = intval($row['inventory_id'] ?? 0);
        $inventory_title = sanitize_text_field($row['inventory_title'] ?? '');
        $inventory_status = sanitize_text_field($row['inventory_status'] ?? 'publish');
        $inventory_meta = json_decode($row['inventory_meta'] ?? '{}', true);
        $inventory_terms = json_decode($row['inventory_terms'] ?? '{}', true);
        
        if (!$inventory_id || !$inventory_title) {
            return ['success' => false, 'message' => 'Invalid inventory data'];
        }
        
        // Update or create inventory
        $inventory_data = [
            'ID' => $inventory_id,
            'post_title' => $inventory_title,
            'post_status' => $inventory_status,
            'post_type' => 'inventory'
        ];
        
        $updated_inventory_id = wp_update_post($inventory_data);
        if (is_wp_error($updated_inventory_id)) {
            return ['success' => false, 'message' => 'Failed to update inventory: ' . $updated_inventory_id->get_error_message()];
        }
        
        // Update inventory meta
        if (is_array($inventory_meta)) {
            foreach ($inventory_meta as $meta_key => $meta_value) {
                update_post_meta($updated_inventory_id, $meta_key, $meta_value);
            }
        }
        
        // Process inventory terms
        if (is_array($inventory_terms)) {
            foreach ($inventory_terms as $taxonomy => $terms_data) {
                if (is_array($terms_data)) {
                    $term_ids = [];
                    foreach ($terms_data as $term_data) {
                        $term_id = intval($term_data['term_id'] ?? 0);
                        $term_slug = sanitize_title($term_data['slug'] ?? '');
                        $term_name = sanitize_text_field($term_data['name'] ?? '');
                        $term_meta = $term_data['meta'] ?? [];
                        
                        if ($term_id && $term_name) {
                            // Create or update term
                            $term = term_exists($term_id, $taxonomy);
                            if (!$term) {
                                $term = wp_insert_term($term_name, $taxonomy, ['slug' => $term_slug]);
                                if (!is_wp_error($term)) {
                                    $term_id = $term['term_id'];
                                }
                            }
                            
                            if ($term_id && !is_wp_error($term)) {
                                $term_ids[] = $term_id;
                                
                                // Update term meta
                                if (is_array($term_meta)) {
                                    foreach ($term_meta as $meta_key => $meta_value) {
                                        update_term_meta($term_id, $meta_key, $meta_value);
                                    }
                                }
                            }
                        }
                    }
                    
                    if (!empty($term_ids)) {
                        wp_set_object_terms($updated_inventory_id, $term_ids, $taxonomy);
                    }
                }
            }
        }
        
        // Normalize pricing meta and clear caches
        $this->normalize_inventory_pricing_meta($updated_inventory_id);
        
        // Force update the inventory post
        $inventory_post = get_post($updated_inventory_id);
        if ($inventory_post) {
            wp_update_post([
                'ID' => $updated_inventory_id,
                'post_title' => $inventory_post->post_title,
                'post_content' => $inventory_post->post_content,
                'post_status' => $inventory_post->post_status
            ]);
        }
        
        return ['success' => true, 'message' => "Successfully imported inventory: $inventory_title"];
    }

    /**
     * Ensure required pricing meta exist in correct format and clear caches
     */
    private function normalize_inventory_pricing_meta(int $inventory_id): void {
        // Defaults if missing
        $pricing_type = get_post_meta($inventory_id, 'pricing_type', true);
        if (empty($pricing_type)) {
            update_post_meta($inventory_id, 'pricing_type', 'general_pricing');
        }
        $hourly_pricing_type = get_post_meta($inventory_id, 'hourly_pricing_type', true);
        if (empty($hourly_pricing_type)) {
            update_post_meta($inventory_id, 'hourly_pricing_type', 'hourly_price');
        }
        
        // Ensure array-shaped fields are arrays and in correct format
        $array_keys = [
            'redq_daily_pricing',
            'redq_monthly_pricing', 
            'redq_day_ranges_cost',
            'redq_hourly_ranges_cost',
        ];
        
        foreach ($array_keys as $meta_key) {
            $value = get_post_meta($inventory_id, $meta_key, true);
            
            if (!empty($value)) {
                $normalized_value = null;
                
                // If it's already an array, use it
                if (is_array($value)) {
                    $normalized_value = $value;
                }
                // If it's a JSON string, decode it
                elseif (is_string($value) && (strpos($value, '{') === 0 || strpos($value, '[') === 0)) {
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $normalized_value = $decoded;
                    }
                }
                // If it's a serialized string, unserialize it
                elseif (is_string($value) && strpos($value, 'a:') === 0) {
                    $unserialized = maybe_unserialize($value);
                    if (is_array($unserialized)) {
                        $normalized_value = $unserialized;
                    }
                }
                
                // Update with normalized value if we have one
                if ($normalized_value !== null) {
                    update_post_meta($inventory_id, $meta_key, $normalized_value);
                }
            }
        }
        
        // Force numeric fields to numeric strings
        $numeric_keys = ['general_price', 'hourly_price', 'perkilo_price'];
        foreach ($numeric_keys as $meta_key) {
            $value = get_post_meta($inventory_id, $meta_key, true);
            if ($value !== '' && $value !== null && $value !== false) {
                // Convert to numeric string
                $numeric_value = is_numeric($value) ? (string) floatval($value) : '0';
                update_post_meta($inventory_id, $meta_key, $numeric_value);
            }
        }
        
        // Clear caches
        clean_post_cache($inventory_id);
        // Clear any transients that might be caching pricing data
        $this->clear_pricing_transients($inventory_id);
        
        // Debug: Log pricing data for troubleshooting
        $this->debug_pricing_data($inventory_id);
    }
    
    /**
     * Debug pricing data to help troubleshoot issues
     */
    private function debug_pricing_data(int $inventory_id): void {
        if (!defined('WP_DEBUG') || !WP_DEBUG) {
            return;
        }
        
        $pricing_keys = [
            'pricing_type',
            'hourly_pricing_type', 
            'general_price',
            'hourly_price',
            'perkilo_price',
            'redq_daily_pricing',
            'redq_monthly_pricing',
            'redq_day_ranges_cost',
            'redq_hourly_ranges_cost'
        ];
        
        $debug_data = [];
        foreach ($pricing_keys as $key) {
            $value = get_post_meta($inventory_id, $key, true);
            $debug_data[$key] = [
                'value' => $value,
                'type' => gettype($value),
                'is_array' => is_array($value),
                'is_string' => is_string($value)
            ];
        }
        
        error_log('RnB Import Debug - Inventory ' . $inventory_id . ' pricing data: ' . print_r($debug_data, true));
    }

    /**
     * Clear pricing-related transients that might be caching old data
     */
    private function clear_pricing_transients(int $inventory_id): void {
        global $wpdb;
        // Clear any transients with pricing/inventory patterns
        $patterns = [
            '_transient_bookingly_max_quantity_%',
            '_transient_rnb_%',
            '_transient_redq_%',
        ];
        foreach ($patterns as $pattern) {
            $transients = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s",
                    $pattern
                )
            );
            foreach ($transients as $transient) {
                $transient_name = str_replace('_transient_', '', $transient->option_name);
                delete_transient($transient_name);
            }
        }
    }

    public function export_settings() {
        // Check nonce
        if (!check_ajax_referer('rnb_export_import_nonce', 'nonce', false)) {
            wp_send_json_error(['message' => esc_html__('Security check failed.', 'redq-rental')]);
        }
        
        // Check permissions
        if (!current_user_can('manage_woocommerce')) {
            wp_send_json_error(['message' => esc_html__('Insufficient permissions.', 'redq-rental')]);
        }
        
        try {
            error_log('RnB Debug: Starting settings export');
            $rnb_options = $this->get_all_rnb_settings();
            error_log('RnB Debug: Found ' . count($rnb_options) . ' settings to export');
            
            if (empty($rnb_options)) {
                error_log('RnB Debug: No settings found');
                wp_send_json_error(['message' => esc_html__('No settings found to export.', 'redq-rental')]);
            }
            
            error_log('RnB Debug: Sending settings export response');
            wp_send_json_success($rnb_options);
        } catch (\Exception $e) {
            error_log('RnB Debug: Settings export error: ' . $e->getMessage());
            wp_send_json_error(['message' => esc_html__('Export failed: ', 'redq-rental') . $e->getMessage()]);
        }
    }
    function redq_rental_import_settings_ajax_handler() {
        // Verify nonce
        if (!isset($_POST['rnb_import_settings_nonce']) || !wp_verify_nonce($_POST['rnb_import_settings_nonce'], 'rnb_import_settings')) {
            wp_send_json_error(['message' => esc_html__('Security check failed.', 'redq-rental')]);
        }
        
        // Check file upload
        if (!isset($_FILES['rnb_import_settings_file']) || $_FILES['rnb_import_settings_file']['error'] !== UPLOAD_ERR_OK) {
            wp_send_json_error(['message' => esc_html__('File upload failed.', 'redq-rental')]);
        }
        
        $file = $_FILES['rnb_import_settings_file'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        // Validate file type
        if ($file_ext !== 'json' && $file_ext !== 'csv') {
            wp_send_json_error(['message' => esc_html__('Invalid file format. Please upload a JSON or CSV file.', 'redq-rental')]);
        }
        
        // Handle JSON import
        if ($file_ext === 'json') {
            $file_content = file_get_contents($file['tmp_name']);
            
            if (!$file_content) {
                wp_send_json_error(['message' => esc_html__('Could not read file.', 'redq-rental')]);
            }
            
            $settings = json_decode($file_content, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                wp_send_json_error(['message' => esc_html__('Invalid JSON file.', 'redq-rental')]);
            }
            
            // Process settings
            $imported = $this->process_imported_settings($settings);
            if ($imported) {
                wp_send_json_success(['message' => esc_html__('Settings imported successfully!', 'redq-rental')]);
            } else {
                wp_send_json_error(['message' => esc_html__('Failed to import settings.', 'redq-rental')]);
            }
        }
        
        // Handle CSV import if needed
        if ($file_ext === 'csv') {
            // Add CSV import logic here
            wp_send_json_error(['message' => esc_html__('CSV import not implemented yet.', 'redq-rental')]);
        }
        
        wp_send_json_error(['message' => esc_html__('Unknown error occurred.', 'redq-rental')]);
    }
    function process_imported_settings($settings) {
        if (!is_array($settings) || empty($settings)) {
            return false;
        }
        
        $success = true;
        
        foreach ($settings as $option_name => $option_value) {
            // Optional: Add prefix to ensure these are your plugin options
            if (strpos($option_name, 'rnb_') !== 0) {
                $option_name = 'rnb_' . $option_name;
            }
            
            // Update option in database
            $previous_value = get_option($option_name, null);
            $updated = update_option($option_name, $option_value);
            // Treat unchanged value as success as well
            if (!$updated && $previous_value !== $option_value) {
                $success = false;
            }
        }
        
        return $success;
    }
    
}
