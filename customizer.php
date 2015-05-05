<?php
/**
 * customizer.php
 * Demo customizer code for #wcnc2015
 */

function wcnc2015_customizer( $wp_customize ) {

	// First, add a new section
	// (if you don't want to use one of
	// the default customizer sections)
	$wp_customize->add_section(
		'wcnc2015-demo-settings',
		array(
			'title'			=> 'Demo Settings',
			'description'	=> 'These are demo settings.',
			'priority'		=> 12
		)
	);

	// Second, add your settings
	// (we're duplicationg the settings
	// we created on our options page)
	$wp_customize->add_setting(
		'my-options-data[extra_tagline]',
		array(
			'type'		=> 'option', // could also use 'theme_mod'
			'sanitize_callback'	=> 'text_washing_machine',
			'default'			=> wcnc2015_get_option( 'extra_tagline' )
		)
	);
	$wp_customize->add_setting(
		'my-options-data[footer_text]',
		array(
			'type'		=> 'option', // could also use 'theme_mod'
			'sanitize_callback'	=> 'text_washing_machine',
			'default'			=> wcnc2015_get_option( 'footer_text' )
		)
	);

	// Third, add your controls (fields)
	$wp_customize->add_control(
		'my-options-data[extra_tagline]',
		array(
			'label'		=> 'Extra Header Tagline',
			'section'	=> 'wcnc2015-demo-settings',
			'type'		=> 'text'
		)
	);
	$wp_customize->add_control(
		'my-options-data[footer_text]',
		array(
			'label'		=> 'Footer Text',
			'section'	=> 'wcnc2015-demo-settings',
			'type'		=> 'text'
		)
	);
}
add_action( 'customize_register', 'wcnc2015_customizer' );


/**
 * Don't forget, we need to validate this data, too!
 * Unlike the options page where we get one array with the whole deal,
 * each control here sends it's own text string.
 * @param 	string $raw_input Dangerous unwashed stuff
 * @return  string Cleaned up input
 */
function text_washing_machine( $raw_input ) {
	$clean_input = strip_tags( stripslashes( $raw_input ) );
	return apply_filters( 'text_washing_machine', $clean_input, $raw_input );
}
