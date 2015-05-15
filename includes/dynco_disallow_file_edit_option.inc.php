<?php
/**
 * Prevent users from doing any unwanted “improvements” to a site via the theme edit page
 * @uses define
 * Since: v.1.0.0
 */

if(get_option('dynco_disallow_file_edit_option') == 1){

    define('DISALLOW_FILE_EDIT', true);

}