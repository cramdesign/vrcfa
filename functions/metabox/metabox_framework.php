<?php
/**
 * Dev7studios Meta Box Framework
 * 
 * @author Gilbert Pellegrom with several changes by Matt Cram
 * @link https://github.com/Dev7studios/Dev7studios-Meta-Box-Framework
 * @version 1.0.4
 * @license MIT
 */

if( !class_exists( 'Dev7_Meta_Box_Framework' ) ) : class Dev7_Meta_Box_Framework {

	function __construct() {
		add_action( 'admin_init', array(&$this, 'admin_init') );
		add_action( 'add_meta_boxes', array(&$this, 'add_meta_boxes') );
		add_action( 'pre_post_update', array(&$this, 'meta_box_save') );
		add_action( 'admin_enqueue_scripts', array(&$this, 'admin_scripts') );
	}

	function admin_init() {
		do_action( 'dev7_meta_boxes' );
	}

	function admin_scripts( $hook ) {
		if( $hook == 'post.php' or $hook == 'post-new.php' ) :
			$path = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, dirname( __FILE__ ) );
			wp_enqueue_style( 'metabox_style', $path . '/metabox_style.css' );
		endif;
	}
	
	function add_meta_boxes() {

		global $dev7_meta_boxes;
		
		if( !is_array($dev7_meta_boxes) ) return;

		foreach( $dev7_meta_boxes as $meta_box ){
			
			if( isset( $meta_box['template'] ) ) :
			
				if( isset( $_GET['post'] ) ) :
					
					$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
					$template = basename( get_post_meta( $post_id, '_wp_page_template', true ) );
				    if( $meta_box['template'] != $template ) return;
					
					add_meta_box( $meta_box['id'], $meta_box['title'], array(&$this, 'meta_box_output'), $meta_box['pages'], $meta_box['context'], $meta_box['priority'], array('dev7_meta_box' => $meta_box) );
				
				endif;
				
			elseif( is_array($meta_box['pages']) ) :
			
				foreach( $meta_box['pages'] as $page ){
					add_meta_box( $meta_box['id'].'_mb', $meta_box['title'], array(&$this, 'meta_box_output'), $page, $meta_box['context'], $meta_box['priority'], array('dev7_meta_box' => $meta_box) );
				}
				
			else :
			
				add_meta_box( $meta_box['id'], $meta_box['title'], array(&$this, 'meta_box_output'), $meta_box['pages'], $meta_box['context'], $meta_box['priority'], array('dev7_meta_box' => $meta_box) );
				
			endif;
		}
	}

	function meta_box_save( $post_id ) {

		if ( !current_user_can( 'edit_page', $post_id ) || !current_user_can( 'edit_post', $post_id ) ) return;
		if ( !isset( $_POST['dev7_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['dev7_meta_box_nonce'], plugin_basename( __FILE__ ) ) ) return;

		global $dev7_meta_boxes;
		

		if( !is_array($dev7_meta_boxes) ) return;

		foreach( $dev7_meta_boxes as $meta_box ){
			if( isset($meta_box['fields']) && is_array($meta_box['fields']) ){
				foreach( $meta_box['fields'] as $field ){
					if( isset($field['id']) ){
						if( $field['type'] == 'checkboxes' && isset($field['choices']) ){
							foreach( $field['choices'] as $ckey=>$cval ){
								if( isset($_POST[$field['id'] .'_'. $ckey]) ){
									update_post_meta( $post_id, $field['id'] .'_'. $ckey, $_POST[$field['id'] .'_'. $ckey] );
								}
							}
						} elseif( isset($_POST[$field['id']]) ){
							update_post_meta( $post_id, $field['id'], $_POST[$field['id']] );
						}
					}
				}
			}
		}
	}

	function meta_box_output( $post, $args ) {
	
		global $dev7_meta_boxes;
		
		if( !is_array($dev7_meta_boxes) ) return;
		
		wp_nonce_field( plugin_basename( __FILE__ ), 'dev7_meta_box_nonce' );

		foreach( $dev7_meta_boxes as $meta_box ){
		
			if( isset($args['args']['dev7_meta_box']['id']) && $args['args']['dev7_meta_box']['id'] == $meta_box['id'] ){
				if( isset($meta_box['fields']) && is_array($meta_box['fields']) ){

					echo '<table class="meta">';

					foreach( $meta_box['fields'] as $field ) :
										
/*
						if( isset($field['type']) )		$type 	= $field['type'];
						if( isset($field['desc']) ) 	$desc 	= $field['desc'];
						if( isset($field['id']) ) 		$id 	= $field['id'];
						if( isset($field['std']) ) 		$std	= $field['std'];
						if( isset($field['args']) ) 	$args	= $field['args'];
*/

						isset($field['type']) 	? $type = $field['type'] 	: $type = false;
						isset($field['label']) 	? $label = $field['label'] 	: $label = false;
						isset($field['desc']) 	? $desc = $field['desc'] 	: $desc = false;
						isset($field['id']) 	? $id = $field['id'] 		: $id = false;
						isset($field['std']) 	? $std = $field['std'] 		: $std = false;
						isset($field['args']) 	? $args = $field['args'] 	: $args = false;
						isset($field['hr']) 	? $class = 'hr ' . $type 	: $class = $type;

						echo '<tr class="' . $class . '">';
						
						if( $label ){
							echo '<th>' . $label . '</th> ';
							echo '<td>';
						} else {
							echo '<td colspan="2">';
						}

						if( $type == 'message' ) {

							echo $desc;

						} elseif( $id && $type ) {

							$value = get_post_meta( $post->ID, $id, true );
							if( $value === false && $std ) $value = $std;
							
							if( $type == 'checkboxes' && $args ){
								$value = array();
								foreach( $args as $ckey=>$cval ){
									$value[$id .'_'. $ckey] = get_post_meta( $post->ID, $id .'_'. $ckey, true );
								}
							}

							switch( $type ) :

								case 'text':
									$value = esc_attr(stripslashes($value));
									echo '<input type="text" name="'. $id .'" id="'. $id .'" value="'. $value .'" />';
									break;

								case 'textarea':
									$value = esc_html(stripslashes($value));
									echo '<textarea name="'. $id .'" id="'. $id .'">'. $value .'</textarea>';
									break;

								case 'select':
									$value = esc_html(esc_attr($value));
									if( $args ){
										echo '<select name="'. $id .'" id="'. $id .'">';
										foreach( $args as $ckey=>$cval ){
											echo $ckey;
											echo '<option value="'. $ckey .'"'. (($ckey == $value) ? ' selected="selected"' : '') .'>'. $cval .'</option>';
										}
										echo '</select>';
									}
									break;

								case 'radio':
									$value = esc_html(esc_attr($value));
									if( $args ){
										foreach( $args as $ckey=>$cval ){
											echo '<label><input type="radio" name="'. $id .'" id="'. $id .'_'. $ckey .'" value="'. $ckey .'"'. (($ckey == $value) ? ' checked="checked"' : '') .' /> '. $cval .'</label><br />';
										}
									}
									break;

								case 'checkbox':
									$value = esc_attr(stripslashes($value));
									echo '<input type="hidden" name="'. $id .'" value="0" />';
									echo '<label><input type="checkbox" name="'. $id .'" id="'. $id .'" value="1"'. (($value) ? ' checked="checked"' : '') .' /> '.$desc.'</label>';
									break;

								case 'checkboxes':
									if( $args ){
										foreach( $args as $ckey=>$cval ){
											$val = '';
											if(isset($value[$id .'_'. $ckey])) $val = $value[$id .'_'. $ckey];
											elseif(is_array($std) && in_array($ckey, $field['std'])) $val = $ckey;
											$val = esc_html(esc_attr($val));
											echo '<input type="hidden" name="'. $id .'_'. $ckey .'" value="0" />';
											echo '<label><input type="checkbox" name="'. $id .'_'. $ckey .'" id="'. $id .'_'. $ckey .'" value="'. $ckey .'"'. (($ckey == $val) ? ' checked="checked"' : '') .' /> '. $cval .'</label><br />';
										}
									}
									break;

								case 'wysiwyg':
									$value = esc_html(stripslashes($value));
									wp_editor( $value, $id, $args );
									break;

								default:
									break;

							endswitch;

							if( $desc && 'checkbox' != $type ) echo '<p class="description">'. $desc .'</p>';

						}
						
						echo '</td></tr>';

					endforeach;

					echo '</table>';

				}
			}
		}
	}
	
}
new Dev7_Meta_Box_Framework();
endif;



if( !function_exists( 'dev7_add_meta_box' ) ) :	function dev7_add_meta_box( $meta_box ) {

	global $dev7_meta_boxes;
	if( !is_array($dev7_meta_boxes) ) $dev7_meta_boxes = array();
	$dev7_meta_boxes[] = $meta_box;

} endif;



// simple way to return the value

if ( !function_exists( 'get_metabox' ) ) : function get_metabox( $key = "" ) {

	return get_post_meta( get_the_ID(), $key, true );

} endif;

if ( !function_exists( 'the_metabox' ) ) : function the_metabox( $key = "" ) {

	echo get_metabox( $key );

} endif;

