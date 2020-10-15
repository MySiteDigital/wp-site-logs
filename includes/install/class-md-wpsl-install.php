<?php

namespace MySiteDigital\WPSiteLogs;

/**
 * Installation related functions and actions.
 *
 * @class    Install
 * @version  0.0.1
 * @package  WPSiteLogs/Classes
 * @category Install
 * @author: MySite Digital
 */

if (!defined('ABSPATH')) {
    exit;
}

class Install
{

    public static function create_db_table()
    {
        global $table_prefix, $wpdb;

        $table_name = $table_prefix .  'site_logs';
        $charset = $wpdb->get_charset_collate();
        $charset_collate = $wpdb->get_charset_collate();

        #Check to see if the table exists already, if not, then create it
        if ( $wpdb->get_var("show tables like '$table_name'") != $table_name ) {

            $sql = "CREATE TABLE " . $table_name . " (   
                ID  int(11) NOT NULL auto_increment,
                created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
                modified datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
                type varchar(25),  
                post_id int(11),
                messages text,    
                PRIMARY KEY  (ID)
            ) " . $charset_collate .";";

            require_once( \ABSPATH . '/wp-admin/includes/upgrade.php' );
            $return = \dbDelta( $sql );
        }
    }
}
