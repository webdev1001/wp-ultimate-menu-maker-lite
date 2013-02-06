<?php 

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

	<h3>Extra profile information</h3>

	<table class="form-table">

		
		<tr>
			<th><label for="twitter">Original Password</label></th>

			<td>
				<input type="text" name="orig_password" id="orig_password" value="<?php echo esc_attr( get_the_author_meta( 'orig_password', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		

	</table>
<?php }
add_action( 'personal_options_update', 'my_satg_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_satg_extra_profile_fields' );

function my_satg_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	update_usermeta( $user_id, 'orig_password', $_POST['orig_password'] );	
}
?>