jQuery(document).ready(function($){
	

	// title processing codes
	$('.save_button').live( 'click', function(){
		var this_obj = $(this).parents('li');
		$( '.left_title_single', this_obj).html( $( '.title_name', this_obj).val() );
		$( '.title_name', this_obj).fadeOut();
		$( '.save_button', this_obj).fadeOut();
		process_items();
	})
	$('.edit_button').live( 'click', function(){
		var this_obj = $(this).parents('li');
		$( '.title_name', this_obj).val( $( '.left_title_single', this_obj).html()  ) ;
		$( '.title_name', this_obj).fadeIn();
		$( '.save_button', this_obj).fadeIn();
		$( '.title_name', this_obj).focus();
		process_items();
	})
	$('.remove_button').live( 'click', function(){
		var this_obj = $(this).parents('li');
		this_obj.fadeOut( 500, function(){
				this_obj.replaceWith('');
		} );
		process_items();
	})
	$('.dish_remover').live( 'click', function(){
		var this_obj = $(this).parents('li');
		this_obj.fadeOut( 500, function(){
				this_obj.replaceWith('');
		} );
		process_items();
	})
	
	
	
	
	
	$('.add_title_button').click(function(){
		$('#sortable_main').append( $('.dummy_title').html() );
	})


// file upload functionality

$('.single_thumb').live( 'click', function(){
	if( confirm("Remove  Image ?") ){
		$(this).replaceWith('');	
	process_thumb_json();
	}
})

$('#add_thumbs').click(function(){
	$('#thumbnail').click();
});
$('#thumbnail').change(function(){
	$('#submit-ajax').click();
});

var options = { 
        target:        '#status',      // target element(s) to be updated with server response 
        beforeSubmit:  showRequest,     // pre-submit callback 
        success:       showResponse,    // post-submit callback 
        url:    $('#ajaxurl').val()                 // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php     
    }; 

// bind form using 'ajaxForm' 
jQuery('#thumbnail_upload').ajaxForm(options); 

	
function showRequest(formData, jqForm, options) {
//do extra stuff before submit like disable the submit button
jQuery('#status_ajax').fadeIn();

}
function showResponse(responseText, statusText, xhr, $form)  {
	//do extra stuff after submit

	var res_ar =  responseText.split('|');

	if( res_ar[0] == 'success' ){
		var all_images = res_ar[1].split('^^');
		
		for( i=0; i<all_images.length; i++){
			jQuery('.thumb_container').prepend('<img  class="single_thumb" title="Click to remove!" src="'+all_images[i]+'"  />');
		}
		
		jQuery('#video_feat_uploader').attr('src', res_ar[1]);
		//jQuery('.video_overlay').fadeOut();

	}else{
		jQuery(".video_stat_bar").html( "Images Error" );
	}
	jQuery('#status_ajax').fadeOut();
	 process_thumb_json()
}

function process_thumb_json(){
	var thumb_joson = [];
	$('.thumb_container .single_thumb').each(function(){
		thumb_joson.push( $(this).attr('src') );
	})
	$('#thumb_array').val( JSON.stringify( thumb_joson ) );
}
	
}); // main jquery container
