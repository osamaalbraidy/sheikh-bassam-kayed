<?php
/**
 * The template for displaying single Friday Khutbahs
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
            $khutbah_date = get_post_meta( get_the_ID(), '_khutbah_date', true );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="single-post-header">
                    <h1><?php the_title(); ?></h1>
                    <div class="post-details">
                        <?php if ( $khutbah_date ) : ?>
                            <span><strong><?php _e( 'تاريخ الخطبة:', 'sheikh-bassam-kayed' ); ?></strong> <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $khutbah_date ) ) ); ?></span>
                        <?php else : ?>
                            <span><strong><?php _e( 'تاريخ الإضافة:', 'sheikh-bassam-kayed' ); ?></strong> <?php echo get_the_date(); ?></span>
                        <?php endif; ?>
                    </div>
                </header>
                
                <div class="entry-content">
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

