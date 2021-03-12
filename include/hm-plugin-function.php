<?php

register_activation_hook(   __FILE__, array( 'WCM_Setup_Demo_Class', 'on_activation' ) );
register_deactivation_hook( __FILE__, array( 'WCM_Setup_Demo_Class', 'on_deactivation' ) );
register_uninstall_hook(    __FILE__, array( 'WCM_Setup_Demo_Class', 'on_uninstall' ) );

add_action( 'plugins_loaded', array( 'WCM_Setup_Demo_Class', 'init' ) );
class WCM_Setup_Demo_Class
{
    protected static $instance;

    public static function init()
    {
        is_null( self::$instance ) AND self::$instance = new self;
        return self::$instance;
    }

    public static function on_activation()
    {
        if ( ! current_user_can( 'activate_plugins' ) )
            return;
        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        check_admin_referer( "activate-plugin_{$plugin}" );

        # Uncomment the following line to see the function in action
        # exit( var_dump( $_GET ) );
    }

    public static function on_deactivation()
    {
        if ( ! current_user_can( 'activate_plugins' ) )
            return;
        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        check_admin_referer( "deactivate-plugin_{$plugin}" );

        # Uncomment the following line to see the function in action
        # exit( var_dump( $_GET ) );
    }

    public static function on_uninstall()
    {
        if ( ! current_user_can( 'activate_plugins' ) )
            return;
        check_admin_referer( 'bulk-plugins' );

        // Important: Check if the file is the one
        // that was registered during the uninstall hook.
        if ( __FILE__ != WP_UNINSTALL_PLUGIN )
            return;

        # Uncomment the following line to see the function in action
        # exit( var_dump( $_GET ) );
    }

    public function __construct()
    {
        add_action( 'activated_plugin' , 'do_create_new_ds' );
    }

    public function do_create_new_ds()
    {
        global $wpdb;

        $sql = 'INSERT INTO ' . $wpdb->prefix . 'posts ("post_author","post_date","post_date_gmt","post_title","post_status","comment_status","ping_status","post_name","post_modified","post_modified_gmt","post_parent","menu_order","post_type") Values (1,' . date('Y-m-d H:m:s') . ',' . date('Y-m-d H:m:s') . ',"Star overview","publish","closed","closed","star-overview",' . date('Y-m-d H:m:s') . ',' . date('Y-m-d H:m:s') . ',0,0,"page")';

        $wpdb->query($wpdb->prepare( $sql ));
    }
}