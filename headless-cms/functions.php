<?php
/**
 * Headless CMS functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Headless_CMS
 */

if ( ! function_exists( 'headless_cms_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function headless_cms_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Headless CMS, use a find and replace
		 * to change 'headless-cms' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'headless-cms', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'headless-cms' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'headless_cms_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'headless_cms_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function headless_cms_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'headless_cms_content_width', 640 );
}
add_action( 'after_setup_theme', 'headless_cms_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function headless_cms_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'headless-cms' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'headless-cms' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'headless_cms_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function headless_cms_scripts() {
	wp_enqueue_style( 'headless-cms-style', get_stylesheet_uri() );

	wp_enqueue_script( 'headless-cms-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'headless-cms-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'headless_cms_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


// BRET'S CODE BELOW HERE 

// Register Custom Post Type
function printers_post_type() {

	$labels = array(
		'name'                  => _x( '3D Printers', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( '3D Printer', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( '3D Printers', 'text_domain' ),
		'name_admin_bar'        => __( '3D Printer', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New 3D Printer', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New 3D Printer', 'text_domain' ),
		'edit_item'             => __( 'Edit 3D Printer', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( '3D Printer', 'text_domain' ),
		'description'           => __( 'Site 3D Printers.', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail'),
		'taxonomies'            => array( '' ),
		'hierarchical'          => false,
		'public'                => true,
    'show_in_rest'          => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
  register_post_type( 'printers', $args );
  
}

add_action( 'init', 'printers_post_type', 0 );


// Add custom field

function printer_meta_box() {

    add_meta_box(
        'global-notice',
        __( 'Printer Category', 'sitepoint' ),
        'printer_meta_box_callback',
        'printers',
        'side',
        'low'
    );
}

function printer_meta_box_callback() {
  global $post;
        $custom = get_post_custom($post->ID);
        $printer_category = $custom["printer_category"][0];
  ?>
  <input style="width:100%" name="printer_category" value="<?php echo $printer_category; ?>" />
  <?php
}

function save_printer_category(){
    global $post;
    update_post_meta($post->ID, "printer_category", $_POST["printer_category"]);
}

add_action( 'add_meta_boxes', 'printer_meta_box' );
add_action( 'save_post', 'save_printer_category' );


  
// Register custom field

add_action( 'rest_api_init', 'register_rest_field_for_printers' );

function register_rest_field_for_printers() {
  register_rest_field(
    'printers',
    'printer_category',
    array(
            'get_callback'    => 'get_printer_meta_field',
            'update_callback' => null,
            'schema' => null,
    )
    );
}

function get_printer_meta_field( $object, $field_name, $value ) {
  return get_post_meta($object['id'])[$field_name][0];
}

// Register Custom Post Type
function materials_post_type() {

	$labels = array(
		'name'                  => _x( '3D Materials', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( '3D Material', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( '3D Materials', 'text_domain' ),
		'name_admin_bar'        => __( '3D Material', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( '3D Material', 'text_domain' ),
		'description'           => __( 'Site 3D Materials.', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'            => array(  ),
		'hierarchical'          => false,
		'public'                => true,
    'show_in_rest'          => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'materials', $args );

}
add_action( 'init', 'materials_post_type', 0 );

// Add custom field

function material_meta_box() {

    add_meta_box(
        'global-notice',
        __( 'Material Category', 'sitepoint' ),
        'material_meta_box_callback',
        'materials',
        'side',
        'low'
    );
}

function material_meta_box_callback() {
  global $post;
        $custom = get_post_custom($post->ID);
        $material_category = $custom["material_category"][0];
  ?>
  <input style="width:100%" name="material_category" value="<?php echo $material_category; ?>" />
  <?php
}

function save_material_category(){
    global $post;
    update_post_meta($post->ID, "material_category", $_POST["material_category"]);
}

add_action( 'add_meta_boxes', 'material_meta_box' );
add_action( 'save_post', 'save_material_category' );


// Register custom field

add_action( 'rest_api_init', 'register_rest_field_for_materials' );

function register_rest_field_for_materials() {
  register_rest_field(
    'materials',
    'material_category',
    array(
            'get_callback'    => 'get_material_meta_field',
            'update_callback' => null,
            'schema' => null,
    )
    );
}

function get_material_meta_field( $object, $field_name, $value ) {
  return get_post_meta($object['id'])[$field_name][0];
}

// Register Custom Post Type
function faq() {

	$labels = array(
		'name'                  => _x( 'FAQ', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Question', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'FAQ', 'text_domain' ),
		'name_admin_bar'        => __( 'Question', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Question', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Question', 'text_domain' ),
		'edit_item'             => __( 'Edit Question', 'text_domain' ),
		'update_item'           => __( 'Update Question', 'text_domain' ),
		'view_item'             => __( 'View Question', 'text_domain' ),
		'view_items'            => __( 'View FAQ', 'text_domain' ),
		'search_items'          => __( 'Search Question', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'FAQ', 'text_domain' ),
		'description'           => __( 'Frequently asked questions.', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions' ),
		'taxonomies'            => array( ''),
		'hierarchical'          => false,
    'public'                => true,
    'show_in_rest'          => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'faq', $args );

}
add_action( 'init', 'faq', 0 );


// Change title text placeholder

function wpb_change_title_text( $title ){
     $screen = get_current_screen();
  
     if  ( 'printers' == $screen->post_type ) {
          $title = 'Enter printer name here';
     } else if ( 'materials' == $screen->post_type ) {
          $title = 'Enter material name here';
     } else if ( 'faq' == $screen->post_type ) {
          $title = 'Enter question here';
     }
  
     return $title;
}
  
add_filter( 'enter_title_here', 'wpb_change_title_text' );


// Restrict visible JSON data across all custom post types, to save space

function my_rest_prepare_post( $data, $post, $request ) {
	$_data = $data->data;
	$params = $request->get_params();
	if ( ! isset( $params['id'] ) ) {
    unset( $_data['date'] );
    unset( $_data['slug'] );
    unset( $_data['date_gmt'] );
    unset( $_data['modified'] );
    unset( $_data['modified_gmt'] );
    unset( $_data['guid'] );
    unset( $_data['type'] );
	}
	$data->data = $_data;
	return $data;
}

add_filter( 'rest_prepare_printers', 'my_rest_prepare_post', 10, 3 );

add_filter( 'rest_prepare_materials', 'my_rest_prepare_post', 10, 3 );

add_filter( 'rest_prepare_faq', 'my_rest_prepare_post', 10, 3 );


// THIS CODE ADDS IMAGES TO THE REST API

    function post_featured_image_json( $data, $post, $context ) {
        $featured_image_id = $data->data['featured_media']; // get featured image id
        $featured_image_url = wp_get_attachment_image_src( $featured_image_id, 'original' ); // get url of the original size

        if( $featured_image_url ) {
            $data->data['featured_image_url'] = $featured_image_url[0];
        }

        return $data;
    }

    add_filter( 'rest_prepare_printers', 'post_featured_image_json', 10, 3 );
    add_filter( 'rest_prepare_materials', 'post_featured_image_json', 10, 3 );