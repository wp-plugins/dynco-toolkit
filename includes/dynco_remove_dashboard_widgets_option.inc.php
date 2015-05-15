<?php
/**
 * Remove unwanted dashboard widgets for relevant users
 * For reference, visit: http://wp.tutsplus.com/tutorials/creative-coding/customizing-the-wordpress-admin-the-dashboard/
 * @uses remove_meta_box
 * Since: v.1.0.0
 */

if(get_option('dynco_remove_dashboard_widgets_option') == 1){

    // Remove unwanted dashboard widgets for relevant users
    function dynco_toolbox_remove_dashboard_widgets() {

        $user = wp_get_current_user();

        if ( ! $user->has_cap( 'manage_options' ) ) {

            remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

            remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );

            remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );

            remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );

            //remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );

            remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );

        }

    }

    add_action( 'wp_dashboard_setup', 'dynco_toolbox_remove_dashboard_widgets' );

    add_filter('screen_options_show_screen', '__return_false');

    // Move the 'Right Now' dashboard widget to the right hand side
    function dynco_toolbox_move_dashboard_widget() {

        $user = wp_get_current_user();

        if ( ! $user->has_cap( 'manage_options' ) ) {

            global $wp_meta_boxes;

            $widget = $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'];

            unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );

            $wp_meta_boxes['dashboard']['side']['core']['dashboard_right_now'] = $widget;

        }

    }

    add_action( 'wp_dashboard_setup', 'dynco_toolbox_move_dashboard_widget' );

}

