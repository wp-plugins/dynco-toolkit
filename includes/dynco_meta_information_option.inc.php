<?php

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