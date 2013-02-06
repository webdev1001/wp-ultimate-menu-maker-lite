<?php 
	
add_action('wp_ajax_tg_image_action', 'tg_image_action_fn');
add_action('wp_ajax_nopriv_tg_image_action', 'tg_image_action_fn');

function tg_image_action_fn(){
//simple Security check

    if( wp_verify_nonce($_POST['tg_name_of_nonce_field'],'tg_name_of_my_action') ){

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	
	tg_fixFilesArray( $_FILES['image_input'] );

	foreach( $_FILES['image_input'] as $singe_file ){

		if( tg_get_image_type( $singe_file["tmp_name"] ) && $singe_file["size"] < 10000000 ){ 

				$uploads = wp_upload_dir();
				$rand_prefix = rand(100000, 900000);
				$prev_path =  $uploads[path].'/'.sanitize_file_name( $rand_prefix.$singe_file["name"] ) ; 
				$prev_url =  $uploads[url].'/'.sanitize_file_name( $rand_prefix.$singe_file["name"] ) ; 
				
			
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