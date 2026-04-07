<?php
/**
 * PHP Compatibility Fix Script for WooCommerce Rental and Booking
 * 
 * This script helps fix PHP syntax errors by reinstalling dependencies
 * with the correct PHP version constraints.
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

// Check current PHP version
$current_php_version = phpversion();
echo "Current PHP Version: " . $current_php_version . "\n";

// Check if PHP version is compatible
if (version_compare($current_php_version, '7.4', '<')) {
    echo "ERROR: PHP 7.4 or higher is required. Current version: " . $current_php_version . "\n";
    echo "Please upgrade your PHP version or contact your hosting provider.\n";
    exit(1);
}

// Check if composer is available
$composer_path = dirname(__FILE__) . '/composer.phar';
if (!file_exists($composer_path)) {
    echo "Composer not found. Downloading composer.phar...\n";
    
    // Download composer.phar
    $composer_url = 'https://getcomposer.org/composer.phar';
    $composer_content = file_get_contents($composer_url);
    
    if ($composer_content === false) {
        echo "ERROR: Could not download composer.phar\n";
        exit(1);
    }
    
    file_put_contents($composer_path, $composer_content);
    chmod($composer_path, 0755);
    echo "Composer downloaded successfully.\n";
}

// Change to plugin directory
$plugin_dir = dirname(__FILE__);
chdir($plugin_dir);

// Remove existing vendor directory
if (is_dir('vendor')) {
    echo "Removing existing vendor directory...\n";
    system('rm -rf vendor');
}

// Remove composer.lock
if (file_exists('composer.lock')) {
    echo "Removing composer.lock...\n";
    unlink('composer.lock');
}

// Install dependencies with PHP 7.4 platform constraint
echo "Installing dependencies with PHP 7.4 compatibility...\n";
$command = 'php composer.phar install --no-dev --optimize-autoloader --platform=php:7.4';
$output = shell_exec($command . ' 2>&1');

if ($output === null) {
    echo "ERROR: Failed to install dependencies\n";
    exit(1);
}

echo "Dependencies installed successfully!\n";
echo "Output:\n" . $output . "\n";

// Verify installation
if (is_dir('vendor')) {
    echo "SUCCESS: Vendor directory created successfully.\n";
    
    // Check for the problematic file
    $problematic_file = 'vendor/symfony/translation-contracts/TranslatorTrait.php';
    if (file_exists($problematic_file)) {
        echo "Checking for PHP 8.0+ syntax in TranslatorTrait.php...\n";
        
        $content = file_get_contents($problematic_file);
        if (strpos($content, 'match (') !== false) {
            echo "WARNING: File still contains PHP 8.0+ match syntax.\n";
            echo "This might still cause issues on older PHP versions.\n";
        } else {
            echo "SUCCESS: No PHP 8.0+ syntax found in TranslatorTrait.php\n";
        }
    }
} else {
    echo "ERROR: Vendor directory was not created.\n";
    exit(1);
}

echo "\nPHP compatibility fix completed!\n";
echo "Please test your plugin now.\n";
