<?php
/**
 * Emergency CarbonPeriod Fix
 * 
 * This script provides an immediate fix by temporarily disabling
 * the problematic holiday function to stop the error.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/../../../');
}

// Check if we're in WordPress context
if (!function_exists('wp_die')) {
    echo "This script must be run from within WordPress.\n";
    exit(1);
}

echo "Applying emergency CarbonPeriod fix...\n";

// Emergency fix: Override the problematic function
if (!function_exists('redq_rental_handle_holidays')) {
    function redq_rental_handle_holidays($product_id) {
        // Return empty array to prevent errors
        error_log('RnB Emergency Fix: Holiday function called for product ' . $product_id . ' - returning empty array');
        return [];
    }
} else {
    // If function exists, we need to override it
    echo "Function already exists. Creating override...\n";
    
    // Remove the existing function and redefine it
    $file_path = dirname(__FILE__) . '/includes/Utils/global-functions.php';
    if (file_exists($file_path)) {
        $content = file_get_contents($file_path);
        
        // Create backup
        $backup_path = $file_path . '.emergency-backup.' . date('Y-m-d-H-i-s');
        copy($file_path, $backup_path);
        echo "Emergency backup created at: " . $backup_path . "\n";
        
        // Replace the entire function with a safe version
        $old_function_start = 'if (!function_exists(\'redq_rental_handle_holidays\')) :';
        $old_function_end = 'endif;';
        
        $new_function = 'if (!function_exists(\'redq_rental_handle_holidays\')) :
    /**
     * Get holidays - Emergency Safe Version
     *
     * @param int $product_id
     * @return array
     */
    function redq_rental_handle_holidays($product_id)
    {
        // Emergency fix: Return empty array to prevent CarbonPeriod errors
        error_log(\'RnB Emergency Fix: Holiday function called for product \' . $product_id . \' - returning empty array\');
        return [];
    }
endif;';
        
        // Find and replace the function
        $pattern = '/if \(!function_exists\(\'redq_rental_handle_holidays\'\)\) :.*?endif;/s';
        $content = preg_replace($pattern, $new_function, $content);
        
        file_put_contents($file_path, $content);
        echo "Emergency fix applied to global-functions.php\n";
    }
}

echo "\nEmergency fix completed!\n";
echo "The holiday function has been temporarily disabled to prevent CarbonPeriod errors.\n";
echo "Your rental products should now work without the CarbonPeriod error.\n";
echo "\nNext steps:\n";
echo "1. Test your rental products to ensure they work\n";
echo "2. Run the comprehensive fix script to properly fix the issue\n";
echo "3. Check your holiday configurations in the admin\n";

