<?php 

class featured_widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'featured_widget', // Base ID
			'Dish of the Day', // Name
			array( 'description' => __( 'Daily Deal widget will show best offer of some dish' ,'rm_domain' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		$config = get_option('urm_options'); 
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$dish_id = apply_filters( 'widget_title', $instance['dish_id'] );
		$price = apply_filters( 'widget_title', $instance['price'] );
		$menu = apply_filters( 'widget_title', $instance['menu'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		$src = wp_get_attachment_image_src(get_post_thumbnail_id( $dish_id ), 'thumbnail');
		if( !$src[0] ){
			$src[0] = plugins_url('/images/no_image.jpg', __FILE__ );
		}
		if( $price ){
			$price_out = '<div class="widget_price">						
						'.$config['currency_name'].$price.'												
					</div>';
		}
		$features = get_features_block( $dish_id );
		
		echo '
			<div class="widget_feat_cont">
					<img class="widget_thumb" src="'.plugins_url( 'inc/resize.php', __FILE__ ).'?h=100&w=200&src='.$src[0].'" />
					'.$price_out.'
					<div class="widget_title"><a href="'.get_permalink( $menu ).'">'.get_post( $dish_id )->post_title.'</a></div>
					<div class="widget_feat">'.$features.'
					<div class="clearfix"></div>
					</div>
					'.( get_post_meta( $dish_id, 'short_description', true ) ? '<div class="widget_description">'.get_post_meta( $dish_id, 'short_description', true ) .'</div>' : '' ).'
			</div>
		';
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['dish_id'] = strip_tags( $new_instance['dish_id'] );
		$instance['price'] = strip_tags( $new_instance['price'] );
		$instance['menu'] = strip_tags( $new_instance['menu'] );
		

		return $instance;
	}

	public function form( $instance ) {
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
			$dish_id = $instance[ 'dish_id' ];
			$price = $instance[ 'price' ];
			$menu = $instance[ 'menu' ];
			
		}
		else {
			$title = __( 'New title' ,'rm_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ,'rm_domain' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Dish to use' ,'rm_domain' ); ?></label> 
		<?php 
		$all_dishes = get_posts('showposts=-1&post_type=single_dish&orderby=name&order=ASC'); 
		?>
			<select class="widefat" id="<?php echo $this->get_field_id( 'dish_id' ); ?>" name="<?php echo $this->get_field_name( 'dish_id' ); ?>"  >
			<?php foreach( $all_dishes as $single_dish ): ?>
			<option value="<?php echo $single_dish->ID; ?>" <?php if( $dish_id == $single_dish->ID ) echo ' selected '; ?> ><?php echo $single_dish->post_title; ?>
			<?php endforeach; ?>
			</select>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'price' ); ?>"><?php _e( 'Price:' ,'rm_domain' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'price' ); ?>" name="<?php echo $this->get_field_name( 'price' ); ?>" type="text" value="<?php echo esc_attr( $price ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'menu' ); ?>"><?php _e( 'Menu to link' ,'rm_domain' ); ?></label> 
		<?php 
		$all_menus = get_posts('showposts=-1&post_type=single_menu&orderby=name&order=ASC'); 
		?>
			<select class="widefat" id="<?php echo $this->get_field_id( 'menu' ); ?>" name="<?php echo $this->get_field_name( 'menu' ); ?>"  >
			<?php foreach( $all_menus as $single_menu ): ?>
			<option value="<?php echo $single_menu->ID; ?>" <?php if( $menu == $single_menu->ID ) echo ' selected '; ?> ><?php echo $single_menu->post_title; ?>
			<?php endforeach; ?>
			</select>
		</p>
		
		
		<?php 
	}

} // class Foo_Widget
// register Foo_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "featured_widget" );' ) );

class dish_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'dish_widget', // Base ID
			'Featured Menu', // Name
			array( 'description' => __( 'You can use this widget to promote any menu' ,'rm_domain' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$menu = apply_filters( 'widget_title', $instance['menu'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			
		$src = wp_get_attachment_image_src(get_post_thumbnail_id( $menu ), 'thumbnail');
		if( !$src[0] ){
			$src[0] = plugins_url('/images/no_image.jpg', __FILE__ );
		}
	
		echo '
			<div class="widget_feat_cont">
					<img class="widget_thumb" src="'.plugins_url( 'inc/resize.php', __FILE__ ).'?h=100&w=200&src='.$src[0].'" />
					'.$price_out.'
					<div class="widget_title"><a href="'.get_permalink( $menu ).'">'.get_post( $menu  )->post_title.'</a></div>
	
			</div>
		';
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['menu'] = strip_tags( $new_instance['menu'] );

		return $instance;
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
			$menu = $instance[ 'menu' ];
			
		}
		else {
			$title = __( 'New title' ,'rm_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','rm_domain' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'menu' ); ?>"><?php _e( 'Menu to link' ,'rm_domain' ); ?></label> 
		<?php 
		$all_menus = get_posts('showposts=-1&post_type=single_menu&orderby=name&order=ASC'); 
		?>
			<select class="widefat" id="<?php echo $this->get_field_id( 'menu' ); ?>" name="<?php echo $this->get_field_name( 'menu' ); ?>"  >
			<?php foreach( $all_menus as $single_menu ): ?>
			<option value="<?php echo $single_menu->ID; ?>" <?php if( $menu == $single_menu->ID ) echo ' selected '; ?> ><?php echo $single_menu->post_title; ?>
			<?php endforeach; ?>
			</select>
		</p>
		<?php 
	}

} // class Foo_Widget
// register Foo_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "dish_widget" );' ) );

?>