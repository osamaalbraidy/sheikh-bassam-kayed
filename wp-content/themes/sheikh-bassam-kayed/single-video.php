<?php
/**
 * The template for displaying single videos
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();
?>

<main class="site-main">
    <div class="content-area">
        <?php
        while ( have_posts() ) {
            the_post();
            $video_url = get_post_meta( get_the_ID(), '_video_url', true );
            $video_file = get_post_meta( get_the_ID(), '_video_file', true );
            $video_date = get_post_meta( get_the_ID(), '_video_date', true );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="single-post-header">
                    <h1><?php the_title(); ?></h1>
                    <div class="post-details">
                        <?php if ( $video_date ) : ?>
                            <span><strong><?php _e( 'تاريخ الفيديو:', 'sheikh-bassam-kayed' ); ?></strong> <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $video_date ) ) ); ?></span>
                        <?php else : ?>
                            <span><strong><?php _e( 'تاريخ الإضافة:', 'sheikh-bassam-kayed' ); ?></strong> <?php echo get_the_date(); ?></span>
                        <?php endif; ?>
                    </div>
                </header>
                
                <div class="entry-content">
                    <?php if ( $video_url ) : ?>
                        <div class="video-embed-container" data-video-url="<?php echo esc_url( $video_url ); ?>">
                            <!-- Video will be embedded via JavaScript -->
                        </div>
                    <?php elseif ( $video_file ) : ?>
                        <div class="video-embed-container">
                            <video controls style="width: 100%; height: auto;">
                                <source src="<?php echo esc_url( $video_file ); ?>" type="video/mp4">
                                <?php _e( 'متصفحك لا يدعم تشغيل الفيديو', 'sheikh-bassam-kayed' ); ?>
                            </video>
                        </div>
                    <?php endif; ?>
                    
                    <?php the_content(); ?>
                </div>
                
                <footer class="entry-footer">
                    <?php
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'الصفحات:', 'sheikh-bassam-kayed' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </footer>
            </article>
            
            <?php
            // Navigation
            the_post_navigation( array(
                'prev_text' => '<span class="nav-subtitle">' . __( 'السابق:', 'sheikh-bassam-kayed' ) . '</span> <span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-subtitle">' . __( 'التالي:', 'sheikh-bassam-kayed' ) . '</span> <span class="nav-title">%title</span>',
            ) );
        }
        ?>
    </div>
</main>

<?php
get_footer();

