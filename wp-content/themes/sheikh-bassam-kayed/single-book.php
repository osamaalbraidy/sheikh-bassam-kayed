<?php
/**
 * The template for displaying single books
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
            $book_author = get_post_meta( get_the_ID(), '_book_author', true );
            $book_year = get_post_meta( get_the_ID(), '_book_year', true );
            $book_pdf = get_post_meta( get_the_ID(), '_book_pdf', true );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="single-post-header">
                    <h1><?php the_title(); ?></h1>
                    <div class="post-details">
                        <?php if ( $book_author ) : ?>
                            <span><strong><?php _e( 'المؤلف:', 'sheikh-bassam-kayed' ); ?></strong> <?php echo esc_html( $book_author ); ?></span>
                        <?php endif; ?>
                        <?php if ( $book_year ) : ?>
                            <span><strong><?php _e( 'سنة النشر:', 'sheikh-bassam-kayed' ); ?></strong> <?php echo esc_html( $book_year ); ?></span>
                        <?php endif; ?>
                        <span><strong><?php _e( 'تاريخ الإضافة:', 'sheikh-bassam-kayed' ); ?></strong> <?php echo get_the_date(); ?></span>
                    </div>
                </header>
                
                <div class="entry-content">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div style="text-align: center; margin-bottom: 30px;">
                            <?php the_post_thumbnail( 'large', array( 'class' => 'book-cover', 'style' => 'max-width: 300px; height: auto;' ) ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php the_content(); ?>
                    
                    <?php if ( $book_pdf ) : ?>
                        <div style="text-align: center; margin: 30px 0;">
                            <a href="<?php echo esc_url( $book_pdf ); ?>" target="_blank" class="book-download">
                                <?php _e( 'تحميل الكتاب PDF', 'sheikh-bassam-kayed' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
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

