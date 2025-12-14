<?php
/**
 * Sheikh Bassam Kayed Theme Functions
 *
 * @package Sheikh_Bassam_Kayed
 */

// Theme Setup
function sheikh_bassam_kayed_setup() {
    // Add theme support for title tag
    add_theme_support( 'title-tag' );
    
    // Add theme support for post thumbnails
    add_theme_support( 'post-thumbnails' );
    
    // Add custom image sizes
    add_image_size( 'book-cover', 300, 400, true );
    add_image_size( 'gallery-thumb', 400, 300, true );
    add_image_size( 'video-thumb', 640, 360, true );
    
    // Add theme support for HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );
    
    // Add theme support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    
    // Register navigation menus
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'sheikh-bassam-kayed' ),
        'footer'  => __( 'Footer Menu', 'sheikh-bassam-kayed' ),
    ) );
    
    // Add dropdown arrow to menu items with children
    add_filter( 'walker_nav_menu_start_el', 'sheikh_bassam_kayed_add_dropdown_arrow', 10, 4 );
    
    // Load theme textdomain for translations
    load_theme_textdomain( 'sheikh-bassam-kayed', get_template_directory() . '/languages' );
    
    // Set content width
    $GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'sheikh_bassam_kayed_setup' );

// Enqueue scripts and styles
function sheikh_bassam_kayed_scripts() {
    // Enqueue Google Fonts (Arabic) - Added creative calligraphic fonts for logo
    wp_enqueue_style( 'google-fonts-arabic', 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Amiri:wght@400;700&family=Almarai:wght@400;700;800&family=Reem+Kufi:wght@400;500;600;700&display=swap', array(), null );
    
    // Enqueue theme stylesheet
    wp_enqueue_style( 'sheikh-bassam-kayed-style', get_stylesheet_uri(), array( 'google-fonts-arabic' ), '1.0.0' );
    
    // Enqueue custom JavaScript
    wp_enqueue_script( 'sheikh-bassam-kayed-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '1.0.0', true );
    
    // Add background image inline style
    $bg_image_url = get_template_directory_uri() . '/assets/images/gray.png';
    $header_bg_url = get_template_directory_uri() . '/assets/images/header-bg.png';
    $custom_css = "
        body {
            background-image: url('{$bg_image_url}');
            background-repeat: repeat;
            background-position: top right;
        }
        .hero-image-container {
            background-image: url('{$header_bg_url}');
            background-repeat: repeat;
            background-position: top right;
        }
    ";
    wp_add_inline_style( 'sheikh-bassam-kayed-style', $custom_css );
    
    // Enqueue RTL stylesheet if needed
    if ( is_rtl() ) {
        wp_enqueue_style( 'sheikh-bassam-kayed-rtl', get_template_directory_uri() . '/rtl.css', array(), '1.0.0' );
    }
}
add_action( 'wp_enqueue_scripts', 'sheikh_bassam_kayed_scripts' );

// Register widget areas
function sheikh_bassam_kayed_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'sheikh-bassam-kayed' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here.', 'sheikh-bassam-kayed' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
        'name'          => __( 'Footer 1', 'sheikh-bassam-kayed' ),
        'id'            => 'footer-1',
        'description'   => __( 'Add widgets here.', 'sheikh-bassam-kayed' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    
    register_sidebar( array(
        'name'          => __( 'Footer 2', 'sheikh-bassam-kayed' ),
        'id'            => 'footer-2',
        'description'   => __( 'Add widgets here.', 'sheikh-bassam-kayed' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    
    register_sidebar( array(
        'name'          => __( 'Footer 3', 'sheikh-bassam-kayed' ),
        'id'            => 'footer-3',
        'description'   => __( 'Add widgets here.', 'sheikh-bassam-kayed' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'sheikh_bassam_kayed_widgets_init' );

// Custom excerpt length
function sheikh_bassam_kayed_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'sheikh_bassam_kayed_excerpt_length' );

// Custom excerpt more
function sheikh_bassam_kayed_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'sheikh_bassam_kayed_excerpt_more' );

// Add Arabic language support
function sheikh_bassam_kayed_language_setup() {
    // Set locale to Arabic
    if ( ! defined( 'WPLANG' ) ) {
        define( 'WPLANG', 'ar' );
    }
}
add_action( 'init', 'sheikh_bassam_kayed_language_setup' );

// Register custom post types
function sheikh_bassam_kayed_register_post_types() {
    // Books Post Type
    register_post_type( 'book', array(
        'labels' => array(
            'name' => __( 'الكتب', 'sheikh-bassam-kayed' ),
            'singular_name' => __( 'كتاب', 'sheikh-bassam-kayed' ),
            'add_new' => __( 'إضافة كتاب جديد', 'sheikh-bassam-kayed' ),
            'add_new_item' => __( 'إضافة كتاب جديد', 'sheikh-bassam-kayed' ),
            'edit_item' => __( 'تعديل الكتاب', 'sheikh-bassam-kayed' ),
            'new_item' => __( 'كتاب جديد', 'sheikh-bassam-kayed' ),
            'view_item' => __( 'عرض الكتاب', 'sheikh-bassam-kayed' ),
            'search_items' => __( 'بحث في الكتب', 'sheikh-bassam-kayed' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-book-alt',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'rewrite' => array( 'slug' => 'books' ),
        'show_in_rest' => true,
    ) );
    
    // Audio Lectures Post Type
    register_post_type( 'audio_lecture', array(
        'labels' => array(
            'name' => __( 'المحاضرات الصوتية', 'sheikh-bassam-kayed' ),
            'singular_name' => __( 'محاضرة صوتية', 'sheikh-bassam-kayed' ),
            'add_new' => __( 'إضافة محاضرة صوتية', 'sheikh-bassam-kayed' ),
            'add_new_item' => __( 'إضافة محاضرة صوتية جديدة', 'sheikh-bassam-kayed' ),
            'edit_item' => __( 'تعديل المحاضرة الصوتية', 'sheikh-bassam-kayed' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-microphone',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'rewrite' => array( 'slug' => 'audio-lectures' ),
        'show_in_rest' => true,
    ) );
    
    // Friday Khutbahs Post Type
    register_post_type( 'friday_khutbah', array(
        'labels' => array(
            'name' => __( 'خطب الجمعة', 'sheikh-bassam-kayed' ),
            'singular_name' => __( 'خطبة الجمعة', 'sheikh-bassam-kayed' ),
            'add_new' => __( 'إضافة خطبة', 'sheikh-bassam-kayed' ),
            'add_new_item' => __( 'إضافة خطبة جديدة', 'sheikh-bassam-kayed' ),
            'edit_item' => __( 'تعديل الخطبة', 'sheikh-bassam-kayed' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'rewrite' => array( 'slug' => 'friday-khutbahs' ),
        'show_in_rest' => true,
    ) );
    
    // Videos Post Type
    register_post_type( 'video', array(
        'labels' => array(
            'name' => __( 'الفيديوهات', 'sheikh-bassam-kayed' ),
            'singular_name' => __( 'فيديو', 'sheikh-bassam-kayed' ),
            'add_new' => __( 'إضافة فيديو', 'sheikh-bassam-kayed' ),
            'add_new_item' => __( 'إضافة فيديو جديد', 'sheikh-bassam-kayed' ),
            'edit_item' => __( 'تعديل الفيديو', 'sheikh-bassam-kayed' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-video-alt3',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'rewrite' => array( 'slug' => 'videos' ),
        'show_in_rest' => true,
    ) );
    
    // Gallery Post Type
    register_post_type( 'gallery', array(
        'labels' => array(
            'name' => __( 'المعرض', 'sheikh-bassam-kayed' ),
            'singular_name' => __( 'صورة', 'sheikh-bassam-kayed' ),
            'add_new' => __( 'إضافة صورة', 'sheikh-bassam-kayed' ),
            'add_new_item' => __( 'إضافة صورة جديدة', 'sheikh-bassam-kayed' ),
            'edit_item' => __( 'تعديل الصورة', 'sheikh-bassam-kayed' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'rewrite' => array( 'slug' => 'gallery' ),
        'show_in_rest' => true,
    ) );
}
add_action( 'init', 'sheikh_bassam_kayed_register_post_types' );

// Add RTL body class
function sheikh_bassam_kayed_body_class( $classes ) {
    $classes[] = 'rtl';
    return $classes;
}
add_filter( 'body_class', 'sheikh_bassam_kayed_body_class' );

// Configure homepage and create essential pages
function sheikh_bassam_kayed_set_homepage() {
    // Set homepage to show latest posts (this will use front-page.php)
    update_option( 'show_on_front', 'posts' );
    
    // Create essential pages if they don't exist
    sheikh_bassam_kayed_create_essential_pages();
    
    // Flush rewrite rules to ensure URLs work correctly
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'sheikh_bassam_kayed_set_homepage' );

// Create essential pages (About, Contact)
function sheikh_bassam_kayed_create_essential_pages() {
    $pages = array(
        'about' => array(
            'title'   => __( 'من نحن', 'sheikh-bassam-kayed' ),
            'content' => '', // Empty content - use Customizer fields instead
        ),
        'contact' => array(
            'title'   => __( 'اتصل بنا', 'sheikh-bassam-kayed' ),
            'content' => '', // Empty content - use Customizer text instead
        ),
        'dashboard-login' => array(
            'title'   => __( 'تسجيل الدخول - لوحة التحكم', 'sheikh-bassam-kayed' ),
            'content' => '',
        ),
        'dashboard' => array(
            'title'   => __( 'لوحة التحكم', 'sheikh-bassam-kayed' ),
            'content' => '',
        ),
    );
    
    foreach ( $pages as $slug => $page_data ) {
        // Check if page already exists
        $page = get_page_by_path( $slug );
        
        if ( ! $page ) {
            // Create the page
            $page_id = wp_insert_post( array(
                'post_title'   => $page_data['title'],
                'post_name'    => $slug,
                'post_content' => $page_data['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => 1,
            ) );
            
            if ( $page_id && ! is_wp_error( $page_id ) ) {
                // Set the page template if it exists
                $template_file = 'page-' . $slug . '.php';
                if ( locate_template( $template_file ) ) {
                    update_post_meta( $page_id, '_wp_page_template', $template_file );
                }
            }
        } else {
            // Page exists, but make sure it's published
            if ( $page->post_status !== 'publish' ) {
                wp_update_post( array(
                    'ID'          => $page->ID,
                    'post_status' => 'publish',
                ) );
            }
        }
    }
}

// Create pages on admin init (one-time, can be triggered manually)
function sheikh_bassam_kayed_create_pages_on_demand() {
    // Only run if pages don't exist
    $about_page = get_page_by_path( 'about' );
    $contact_page = get_page_by_path( 'contact' );
    
    if ( ! $about_page || ! $contact_page ) {
        sheikh_bassam_kayed_create_essential_pages();
        flush_rewrite_rules();
    } else {
        // Clean up existing pages - remove default placeholder text
        $default_about_text = __( 'هذه صفحة من نحن. يمكنك تعديل المحتوى من لوحة التحكم.', 'sheikh-bassam-kayed' );
        $default_contact_text = __( 'هذه صفحة اتصل بنا. يمكنك تعديل المحتوى من لوحة التحكم.', 'sheikh-bassam-kayed' );
        
        if ( $about_page && trim( $about_page->post_content ) === $default_about_text ) {
            wp_update_post( array(
                'ID' => $about_page->ID,
                'post_content' => '',
            ) );
        }
        
        if ( $contact_page && trim( $contact_page->post_content ) === $default_contact_text ) {
            wp_update_post( array(
                'ID' => $contact_page->ID,
                'post_content' => '',
            ) );
        }
    }
}
add_action( 'admin_init', 'sheikh_bassam_kayed_create_pages_on_demand' );

// Force front-page.php to be used for homepage
function sheikh_bassam_kayed_template_include( $template ) {
    // If this is the front page and front-page.php exists, use it
    if ( is_front_page() && is_home() ) {
        $front_page_template = locate_template( 'front-page.php' );
        if ( $front_page_template ) {
            return $front_page_template;
        }
    }
    return $template;
}
add_filter( 'template_include', 'sheikh_bassam_kayed_template_include', 99 );

// Include custom meta boxes
require_once get_template_directory() . '/inc/meta-boxes.php';

// Include WhatsApp configuration
require_once get_template_directory() . '/inc/whatsapp-config.php';

// Include Social Media configuration
require_once get_template_directory() . '/inc/social-media.php';

// Include Dashboard Authentication
require_once get_template_directory() . '/inc/dashboard-auth.php';

// Include Dashboard Management
require_once get_template_directory() . '/inc/dashboard-manager.php';

// Add Hero Section Customizer Option
function sheikh_bassam_kayed_customize_register( $wp_customize ) {
    // Hero Section
    $wp_customize->add_section( 'hero_section', array(
        'title'    => __( 'قسم البطل', 'sheikh-bassam-kayed' ),
        'priority' => 30,
    ) );
    
    $wp_customize->add_setting( 'hero_intro_text', array(
        'default'           => __( 'موقع إسلامي يقدم المحاضرات، الكتب، الفتاوى، والمواد التعليمية الإسلامية', 'sheikh-bassam-kayed' ),
        'sanitize_callback' => 'wp_kses_post',
    ) );
    
    $wp_customize->add_control( 'hero_intro_text', array(
        'label'       => __( 'نص مقدمة الموقع', 'sheikh-bassam-kayed' ),
        'section'     => 'hero_section',
        'type'        => 'textarea',
    ) );
    
    // Hero Image
    $wp_customize->add_setting( 'hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_image', array(
        'label'       => __( 'صورة قسم البطل (سطح المكتب والتابلت)', 'sheikh-bassam-kayed' ),
        'description' => __( 'اختر صورة لقسم البطل - ستكون بنسبة 1160:283 (مستطيل عريض) وسيتم استخدام object-fit: cover', 'sheikh-bassam-kayed' ),
        'section'     => 'hero_section',
        'settings'    => 'hero_image',
    ) ) );
    
    // Hero Image for Mobile
    $wp_customize->add_setting( 'hero_image_mobile', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_image_mobile', array(
        'label'       => __( 'صورة قسم البطل للموبايل', 'sheikh-bassam-kayed' ),
        'description' => __( 'اختر صورة خاصة للموبايل (اختياري - إذا لم يتم اختيارها سيتم استخدام صورة سطح المكتب)', 'sheikh-bassam-kayed' ),
        'section'     => 'hero_section',
        'settings'    => 'hero_image_mobile',
    ) ) );
    
    // About Page Section
    $wp_customize->add_section( 'about_page_section', array(
        'title'    => __( 'صفحة من نحن', 'sheikh-bassam-kayed' ),
        'priority' => 40,
    ) );
    
    // About Page Image
    $wp_customize->add_setting( 'about_page_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'about_page_image', array(
        'label'       => __( 'صورة الشيخ', 'sheikh-bassam-kayed' ),
        'description' => __( 'اختر صورة الشيخ بسام كايد', 'sheikh-bassam-kayed' ),
        'section'     => 'about_page_section',
        'settings'    => 'about_page_image',
    ) ) );
    
    // About Page Description
    $wp_customize->add_setting( 'about_page_description', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    
    $wp_customize->add_control( 'about_page_description', array(
        'label'       => __( 'نبذة عن حياة الشيخ', 'sheikh-bassam-kayed' ),
        'description' => __( 'أدخل وصفاً عن حياة الشيخ بسام كايد', 'sheikh-bassam-kayed' ),
        'section'     => 'about_page_section',
        'type'        => 'textarea',
    ) );
    
    // Contact Page Section
    $wp_customize->add_section( 'contact_page_section', array(
        'title'    => __( 'صفحة اتصل بنا', 'sheikh-bassam-kayed' ),
        'priority' => 50,
    ) );
    
    // Contact Page Text
    $wp_customize->add_setting( 'contact_page_text', array(
        'default'           => __( 'نحن هنا للإجابة على استفساراتكم ومساعدتكم. لا تترددوا في التواصل معنا عبر واتساب.', 'sheikh-bassam-kayed' ),
        'sanitize_callback' => 'wp_kses_post',
    ) );
    
    $wp_customize->add_control( 'contact_page_text', array(
        'label'       => __( 'نص صفحة الاتصال', 'sheikh-bassam-kayed' ),
        'description' => __( 'أدخل النص الذي سيظهر في صفحة اتصل بنا', 'sheikh-bassam-kayed' ),
        'section'     => 'contact_page_section',
        'type'        => 'textarea',
    ) );
}
add_action( 'customize_register', 'sheikh_bassam_kayed_customize_register' );

/**
 * Add dropdown arrow to menu items with children
 */
function sheikh_bassam_kayed_add_dropdown_arrow( $item_output, $item, $depth, $args ) {
    if ( in_array( 'menu-item-has-children', $item->classes ) && $depth === 0 ) {
        $item_output = str_replace( '</a>', ' <span class="dropdown-arrow">▼</span></a>', $item_output );
    }
    return $item_output;
}

