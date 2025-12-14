<?php
/**
 * The template for displaying all pages
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
                </header>
                
                <div class="entry-content">
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'large', array( 'class' => 'featured-image' ) );
                    }
                    the_content();
                    
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'الصفحات:', 'sheikh-bassam-kayed' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>
            </article>
            <?php
        }
        ?>
    </div>
</main>

<?php
get_footer();

