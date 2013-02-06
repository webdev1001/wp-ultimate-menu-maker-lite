<?php 
add_shortcode( 'menu', 'urm_shortcode_handler' );
function urm_shortcode_handler( $atts ) {
   return urm_generate_menu( $atts['id'] );
}
?>