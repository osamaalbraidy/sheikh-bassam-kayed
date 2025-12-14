<?php
/**
 * The template for displaying gallery archives
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
        
        <div class="gallery-grid">
            <?php
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    ?>
                    <div class="gallery-item">
                        <a href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'gallery-thumb' ); ?>
                            <?php endif; ?>
                            <div class="gallery-caption">
                                <h4><?php the_title(); ?></h4>
                                <?php if ( has_excerpt() ) : ?>
                                    <p><?php the_excerpt(); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                
                // Pagination
                the_posts_pagination();
            } else {
                ?>
                <p><?php _e( 'لا توجد صور في هذا الأرشيف.', 'sheikh-bassam-kayed' ); ?></p>
                <?php
            }
            ?>
        </div>
    </div>
</main>

<?php
get_footer();

