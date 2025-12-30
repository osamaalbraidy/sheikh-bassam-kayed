<?php
/**
 * Dashboard Manager - Handle all CRUD operations
 *
 * @package Sheikh_Bassam_Kayed
 */

// Handle dashboard form submissions
function sheikh_bassam_kayed_handle_dashboard_submissions() {
    if ( ! sheikh_bassam_kayed_is_dashboard_authenticated() ) {
        return;
    }
    
    // Track if we processed a form submission in this function
    $form_processed = false;
    
    // Track which tab we're on for redirect
    $current_tab = 'hero'; // Default tab
    
    // Handle Customizer options updates
    if ( isset( $_POST['update_hero_settings'] ) && wp_verify_nonce( $_POST['hero_settings_nonce'], 'update_hero_settings' ) ) {
        set_theme_mod( 'hero_intro_text', wp_kses_post( $_POST['hero_intro_text'] ) );
        set_theme_mod( 'hero_image', esc_url_raw( $_POST['hero_image'] ) );
        set_theme_mod( 'hero_image_mobile', esc_url_raw( $_POST['hero_image_mobile'] ) );
        $_SESSION['dashboard_success'] = __( 'تم تحديث إعدادات قسم البطل بنجاح', 'sheikh-bassam-kayed' );
        $form_processed = true;
        $current_tab = 'hero';
    }
    
    if ( isset( $_POST['update_about_settings'] ) && wp_verify_nonce( $_POST['about_settings_nonce'], 'update_about_settings' ) ) {
        set_theme_mod( 'about_page_image', esc_url_raw( $_POST['about_page_image'] ) );
        set_theme_mod( 'about_page_description', wp_kses_post( $_POST['about_page_description'] ) );
        $_SESSION['dashboard_success'] = __( 'تم تحديث صفحة من نحن بنجاح', 'sheikh-bassam-kayed' );
        $form_processed = true;
        $current_tab = 'about';
    }
    
    if ( isset( $_POST['update_contact_settings'] ) && wp_verify_nonce( $_POST['contact_settings_nonce'], 'update_contact_settings' ) ) {
        set_theme_mod( 'contact_page_text', wp_kses_post( $_POST['contact_page_text'] ) );
        $_SESSION['dashboard_success'] = __( 'تم تحديث صفحة اتصل بنا بنجاح', 'sheikh-bassam-kayed' );
        $form_processed = true;
        $current_tab = 'contact';
    }
    
    if ( isset( $_POST['update_social_settings'] ) && wp_verify_nonce( $_POST['social_settings_nonce'], 'update_social_settings' ) ) {
        $social_platforms = array( 'facebook', 'twitter', 'youtube', 'instagram', 'telegram', 'linkedin' );
        foreach ( $social_platforms as $platform ) {
            set_theme_mod( 'social_' . $platform, esc_url_raw( $_POST['social_' . $platform] ) );
        }
        $_SESSION['dashboard_success'] = __( 'تم تحديث حسابات التواصل الاجتماعي بنجاح', 'sheikh-bassam-kayed' );
        $form_processed = true;
        $current_tab = 'social';
    }
    
    if ( isset( $_POST['update_whatsapp_settings'] ) && wp_verify_nonce( $_POST['whatsapp_settings_nonce'], 'update_whatsapp_settings' ) ) {
        set_theme_mod( 'whatsapp_number', sanitize_text_field( $_POST['whatsapp_number'] ) );
        set_theme_mod( 'whatsapp_message', sanitize_text_field( $_POST['whatsapp_message'] ) );
        $_SESSION['dashboard_success'] = __( 'تم تحديث إعدادات واتساب بنجاح', 'sheikh-bassam-kayed' );
        $form_processed = true;
        $current_tab = 'whatsapp';
    }
    
    // Only redirect if we processed a form submission in this function
    // CRUD operations handle their own redirects, so we don't interfere
    if ( $form_processed ) {
        wp_safe_redirect( home_url( '/dashboard/' . $current_tab . '?updated=1' ) );
        exit;
    }
}
add_action( 'template_redirect', 'sheikh_bassam_kayed_handle_dashboard_submissions' );

// Create dashboard and login pages on theme activation
function sheikh_bassam_kayed_create_dashboard_pages() {
    $pages = array(
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
        $page = get_page_by_path( $slug );
        if ( ! $page ) {
            $page_id = wp_insert_post( array(
                'post_title'   => $page_data['title'],
                'post_name'    => $slug,
                'post_content' => $page_data['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => 1,
            ) );
            
            if ( $page_id && ! is_wp_error( $page_id ) ) {
                $template_file = 'page-' . $slug . '.php';
                if ( locate_template( $template_file ) ) {
                    update_post_meta( $page_id, '_wp_page_template', $template_file );
                }
            }
        }
    }
}
add_action( 'after_switch_theme', 'sheikh_bassam_kayed_create_dashboard_pages' );
add_action( 'admin_init', 'sheikh_bassam_kayed_create_dashboard_pages' );

