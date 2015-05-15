<?php
/**
 * Add a new user role called Manager
 * For reference, visit: http://codex.wordpress.org/Roles_and_Capabilities
 * @uses get_role and add_role and remove_role
 * Since: v.1.0.0
 */

$role = 'manager';

if(get_option('dynco_manager_role_option') == 1){

    if( null !== get_role( $role ) ) {

        //It's already been added

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