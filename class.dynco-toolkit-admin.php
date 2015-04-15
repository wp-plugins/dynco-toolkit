<?php

add_action( 'admin_menu', 'dynco_toolkit_admin_menu' );

function dynco_toolkit_admin_menu() {
	add_options_page( 'Dynco Toolkit Options', 'Dynco Toolkit', 'manage_options', 'my-unique-identifier', 'dynco_toolkit_options' );
	
	add_action( 'admin_init', 'register_dynco_settings');	
}

function register_dynco_settings(){
	register_setting('dynco_settings_group','dynco_manager_role_option');
	register_setting('dynco_settings_group','dynco_meta_information_option');
	register_setting('dynco_settings_group','dynco_remove_generator_filter_option');
	register_setting('dynco_settings_group','dynco_disallow_file_edit_option');
	register_setting('dynco_settings_group','dynco_remove_dashboard_widgets_option');
	register_setting('dynco_settings_group','dynco_added_dashboard_widgets_option');
	register_setting('dynco_settings_group','dynco_mapped_domains_redirect_option');
	register_setting('dynco_settings_group','dynco_extra_shortcodes_option');
	register_setting('dynco_settings_group','dynco_search_all_option');
	register_setting('dynco_settings_group','dynco_search_all_types');
}

function dynco_toolkit_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
    echo '<h2>Dynco Toolkit Options</p>';
	
	echo '<form method="post" action="options.php">';
    settings_fields( 'dynco_settings_group' );
    do_settings_sections( 'dynco_settings_group' );
    echo '<table class="form-table">';
    
	//Remove Generator Filter
	echo '<tr valign="top">';
    echo '<th scope="row">Remove Generator Filter Option</th>';
    echo '<td><input type="checkbox" name="dynco_remove_generator_filter_option" '.checked('1', get_option('dynco_remove_generator_filter_option'),false). 'value="1" /></td>';
	echo '<td style="font-size:12px; font-weight:bold; font-style:italic;">Removes &quot;&lt;meta name=&quot;generator&quot; content=&quot;WordPress n.n&quot;&gt;&quot; from headers.</td>';
   	echo '</tr>';
	
	// Meta Information
	echo '<tr valign="top">';
    echo '<th scope="row">Meta Information Option</th>';
    echo '<td><input type="checkbox" name="dynco_meta_information_option" '.checked('1', get_option('dynco_meta_information_option'),false). 'value="1" /></td>';
	echo '<td style="font-size:12px; font-weight:bold; font-style:italic;">Adds Dynco as author and copyright credits for toolkit plugin.</td>';
   	echo '</tr>';
	
	// Prevent File Edits
	echo '<tr valign="top">';
    echo '<th scope="row">Disallow File Edit Option</th>';
    echo '<td><input type="checkbox" name="dynco_disallow_file_edit_option" '.checked('1', get_option('dynco_disallow_file_edit_option'),false). 'value="1" /></td>';
	echo '<td style="font-size:12px; font-weight:bold; font-style:italic;">Prevents any users from accessing/editing theme/plugin files via editor option.</td>';
   	echo '</tr>';
	
	// Manager Role
	echo '<tr valign="top">';
    echo '<th scope="row">Manager Role Option</th>';
    echo '<td><input type="checkbox" name="dynco_manager_role_option" '.checked('1', get_option('dynco_manager_role_option'),false). 'value="1" /></td>';
	echo '<td style="font-size:12px; font-weight:bold; font-style:italic;">Adds &quot;Manager&quot; as a permitted role.</td>';
   	echo '</tr>';
	
	// Unwanted Dashboad Widgets
	echo '<tr valign="top">';
    echo '<th scope="row">Remove Unwanted Dashboard Widgets Option</th>';
    echo '<td><input type="checkbox" name="dynco_remove_dashboard_widgets_option" '.checked('1', get_option('dynco_remove_dashboard_widgets_option'),false). 'value="1" /></td>';
	echo '<td style="font-size:12px; font-weight:bold; font-style:italic;">Removes unwanted dashboard widgets from administration view.</td>';
   	echo '</tr>';
	
	// Dynco Bespoke Dashboad Widgets
	echo '<tr valign="top">';
    echo '<th scope="row">Show Dynco Dashboard Widgets Option</th>';
    echo '<td><input type="checkbox" name="dynco_added_dashboard_widgets_option" '.checked('1', get_option('dynco_added_dashboard_widgets_option'),false). 'value="1" /></td>';
	echo '<td style="font-size:12px; font-weight:bold; font-style:italic;">Adds Dynco\'s own dashboard widgets to the administration dashboard.</td>';
   	echo '</tr>';
	
	// Dynco Mapped Domains redirect
	echo '<tr valign="top">';
    echo '<th scope="row">Redirect Mapped Domains Option</th>';
    echo '<td><input type="checkbox" name="dynco_mapped_domains_redirect_option" '.checked('1', get_option('dynco_mapped_domains_redirect_option'),false). 'value="1" /></td>';
	echo '<td style="font-size:12px; font-weight:bold; font-style:italic;">Redirect mapped domains to the primary domain with a 301.</td>';
   	echo '</tr>';
	
	// Dynco Extra Shorcodes
	echo '<tr valign="top">';
    echo '<th scope="row">Extra Shortcodes Option</th>';
    echo '<td><input type="checkbox" name="dynco_extra_shortcodes_option" '.checked('1', get_option('dynco_extra_shortcodes_option'),false). 'value="1" /></td>';
	echo '<td style="font-size:12px; font-weight:bold; font-style:italic;">Allow usage of extra \'helper\' shortcodes ([dynco_date], [dynco_day], [dynco_time] etc).</td>';
   	echo '</tr>';
	
	// Dynco Search All content
	echo '<tr valign="top">';
    echo '<th scope="row">Search Pages Option</th>';
    echo '<td><input type="checkbox" name="dynco_search_all_option" '.checked('1', get_option('dynco_search_all_option'),false). 'value="1" /></td>';
	echo '<td style="font-size:12px; font-weight:bold; font-style:italic;">Extends search function to include Pages as well as Posts</td>';
   	echo '</tr>';
	//content types
	echo '<tr valign="top">';
    echo '<th scope="row">Page types to include:</th>';
	echo '<td>';
	$types = get_post_types();
	$selected_types = get_option('dynco_search_all_types',false);
	echo '<select multiple="multiple" name="dynco_search_all_types[]">';
	foreach($types as $type){
		echo '<option value="'.$type.'"';
		if(in_array($type,$selected_types)){
			echo ' selected ';
		}
		echo '>'.$type.'</option>';
	}
	echo '</select>';
	echo '<td style="font-size:12px; font-weight:bold; font-style:italic;">Choose content type to include in searches (ctrl+click / cmd+click to choose multiple items)</td>';
	
	echo '</table>';    
    submit_button();
	echo '</form>';	
	echo '</div>';
}
?>