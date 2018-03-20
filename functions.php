<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
function genesis_sample_localization_setup(){
	load_child_theme_textdomain( 'genesis-sample', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Add the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'NRX Skin' );
define( 'CHILD_THEME_URL', 'http://greatoakcircle.com/' );
define( 'CHILD_THEME_VERSION', '2.3.0' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
function genesis_sample_enqueue_scripts_styles() {

	//wp_enqueue_style( 'genesis-sample-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	//wp_enqueue_style( 'dashicons' );

	//$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	/*wp_enqueue_script( 'genesis-sample-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);*/
	wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . "/js/custom.js", array( 'jquery' ), '', true );

}

// Define our responsive menu settings.
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'genesis-sample' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'genesis-sample' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Remove the header right widget area
unregister_sidebar( 'header-right' );

// Remove the secondary sidebar
unregister_sidebar( 'sidebar-alt' );

// Add support for custom logo.
add_theme_support( 'custom-logo', array(
	'width'       => 600,
	'height'      => 160,
	'flex-width' => true,
	'flex-height' => true,
) );

add_filter( 'genesis_seo_title', 'custom_header_inline_logo', 10, 3 );
/**
 * Add an image inline in the site title element for the logo
 *
 * @param string $title Current markup of title.
 * @param string $inside Markup inside the title.
 * @param string $wrap Wrapping element for the title.
 *
 * @author @_AlphaBlossom
 * @author @_neilgee
 * @author @_JiveDig
 * @author @_srikat
 */
function custom_header_inline_logo( $title, $inside, $wrap ) {
	// If the custom logo function and custom logo exist, set the logo image element inside the wrapping tags.
	if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
		$inside = sprintf( '<span class="screen-reader-text">%s</span>%s', esc_html( get_bloginfo( 'name' ) ), get_custom_logo() );
	} else {
		// If no custom logo, wrap around the site name.
		$inside	= sprintf( '<a href="%s">%s</a>', trailingslashit( home_url() ), esc_html( get_bloginfo( 'name' ) ) );
	}

	// Build the title.
	$title = genesis_markup( array(
		'open'    => sprintf( "<{$wrap} %s>", genesis_attr( 'site-title' ) ),
		'close'   => "</{$wrap}>",
		'content' => $inside,
		'context' => 'site-title',
		'echo'    => false,
		'params'  => array(
			'wrap' => $wrap,
		),
	) );

	return $title;
}

add_filter( 'genesis_attr_site-description', 'custom_add_site_description_class' );
/**
 * Add class for screen readers to site description.
 * This will keep the site description markup but will not have any visual presence on the page
 * This runs if there is a logo image set in the Customizer.
 *
 * @param array $attributes Current attributes.
 *
 * @author @_neilgee
 * @author @_srikat
 */
function custom_add_site_description_class( $attributes ) {
	if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
		$attributes['class'] .= ' screen-reader-text';
	}

	return $attributes;
}

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );
add_image_size( 'page-featured', 1500, 500, TRUE );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'genesis-sample' ), 'secondary' => __( 'Mobile Menu', 'genesis-sample' ) ) );

// Reposition the secondary navigation menu.
//remove_action( 'genesis_after_header', 'genesis_do_subnav' );
//add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
function genesis_sample_secondary_menu_args( $args ) {
	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}
	$args['depth'] = 1;
	return $args;
}

// Add Hamburger icon into the main menu
add_filter( 'genesis_nav_items', 'gc_hamburger_icon', 10, 2 );
add_filter( 'wp_nav_menu_items', 'gc_hamburger_icon', 10, 2 );

function gc_hamburger_icon($menu, $args) {
	$args = (array)$args;
	$hamburger_icon = '<span class="icon-menu"><svg id="i-menu" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
    		<path d="M4 8 L28 8 M4 16 L28 16 M4 24 L28 24" />
		</svg></span>';
	$close_icon = '<span class="icon-close"><svg id="i-close" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
    		<path d="M2 30 L30 2 M30 30 L2 2" />
		</svg></span>';
	if ( 'secondary' == $args['theme_location'] )
		return $close_icon . $menu;
	else if ( 'primary' == $args['theme_location'] ) return $hamburger_icon . $menu;
	else return $menu;
}

// Add Yelp icon to Simple Social Icons plugin
add_filter( 'simple_social_default_profiles', 'custom_add_new_simple_icon' );

function custom_add_new_simple_icon( $icons ) {
	$icons['yelp'] = [
		'label'   => __( 'Yelp', 'simple-social-icons' ),
		'pattern' => '<li class="social-yelp"><a href="%s" %s><svg role="img" class="social-yelp" aria-labelledby="social-yelp"><title id="social-yelp">' . __( 'Yelp', 'simple-social-icons' ) . '</title><use xlink:href="' . get_stylesheet_directory_uri() . '/icons/custom.svg#social-yelp "></use></svg></a></li>',
	];

	return $icons;
}

add_filter( 'simple_social_default_styles', 'custom_add_new_icon_default' );

function custom_add_new_icon_default( $defaults ) {
	$defaults['social-yelp'] = '';

	return $defaults;
}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
function genesis_sample_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
function genesis_sample_comments_gravatar( $args ) {
	$args['avatar_size'] = 60;
	return $args;
}

// Remove Entry Header from homepage
add_action( 'genesis_before', 'gc_remove_entry_header' );
function gc_remove_entry_header() {

	if ( ! is_front_page() ) { return; }

	//* Remove the entry header markup (requires HTML5 theme support)
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

	//* Remove the entry title (requires HTML5 theme support)
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

	//* Remove the entry meta in the entry header (requires HTML5 theme support)
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

	//* Remove the post format image (requires HTML5 theme support)
	remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );
}

// Change number of products per page
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );
function new_loop_shop_per_page( $cols ) {
	// $cols contains the current number of products per page based on the value stored on Options -> Reading
	// Return the number of products you wanna show per page.
	$cols = 24;
	return $cols;
}

// Force layout
function gc_fullwidth_layout() {
	//if( is_page ( array( 'cart', 'checkout' )) || is_shop() || 'product' == get_post_type() || is_singular( 'post' ) ) {
	if( 'post' == get_post_type() ) {

		return 'content-sidebar';
	}
}
add_filter( 'genesis_site_layout', 'gc_fullwidth_layout' );

//* Add Featured Image on top of pages and posts
add_action( 'genesis_after_header', 'featured_page_image' );
function featured_page_image() {
	if ( is_singular(array('page')) && has_post_thumbnail() ) { 
	    //the_post_thumbnail('large'); //you can use medium, large or a custom size
		$image_args = array(
			'size' => 'page-featured',
			'attr' => array(
				'class' => 'aligncenter page-featured',
			),
		);
		 
		genesis_image( $image_args );
	}
}

// Move Post Meta from Entry Footer to Entry Content
add_action( 'genesis_before_entry', 'gc_reposition_entry_footer' );
function gc_reposition_entry_footer() {

	if ( !is_home() ) 
		return;

	remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
	remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	add_action( 'genesis_entry_content', 'genesis_post_meta' );
}

// Change the footer credits
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = 'Copyright [footer_copyright] &middot; <a href="'.get_bloginfo( 'url' ).'">'. get_bloginfo( 'name' ) .'</a>. Design by <a href="http://greatoakcircle.com" target="_blank">Great Oak Circle</a>.';
	return $creds;
}

// Add Header Left widget area
add_action( 'genesis_header', 'gc_header_left', 9 );
function gc_header_left() {
	genesis_widget_area('header-left',
		array(
           	 'before' => '<div class="header-top"><div class="wrap">',
		'after'   => '</div></div>',
        	)
	);

}
genesis_register_sidebar( array(
	'id'          	=> 'header-left',
	'name'        	=> __( 'Header Top', 'genesis-sample' ),
	'description' 	=> __( 'This is the header top widget area.', 'genesis-sample' ),
) );

// Register the optin sidebar
genesis_register_sidebar( array(
	'id'          => 'optin',
	'name'        => __( 'Optin', 'genesis-sample' ),
	'description' => __( 'This is the optin widget area.', 'genesis-sample' ),
) );