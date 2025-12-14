<?php
/**
 * The template for displaying book archives
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
        
        <div class="books-grid">
            <?php
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    $book_author = get_post_meta( get_the_ID(), '_book_author', true );
                    $book_year = get_post_meta( get_the_ID(), '_book_year', true );
                    ?>
                    <div class="book-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'book-cover', array( 'class' => 'book-cover' ) ); ?>
                            </a>
                        <?php endif; ?>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php if ( $book_author ) : ?>
                            <div class="book-meta"><?php echo esc_html( $book_author ); ?></div>
                        <?php endif; ?>
                        <?php if ( $book_year ) : ?>
                            <div class="book-meta"><?php echo esc_html( $book_year ); ?></div>
                        <?php endif; ?>
                        <div class="post-excerpt"><?php the_excerpt(); ?></div>
                    </div>
                    <?php
                }
                
                // Pagination
                the_posts_pagination();
            } else {
                ?>
                <p><?php _e( 'لا توجد كتب في هذا الأرشيف.', 'sheikh-bassam-kayed' ); ?></p>
                <?php
            }
            ?>
        </div>
    </div>
</main>

<?php
get_footer();

