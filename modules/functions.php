<?php 

function urm_generate_menu( $menu_id = null ){
	
	$config = get_option('urm_options'); 
	
	
	
	$current_menu = json_decode( stripcslashes( get_post_meta( $menu_id, 'menu_listing', true ) ) );
	
	$out .= '<div class="front_menu_cont" >';
		
		
		
		if( $config['short_menu'] == 'on' ){
			$out .= '<div class="front_menu_descr" >';
			if( $config['menu_thumb'] == 'on' ){
				$src = wp_get_attachment_image_src(get_post_thumbnail_id( $menu_id ), 'thumbnail');
				if( !$src[0] ){
					$src[0] = plugins_url('/images/no_image.jpg', __FILE__ );
				}
				$out .= '<img class="front_descr_icon" src="'.plugins_url( 'inc/resize.php', __FILE__ ).'?h=100&w=100&src='.$src[0].'" />';
			}
			$out .= get_post_meta( $menu_id, 'menu_description', true  ).'<div class="clearfix"></div></div>';
		}
		
	if( $current_menu ){
	foreach( $current_menu as $single_block ){
		
		if( $single_block->title ){
		
			if( $config['design'] == 'des1' ){
				$out .= '<div class="front_menu_title" >'.$single_block->title.'</div>';
			}

		}
		
		
		if( $single_block->id ){ 
			$src = wp_get_attachment_image_src(get_post_thumbnail_id( $single_block->id ), 'thumbnail');
			if( !$src[0] ){
				$src[0] = plugins_url('/images/no_image.jpg', __FILE__ );
			}
			
			
			$features = get_features_block( $single_block->id );
			
			if( $config['design'] == 'des1' ){
				$out .= '
				<div class="front_menu_dish">'.( !substr_count( $src[0], 'no_image.jpg' ) ? '<a class="fancybox"  href="'.plugins_url( 'inc/resize.php', __FILE__ ).'?w=640&src='.$src[0].'"><img class="front_feat_icon" src="'.plugins_url( 'inc/resize.php', __FILE__ ).'?h=50&w=50&src='.$src[0].'" /></a>' : '' )
					
					.'<div class="front_dish_cont">
					
						<div class="price_block">'.( get_post_meta( $single_block->id, 'price', true ) ? $config['currency_name'].get_post_meta( $single_block->id, 'price', true ) : '' ).'
						
						'.(  get_post_meta( $single_block->id, 'old_price', true ) ? '<div class="des2_old_price"><del>'.$config['currency_name'].get_post_meta( $single_block->id, 'old_price', true ).'</del></div>'  : '' ).'
						
						</div>
						
						
						<div class="data_block">
							<div class="front_title"><a href="'.get_permalink( $single_block->id ).'">'.get_post( $single_block->id )->post_title.'</a></div>
							<div class="front_feature">
								'.$features.'
								'.( strlen( $features ) ? '<div class="clearfix"></div>' : '' ).'
								'.( $config['short_description'] == 'on' ? '<div class="short_description">'.get_post_meta( $single_block->id, 'short_description', true ).'</div>' : '' ).'
							</div>
							
						</div>
						
						
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div>
			';
			}
			
			
		}
	}
	}// endif
	else{
		$out .= '<h2>'._('Sorry, no items').'</h2>';
	}
	
	$out .= '</div><!-- .front_menu cont -->';
	
	// Jquery scripting
	$out .= '
	<script>
	/*
		jQuery(".front_menu_cont .des3_block").mouseover(function(){
			jQuery(".des3_dish_descr", this).fadeIn();
		}).mouseout(function(){
			jQuery(".des3_dish_descr", this).fadeOut();
		});
		
		jQuery(".front_menu_cont .des3_block").mouseenter(function(){
			jQuery(".des3_dish_descr", this).fadeIn();
		}).mouseleave(function(){
			jQuery(".des3_dish_descr", this).fadeOut();
		})*/
	</script>
	';
	
	return $out;
	
}


function urm_show_single_dish( $dish_id = null ){
	$config = get_option('urm_options'); 
	$this_post = get_post( $dish_id );
	
	$out .= '
		<div class="front_single_dish">';
		
			$src = wp_get_attachment_image_src(get_post_thumbnail_id( $dish_id ), 'thumbnail');
			if( !$src[0] ){
				$src[0] = plugins_url('/images/no_image.jpg', __FILE__ );
			}	
			
		// additional images
		$additional_images = json_decode( get_post_meta( $dish_id, 'thumb_array', true ) )	;
		$add_images = '';
		if( count( $additional_images ) ){
			$add_images .= '<div class="single_add_thumbs_block">';
			foreach( $additional_images as $single_image ){
				$add_images .= '
				<a class="fancybox" rel="group" href="'.plugins_url( 'inc/resize.php', __FILE__ ).'?w=640&src='.$single_image.'">
				<img class="single_add_thumbs" src="'.plugins_url( 'inc/resize.php', __FILE__ ).'?h=25&w=25&src='.$single_image.'" />
				</a>
				';
			}
			$add_images .= '
			<div class="clearfix"></div>
			</div>';
		}
			
		$out .= '	
		<div class="single_feat_block">
			<a class="fancybox" rel="group" href="'.plugins_url( 'inc/resize.php', __FILE__ ).'?w=640&src='.$src[0].'">
				<img class="single_feat_icon" src="'.plugins_url( 'inc/resize.php', __FILE__ ).'?w=300&h=200&src='.$src[0].'" />
			</a>
			'.$add_images.'
		</div>
		';
		
		$all_features = unserialize( get_post_meta( $dish_id, 'featured', true ) );

			$features = '';
			if( $all_features ){
			$features .= __('Features: ' ,'rm_domain').'<div >';	
				foreach( $all_features as $single_feature ){
					
					
					switch( $single_feature ){
						case "spicy":
							$features .= '<img class="single_spec_feature" title="'.__('Spicy' ,'rm_domain').'" src="'.plugins_url('/images/pepper.png', __FILE__ ).'" />';
						break;
						
						case "hot":
							$features .= '<img class="single_spec_feature" title="'.__('Hot' ,'rm_domain').'"  src="'.plugins_url('/images/icon_hot.gif', __FILE__ ).'" />';
						break;
						
						case "featured":
							$features .= '<img class="single_spec_feature" title="'.__('Featured' ,'rm_domain').'"  src="'.plugins_url('/images/new.png', __FILE__ ).'" />';
						break;
						
						case "discount":
							$features .= '<img class="single_spec_feature" title="'.__('Discount' ,'rm_domain').'"  src="'.plugins_url('/images/discount.png', __FILE__ ).'" />';
						break;
						
						case "special":
							$features .= '<img class="single_spec_feature" title="'.__('Special' ,'rm_domain').'"  src="'.plugins_url('/images/star.png', __FILE__ ).'" />';
						break;
						
						case "vegetarian":
							$features .= '<img class="single_spec_feature"  title="'.__('Vegetarian' ,'rm_domain').'" src="'.plugins_url('/images/vegetarian.png', __FILE__ ).'" />';
						break;
					}
					
				}
				$features .= '<div class="clearfix"></div>';
				$features .= '</div>';
			}//if
		
		// get this dish categories
		$terms = get_the_terms( $dish_id, 'dish_type' );
		$out_cats = __('Categories: ' ,'rm_domain');
		if( count($terms) ){
			foreach( $terms as $single_term ){
				$all_terms_arr[] = '<a href="'.get_term_link( $single_term ).'">'.$single_term->name.'</a>';
			}
			$out_cats .= implode( ', ', $all_terms_arr );
		}
		
		
		$out .= '
		<div class="single_data_block">
			<div class="single_title">'.$this_post->post_title.'</div>
			<div class="single_feature_block">'.$features.'</div>
			<!--
			<div class="single_category_block">'.$out_cats.'</div>
			-->
			'.( get_post_meta( $dish_id, 'price', true ) ? '<div class="single_price">'.__('Price: ' ,'rm_domain').$config['currency_name'].get_post_meta( $dish_id, 'price', true ).'</div>' : '' ).'
			'.( get_post_meta( $dish_id, 'old_price', true ) ? '<div class="single_old_price">'.__('Old Price: ' ,'rm_domain').'<del>'.$config['currency_name'].get_post_meta( $dish_id, 'old_price', true ).'</del></div>' : '' ).'
			'.( get_post_meta( $dish_id, 'calories', true ) ? '<div class="single_cal_price">'.__('Calories: ' ,'rm_domain').get_post_meta( $dish_id, 'calories', true ).'</div>' : '' ).'
			'.( get_post_meta( $dish_id, 'weight', true ) ? '<div class="single_weight_price">'.__('Weight: ' ,'rm_domain').get_post_meta( $dish_id, 'weight', true ).' '.$config['weight_unit'].'</div>' : '' ).'
		</div>
		<div class="clearfix"></div>
		<div class="single_content_block">
			'.$this_post->post_content.'
		</div>
		';
		
	$out .= '	
		</div>
	';
	return $out;
}


function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function urm_get_image_type($file) {
     if (!$f = @fopen($file, 'rb')) {
         return false;
     }
 
     $data = fread($f, 8);
     fclose($f);
 
     if (
         @array_pop(unpack('H12', $data)) == '474946383961' ||
         @array_pop(unpack('H12', $data)) == '474946383761'
     ) {
         return 'GIF';
     } else if (
         @array_pop(unpack('H4', $data)) == 'ffd8'
     ) {
         return 'JPEG';
     } else if (
         @array_pop(unpack('H16', $data)) == '89504e470d0a1a0a'
     ) {
         return 'PNG';
     } 
 
     return false;
 }
 function urm_fixFilesArray(&$files)
{
    $names = array( 'name' => 1, 'type' => 1, 'tmp_name' => 1, 'error' => 1, 'size' => 1);
    foreach ($files as $key => $part) {
        // only deal with valid keys and multiple files
        $key = (string) $key;
        if (isset($names[$key]) && is_array($part)) {
            foreach ($part as $position => $value) {
                $files[$position][$key] = $value;
            }
            // remove old key reference
            unset($files[$key]);
        }
    }
}

function get_features_block( $id){
	// generate features
			$all_features = unserialize( get_post_meta( $id, 'featured', true ) );

			$features = '';
			if( $all_features ){
				
				foreach( $all_features as $single_feature ){
					
					
					switch( $single_feature ){
						case "spicy":
							$features .= '<img class="single_feature" title="'.__('Spicy' ,'rm_domain').'" src="'.plugins_url('/images/pepper.png', __FILE__ ).'" />';
						break;
						
						case "hot":
							$features .= '<img class="single_feature" title="'.__('Hot' ,'rm_domain').'"  src="'.plugins_url('/images/icon_hot.gif', __FILE__ ).'" />';
						break;
						
						case "featured":
							$features .= '<img class="single_feature" title="'.__('Featured' ,'rm_domain').'"  src="'.plugins_url('/images/new.png', __FILE__ ).'" />';
						break;
						
						case "discount":
							$features .= '<img class="single_feature" title="'.__('Discount' ,'rm_domain').'"  src="'.plugins_url('/images/discount.png', __FILE__ ).'" />';
						break;
						
						case "special":
							$features .= '<img class="single_feature" title="'.__('Special' ,'rm_domain').'"  src="'.plugins_url('/images/star.png', __FILE__ ).'" />';
						break;
						
						case "vegetarian":
							$features .= '<img class="single_feature"  title="'.__('Vegetarian' ,'rm_domain').'" src="'.plugins_url('/images/vegetarian.png', __FILE__ ).'" />';
						break;
					}
					
				}
			}//if
			return $features;
}

?>