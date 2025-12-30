<?php
/**
 * The template for displaying audio lecture archives
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
                <div class="archive-icon">🎙️</div>
                <h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
                <p class="archive-description"><?php _e( 'استمع إلى المحاضرات الصوتية الإسلامية', 'sheikh-bassam-kayed' ); ?></p>
            </div>
        </header>
        
        <!-- Audio Grid -->
        <div class="audio-cards-grid archive-grid">
            <?php
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    $audio_file = get_post_meta( get_the_ID(), '_audio_file', true );
                    $audio_file = sheikh_bassam_kayed_fix_url( $audio_file );
                    $audio_date = get_post_meta( get_the_ID(), '_audio_date', true );
                    $audio_category = get_post_meta( get_the_ID(), '_audio_category', true );
                    ?>
                    <div class="audio-card-creative">
                        <div class="audio-card-header">
                            <div class="audio-icon">🎵</div>
                            <?php if ( $audio_category ) : ?>
                                <span class="audio-category"><?php echo esc_html( $audio_category ); ?></span>
                            <?php endif; ?>
                        </div>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="audio-meta">
                            <?php if ( $audio_date ) : ?>
                                <span><i>📅</i> <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $audio_date ) ) ); ?></span>
                            <?php else : ?>
                                <span><i>📅</i> <?php echo get_the_date(); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ( $audio_file ) : ?>
                            <div class="audio-player-creative">
                                <audio controls>
                                    <source src="<?php echo esc_url( $audio_file ); ?>" type="audio/mpeg">
                                    <?php _e( 'متصفحك لا يدعم تشغيل الصوت', 'sheikh-bassam-kayed' ); ?>
                                </audio>
                            </div>
                        <?php endif; ?>
                        <?php if ( has_excerpt() ) : ?>
                            <div class="audio-excerpt"><?php the_excerpt(); ?></div>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="audio-link">استمع للمزيد →</a>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="no-content-message">
                    <div class="no-content-icon">🎙️</div>
                    <p><?php _e( 'لا توجد محاضرات صوتية في هذا الأرشيف.', 'sheikh-bassam-kayed' ); ?></p>
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
