<?php

/**
*
*JW PLAYER 7 FOR WORDPRESS/ ADMINISTRATION FUNCTIONS
*
*/


add_action( 'admin_menu', 'jwppp_add_menu' );
add_action( 'admin_init', 'jwppp_register_js_menu' );
add_action( 'admin_menu', 'jwppp_js_menu' );


//GET THE SCRIPT REQUIRED FROM THE MENU
function jwppp_register_js_menu() {
	wp_register_script('jwppp-admin-nav', plugins_url('js/jwppp-admin-nav.js', 'jwppp/js'), array('jquery'), '1.0', true );
}

function jwppp_js_menu() {
	wp_enqueue_script('jwppp-admin-nav');
}


//MENU ITEMS
function jwppp_add_menu() {
	$jwppp_page = add_menu_page( 'JW Player 7 for Wordpress', 'Clickyab JW Player', 'manage_options', 'jwppp', 'jwppp_options');
	
	//SCRIPT
	add_action( 'admin_print_scripts-' . $jwppp_page, 'jwppp_js_menu');
	
	return $jwppp_page;
}

//OPTION PAGE
function jwppp_options() {
	
	//CAN YOU?
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'It looks like you do not have sufficient permissions to view this page.', 'jwppp' ) );
	}

//INIZIO TEMPLATE DI PAGINA
echo '<div class="wrap">'; 
echo '<div class="wrap-right" style="float:right; width:70%;">';

	echo '<div id="jwppp-description">';
	    //HEADER
		echo "<h1 class=\"jwppp main\">" . __( 'JW Player 7 for Wordrpess', 'jwppp' ) . "<span style=\"font-size:60%;\"> 1.3.1</span></h1>";
	echo '</div>';

?>
	    
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

	<h2 id="jwppp-admin-menu " class="nav-tab-wrapper">
		<a href="#" data-link="jwppp-settings" class="nav-tab"><?php echo __('Settings', 'jwppp'); ?></a>
		<a href="#" data-link="jwppp-related" class="nav-tab"><?php echo __('Related videos', 'jwppp'); ?></a>
		<a href="#" data-link="jwppp-social" class="nav-tab"><?php echo __('Sharing', 'jwppp'); ?></a>
	</h2>


	<!-- START - SETTINGS -->
 	<div id="jwppp-settings" class="jwppp-admin">

 		<?php

 			echo '<form id="jwppp-options" method="post" action="">';
 			echo '<table class="form-table">';

			//JW PLAYER LIBRARY URL
			$library = sanitize_text_field(get_option('jwppp-library'));
 			if(isset($_POST['jwppp-library'])) {
 				$library = sanitize_text_field($_POST['jwppp-library']);
 				update_option('jwppp-library', $library);
 			}

 			//JUST A LITTLE OF STYLE
 			echo '<style>';
 			echo '.question-mark {position:relative; float:right; top:2px; right:12rem;}';
 			echo '</style>';

 			echo '<tr>';
 			echo '<th scope="row">' . __('Player library URL', 'jwppp');
 			echo '<td>';
 			echo '<input type="text" class="regular-text" id="jwppp-library" name="jwppp-library" value="' . $library . '" />';
 			echo '<p class="description">http://example.com/jwplayer.js</p>';
 			echo '</td>';
 			echo '</tr>';

 			//JW PLAYER LICENCE KEY
 			$licence = sanitize_text_field(get_option('jwppp-licence'));
 			if(isset($_POST['jwppp-licence'])) {
 				$licence = sanitize_text_field($_POST['jwppp-licence']);
 				update_option('jwppp-licence', $licence);
 			}
 			echo '<tr>';
 			echo '<th scope="row">' . __('JWP Licence Key', 'jwppp');

 			echo '<td>';
 			echo '<input type="text" class="regular-text" id="jwppp-licence" name="jwppp-licence" value="' . $licence . '" />';
 			echo '<p class="description">' . __('Add your JW Player self-hosted license key.', 'jwppp');
 			echo ' Don\'t you have one? <a href="http://www.jwplayer.com/sign-up/" target="_blank">Take it</a>, it\'s free.</p>';
 			echo '</td>';
 			echo '</tr>';

 			//POST TYPES WITH WHICH USE THE PLUGIN
 			$jwppp_get_types = array('post', 'page');

 			echo '<tr>';
 			echo '<th scope="row">' . __('Post types', 'jwppp') . '</th>';
 			echo '<td>';

 			foreach($jwppp_get_types as $type) {
 					$var_type = get_option('jwppp-type-' . $type);
 					if(isset($_POST['done'])) {
 						$var_type = isset($_POST[$type]) ? $_POST[$type] : 0;
 						update_option('jwppp-type-' . $type, $var_type);
 					}
	 				echo '<input type="checkbox" name="' . $type . '" id="' . $type . '" value="1"';
	 				echo ($var_type == 1) ? 'checked="checked"' : '';
	 				echo ' /><span class="jwppp-type">' . ucfirst($type) . '</span><br>';
 			}
 			echo '<p class="description">' . __('Select the type of content where display videos.', 'jwppp') . '<br>';
 			echo '</td>';
 			echo '</tr>';


 			//BEFORE OR AFTER THE CONTENT
 			$position = get_option('jwppp-position');
 			if(isset($_POST['position'])) {
 				$position = $_POST['position'];
 				update_option('jwppp-position', $_POST['position']);
 			}

 			echo '<th scope="row">' . __('Video Player position', 'jwppp') . '</th>';
 			echo '<td>';
 			echo '<select id="position" name="position" />';
 			echo '<option id="before-content"  name="before-content" value="before-content"';
 			echo ($position == 'before-content') ? ' selected="selected"' : '';
 			echo ' />' . __('Before the content', 'jwppp');
 			echo '<option id="after-content"  name="after-content" value="after-content"';
 			echo ($position == 'after-content') ? ' selected="selected"' : '';
 			echo ' />' . __('After the content', 'jwppp');
 			echo '<option id="custom"  name="custom" value="custom"';
 			echo ($position == 'custom') ? ' selected="selected"' : '';
 			echo ' />' . __('Custom', 'jwppp');
 			echo '</select>';
 			echo '<p class="description">' . __('Select the location where you want the video player is displayed.', 'jwppp') . '<br>';
 			echo __('For custom position use the shortcode <b>[jw7-video]</b>.', 'jwppp') . '</p>';
 			echo '</td>';
 			echo '</tr>';

// 			//TEXT
// 			echo '<tr>';
// 			echo '<th scope="row">' . __('Video text', 'jwppp') . '</th>';
// 			echo '<td>';
// 			echo '<textarea cols="40" rows="2" id="jwppp-text" name="jwppp-text" disabled="disabled" placeholder="' . __('Loading the player...', 'jwppp') . '">' . $jwppp_text . '</textarea>';
// 			echo '<p class="description">' . __('Add custom text that appears while the player is loading.', 'jwppp') . '<br>';
// 			echo '<a href="http://www.ilghera.com/product/jw-player-7-for-wordpress-premium/" target="_blank">Upgrade</a></p>';
// 			echo '</td>';
// 			echo '</tr>';


		$clickyab_plugin_url = sanitize_text_field(get_option('jwppp-clickyab-plugin-url'));
		if(isset($_POST['jwppp-clickyab-plugin-url'])) {
			$clickyab_plugin_url = sanitize_text_field($_POST['jwppp-clickyab-plugin-url']);
			update_option('jwppp-clickyab-plugin-url', $clickyab_plugin_url);
		}

		//LOGO LINK
		echo '<tr>';
		echo '<th scope="row">' . __('jwppp-clickyab-vast-url-js', 'jwppp') . '</th>';
		echo '<td>';
		echo '<input type="text" class="regular-text" id="jwppp-clickyab-plugin-url" name="jwppp-clickyab-plugin-url" ';
		echo 'placeholder="http://a.clickyab.com/ads/vast/?a=2081450003094&l=106" value="' . $clickyab_plugin_url . '" />';
		echo '<p class="description">http://a.clickyab.com/ads/vast/?a=2081450003094&l=106<br>';
		echo '</td>';
		echo '</tr>';

		$clickyab_vast_url_js = sanitize_text_field(get_option('jwppp-clickyab-vast-url-js'));
		if(isset($_POST['jwppp-clickyab-vast-url-js'])) {
			$clickyab_vast_url_js = sanitize_text_field($_POST['jwppp-clickyab-vast-url-js']);
			update_option('jwppp-clickyab-vast-url-js', $clickyab_vast_url_js);
		}

		//LOGO LINK
		echo '<tr>';
		echo '<th scope="row">' . __('js plugin clickyab url', 'jwppp') . '</th>';
		echo '<td>';
		echo '<input type="text" class="regular-text" id="jwppp-clickyab-vast-url-js" name="jwppp-clickyab-vast-url-js" ';
		echo 'placeholder="http://static.clickyab.com/js/vastAD.js" value="' . $clickyab_vast_url_js . '" />';
		echo '<p class="description">http://static.clickyab.com/js/vastAD.js<br>';
		echo '</td>';
		echo '</tr>';

 			//POSTER IMAGE
 			$poster_image = sanitize_text_field(get_option('jwppp-poster-image'));
 			if(isset($_POST['poster-image'])) {
 				$poster_image = sanitize_text_field($_POST['poster-image']);
 				update_option('jwppp-poster-image', $poster_image);
 			}

 			echo '<tr>';
 			echo '<th scope="row">' . __('Default poster image', 'jwppp') . '</th>';
			echo '<td>';
			echo '<input type="text" class="regular-text" id="poster-image" name="poster-image" value="' . $poster_image . '" />';
			echo '<p class="description">' . __('Add the url of a default poster image.', 'jwppp') . '</p>';
			echo '<td>';
 			echo '</tr>';

 		
 			//PLAYER FIXED WIDTH
 			$jwppp_player_width = sanitize_text_field(get_option('jwppp-player-width'));
 			if(isset($_POST['jwppp-player-width'])) {
 				$jwppp_player_width = sanitize_text_field($_POST['jwppp-player-width']);
 				update_option('jwppp-player-width', $jwppp_player_width);
 			}

 			//PLAYER FIXED HEIGHT
 			$jwppp_player_height = sanitize_text_field(get_option('jwppp-player-height'));
 			if(isset($_POST['jwppp-player-height'])) {
 				$jwppp_player_height = sanitize_text_field($_POST['jwppp-player-height']);
 				update_option('jwppp-player-height', $jwppp_player_height);
 			}

// 			//FIXED DIMENSIONS OR RESPONSIVE?
// 			echo '<tr>';
// 			echo '<th scope="row">Player dimensions</th>';
// 			echo '<td>';
// 			echo '<select id="jwppp-method-dimensions" name="jwppp-method-dimensions" disabled="disabled" />';
// 			echo '<option name="fixed" id="fixed" value="fixed" ';
// 			echo 'selected="selected"';
// 			echo '>' . __('Fixed', 'jwppp') . '</option>';
// 			echo '</select>';
// 			echo '<p class="description">' . __('Select how define the measures of the player.', 'jwppp') . '<br>';
// 			echo '<a href="http://www.ilghera.com/product/jw-player-7-for-wordpress-premium/" target="_blank">Upgrade</a> for a responsive player</p>';
// 			echo '</td>';
// 			echo '</tr>';

 			//PLAYER FIXED WIDTH & HEIGHT
 			echo '<tr class="more-fixed">';
 			echo '<th scope="row">' . __('Fixed measures', 'jwppp') . '</th>';
 			echo '<td>';
 			echo '<input type="number" min="1" step="1" class="small-text" id="jwppp-player-width" name="jwppp-player-width" value="';
			echo ($jwppp_player_width != null) ? $jwppp_player_width : '640';
			echo '" />';
			echo ' x ';
			echo '<input type="number" min="1" step="1" class="small-text" id="jwppp-player-height" name="jwppp-player-height" value="';
			echo ($jwppp_player_height != null) ? $jwppp_player_height : '360';
			echo '" />';
 			echo '<p class="description"></p>';
 			echo '</td>';
 			echo '</tr>';


			//SKIN
 			$jwppp_skin = sanitize_text_field(get_option('jwppp-skin'));
 			if(isset($_POST['jwppp-skin'])) {
 				$jwppp_skin = sanitize_text_field($_POST['jwppp-skin']);
 				update_option('jwppp-skin', $jwppp_skin);
 			}

			echo '<tr>';
			echo '<th scope="row">' . __('Skin', 'jwppp') . '</th>';
			echo '<td>';
			echo '<select id="jwppp-skin" name="jwppp-skin" />';
			echo '<option name="none" value="none" ';
			echo ($jwppp_skin == 'none') ? 'selected="selected"' : '';
			echo '>--</option>';
			echo '<option name="seven" value="seven" ';
			echo ($jwppp_skin == 'seven') ? 'selected="selected"' : '';
			echo '>Seven</option>';
			echo '<option name="six" value="six" ';
			echo ($jwppp_skin == 'six') ? 'selected="selected"' : '';
			echo '>Six</option>';
			echo '<option name="five" value="five" ';
			echo ($jwppp_skin == 'five') ? 'selected="selected"' : '';
			echo '>Five</option>';
			echo '</select>';
			echo '<p class="description">' . __('Choose a skin to customize your player.', 'jwppp') . '<br>';

			echo '</td>';
			echo '</tr>';

		
//			//LOGO
//			echo '<tr>';
//			echo '<th scope="row">' . __('Logo', 'jwppp') . '</th>';
//			echo '<td>';
//			echo '<input type="text" class="regular-text" id="jwppp-logo" name="jwppp-logo" disabled="disabled" ';
//			echo 'placeholder="' . __('Image url', 'jwppp') . '" value="' . $jwppp_logo . '" />';
//			echo '<p class="description">' . __('Add your logo to the player.', 'jwppp') . '<br>';
// 			echo '<a href="http://www.ilghera.com/product/jw-player-7-for-wordpress-premium/" target="_blank">Upgrade</a></p>';
//			echo '</td>';
//			echo '</tr>';

//			//LOGO POSITION
//			echo '<tr>';
//			echo '<th scope="row">' . __('Logo Position', 'jwppp') . '</th>';
//			echo '<td>';
//			echo '<select id="jwppp-logo-vertical" name="jwppp-logo-vertical" disabled="disabled"/>';
//			echo '<option id="top" name="top" value="top" selected="selected">Top</option>';
//			echo '<option id="bottom" name="bottom" value="bottom">Bottom</option>';
//			echo '</select>';
//			echo '<select style="margin-left: 0.5rem;" id="jwppp-logo-horizontal" name="jwppp-logo-horizontal" disabled="disabled" />';
//			echo '<option id="right" name="right" value="right" selected="selected">Right</option>';
//			echo '<option id="left" name="left" value="left">Left</option>';
//			echo '</select>';
//			echo '<p class="description">' . __('Choose the logo position.', 'jwppp') . '</p>';
//			echo '</td>';
//			echo '</tr>';
			
			//LOGO LINK
//			echo '<tr>';
//			echo '<th scope="row">' . __('Logo Link', 'jwppp') . '</th>';
//			echo '<td>';
//			echo '<input type="text" class="regular-text" id="jwppp-logo-link" name="jwppp-logo-link" disabled="disabled" ';
//			echo 'placeholder="' . __('Link url', 'jwppp') . '" value="' . $jwppp_logo_link . '" />';
//			echo '<p class="description">' . __('Add a link to the logo.', 'jwppp') . '<br>';
// 			echo '<a href="http://www.ilghera.com/product/jw-player-7-for-wordpress-premium/" target="_blank">Upgrade</a></p>';
//			echo '</td>';
//			echo '</tr>';

 			echo '</table>';

 			echo '<input type="hidden" name="done" value="1" />';
 			echo '<input type="submit" class="button button-primary" value="' . __('Save changes ', 'jwppp') . '" />';
 			echo '</form>';
 		?>
 	</div>
	<!-- END - SETTINGS -->


	<!-- START - RELATED VIDEOS -->
	<div id="jwppp-related" class="jwppp-admin">

		<?php //GET INFO FROM DATABASE

		//SHOW RELATED?
		$jwppp_show_related = sanitize_text_field(get_option('jwppp-show-related'));
		if($_POST['set'] == 1) {
			$jwppp_show_related = isset($_POST['jwppp-show-related']) ? $_POST['jwppp-show-related'] : 0;
			update_option('jwppp-show-related', $jwppp_show_related);
		}
		

		//FORM RELATED VIDEOS
		echo '<form id="post-image" name="post-image" method="post" action="">';
		echo '<table class="form-table">';

		//SHOW RELATED?
		echo '<tr>';
		echo '<th scope="row">' . __('Active Related Videos option', 'jwppp') . '</th>';
		echo '<td>';
		echo '<input type="checkbox" id="jwppp-show-related" name="jwppp-show-related" value="1"';
		echo ($jwppp_show_related == 1) ? ' checked="checked"' : '';
		echo '/>';
		echo '<p class="description">' . __('Show Related Videos overlay as default option.', 'jwppp') . '</p>';
		echo '</td>';
		echo '</tr>';

		//HEADING
		echo '<tr class="related-options">';
		echo '<th scope="row">' . __('Heading', 'jwppp') . '</th>';
		echo '<td>';
		echo '<input type="text" class="regular-text" id="jwppp-related-heading" name="jwppp-related-heading" disabled="disabled"';
		echo 'placeholder="' . __('Related Videos', 'jwppp') . '" value="More videos" />';
		echo '<p class="description">' . __('Add a custom heading, default is <strong>Related Videos</strong>.', 'jwppp') . '<br>'; 
//		echo '<a href="http://www.ilghera.com/product/jw-player-7-for-wordpress-premium/" target="_blank">Upgrade</a></p>';
		echo '</td>';
		echo '</tr>';

		//THUMBNAIL
		echo '<tr class="related-options">';
		echo '<th scope="row">' . __('Related image', 'jwppp') . '</th>';
		echo '<td>';
		echo '<select id="thumbnail" name="thumbnail" disabled="disabled" />';

		echo '<option id="featured-image" value="featured-image"';
		echo 'selected="selected">';
		echo __('Featured image', 'jwppp') . '</option>';;

		echo '</select>';
		echo '<p class="description">' . __('Select how get images for related contents.', 'jwppp') . '<br>';
//		echo '<a href="http://www.ilghera.com/product/jw-player-7-for-wordpress-premium/" target="_blank">Upgrade</a></p>';
		echo '</td>';
		echo '</tr>';

		//DIMENSIONS
		echo '<tr class="related-options">';
		echo '<th scope="row">' . __('Thumbnail size', 'jwppp') . '</th>';
		echo '<td>';
		echo '<input type="number" min="1" step="1" class="small-text" id="jwppp-related-width" name="jwppp-related-width" disabled="disabled" value="';
		echo '140';
		echo '" />';
		echo ' x ';
		echo '<input type="number" min="1" step="1" class="small-text" id="jwppp-related-height" name="jwppp-related-height" disabled="disabled" value="';
		echo '80';
		echo '" />';
		echo '<p class="description">' . __('Set the dimensions of each thumbnail in pixels. Default is <strong>140x80</strong>.', 'jwppp') . '<br>';
//		echo '<a href="http://www.ilghera.com/product/jw-player-7-for-wordpress-premium/" target="_blank">Upgrade</a></p>';
		echo '</td>';
		echo '</tr>';


		echo '</table>';
		echo '<input type="hidden" name="set" value="1" />';
		echo '<input class="button button-primary" type="submit" id="submit" value="' . __('Save chages', 'jwppp') . '">';

		echo '</form>'; ?>

	</div>
	<!-- END - RELATED VIDEOS -->


	<!-- START -  SHARING -->
	<div id="jwppp-social" class="jwppp-admin">

		<?php 
			//ACTIVE SHARE?
			$active_share = sanitize_text_field(get_option('jwppp-active-share'));
			if(isset($_POST['share-sent'])) {
				$active_share = isset($_POST['jwppp-active-share']) ? $_POST['jwppp-active-share'] : 0;
				update_option('jwppp-active-share', $active_share);
			}
			//HEADING
			$share_heading = get_option('jwppp-share-heading');
			if(isset($_POST['share-heading'])) {
				$share_heading = sanitize_text_field($_POST['share-heading']);
				update_option('jwppp-share-heading', $share_heading);
			} 
			//EMBED?
			$jwppp_embed_video = sanitize_text_field(get_option('jwppp-embed-video'));
			if(isset($_POST['share-sent'])) {
				$jwppp_embed_video = isset($_POST['jwppp-embed-video']) ? $_POST['jwppp-embed-video'] : 0;
				update_option('jwppp-embed-video', $jwppp_embed_video);
			}
	
			echo '<form id="jwppp-sharing" name="jwppp-sharing" method="post" action="">';
			echo '<table class="form-table">';

			//ACTIVE SHARE?
			echo '<tr>';
			echo '<th scope="row">' . __('Active Share option', 'jwppp') . '</th>';
			echo '<td>';
			echo '<input type="checkbox" id="jwppp-active-share" name="jwppp-active-share" value="1"';
			echo ($active_share == 1) ? ' checked="checked"' : '' ;
			echo ' />';
			echo '<p class="description">' . __('Active <strong>share video</strong> as default option. You\'ll be able to change it on single video.', 'jwppp') . '</p>';
			echo '</td>';
			echo '</tr>';

			//HEADING
			echo '<tr class="share-options">';
			echo '<th scope="row">' . __('Heading', 'jwppp') . '</th>';
			echo '<td>';
			echo '<input type="text" class="regular-text" id="share-heading" name="share-heading" placeholder="' . __('Share Video', 'jwppp') . '" value="' . $share_heading . '" />';
			echo '<p class="description">' . __('Add a custom heading, default is <strong>Share Video</strong>', 'jwppp') . '</p>';
			echo '</td>';	
			echo '</tr>';

			//EMBED?
			echo '<tr class="share-options">';
			echo '<th scope="row">' . __('Active embed option', 'jwppp') . '</th>';
			echo '<td>';
			echo '<input type="checkbox" id="jwppp-embed-video" name="jwppp-embed-video" value="1"';
			echo ($jwppp_embed_video == 1) ? ' checked="checked"' : '';
			echo ' />';
			echo '<p class="description">' . __('Active <strong>embed video</strong> as default option. You\'ll be able to change it on single video.', 'jwppp') . '</p>';
			echo '</td>';
			echo '</tr>';

			echo '</table>';

			echo '<input type="hidden" name="share-sent" value="1" />';
			echo '<input class="button button-primary" type="submit" id="submit" value="' . __('Save options', 'jwppp') . '" />';
			echo '</form>';


		?>
 	</div>
	<!-- END - SOCIAL SHARING -->

	<!-- START ADS -->

	<!-- END ADS -->
	</div><!-- WRAP LEFT -->
	<div class="clear"></div>

</div>

<?php

}

//JWPPP FOOTER TEXT
function jwppp_footer_text($text) {
	$screen = get_current_screen();
	if($screen->id == 'toplevel_page_jw-player-7-for-wp') {
		$text = __('If you like <strong>JW Player 7 for Wordpress</strong>, please give it a <a href="https://wordpress.org/support/view/plugin-reviews/jw-player-7-for-wp?filter=5#postform" target="_blank">★★★★★</a> rating. Thanks in advance! ', 'jwppp');
		echo $text;
	} else {
		echo $text;
	}
}
add_filter('admin_footer_text', 'jwppp_footer_text');
