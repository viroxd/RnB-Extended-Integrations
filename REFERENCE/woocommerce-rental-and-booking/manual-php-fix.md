# Manual PHP Fix for WooCommerce Rental and Booking

## Problem
The error occurs because the Symfony Translation Contracts library uses PHP 8.0+ `match` syntax, but your server is running an older PHP version.

## Quick Fix Steps

### Step 1: Check Your PHP Version
Add this to your WordPress site to check your PHP version:
```php
<?php echo phpversion(); ?>
```

### Step 2: Manual File Fix
Edit the file: `/wp-content/plugins/woocommerce-rental-and-booking/vendor/symfony/translation-contracts/TranslatorTrait.php`

**Find this code (around line 138):**
```php
return match ('pt_BR' !== $locale && 'en_US_POSIX' !== $locale && \strlen($locale) > 3 ? substr($locale, 0, strrpos($locale, '_')) : $locale) {
    'af',
    'bn',
    'bg',
    'ca',
    'da',
    'de',
    'el',
    'en',
    'en_US_POSIX',
    'eo',
    'es',
    'et',
    'eu',
    'fa',
    'fi',
    'fo',
    'fur',
    'fy',
    'gl',
    'gu',
    'ha',
    'he',
    'hu',
    'is',
    'it',
    'ku',
    'lb',
    'ml',
    'mn',
    'mr',
    'nah',
    'nb',
    'ne',
    'nl',
    'nn',
    'no',
    'oc',
    'om',
    'or',
    'pa',
    'pap',
    'ps',
    'pt',
    'so',
    'sq',
    'sv',
    'sw',
    'ta',
    'te',
    'tk',
    'ur',
    'zu' => (1 == $number) ? 0 : 1,
    'am',
    'bh',
    'fil',
    'fr',
    'gun',
    'hi',
    'hy',
    'ln',
    'mg',
    'nso',
    'pt_BR',
    'ti',
    'wa' => ($number < 2) ? 0 : 1,
    'be',
    'bs',
    'hr',
    'ru',
    'sh',
    'sr',
    'uk' => ((1 == $number % 10) && (11 != $number % 100)) ? 0 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 10) || ($number % 100 >= 20))) ? 1 : 2),
    'cs',
    'sk' => (1 == $number) ? 0 : ((($number >= 2) && ($number <= 4)) ? 1 : 2),
    'ga' => (1 == $number) ? 0 : ((2 == $number) ? 1 : 2),
    'lt' => ((1 == $number % 10) && (11 != $number % 100)) ? 0 : ((($number % 10 >= 2) && (($number % 100 < 10) || ($number % 100 >= 20))) ? 1 : 2),
    'sl' => (1 == $number % 100) ? 0 : ((2 == $number % 100) ? 1 : (((3 == $number % 100) || (4 == $number % 100)) ? 2 : 3)),
    'mk' => (1 == $number % 10) ? 0 : 1,
    'mt' => (1 == $number) ? 0 : (((0 == $number) || (($number % 100 > 1) && ($number % 100 < 11))) ? 1 : ((($number % 100 > 10) && ($number % 100 < 20)) ? 2 : 3)),
    'lv' => (0 == $number) ? 0 : (((1 == $number % 10) && (11 != $number % 100)) ? 1 : 2),
    'pl' => (1 == $number) ? 0 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 12) || ($number % 100 > 14))) ? 1 : 2),
    'cy' => (1 == $number) ? 0 : ((2 == $number) ? 1 : (((8 == $number) || (11 == $number)) ? 2 : 3)),
    'ro' => (1 == $number) ? 0 : (((0 == $number) || (($number % 100 > 0) && ($number % 100 < 20))) ? 1 : 2),
    'ar' => (0 == $number) ? 0 : ((1 == $number) ? 1 : ((2 == $number) ? 2 : ((($number % 100 >= 3) && ($number % 100 <= 10)) ? 3 : ((($number % 100 >= 11) && ($number % 100 <= 99)) ? 4 : 5)))),
    default => 0,
};
```

**Replace it with this PHP 7.4 compatible code:**
```php
$locale_condition = 'pt_BR' !== $locale && 'en_US_POSIX' !== $locale && \strlen($locale) > 3 ? substr($locale, 0, strrpos($locale, '_')) : $locale;

switch ($locale_condition) {
    case 'af':
    case 'bn':
    case 'bg':
    case 'ca':
    case 'da':
    case 'de':
    case 'el':
    case 'en':
    case 'en_US_POSIX':
    case 'eo':
    case 'es':
    case 'et':
    case 'eu':
    case 'fa':
    case 'fi':
    case 'fo':
    case 'fur':
    case 'fy':
    case 'gl':
    case 'gu':
    case 'ha':
    case 'he':
    case 'hu':
    case 'is':
    case 'it':
    case 'ku':
    case 'lb':
    case 'ml':
    case 'mn':
    case 'mr':
    case 'nah':
    case 'nb':
    case 'ne':
    case 'nl':
    case 'nn':
    case 'no':
    case 'oc':
    case 'om':
    case 'or':
    case 'pa':
    case 'pap':
    case 'ps':
    case 'pt':
    case 'so':
    case 'sq':
    case 'sv':
    case 'sw':
    case 'ta':
    case 'te':
    case 'tk':
    case 'ur':
    case 'zu':
        return (1 == $number) ? 0 : 1;
    
    case 'am':
    case 'bh':
    case 'fil':
    case 'fr':
    case 'gun':
    case 'hi':
    case 'hy':
    case 'ln':
    case 'mg':
    case 'nso':
    case 'pt_BR':
    case 'ti':
    case 'wa':
        return ($number < 2) ? 0 : 1;
    
    case 'be':
    case 'bs':
    case 'hr':
    case 'ru':
    case 'sh':
    case 'sr':
    case 'uk':
        return ((1 == $number % 10) && (11 != $number % 100)) ? 0 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 10) || ($number % 100 >= 20))) ? 1 : 2);
    
    case 'cs':
    case 'sk':
        return (1 == $number) ? 0 : ((($number >= 2) && ($number <= 4)) ? 1 : 2);
    
    case 'ga':
        return (1 == $number) ? 0 : ((2 == $number) ? 1 : 2);
    
    case 'lt':
        return ((1 == $number % 10) && (11 != $number % 100)) ? 0 : ((($number % 10 >= 2) && (($number % 100 < 10) || ($number % 100 >= 20))) ? 1 : 2);
    
    case 'sl':
        return (1 == $number % 100) ? 0 : ((2 == $number % 100) ? 1 : (((3 == $number % 100) || (4 == $number % 100)) ? 2 : 3));
    
    case 'mk':
        return (1 == $number % 10) ? 0 : 1;
    
    case 'mt':
        return (1 == $number) ? 0 : (((0 == $number) || (($number % 100 > 1) && ($number % 100 < 11))) ? 1 : ((($number % 100 > 10) && ($number % 100 < 20)) ? 2 : 3));
    
    case 'lv':
        return (0 == $number) ? 0 : (((1 == $number % 10) && (11 != $number % 100)) ? 1 : 2);
    
    case 'pl':
        return (1 == $number) ? 0 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 12) || ($number % 100 > 14))) ? 1 : 2);
    
    case 'cy':
        return (1 == $number) ? 0 : ((2 == $number) ? 1 : (((8 == $number) || (11 == $number)) ? 2 : 3));
    
    case 'ro':
        return (1 == $number) ? 0 : (((0 == $number) || (($number % 100 > 0) && ($number % 100 < 20))) ? 1 : 2);
    
    case 'ar':
        return (0 == $number) ? 0 : ((1 == $number) ? 1 : ((2 == $number) ? 2 : ((($number % 100 >= 3) && ($number % 100 <= 10)) ? 3 : ((($number % 100 >= 11) && ($number % 100 <= 99)) ? 4 : 5))));
    
    default:
        return 0;
}
```

### Step 3: Test the Fix
After making the change, test your plugin to ensure it works correctly.

## Alternative Solutions

### Option 1: Upgrade PHP (Recommended)
Contact your hosting provider to upgrade PHP to version 8.0 or higher.

### Option 2: Reinstall Dependencies
Run these commands in your plugin directory:
```bash
rm -rf vendor
rm composer.lock
composer install --platform=php:7.4
```

### Option 3: Use the Fix Scripts
Run the provided fix scripts:
1. `fix-php-compatibility.php` - Reinstalls dependencies
2. `fix-translator-trait.php` - Automatically fixes the file

## Prevention
To prevent this issue in the future:
1. Always check PHP version compatibility before installing plugins
2. Keep your server's PHP version updated
3. Use the updated composer.json with PHP version constraints
