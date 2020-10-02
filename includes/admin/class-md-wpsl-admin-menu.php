<?php

namespace MySiteDigital\WPSiteLogs\Admin;

/**
 *
 * @class    Menu
 * @version  0.0.1
 * @package  WPSiteLogs/Classes
 * @category Admin
 * @author: MySite Digital
 */

if (!defined('ABSPATH')) {
    exit;
}

class Menu
{
    public function __construct()
    {

        \add_action('admin_menu', [$this, 'admin_menu_items']);
    }

    public function admin_menu_items()
    {
        \add_management_page(
            \__('Site Logs', 'wp-site-logs'),
            \__('Site Logs', 'wp-site-logs'),
            'manage_options',
            'site-logs',
            [$this, 'site_logs_output']
        );
    }

    public function site_logs_output()
    {
        global $wpdb;

        $table = new ListTable();
        $table->prepare_items();
        ?>
            <div class="wrap">
                <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
                <h2>
                    <?php echo \__('Site Logs', 'wp-site-logs') ?>
                </h2>
                <form id="site-logs-table" method="GET">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                    <?php $table->display() ?>
                </form>

            </div>
        <?php
    }
}

new Menu();
