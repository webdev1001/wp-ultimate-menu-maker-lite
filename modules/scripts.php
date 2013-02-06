<?php 

//add_action('wp_print_scripts', 'urm_add_script_fn');
add_action('init', 'urm_add_script_fn');


function urm_add_script_fn(){
	wp_enqueue_style('tg_buttons_js', plugins_url('/css/buttons.css', __FILE__ ) ) ; 
   if(is_admin()){
	wp_enqueue_script('urm_admin_js', plugins_url('/js/admin.js', __FILE__ ), array('jquery', 'jquery-form', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-sortable' ), '1.0', false ) ;
	wp_enqueue_style('urm_ui_css', plugins_url('/css/jquery-ui-1.8.24.custom.css', __FILE__ ) ) ;
	wp_enqueue_style('urm_admin_css', plugins_url('/css/admin.css', __FILE__ ) ) ;
  }else{ 
	wp_enqueue_script('urm_jquery.fancybox', plugins_url('/js/jquery.fancybox.pack.js', __FILE__ ), array('jquery'), '1.0' ) ;
	wp_enqueue_style('urm_jquery.fancybox', plugins_url('/css/jquery.fancybox.css', __FILE__ ) ) ;
	wp_enqueue_script('urm_front_js', plugins_url('/js/front.js', __FILE__ ), array('jquery'), '1.0' ) ;
	wp_enqueue_style('urm_front_css', plugins_url('/css/front.css', __FILE__ ) ) ;
	wp_enqueue_style('urm_front-extend_css', plugins_url('/css/front-extend.css', __FILE__ ) ) ;
	
  }
 
}
?>