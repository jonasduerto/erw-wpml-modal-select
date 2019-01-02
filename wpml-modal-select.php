<?php
/**
 * Plugin Name: ERW Modal Lang Select
 * Description: ERW WPML Languaje Selector is a simple Modal for select languaje by cookie
 * Plugin URI: http://www.elreyweb.com/
 * Author: Team elreyweb
 * Author URI: http://www.elreyweb.com/
 * Version: 2.0.8
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: erwlangselect
 


 * Name is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Name is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Name. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

defined( 'ABSPATH' ) or exit;


#admin_menu
add_action("admin_menu", function() {	
	# add_menu_page adds page directly on the sidebar
	add_menu_page( "Modal lang", "Modal lang", "manage_options", "msl_settings", function() {
		?><div class="wrap">
			<h1><?php echo get_admin_page_title();?></h1>
			<hr color='#333' size='4'>
			<form action="options.php" method="post">
			<?php
				settings_fields( "msl_option_group" );
				do_settings_sections( "msl_settings" );
				submit_button();
			?>
			</form>
		</div><?php
	});
});

add_action( "admin_init", function() {
	register_setting( 'msl_option_group', 'msl_option' );

	#add_sections_and_settings_here

	add_settings_section( 'msl_settings_simple_conf', 'Section Label',
	function(){echo'<div style="margin-left:8%">';}, 'msl_settings' );

	#sublime-snippets: add_settings_textfield | add_settings_checkbox | 
	# add_settings_radio | add_settings_testarea | add_settings_select

	add_settings_field( 'msl_option_show', 'Active Modal select lang', function() {	
		$value = get_option( 'msl_option' )[ "msl_option_show" ];
		?>
		<input type="checkbox" name="msl_option[msl_option_show]"
			<?php checked( $value, 1 ); ?> value="1">
		<?php
	}, 'msl_settings', 'msl_settings_simple_conf' );
	
	add_settings_field( 'msl_option_{2:id}_textfield', 'Show Logo',function() { ?>
		<input type="text" 
			name="msl_option[msl_option_show_logo]" 
			id="msl_option_show_logo" 
			value="<?php echo esc_attr( get_option( 'msl_option' )[ 'msl_option_show_logo' ] ); ?>">
		<a class="button" onclick="upload_image('msl_option_show_logo');">Upload Favicon</a>

		<script type="text/javascript">
				var uploader;
				function upload_image(id) {

				  //Extend the wp.media object
				  uploader = wp.media.frames.file_frame = wp.media({
				    title: 'Choose Image',
				    button: {
				      text: 'Choose Image'
				    },
				    multiple: false
				  });

				  //When a file is selected, grab the URL and set it as the text field's value
				  uploader.on('select', function() {
				    attachment = uploader.state().get('selection').first().toJSON();
				    var url = attachment['url'];
				    jQuery('#'+id).val(url);
				  });

				  //Open the uploader dialog
				  uploader.open();
				}
		</script>

		<?php
	}, 'msl_settings', 'msl_settings_simple_conf' );

	add_settings_field( 'msl_option_txt_en', 'Add Text for secction English', function() {	
		$value = get_option( 'msl_option' )[ "msl_option_txt_en" ]; ?>
		<textarea cols="40" rows="5" name="msl_option[msl_option_txt_en]"> 
			<?php echo $value; ?>
		</textarea>
		<?php
	}, 'msl_settings', 'msl_settings_simple_conf' );

	add_settings_field( 'msl_option_txt_es','Add Text for secction Spanish', function() {	
		$value = get_option( 'msl_option' )[ "msl_option_txt_es" ]; ?>
		<textarea cols="40" rows="5" name="msl_option[msl_option_txt_es]"> 
			<?php echo $value; ?>
		</textarea>
		<?php
	}, 'msl_settings', 'msl_settings_simple_conf' );

	add_settings_section('/msl_settings_simple_conf','', # dummy section to close div
	function(){echo"</div>\r\n";},'msl_settings'); 

});



// queue up the necessary js
add_action('admin_enqueue_scripts', function () {
	add_thickbox();
	wp_enqueue_media();
});


//Functions
function get_id_by_slug($page_slug, $slug_page_type = 'page') {
	$find_page = get_page_by_path($page_slug, OBJECT, $slug_page_type);
	if ($find_page) {
		return $find_page->ID;
	} else {
		return null;
	}
}

add_action('wp_footer','slider_option');

// add script to the footer and break out of PHP
function slider_option(){
global $sitepress;
global $wp;
?>

	<!-- Modal -->
	<div id="languageSelector" class="modal pulse animated"  tabindex="-1" role="dialog" aria-labelledby="languageSelector">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">

				<?php if (get_option( 'msl_option' )[ "msl_option_show_logo" ] != ''): ?>
					<img 
						src="<?php echo get_option( 'msl_option' )[ "msl_option_show_logo" ]; ?>" 
						class="img-responsive center-block"
						alt="<?php bloginfo( 'name' ); ?>" 
						height="50" />
				<?php endif ?>
				    <div id="text_en" class="white text-center flipInY animated">
				        <?php echo get_option( 'msl_option' )[ "msl_option_txt_en" ]; ?>
				    </div>
				    <div id="text_es" class="white text-center flipInX animated">
				        <?php echo get_option( 'msl_option' )[ "msl_option_txt_es" ]; ?>
				    </div>
				</div>
				<div class="modal-footer text-center center-block">
				<?php 
					global $post;
					$post_slug = (is_front_page()) ? "" : $post->post_name .'/';
					$languages = icl_get_languages('skip_missing=0');
					$actUrlLang = "";
					foreach($languages as $l){ 
					    if($l['active']){ 
							$url = $l['url'] .$post_slug;
							$actUrlLang = $l['url'];
					        echo "<a id='btn_{$l['language_code']}' 
					        	class='btn btn-primary slclick' 
					        	data-languagecode='{$l['language_code']}' 
					        	href='{$url}'>{$l['native_name']}</a>";
					    }else {
							$url = $l['url'] .$post_slug;
							echo "<a id='btn_{$l['language_code']}' 
								class='btn btn-default slclick' 
								data-languagecode='{$l['language_code']}' 
								href='{$url}'>{$l['native_name']}</a>";
					    }
					}
				 ?>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
	var showMSL     = '<?php echo get_option( 'msl_option' )[ "msl_option_show" ]; ?>';
	var current_url = '<?php echo home_url(add_query_arg(array(),$wp->request)); ?>';
	var getLangCode = '<?php echo apply_filters( 'wpml_current_language', NULL );  ?>';
	var actUrlLang  = "<?php echo $actUrlLang; ?>";
	var curent_slug = "<?php echo $post_slug = (is_front_page()) ? "" : $post->post_name .'/'; ?>";
</script>

<?php }

	add_action( 'wp_enqueue_scripts', function() {
		wp_enqueue_style( 'msl-mamin', plugin_dir_url(__FILE__).'/assets/erwlangselect.css', false, false, false );
		wp_enqueue_script( 'cookie', plugin_dir_url(__FILE__).'/assets/js/js.cookie.js', array( 'jquery' ), false, false);
		wp_enqueue_script( 'msl-mamin', plugin_dir_url(__FILE__).'/assets/js/erwlangselect.js', array( 'jquery' ), false, false);
	});


