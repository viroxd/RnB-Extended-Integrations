# WooCommerce Booking & Rental System (RnB) - Complete Documentation

## Table of Contents
1. [Overview](#overview)
2. [Installation](#installation)
3. [Initial Setup](#initial-setup)
4. [Features Overview](#features-overview)
5. [Configuration Guide](#configuration-guide)
6. [Admin Interface](#admin-interface)
7. [Product Management](#product-management)
8. [Order Management](#order-management)
9. [Integrations](#integrations)
10. [Troubleshooting](#troubleshooting)

---

## Overview

WooCommerce Booking & Rental System (RnB) is a comprehensive WordPress plugin that extends WooCommerce to enable date/time-based bookings and rentals. It transforms your WooCommerce store into a powerful rental and booking management system.

**Key Benefits:**
- Create rental/booking products with date/time selection
- Manage inventory, availability, and pricing
- Handle complex pricing structures (daily, hourly, seasonal)
- Process partial payments and deposits
- Integrate with Google Calendar and external systems
- Support multiple locations, resources, and person-based pricing

**Version:** 18.0.8  
**Requires:** WordPress 5.0+, WooCommerce 8.0.0+  
**License:** GPL-2.0

---

## Installation

### Prerequisites
- WordPress 5.0 or higher
- WooCommerce 8.0.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

### Step 1: Install WooCommerce
1. Install and activate WooCommerce from WordPress.org
2. Complete the WooCommerce setup wizard
3. Ensure WooCommerce is functioning properly

### Step 2: Install RnB Plugin
1. Download the plugin zip file
2. Navigate to **WordPress Admin > Plugins > Add New**
3. Click **Upload Plugin** and select the zip file
4. Click **Install Now** and then **Activate**

### Step 3: Verify Installation
1. Check that **RnB** appears in the admin menu
2. Navigate to **WooCommerce > Settings > RnB Settings**
3. Confirm no error messages appear

### Dependencies Installation
The plugin automatically installs required PHP dependencies via Composer:
- `nesbot/carbon` ^2.47 - Date/time manipulation
- `bayfrontmedia/php-array-helpers` ^1.3 - Array utilities

---

## Initial Setup

### 1. License Activation
1. Go to **RnB > Activate License**
2. Enter your purchase code from CodeCanyon
3. Click **Activate License**

### 2. Basic Configuration
Navigate to **WooCommerce > Settings > RnB Settings** and configure:

#### General Settings
- **Calendar Language**: Set to your preferred language (e.g., 'en', 'fr', 'de')
- **Payment Type**: Choose percentage or fixed amount for partial payments
- **Pay During Booking**: Set the amount customers pay upfront (default: 100%)
- **Shop Page Button**: Customize the button text on shop pages

#### Display Settings
- **Enable DateTime Fields**: Show date/time selection (recommended: Yes)
- **Show Pickup/Return Date/Time**: Control which fields appear
- **Enable Quantity Field**: Allow multiple item bookings
- **Show Book Now Button**: Display the main booking button

### 3. Create Your First Rental Product
1. Go to **Products > Add New**
2. Select **Product Type: Rental Product**
3. Configure basic product information
4. Set pricing in the **Rental Settings** tab
5. Configure availability and inventory
6. Publish the product

---

## Features Overview

### Pricing Plans
- **Daily Pricing**: Standard per-day rates
- **Monthly Pricing**: Extended period discounts
- **Hourly Pricing**: Minute-based charging
- **Day Range Pricing**: Different rates for different durations
- **Seasonal Pricing**: Time-of-year based rates
- **Flat Hours Configuration**: Fixed hour blocks
- **Kilometer-based Pricing**: Distance-dependent rates

### Discount System
- **Duration Discounts**: Reduced rates for longer bookings
- **Percentage or Fixed Discounts**: Flexible discount types
- **Automatic Application**: Based on booking duration

### Inventory & Availability Management
- **Multiple Quantity Support**: Track available units
- **Date Blocking**: Prevent bookings on specific dates
- **Automatic Availability**: Real-time inventory updates
- **Order Cancellation**: Automatic date re-availability

### Extra Options
- **Payable Resources**: Additional equipment/services
  - Daily, hourly, per-day, or one-time pricing
- **Person Management**: Adult/child classification
  - Payable or non-payable person types
  - Various pricing structures
- **Security Deposits**: Refundable deposits
  - Flexible calculation methods
- **Pickup/Return Locations**: Multiple location support
  - Payable or non-payable locations
- **Unlimited Attributes & Features**: Custom product properties

### Payment Systems
- **Partial Payments**: Split total cost over time
- **All WooCommerce Gateways**: Full payment integration
- **Cash on Delivery**: Offline payment support
- **Direct Bank Transfer**: Manual payment processing

### Email & Calendar Integration
- **Email Notifications**: Automated customer and admin alerts
- **Google Calendar Sync**: Two-way calendar integration
- **Full Calendar Interface**: Visual booking management

### Translation & Localization
- **Translation Ready**: Complete .pot file included
- **WPML Compatible**: Multi-language support
- **RTL Support**: Right-to-left language compatibility

---

## Configuration Guide

### General Configuration

#### Calendar Settings
```
Calendar Data Type: pre_fetched (recommended for smaller datasets)
Calendar Active Days: 365 (days calendar shows from today)
Week Start Day: Sunday/Monday (based on locale)
Language Domain: en, fr, de, etc.
```

#### Payment Configuration
```
Payment Type: percent (recommended) or fixed
Pay During Booking: 100% (full payment) or partial amount
Instance Payment: Enable for split payments
```

#### Time & Date Settings
```
Date Format: m/d/Y, d/m/Y, or Y/m/d
Time Format: 24-hours or 12-hours
Time Intervals: 30 minutes (recommended)
Allowed Times: Comma-separated list (e.g., "10:00, 12:00, 14:00")
```

### Display Configuration

#### Field Visibility
- **Pickup Date/Time**: Control date and time field display
- **Return Date/Time**: Configure return field visibility
- **Quantity Field**: Enable multi-unit bookings
- **Book Now Button**: Show/hide main booking action
- **Request Quote Button**: Enable quote requests

#### Layout Options
- **Layout One (Normal)**: Standard single-page booking
- **Layout Two (Modal)**: Multi-step modal interface

### Label Customization

#### Location Labels
```
Pickup Location Title: "Pickup Location"
Pickup Location Placeholder: "Choose pickup location"
Return Location Title: "Return Location"
Return Location Placeholder: "Choose return location"
```

#### DateTime Labels
```
Pickup DateTime Title: "Pickup Date & Time"
Pickup Date Placeholder: "Select pickup date"
Pickup Time Placeholder: "Select pickup time"
Return DateTime Title: "Return Date & Time"
Return Date Placeholder: "Select return date"
Return Time Placeholder: "Select return time"
```

#### Price Breakdown Labels
```
Duration Cost: "Duration Cost"
Resource Cost: "Resource Cost" 
Adult/Child Cost: "Adult Cost" / "Child Cost"
Deposit Amount: "Deposit Amount"
Discount Amount: "Discount Amount"
Grand Total: "Grand Total"
```

### Conditions & Validation

#### Booking Limits
```
Max Booking Days: Maximum rental duration (days)
Min Booking Days: Minimum rental duration (days)
Max Booking Hours: Maximum rental duration (hours)
Min Booking Hours: Minimum rental duration (hours)
```

#### Availability Controls
```
Initially Blocked Dates: Days blocked from today
Pre Booking Block Days: Auto-blocked days before booking
Post Booking Block Days: Auto-blocked days after booking
Pre/Post Booking Block Hours: Hour-based blocking
```

#### Business Hours
Configure daily opening/closing times:
```
Monday: 09:00 - 17:00
Tuesday: 09:00 - 17:00
...
Weekend: 10:00 - 16:00 (or custom)
```

#### Required Fields
- **Pickup Location**: Force location selection
- **Return Location**: Require return location
- **Pickup/Return Time**: Mandate time selection
- **Adult Count**: Require person specification

### Order Cancellation

#### Cancel Button Configuration
```
Enable Cancel Button: Show on My Account page
Order Types: pending, on-hold, processing
Cancellation Reason: Required or optional
Customer Note: Instructions for customers
```

#### Cancel Request Settings
```
Cancel Type: Direct cancellation or request workflow
Cancel Before By: Day or hour based restrictions
Days/Hours Before: Time limit for cancellations
```

---

## Admin Interface

### Main Menu Structure
The RnB plugin adds a comprehensive admin menu:

#### RnB Dashboard
- **License Activation**: Manage plugin license
- **Overview Statistics**: Booking and revenue summaries

#### Inventory Management
- **All Inventories**: View all rental items
- **Add New Inventory**: Create rental products
- **Inventory Categories**: Organize products

#### Order Management
- **RnB Orders**: View rental-specific orders
- **Order Calendar**: Visual booking overview
- **Quote Management**: Handle quote requests

#### Taxonomy Management
- **Resources**: Additional equipment/services
- **Categories**: Product categorization
- **Person Types**: Adult/child classifications
- **Deposits**: Security deposit options
- **Locations**: Pickup/return locations

#### Settings & Tools
- **Settings**: Global plugin configuration
- **Export/Import**: Bulk data management
- **Calendar Integration**: Google Calendar setup

### Order Management Interface

#### Order List Features
- **Rental-specific Columns**: Pickup/return dates, duration
- **Status Indicators**: Visual booking status
- **Quick Actions**: Cancel, modify, view details
- **Bulk Operations**: Multi-order management

#### Order Detail View
- **Booking Information**: Complete rental details
- **Payment Status**: Deposit and balance tracking
- **Customer Communication**: Built-in messaging
- **Modification Tools**: Date changes, cancellations

### Calendar Interface

#### Full Calendar View
- **Monthly/Weekly/Daily Views**: Multiple perspectives
- **Booking Visualization**: Color-coded bookings
- **Drag & Drop**: Move bookings (if enabled)
- **Quick Booking**: Create bookings directly

#### Filter Options
- **Product Filter**: Show specific rental items
- **Status Filter**: Filter by booking status
- **Date Range**: Custom date ranges
- **Location Filter**: Filter by pickup/return locations

---

## Product Management

### Creating Rental Products

#### Basic Setup
1. **Product Type**: Select "Rental Product"
2. **General Tab**: 
   - Product name, description
   - Featured image
   - Product gallery
3. **Inventory Tab**:
   - SKU management
   - Stock tracking (if applicable)

#### Rental Settings Tab

##### Pricing Configuration
```
Pricing Type: daily, hourly, flat_hours, day_ranges
Base Price: Starting price per unit
Seasonal Pricing: Date-based price variations
```

##### Availability Settings
```
Available Quantity: Number of units
Blocked Dates: Unavailable periods
Minimum/Maximum Duration: Booking constraints
```

##### Location Setup
```
Pickup Locations: Available pickup points
Return Locations: Available return points
Location Pricing: Additional location fees
```

##### Additional Options
```
Resources: Equipment add-ons
Person Pricing: Adult/child rates
Security Deposits: Refundable amounts
Categories: Product classifications
```

### Inventory Management

#### Stock Tracking
- **Quantity-based**: Track available units
- **Date-based**: Availability calendar
- **Real-time Updates**: Automatic inventory adjustments

#### Availability Rules
- **Date Blocking**: Manual unavailability
- **Business Hours**: Operating time restrictions
- **Holidays**: Automatic blocking
- **Maintenance Periods**: Scheduled downtime

### Pricing Strategies

#### Daily Pricing
- **Standard Rates**: Fixed daily prices
- **Weekend Premiums**: Higher weekend rates
- **Extended Stay Discounts**: Progressive discounts

#### Hourly Pricing
- **Minimum Duration**: Required booking length
- **Overtime Charges**: Additional hour rates
- **Block Pricing**: Pre-defined time blocks

#### Seasonal Pricing
- **Peak Seasons**: Higher demand periods
- **Off-Season Rates**: Discounted periods
- **Holiday Pricing**: Special event rates

---

## Order Management

### Booking Workflow

#### Customer Booking Process
1. **Product Selection**: Choose rental item
2. **Date/Time Selection**: Pick booking period
3. **Location Selection**: Choose pickup/return points
4. **Extras Selection**: Add resources, persons
5. **Payment Processing**: Complete transaction

#### Admin Order Processing
1. **Order Validation**: Verify availability
2. **Payment Confirmation**: Check payment status
3. **Booking Confirmation**: Send confirmations
4. **Calendar Updates**: Update availability

### Order Status Management

#### Standard WooCommerce Statuses
- **Pending Payment**: Awaiting payment
- **Processing**: Payment received, preparing
- **Completed**: Booking fulfilled
- **Cancelled**: Booking cancelled
- **Refunded**: Payment refunded

#### RnB-Specific Statuses
- **Confirmed**: Booking confirmed
- **In Progress**: Currently rented
- **Returned**: Item returned
- **Damaged**: Damage reported

### Payment Processing

#### Partial Payment Flow
1. **Initial Payment**: Deposit or percentage
2. **Balance Due**: Remaining amount
3. **Payment Reminders**: Automated notifications
4. **Final Settlement**: Complete payment

#### Deposit Management
- **Security Deposits**: Refundable amounts
- **Damage Charges**: Deductions from deposit
- **Refund Processing**: Automated refunds

### Order Modifications

#### Date Changes
- **Availability Check**: Verify new dates
- **Price Adjustment**: Recalculate costs
- **Confirmation**: Update bookings

#### Cancellations
- **Customer Cancellations**: Self-service options
- **Admin Cancellations**: Manual processing
- **Refund Calculations**: Policy-based refunds

---

## Integrations

### Google Calendar Integration

#### Setup Process
1. **Google API Setup**: Create project and credentials
2. **Calendar Selection**: Choose target calendar
3. **Sync Configuration**: Two-way synchronization
4. **Event Mapping**: Map booking to calendar events

#### Sync Features
- **Automatic Events**: Booking creation/updates
- **Conflict Prevention**: Availability checking
- **Event Details**: Complete booking information
- **Deletion Handling**: Cancel event management

### Email System

#### Customer Notifications
- **Booking Confirmation**: Order details and instructions
- **Payment Reminders**: Balance due notifications
- **Modification Alerts**: Change confirmations
- **Cancellation Notices**: Cancellation confirmations

#### Admin Notifications
- **New Bookings**: Order notifications
- **Payment Updates**: Payment status changes
- **Cancellation Requests**: Customer cancellations
- **System Alerts**: Error notifications

### Third-Party Integrations

#### Payment Gateways
- **All WooCommerce Gateways**: Seamless integration
- **Partial Payment Support**: Split payment processing
- **Refund Handling**: Automated refund processing

#### Multilingual Support
- **WPML Integration**: Multi-language sites
- **Translation Files**: Complete localization
- **RTL Support**: Right-to-left languages

#### Theme Compatibility
- **BeTheme Support**: Specialized integration
- **Universal Compatibility**: Works with most themes
- **Custom Styling**: Override default styles

---

## Troubleshooting

### Common Issues

#### Installation Problems
**Issue**: Plugin activation fails
**Solution**: 
- Verify WooCommerce is active
- Check PHP version (7.4+ required)
- Ensure sufficient memory (128MB+)

**Issue**: Missing features after installation
**Solution**:
- Clear cache (if using caching plugins)
- Reactivate plugin
- Check for plugin conflicts

#### Booking Issues
**Issue**: Dates not available when they should be
**Solution**:
- Check blocked dates in product settings
- Verify business hours configuration
- Review availability rules

**Issue**: Price calculations incorrect
**Solution**:
- Verify pricing configuration
- Check seasonal pricing rules
- Review discount settings

#### Calendar Problems
**Issue**: Calendar not displaying
**Solution**:
- Check JavaScript errors in browser console
- Verify calendar data type setting
- Clear browser cache

**Issue**: Google Calendar sync not working
**Solution**:
- Verify API credentials
- Check calendar permissions
- Review sync settings

### Performance Optimization

#### Large Datasets
- **Use REST API**: For large order datasets
- **Limit Calendar Range**: Reduce active days
- **Caching**: Implement caching strategies

#### Database Optimization
- **Regular Cleanup**: Remove old booking data
- **Index Optimization**: Ensure proper indexing
- **Query Optimization**: Review custom queries

### Support Resources

#### Documentation
- **Official Docs**: https://rnb-doc.vercel.app/
- **Video Tutorials**: YouTube channel
- **Knowledge Base**: Common solutions

#### Support Channels
- **Ticket System**: https://redqsupport.ticksy.com/
- **Community Forum**: User community
- **Premium Support**: Priority assistance

#### Developer Resources
- **Hooks & Filters**: Customization points
- **API Documentation**: Integration guides
- **Code Examples**: Implementation samples

---

## Advanced Configuration

### Custom Development

#### Hooks & Filters
The plugin provides numerous hooks for customization:
```php
// Modify booking form fields
add_filter('rnb_booking_form_fields', 'custom_booking_fields');

// Customize price calculation
add_filter('rnb_calculate_price', 'custom_price_calculation');

// Add custom validation
add_action('rnb_validate_booking', 'custom_booking_validation');
```

#### Template Overrides
Override plugin templates in your theme:
```
/your-theme/rnb/
  booking-content/
    booking-modal.php
    booking-summary.php
  emails/
    customer-place-quote-request.php
```

### API Integration

#### REST API Endpoints
```
GET /wp-json/rnb/v1/events - Calendar events
POST /wp-json/rnb/v1/booking - Create booking
GET /wp-json/rnb/v1/availability - Check availability
```

#### Webhook Support
Configure webhooks for external system integration:
- **Booking Created**: New booking notifications
- **Payment Updated**: Payment status changes
- **Booking Modified**: Booking change notifications

This comprehensive documentation covers all aspects of the WooCommerce Booking & Rental System. For additional support or advanced customization, consult the official documentation or contact support.