<?php
/**
 * The front page template
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();
?>

<main class="site-main">
    <!-- Hero Section -->
    <section class="hero-section">
        <?php
        $hero_image = get_theme_mod( 'hero_image', '' );
        $hero_image_mobile = get_theme_mod( 'hero_image_mobile', '' );
        
        if ( $hero_image ) :
            // Use ratio 1160:283 (24.4%)
            $aspect_ratio = 24.4; // 1160:283 ratio
            ?>
            <div class="hero-image-container" style="--aspect-ratio: <?php echo esc_attr( $aspect_ratio ); ?>%;">
                <?php if ( $hero_image_mobile ) : ?>
                    <!-- Desktop/Tablet Image -->
                    <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="hero-image hero-image-desktop" />
                    <!-- Mobile Image -->
                    <img src="<?php echo esc_url( $hero_image_mobile ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="hero-image hero-image-mobile" />
                <?php else : ?>
                    <!-- Single Image for All Devices -->
                    <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="hero-image" />
                <?php endif; ?>
                <div class="hero-overlay">
                    <div class="hero-content">
                        <h1 class="hero-logo-text">الشّيخ بسّام كايد</h1>
                        <div class="hero-intro">
                            <?php
                            $hero_text = get_theme_mod( 'hero_intro_text', __( 'موقع إسلامي يقدم المحاضرات، الكتب، الفتاوى، والمواد التعليمية الإسلامية', 'sheikh-bassam-kayed' ) );
                            echo wp_kses_post( $hero_text );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <!-- Fallback div with aspect ratio 1160:283 -->
            <div class="hero-image-container hero-fallback" style="--aspect-ratio: 24.4%;">
                <div class="hero-content">
                    <h1 class="hero-logo-text">الشّيخ بسّام كايد</h1>
                    <div class="hero-intro">
                        <?php
                        $hero_text = get_theme_mod( 'hero_intro_text', __( 'موقع إسلامي يقدم المحاضرات، الكتب، الفتاوى، والمواد التعليمية الإسلامية', 'sheikh-bassam-kayed' ) );
                        echo wp_kses_post( $hero_text );
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
    
    <div class="content-area">
        <!-- Latest Books Section -->
        <section class="home-section creative-section">
            <div class="section-header">
                <div class="section-icon">📚</div>
                <h2 class="section-title">أحدث الكتب</h2>
                <div class="section-line"></div>
            </div>
            <div class="books-grid-creative">
                <?php
                $books_query = new WP_Query( array(
                    'post_type' => 'book',
                    'posts_per_page' => 3,
                    'orderby' => 'rand',
                ) );
                
                if ( $books_query->have_posts() ) {
                    while ( $books_query->have_posts() ) {
                        $books_query->the_post();
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
                                    <?php if ( $book_pdf ) : ?>
                                        <a href="<?php echo esc_url( $book_pdf ); ?>" target="_blank" class="book-download-btn">
                                            <span>📥</span> تحميل PDF
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                } else {
                    echo '<p class="no-content">لا توجد كتب بعد.</p>';
                }
                ?>
            </div>
            <div class="section-footer">
                <a href="<?php echo esc_url( home_url( '/books' ) ); ?>" class="btn-creative">
                    <span>عرض جميع الكتب</span>
                    <span class="btn-arrow">←</span>
                </a>
            </div>
        </section>
        
        <!-- Latest Audio Lectures Section -->
        <section class="home-section creative-section audio-section">
            <div class="section-header">
                <div class="section-icon">🎙️</div>
                <h2 class="section-title">أحدث المحاضرات الصوتية</h2>
                <div class="section-line"></div>
            </div>
            <div class="audio-cards-grid">
                <?php
                $audio_query = new WP_Query( array(
                    'post_type' => 'audio_lecture',
                    'posts_per_page' => 3,
                    'orderby' => 'rand',
                ) );
                
                if ( $audio_query->have_posts() ) {
                    while ( $audio_query->have_posts() ) {
                        $audio_query->the_post();
                        $audio_file = get_post_meta( get_the_ID(), '_audio_file', true );
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
                            <div class="audio-excerpt"><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="audio-link">استمع للمزيد →</a>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                } else {
                    echo '<p class="no-content">لا توجد محاضرات صوتية بعد.</p>';
                }
                ?>
            </div>
            <div class="section-footer">
                <a href="<?php echo esc_url( home_url( '/audio-lectures' ) ); ?>" class="btn-creative">
                    <span>عرض جميع المحاضرات الصوتية</span>
                    <span class="btn-arrow">←</span>
                </a>
            </div>
        </section>
        
        <!-- Latest Videos Section -->
        <section class="home-section creative-section video-section">
            <div class="section-header">
                <div class="section-icon">🎬</div>
                <h2 class="section-title">أحدث الفيديوهات</h2>
                <div class="section-line"></div>
            </div>
            <div class="videos-grid-creative">
                <?php
                $videos_query = new WP_Query( array(
                    'post_type' => 'video',
                    'posts_per_page' => 3,
                    'orderby' => 'rand',
                ) );
                
                if ( $videos_query->have_posts() ) {
                    while ( $videos_query->have_posts() ) {
                        $videos_query->the_post();
                        $video_url = get_post_meta( get_the_ID(), '_video_url', true );
                        $video_date = get_post_meta( get_the_ID(), '_video_date', true );
                        ?>
                        <div class="video-card-creative">
                            <div class="video-thumb-wrapper">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="video-thumb-link">
                                        <?php the_post_thumbnail( 'video-thumb', array( 'class' => 'video-thumb-creative' ) ); ?>
                                        <div class="play-overlay">
                                            <div class="play-button">▶</div>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="video-card-content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="video-meta">
                                    <?php if ( $video_date ) : ?>
                                        <span><i>📅</i> <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $video_date ) ) ); ?></span>
                                    <?php else : ?>
                                        <span><i>📅</i> <?php echo get_the_date(); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="video-excerpt"><?php the_excerpt(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="video-watch-btn">شاهد الفيديو →</a>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                } else {
                    echo '<p class="no-content">لا توجد فيديوهات بعد.</p>';
                }
                ?>
            </div>
            <div class="section-footer">
                <a href="<?php echo esc_url( home_url( '/videos' ) ); ?>" class="btn-creative">
                    <span>عرض جميع الفيديوهات</span>
                    <span class="btn-arrow">←</span>
                </a>
            </div>
        </section>
        
        <!-- Latest Friday Khutbahs Section -->
        <section class="home-section creative-section khutbah-section">
            <div class="section-header">
                <div class="section-icon">🕌</div>
                <h2 class="section-title">أحدث خطب الجمعة</h2>
                <div class="section-line"></div>
            </div>
            <div class="khutbah-cards-grid">
                <?php
                $khutbahs_query = new WP_Query( array(
                    'post_type' => 'friday_khutbah',
                    'posts_per_page' => 3,
                    'orderby' => 'rand',
                ) );
                
                if ( $khutbahs_query->have_posts() ) {
                    while ( $khutbahs_query->have_posts() ) {
                        $khutbahs_query->the_post();
                        $khutbah_date = get_post_meta( get_the_ID(), '_khutbah_date', true );
                        ?>
                        <div class="khutbah-card-creative">
                            <div class="khutbah-content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="khutbah-excerpt"><?php the_excerpt(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="khutbah-read-btn">اقرأ الخطبة كاملة →</a>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                } else {
                    echo '<p class="no-content">لا توجد خطب بعد.</p>';
                }
                ?>
            </div>
            <div class="section-footer">
                <a href="<?php echo esc_url( home_url( '/friday-khutbahs' ) ); ?>" class="btn-creative">
                    <span>عرض جميع الخطب</span>
                    <span class="btn-arrow">←</span>
                </a>
            </div>
        </section>
        
        <!-- Gallery Preview Section -->
        <section class="home-section creative-section gallery-section">
            <div class="section-header">
                <div class="section-icon">🖼️</div>
                <h2 class="section-title">معرض الصور</h2>
                <div class="section-line"></div>
            </div>
            <div class="gallery-grid-creative">
                <?php
                $gallery_query = new WP_Query( array(
                    'post_type' => 'gallery',
                    'posts_per_page' => 3,
                    'orderby' => 'rand',
                ) );
                
                if ( $gallery_query->have_posts() ) {
                    while ( $gallery_query->have_posts() ) {
                        $gallery_query->the_post();
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
                    wp_reset_postdata();
                } else {
                    echo '<p class="no-content">لا توجد صور في المعرض بعد.</p>';
                }
                ?>
            </div>
            <div class="section-footer">
                <a href="<?php echo esc_url( home_url( '/gallery' ) ); ?>" class="btn-creative">
                    <span>عرض جميع الصور</span>
                    <span class="btn-arrow">←</span>
                </a>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();
