<?php
/**
 * The template for displaying Friday Khutbah archives
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();
?>

<main class="site-main">
    <div class="content-area">
        <header class="archive-header">
            <h1><?php post_type_archive_title(); ?></h1>
        </header>
        
        <?php
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                $khutbah_date = get_post_meta( get_the_ID(), '_khutbah_date', true );
                ?>
                <article class="post-item">
                    <header class="entry-header">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="post-meta">
                            <?php if ( $khutbah_date ) : ?>
                                <span><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $khutbah_date ) ) ); ?></span>
                            <?php else : ?>
                                <span><?php echo get_the_date(); ?></span>
                            <?php endif; ?>
                        </div>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                        <a href="<?php the_permalink(); ?>" class="read-more">اقرأ الخطبة كاملة</a>
                    </div>
                </article>
                <?php
            }
            
            // Pagination
            the_posts_pagination();
        } else {
            ?>
            <p><?php _e( 'لا توجد خطب في هذا الأرشيف.', 'sheikh-bassam-kayed' ); ?></p>
            <?php
        }
        ?>
    </div>
</main>

<?php
get_footer();

