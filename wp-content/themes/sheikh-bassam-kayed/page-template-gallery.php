<?php
/**
 * Template Name: Gallery Archive Page
 * The template for displaying Gallery archive as a page
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();
?>

<main class="site-main">
    <div class="content-area">
        <header class="archive-header">
            <h1><?php the_title(); ?></h1>
        </header>
        
        <div class="gallery-grid">
            <?php
            $gallery_query = new WP_Query( array(
                'post_type' => 'gallery',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
            ) );
            
            if ( $gallery_query->have_posts() ) {
                while ( $gallery_query->have_posts() ) {
                    $gallery_query->the_post();
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
                wp_reset_postdata();
            } else {
                echo '<p>' . __( 'لا توجد صور في المعرض بعد.', 'sheikh-bassam-kayed' ) . '</p>';
            }
            ?>
        </div>
    </div>
</main>

<?php
get_footer();

