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
unset( $_SESSION['dashboard_success'] );

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
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
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
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 6px;
            font-size: 16px;
            font-family: inherit;
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
            background: #1B7560;
            color: #fff;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .submit-button:hover {
            background: #135243;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
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
        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        .quick-link-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .quick-link-card a {
            color: #1B7560;
            text-decoration: none;
            font-weight: 600;
            display: block;
        }
        .quick-link-card a:hover {
            text-decoration: underline;
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
        
        <div class="quick-links">
            <div class="quick-link-card">
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=book' ) ); ?>" target="_blank">
                    📚 <?php _e( 'إدارة الكتب', 'sheikh-bassam-kayed' ); ?>
                </a>
            </div>
            <div class="quick-link-card">
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=audio_lecture' ) ); ?>" target="_blank">
                    🎤 <?php _e( 'إدارة المحاضرات الصوتية', 'sheikh-bassam-kayed' ); ?>
                </a>
            </div>
            <div class="quick-link-card">
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=friday_khutbah' ) ); ?>" target="_blank">
                    📿 <?php _e( 'إدارة خطب الجمعة', 'sheikh-bassam-kayed' ); ?>
                </a>
            </div>
            <div class="quick-link-card">
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=video' ) ); ?>" target="_blank">
                    🎥 <?php _e( 'إدارة الفيديوهات', 'sheikh-bassam-kayed' ); ?>
                </a>
            </div>
            <div class="quick-link-card">
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=gallery' ) ); ?>" target="_blank">
                    🖼️ <?php _e( 'إدارة المعرض', 'sheikh-bassam-kayed' ); ?>
                </a>
            </div>
        </div>
        
        <div class="dashboard-tabs">
            <button class="dashboard-tab active" data-tab="hero"><?php _e( 'قسم البطل', 'sheikh-bassam-kayed' ); ?></button>
            <button class="dashboard-tab" data-tab="about"><?php _e( 'صفحة من نحن', 'sheikh-bassam-kayed' ); ?></button>
            <button class="dashboard-tab" data-tab="contact"><?php _e( 'صفحة اتصل بنا', 'sheikh-bassam-kayed' ); ?></button>
            <button class="dashboard-tab" data-tab="social"><?php _e( 'التواصل الاجتماعي', 'sheikh-bassam-kayed' ); ?></button>
            <button class="dashboard-tab" data-tab="whatsapp"><?php _e( 'واتساب', 'sheikh-bassam-kayed' ); ?></button>
        </div>
        
        <div class="dashboard-content">
            <!-- Hero Section Tab -->
            <div class="tab-content active" id="hero-tab">
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
            <div class="tab-content" id="about-tab">
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
            <div class="tab-content" id="contact-tab">
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
            <div class="tab-content" id="social-tab">
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
            <div class="tab-content" id="whatsapp-tab">
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
        </div>
    </div>
    
    <script>
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
            
        })(jQuery);
    </script>
    <?php wp_footer(); ?>
</body>
</html>

