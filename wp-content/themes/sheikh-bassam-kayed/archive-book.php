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
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    $book_author = get_post_meta( get_the_ID(), '_book_author', true );
                    $book_year = get_post_meta( get_the_ID(), '_book_year', true );
                    $book_pdf = get_post_meta( get_the_ID(), '_book_pdf', true );
                    ?>
                    <div class="book-card-creative">
                        <div class="book-card-inner">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="book-cover-wrapper">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'book-cover', array( 'class' => 'book-cover-creative' ) ); ?>
                                        <div class="book-overlay">
                                            <span class="view-book">عرض الكتاب</span>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
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
        <?php if ( have_posts() ) : ?>
            <div class="archive-pagination">
                <?php
                the_posts_pagination( array(
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
    padding: 40px 20px;
}

.archive-header-creative {
    background: linear-gradient(135deg, #1B7560 0%, #135243 100%);
    border-radius: 20px;
    padding: 60px 40px;
    margin-bottom: 50px;
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
    gap: 30px;
    margin-bottom: 50px;
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
    margin-top: 50px;
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
