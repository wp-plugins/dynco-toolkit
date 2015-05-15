<?php
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