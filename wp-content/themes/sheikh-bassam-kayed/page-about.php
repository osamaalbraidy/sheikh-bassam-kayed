<?php
/**
 * The template for displaying About page
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();

// Get Customizer options
$about_image = get_theme_mod( 'about_page_image', '' );
$about_description = get_theme_mod( 'about_page_description', '' );
?>

<main class="site-main">
    <div class="content-area">
        <article class="about-page-content">
            <header class="single-post-header">
                <h1><?php the_title(); ?></h1>
            </header>
            
            <div class="about-page-wrapper">
                <?php if ( $about_image ) : ?>
                    <div class="about-image-container">
                        <img src="<?php echo esc_url( $about_image ); ?>" alt="<?php esc_attr_e( 'الشيخ بسام كايد', 'sheikh-bassam-kayed' ); ?>" class="about-image">
                    </div>
                <?php endif; ?>
                
                <?php if ( $about_description ) : ?>
                <div class="about-description">
                    <div class="about-text">
                        <?php echo wp_kses_post( wpautop( $about_description ) ); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php
                // Also show page content if admin added any (skip default placeholder text)
                while ( have_posts() ) {
                    the_post();
                    $content = trim( get_the_content() );
                    $default_text = __( 'هذه صفحة من نحن. يمكنك تعديل المحتوى من لوحة التحكم.', 'sheikh-bassam-kayed' );
                    
                    if ( $content && $content !== $default_text ) {
                        ?>
                        <div class="page-content">
                            <?php the_content(); ?>
                        </div>
                        <?php
                    }
                }
                ?>
                
                <!-- Social Media Section -->
                <?php
                $social_links = sheikh_bassam_kayed_get_social_media();
                if ( ! empty( $social_links ) ) :
                    ?>
                    <div class="about-social-media">
                        <h3><?php _e( 'تابعنا على', 'sheikh-bassam-kayed' ); ?></h3>
                        <?php sheikh_bassam_kayed_display_social_media( 'about-social-media' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </article>
    </div>
</main>

<?php
get_footer();

