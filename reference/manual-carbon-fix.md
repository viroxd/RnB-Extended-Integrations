# Manual CarbonPeriod Fix (Without Modifying Vendor Files)

## Problem
The CarbonPeriod error occurs because invalid parameters (like empty strings) are being passed to the Carbon library. Since vendor files are auto-generated, we need to fix the issue at the source where the parameters are being passed.

## Solution: Fix Parameters at the Source

### Fix 1: global-functions.php - redq_rental_handle_holidays function

**File:** `/wp-content/plugins/woocommerce-rental-and-booking/includes/Utils/global-functions.php`

**Find this function (around line 1307):**
```php
if (!function_exists('redq_rental_handle_holidays')) :
    function redq_rental_handle_holidays($product_id)
    {
        $holidays   = [];
        $general    = rnb_get_settings($product_id, 'general', ['holidays']);
        $conditions = rnb_get_settings($product_id, 'conditions', ['date_format']);

        $output_format = $conditions['date_format'] ? $conditions['date_format'] : 'd/m/Y';
        
        $holiday_ranges = $general['holidays'];
        if (empty($holiday_ranges)) {
            return $holidays;
        }

        $ranges = explode(',', $holiday_ranges);

        foreach ($ranges as $range) {
            list($start_date, $end_date) = explode('to', $range);
            $start_date = trim($start_date);
            $end_date = trim($end_date);
            $period = CarbonPeriod::create($start_date, $end_date);
            foreach ($period as $date) {
                $holidays[] = $date->format($output_format);
            }
        }

        return $holidays;
    }
endif;
```

**Replace with this safe version:**
```php
if (!function_exists('redq_rental_handle_holidays')) :
    function redq_rental_handle_holidays($product_id)
    {
        $holidays   = [];
        $general    = rnb_get_settings($product_id, 'general', ['holidays']);
        $conditions = rnb_get_settings($product_id, 'conditions', ['date_format']);

        $output_format = $conditions['date_format'] ? $conditions['date_format'] : 'd/m/Y';
        
        $holiday_ranges = $general['holidays'];
        if (empty($holiday_ranges)) {
            return $holidays;
        }

        $ranges = explode(',', $holiday_ranges);

        foreach ($ranges as $range) {
            // Skip empty ranges
            if (empty(trim($range))) {
                continue;
            }
            
            // Check if range contains 'to' separator
            if (strpos($range, 'to') === false) {
                // Single date, not a range - add directly if valid
                $single_date = trim($range);
                if (!empty($single_date)) {
                    $holidays[] = $single_date;
                }
                continue;
            }
            
            list($start_date, $end_date) = explode('to', $range);
            $start_date = trim($start_date);
            $end_date = trim($end_date);
            
            // Validate both dates are not empty
            if (empty($start_date) || empty($end_date)) {
                error_log('RnB Holiday Range Error: Empty start or end date in range - ' . $range);
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
                error_log('RnB Holiday Period Error: ' . $e->getMessage() . ' for range - ' . $range);
                continue;
            }
        }

        return $holidays;
    }
endif;
```

**Add this import at the top of the file (after the Carbon imports):**
```php
use Exception;
```

### Fix 2: functions.php - rnb_check_dates_overlap function

**File:** `/wp-content/plugins/woocommerce-rental-and-booking/includes/functions.php`

**Find this function (around line 303):**
```php
function rnb_check_dates_overlap($args1, $args2)
{
    $pickup_date = $args1['pickup_date'];
    $pickup_time = $args1['pickup_time'];
    $return_date = $args1['return_date'];
    $return_time = $args1['return_time'];

    $pickup_datetime = $pickup_date . ' ' . $pickup_time;
    $return_datetime = $return_date . ' ' . $return_time;

    $pickup_date_2 = $args2['pickup_date'];
    $pickup_time_2 = $args2['pickup_time'];
    $return_date_2 = $args2['dropoff_date'];
    $return_time_2 = $args2['dropoff_time'];

    $pickup_datetime_2 = $pickup_date_2 . ' ' . $pickup_time_2;
    $return_datetime_2 = $return_date_2 . ' ' . $return_time_2;

    $period = CarbonPeriod::create($pickup_datetime, $return_datetime);
    $period_2 = CarbonPeriod::create($pickup_datetime_2, $return_datetime_2);

    return $period->overlaps($period_2);
}
```

**Replace with this safe version:**
```php
function rnb_check_dates_overlap($args1, $args2)
{
    $pickup_date = $args1['pickup_date'];
    $pickup_time = $args1['pickup_time'];
    $return_date = $args1['return_date'];
    $return_time = $args1['return_time'];

    $pickup_datetime = $pickup_date . ' ' . $pickup_time;
    $return_datetime = $return_date . ' ' . $return_time;

    $pickup_date_2 = $args2['pickup_date'];
    $pickup_time_2 = $args2['pickup_time'];
    $return_date_2 = $args2['dropoff_date'];
    $return_time_2 = $args2['dropoff_time'];

    $pickup_datetime_2 = $pickup_date_2 . ' ' . $pickup_time_2;
    $return_datetime_2 = $return_date_2 . ' ' . $return_time_2;

    // Validate all datetime values before creating CarbonPeriod
    if (empty($pickup_datetime) || empty($return_datetime) || empty($pickup_datetime_2) || empty($return_datetime_2)) {
        error_log('RnB Overlap Check Error: Empty datetime values detected');
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
        error_log('RnB Overlap Check Error: ' . $e->getMessage());
        return false;
    }
}
```

**Add this import at the top of the file (after the Carbon imports):**
```php
use Exception;
```

### Fix 3: Period_Trait.php - handle_custom_block_dates function

**File:** `/wp-content/plugins/woocommerce-rental-and-booking/includes/Traits/Period_Trait.php`

**Find this line (around line 84):**
```php
$period = CarbonPeriod::create($start_date, $return_date);
```

**Replace with this safe version:**
```php
// Validate dates before creating CarbonPeriod
if (empty($start_date) || empty($return_date)) {
    error_log('RnB Period Trait Error: Empty start or return date');
    continue;
}

try {
    // Parse dates to ensure they are valid
    $start_carbon = Carbon::parse($start_date);
    $return_carbon = Carbon::parse($return_date);
    $period = CarbonPeriod::create($start_carbon, $return_carbon);
} catch (Exception $e) {
    error_log('RnB Period Trait Error: ' . $e->getMessage());
    continue;
}
```

**Add this import at the top of the file (after the Carbon imports):**
```php
use Exception;
```

## What This Fix Does

1. **Validates Parameters:** Ensures no empty strings are passed to CarbonPeriod
2. **Parses Dates:** Uses Carbon::parse() to validate date formats before creating periods
3. **Error Handling:** Wraps CarbonPeriod creation in try-catch blocks
4. **Logging:** Logs errors for debugging without breaking the site
5. **Graceful Degradation:** Continues processing even if some dates are invalid

## Testing

After applying these fixes:

1. **Clear any caching** (if using caching plugins)
2. **Visit a rental product page** to ensure no errors occur
3. **Check the browser console** for any remaining JavaScript errors
4. **Test holiday date functionality** if you have holidays configured

## Prevention

To prevent this issue in the future:

1. **Always validate holiday date inputs** in the admin interface
2. **Use proper date formats** when configuring holidays
3. **Regularly check error logs** for similar issues
4. **Keep the plugin updated** to the latest version

This fix addresses the root cause by ensuring valid parameters are passed to the Carbon library, without modifying any vendor files.

