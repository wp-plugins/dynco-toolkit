<?php
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

            foreach($types as $type){

                $check = get_option('dynco_search_all_option_'.$type);

                if($check==1){

                    $searchable[] = $type;

                }

            }

            $query->set('post_type', $searchable);

        }

        return $query;

    }

    add_filter('pre_get_posts', 'dynco_filter_search');
}