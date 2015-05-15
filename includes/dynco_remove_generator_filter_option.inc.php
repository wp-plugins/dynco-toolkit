<?php
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

    add_action('wp_head', 'dynco_toolbox_remove_generator_filter',1);
}