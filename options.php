<?php
/**
 * options.php
 * Demo options code for #wcnc2015
 */

/**
 * Step 0: Make sure you have some options to work with.
 * 			(And if you don't, create some!)
 */
function wcnc2015_options_check() {
	if ( ! get_option( 'my-options-data' ) ) {
		$options_defaults['extra_tagline'] 	= '';
		$options_defaults['footer_text']	= '';

		update_option( 'my-options-data', $options_defaults );
	}
}
add_action( 'after_setup_theme', 'wcnc2015_options_check' );
// (for plugins, hook this to init)


/**
 * Step 1: Make a Place for Your Page
 */
function add_my_menu() {
 // add_plugins_page or
	add_theme_page(
		'Demo Optons',
		'Demo Menu Text',
		'edit_theme_options',
		'my-page-id',
		'display_my_page'
		);
}
add_action( 'admin_menu', 'add_my_menu' );


/**
 * Step 2: Build Your Page Template
 */
function display_my_page() {
?>
	<div class="wrap">
		<h2>Theme Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'my-options' ); ?>
			<?php do_settings_sections( 'my-page-id' ); ?>
			<?php submit_button( 'Ka-Pow!' ); ?>
		</form>
	</div>
<?php
}


/**
 * Step 3: Register Your Settings, Sections and Fields
 */
function register_my_settings() {
	// First say,
	// "Here's a hunk of stuff that
	// will be saved in the database."
	register_setting(
		'my-options',
		'my-options-data',
		'washing_machine'
	);

	// Next say,
	// "Here are the sections I want
	// to present my settings in
	// on the page I told you about earlier."
	add_settings_section(
		'section-1',
		'Header Stuff',
		'section_ringy_dingy',
		'my-page-id'
	);
	add_settings_section(
		'section-2',
		'Footer Stuff',
		'section_ringy_dingy',
		'my-page-id'
	);

	// Third, gather the information
	// you'll need to display your fields
	// into HTML
	$extra_tagline_args = array(
		'id'		=> 'extra_tagline',
		'desc'		=> 'Enter Your Extra Tagline Here',
		'label_for'	=> 'extra_tagline'
	);

	$footer_text_args = array(
		'id'		=> 'footer_text',
		'desc'		=> 'Enter Your Footer Text Here',
		'label_for'	=> 'footer_text'
	);

	// Finally say,
	// "These are the fields we want
	// users to fill in."
	add_settings_field(
		'extra-tagline',
		'Text for Extra Tagline',
		'render_text_field',
		'my-page-id',
		'section-1',
		$extra_tagline_args
	);
	add_settings_field(
		'footer-text',
		'Text for Footer',
		'render_text_field',
		'my-page-id',
		'section-2',
		$footer_text_args
	);

}
add_action( 'admin_init', 'register_my_settings' );


/**
 * Step 4: Render Your Section Callback(s)
 */
function section_ringy_dingy() {
	echo 'This is a settings section.
	You can put instructions here for users about this section.';
	// You could also just leave this function blank
	// if you didn't want to output anything.
}


/**
 * Step 5: Render Your Fields
 */
function render_text_field( $args ) {
	extract( $args );
	if ( ! $id ) return; // If we don't have an id this isn't going to work.
							// Fail quietly.

	$options_data = 'my-options-data';
	$current_options = get_option( $options_data );

	echo '<input class="text-field"
				type="text"
				id="' . $id . '"
				name="' . $options_data . '[' . $id . ']"
				value="' . ( ( array_key_exists( $id, $current_options ) )
					? esc_attr( $current_options[$id] )
					: '' ) . '" />';
	if ( $desc ) echo '<br /><span class="description">' . $desc . '</span>';
}


/**
 * Step 6. Validate Your Input!
 */
function washing_machine( $raw_input ) {
	$clean_input = array();

	foreach ( $raw_input as $key => $value) {
		if ( isset( $raw_input[$key] ) ) {
			$clean_input[$key] = strip_tags( stripslashes( $value ) );
			// we could also use wp_kses( $value, array( 'a', 'br', ... ) );

			if ( $key == 'footer_columns' ) {
				$clean_input[$key] =
					( ( $clean_input[$key] == ( 0 || 1 || 2 || 3 ) ) )
						? $clean_input[$key]
						: 1;
			}
		}
	}

	return apply_filters( 'washing_machine', $clean_input, $raw_input );
}


/**
 * A little helper function to grab the values from our current options
 * @param  string $name The name of the setting we want
 * @return mixed        The stored value of the setting we asked for
 */
function wcnc2015_get_option( $name = null ) {
	$options = get_option( 'my-options-data' );

	if ( isset ($options[$name] ) ) {
		return apply_filters( 'wcnc_get_options_$name', $options[$name] );
	}

	return null; // If we don't have an option by that name, fail quietly
}



