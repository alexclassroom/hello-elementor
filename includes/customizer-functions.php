<?php /**
 * Hello Elementor customizer registration functions.
 *
 * @package HelloElementor
 */

/**
 * Register Customizer controls which add Elementor deeplinks
 *
 * @return void
 */
add_action( 'customize_register', 'hello_customizer_register' );
function hello_customizer_register( $wp_customize ) {
	// Allow active/inactive via the Experiments
	if ( ! hello_header_footer_experiment_active() ) return;

	require get_template_directory() . '/includes/controls/customizer-upsell-control.php';

	$wp_customize->add_section(
		'hello_theme_options',
		[
			'title' => __( 'Header &amp; Footer', 'hello-elementor' ),
			'capability' => 'edit_theme_options',
		]
	);

	$wp_customize->add_setting( 'hello-elementor-header-footer', [ 'transport' => 'refresh' ] );

	$wp_customize->add_control(
		new Hello_Elementor_Upsell(
			$wp_customize,
			'hello-elementor-header-footer',
			[
				'section' => 'hello_theme_options',
				'priority' => 20,
			]
		)
	);
}


/**
 * Enqueue Customiser CSS
 *
 * @return string HTML to use in the customizer panel
 */
add_action( 'admin_enqueue_scripts', 'hello_admin_print_styles' );
function hello_admin_print_styles() {
	global $wp_customize;

	if ( ! isset( $wp_customize ) ) {
		return;
	}

	$min_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style(
		'hello-elementor-customizer',
		get_template_directory_uri() . '/customizer' . $min_suffix . '.css',
		[],
		HELLO_ELEMENTOR_VERSION
	);
}
