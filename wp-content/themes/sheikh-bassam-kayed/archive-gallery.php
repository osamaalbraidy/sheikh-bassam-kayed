<?php
/**
 * The template for displaying gallery archives
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
                <div class="archive-icon">🖼️</div>
                <h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
                <p class="archive-description"><?php _e( 'تصفح معرض الصور والألبومات', 'sheikh-bassam-kayed' ); ?></p>
            </div>
        </header>
        
        <!-- Gallery Grid -->
        <div class="gallery-grid-creative archive-grid">
            <?php
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    ?>
                    <div class="gallery-item-creative">
                        <a href="<?php the_permalink(); ?>" class="gallery-link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'gallery-thumb', array( 'class' => 'gallery-image-creative' ) ); ?>
                                <div class="gallery-overlay-creative">
                                    <h4><?php the_title(); ?></h4>
                                    <?php if ( has_excerpt() ) : ?>
                                        <p><?php the_excerpt(); ?></p>
                                    <?php endif; ?>
                                    <span class="gallery-view">عرض الصورة</span>
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="no-content-message">
                    <div class="no-content-icon">🖼️</div>
                    <p><?php _e( 'لا توجد صور في هذا الأرشيف.', 'sheikh-bassam-kayed' ); ?></p>
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
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
}
</style>

<?php
get_footer();
