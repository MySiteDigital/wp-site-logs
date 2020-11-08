<?php

namespace MySiteDigital\WPSiteLogs;

/**
 *
 * @class    Logger
 * @version  0.0.1
 * @package  WPSiteLogs/Classes
 * @category Admin
 * @author: MySite Digital
 */

if (!defined('ABSPATH')) {
    exit;
}

class Logger
{
    public static function log( $post_id, $type, $message )
    {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix .  'site_logs';
        $message = '
                <tr>
                    <td>'. date("Y-m-d h:i:s") . '</td>
                    <td>'. $message . '</td>
                </tr>';

        $log = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT ID, messages FROM " . $table_name . "
                WHERE type = %s AND post_id = %d LIMIT 1",
                $type, $post_id
            )
        );

        if( empty( $log ) ) {
            $wpdb->insert( 
                $table_name, 
                [
                    'type' => $type,
                    'post_id' => $post_id,
                    'messages' => $message, // ... and so on
                ]
            );
        }
        else {
            $log = $log[0];
            $messages = $log->messages . $message;
            $wpdb->update( 
                $table_name, 
                [
                    'modified' => date("Y-m-d h:i:s"),
                    'messages' => $messages, // ... and so on
                ],
                [
                    'ID' => $log->ID
                ]
            );
        }
        
    }

    public static function get_messages( $id )
    {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix .  'site_logs';
        return $wpdb->get_var(
            $wpdb->prepare(
                "SELECT messages FROM " . $table_name . "
                WHERE ID = %d LIMIT 1",
                $id
            )
        );
    }
}
