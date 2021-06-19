<?php
/**
 * Newsletter Geek
 *
 * @package           PluginPackage
 * @author            Guilfred
 *
 * @wordpress-plugin
 * Plugin Name:       Newsletter Geek
 * Description:       Newsletter plugin.
 * Version:           1.0.3
 * Requires PHP:      7.4
 * Author:            Guilfred
 */

// If this file is called firectly, abort!!
if ( !defined('ABSPATH')) {
    die;
}

// Require once the Composer Autoload
if (file_exists(dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once  dirname( __FILE__ ) . '/vendor/autoload.php' ;
}

//Define CONSTANT
define( 'NWL_PLUGIN_NAME', 'Newsletter Geek' );
define( 'NWL_TEMPLATE_FOLDER', 'templates' );
define( 'NWL_ASSETS_FOLDER', 'assets' );
define( 'NWL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'NWL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'NWL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'WP_PHP_AJX_REQ_NONCE_SECURITY', 'keep_calm_you_are_protected_hh' );

function activatePlugin() {
    \App\core\Activation::handle();
}
register_activation_hook(__FILE__, 'activatePlugin' );
if (class_exists(\App\Init::class ) ) {
    \App\Init::registerServices();  //no need singleton
}






