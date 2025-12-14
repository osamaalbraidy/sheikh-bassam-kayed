<?php
/**
 * The main template file
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();
?>

<main class="site-main">
    <div class="content-area">
        <?php
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-item' ); ?>>
                    <header class="entry-header">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="post-meta">
                            <span><?php echo get_the_date(); ?></span>
                        </div>
                    </header>
                    
                    <div class="entry-content">
                        <?php
                        if ( has_excerpt() ) {
                            the_excerpt();
                        } else {
                            the_content( '...' );
                        }
                        ?>
                        <a href="<?php the_permalink(); ?>" class="read-more">اقرأ المزيد</a>
                    </div>
                </article>
                <?php
            }
            
            // Pagination
            the_posts_pagination();
        } else {
            ?>
            <p>لا توجد مقالات.</p>
            <?php
        }
        ?>
    </div>
</main>

<?php
get_footer();

