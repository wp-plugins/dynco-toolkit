<?php

WP_CLI::add_command( 'dynco', 'Dynco_Toolkit_CLI' );

/**
 * Control your local Dynco Toolkit installation.
 */
class Dynco_Toolkit_CLI extends WP_CLI_Command {

	/**
	 * Get Dynco Toolkit Details
	 *
	 * ## OPTIONS
	 *
	 * None. Simply returns details about whether or not your blog
	 * is connected, its Dynco Toolkit version, and WordPress.com blog_id.
	 *
	 * ## EXAMPLES
	 *
	 * wp dynco status
	 *
	 */
	public function status( $args, $assoc_args ) {
		if ( Dynco::is_active() ) {
			WP_CLI::success( __( 'Dynco Toolkit is currently connected to WordPress.com', 'dynco' ) );
			WP_CLI::line( sprintf( __( 'The Dynco toolkit Version is %s', 'dynco' ), DYNCO__VERSION ) );
			WP_CLI::line( sprintf( __( 'The WordPress.com blog_id is %d', 'dynco' ), Dynco_Toolkit_Options::get_option( 'id' ) ) );
		} else {
			WP_CLI::line( __( 'Dynco Toolkit is not currently connected to WordPress.com', 'dynco' ) );
		}
	}

	/**
	 * Disconnect Dynco Toolkit Blogs or Users
	 *
	 * ## OPTIONS
	 *
	 * blog: Disconnect the entire blog.
	 *
	 * user <user_identifier>: Disconnect a specific user from WordPress.com.
	 *
	 * Please note, the primary account that the blog is connected
	 * to WordPress.com with cannot be disconnected without
	 * disconnecting the entire blog.
	 *
	 * ## EXAMPLES
	 *
	 * wp dynco toolkit disconnect blog
	 * wp dynco toolkit disconnect user 13
	 * wp dynco toolkit disconnect user username
	 * wp dynco toolkit disconnect user email@domain.com
	 *
	 * @synopsis blog|[user <user_id>]
	 */
	public function disconnect( $args, $assoc_args ) {
		if ( ! Dynco::is_active() ) {
			WP_CLI::error( __( 'You cannot disconnect, without having first connected.', 'dynco' ) );
		}

		$action = isset( $args[0] ) ? $args[0] : 'prompt';
		if ( ! in_array( $action, array( 'blog', 'user', 'prompt' ) ) ) {
			WP_CLI::error( sprintf( __( '%s is not a valid command.', 'dynco' ), $action ) );
		}

		if ( in_array( $action, array( 'user' ) ) ) {
			if ( isset( $args[1] ) ) {
				$user_id = $args[1];
				if ( ctype_digit( $user_id ) ) {
					$field = 'id';
					$user_id = (int) $user_id;
				} elseif ( is_email( $user_id ) ) {
					$field = 'email';
					$user_id = sanitize_user( $user_id, true );
				} else {
					$field = 'login';
					$user_id = sanitize_user( $user_id, true );
				}
				if ( ! $user = get_user_by( $field, $user_id ) ) {
					WP_CLI::error( __( 'Please specify a valid user.', 'dynco' ) );
				}
			} else {
				WP_CLI::error( __( 'Please specify a user.', 'dynco' ) );
			}
		}

		switch ( $action ) {
			case 'blog':
				Dynco::log( 'disconnect' );
				Dynco::disconnect();
				WP_CLI::success( __( 'Dynco has been successfully disconnected.', 'dynco' ) );
				break;
			case 'user':
				if ( Dynco::unlink_user( $user->ID ) ) {
					Dynco::log( 'unlink', $user->ID );
					WP_CLI::success( sprintf( __( '%s has been successfully disconnected.', 'dynco' ), $action ) );
				} else {
					WP_CLI::error( sprintf( __( '%s could not be disconnected.  Are you sure they\'re connected currently?', 'dynco' ), "{$user->login} <{$user->email}>" ) );
				}
				break;
			case 'prompt':
				WP_CLI::error( __( 'Please specify if you would like to disconnect a blog or user.', 'dynco' ) );
				break;
		}
	}

	/**
	 * Manage Dynco Toolkit Modules
	 *
	 * ## OPTIONS
	 *
	 * list: View all available modules, and their status.
	 *
	 * activate <module_slug>: Activate a module.
	 *
	 * deactivate <module_slug>: Deactivate a module.
	 *
	 * toggle <module_slug>: Toggle a module on or off.
	 *
	 * ## EXAMPLES
	 *
	 * wp dynco toolkit module list
	 * wp dynco toolkit module activate stats
	 * wp dynco toolkit module deactivate stats
	 * wp dynco toolkit module toggle stats
	 *
	 * @synopsis [list|activate|deactivate|toggle [<module_name>]]
	 */
	public function module( $args, $assoc_args ) {
		$action = isset( $args[0] ) ? $args[0] : 'list';
		if ( ! in_array( $action, array( 'list', 'activate', 'deactivate', 'toggle' ) ) ) {
			WP_CLI::error( sprintf( __( '%s is not a valid command.', 'dynco' ), $action ) );
		}

		if ( in_array( $action, array( 'activate', 'deactivate', 'toggle' ) ) ) {
			if ( isset( $args[1] ) ) {
				$module_slug = $args[1];
				if ( ! Dynco::is_module( $module_slug ) ) {
					WP_CLI::error( sprintf( __( '%s is not a valid module.', 'dynco' ), $module_slug ) );
				}
				if ( 'toggle' == $action ) {
					$action = Dynco::is_module_active( $module_slug ) ? 'deactivate' : 'activate';
				}
			} else {
				WP_CLI::line( __( 'Please specify a valid module.', 'dynco' ) );
				$action = 'list';
			}
		}

		switch ( $action ) {
			case 'list':
				WP_CLI::line( __( 'Available Modules:', 'dynco' ) );
				$modules = Dynco::get_available_modules();
				sort( $modules );
				foreach( $modules as $module_slug ) {
					$active = Dynco::is_module_active( $module_slug ) ? __( 'Active', 'dynco' ) : __( 'Inactive', 'dynco' );
					WP_CLI::line( "\t" . str_pad( $module_slug, 24 ) . $active );
				}
				break;
			case 'activate':
				$module = Dynco::get_module( $module_slug );
				Dynco::log( 'activate', $module_slug );
				Dynco::activate_module( $module_slug, false );
				WP_CLI::success( sprintf( __( '%s has been activated.', 'dynco' ), $module['name'] ) );
				break;
			case 'deactivate':
				$module = Dynco::get_module( $module_slug );
				Dynco::log( 'deactivate', $module_slug );
				Dynco::deactivate_module( $module_slug );
				WP_CLI::success( sprintf( __( '%s has been deactivated.', 'dynco' ), $module['name'] ) );
				break;
			case 'toggle':
				// Will never happen, should have been handled above and changed to activate or deactivate.
				break;
		}
	}

}
