<?php

/**
 * Plugin Name: WP Site Logs
 * Description:
 * Version: 1.0.0
 * Author: MySite Digital
 * Author URI: https://mysite.digital
 * Requires at least: 5.0
 * Tested up to: 5.0
 */


namespace MySiteDigital;

use MySiteDigital\WPSiteLogs\Install;

if (!defined('ABSPATH')) {

    exit; // Exit if accessed directly.

}

/**
 * Main WPSiteLogs Class.
 *
 * @class WPSiteLogs
 * @version    1.0.0
 */

final class WPSiteLogs
{

    /**
     * WPSiteLogs Constructor.
     */
    public function __construct()
    {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    /*
        *
        * Define WPSiteLogs Constants.
        */
    private function define_constants()
    {
        if (!defined('WPSL_PLUGIN_PATH')) {
            define('WPSL_PLUGIN_PATH', plugin_dir_path(__FILE__));
        }
        if (!defined('WPSL_PLUGIN_URL')) {
            define('WPSL_PLUGIN_URL', plugin_dir_url(__FILE__));
        }
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes()
    {
        include_once( WPSL_PLUGIN_PATH . 'includes/install/class-md-wpsl-install.php');
        include_once( WPSL_PLUGIN_PATH . 'includes/class-md-wpsl-logger.php');
        include_once( WPSL_PLUGIN_PATH . 'includes/admin/class-md-wpsl-admin-menu.php' );
        include_once( WPSL_PLUGIN_PATH . 'includes/admin/class-md-wpsl-admin-listtable.php' );
    }

    /**
     * Hook into actions and filters.
     */
    private function init_hooks()
    {
        \register_activation_hook(__FILE__, [ Install::class, 'create_db_table' ] );
    }
}

new WPSiteLogs();
