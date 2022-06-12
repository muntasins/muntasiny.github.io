<?php
/**
 * aperture-portfolio Theme Customizer
 *
 * @package aperture-portfolio
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function aperture_portfolio_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'aperture_portfolio_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'aperture_portfolio_customize_partial_blogdescription',
		) );
	}



	$wp_customize->add_setting( 'link_color' , array(
	    'default' => '#e74c3c',
	    'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize,'link_color', 
		array(
		'label'      => esc_html__( 'Link Color', 'aperture-portfolio' ),
		'section'    => 'colors',
		'settings'   => 'link_color',
	) ) );


	// View PRO Version
	$wp_customize->add_section( 'aperture_portfoliostyle_view_pro', array(
		'title'       => '' . esc_html__( 'Upgrage to Pro', 'aperture-portfolio' ),
		'priority'    => 2,
		'description' => sprintf(
			//unintrosive upsell message
			__( '<div class="upsell-container">
					<h2>Upgrade to PRO Today!</h2>
					<p>Get the pro add-on plugin today:</p>
					<ul class="upsell-features">
                            <li>
                            	<h4>Portfolio Plugin</h4>
                            	<div class="description">Have a dedicated portfolio post types with an image library, category filtering and styled portfolio page.</div>
                            </li>

                            <li>
                            	<h4>Galleries & Albums</h4>
                            	<div class="description">Upload galleries/Albums in your portfolios with a single click</div>
                            </li>
                            
                            <li>
                            	<h4>Video Support</h4>
                            	<div class="description">Upload videos from youtube or vimeo</div>
                            </li>

                            <li>
                            	<h4>One On One Email Support</h4>
                            	<div class="description">Get one on one email support from our experienced support stuff, we can also help you modify the theme to your liking</div>
                            </li>
                            
                    </ul> %s </div>', 'aperture-portfolio' ),
			sprintf( '<a href="%1$s" target="_blank" class="button button-primary">%2$s</a>', esc_url( aperture_portfolio_get_pro_link() ), esc_html__( 'Upgrade To PRO', 'aperture-portfolio' ) )
		),
	) );

	$wp_customize->add_setting( 'aperture_portfoliopro_desc', array(
		'default'           => '',
		'sanitize_callback' => 'aperture_portfoliosanitize_checkbox',
	) );
	$wp_customize->add_control( 'aperture_portfoliopro_desc', array(
		'section' => 'aperture_portfoliostyle_view_pro',
		'type'    => 'hidden',
	) );

}
add_action( 'customize_register', 'aperture_portfolio_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function aperture_portfolio_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function aperture_portfolio_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function aperture_portfolio_customize_preview_js() {
	wp_enqueue_script( 'aperture-portfolio-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'aperture_portfolio_customize_preview_js' );


/**
 * Admin CSS
 */
function aperture_portfolio_customizer_assets() {
    wp_enqueue_style( 'aperture_portfolio_customizer_style', get_template_directory_uri() . '/css/upsell.css', null, '1.0.0', false );
}
add_action( 'customize_controls_enqueue_scripts', 'aperture_portfolio_customizer_assets' );
/**
 * Generate a link to the Noah Lite info page.
 */
function aperture_portfolio_get_pro_link() {
    return 'https://portfolio.thepixeltribe.com/#aperture;
}
