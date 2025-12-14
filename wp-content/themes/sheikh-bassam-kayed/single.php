<?php
/**
 * The template for displaying single posts
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
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1><?php the_title(); ?></h1>
                    <div class="post-meta">
                        <span>تاريخ النشر: <?php echo get_the_date(); ?></span>
                        <?php if ( get_the_category() ) : ?>
                            <span> | التصنيف: <?php the_category( ', ' ); ?></span>
                        <?php endif; ?>
                    </div>
                </header>
                
                <div class="entry-content">
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'large', array( 'class' => 'featured-image' ) );
                    }
                    the_content();
                    ?>
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

