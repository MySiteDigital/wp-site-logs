<?php

namespace MySiteDigital\WPSiteLogs\Admin;

use MySiteDigital\WPSiteLogs\Logger;

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
            [$this, 'site_logs_table_output']
        );
        \add_submenu_page(
            null,
            \__('Site Log Entry', 'wp-site-logs'),
            \__('Site Log Entry', 'wp-site-logs'),
            'manage_options',
            'site_log',
            [$this, 'site_log_output']
        );
    }

    public function site_logs_table_output()
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

    public function site_log_output()
    {
        global $wpdb;
        $output = '';

        if (isset($_GET['id']) && $_GET['id']) {
            $messages = Logger::get_messages(intval($_GET['id']));

            if (!empty($messages)) {
                $output = $messages;
            }
        }

        ?>
            <div class="wrap">
                <h1 class="wp-heading-inline">
                    <?php echo \__('Site Log Entry', 'wp-site-logs'); ?>
                </h1>
                <a href="/wp-admin/tools.php?page=site-logs" class="page-title-action">
                    Go Back
                </a>
                <table class="wp-list-table widefat fixed striped sitelog">
                    <tbody id="the-list">
                        <?php
                            if ($output) {
                                ?>
                                    <tr>
                                        <th scope="col">
                                            <span>Date</span>
                                        </th>
                                        <th scope="col">
                                            <span>Message</span>
                                        </th>
                                    </tr>
                                <?php
                                echo $output;
                            } else {
                                echo 'Log not found';
                            }
                        ?>
                        </tobdy>
                </table>
            </div>
        <?php
    }
}

new Menu();
