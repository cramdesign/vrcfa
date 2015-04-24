<?php

/* http://code.tutsplus.com/articles/custom-controls-in-the-theme-customizer--wp-34556 */

function cram_customize_register( $wp_customize ) {

	if (class_exists('WP_Customize_Control')) :
	    class WP_Customize_Category_Control extends WP_Customize_Control {
	        /**
	         * Render the control's content.
	         *
	         * @since 3.4.0
	         */
	        public function render_content() {
				
	            $dropdown = wp_dropdown_categories( array(
		                'taxonomy'			=> 'sbe_category',
						'hide_empty'		=> false,
	                    'name'              => '_customize-dropdown-categories-' . $this->id,
	                    'echo'              => 0,
	                    'show_option_none'  => 'Select category...',
	                    'option_none_value' => '0',
	                    'selected'          => $this->value(),
	                )
	            );
	 
	            // Hackily add in the data link parameter.
	            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
	 
	            printf(
	                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
	                $this->label,
	                $dropdown
	            );
	            
	        }
	    }
	endif;
	
	/*-----------------------------------------------------------*
	 * Home Template Settings section
	 *-----------------------------------------------------------*/
	 
	$wp_customize->add_section( 'general_settings_section', array(
	    'title'     => 'General Settings',
	    'priority'  => 202
	));
	
	// Category
	$wp_customize->add_setting( 'current_season_category', array(
	    'default'     => 1 
	));
	
	$wp_customize->add_control( new WP_Customize_Category_Control( $wp_customize, 'current_season_category', array(
	    'label'    => 'Current Season Category',
	    'section'  => 'general_settings_section',
	    'settings' => 'current_season_category'
	)));
	
	
}
add_action( 'customize_register', 'cram_customize_register' );