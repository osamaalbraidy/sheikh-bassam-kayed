<?php
/**
 * The template for displaying Contact page
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();

// Get Customizer options
$contact_text = get_theme_mod( 'contact_page_text', __( 'نحن هنا للإجابة على استفساراتكم ومساعدتكم. لا تترددوا في التواصل معنا عبر واتساب.', 'sheikh-bassam-kayed' ) );
$whatsapp_number = get_theme_mod( 'whatsapp_number', '+96171226483' );
?>

<main class="site-main">
    <div class="content-area">
        <div class="contact-page">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="single-post-header">
                    <h1><?php the_title(); ?></h1>
                </header>
                
                <div class="contact-content">
                    <?php if ( $contact_text ) : ?>
                        <div class="contact-text">
                            <?php echo wp_kses_post( wpautop( $contact_text ) ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php
                    // Show page content if admin added any (skip default placeholder text)
                    while ( have_posts() ) {
                        the_post();
                        $content = trim( get_the_content() );
                        $default_text = __( 'هذه صفحة اتصل بنا. يمكنك تعديل المحتوى من لوحة التحكم.', 'sheikh-bassam-kayed' );
                        
                        if ( $content && $content !== $default_text ) {
                            ?>
                            <div class="page-content">
                                <?php the_content(); ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    
                    <div class="contact-whatsapp-section">
                        <h3><?php _e( 'تواصل مع الشيخ بسام كايد', 'sheikh-bassam-kayed' ); ?></h3>
                        <p class="whatsapp-number-display">
                            <?php _e( 'رقم واتساب:', 'sheikh-bassam-kayed' ); ?> 
                            <strong><?php echo esc_html( $whatsapp_number ); ?></strong>
                        </p>
                        <?php sheikh_bassam_kayed_whatsapp_button( __( 'تواصل عبر واتساب', 'sheikh-bassam-kayed' ) ); ?>
                    </div>
                </div>
            </article>
        </div>
    </div>
</main>

<?php
get_footer();

