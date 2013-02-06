<?
/*
Plugin Name: Wordpress Ultimate Restaurant Menu Maker Lite
Plugin URI: http://voodoopress.net/
Description: Wordpress Ultimate Restaurant Menu Maker allows you to create menus for your cooking / restaurant web site. 
Version: 1.4
Author: Evgen Dobrzhanskiy
Author URI: http://voodoopress.net/
Stable tag: 1.4
*/
include('modules/scripts.php');


function tg_activate() {



$urm_options = array(

  'currency_name' =>  '$',
  'weight_unit' =>  'gr',
  'design' =>  'des1',
  'short_description' =>  'off',
  'short_menu' =>  'off',
  'menu_thumb' =>  'off',
  

  );
  if( !get_option('urm_options') ){
	update_option('urm_options', $urm_options );
  }


}

register_activation_hook( __FILE__, 'tg_activate' );



function myplugin_init() {
 $plugin_dir = basename(dirname(__FILE__));
 load_plugin_textdomain( 'rm_domain', false, $plugin_dir );
}
add_action('plugins_loaded', 'myplugin_init');


include('modules/cpt.php');
include('modules/meta_box.php');

include('modules/settings.php');
include('modules/hooks.php');
include('modules/functions.php');
include('modules/shortcode.php');
include('modules/widgets.php');


?>