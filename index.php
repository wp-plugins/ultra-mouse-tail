<?php
/*
	Plugin Name: Ultra Mouse-Tail
	Plugin URI: http://www.themeultra.com/downloads/ultra-mouse-tail/
	Description: This is a Awesome Mouse Tail Plugin. This plugin add animated Text with mouse cursor. Plugin <a href="http://www.themeultra.com/downloads/ultra-mouse-tail/"> Documentation and Demo </a> is available here. For any kind of technical Support <a href="http://www.themeultra.com/support/"> Click Here</a>
	Author: ThemeUltra.com
	Author URI: http://www.themeultra.com
	Version: 1.0.1
*/

 

/* Enqueue Java Script */
function ultra_mouse_tail_jquery_main_js() {
	wp_enqueue_script('jquery');;
}
add_action('init','ultra_mouse_tail_jquery_main_js');


/* Enqueue Java Script */
function ultra_mousetail_main_js() {
	wp_enqueue_script( 'ultra-mousetail-js', plugins_url( '/js/ultra_mousetail.js', __FILE__ ), array('jquery'), false);;
}
add_action('wp_footer','ultra_mousetail_main_js');


function ultra_mouse_tail_manu(){

	 add_options_page( 'Ultra Mouse Tail', 'Ultra Mouse Tail', 'manage_options', 'mouse-tail-page', 'ultea_mouse_tail_options_page_function', plugins_url( 'myplugin/images/icon.png' ),8 );

			 
}
add_action('admin_menu','ultra_mouse_tail_manu');
		  
// 2. Add default value array. 
$ultra_mouse_tail_options_default = array(
	'ultea_mouse_text' => "Stay With Us",
);

 

    if ( is_admin() ) : // 3. Load only if we are viewing an admin page	

  // 4. Add setting option by used function. 
function ultea_mouse_tail_register_settings() {
// Register settings and call sanitation functions
// 4. Add register setting. 
	register_setting( 'ultea_mouse_tail_p_options', 'ultra_mouse_tail_options_default', 'ultea_mouse_tail_validate_options' );
}

add_action( 'admin_init', 'ultea_mouse_tail_register_settings' );



 //1.2
 function ultea_mouse_tail_options_page_function(){?>
 
 <?php // 5.1. Add settings API hook under form action.  ?>
<?php global $ultra_mouse_tail_options_default ;


if ( ! isset( $_REQUEST['updated'] ) )
	$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. 

?>
	 
	 
   <div class="wrap">
	  <h2>Cursor Text setting</h2>
				  <?php if ( false !== $_REQUEST['updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
		<?php endif; // 5.2. If the form has just been submitted, this shows the notification ?>	
	  
	<form action="options.php" method="post">  
	  
	  

	<?php // 6.1 Add settings API hook under form action.  ?>
<?php $settings = get_option( 'ultra_mouse_tail_options_default', $ultra_mouse_tail_options_default ); ?>


<?php settings_fields( 'ultea_mouse_tail_p_options' );
/* 6.2  This function outputs some hidden fields required by the form,
including a nonce, a unique number used to ensure the form has been submitted from the admin page and not somewhere else, very important for security */ ?>



		
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><label for="ultea_mouse_text">Ultra MouseTail Cursor Text:</label></th>
					<td>
						<input type="text" class="" value="<?php echo stripslashes($settings['ultea_mouse_text']); ?>" id="ultea_mouse_text" name="ultra_mouse_tail_options_default[ultea_mouse_text]"/><p class="description">Please Type The text Which you want with cursor</p>
					</td>
			</tr>

	</tbody>

</table>


<p class="submit">
<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
</p>

</form>
			   
</div>
	 
	 
	<?php 
	 }
	 

  // 7. Add validate options. 
function ultea_mouse_tail_validate_options( $input ) {
	global $ultra_mouse_tail_options_default;

	$settings = get_option( 'ultra_mouse_tail_options_default', $ultra_mouse_tail_options_default );
	
	
	$input['ultea_mouse_text']=wp_filter_post_kses($input['ultea_mouse_text']);
	
	
	 // We strip all tags from the text field, to avoid vulnerablilties like XSS
	$prev=$settings['layout_only'];
	if(!array_key_exists($input['layout_only']))
	$input['layout_only']=$prev;
	

 return $input;
}





 
	endif;  //3. EndIf is_admin()	


// 8.data danamic
		
function ultea_mouse_tail_activator(){?>
<?php

	 global $ultra_mouse_tail_options_default;

	$ultra_mouse_tail_settings=get_option('ultra_mouse_tail_options_default','$ultra_mouse_tail_options_default'); ?>

		<!--use this where need dynamic data-->
		<?php // echo $ultra_mouse_tail_settings['ultea_mouse_text']; ?>
		<script type='text/javascript'>
			var text="<?php echo $ultra_mouse_tail_settings['ultea_mouse_text']; ?>";
		</script>	
			
		
		
<?php
}

add_action('wp_footer','ultea_mouse_tail_activator');




add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'my_plugin_action_links' );

function my_plugin_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=mouse-tail-page') ) .'">Settings</a>';
   $links[] = '<a href="http://www.themeultra.com/products/" target="_blank">More Item</a>';
   return $links;
}


?>