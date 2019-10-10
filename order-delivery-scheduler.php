<?php

/**
* @package GT Plugin
**/

/**
Plugin Name: Order Delivery Scheduler
Plugin URI: https://glotelho.cm
Description: A plugin to schedule order deliveries to easily find orders that are ready to be shipped
Version: 1.0.0
Author: TN CEDRIC
Author URI: https://glotelho.cm
Licence: GPLv2 or later
Text Domain:  TN_Order_Schedule.
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
define('GT_SCHEDULE_PLUGIN_URL', plugins_url() . '/gt_emei/');
define('GT_SCHEDULE_ASSETS_URL', GT_SCHEDULE_PLUGIN_URL . 'assets/');
define('GT_SCHEDULE_CLASSES_URL',  'classes/');
define('GT_SCHEDULE_PLUGIN_BASENAME', plugin_basename(__FILE__));
define("GT_SCHEDULE_BASE_DIRECTORY", __DIR__);

//include the core class file

use App\Core\Scheduler;
use App\Base\Activation;

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
    function gt_admin_notice__error()
    {
    	$class = 'notice notice-error';
    	$message = __( 'WooCommerce is Required to use Glotelho EMEI plugin', 'gt_emei' );

    	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }
    add_action( 'admin_notices', 'gt_admin_notice__error' );

}



?>
