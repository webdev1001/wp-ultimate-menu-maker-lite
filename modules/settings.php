<?php 
	
add_action('admin_menu', 'ucm_item_menu');

function ucm_item_menu() {
	add_submenu_page( 'edit.php?post_type=single_dish', __('Settings' ,'rm_domain'), __('Settings' ,'rm_domain'), 'delete_others_pages', 'ucm_config', 'ucm_config');
}

function ucm_config(){

?>
<div class="wrap">
<h2><?php _e('Settings' ,'rm_domain'); ?></h2>

 <?php if( ($_POST['posted'] == 1) && (is_admin() ) && wp_verify_nonce($_POST['_wpnonce']) ): ?>
  <div id="message" class="updated" ><?php _e('Settings saved successfully' ,'rm_domain'); ?></div>
  
  <?php 

  
  $urm_options = array(

  'currency_name' =>  $_POST['currency_name'],
  'weight_unit' =>  $_POST['weight_unit'],
  'design' =>  $_POST['design'],
  'short_description' =>  $_POST['short_description'],
  'short_menu' =>  $_POST['short_menu'],
  'menu_thumb' =>  $_POST['menu_thumb'],
  

  );
  update_option('urm_options', $urm_options );

  ?>
  
  
  <?php else:  ?>
  
  <?php //exit; ?>
  
  <?php endif; ?> 
<form method="post" action="">
<?php wp_nonce_field();  
$config = get_option('urm_options'); 


?>  
<table class="form-table">
   
	<tr valign="top">
      <th scope="row"><?php _e('Currency Sign', 'rm_domain'); ?></th>
      <td><input type="text" name="currency_name" value="<?php echo $config['currency_name']; ?>"  />
      <p><?php _e('This Currency Sign will be used on site price elements.'); ?></p>
	  </td>
	  
    </tr>
	
    <!--
	<tr valign="top">
      <th scope="row"><?php _e('Weight Unit','rm_domain'); ?></th>
      <td><input type="text" name="weight_unit" value="<?php echo $config['weight_unit']; ?>"  />
      <p><?php _e('This Weight Unit will be used on site dishes elements.'); ?></p>
      </td>
    </tr>
	-->
	
	<tr valign="top">
      <th scope="row"><?php _e('Design Layout','rm_domain'); ?></th>
      <td>
	  <select name="design" >
	  <option value="des1" <?php if( $config['design'] == 'des1' ) echo ' selected '  ; ?> >Design 1
	  </select>
	  
      <p>Select your currency.</p>
      </td>
    </tr>
	
	<tr valign="top">
      <th scope="row"><?php _e('Show Dish Short Dedscription','rm_domain'); ?></th>
      <td><input type="checkbox" name="short_description" value="on" <?php if( $config['short_description'] == 'on' ) echo ' checked '; ?>  />
      <p><?php _e('If checked - menu will show dishes short description','rm_domain'); ?></p>
      </td>
    </tr>
	
	<tr valign="top">
      <th scope="row"><?php _e('Show Menu Description','rm_domain'); ?></th>
      <td><input type="checkbox" name="short_menu" value="on" <?php if( $config['short_menu'] == 'on' ) echo ' checked '; ?>  />
      <p><?php _e('If checked - menu will show short description','rm_domain'); ?></p>
      </td>
    </tr>
	
	<tr valign="top">
      <th scope="row"><?php _e('Show Menu Thumbnail','rm_domain'); ?></th>
      <td><input type="checkbox" name="menu_thumb" value="on" <?php if( $config['menu_thumb'] == 'on' ) echo ' checked '; ?>  />
      <p><?php _e('If checked - menu thumbnail will be show in description block','rm_domain'); ?></p>
      </td>
    </tr>
	
 
 
</table>

<input type="hidden" value="1" name="posted" />
<input type="Submit" value="Save" class="button-secondary" />
</form>
  
</div>


<?php 
}
?>