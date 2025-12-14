<?php
/**
 * Dashboard Page Template
 *
 * @package Sheikh_Bassam_Kayed
 */

// Check authentication
if ( ! sheikh_bassam_kayed_is_dashboard_authenticated() ) {
    wp_safe_redirect( home_url( '/dashboard-login' ) );
    exit;
}

get_header();

$success_message = isset( $_SESSION['dashboard_success'] ) ? $_SESSION['dashboard_success'] : '';
$error_message = isset( $_SESSION['dashboard_error'] ) ? $_SESSION['dashboard_error'] : '';
unset( $_SESSION['dashboard_success'] );
unset( $_SESSION['dashboard_error'] );

// Get current settings
$hero_intro = get_theme_mod( 'hero_intro_text', '' );
$hero_image = get_theme_mod( 'hero_image', '' );
$hero_image_mobile = get_theme_mod( 'hero_image_mobile', '' );
$about_image = get_theme_mod( 'about_page_image', '' );
$about_description = get_theme_mod( 'about_page_description', '' );
$contact_text = get_theme_mod( 'contact_page_text', '' );
$whatsapp_number = get_theme_mod( 'whatsapp_number', '+96171226483' );
$whatsapp_message = get_theme_mod( 'whatsapp_message', 'مرحباً، أريد التواصل معكم' );
$social_facebook = get_theme_mod( 'social_facebook', '' );
$social_twitter = get_theme_mod( 'social_twitter', '' );
$social_youtube = get_theme_mod( 'social_youtube', '' );
$social_instagram = get_theme_mod( 'social_instagram', '' );
$social_telegram = get_theme_mod( 'social_telegram', '' );
$social_linkedin = get_theme_mod( 'social_linkedin', '' );

// Get active tab from URL - use query var first, then REQUEST_URI, default to 'hero'
$active_tab = 'hero'; // Default to first tab

// Try to get from query var (set by rewrite rule)
$dashboard_tab = get_query_var( 'dashboard_tab' );
if ( ! empty( $dashboard_tab ) ) {
    $active_tab = sanitize_text_field( $dashboard_tab );
} else {
    // Fallback: parse from REQUEST_URI
    $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
    // Remove query string for parsing
    $request_path = parse_url( $request_uri, PHP_URL_PATH );
    
    if ( preg_match( '/\/dashboard\/([^\/\?]+)/', $request_path, $matches ) ) {
        $active_tab = sanitize_text_field( $matches[1] );
    } elseif ( isset( $_GET['tab'] ) ) {
        $active_tab = sanitize_text_field( $_GET['tab'] );
    }
    // If we're on /dashboard without a tab, just default to 'hero' tab (no redirect needed)
    // The page will display with hero tab active by default
}

// Valid tabs
$valid_tabs = array( 'hero', 'about', 'contact', 'social', 'whatsapp', 'books', 'audio', 'khutbahs', 'videos', 'gallery' );
if ( ! in_array( $active_tab, $valid_tabs ) ) {
    $active_tab = 'hero';
}

// Get editing post ID if in edit mode
$editing_post_id = isset( $_GET['edit'] ) ? intval( $_GET['edit'] ) : 0;
$editing_post = $editing_post_id ? get_post( $editing_post_id ) : null;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php _e( 'لوحة التحكم', 'sheikh-bassam-kayed' ); ?></title>
    <?php 
    wp_enqueue_media(); // Enqueue WordPress media uploader
    wp_head(); 
    ?>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f5f5f5;
            direction: rtl;
        }
        .dashboard-header {
            background: linear-gradient(135deg, #135243 0%, #1B7560 100%);
            color: #fff;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .dashboard-header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dashboard-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .dashboard-logout {
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            background: rgba(255,255,255,0.2);
            border-radius: 6px;
            transition: background 0.3s;
        }
        .dashboard-logout:hover {
            background: rgba(255,255,255,0.3);
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px;
        }
        .dashboard-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            border-bottom: 2px solid #ddd;
        }
        .dashboard-tab {
            padding: 12px 24px;
            background: #fff;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            color: #666;
            transition: all 0.3s;
        }
        .dashboard-tab.active {
            color: #1B7560;
            border-bottom-color: #1B7560;
        }
        .dashboard-tab:hover {
            color: #1B7560;
        }
        .dashboard-content {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            min-height: 600px;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .form-section {
            margin-bottom: 40px;
        }
        .form-section h3 {
            color: #1B7560;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #1B7560;
            font-size: 24px;
            font-weight: 700;
        }
        .form-section h4 {
            color: #333;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 600;
            padding: 15px;
            background: linear-gradient(90deg, rgba(27, 117, 96, 0.1) 0%, transparent 100%);
            border-right: 4px solid #1B7560;
            border-radius: 6px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        .form-group input[type="text"],
        .form-group input[type="url"],
        .form-group input[type="email"],
        .form-group input[type="number"],
        .form-group input[type="date"],
        .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            background: #fff;
            border-color: #1B7560;
            box-shadow: 0 0 0 3px rgba(27, 117, 96, 0.1);
        }
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #1B7560;
        }
        .submit-button {
            background: linear-gradient(135deg, #1B7560 0%, #135243 100%);
            color: #fff;
            padding: 14px 35px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(27, 117, 96, 0.3);
            position: relative;
            overflow: hidden;
        }
        .submit-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        .submit-button:hover {
            background: linear-gradient(135deg, #135243 0%, #1B7560 100%);
            box-shadow: 0 6px 20px rgba(27, 117, 96, 0.4);
            transform: translateY(-2px);
        }
        .submit-button:hover::before {
            width: 300px;
            height: 300px;
        }
        .submit-button:active {
            transform: translateY(0);
        }
        .success-message {
            background: linear-gradient(90deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            padding: 18px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-right: 4px solid #28a745;
            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.2);
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        .success-message::before {
            content: '✓';
            margin-left: 10px;
            font-size: 20px;
            font-weight: bold;
        }
        .image-upload-wrapper {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .image-upload-input-wrapper {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .image-upload-input-wrapper input {
            flex: 1;
        }
        .image-upload-button {
            padding: 12px 20px;
            background: #1B7560;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
            transition: background 0.3s;
        }
        .image-upload-button:hover {
            background: #135243;
        }
        .image-remove-button {
            padding: 12px 20px;
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
            transition: background 0.3s;
        }
        .image-remove-button:hover {
            background: #c82333;
        }
        .image-preview {
            max-width: 300px;
            margin-top: 10px;
            border-radius: 6px;
            border: 2px solid #eee;
            display: block;
        }
        .image-preview.hidden {
            display: none;
        }
        .file-upload-button {
            padding: 12px 20px;
            background: #1B7560;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
            transition: background 0.3s;
            margin-right: 10px;
        }
        .file-upload-button:hover {
            background: #135243;
        }
        .dashboard-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 25px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .dashboard-table thead tr {
            background: linear-gradient(135deg, #1B7560 0%, #135243 100%);
        }
        .dashboard-table th {
            padding: 18px 15px;
            text-align: right;
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }
        .dashboard-table th:first-child {
            border-top-right-radius: 10px;
        }
        .dashboard-table th:last-child {
            border-top-left-radius: 10px;
        }
        .dashboard-table td {
            padding: 16px 15px;
            border-bottom: 1px solid #f0f0f0;
            text-align: right;
            color: #333;
        }
        .dashboard-table tbody tr {
            transition: all 0.2s ease;
        }
        .dashboard-table tbody tr:hover {
            background: rgba(27, 117, 96, 0.05);
            transform: scale(1.01);
        }
        .dashboard-table tbody tr:last-child td:first-child {
            border-bottom-right-radius: 10px;
        }
        .dashboard-table tbody tr:last-child td:last-child {
            border-bottom-left-radius: 10px;
        }
        .dashboard-table td:last-child {
            text-align: center;
        }
        .dashboard-table a {
            color: #1B7560;
            text-decoration: none;
            margin: 0 8px;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            background: rgba(27, 117, 96, 0.1);
        }
        .dashboard-table a:hover {
            background: #1B7560;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(27, 117, 96, 0.3);
        }
        .dashboard-table a.delete-link {
            color: #dc3545;
            background: rgba(220, 53, 69, 0.1);
        }
        .dashboard-table a.delete-link:hover {
            background: #dc3545;
            color: #fff;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }
        .dashboard-table img {
            max-width: 80px;
            height: auto;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        /* CRUD Form Styles */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #1B7560;
        }
        .section-header h3 {
            margin: 0;
            border: none;
            padding: 0;
        }
        .add-new-button {
            background: linear-gradient(135deg, #1B7560 0%, #135243 100%);
            color: #fff;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(27, 117, 96, 0.3);
        }
        .add-new-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(27, 117, 96, 0.4);
        }
        .crud-form-wrapper {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease, margin 0.4s ease;
            margin-bottom: 0;
            padding: 0;
            background: #f9f9f9;
            border-radius: 8px;
            border: 2px solid transparent;
        }
        .crud-form-wrapper.show {
            max-height: 5000px;
            padding: 25px;
            margin-bottom: 30px;
            border-color: #1B7560;
        }
        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }
        .form-header h4 {
            margin: 0;
            padding: 0;
            border: none;
            background: none;
        }
        .close-form-button {
            background: #dc3545;
            color: #fff;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .close-form-button:hover {
            background: #c82333;
            transform: rotate(90deg);
        }
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }
        .cancel-form-button {
            background: #666;
            color: #fff;
            padding: 14px 35px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .cancel-form-button:hover {
            background: #555;
            transform: translateY(-2px);
        }
        .data-list-section {
            margin-top: 30px;
        }
        .data-list-section h4 {
            margin-bottom: 20px;
            color: #1B7560;
            font-size: 20px;
            font-weight: 700;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 2px dashed #ddd;
        }
        .empty-state p {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
        }
        
        /* Dashboard Layout */
        .dashboard-wrapper {
            display: flex;
            gap: 30px;
            max-width: 1600px;
            margin: 0 auto;
            align-items: flex-start;
        }
        .dashboard-sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1B7560 0%, #135243 100%);
            border-radius: 12px;
            padding: 25px 0;
            height: fit-content;
            position: sticky;
            top: 20px;
            box-shadow: 0 4px 20px rgba(27, 117, 96, 0.3);
        }
        .dashboard-sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .dashboard-sidebar-menu li {
            margin: 0;
        }
        .dashboard-sidebar-menu .menu-divider {
            margin: 20px 0;
            padding: 0 20px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }
        .dashboard-sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            border-right: 4px solid transparent;
            position: relative;
        }
        .dashboard-sidebar-menu a::before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: rgba(255, 255, 255, 0.15);
            transition: width 0.3s ease;
        }
        .dashboard-sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding-right: 30px;
        }
        .dashboard-sidebar-menu a:hover::before {
            width: 4px;
        }
        .dashboard-sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border-right-color: #d8a51c;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .dashboard-sidebar-menu a.active::before {
            width: 4px;
            background: #d8a51c;
        }
        .dashboard-main-content {
            flex: 1;
            min-width: 0;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .dashboard-wrapper {
                flex-direction: column;
            }
            .dashboard-sidebar {
                width: 100%;
                position: relative;
                top: 0;
            }
            .dashboard-sidebar-menu {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                padding: 15px;
            }
            .dashboard-sidebar-menu li {
                flex: 1 1 auto;
            }
            .dashboard-sidebar-menu a {
                padding: 12px 15px;
                border-radius: 8px;
                border-right: none;
                border-bottom: 3px solid transparent;
            }
            .dashboard-sidebar-menu a.active {
                border-right: none;
                border-bottom-color: #d8a51c;
            }
            .dashboard-sidebar-menu .menu-divider {
                width: 100%;
                margin: 10px 0;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1><?php _e( 'لوحة التحكم', 'sheikh-bassam-kayed' ); ?></h1>
            <a href="<?php echo esc_url( wp_nonce_url( home_url( '/dashboard-login?dashboard_logout=1' ), 'dashboard_logout' ) ); ?>" class="dashboard-logout">
                <?php _e( 'تسجيل الخروج', 'sheikh-bassam-kayed' ); ?>
            </a>
        </div>
    </div>
    
    <div class="dashboard-container">
        <?php if ( $success_message ) : ?>
            <div class="success-message">
                <?php echo esc_html( $success_message ); ?>
            </div>
        <?php endif; ?>
        <?php if ( $error_message ) : ?>
            <div class="error-message" style="background: #fee; color: #c33; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #fcc;">
                <?php echo esc_html( $error_message ); ?>
            </div>
        <?php endif; ?>
        
        <div class="dashboard-wrapper">
            <!-- Main Content Area -->
            <div class="dashboard-main-content">
        <div class="dashboard-content">
            <!-- Hero Section Tab -->
            <div class="tab-content <?php echo $active_tab === 'hero' ? 'active' : ''; ?>" id="hero-tab">
                <form method="post">
                    <?php wp_nonce_field( 'update_hero_settings', 'hero_settings_nonce' ); ?>
                    <div class="form-section">
                        <h3><?php _e( 'إعدادات قسم البطل', 'sheikh-bassam-kayed' ); ?></h3>
                        <div class="form-group">
                            <label><?php _e( 'نص المقدمة', 'sheikh-bassam-kayed' ); ?></label>
                            <textarea name="hero_intro_text"><?php echo esc_textarea( $hero_intro ); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><?php _e( 'صورة قسم البطل (سطح المكتب)', 'sheikh-bassam-kayed' ); ?></label>
                            <div class="image-upload-wrapper">
                                <div class="image-upload-input-wrapper">
                                    <input type="url" id="hero_image" name="hero_image" value="<?php echo esc_url( $hero_image ); ?>" placeholder="https://..." />
                                    <button type="button" class="image-upload-button" data-target="hero_image"><?php _e( 'رفع صورة', 'sheikh-bassam-kayed' ); ?></button>
                                    <?php if ( $hero_image ) : ?>
                                        <button type="button" class="image-remove-button" data-target="hero_image"><?php _e( 'حذف', 'sheikh-bassam-kayed' ); ?></button>
                                    <?php endif; ?>
                                </div>
                                <img src="<?php echo esc_url( $hero_image ); ?>" class="image-preview <?php echo $hero_image ? '' : 'hidden'; ?>" id="hero_image_preview" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php _e( 'صورة قسم البطل (الموبايل)', 'sheikh-bassam-kayed' ); ?></label>
                            <div class="image-upload-wrapper">
                                <div class="image-upload-input-wrapper">
                                    <input type="url" id="hero_image_mobile" name="hero_image_mobile" value="<?php echo esc_url( $hero_image_mobile ); ?>" placeholder="https://..." />
                                    <button type="button" class="image-upload-button" data-target="hero_image_mobile"><?php _e( 'رفع صورة', 'sheikh-bassam-kayed' ); ?></button>
                                    <?php if ( $hero_image_mobile ) : ?>
                                        <button type="button" class="image-remove-button" data-target="hero_image_mobile"><?php _e( 'حذف', 'sheikh-bassam-kayed' ); ?></button>
                                    <?php endif; ?>
                                </div>
                                <img src="<?php echo esc_url( $hero_image_mobile ); ?>" class="image-preview <?php echo $hero_image_mobile ? '' : 'hidden'; ?>" id="hero_image_mobile_preview" />
                            </div>
                        </div>
                        <button type="submit" name="update_hero_settings" class="submit-button">
                            <?php _e( 'حفظ التغييرات', 'sheikh-bassam-kayed' ); ?>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- About Page Tab -->
            <div class="tab-content <?php echo $active_tab === 'about' ? 'active' : ''; ?>" id="about-tab">
                <form method="post">
                    <?php wp_nonce_field( 'update_about_settings', 'about_settings_nonce' ); ?>
                    <div class="form-section">
                        <h3><?php _e( 'إعدادات صفحة من نحن', 'sheikh-bassam-kayed' ); ?></h3>
                        <div class="form-group">
                            <label><?php _e( 'صورة الشيخ', 'sheikh-bassam-kayed' ); ?></label>
                            <div class="image-upload-wrapper">
                                <div class="image-upload-input-wrapper">
                                    <input type="url" id="about_page_image" name="about_page_image" value="<?php echo esc_url( $about_image ); ?>" placeholder="https://..." />
                                    <button type="button" class="image-upload-button" data-target="about_page_image"><?php _e( 'رفع صورة', 'sheikh-bassam-kayed' ); ?></button>
                                    <?php if ( $about_image ) : ?>
                                        <button type="button" class="image-remove-button" data-target="about_page_image"><?php _e( 'حذف', 'sheikh-bassam-kayed' ); ?></button>
                                    <?php endif; ?>
                                </div>
                                <img src="<?php echo esc_url( $about_image ); ?>" class="image-preview <?php echo $about_image ? '' : 'hidden'; ?>" id="about_page_image_preview" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php _e( 'نبذة عن حياة الشيخ', 'sheikh-bassam-kayed' ); ?></label>
                            <textarea name="about_page_description"><?php echo esc_textarea( $about_description ); ?></textarea>
                        </div>
                        <button type="submit" name="update_about_settings" class="submit-button">
                            <?php _e( 'حفظ التغييرات', 'sheikh-bassam-kayed' ); ?>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Contact Page Tab -->
            <div class="tab-content <?php echo $active_tab === 'contact' ? 'active' : ''; ?>" id="contact-tab">
                <form method="post">
                    <?php wp_nonce_field( 'update_contact_settings', 'contact_settings_nonce' ); ?>
                    <div class="form-section">
                        <h3><?php _e( 'إعدادات صفحة اتصل بنا', 'sheikh-bassam-kayed' ); ?></h3>
                        <div class="form-group">
                            <label><?php _e( 'نص صفحة الاتصال', 'sheikh-bassam-kayed' ); ?></label>
                            <textarea name="contact_page_text"><?php echo esc_textarea( $contact_text ); ?></textarea>
                        </div>
                        <button type="submit" name="update_contact_settings" class="submit-button">
                            <?php _e( 'حفظ التغييرات', 'sheikh-bassam-kayed' ); ?>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Social Media Tab -->
            <div class="tab-content <?php echo $active_tab === 'social' ? 'active' : ''; ?>" id="social-tab">
                <form method="post">
                    <?php wp_nonce_field( 'update_social_settings', 'social_settings_nonce' ); ?>
                    <div class="form-section">
                        <h3><?php _e( 'حسابات التواصل الاجتماعي', 'sheikh-bassam-kayed' ); ?></h3>
                        <div class="form-group">
                            <label>📘 <?php _e( 'فيسبوك', 'sheikh-bassam-kayed' ); ?></label>
                            <input type="url" name="social_facebook" value="<?php echo esc_url( $social_facebook ); ?>" placeholder="https://facebook.com/..." />
                        </div>
                        <div class="form-group">
                            <label>🐦 <?php _e( 'تويتر', 'sheikh-bassam-kayed' ); ?></label>
                            <input type="url" name="social_twitter" value="<?php echo esc_url( $social_twitter ); ?>" placeholder="https://twitter.com/..." />
                        </div>
                        <div class="form-group">
                            <label>📺 <?php _e( 'يوتيوب', 'sheikh-bassam-kayed' ); ?></label>
                            <input type="url" name="social_youtube" value="<?php echo esc_url( $social_youtube ); ?>" placeholder="https://youtube.com/..." />
                        </div>
                        <div class="form-group">
                            <label>📷 <?php _e( 'إنستغرام', 'sheikh-bassam-kayed' ); ?></label>
                            <input type="url" name="social_instagram" value="<?php echo esc_url( $social_instagram ); ?>" placeholder="https://instagram.com/..." />
                        </div>
                        <div class="form-group">
                            <label>✈️ <?php _e( 'تيليجرام', 'sheikh-bassam-kayed' ); ?></label>
                            <input type="url" name="social_telegram" value="<?php echo esc_url( $social_telegram ); ?>" placeholder="https://t.me/..." />
                        </div>
                        <div class="form-group">
                            <label>💼 <?php _e( 'لينكد إن', 'sheikh-bassam-kayed' ); ?></label>
                            <input type="url" name="social_linkedin" value="<?php echo esc_url( $social_linkedin ); ?>" placeholder="https://linkedin.com/..." />
                        </div>
                        <button type="submit" name="update_social_settings" class="submit-button">
                            <?php _e( 'حفظ التغييرات', 'sheikh-bassam-kayed' ); ?>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- WhatsApp Tab -->
            <div class="tab-content <?php echo $active_tab === 'whatsapp' ? 'active' : ''; ?>" id="whatsapp-tab">
                <form method="post">
                    <?php wp_nonce_field( 'update_whatsapp_settings', 'whatsapp_settings_nonce' ); ?>
                    <div class="form-section">
                        <h3><?php _e( 'إعدادات واتساب', 'sheikh-bassam-kayed' ); ?></h3>
                        <div class="form-group">
                            <label><?php _e( 'رقم واتساب', 'sheikh-bassam-kayed' ); ?></label>
                            <input type="text" name="whatsapp_number" value="<?php echo esc_attr( $whatsapp_number ); ?>" placeholder="+96171226483" />
                        </div>
                        <div class="form-group">
                            <label><?php _e( 'الرسالة الافتراضية', 'sheikh-bassam-kayed' ); ?></label>
                            <input type="text" name="whatsapp_message" value="<?php echo esc_attr( $whatsapp_message ); ?>" />
                        </div>
                        <button type="submit" name="update_whatsapp_settings" class="submit-button">
                            <?php _e( 'حفظ التغييرات', 'sheikh-bassam-kayed' ); ?>
                        </button>
                    </div>
                </form>
            </div>
            
            <?php
            // Include CRUD tabs for post types
            include get_template_directory() . '/inc/dashboard-crud-tabs.php';
            ?>
        </div>
            </div>
            
            <!-- Sidebar Navigation (Right Side) -->
            <aside class="dashboard-sidebar">
                <ul class="dashboard-sidebar-menu">
                    <li><a href="<?php echo esc_url( home_url( '/dashboard/hero' ) ); ?>" class="<?php echo $active_tab === 'hero' ? 'active' : ''; ?>"><?php _e( 'قسم البطل', 'sheikh-bassam-kayed' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/dashboard/about' ) ); ?>" class="<?php echo $active_tab === 'about' ? 'active' : ''; ?>"><?php _e( 'صفحة من نحن', 'sheikh-bassam-kayed' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/dashboard/contact' ) ); ?>" class="<?php echo $active_tab === 'contact' ? 'active' : ''; ?>"><?php _e( 'صفحة اتصل بنا', 'sheikh-bassam-kayed' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/dashboard/social' ) ); ?>" class="<?php echo $active_tab === 'social' ? 'active' : ''; ?>"><?php _e( 'التواصل الاجتماعي', 'sheikh-bassam-kayed' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/dashboard/whatsapp' ) ); ?>" class="<?php echo $active_tab === 'whatsapp' ? 'active' : ''; ?>"><?php _e( 'واتساب', 'sheikh-bassam-kayed' ); ?></a></li>
                    <li class="menu-divider"><?php _e( 'إدارة المحتوى', 'sheikh-bassam-kayed' ); ?></li>
                    <li><a href="<?php echo esc_url( home_url( '/dashboard/books' ) ); ?>" class="<?php echo $active_tab === 'books' ? 'active' : ''; ?>">📚 <?php _e( 'الكتب', 'sheikh-bassam-kayed' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/dashboard/audio' ) ); ?>" class="<?php echo $active_tab === 'audio' ? 'active' : ''; ?>">🎤 <?php _e( 'المحاضرات الصوتية', 'sheikh-bassam-kayed' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/dashboard/khutbahs' ) ); ?>" class="<?php echo $active_tab === 'khutbahs' ? 'active' : ''; ?>">📿 <?php _e( 'خطب الجمعة', 'sheikh-bassam-kayed' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/dashboard/videos' ) ); ?>" class="<?php echo $active_tab === 'videos' ? 'active' : ''; ?>">🎥 <?php _e( 'الفيديوهات', 'sheikh-bassam-kayed' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/dashboard/gallery' ) ); ?>" class="<?php echo $active_tab === 'gallery' ? 'active' : ''; ?>">🖼️ <?php _e( 'المعرض', 'sheikh-bassam-kayed' ); ?></a></li>
                </ul>
            </aside>
        </div>
    </div>
    
    <script>
        // Initialize active tab from URL or default
        var activeTab = '<?php echo esc_js( $active_tab ); ?>';
        
        // Set active tab on page load
        if (activeTab) {
            document.querySelectorAll('.dashboard-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            
            var activeTabButton = document.querySelector('.dashboard-tab[data-tab="' + activeTab + '"]');
            var activeTabContent = document.getElementById(activeTab + '-tab');
            
            if (activeTabButton) activeTabButton.classList.add('active');
            if (activeTabContent) activeTabContent.classList.add('active');
        }
        
        // Tab switching
        document.querySelectorAll('.dashboard-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.dashboard-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId + '-tab').classList.add('active');
            });
        });
        
        // WordPress Media Uploader
        (function($) {
            'use strict';
            
            // Image upload button handler
            $('.image-upload-button').on('click', function(e) {
                e.preventDefault();
                
                var button = $(this);
                var targetInput = button.data('target');
                var previewId = targetInput + '_preview';
                
                // Create media frame
                var frame = wp.media({
                    title: 'اختر صورة',
                    button: {
                        text: 'استخدم هذه الصورة'
                    },
                    multiple: false
                });
                
                // When image is selected
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#' + targetInput).val(attachment.url);
                    $('#' + previewId).attr('src', attachment.url).removeClass('hidden');
                    
                    // Show remove button if not already visible
                    if (button.siblings('.image-remove-button').length === 0) {
                        button.after('<button type="button" class="image-remove-button" data-target="' + targetInput + '">حذف</button>');
                    }
                });
                
                // Open media frame
                frame.open();
            });
            
            // Image remove button handler
            $(document).on('click', '.image-remove-button', function(e) {
                e.preventDefault();
                
                var button = $(this);
                var targetInput = button.data('target');
                var previewId = targetInput + '_preview';
                
                $('#' + targetInput).val('');
                $('#' + previewId).addClass('hidden');
                button.remove();
            });
            
            // File upload button handler (PDF, Audio, Video)
            $('.file-upload-button').on('click', function(e) {
                e.preventDefault();
                
                var button = $(this);
                var targetInput = button.data('target');
                var fileType = button.data('type');
                
                // Map file types to mime types
                var mimeTypes = {
                    'application/pdf': ['application/pdf'],
                    'audio': ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp3'],
                    'video': ['video/mp4', 'video/webm', 'video/ogg']
                };
                
                var libraryType = mimeTypes[fileType] || null;
                
                // Create media frame
                var frameOptions = {
                    title: 'اختر ملف',
                    button: {
                        text: 'استخدم هذا الملف'
                    },
                    multiple: false
                };
                
                if (libraryType) {
                    frameOptions.library = {
                        type: libraryType
                    };
                }
                
                var frame = wp.media(frameOptions);
                
                // When file is selected
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#' + targetInput).val(attachment.url);
                });
                
                // Open media frame
                frame.open();
            });
            
        })(jQuery);
        
        // CRUD Form Toggle Functionality
        (function() {
            // Check if we're in edit mode (URL has ?edit= parameter)
            var urlParams = new URLSearchParams(window.location.search);
            var editId = urlParams.get('edit');
            
            // Show form if in edit mode
            if (editId) {
                var activeTab = '<?php echo esc_js( $active_tab ); ?>';
                var formId = activeTab + '-form';
                var formWrapper = document.getElementById(formId);
                if (formWrapper) {
                    formWrapper.classList.add('show');
                    // Scroll to form
                    setTimeout(function() {
                        formWrapper.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }, 100);
                }
            }
            
            // Add New Button - Show Form
            document.querySelectorAll('.add-new-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    var formId = this.getAttribute('data-form');
                    var formWrapper = document.getElementById(formId);
                    if (formWrapper) {
                        formWrapper.classList.add('show');
                        // Scroll to form
                        setTimeout(function() {
                            formWrapper.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }, 100);
                    }
                });
            });
            
            // Close Form Button
            document.querySelectorAll('.close-form-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    var formId = this.getAttribute('data-form');
                    var formWrapper = document.getElementById(formId);
                    if (formWrapper) {
                        formWrapper.classList.remove('show');
                        // Clear form if not in edit mode
                        var urlParams = new URLSearchParams(window.location.search);
                        if (!urlParams.get('edit')) {
                            var form = formWrapper.querySelector('form');
                            if (form) {
                                form.reset();
                            }
                        }
                    }
                });
            });
            
            // Cancel Form Button
            document.querySelectorAll('.cancel-form-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    var formId = this.getAttribute('data-form');
                    var tab = this.getAttribute('data-tab');
                    var formWrapper = document.getElementById(formId);
                    if (formWrapper) {
                        formWrapper.classList.remove('show');
                        // Redirect to clean URL (remove edit parameter)
                        // Simply remove query parameters from current URL
                        var currentUrl = window.location.href;
                        var urlWithoutQuery = currentUrl.split('?')[0];
                        // Remove trailing slash if present
                        urlWithoutQuery = urlWithoutQuery.replace(/\/$/, '');
                        window.location.href = urlWithoutQuery;
                    }
                });
            });
        })();
    </script>
    <?php wp_footer(); ?>
</body>
</html>

