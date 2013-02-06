<?php
function urm_add_post_type() {
  $labels = array(
    'name' => _x('Dish', 'post type general name', 'rm_domain'),
    'singular_name' => _x('Dish', 'post type singular name', 'rm_domain'),
    'add_new' => _x('Add New', 'book', 'rm_domain'),
    'add_new_item' => __('Add New Dish', 'rm_domain'),
    'edit_item' => __('Edit Dish', 'rm_domain'),
    'new_item' => __('New Dish', 'rm_domain'),
    'all_items' => __('All Dishes', 'rm_domain'),
    'view_item' => __('View Dish', 'rm_domain'),
    'search_items' => __('Search Dish', 'rm_domain'),
    'not_found' =>  __('No Dish found', 'rm_domain'),
    'not_found_in_trash' => __('No Dish found in Trash', 'rm_domain'), 
    'parent_item_colon' => '',
    'menu_name' => __('Dishes', 'rm_domain')

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' =>  array( 'slug' => 'dish' ),
	'menu_icon' => plugins_url('images/dish_logo.ico', __FILE__ ),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'custom-fields', 'editor', 'thumbnail' )
  ); 
  register_post_type('single_dish', $args);
  
  
  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name', 'rm_domain' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name', 'rm_domain' ),
    'search_items' =>  __( 'Search Category', 'rm_domain' ),
    'popular_items' => __( 'Popular Category' , 'rm_domain'),
    'all_items' => __( 'All Categories', 'rm_domain' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Category', 'rm_domain' ), 
    'update_item' => __( 'Update Category' , 'rm_domain'),
    'add_new_item' => __( 'Add New Category', 'rm_domain' ),
    'new_item_name' => __( 'New Category Name', 'rm_domain' ),
    'separate_items_with_commas' => __( 'Separate writers with commas', 'rm_domain' ),
    'add_or_remove_items' => __( 'Add or remove writers', 'rm_domain' ),
    'choose_from_most_used' => __( 'Choose from the most used writers', 'rm_domain' ),
    'menu_name' => __( 'Categories', 'rm_domain' ),
  ); 

  register_taxonomy('dish_type', 'single_dish', array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' =>  array( 'slug' => 'cat' ),
  ));
  
  
  $labels = array(
    'name' => _x('Menu', 'post type general name', 'rm_domain'),
    'singular_name' => _x('Menu', 'post type singular name', 'rm_domain'),
    'add_new' => _x('Add New', 'book', 'rm_domain'),
    'add_new_item' => __('Add New Menu', 'rm_domain'),
    'edit_item' => __('Edit Menu', 'rm_domain'),
    'new_item' => __('New Menu', 'rm_domain'),
    'all_items' => __('All Menues', 'rm_domain'),
    'view_item' => __('View Menu', 'rm_domain'),
    'search_items' => __('Search Menu', 'rm_domain'),
    'not_found' =>  __('No Menues found', 'rm_domain'),
    'not_found_in_trash' => __('No Menues found in Trash', 'rm_domain'), 
    'parent_item_colon' => '',
    'menu_name' => __('Menues', 'rm_domain')

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'menu' ),
	'menu_icon' => plugins_url('images/menu_logo.ico', __FILE__ ),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'custom-fields' , 'thumbnail' )
  ); 
  register_post_type('single_menu', $args);
  
  
  
  
}
add_action( 'init', 'urm_add_post_type' );
?>