<?php 


add_action( 'add_meta_boxes', 'urm_add_custom_box' );
function urm_add_custom_box() {
	
	// single dish
		add_meta_box( 
			'urm_dishbox_id',
			__( 'Dish Info' ,'rm_domain' ),
			'urm_dishbox_box',
			'single_dish', 'side' , 'high'
		);
		
	// single additional images
		add_meta_box( 
			'urm_dishbox_images_id',
			__( 'Dish Additional Images' ,'rm_domain' ),
			'urm_dishbox_images_box',
			'single_dish', 'side' , 'high'
		);	
		
	// menu editor
		add_meta_box( 
			'urm_menu_id',
			__( 'Menu Generator' ,'rm_domain' ),
			'urm_menugen_box',
			'single_menu'
		);
	// menu info	
		add_meta_box( 
			'urm_menu_info_id',
			__( 'Menu Info' ,'rm_domain' ),
			'urm_menu_info_box',
			'single_menu', 'side', 'high'
		);

}

// menu info
function urm_menu_info_box( $post ) {

		wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
		
		echo '
			<label>'.__('Menu Data' ,'rm_domain').' </label>
			<div class="menu_shortcode">[menu id="'.$post->ID.'"]</div>
			<p>'.__('You can use this shortcode to print menu where you like.' ,'rm_domain').'</p>
			<label>'.__('Menu Short description' ,'rm_domain').' </label>
			<textarea name="menu_description" >'.get_post_meta( $post->ID, 'menu_description', true ).'</textarea>
			<p>'.__('This data will appear abow menu' ,'rm_domain').'</p>
		';	
}

// menu editor
function urm_menugen_box( $post ) {
		
		$config = get_option('urm_options'); 	
		wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );	
		
		// preform previous listing
		
		
		if( get_post_meta( $post->ID, 'menu_listing', true ) ){
			$json_res = json_decode( get_post_meta( $post->ID, 'menu_listing', true ) );
		if( $json_res ){	
			foreach( $json_res as $single_block ){
				if( $single_block->title ){
					$out .= '
					<li class="ui-state-default left_titles">
						<div class="left_title_single">'.$single_block->title.'</div> 
						<div class="edit_block"> 
							<input type="text" class="title_name" /> 
							<input type="button" class="save_button button_pl green  small" value="'.__('Save' ,'rm_domain').'" /> 
							<input type="button" class="edit_button button_pl orange small" value="'.__('Edit' ,'rm_domain').'"/> 
							<input type="button" class="remove_button button_pl red small" value="'.__('Remove' ,'rm_domain').'"/>
						</div>
						<div class="clearfix"></div>
					</li>
					';
				}
				if( $single_block->id ){
					$src = wp_get_attachment_image_src(get_post_thumbnail_id( $single_block->id ), 'thumbnail');
					if( !$src[0] ){
						$src[0] = plugins_url('/images/no_image.jpg', __FILE__ );
					}
					$out .= '
					<li class="ui-state-highlight dish_item" id="'.$single_block->id.'"> <img class="admin_feat_icon" src="'.plugins_url( 'inc/resize.php', __FILE__ ).'?h=25&w=25&src='.$src[0].'" /> <div class="admin_feat_name">'.get_post( $single_block->id )->post_title.'</div>
						<div class="dish_remover">
							<img src="'.plugins_url('images/close-button.png', __FILE__ ).'" />
						</div>		
					<div class="clearfix"></div>
					</li>
					';
				
				}
				
			}
		}//if
		}else{
			$out = '
					<li class="ui-state-default left_titles">
						<div class="left_title_single">'.__('Dummy Title' ,'rm_domain').'</div> 
						<div class="edit_block"> 
							<input type="text" class="title_name" /> 
							<input type="button" class="save_button button_pl green  small" value="'.__('Save' ,'rm_domain').'" /> 
							<input type="button" class="edit_button button_pl orange small" value="'.__('Edit' ,'rm_domain').'"/> 
							<input type="button" class="remove_button button_pl red small" value="'.__('Remove' ,'rm_domain').'"/>
						</div>
						<div class="clearfix"></div>
					</li>
					<li class="ui-state-default left_titles">
						<div class="left_title_single">'.__('Dummy Title' ,'rm_domain').'</div> 
						<div class="edit_block"> 
							<input type="text" class="title_name" /> 
							<input type="button" class="save_button button_pl green  small" value="'.__('Save' ,'rm_domain').'" /> 
							<input type="button" class="edit_button button_pl orange small" value="'.__('Edit' ,'rm_domain').'"/> 
							<input type="button" class="remove_button button_pl red small" value="'.__('Remove' ,'rm_domain').'"/>
						</div>
						<div class="clearfix"></div>
					</li>
			';
		}
		
		
		
		echo '
			<!--  hidden blocks  -->
			<input type="hidden" id="menu_listing" name="menu_listing" value=\''.get_post_meta( $post->ID, 'menu_listing', true ).'\'  />
		
		
			<div class="editor_container">
				<!--  hidden block -->
				<div class="dummy_title">
					<li class="ui-state-default left_titles">
						<div class="left_title_single">'.__('Dummy Title' ,'rm_domain').'</div> 
						<div class="edit_block"> 
							<input type="text" class="title_name" /> 
							<input type="button" class="save_button button_pl green  small" value="'.__('Save' ,'rm_domain').'" /> 
							<input type="button" class="edit_button button_pl orange small" value="'.__('Edit' ,'rm_domain').'"/> 
							<input type="button" class="remove_button button_pl red small" value="'.__('Remove' ,'rm_domain').'"/>
						</div>
						<div class="clearfix"></div>
					</li>
				</div>
				<!--  hidden block end -->
			
			<div class="left_col">
				<div class="col_title">'.__('Current Menu' ,'rm_domain').' <input type="button" class="add_title_button button_pl small green" value="'.__('Add Title' ,'rm_domain').'" /></div>
				
				
				
				<ul id="sortable_main" class="connectedSortable ">
					'.$out.'

				</ul>
			</div><!--  left_col -->
			
			<div class="right_col">
				<div class="inner_right_col_nav">
					';
				
				$all_terms = get_terms( 'dish_type', $args );
				foreach( $all_terms as $single_term ){
					echo '
					<div class="col_title">'.$single_term->name.'</div>
					<ul id="sortable'.$single_term->term_id.'" class="single_sortable">';
						$args = array(
							'post_type' => 'single_dish',
							'tax_query' => array(
								array(
									'taxonomy' => 'dish_type',
									'field' => 'id',
									'terms' => $single_term->term_id
								)
							)
						);
						$posts = get_posts( $args );
						foreach( $posts as $single_post ){
							$src = wp_get_attachment_image_src(get_post_thumbnail_id( $single_post->ID ), 'thumbnail');
							if( !$src[0] ){
								$src[0] = plugins_url('/images/no_image.jpg', __FILE__ );
							}
							echo '<li class="ui-state-highlight dish_item" id="'.$single_post->ID.'"> <img class="admin_feat_icon" src="'.plugins_url( 'inc/resize.php', __FILE__ ).'?h=25&w=25&src='.$src[0].'" /> <div class="admin_feat_name">'.$single_post->post_title.'</div>
							
							<div class="dish_remover">
								<img src="'.plugins_url('images/close-button.png', __FILE__ ).'" />
							</div>
							
							<div class="clearfix"></div>
							</li>';
						}

					echo '
					</ul>
					
					<script>
					jQuery( "#sortable_main" ).sortable();
					jQuery( "#sortable'.$single_term->term_id.'" ).sortable({
					  connectWith: ".connectedSortable",
					  remove: function(event, ui) {
								ui.item.clone().appendTo(\'#sortable'.$single_term->term_id.'\');
								},
						update: function(event, ui){
							process_items();
						}
					}).disableSelection();
					
					</script>
					
					';
				}
				
			echo '
				</div><!-- inner_right_col_nav  -->
			</div><!--  right_col -->
			
			<div class="clearfix"></div>
			<script>
				function process_items(){
					var jsonObj = [];
					jQuery("#sortable_main li").each(function(){
						if( jQuery(this).hasClass("left_titles") ){
							jsonObj.push( {title:jQuery(".left_title_single", this).html() });
						}
						if( jQuery(this).hasClass("dish_item") ){
							jsonObj.push( {id:jQuery(this).attr("id") } );
						}
					})
					
					var myJSONText = JSON.stringify( jsonObj );
					jQuery("#menu_listing").val( myJSONText );
					
				}
			</script>
			</div>
		';	
}

// single dish
function urm_dishbox_box( $post ) {
		
		$config = get_option('urm_options'); 	
		wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

		$all_features = unserialize( get_post_meta( $post->ID, 'featured', true ) );
		
		echo '
			<label>'.__('Price' ,'rm_domain').' ('.$config['currency_name'].')</label>
			<input type="text" placeholder="0.00" value="'.get_post_meta( $post->ID, 'price', true ).'" name="price" />
			
			<label>'.__('Old Price' ,'rm_domain').' ('.$config['currency_name'].')</label>
			<input type="text" placeholder="0.00" value="'.get_post_meta( $post->ID, 'old_price', true ).'" name="old_price" />
			
			<label>'.__('Calories' ,'rm_domain').'</label>
			<input type="text" placeholder="0" value="'.get_post_meta( $post->ID, 'calories', true ).'" name="calories"  />
			<label>'.__('Weight' ,'rm_domain').' ('.$config['weight_unit'].')</label>
			<input type="text" value="'.get_post_meta( $post->ID, 'weight', true ).'" name="weight" placeholder="0" />
			<hr>
			<h2>'.__('Features' ,'rm_domain').' </h2>
			<div class="admin_featured">  
				'.__('Spicy' ,'rm_domain').'
				<input name="featured[]" type="checkbox" value="spicy"  '.( @in_array( "spicy" , $all_features ) ? ' checked ' : '' ).' />
				<img src="'.plugins_url('/images/pepper.png', __FILE__ ).'" />
				<div class="clearfix"></div>
			</div>
			<div class="admin_featured">  
				'.__('Hot' ,'rm_domain').'
				<input name="featured[]" type="checkbox" value="hot" '.( @in_array( "hot" , $all_features ) ? ' checked ' : '' ).'  />
				<img src="'.plugins_url('/images/icon_hot.gif', __FILE__ ).'" />
				<div class="clearfix"></div>
			</div>
			
			<div class="admin_featured">  
				'.__('Featured' ,'rm_domain').'
				<input name="featured[]" type="checkbox" value="featured"  '.( @in_array( "featured" , $all_features ) ? ' checked ' : '' ).'  />
				<img src="'.plugins_url('/images/new.png', __FILE__ ).'" />
				<div class="clearfix"></div>
			</div>
			<div class="admin_featured">  
				'.__('Discount' ,'rm_domain').'
				<input name="featured[]" type="checkbox" value="discount" '.( @in_array( "discount" , $all_features ) ? ' checked ' : '' ).'  />
				<img src="'.plugins_url('/images/discount.png', __FILE__ ).'" />
				<div class="clearfix"></div>
			</div>
			
			<div class="admin_featured">  
				'.__('Special' ,'rm_domain').'
				<input name="featured[]" type="checkbox" value="special" '.( @in_array( "special" , $all_features ) ? ' checked ' : '' ).'  />
				<img src="'.plugins_url('/images/star.png', __FILE__ ).'" />
				<div class="clearfix"></div>
			</div>
			<div class="admin_featured">  
				'.__('Vegetarian' ,'rm_domain').'
				<input name="featured[]" type="checkbox" value="vegetarian" '.( @in_array( "vegetarian" , $all_features ) ? ' checked ' : '' ).'  />
				<img src="'.plugins_url('/images/vegetarian.png', __FILE__ ).'" />
				<div class="clearfix"></div>
			</div>
			
			<hr>
			<h2>'.__('Short Description' ,'rm_domain').' </h2>
			<textarea id="full_size" name="short_description">'.htmlentities( get_post_meta( $post->ID, 'short_description', true ) ).'</textarea>
			
		';	
}
// additional images
function urm_dishbox_images_box( $post ) {
		
		$config = get_option('urm_options'); 	
		wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

		$json_str = stripslashes( get_post_meta( $post->ID, 'thumb_array', true ) );
		
		$json_arr = json_decode( $json_str );
		if( count( $json_arr  ) ){
			foreach( $json_arr as $single_img ){
				$out_images .= '<img  class="single_thumb" title="Click to remove!" src="'.$single_img.'"  >';
			}
		}
		echo '
		<input type="hidden" name="thumb_array" id="thumb_array" value=\''.$json_str.'\' />
			<div class="thumb_container" >'.$out_images.'</div>
			<input type="button" class="button_pl green" id="add_thumbs" value="Add Images" />
			<img id="status_ajax" src="'.plugins_url('/images/loader.gif', __FILE__ ).'" />
		';	
}


add_action( 'save_post', 'urm_save_postdata' );
function urm_save_postdata( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
      return;
  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }
  /// User editotions
  //var_dump( $_POST );
  if( get_post_type( $post_id ) == 'single_dish' ){

  
	update_post_meta( $post_id, 'price', $_POST['price'] );
	update_post_meta( $post_id, 'old_price', $_POST['old_price'] );
	
	update_post_meta( $post_id, 'calories', $_POST['calories'] );
	update_post_meta( $post_id, 'weight', $_POST['weight'] );
	update_post_meta( $post_id, 'featured', serialize( $_POST['featured'] ) );
	update_post_meta( $post_id, 'thumb_array', stripslashes( $_POST['thumb_array'] ) );
	update_post_meta( $post_id, 'short_description', $_POST['short_description'] );
	
	
	
  }
  if( get_post_type( $post_id ) == 'single_menu' ){
  
  update_post_meta( $post_id, 'menu_listing', stripslashes( $_POST['menu_listing'] ) );
  update_post_meta( $post_id, 'menu_description', stripslashes( $_POST['menu_description'] ) );
  
  }
  
  
}

?>