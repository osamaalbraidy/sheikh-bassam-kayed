<?php
/**
 * Template Name: Books Archive Page
 * The template for displaying Books archive as a page
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
        
        <div class="books-grid">
            <?php
            $books_query = new WP_Query( array(
                'post_type' => 'book',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
            ) );
            
            if ( $books_query->have_posts() ) {
                while ( $books_query->have_posts() ) {
                    $books_query->the_post();
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
                wp_reset_postdata();
            } else {
                echo '<p>' . __( 'لا توجد كتب بعد.', 'sheikh-bassam-kayed' ) . '</p>';
            }
            ?>
        </div>
    </div>
</main>

<?php
get_footer();

