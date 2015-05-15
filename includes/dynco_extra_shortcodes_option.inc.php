<?php

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

    //clear floats
    function dynco_toolbox_clearfloat(){

        $clearHTML = '<div style="clear: both; font-size: 1px; height: 0; line-height: 0;"></div>';

        return $clearHTML;

    }

    add_shortcode("dynco_clearfloat", "dynco_toolbox_clearfloat");
}