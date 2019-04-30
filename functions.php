<?php
/**
 * puca functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Puca
 * @since Puca 1.3.6
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Puca 1.3.6
 */
define( 'PUCA_THEME_VERSION', '1.3.6' );

/**
 * ------------------------------------------------------------------------------------------------
 * Define constants.
 * ------------------------------------------------------------------------------------------------
 */
define( 'PUCA_THEME_DIR', 		get_template_directory_uri() );
define( 'PUCA_THEMEROOT', 		get_template_directory() );
define( 'PUCA_IMAGES', 			PUCA_THEME_DIR . '/images' );
define( 'PUCA_SCRIPTS', 		PUCA_THEME_DIR . '/js' );

/*Debug*/
// define( 'PUCA_SCRIPTS', 			PUCA_THEME_DIR . '/dev-js' );

define( 'PUCA_SCRIPTS_SKINS', 	PUCA_SCRIPTS . '/skins' );
define( 'PUCA_STYLES', 			PUCA_THEME_DIR . '/css' );
define( 'PUCA_STYLES_SKINS', 	PUCA_STYLES . '/skins' );

define( 'PUCA_INC', 				'/inc' );
define( 'PUCA_CLASSES', 			PUCA_INC . '/classes' );
define( 'PUCA_VENDORS', 			PUCA_INC . '/vendors' );
define( 'PUCA_WIDGETS', 			PUCA_INC . '/widgets' );

define( 'PUCA_ASSETS', 			PUCA_THEME_DIR . '/inc/assets' );
define( 'PUCA_ASSETS_IMAGES', 	PUCA_ASSETS    . '/images' );

define( 'PUCA_MIN_JS', 	'.min' );

/*Debug*/
// define( 'PUCA_MIN_JS', 	'' );


if ( ! isset( $content_width ) ) {
	$content_width = 660;
}


if ( ! function_exists( 'puca_tbay_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Puca 1.3.6
 */
function puca_tbay_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on puca, use a find and replace
	 * to change 'puca' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'puca', PUCA_THEMEROOT . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( "post-thumbnails" );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	$font_source = puca_tbay_get_config('show_typography', false);
	if( !$font_source ) {
		add_editor_style( array( 'css/editor-style.css', puca_fonts_url() ) );
	}


	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );


	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_theme_support( "woocommerce" );
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio'
	) );

	$color_scheme  = puca_tbay_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'puca_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );
	
	puca_tbay_get_load_plugins();
}
endif; // puca_tbay_setup
add_action( 'after_setup_theme', 'puca_tbay_setup' );


/**
 * Enqueue scripts and styles.
 *
 * @since Puca 1.3.6
 */
function puca_tbay_scripts() { 

	$menu_option = apply_filters( 'puca_menu_mobile_option', 10,2 );

	// load bootstrap style
	if( is_rtl() ){
		wp_enqueue_style( 'bootstrap', PUCA_STYLES . '/bootstrap-rtl.css', array(), '3.2.0' );
	}else{
		wp_enqueue_style( 'bootstrap', PUCA_STYLES . '/bootstrap.css', array(), '3.2.0' );
	}
	
	$skin = puca_tbay_get_theme();
	// Load our main stylesheet.
	if( is_rtl() ){
		
		if ( $skin != 'default' && $skin ) {
			$css_path =  PUCA_STYLES_SKINS . '/'.$skin.'/template.rtl.css';
		} else {
			$css_path =  PUCA_STYLES . '/template.rtl.css';
		}
	}
	else{
		if ( $skin != 'default' && $skin ) {
			$css_path =  PUCA_STYLES_SKINS . '/'.$skin.'/template.css';
		} else {
			$css_path =  PUCA_STYLES . '/template.css';
		}
	}
	wp_enqueue_style( 'puca-template', $css_path, array(), PUCA_THEME_VERSION );
	
	$footer_style = puca_tbay_print_style_footer();
	if ( !empty($footer_style) ) {
		wp_add_inline_style( 'puca-template', $footer_style );
	}

	$custom_style = puca_tbay_custom_styles();
	if ( !empty($custom_style) ) {
		wp_add_inline_style( 'puca-template', $custom_style );
	}

	wp_enqueue_style( 'puca-style', PUCA_THEME_DIR . '/style.css', array(), PUCA_THEME_VERSION );
	
	//load font awesome
	wp_enqueue_style( 'font-awesome', PUCA_STYLES . '/font-awesome.css', array(), '4.7.0' );
	
	//load font custom icon tbay
	wp_enqueue_style( 'font-tbay', PUCA_STYLES . '/font-tbay-custom.css', array(), '1.0.0' );

	//load simple-line-icons
	wp_enqueue_style( 'simple-line-icons', PUCA_STYLES . '/simple-line-icons.css', array(), '2.4.0' );

	// load animate version 3.5.0
	wp_enqueue_style( 'animate-css', PUCA_STYLES . '/animate.css', array(), '3.5.0' );

	
	wp_enqueue_script( 'puca-skip-link-fix', PUCA_SCRIPTS . '/skip-link-fix' . PUCA_MIN_JS . '.js', array(), PUCA_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	} 

	wp_enqueue_script( 'jquery-unveil', PUCA_SCRIPTS . '/jquery.unveil' . PUCA_MIN_JS . '.js', '1.3.2', true );

	/*mmenu menu*/ 
	if( $menu_option == 'smart_menu' ){
		wp_enqueue_script( 'jquery-mmenu', PUCA_SCRIPTS . '/jquery.mmenu' . PUCA_MIN_JS . '.js', array( 'jquery', 'underscore' ),'7.0.5', true );
	}
 
	/*Treeview menu*/
	wp_enqueue_style( 'jquery-treeview',  PUCA_STYLES . '/jquery.treeview.css', array(), '1.0.0' );

	/*hc sticky*/
	wp_register_script( 'hc-sticky', PUCA_SCRIPTS . '/hc-sticky' . PUCA_MIN_JS . '.js', array( 'jquery' ) , '2.1.0', true );

	wp_enqueue_script( 'bootstrap', PUCA_SCRIPTS . '/bootstrap' . PUCA_MIN_JS . '.js', array( 'jquery' ), '3.3.7', true );

	/*slick jquery*/
    wp_register_script( 'slick', PUCA_SCRIPTS . '/slick' . PUCA_MIN_JS . '.js', '1.0.0', true );

	// Add js Sumoselect version 3.0.2
	wp_register_style('sumoselect', PUCA_STYLES . '/sumoselect.css', array(), '1.0.0', 'all');
	wp_register_script('jquery-sumoselect', PUCA_SCRIPTS . '/jquery.sumoselect' . PUCA_MIN_JS . '.js', '3.0.2', TRUE);	

	wp_dequeue_script('wpb_composer_front_js');
	wp_enqueue_script( 'wpb_composer_front_js');

    wp_register_script( 'jquery-shuffle', PUCA_SCRIPTS . '/jquery.shuffle' . PUCA_MIN_JS . '.js', array( 'jquery' ), '3.0.0', true ); 
    wp_register_script( 'jquery-magnific-popup', PUCA_SCRIPTS . '/jquery.magnific-popup' . PUCA_MIN_JS . '.js', array( 'jquery' ), '1.0.0', true );    

    wp_register_style( 'magnific-popup', PUCA_STYLES . '/magnific-popup.css', array(), '1.0.0' );

	wp_register_script( 'jquery-countdowntimer', PUCA_SCRIPTS . '/jquery.countdownTimer' . PUCA_MIN_JS . '.js', array( 'jquery' ), '1.0', true );

	wp_register_style( 'jquery-fancybox', PUCA_STYLES . '/jquery.fancybox.css', array(), '3.2.0' );
	wp_register_script( 'jquery-fancybox', PUCA_SCRIPTS . '/jquery.fancybox' . PUCA_MIN_JS . '.js', array( 'jquery' ), '2.1.7', true );

	wp_register_script( 'puca-script',  PUCA_SCRIPTS . '/functions' . PUCA_MIN_JS . '.js', PUCA_THEME_VERSION, true );
	wp_localize_script( 'puca-script', 'puca_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

	wp_register_script( 'puca-skins-script', PUCA_SCRIPTS_SKINS . '/'.$skin . PUCA_MIN_JS . '.js', array( 'puca-script' ), PUCA_THEME_VERSION, true );

	if ( wp_is_mobile() ) {
		wp_enqueue_script( 'jquery-fastclick', PUCA_SCRIPTS . '/jquery.fastclick' . PUCA_MIN_JS . '.js', array( 'jquery' ), '1.0.6', true );
	}

	wp_enqueue_script( 'puca-skins-script' );
	if ( puca_tbay_get_config('header_js') != "" ) {
		wp_add_inline_script( 'puca-script', puca_tbay_get_config('header_js'), 'after' );
	}

	wp_enqueue_style( 'puca-style', PUCA_THEME_DIR . '/style.css', array(), '1.0' );
	
	wp_register_script( 'socialpixel', get_template_directory_uri() . "/js/socialpixel.js", array('jquery') );
	wp_enqueue_script( 'socialpixel' );

	global $wp_query; 

	$position = apply_filters( 'puca_cart_position', 10,2 );
	$tbay_header = apply_filters( 'puca_tbay_get_header_layout', puca_tbay_get_config('header_type', 'v1') );
	$config = array(
		'ajax_update_quantity' => (bool) puca_tbay_get_config('ajax_update_quantity', true),
		'active_theme' => puca_tbay_get_config('active_theme', 'fashion'),
		'tbay_header' => $tbay_header,
		'cart_position' => $position, 
		'cancel' => esc_html__('cancel', 'puca'),
		'search' => esc_html__('Search', 'puca'),
		'posts' => json_encode( $wp_query->query_vars ),
		'view_all' => esc_html__('View All', 'puca'),
		'no_results' => esc_html__('No results found', 'puca'),
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,  
		'max_page' => $wp_query->max_num_pages 
	);


	wp_localize_script( 'puca-script', 'puca_settings', $config );

}
add_action( 'wp_enqueue_scripts', 'puca_tbay_scripts', 100 );

if ( !function_exists('puca_tbay_head_scripts') ) {
	function puca_tbay_head_scripts() {
		if( !is_admin()) {
		    wp_dequeue_script('jquery');
		    wp_enqueue_script('jquery-3x', PUCA_SCRIPTS . '/jquery' . PUCA_MIN_JS . '.js', false, '3.3.1');
		    wp_dequeue_script('jquery-migrate'); 
		    wp_enqueue_script('jquery-migrate-3x', PUCA_SCRIPTS . '/jquery-migrate' . PUCA_MIN_JS . '.js', array('jquery'), '3.0.0'); 

		    define( 'TBAY_JQUERY_REMOVE_CORE_OLD', true );
		}
	}
	add_action('wp_head','puca_tbay_head_scripts', -9999); 
}

if ( !function_exists('puca_tbay_footer_scripts') ) {
	function puca_tbay_footer_scripts() {
		if ( puca_tbay_get_config('footer_js') != "" ) {
			$footer_js = puca_tbay_get_config('footer_js');
			echo trim($footer_js);
		}
	}
	add_action('wp_footer', 'puca_tbay_footer_scripts');
}

if ( !function_exists('puca_tbay_remove_fonts_redux_url') ) {
	function puca_tbay_remove_fonts_redux_url() {  
		$show_typography  = puca_tbay_get_config('show_typography', false);
		if( !$show_typography ) {
			wp_dequeue_style( 'redux-google-fonts-puca_tbay_theme_options' );
		} 
	}
	add_action('wp_enqueue_scripts', 'puca_tbay_remove_fonts_redux_url', 9999);
}

add_filter( 'wc_city_select_cities', 'my_cities' );
function my_cities( $cities ) {
	$cities['SA'] = array(
        'الرياض   Riyadh',
		'جدة   Jeddah',
		'ابها   Abha',
		'احد رفيدة   Ahad Rafidah',
		'الدوادمي   Duwadimi',
		'الاحساء   Al Ahsa',
		'عرعر   Arar',
		'الباحة   Baha',
		'بيشة   Bish',
		'الدمام   Dammam',
		'الدرعية   Diriyah',
		'الظهران   Dhahran',
		'جيزان   Jazan',
		'حفر الباطن   Hafar Al Baten',
		'حائل   Hail',
		'الجوف   Al Jouf',
		'جبيل   Jubail',
		'خميس مشيط   Khamis Mushayt',
		'الخرج   Kharj',
		'الخبر   Khubar',
		'مكة المكرمة   Makkah',
		'المدينة المنورة   Madinah',
		'نجران   Najran',
		'قطيف   Qatif',
		'القريات   Qurayyat',
		'رفحة   Rafha',
		'سيهات   Sayhat',
		'شرورة   Sharourah',
		'تبوك   Tabuk',
		'الطائف   Taif',
		'تاروت   Tarut (Darin)',
		'طريف   Turayf',
		'وادي الدواسر   Wadi Al-Dawasir',
		'ينبع   Yanbu',
		'القنفذة   Qunfudah',
		'المجمعة   Majmaah',
		'مهد الذهب   Mahd Ad Dhahab',
		'الخفجي   Khafji',
		'بريدة   Buraydah',
		'عنيزة   Unayzah',
		'الرس   Rass',
		'سكاكا   Skakah',
		'بقيق‎   Buqaiq',
		'رأس تنورة   Ras Tanura',
		'عفيف   Afif',
		'الأفلاج   Al Aflaj (Layla)',
		'ساجِر   Sajir',
		'شقراء   Shaqra',
		'الزلفي   Zulfi',
		'النماص   Namas',
		'السليل‎   Sulayyil',
		'بلجرشي‎   Baljurashi',
		'المجارده   Majardah',
		'الخرمة   Khurma',
		'رانيا   Ranyah',
		'تربه   Turbah',
		'البكيرية   Bukayriyah',
		'تثليث   Tathlith',
		'المذنب   Midhnab',
		'القويعيه   Quwayiyah',
		'الظهران الجنوب   Dhahran Al Janoub',
		'أبوعريش  Abu Areish',
		'سراة عبيدة   Sarat Abida',
		'المخواه   Mukhwah',
		'سبت العلايا   Sapt Al Alaya',
		'تنومة   Tanumah',
		'محايل عسير   Mahayel Asir',
		'النعيرية   Nairiyah',
		'الهفوف   Hufuf',
		'صبيا   Sabya',
		'دومة الجندل   Dawmat Al Jandal',
		'املج   Ummlujj',
		'العلا   Ula',
		'صامطه   Samtah',
		'الطوال   At Tuwal',
		'الدرب   Darb',
		'ضبا   Dhuba',
		'طبرجل   Tabarjal',
		'تيماء   Taima',
		'الثقبة   Thqbah',
		'صفوى   Safwa',
		'رابغ   Rabigh',
		'رجال ألمع   Rijal Almaa',
		'الدائر   Al Dayer',
		'رياض الخبراء   Riyadh Al Khabra',
		'المزاحمية   Muzahmiyah',
		'القرية العليا   Qarya Al Uliya',
		'الوجه   Wajh',
		'عنك   Anak',
		'حوطة بني تميم   Hawtat Bani Tamim',
		'رماح   Rumah',
		'بيش   Baysh',
		'البدايع   Badaya',
		'الحناكية   Hanakiyah',
		'الليث   Lith',
		'عيون الجواء   Uyun Al Jiwa',
		'طريب   Tarib',
		'بدر   Badr',
		'خليص   Khulais',
		'قلوة   Qilwah',
		'العقيق   Aqiq',
		'المندق   Mandaq',
		'Rafayaa Al Gimsh',
		'الجموم   Jamoum',
		'الأرطاوية   Artawiyah',
		'أحد المسارحة Ahad Masarha',
		'الاسياح   Alasyah',
		'البدائع   albadayeh',
		'البرك   bark',
		'الجبيل   Jubail',
		'الجش   Jash',
		'الحرجة   harjah',
		'الحوية   Alhaweyah',
		'الخماسين   Khamasin',
		'الرويضة   Ruwaidah',
		'السفانية   safaneyah',
		'الشرائع   alsharaye',
		'الشفا   shafa',
		'الشقيق   Shuqayq',
		'الصحنة   sahnah',
		'العضيلية   ydayleyah',
		'العوامية   awwameyah',
		'العيون   Al Ayun',
		'الغاط   Ghat',
		'القحمة   Qahma',
		'المبرز   Mubarraz',
		'المظيلف   Mudhaylif',
		'بارق   Bariq',
		'بحرة   Bahrah',
		'بللسمر   Bellasmar',
		'ثادق   thadeq',
		'جديد   jaded',
		'جلاجل   Jalajel',
		'حالة عمار   Halit Ammar',
		'حرض   Harad',
		'حريملاء   Huraymila',
		'حقل   Haql',
		'حوطة سدير   Hawtat Sudayr',
		'خيبر   Khayber',
		'رفحاء   rafha',
		'رنية   ranyah',
		'روضة سدير   rawdat sudair',
		'ضباء   Duba',
		'ضرما   Dhurma',
		'ضمد   Dhamad',
		'ظلم   Dhalim',
		'عسفان   Asfan',
		'عقلة الصقور   Uqlat As Suqur',
		'تربة   Turbah (Makkah)',
		'ينبع البحر   yanbu bahr',
		'الدلم   Dilam',
		'ثول   Thuwal',
		'القيصومة   Qaysumah',
		'فرسان   Farasan',
		'شيبة   Shaibah',
		'سلوى   Salwa',
		'مستورة   Masturah',
		'الكامل   Kamil',
		'بحرة Bahara',
		'الاطاولة Atawleh',
		'بلجرشي BilJurashi',
		'قلوة Gilwa',
		'المندق Mandak',
		'المظيلف Muthaleif',
		'مخواه Mikhwa',
		'خبر Khobar',
		'سيهات Seihat',
		'ضمد Damad',
		'جيزان Gizan',
		'الكربوس Karboos',
		'الهفوف Hofuf',
		'الأحساء Al Hassa',
		'ذهبان Zahban',
		'خليص Khulais',
		'صعبر Saaber',
		'التنعيم At Taniem',
		"جعرانة Ja'araneh",
		'الجموم Jumum',
		'رنية Rania',
		'الهدا Alhada',
		'الليث Laith',
		'عشيرة Ashayrah',
		'عمق Amaq',
		'البرك Birk',
		'نمران Nimra',
		'النوارية Nwariah'
    );
	return $cities;
}
add_action( 'admin_enqueue_scripts', 'puca_tbay_load_admin_styles' );
function puca_tbay_load_admin_styles() {
	wp_enqueue_style( 'puca-custom-admin', PUCA_STYLES . '/admin/custom-admin.css', false, '1.0.0' );
}  

/**
 * Display descriptions in main navigation.
 *
 * @since Puca 1.3.6
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function puca_tbay_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'puca_tbay_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Puca 1.3.6
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function puca_tbay_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'puca_tbay_search_form_modify' );


function puca_tbay_get_config($name, $default = '') {
	global $tbay_options;
    if ( isset($tbay_options[$name]) ) {
        return $tbay_options[$name];
    }
    return $default;
}


if ( ! function_exists( 'puca_time_link' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function puca_time_link() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ), 
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	// Wrap the time string in a link, and preface it with 'Posted on'.
	return sprintf( 
		/* translators: %s: post date */
		__( '<span class="screen-reader-text">Posted on</span> %s', 'puca' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
}
endif;

function puca_tbay_get_global_config($name, $default = '') {
	$options = get_option( 'puca_tbay_theme_options', array() );
	if ( isset($options[$name]) ) {
        return $options[$name];
    }
    return $default;
}

function puca_tbay_get_load_plugins() {

	$plugins[] =(array(
		'name'                     => esc_html__( 'Cmb2', 'puca' ),
	    'slug'                     => 'cmb2',
	    'required'                 => true,
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'WooCommerce', 'puca' ),
	    'slug'                     => 'woocommerce',
	    'required'                 => true,
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'MailChimp', 'puca' ),
	    'slug'                     => 'mailchimp-for-wp',
	    'required'                 =>  true
	));	

	$plugins[] =(array(
		'name'                     => esc_html__( 'Contact Form 7', 'puca' ),
	    'slug'                     => 'contact-form-7',
	    'required'                 => true,
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'WPBakery Visual Composer', 'puca' ),
	    'slug'                     => 'js_composer',
	    'required'                 => true,
	    'source'         		   => esc_url( 'https://bitbucket.org/devthembay/update-plugin/raw/master/plugins/js_composer.zip' ),
	));
	
	$plugins[] =(array(
		'name'                     => esc_html__( 'Tbay Framework Pro For Themes', 'puca' ),
		'slug'                     => 'tbay-framework-pro',
		'required'                 => true ,
		'source'         		   => esc_url( 'https://bitbucket.org/devthembay/update-plugin/raw/master/plugins/tbay-framework-pro.zip' ),
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'WooCommerce Variation Swatches', 'puca' ),
	    'slug'                     => 'woo-variation-swatches',
	    'required'                 =>  true
	));		

	$plugins[] =(array(
		'name'                     => esc_html__( 'WooCommerce Products Filter', 'puca' ),
	    'slug'                     => 'woocommerce-products-filter',
	    'required'                 =>  true,
	    'source'         		   => esc_url( 'https://bitbucket.org/devthembay/update-plugin/raw/master/plugins/woocommerce-products-filter.zip' ),
	));	

	$plugins[] =(array(
		'name'                     => esc_html__( 'YITH WooCommerce Quick View', 'puca' ),
	    'slug'                     => 'yith-woocommerce-quick-view',
	    'required'                 =>  true
	));
	
	$plugins[] =(array(
		'name'                     => esc_html__( 'YITH WooCommerce Wishlist', 'puca' ),
	    'slug'                     => 'yith-woocommerce-wishlist',
	    'required'                 =>  true
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'YITH Woocommerce Compare', 'puca' ),
        'slug'                     => 'yith-woocommerce-compare',
        'required'                 => true
	));	

	$plugins[] =(array(
		'name'                     => esc_html__( 'Projects by WooThemes', 'puca' ),
        'slug'                     => 'projects-by-woothemes',
        'required'                 => true
	));	

	$plugins[] =(array(
		'name'                     => esc_html__( 'YITH WooCommerce Brands Add-On', 'puca' ),
        'slug'                     => 'yith-woocommerce-brands-add-on',
        'required'                 => true
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'Revolution Slider', 'puca' ),
        'slug'                     => 'revslider',
        'required'                 => true ,
        'source'         		   => esc_url( 'https://bitbucket.org/devthembay/update-plugin/raw/master/plugins/revslider.zip' ),
	));
	 
	tgmpa( $plugins );
}


require_once( get_parent_theme_file_path( PUCA_INC . '/plugins/class-tgm-plugin-activation.php') );
require_once( get_parent_theme_file_path( PUCA_INC . '/functions-helper.php') );
require_once( get_parent_theme_file_path( PUCA_INC . '/functions-frontend.php') );
require_once( get_parent_theme_file_path( PUCA_INC . '/skins/'.puca_tbay_get_theme().'/functions.php') );

/**
 * Implement the Custom Header feature.
 *
 */
require_once( get_parent_theme_file_path( PUCA_INC . '/custom-header.php') );
/**
 * Classess file
 *
 */

require_once( get_parent_theme_file_path( PUCA_CLASSES . '/megamenu.php') );
require_once( get_parent_theme_file_path( PUCA_CLASSES . '/custommenu.php') );
require_once( get_parent_theme_file_path( PUCA_CLASSES . '/mmenu.php') );

/**
 * Custom template tags for this theme.
 *
 */

require_once( get_parent_theme_file_path( PUCA_INC . '/template-tags.php') );


if ( defined( 'TBAY_FRAMEWORK_REDUX_ACTIVED' ) ) {
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/redux-framework/redux-config.php') );
	define( 'PUCA_REDUX_FRAMEWORK_ACTIVED', true );
}
if( in_array( 'cmb2/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/cmb2/page.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/cmb2/post.php') );
	define( 'PUCA_CMB2_ACTIVED', true );
}
if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/functions.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/single-functions.php') );
	define( 'PUCA_WOOCOMMERCE_ACTIVED', true );
}
if( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/visualcomposer/functions.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/visualcomposer/vc-map-posts.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/visualcomposer/vc-map-theme.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/visualcomposer/vc-map-woocommerce.php') );
	define( 'PUCA_VISUALCOMPOSER_ACTIVED', true );
}
if( in_array( 'tbay-framework-pro/tbay-framework.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/custom_menu.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/instagram.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/list-categories.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/popular_posts.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/popular_posts2.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/popup_newsletter.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/posts.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/recent_comment.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/recent_post.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/single_image.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/socials.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/top_rate.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/video.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/woo-carousel.php') );
	define( 'PUCA_TBAY_FRAMEWORK_ACTIVED', true );
}

if( in_array( 'projects-by-woothemes/projects.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/portfolio/functions.php') );
	define( 'PUCA_TBAY_PORTFOLIO_ACTIVED', true );
}



/**
 * Customizer additions.
 *
 */

require_once( get_parent_theme_file_path( PUCA_INC . '/skins/'.puca_tbay_get_theme().'/customizer.php') );

require_once( get_parent_theme_file_path( PUCA_INC . '/skins/'.puca_tbay_get_theme().'/custom-styles.php') );

/////////////////////////////////////////////////////////////////////////////////////////
//@emptyops.com
/////////////////////////////////////////////////////////////////////////////////////////
function eo_custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['custom_sales'] = 'Sort by Custom Order + Popularity';
    return $sortby;
}

add_filter( 'woocommerce_default_catalog_orderby_options', 'eo_custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'eo_custom_woocommerce_catalog_orderby' );

//Add Alphabetical sorting option to shop page / WC Product Settings
add_filter( 'woocommerce_get_catalog_ordering_args',function($args){
   global $wp_query;	
  $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

    if ( 'custom_sales' == $orderby_value ) {				
		$args['orderby'] = array('menu_order'=>'ASC','meta_value_num'=>'DESC');
        $args['meta_key'] = 'total_sales'; 
    }
    return $args;
},20,1);

add_action( 'woocommerce_after_checkout_billing_form', 'add_jscript_checkout');
 
function add_jscript_checkout() {
    echo '<script>jQuery(window).load(function(){ var email_cnt = jQuery("p#billing_email_field")[0].outerHTML; jQuery("p#billing_email_field").remove(); jQuery("p#billing_last_name_field").after(email_cnt); jQuery("p#billing_email_field").css("width","100%");});</script>';
print_r(ABSPATH.'csv/districts.csv');
if(file_exists(ABSPATH.'csv/districts.csv')){
    echo "<script> var district_array = []; ";
    $file = fopen(ABSPATH.'csv/districts.csv',"r");
    
    while(! feof($file))
    {   
        $curr = fgetcsv($file);
        if($curr[0] != '' && $curr[0] != 'City')
        {
            
            echo 'district_array.push({0 :"'.$curr[0].'", 1:"'.$curr[1].'", 2:"'.$curr[2].'"});';
        }
        
    }
    
    fclose($file);
    
    echo  "function pass_city(m){
             var city_val = m;  
             if(city_val != ''){ 
                    var only_city = city_val.replace(/[^a-zA-Z0-9]+/g, '');  
                    jQuery('#billing_district').html(''); 
                    for(var k=0; k<district_array.length; k++){ 
                        if(typeof district_array[k] !== 'undefined'){ 
                            if(district_array[k][0] == only_city ){ 
                                var full_show = district_array[k][2]+' '+district_array[k][1];
                                jQuery('#billing_district').append('<option value=\"'+full_show+'\">'+full_show+'</option>'); 
                                
                            } 
                            
                        } 
                        
                    }  
                    
                } 
    }
    function shipping_city_change(n){
             var city_val = n;  
            
             if(city_val != ''){ 
                    var only_city = city_val.replace(/[^a-zA-Z0-9]+/g, '');  
                    jQuery('#shipping_district').html(''); 
                    for(var k=0; k<district_array.length; k++){ 
                        if(typeof district_array[k] !== 'undefined'){ 
                            if(district_array[k][0] == only_city ){ 
                                var full_show = district_array[k][2]+' '+district_array[k][1];
                                jQuery('#shipping_district').append('<option value=\"'+full_show+'\">'+full_show+'</option>'); 
                                
                            } 
                            
                        } 
                        
                    }  
                    
                } 
    }
    
    jQuery('#billing_city').change(function(){ 
               
        pass_city(jQuery(this).val());
    });
    setInterval(function(){   
        jQuery('select[name=shipping_city]').on('change',function(){
            shipping_city_change(jQuery(this).val());
    }); 
        
    },5000);
    
    
    jQuery(window).load(function(){  jQuery('#billing_district').html(''); jQuery('#shipping_district').html('');  if(jQuery('#billing_city').val() != '' ){ pass_city(jQuery('#billing_city').val()); }  if(jQuery('#shipping_city').val() != '' ){ shipping_city_change(jQuery('#shipping_city').val()); } });
    </script>";
    }

}

add_action( 'woocommerce_order_details_after_customer_details', 'action_woocommerce_order_details_after_customer_details', 10, 1 );

function  action_woocommerce_order_details_after_customer_details($order){
            echo "<script>var billing_dist = jQuery('table.woocommerce-table--custom-fields.shop_table.custom-fields tbody tr').first().find('td').text(); var shiping_dist = jQuery('table.woocommerce-table--custom-fields.shop_table.custom-fields tbody tr').last().find('td').text(); jQuery('table.shop_table.custom-fields').remove(); jQuery('.woocommerce-column.woocommerce-column--billing-address address p.woocommerce-customer-details--phone').before('<br>'+billing_dist); jQuery('.woocommerce-column.woocommerce-column--shipping-address address').append('<br>'+shiping_dist); </script>";
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_product_add_to_cart_text' );
add_filter( 'add_to_cart_text', 'woo_custom_product_add_to_cart_text' );            // < 2.1
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_product_add_to_cart_text' );  // 2.1 +
  
function woo_custom_product_add_to_cart_text() {
  
    return __( 'أضف الى السلة', 'woocommerce' );
  
}

//////////////////////////////////////////////////////////////////////////////////////////////
////
//////////////////////////////////////////////////////////////////////////////////////////////


add_filter('the_posts', 'variation_query');
function variation_query($posts, $query = false) {
	if (is_search() && !is_admin()) {
		$ignoreIds = array(0);
		foreach($posts as $post) {
			$ignoreIds[] = $post->ID;
		}
		$matchedSku = get_parent_post_by_sku(get_search_query(), $ignoreIds);
		if ($matchedSku) {
			foreach($matchedSku as $product_id) {
				$posts[] = get_post($product_id->post_id);
			}
		}
		return $posts;
	}
	return $posts;
}
function get_parent_post_by_sku($sku, $ignoreIds) {
	global $wpdb, $wp_query;
	$wmplEnabled = false;
	if(defined('WPML_TM_VERSION') && defined('WPML_ST_VERSION') && class_exists("woocommerce_wpml")){
		$wmplEnabled = true;
		$languageCode = ICL_LANGUAGE_CODE;
	}
	$results = array();
	$ignoreIdsForMySql = implode(",", $ignoreIds);
	$variationsSql = "
		SELECT p.post_parent as post_id FROM $wpdb->posts as p
		join $wpdb->postmeta pm
		on p.ID = pm.post_id
		and pm.meta_key='_sku'
		and pm.meta_value LIKE '%$sku%'
		join $wpdb->postmeta visibility
		on p.post_parent = visibility.post_id
		and visibility.meta_key = '_visibility'
		and visibility.meta_value <> 'hidden'
		";
	if($wmplEnabled) {
		$variationsSql .= "
		join ".$wpdb->prefix."icl_translations t on
		t.element_id = p.post_parent
		and t.element_type = 'post_product'
		and t.language_code = '$languageCode'
		";
	}
	$variationsSql .= "
		where 1
		AND p.post_parent <> 0
		and p.ID not in ($ignoreIdsForMySql)
		and p.post_status = 'publish'
		group by p.post_parent
		";
	$variations = $wpdb->get_results($variationsSql);
	foreach($variations as $post) {
		$ignoreIds[] = $post->post_id;
	}
	$ignoreIdsForMySql = implode(",", $ignoreIds);
	$regularProductsSql = "
		SELECT p.ID as post_id FROM $wpdb->posts as p
		join $wpdb->postmeta pm
		on p.ID = pm.post_id
		and  pm.meta_key='_sku' 
		AND pm.meta_value LIKE '%$sku%' 
		join $wpdb->postmeta visibility
		on p.ID = visibility.post_id    
		and visibility.meta_key = '_visibility'
		and visibility.meta_value <> 'hidden'
		";
	if($wmplEnabled) {
		$regularProductsSql .= "
		join ".$wpdb->prefix."icl_translations t on
		t.element_id = p.ID
		and t.element_type = 'post_product'
		and t.language_code = '$languageCode'";
	}
	$regularProductsSql .= "
		where 1
		and (p.post_parent = 0 or p.post_parent is null)
		and p.ID not in ($ignoreIdsForMySql)
		and p.post_status = 'publish'
		group by p.ID
		";
	$regular_products = $wpdb->get_results($regularProductsSql);
	$results = array_merge($variations, $regular_products);
	$wp_query->found_posts += sizeof($results);
	return $results;
}
// define the woocommerce_order_formatted_shipping_address callback 
function filter_woocommerce_order_formatted_shipping_address( $this_get_address_shipping, $instance ) { 

print_r('<pre style="display:none;">');
print_r($this_get_address_shipping);
print_r('</pre>');

    // make filter magic happen here... 
    return $this_get_address_shipping; 
}; 
         
// add the filter 
add_filter( 'woocommerce_order_formatted_shipping_address', 'filter_woocommerce_order_formatted_shipping_address', 10, 2 );

// define the woocommerce_order_formatted_shipping_address callback 
function filter_woocommerce_order_formatted_billing_address( $this_get_address_shipping, $instance ) { 

print_r('<pre style="display:none;">');
print_r($instance->get_meta_data('_billing_district'));

print_r(get_post_meta( $instance->get_id(), '_billing_district', true ));

print_r($this_get_address_shipping);
print_r('</pre>');

    // make filter magic happen here... 
    return $this_get_address_shipping; 
}; 
         
// add the filter 
add_filter( 'woocommerce_order_formatted_billing_address', 'filter_woocommerce_order_formatted_billing_address', 10, 2 );