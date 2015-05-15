<?php


define ( 'DYNCO_PLUGIN_DIR', plugin_dir_path(__FILE__) );

if( !class_exists( 'Dynco_WordPress_Toolkit' ) ) {

    require_once DYNCO__PLUGIN_DIR . 'includes/dynco_search_all_options.inc.php';
    require_once DYNCO__PLUGIN_DIR . 'includes/dynco_remove_generator_filter_option.inc.php';
    require_once DYNCO__PLUGIN_DIR . 'includes/dynco_meta_information_option.inc.php';
    require_once DYNCO__PLUGIN_DIR . 'includes/dynco_mapped_domains_redirect_option.inc.php';
    require_once DYNCO__PLUGIN_DIR . 'includes/dynco_disallow_file_edit_option.inc.php';
    require_once DYNCO__PLUGIN_DIR . 'includes/dynco_support_svg_option.inc.php';
    require_once DYNCO__PLUGIN_DIR . 'includes/dynco_manager_role_option.inc.php';
    require_once DYNCO__PLUGIN_DIR . 'includes/dynco_remove_dashboard_widgets_option.inc.php';
    require_once DYNCO__PLUGIN_DIR . 'includes/dynco_added_dashboard_widgets_option.inc.php';
    require_once DYNCO__PLUGIN_DIR . 'includes/dynco_extra_shortcodes_option.inc.php';

}
