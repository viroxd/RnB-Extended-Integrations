# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is WooCommerce Booking & Rental System (RnB), a WordPress plugin that extends WooCommerce to enable date/time-based bookings and rentals. The plugin creates a new product type (`redq_rental`) that allows selling time or date-based services like equipment rentals, accommodation bookings, or service appointments.

**Key Information:**
- Plugin Version: 18.0.8
- Text Domain: `redq-rental`
- Requires: WooCommerce 8.0.0+
- Main File: `redq-rental-and-bookings.php`
- Namespace: `REDQ_RnB`

## Development Commands

### Package Management
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies  
npm install

# Create distribution bundle (excludes dev files)
npm run bundle
```

### No Build Process
This plugin does not use a build process - assets are served directly from the `assets/` directory.

## Architecture Overview

### Plugin Structure
```
includes/
├── Admin/              # Admin interface, metaboxes, settings
├── Integrations/       # External service integrations (Google Calendar, FullCalendar)
├── Traits/             # Reusable code traits
├── Utils/              # Utility functions and helpers
├── Init.php            # Plugin initialization
├── Assets.php          # Asset management
├── Ajax.php            # AJAX handlers
├── CartHandler.php     # WooCommerce cart integration
├── Order.php           # Order management
└── functions.php       # Global functions
```

### Key Components

**Product Type System:**
- `WC_Product_Redq_Rental` extends WooCommerce's base product class
- Custom product type: `redq_rental`
- Located in `includes/class-redq-product-redq_rental.php`

**Main Plugin Class:**
- `RedQ_Rental_And_Bookings` - Main singleton class
- Handles plugin initialization, constants, and activation
- Located in root `redq-rental-and-bookings.php`

**Core Modules:**
- `Init.php` - REST API endpoints, template loading, integrations
- `Admin/AdminPage.php` - Admin interface and calendar views
- `CartHandler.php` - Custom cart behavior for rental products
- `Order.php` - Order processing and rental-specific order management

### Database & Constants
**Plugin Constants:**
- `RNB_VERSION` - Plugin version
- `RNB_PATH` - Plugin directory path
- `RNB_URL` - Plugin URL
- `RNB_ASSETS` - Assets URL
- `RNB_PACKAGE_TEMPLATE_PATH` - Template directory

### Dependencies
**PHP Dependencies (composer.json):**
- `nesbot/carbon` ^2.47 - Date/time manipulation
- `bayfrontmedia/php-array-helpers` ^1.3 - Array utilities

**Autoloading:**
- PSR-4 autoloading via composer for `includes/` directory
- Manual includes for utility files in `includes/Utils/`

### Integration Points
- **WooCommerce Integration:** Custom product type, cart handling, order processing
- **Google Calendar:** Two-way sync for bookings
- **FullCalendar:** Admin calendar interface
- **WPML:** Translation support via `wpml-config.xml`

### Template System
Templates located in `templates/` directory:
- `templates/rnb/` - Core booking templates
- `templates/single-product/add-to-cart/redq_rental.php` - Product page form
- `templates/myaccount/` - Customer account pages

### REST API
- Endpoint: `/wp-json/rnb/v1/events`
- Used for calendar event data
- Requires admin capabilities for access

### Asset Management
- CSS/JS files in `assets/` directory served directly
- No compilation/minification process
- Multiple third-party libraries included (FullCalendar, jQuery plugins)

## Key Features Architecture

**Pricing System:**
- Multiple pricing types: daily, monthly, hourly, seasonal
- Discount system with percentage or fixed amounts
- Resource and person-based pricing

**Availability Management:**
- Date blocking functionality
- Inventory management for multiple quantities
- Cancellation and re-availability handling

**Booking Flow:**
- Custom product type with date/time selection
- Pickup/return location support
- Security deposits and additional resources
- Quote request system (RFQ)