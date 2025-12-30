<?php
/**
 * The template for displaying book archives
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();
?>

<main class="site-main">
    <div class="content-area archive-page">
        <!-- Archive Header -->
        <header class="archive-header-creative">
            <div class="archive-header-content">
                <div class="archive-icon">📚</div>
                <h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
                <p class="archive-description"><?php _e( 'استكشف مجموعتنا الكاملة من الكتب الإسلامية', 'sheikh-bassam-kayed' ); ?></p>
            </div>
        </header>
        
        <!-- Books Grid -->
        <div class="books-grid-creative archive-grid">
            <?php
            // Re-query to ensure published posts are shown
            global $wp_query;
            $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
            $books_query = new WP_Query( array(
                'post_type' => 'book',
                'post_status' => 'publish',
                'paged' => $paged,
                'posts_per_page' => get_option( 'posts_per_page' ),
            ) );
            
            if ( $books_query->have_posts() ) {
                while ( $books_query->have_posts() ) {
                    $books_query->the_post();
                    $book_author = get_post_meta( get_the_ID(), '_book_author', true );
                    $book_year = get_post_meta( get_the_ID(), '_book_year', true );
                    $book_pdf = get_post_meta( get_the_ID(), '_book_pdf', true );
                    
                    // Fix PDF URL if needed (handle attachment IDs and relative paths)
                    if ( $book_pdf ) {
                        if ( is_numeric( $book_pdf ) ) {
                            $book_pdf = wp_get_attachment_url( $book_pdf );
                        } else {
                            $book_pdf = esc_url_raw( $book_pdf );
                            if ( ! preg_match( '/^https?:\/\//', $book_pdf ) ) {
                                $book_pdf = home_url( $book_pdf );
                            }
                        }
                    }
                    ?>
                    <div class="book-card-creative">
                        <div class="book-card-inner">
                            <div class="book-cover-wrapper">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'book-cover', array( 'class' => 'book-cover-creative' ) ); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/empty-book-cover.png' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="book-cover-creative" />
                                    <?php endif; ?>
                                    <div class="book-overlay">
                                        <span class="view-book">عرض الكتاب</span>
                                    </div>
                                </a>
                            </div>
                            <div class="book-card-content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="book-meta-creative">
                                    <?php if ( $book_author ) : ?>
                                        <span class="meta-item"><i class="meta-icon">👤</i> <?php echo esc_html( $book_author ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $book_year ) : ?>
                                        <span class="meta-item"><i class="meta-icon">📅</i> <?php echo esc_html( $book_year ); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if ( has_excerpt() ) : ?>
                                    <div class="book-excerpt"><?php the_excerpt(); ?></div>
                                <?php endif; ?>
                                <div class="book-actions">
                                    <a href="<?php the_permalink(); ?>" class="book-read-btn">اقرأ المزيد →</a>
                                    <?php if ( $book_pdf ) : ?>
                                        <a href="<?php echo esc_url( $book_pdf ); ?>" target="_blank" class="book-download-btn">
                                            <span>📥</span> تحميل PDF
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            } else {
                ?>
                <div class="no-content-message">
                    <div class="no-content-icon">📚</div>
                    <p><?php _e( 'لا توجد كتب في هذا الأرشيف.', 'sheikh-bassam-kayed' ); ?></p>
                </div>
                <?php
            }
            ?>
        </div>
        
        <!-- Pagination -->
        <?php if ( isset( $books_query ) && $books_query->have_posts() ) : ?>
            <div class="archive-pagination">
                <?php
                // Use custom pagination for the custom query
                $big = 999999999;
                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, $paged ),
                    'total' => $books_query->max_num_pages,
                    'mid_size'  => 2,
                    'prev_text' => __( '← السابق', 'sheikh-bassam-kayed' ),
                    'next_text' => __( 'التالي →', 'sheikh-bassam-kayed' ),
                ) );
                ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
.archive-page {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

.archive-header-creative {
    background: linear-gradient(135deg, #1B7560 0%, #135243 100%);
    border-radius: 20px;
    padding: 40px 30px;
    margin-bottom: 30px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(27, 117, 96, 0.3);
}

.archive-header-content {
    color: #fff;
}

.archive-icon {
    font-size: 64px;
    margin-bottom: 20px;
    display: block;
}

.archive-title {
    font-size: 42px;
    font-weight: 700;
    margin: 0 0 15px 0;
    color: #fff;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.archive-description {
    font-size: 18px;
    color: rgba(255,255,255,0.9);
    margin: 0;
}

.archive-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.no-content-message {
    text-align: center;
    padding: 80px 20px;
    grid-column: 1 / -1;
}

.no-content-icon {
    font-size: 80px;
    margin-bottom: 20px;
    opacity: 0.5;
}

.no-content-message p {
    font-size: 20px;
    color: #666;
}

.archive-pagination {
    margin-top: 30px;
    text-align: center;
}

.archive-pagination .nav-links {
    display: inline-flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
}

.archive-pagination .page-numbers {
    display: inline-block;
    padding: 12px 20px;
    background: #fff;
    color: #1B7560;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.archive-pagination .page-numbers:hover,
.archive-pagination .page-numbers.current {
    background: linear-gradient(135deg, #1B7560 0%, #135243 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(27, 117, 96, 0.3);
}

.book-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    flex-wrap: wrap;
}

.book-read-btn {
    flex: 1;
    padding: 10px 20px;
    background: linear-gradient(135deg, #1B7560 0%, #135243 100%);
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    text-align: center;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(27, 117, 96, 0.2);
}

.book-read-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(27, 117, 96, 0.4);
}

.book-excerpt {
    color: #666;
    font-size: 14px;
    line-height: 1.6;
    margin: 10px 0;
}

@media (max-width: 768px) {
    .archive-header-creative {
        padding: 40px 20px;
    }
    
    .archive-title {
        font-size: 32px;
    }
    
    .archive-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .book-actions {
        flex-direction: column;
    }
    
    .book-read-btn {
        width: 100%;
    }
}
</style>

<?php
get_footer();
