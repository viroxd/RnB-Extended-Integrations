<?php
/**
 * Manual Fix for TranslatorTrait.php PHP 8.0+ Syntax
 * 
 * This script replaces the match expression with a switch statement
 * to make it compatible with PHP 7.4.
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

$file_path = dirname(__FILE__) . '/vendor/symfony/translation-contracts/TranslatorTrait.php';

if (!file_exists($file_path)) {
    echo "ERROR: TranslatorTrait.php not found at: " . $file_path . "\n";
    exit(1);
}

echo "Found TranslatorTrait.php at: " . $file_path . "\n";

// Read the file content
$content = file_get_contents($file_path);

if ($content === false) {
    echo "ERROR: Could not read file content.\n";
    exit(1);
}

// Check if the file contains match syntax
if (strpos($content, 'match (') === false) {
    echo "SUCCESS: File does not contain PHP 8.0+ match syntax.\n";
    exit(0);
}

echo "Found PHP 8.0+ match syntax. Replacing with PHP 7.4 compatible switch...\n";

// Create backup
$backup_path = $file_path . '.backup.' . date('Y-m-d-H-i-s');
if (copy($file_path, $backup_path)) {
    echo "Backup created at: " . $backup_path . "\n";
} else {
    echo "WARNING: Could not create backup.\n";
}

// Replace the match expression with a switch statement
$pattern = '/return match \(([^)]+)\) \{([^}]+)\};/s';
$replacement = 'return $this->getPluralizationRuleMatch($1, $2);';

$new_content = preg_replace($pattern, $replacement, $content);

// Add the helper method
$helper_method = '
    /**
     * Helper method to replace match expression for PHP 7.4 compatibility
     */
    private function getPluralizationRuleMatch($locale, $cases)
    {
        $number = abs($this->number);
        $locale = $locale;
        
        // Extract the locale condition
        $locale_condition = \'pt_BR\' !== $locale && \'en_US_POSIX\' !== $locale && \strlen($locale) > 3 ? substr($locale, 0, strrpos($locale, \'_\')) : $locale;
        
        // Parse the cases and convert to switch
        $cases = trim($cases);
        $lines = explode("\n", $cases);
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, \'default\') !== false) {
                continue;
            }
            
            // Extract locale codes and result
            if (preg_match(\'/([a-z_]+)\s*=>\s*(.+),?\s*$/\', $line, $matches)) {
                $locale_codes = array_map(\'trim\', explode(\',\', $matches[1]));
                $result = trim($matches[2]);
                
                foreach ($locale_codes as $code) {
                    if ($code === $locale_condition) {
                        return eval(\'return \' . $result . \';\');
                    }
                }
            }
        }
        
        return 0; // default case
    }
';

// Add the helper method before the closing brace of the class
$new_content = str_replace('}', $helper_method . "\n}", $new_content);

// Write the modified content back
if (file_put_contents($file_path, $new_content) === false) {
    echo "ERROR: Could not write modified content to file.\n";
    exit(1);
}

echo "SUCCESS: TranslatorTrait.php has been updated to be PHP 7.4 compatible.\n";
echo "The match expression has been replaced with a switch-based approach.\n";

// Verify the fix
$updated_content = file_get_contents($file_path);
if (strpos($updated_content, 'match (') === false) {
    echo "VERIFICATION: No match syntax found in updated file.\n";
} else {
    echo "WARNING: Match syntax still found in file. Manual review may be needed.\n";
}

echo "\nFix completed! Please test your plugin now.\n";
