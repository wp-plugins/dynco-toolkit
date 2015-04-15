<?php




if( !class_exists( 'Dynco_WordPress_Toolkit' ) ) {
	
	/**
	 *  Adds page content to default search function
	 *	@users add_filter
	 *	Since: v.1.0.0
	 */
	if(get_option('dynco_search_all_option') == 1){
		function dynco_filter_search($query) {
			if ($query->is_search) {
				//add all available types to search
				$types = get_post_types();
				$searchable = get_option('dynco_search_all_types');
				/*
				$searchable = array();
				foreach($types as $key=>$val){
					$exclude = array('revision', 'nav_menu_item','product_variation','shop_order','shop_order_refund','shop_coupon','shop_webhook');
					if(!in_array($val,$exclude)){
						$searchable[] = $val;
					}
				}
				*/
				$query->set('post_type', $searchable);
			}
			return $query;
		}
		add_filter('pre_get_posts', 'dynco_filter_search');
	}
	
	/**
	 * Removes the generator from the wp_head
	 * @uses remove_action
	 * Since: v.1.0.0
	 */	
	if(get_option('dynco_remove_generator_filter_option') == 1){
		
		function dynco_toolbox_remove_generator_filter() { return ''; }
		
		if (function_exists('add_filter')) {
			$types = array('html', 'xhtml', 'atom', 'rss2', 'rdf', 'comment', 'export');
			foreach ($types as $type)
			add_filter('get_the_generator_'.$type, 'dynco_toolbox_remove_generator_filter');
		}
		
		add_action('wp_head', 'dynco_toolbox_remove_generator_filter');	
	}
	
	/**
	 * Adds meta information to the wp_head funtion
	 * @uses add_action
	 * Since: v.1.0.0
	 */
	if(get_option('dynco_meta_information_option') == 1){
		
		function dynco_toolbox_add_meta_information() {
			
			$meta  = '<meta name="author" content="Dynamic Consultants" />';
			$meta .= '<meta name="copyright" content="Copyright &copy;' . date( 'Y' ) . ' ' .get_bloginfo('name') . '. All Rights Reserved." />';
			$meta .= '<meta name="msapplication-config" content="none”/>';
		
			echo $meta;
		}
		add_action('wp_head', 'dynco_toolbox_add_meta_information');	
	}


	/**
	  * Mapped domains redirect script
	  * Redirect script to resolve mapped domain names
	  * @uses redirectPage
	  * Since: v.1.0.0
	**/
	if(get_option('dynco_mapped_domains_redirect_option') == 1){
		function dynco_toolbox_mapped_domains_redirect() {
		
			// Set the correct website link
			$home_link = home_url();
			
			// Set the actual website link
			$actual_link = "http://".$_SERVER['HTTP_HOST']; 
			
			// Check to see if the two links are incorrect
			if( $actual_link != $home_link ) {
				// Links are different, so redirect to the correct url
				dynco_redirectPage( 301, $home_link );
				
			}
		}
		add_action('wp_head', 'dynco_toolbox_mapped_domains_redirect');
	}

	/*
	 * Prevent users from doing any unwanted “improvements” to a site via the theme edit page
	 * @uses define
	 * Since: v.1.0.0
	 */
	if(get_option('dynco_disallow_file_edit_option') == 1){
		
		define('DISALLOW_FILE_EDIT', true);
	
	}
	
	/**
	 * Add support for SVG files.
	 * @uses add_filter
	 * Since: v.1.0.0
	 */
	if(get_option('dynco_support_svg_option') == 1){
		
		function dynco_toolbox_upload_mimes($mimes = array()) {
			$mimes['svg'] = 'image/svg+xml';
			return $mimes;
		}
		
		add_filter('upload_mimes', 'dynco_toolbox_upload_mimes');
	
	}
	
	/**
	 * Add a new user role called Manager
	 * For reference, visit: http://codex.wordpress.org/Roles_and_Capabilities
	 * @uses get_role and add_role and remove_role
	 * Since: v.1.0.0
	 */
	$role = 'manager';
	if(get_option('dynco_manager_role_option') == 1){
		
		$role = 'manager';
		
		if( null !== get_role( $role ) ) {
			/* Used to update existing role
			function update_manager_role() {
				$user_role = get_role( 'manager' );
				$user_role->add_cap( 'moderate_comments' );
				
			}
			add_action( 'admin_init', 'update_manager_role');
			*/	
		} else {
			add_role( $role, __( 'Manager' ), array(
				'moderate_comments' => true,
				'manage_categories' => true,
				'manage_links' => true,
				'edit_others_posts' => true,
				'edit_pages' => true,
				'edit_others_pages' => true,
				'edit_published_pages' => true,
				'publish_pages' => true,
				'delete_pages' => true,
				'delete_others_pages' => true,
				'delete_published_pages' => true,
				'delete_others_posts' => true,
				'delete_private_posts' => true,
				'edit_private_posts' => true,
				'read_private_posts' => true,
				'delete_private_pages' => true,
				'edit_private_pages' => true,
				'read_private_pages' =>	 true,
				'edit_published_posts' => true,
				'upload_files' => true,
				'add_users' => true,
				'create_users' => true,
				'edit_users' => true,
				'list_users' => true,
				'promote_users' => true,
				'publish_posts' => true,
				'delete_published_posts' => true,
				'edit_posts'   => true,
				'delete_posts' => true,
				'read' => true,
				'export' => true,
				)
			);
		}
	}else{
		if( null !== get_role( $role ) ) {
			remove_role($role);
		}
	}
	
	
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
	}
	
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
	
	
	if(get_option('dynco_added_dashboard_widgets_option') == 1){
		// Add new dashboard widgets
		function dynco_toolbox_add_dashboard_widgets() {
			wp_add_dashboard_widget( 'dynco_toolbox_dashboard_welcome', 'Welcome', 'dynco_toolbox_add_welcome_widget' );
			wp_add_dashboard_widget( 'dynco_toolbox_dashboard_links', 'Useful Links - Dynamic Consultants', 'dynco_toolbox_add_links_widget' );
			wp_add_dashboard_widget( 'dynco_toolbox_dashboard_blog_feed', 'Latest Blogs - Dynamic Consultants', 'dynco_toolbox_add_blog_widget');
			wp_add_dashboard_widget( 'dynco_toolbox_dashboard_news_feed', 'Latest News - Dynamic Consultants', 'dynco_toolbox_add_news_widget');
		}
		function dynco_toolbox_add_welcome_widget(){ ?>
		 
			This content management system lets you edit the pages and posts on your website.
		 
			Your site consists of the following content, which you can access via the menu on the left:
		 
			<ul>
				<li><strong>Pages</strong> - static pages which you can edit.</li>
				<li><strong>Posts</strong> - news or blog articles - you can edit these and add more.</li>
				<li><strong>Media</strong> - images and documents which you can upload via the Media menu on the left or within each post or page.</li>
			</ul>
		 
			On each editing screen there are instructions to help you add and edit content.
		 
		<?php }
		 
		function dynco_toolbox_add_links_widget() { ?>
		 
			Some links to resources which will help you manage your site:
		 
			<ul>
				<li><a target="_blank" href="http://www.dynco.co.uk">Our main website</a></li>
				<li><a target="_blank" href="http://support.dynco.co.uk">Support portal</a> - Search our knowledgebase or report a fault.</li>
				<li><a target="_blank" href="http://dynco.co.uk/system-status">System status</a> - Check for planned maintenance and current issues.</li>
				<li><a target="_blank" href="http://controlpanel.dynco.co.uk">Control panel</a> - Login to your hosting control panel.</li>
				<li><a target="_blank" href="http://webmail.dynco.co.uk">Webmail login</a> - Login to your email account.</li>
			</ul>
		<?php }
		
		
		function dynco_toolbox_add_blog_widget() { dynco_toolbox_get_feed_widget('http://dynco.co.uk/feed', 3); }
		function dynco_toolbox_add_news_widget() { dynco_toolbox_get_feed_widget('http://www.dynco.co.uk/feed/?post_type=dynco_articles', 1); }
		
		
		function dynco_toolbox_get_feed_widget( $feed, $count ) {
		
			include_once(ABSPATH . WPINC . '/feed.php'); // Get RSS Feed
			$rss = fetch_feed( $feed ); // Get the feed object from our specified feed source.
			
			if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
				$maxitems  = $rss->get_item_quantity( $count ); 
				$rss_items = $rss->get_items( 0, $maxitems ); 
			endif; ?>
			
			<div class="rss-widget">
			<ul>
			
			<?php
			if ( $maxitems == 0 ) { ?>
				<li>There are currently no posts to show.</li>
			<?php } else {
				
				// Loop through each feed item and display each item as a hyperlink.
				foreach ( $rss_items as $item ) :
					$item_date = human_time_diff( $item->get_date('U'), current_time('timestamp')).' '.__( 'ago', 'rc_mdm' );
					$content = $item->get_content();
					
					$article  = '<li>';
					$article .= '<a href="'.esc_url( $item->get_permalink() ).'" title="'.$item_date.'">';
					$article .= esc_html( $item->get_title() );
					$article .= '</a>';
					$article .= ' <span class="rss-date">'.$item_date.'</span><br />';
					$article .= wp_html_excerpt($content, 120) . ' [...]';
					$article .= '</li>';
					
					echo $article;
					
				endforeach;
				
			} ?>
			</ul>
			</div>
		<?php }
		
		add_action( 'wp_dashboard_setup', 'dynco_toolbox_add_dashboard_widgets' );	
	}

	
	/**
	 * Shortcodes.
	 * Various custom additions to the shortcode functions
	 */
	if(get_option('dynco_extra_shortcodes_option') == 1){ 
		// Date 
		function dynco_toolbox_date($atts, $content = null) {
			extract(shortcode_atts(array(
				"format" => 'j F Y',
			), $atts));
			return date( $format );
		}
		add_shortcode("dynco_date", "dynco_toolbox_date");
		
		// Day
		function dynco_toolbox_day($atts, $content = null) {
			extract(shortcode_atts(array(
				"format" => 'l',
			), $atts));
			return date( $format );
		}
		add_shortcode("dynco_day", "dynco_toolbox_day");
		
		// Time
		function dynco_toolbox_time($atts, $content = null) {
			extract(shortcode_atts(array(
				"format" => 'H:i',
			), $atts));
			return date( $format );
		}
		add_shortcode("dynco_time", "dynco_toolbox_time");
		
		
		/**
		 * Clearfloat.
		 * Adds a clearfloat/reset class to the css.
		 */
		
		//wp_enqueue_style('dynco-style', get_template_directory_uri() . '/style.css');
        //$dynco_css = ".clearfloat { clear: both; font-size: 1px; height: 0; line-height: 0; }";
        //wp_add_inline_style( 'dynco-style', $dynco_css );
		
		//clear floats
		function dynco_toolbox_clearfloat(){
			$clearHTML = '<div style="clear: both; font-size: 1px; height: 0; line-height: 0;"></div>';
			return $clearHTML;
		}
		add_shortcode("dynco_clearfloat", "dynco_toolbox_clearfloat");
	}


	/**
	 *
	 * PHP Redirect To Another URL
	 * Code source: http://www.cyberciti.biz/faq/php-redirect
	 * Date: Jan 2013
	 *
	 */	
	function dynco_redirectPage($num,$url){
	   
	   static $http = array (
		   100 => "HTTP/1.1 100 Continue",
		   101 => "HTTP/1.1 101 Switching Protocols",
		   200 => "HTTP/1.1 200 OK",
		   201 => "HTTP/1.1 201 Created",
		   202 => "HTTP/1.1 202 Accepted",
		   203 => "HTTP/1.1 203 Non-Authoritative Information",
		   204 => "HTTP/1.1 204 No Content",
		   205 => "HTTP/1.1 205 Reset Content",
		   206 => "HTTP/1.1 206 Partial Content",
		   300 => "HTTP/1.1 300 Multiple Choices",
		   301 => "HTTP/1.1 301 Moved Permanently",
		   302 => "HTTP/1.1 302 Found",
		   303 => "HTTP/1.1 303 See Other",
		   304 => "HTTP/1.1 304 Not Modified",
		   305 => "HTTP/1.1 305 Use Proxy",
		   307 => "HTTP/1.1 307 Temporary Redirect",
		   400 => "HTTP/1.1 400 Bad Request",
		   401 => "HTTP/1.1 401 Unauthorized",
		   402 => "HTTP/1.1 402 Payment Required",
		   403 => "HTTP/1.1 403 Forbidden",
		   404 => "HTTP/1.1 404 Not Found",
		   405 => "HTTP/1.1 405 Method Not Allowed",
		   406 => "HTTP/1.1 406 Not Acceptable",
		   407 => "HTTP/1.1 407 Proxy Authentication Required",
		   408 => "HTTP/1.1 408 Request Time-out",
		   409 => "HTTP/1.1 409 Conflict",
		   410 => "HTTP/1.1 410 Gone",
		   411 => "HTTP/1.1 411 Length Required",
		   412 => "HTTP/1.1 412 Precondition Failed",
		   413 => "HTTP/1.1 413 Request Entity Too Large",
		   414 => "HTTP/1.1 414 Request-URI Too Large",
		   415 => "HTTP/1.1 415 Unsupported Media Type",
		   416 => "HTTP/1.1 416 Requested range not satisfiable",
		   417 => "HTTP/1.1 417 Expectation Failed",
		   500 => "HTTP/1.1 500 Internal Server Error",
		   501 => "HTTP/1.1 501 Not Implemented",
		   502 => "HTTP/1.1 502 Bad Gateway",
		   503 => "HTTP/1.1 503 Service Unavailable",
		   504 => "HTTP/1.1 504 Gateway Time-out"
		);
		
		header($http[$num]);
		header ("Location: $url");
	}
		
}
