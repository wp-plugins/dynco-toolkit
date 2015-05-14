<?php

/*
 * Plugin Name: Dynamic Consultants Toolkit
 * Plugin URI: http://dynco.co.uk/dynco-wordpress-toolkit/
 * Description: A Toolkit for WordPress websites developed by Dynamic Consultants that has a set of custom coding functions to help better define the content management system better for clients.
 * Author: Daniel Cook, Dynamic Consultants
 * Author URI: http://dynco.co.uk/
 * License: GPL2+
 * Version: 1.0.3
 * Text Domain: dynco
 * Domain Path: /languages/
 */


define( 'DYNCO__MINIMUM_WP_VERSION', '3.9' );

define( 'DYNCO__VERSION',            '1.0' );
define( 'DYNCO_MASTER_USER',         true );
define( 'DYNCO__API_VERSION',        1 );
define( 'DYNCO__PLUGIN_DIR',         plugin_dir_path( __FILE__ ) );
define( 'DYNCO__PLUGIN_FILE',        __FILE__ );


// Include the functions
require_once( DYNCO__PLUGIN_DIR . 'class.dynco-toolkit.php' );

if ( is_admin() ) {
	require_once( DYNCO__PLUGIN_DIR . 'class.dynco-toolkit-admin.php'     );
}


// Play nice with http://wp-cli.org/
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once( DYNCO__PLUGIN_DIR . 'class.dynco-toolkit-cli.php' );
}