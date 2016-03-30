<?php
/*
 * Plugin Name: ABC Faculty and Staff
 * Plugin URI: https://github.com/ambassador-baptist-college/abc-faculty-staff/
 * Description: Faculty and Staff
 * Version: 1.0.0
 * Author: AndrewRMinion Design
 * Author URI: https://andrewrminion.com
 */

if (!defined('ABSPATH')) {
    exit;
}

// Register Custom Post Type
function faculty_staff_post_type() {

    $labels = array(
        'name'                  => 'Faculty Members',
        'singular_name'         => 'Faculty Member',
        'menu_name'             => 'Faculty Members',
        'name_admin_bar'        => 'Faculty Member',
        'archives'              => 'Faculty Member Archives',
        'parent_item_colon'     => 'Parent Faculty Member:',
        'all_items'             => 'All Faculty Members',
        'add_new_item'          => 'Add New Faculty Member',
        'add_new'               => 'Add New',
        'new_item'              => 'New Faculty Member',
        'edit_item'             => 'Edit Faculty Member',
        'update_item'           => 'Update Faculty Member',
        'view_item'             => 'View Faculty Member',
        'search_items'          => 'Search Faculty Member',
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'insert_into_item'      => 'Insert into faculty member',
        'uploaded_to_this_item' => 'Uploaded to this faculty member',
        'items_list'            => 'Faculty Members list',
        'items_list_navigation' => 'Faculty Members list navigation',
        'filter_items_list'     => 'Filter faculty members list',
    );
    $rewrite = array(
        'slug'                  => 'about-us/faculty-and-staff/',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => 'Faculty Member',
        'description'           => 'Faculty and Staff Members',
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes', ),
        'taxonomies'            => array( 'faculty-category' ),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-businessman',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'faculty-staff',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'page',
    );
    register_post_type( 'faculty', $args );

}
add_action( 'init', 'faculty_staff_post_type', 0 );

// Register Custom Taxonomy
function faculty_categories() {

    $labels = array(
        'name'                       => 'Types',
        'singular_name'              => 'Type',
        'menu_name'                  => 'Type',
        'all_items'                  => 'All Types',
        'parent_item'                => 'Parent Type',
        'parent_item_colon'          => 'Parent Type:',
        'new_item_name'              => 'New Type Name',
        'add_new_item'               => 'Add New Type',
        'edit_item'                  => 'Edit Type',
        'update_item'                => 'Update Type',
        'view_item'                  => 'View Type',
        'separate_items_with_commas' => 'Separate types with commas',
        'add_or_remove_items'        => 'Add or remove types',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Types',
        'search_items'               => 'Search Types',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No types',
        'items_list'                 => 'Types list',
        'items_list_navigation'      => 'Types list navigation',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'faculty-category', array( 'faculty' ), $args );

}
add_action( 'init', 'faculty_categories', 0 );

// Add custom archive template
function get_faculty_archive_template( $archive_template ) {
     global $post;
     if ( is_post_type_archive ( 'meeting' ) || is_tax( 'faculty-category' ) ) {
          $archive_template = dirname( __FILE__ ) . '/archive-faculty.php';
     }
     return $archive_template;
}
add_filter( 'archive_template', 'get_faculty_archive_template' ) ;
add_filter( 'taxonomy_archive', 'get_faculty_archive_template' ) ;

// Sort by beginning date ascending
function sort_faculty( $query ) {
    if ( ( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'faculty' ) || ( isset($query->query_vars['faculty-category']) ) ) {
        $query->set( 'posts_per_page', -1 );
        $query->set( 'order', 'ASC' );
    }
}
add_filter( 'pre_get_posts', 'sort_faculty' );

// Register backend script
function abc_faculty_register_backend_js() {
    global $post_type;
    if ( 'faculty' == $post_type ) {
        wp_enqueue_script( 'abc-faculty-backend', plugins_url( 'js/backend.min.js', __FILE__ ), array( 'jquery' ) );
    }
}
add_action( 'admin_enqueue_scripts', 'abc_faculty_register_backend_js' );
