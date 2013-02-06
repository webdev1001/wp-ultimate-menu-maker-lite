<?php 
add_filter('the_content', 'urm_process_content');
function urm_process_content( $content ){
	global $post;
	if( get_post_type( $post->ID ) == 'single_menu' && is_single()  ){
		$content = urm_generate_menu( $post->ID );
	}
	
	if( get_post_type( $post->ID ) == 'single_dish' && is_single()  ){
		$content = urm_show_single_dish( $post->ID );
	}
	
	return $content;
}

add_action('admin_footer', 'urm_footer_inj');
function urm_footer_inj(){
	echo '
	<div class="image_overlay">

	<form id="thumbnail_upload" method="post" action="#" enctype="multipart/form-data" >
			<input type="file" name="thumbnail[]" id="thumbnail"  multiple="true" >
			'.wp_nonce_field('name_of_my_action','name_of_nonce_field', true, false).'
			<input type="hidden" name="action" id="action" value="my_upload_action">
		  <input id="submit-ajax" name="submit-ajax" type="submit" value="upload">
		  <input id="status" name="status" type="text" />
		</form>
	</div>
	
	
	
	';
}

add_action('admin_footer', 'urm_footer_injection') ;
function urm_footer_injection(){
	echo '<input type="hidden" id="ajaxurl" value="'.get_option('home').'/wp-admin/admin-ajax.php" />';
	echo '<input type="hidden" id="plugin_url" value="'.plugins_url('', __FILE__).'" />';
}

add_Action('wp_head', 'urm_add_footer_codes');
function urm_add_footer_codes(){
	echo "<link href='http://fonts.googleapis.com/css?family=Donegal+One' rel='stylesheet' type='text/css'>";
}


//hook the Ajax call
add_action('wp_ajax_my_upload_action', 'urm_ajax_upload');
add_action('wp_ajax_nopriv_my_upload_action', 'urm_ajax_upload');

function urm_ajax_upload(){

//var_dump( $_REQUEST );var_dump( $_POST );
    if( wp_verify_nonce($_POST['name_of_nonce_field'],'name_of_my_action') ){

//get POST data
    $post_id = $_POST['post_id'];

//require the needed files
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
//then loop over the files that were sent and store them using  media_handle_upload();
	$uploads = wp_upload_dir();
	$prefix = rand(1,1000).'-';
	urm_fixFilesArray( $_FILES['thumbnail'] );
	foreach( $_FILES['thumbnail'] as $singe_file ){
		if( urm_get_image_type( $singe_file["tmp_name"] ) && $singe_file["size"] < 20000000 ){ 

		$prefix = rand(1,1000).'-';
		$prev_path =  $uploads[path].'/'.sanitize_file_name( $prefix .$singe_file["name"] ) ; 
		$prev_url =  $uploads[url].'/'.sanitize_file_name( $prefix.$singe_file["name"] ) ; 
                if( move_uploaded_file($singe_file["tmp_name"], $prev_path) ) {
						$ulr_mass[] = $prev_url;					
				}
		}
	}
	if( count($ulr_mass) > 0 )
		echo 'success|'.implode('^^', $ulr_mass);
	else
		echo 'error|';

  }
  die();
}

?>