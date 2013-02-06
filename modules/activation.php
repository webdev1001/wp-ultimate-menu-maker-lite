<?php 
function tg_activate() {
$config = get_option('mw_options');

}

register_activation_hook( __FILE__, 'tg_activate' );	
?>