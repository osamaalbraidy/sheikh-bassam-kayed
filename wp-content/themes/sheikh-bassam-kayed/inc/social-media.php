<?php
/**
 * Social Media Configuration
 *
 * @package Sheikh_Bassam_Kayed
 */

// Add Social Media settings to Customizer
function sheikh_bassam_kayed_social_media_customize_register( $wp_customize ) {
    // Add Social Media Section
    $wp_customize->add_section( 'social_media_settings', array(
        'title'    => __( 'حسابات التواصل الاجتماعي', 'sheikh-bassam-kayed' ),
        'priority' => 130,
    ) );
    
    // Available social media platforms
    $social_platforms = array(
        'facebook' => array(
            'label' => __( 'فيسبوك', 'sheikh-bassam-kayed' ),
            'icon' => 'facebook',
        ),
        'twitter' => array(
            'label' => __( 'تويتر', 'sheikh-bassam-kayed' ),
            'icon' => 'twitter',
        ),
        'youtube' => array(
            'label' => __( 'يوتيوب', 'sheikh-bassam-kayed' ),
            'icon' => 'youtube',
        ),
        'instagram' => array(
            'label' => __( 'إنستغرام', 'sheikh-bassam-kayed' ),
            'icon' => 'instagram',
        ),
        'telegram' => array(
            'label' => __( 'تيليجرام', 'sheikh-bassam-kayed' ),
            'icon' => 'telegram',
        ),
        'linkedin' => array(
            'label' => __( 'لينكد إن', 'sheikh-bassam-kayed' ),
            'icon' => 'linkedin',
        ),
    );
    
    // Add settings and controls for each platform
    foreach ( $social_platforms as $platform => $data ) {
        $wp_customize->add_setting( 'social_' . $platform, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( 'social_' . $platform, array(
            'label'       => $data['label'],
            'description' => __( 'أدخل رابط', 'sheikh-bassam-kayed' ) . ' ' . $data['label'],
            'section'     => 'social_media_settings',
            'type'        => 'url',
        ) );
    }
}
add_action( 'customize_register', 'sheikh_bassam_kayed_social_media_customize_register' );

// Get social media links
function sheikh_bassam_kayed_get_social_media() {
    $social_platforms = array(
        'facebook' => array(
            'label' => __( 'فيسبوك', 'sheikh-bassam-kayed' ),
            'icon' => 'facebook',
            'url' => get_theme_mod( 'social_facebook', '' ),
        ),
        'twitter' => array(
            'label' => __( 'تويتر', 'sheikh-bassam-kayed' ),
            'icon' => 'twitter',
            'url' => get_theme_mod( 'social_twitter', '' ),
        ),
        'youtube' => array(
            'label' => __( 'يوتيوب', 'sheikh-bassam-kayed' ),
            'icon' => 'youtube',
            'url' => get_theme_mod( 'social_youtube', '' ),
        ),
        'instagram' => array(
            'label' => __( 'إنستغرام', 'sheikh-bassam-kayed' ),
            'icon' => 'instagram',
            'url' => get_theme_mod( 'social_instagram', '' ),
        ),
        'telegram' => array(
            'label' => __( 'تيليجرام', 'sheikh-bassam-kayed' ),
            'icon' => 'telegram',
            'url' => get_theme_mod( 'social_telegram', '' ),
        ),
        'linkedin' => array(
            'label' => __( 'لينكد إن', 'sheikh-bassam-kayed' ),
            'icon' => 'linkedin',
            'url' => get_theme_mod( 'social_linkedin', '' ),
        ),
    );
    
    // Filter out empty URLs
    $active_social = array();
    foreach ( $social_platforms as $platform => $data ) {
        if ( ! empty( $data['url'] ) ) {
            $active_social[ $platform ] = $data;
        }
    }
    
    return $active_social;
}

// Get social media icon
function sheikh_bassam_kayed_get_social_icon( $platform ) {
    $icons = array(
        'facebook' => '📘',
        'twitter' => '🐦',
        'youtube' => '📺',
        'instagram' => '📷',
        'telegram' => '✈️',
        'linkedin' => '💼',
    );
    
    return isset( $icons[ $platform ] ) ? $icons[ $platform ] : '🔗';
}

// Display social media links
function sheikh_bassam_kayed_display_social_media( $class = 'social-media-links' ) {
    $social_links = sheikh_bassam_kayed_get_social_media();
    
    if ( empty( $social_links ) ) {
        return;
    }
    
    ?>
    <ul class="<?php echo esc_attr( $class ); ?>">
        <?php foreach ( $social_links as $platform => $data ) : ?>
            <li>
                <a href="<?php echo esc_url( $data['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="social-link social-<?php echo esc_attr( $platform ); ?>" aria-label="<?php echo esc_attr( $data['label'] ); ?>">
                    <span class="social-icon social-icon-<?php echo esc_attr( $platform ); ?>"><?php echo esc_html( sheikh_bassam_kayed_get_social_icon( $platform ) ); ?></span>
                    <span class="social-label"><?php echo esc_html( $data['label'] ); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
}

