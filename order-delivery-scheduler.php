<?php

/**
* @package TNC Plugin
**/

/**
Plugin Name: Order Delivery Scheduler
Plugin URI: https://glotelho.cm
Description: A nifty Wordpress Woocommerce plugin that helps set scheduled delivery dates for orders so that you can easily follow up on order and get reminded
Version: 1.0.0
Author: TN TNCRIC
Author URI: https://glotelho.cm
Licence: GPLv2 or later
Text Domain:  TNC_Order_Scheduler.
Domain Path: /languages
**/

//forbid direct script access
if( ! defined('ABSPATH'))
{
    die("Direct Script Access is forbiden");
}

//include composer autoload
require_once(__DIR__ . '/vendor/autoload.php');

//do my definitions here
define('TNC_SCHEDULE_PLUGIN_URL', plugins_url() . '/order-delivery-scheduler/');
define('TNC_SCHEDULE_ASSETS_URL', TNC_SCHEDULE_PLUGIN_URL . 'assets/');
define('TNC_SCHEDULE_CLASSES_URL',  'classes/');
define('TNC_SCHEDULE_PLUGIN_BASENAME', plugin_basename(__FILE__));
define("TNC_SCHEDULE_BASE_DIRECTORY", __DIR__);

//include the core class file

use TNC\Core\Scheduler;
use TNC\Base\Activation;

// Register the activation and the deactivation hooks for the plugin.
register_activation_hook(__FILE__, [Activation::class, 'activate']);
register_deactivation_hook(__FILE__, [Activation::class, 'deactivate']);


//check if woocommerce is activated.
Scheduler::register_services();

if(!class_exists('WooCommerce'))
{
    //WooCommerce plugin is active
    //register the plugin services..

}
else {
    function TNC_admin_notice__error()
    {
    	$class = 'notice notice-error';
    	$message = __( 'WooCommerce is Required to use this plugin', 'TNC_emei' );

    	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }
    add_action( 'admin_notices', 'TNC_admin_notice__error' );

}



?>
