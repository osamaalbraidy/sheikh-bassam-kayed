<?php
/**
 * The template for displaying single gallery items
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
            $gallery_images = get_post_meta( get_the_ID(), '_gallery_images', true );
            $gallery_images = $gallery_images ? explode( ',', $gallery_images ) : array();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="single-post-header">
                    <h1><?php the_title(); ?></h1>
                    <div class="post-details">
                        <span><strong><?php _e( 'تاريخ الإضافة:', 'sheikh-bassam-kayed' ); ?></strong> <?php echo get_the_date(); ?></span>
                    </div>
                </header>
                
                <div class="entry-content">
                    <?php if ( ! empty( $gallery_images ) ) : ?>
                        <div class="gallery-grid">
                            <?php foreach ( $gallery_images as $image_id ) : ?>
                                <?php if ( $image_id ) : ?>
                                    <div class="gallery-item">
                                        <?php echo wp_get_attachment_image( $image_id, 'gallery-thumb', false, array( 'class' => 'gallery-image' ) ); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php elseif ( has_post_thumbnail() ) : ?>
                        <div style="text-align: center; margin-bottom: 30px;">
                            <?php the_post_thumbnail( 'large' ); ?>
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

