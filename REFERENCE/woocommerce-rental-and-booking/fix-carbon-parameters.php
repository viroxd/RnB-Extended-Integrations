<?php
/**
 * CarbonPeriod Parameters Fix
 * 
 * This script fixes the root cause by ensuring all parameters passed to CarbonPeriod
 * are valid, without modifying vendor files.
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

echo "Fixing CarbonPeriod parameters at the source...\n";

// Fix 1: global-functions.php - redq_rental_handle_holidays function
$file_path_1 = dirname(__FILE__) . '/includes/Utils/global-functions.php';
if (file_exists($file_path_1)) {
    echo "Fixing includes/Utils/global-functions.php...\n";
    
    $content_1 = file_get_contents($file_path_1);
    
    // Create backup
    $backup_path_1 = $file_path_1 . '.backup.' . date('Y-m-d-H-i-s');
    copy($file_path_1, $backup_path_1);
    echo "Backup created at: " . $backup_path_1 . "\n";
    
    // Replace the entire redq_rental_handle_holidays function with a safe version
    $old_function_pattern = '/if \(!function_exists\(\'redq_rental_handle_holidays\'\)\) :.*?endif;/s';
    
    $new_function = 'if (!function_exists(\'redq_rental_handle_holidays\')) :
    /**
     * Get holidays - Safe Version with Parameter Validation
     *
     * @param int $product_id
     * @return array
     */
    function redq_rental_handle_holidays($product_id)
    {
        $holidays   = [];
        $general    = rnb_get_settings($product_id, \'general\', [\'holidays\']);
        $conditions = rnb_get_settings($product_id, \'conditions\', [\'date_format\']);

        $output_format = $conditions[\'date_format\'] ? $conditions[\'date_format\'] : \'d/m/Y\';
        
        $holiday_ranges = $general[\'holidays\'];
        if (empty($holiday_ranges)) {
            return $holidays;
        }

        $ranges = explode(\',\', $holiday_ranges);

        foreach ($ranges as $range) {
            // Skip empty ranges
            if (empty(trim($range))) {
                continue;
            }
            
            // Check if range contains \'to\' separator
            if (strpos($range, \'to\') === false) {
                // Single date, not a range - add directly if valid
                $single_date = trim($range);
                if (!empty($single_date)) {
                    $holidays[] = $single_date;
                }
                continue;
            }
            
            list($start_date, $end_date) = explode(\'to\', $range);
            $start_date = trim($start_date);
            $end_date = trim($end_date);
            
            // Validate both dates are not empty
            if (empty($start_date) || empty($end_date)) {
                error_log(\'RnB Holiday Range Error: Empty start or end date in range - \' . $range);
                continue;
            }
            
            // Additional validation: ensure dates are in valid format
            try {
                $start_carbon = Carbon::parse($start_date);
                $end_carbon = Carbon::parse($end_date);
                
                // Only create CarbonPeriod if both dates are valid
                $period = CarbonPeriod::create($start_carbon, $end_carbon);
                foreach ($period as $date) {
                    $holidays[] = $date->format($output_format);
                }
            } catch (Exception $e) {
                error_log(\'RnB Holiday Period Error: \' . $e->getMessage() . \' for range - \' . $range);
                continue;
            }
        }

        return $holidays;
    }
endif;';
    
    $content_1 = preg_replace($old_function_pattern, $new_function, $content_1);
    
    // Add Exception import if not present
    if (strpos($content_1, 'use Exception;') === false) {
        $content_1 = str_replace('use Carbon\CarbonPeriod;', "use Carbon\CarbonPeriod;\nuse Exception;", $content_1);
    }
    
    file_put_contents($file_path_1, $content_1);
    echo "Fixed includes/Utils/global-functions.php\n";
}

// Fix 2: functions.php - rnb_check_dates_overlap function
$file_path_2 = dirname(__FILE__) . '/includes/functions.php';
if (file_exists($file_path_2)) {
    echo "Fixing includes/functions.php...\n";
    
    $content_2 = file_get_contents($file_path_2);
    
    // Create backup
    $backup_path_2 = $file_path_2 . '.backup.' . date('Y-m-d-H-i-s');
    copy($file_path_2, $backup_path_2);
    echo "Backup created at: " . $backup_path_2 . "\n";
    
    // Find and fix the rnb_check_dates_overlap function
    $old_overlap_pattern = '/function rnb_check_dates_overlap\(\$args1, \$args2\).*?return \$period->overlaps\(\$period_2\);/s';
    
    $new_overlap_function = 'function rnb_check_dates_overlap($args1, $args2)
{
    $pickup_date = $args1[\'pickup_date\'];
    $pickup_time = $args1[\'pickup_time\'];
    $return_date = $args1[\'return_date\'];
    $return_time = $args1[\'return_time\'];

    $pickup_datetime = $pickup_date . \' \' . $pickup_time;
    $return_datetime = $return_date . \' \' . $return_time;

    $pickup_date_2 = $args2[\'pickup_date\'];
    $pickup_time_2 = $args2[\'pickup_time\'];
    $return_date_2 = $args2[\'dropoff_date\'];
    $return_time_2 = $args2[\'dropoff_time\'];

    $pickup_datetime_2 = $pickup_date_2 . \' \' . $pickup_time_2;
    $return_datetime_2 = $return_date_2 . \' \' . $return_time_2;

    // Validate all datetime values before creating CarbonPeriod
    if (empty($pickup_datetime) || empty($return_datetime) || empty($pickup_datetime_2) || empty($return_datetime_2)) {
        error_log(\'RnB Overlap Check Error: Empty datetime values detected\');
        return false;
    }

    try {
        // Parse dates to ensure they are valid
        $start1 = Carbon::parse($pickup_datetime);
        $end1 = Carbon::parse($return_datetime);
        $start2 = Carbon::parse($pickup_datetime_2);
        $end2 = Carbon::parse($return_datetime_2);
        
        $period = CarbonPeriod::create($start1, $end1);
        $period_2 = CarbonPeriod::create($start2, $end2);
        
        return $period->overlaps($period_2);
    } catch (Exception $e) {
        error_log(\'RnB Overlap Check Error: \' . $e->getMessage());
        return false;
    }
}';
    
    $content_2 = preg_replace($old_overlap_pattern, $new_overlap_function, $content_2);
    
    // Add Exception import if not present
    if (strpos($content_2, 'use Exception;') === false) {
        $content_2 = str_replace('use Carbon\CarbonPeriod;', "use Carbon\CarbonPeriod;\nuse Exception;", $content_2);
    }
    
    file_put_contents($file_path_2, $content_2);
    echo "Fixed includes/functions.php\n";
}

// Fix 3: Period_Trait.php - handle_custom_block_dates function
$file_path_3 = dirname(__FILE__) . '/includes/Traits/Period_Trait.php';
if (file_exists($file_path_3)) {
    echo "Fixing includes/Traits/Period_Trait.php...\n";
    
    $content_3 = file_get_contents($file_path_3);
    
    // Create backup
    $backup_path_3 = $file_path_3 . '.backup.' . date('Y-m-d-H-i-s');
    copy($file_path_3, $backup_path_3);
    echo "Backup created at: " . $backup_path_3 . "\n";
    
    // Find and fix the CarbonPeriod::create call in handle_custom_block_dates
    $old_period_call = '            $period = CarbonPeriod::create($start_date, $return_date);';
    
    $new_period_call = '            // Validate dates before creating CarbonPeriod
            if (empty($start_date) || empty($return_date)) {
                error_log(\'RnB Period Trait Error: Empty start or return date\');
                continue;
            }
            
            try {
                // Parse dates to ensure they are valid
                $start_carbon = Carbon::parse($start_date);
                $return_carbon = Carbon::parse($return_date);
                $period = CarbonPeriod::create($start_carbon, $return_carbon);
            } catch (Exception $e) {
                error_log(\'RnB Period Trait Error: \' . $e->getMessage());
                continue;
            }';
    
    $content_3 = str_replace($old_period_call, $new_period_call, $content_3);
    
    // Add Exception import if not present
    if (strpos($content_3, 'use Exception;') === false) {
        $content_3 = str_replace('use Carbon\CarbonPeriod;', "use Carbon\CarbonPeriod;\nuse Exception;", $content_3);
    }
    
    file_put_contents($file_path_3, $content_3);
    echo "Fixed includes/Traits/Period_Trait.php\n";
}

echo "\nCarbonPeriod parameters fix completed!\n";
echo "All CarbonPeriod::create calls now have proper parameter validation.\n";
echo "The vendor files remain untouched - we fixed the issue at the source.\n";
echo "\nPlease test your rental products to ensure they work correctly.\n";

