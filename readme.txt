=== Integration of WooCommerce and Zoho Inventory ===
Contributors: formsintegrations
Tags: zoho inventory integration,woocommerce integration,woocommerce zoho inventory,woocommerce,wordpress integration,woocommerce integration,integration,checkout zoho inventory,woocommerce checkout,woocommerce zoho,zoho woocommerce,zoho inventory woocommerce,zoho inventory integration with woocommerce,woocommerce integration with zoho inventory,zoho integration with woocommerce,woocommerce integration with zoho
Requires at least: 4.9.0
Tested up to: 6.4.3
Requires PHP: 5.6
Stable tag: 2.8
License: GPLv2 or later

== Description ==

Visit plugin's [website](https://formsintegrations.com/woocommerce-integration-with-zoho-inventory)

This is an advanced integration plugin to connect your WooCommerce site with Zoho Inventory. When a customer complete an order through WooCommerce checkout the data will be sent to Zoho inventory. It also Import old WooCommerce order data in just one click to Zoho inventory and the rest of the work will be done automatically as per your preference.

**Check out our step-by-step tutorial on Zoho Inventory Integration with WooCommerce**

https://youtu.be/Ch_-OeClz00

# How to connect Zoho Inventory and WooCommerce?

1. Install & activate Integration of WooCommerce and Zoho Inventory plugin.
2. Click the  **Home button.**
3. From  **Zoho Inventory**  settings enter  **Integration Name**,  **Data Center**,  **Homepage URL**,  **Authorized Redirect URL**.
4. To get client Id & secret information go to  **ZOHO API CONSOLE**  =>  **Add Client**=>  **Server-based application**  =>  **Create New Client**. Register all the information and get your client ID and secret information.
5. Authorize your site.

# Organization select for WooCommerce and Zoho Inventory integration:

For mapping the fields first enter your  **‘organization name‘**  to which your Zoho Inventory account belongs. Now you can sync order details of your WooCommerce site with Zoho Inventory by mapping the fields regarding your choice. You just have to map those fields only once, after that it will be executed by this WordPress plugin automatically.

# Field Mapping Between Zoho Inventory and WooCommerce Customer:

Suppose you want to set your customer’s first name as a contact name in Zoho inventory. Then select  **‘First Name‘**  in your WooCommerce checkout field & select  **‘Contact Name‘**  in the Zoho inventory field. You can map multiple fields with Zoho Inventory fields to organize your customer information.  
  
You can set  **‘Custom value‘**  from where you can send order notes according to the placed order.

1. By default, Zoho Inventory has settings not to allow the same name for contacts. But to work with this plugin more precisely, you have to turn on that setting from the Zoho Inventory.
  
2. If you don't want your customers to get duplicated in Zoho Inventory, you must map the customer email field. So every time an order has been processed, at first, this WooCommerce plugin will check if the customer with that email already exists in Zoho inventory; if it exists, then it gets referenced to that customer; otherwise, the customer will be considered as a new one.

# Field Mapping Between WooCommerce and Zoho Inventory Customer Sales Order:

When customers place an order from your WooCommerce site a corresponding sales order is created automatically expect the  **‘Shipping Charge‘**  field. The automated fields are Items & Description, Order ID, Status, Rate, Discount & Amount. You can customize your sales order area according to your need that how you want to show your WooCommerce customer’s sales order on your Zoho Inventory account.

# Action in Zoo Inventory and WooCommerce Plugin:

**Status Complete** :  After mapping all your required fields select the necessary action **Status Complete** to the order status complete, and then click on the Save button to save your settings.

**Add Warehouse & Salesperson** :  You can select Inventory warehouse from here. Also can be added salesperson according to the sales order from the dropdown list.

**Reference Number** :  Type the custom reference number for salesorder , and then click on the Save button to save your settings.


# How to old import data from WooCommerce to Zoho Inventory?

In this area, you can set the duration, within which date you can import all data to Zoho inventory. For example, you are running a WooCoomerce site since 2019 but you have been using this plugin since 2020. Then if you set Start Date – 1/01/19, End Date – 1/01/2020, Order Status – Confirmed & also set Import Type, after clicking  **‘Import Data‘**  only mentioned data will be imported to Zoho inventory. If you want to import all the confirmed data between 2019 to 2021 then just click the ‘Import Data’ button. You can select multiple order status to import orders.

# Integration of Zoho Inventory and WooCommerce data Logs

1. All logs allow admin to see the newly created record in Zoho Inventory from WordPress.
2. If user import any old data from your WordPress site, these data will also be displayed in the log.
3. Users can sort the columns according to their preference.
4. Users can copy all the API response of Zoho Inventory sales order to clipboard.

Visit plugin's [website](https://formsintegrations.com/woocommerce-integration-with-zoho-inventory)

== Installation ==

1. Download the plugin.
2. From the WordPress Admin Panel, click on Plugins => Add New.
3. Click on Upload, so you can directly upload your plugin zip file.
4. Use the browse button to select the plugin zip file that was downloaded, and then click on Install Now.
5. Once installed, click “Activate”.

== Changelog ==

= 2.7 =
* Release Date - 27 Oct, 2024*
* Zoho API Root Endpoint updated

= 2.6 =
* Pro link changed

= 2.5 =
* Authorization redirect issue fixed

= 2.4 =
* Country codes are replaced based on zoho inventory list

= 2.3 =
* 

= 2.2 =
*Release Date - 16 February 2023*
* Added all default fields of contact
* Custom field functionality added for salesorder

= 2.1 =
*Release Date - 20 December 2022*
* Fixed Authorization

= 2.0 =
* Fixed import data issue
* Fixed customer id issue
* Fixed db log issue
* Added new toggle for integration enabled/disabled
* Improved the ux of the plugin

= 1.0.4 =
* Update: check plugin upto wordpress 5.9 & woocommerce 6.1.1

= 1.0.3 =
* icon/logo updated

= 1.0.2 =
* Fix: auto refresh woocommerce fields issue fixed

= 1.0.1 =
* contact/customer email duplicate check (if exists use that contact/customer info else create new contact/customer)
* shipping charge sent to sales order

= 1.0.0 =
* Initial release of bit_wc_zoho_inventory