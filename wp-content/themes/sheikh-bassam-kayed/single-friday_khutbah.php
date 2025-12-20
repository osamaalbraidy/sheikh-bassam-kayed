<?php
/**
 * The template for displaying single Friday Khutbah
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();
?>

<main class="site-main">
    <div class="content-area single-page">
        <?php
        while ( have_posts() ) {
            the_post();
            $khutbah_date = get_post_meta( get_the_ID(), '_khutbah_date', true );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-creative' ); ?>>
                <!-- Post Header -->
                <header class="single-post-header-creative">
                    <div class="post-header-content">
                        <div class="post-icon">🕌</div>
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        <div class="post-meta-creative">
                            <?php if ( $khutbah_date ) : ?>
                                <span class="meta-badge"><i>📅</i> <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $khutbah_date ) ) ); ?></span>
                            <?php else : ?>
                                <span class="meta-badge"><i>📆</i> <?php echo get_the_date(); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </header>
                
                <!-- Post Content -->
                <div class="single-post-content">
                    <div class="entry-content-wrapper">
                        <?php the_content(); ?>
                    </div>
                </div>
                
                <!-- Post Navigation -->
                <nav class="post-navigation-creative">
                    <?php
                    the_post_navigation( array(
                        'prev_text' => '<div class="nav-content"><span class="nav-label">السابق</span><span class="nav-title">%title</span></div>',
                        'next_text' => '<div class="nav-content"><span class="nav-label">التالي</span><span class="nav-title">%title</span></div>',
                    ) );
                    ?>
                </nav>
            </article>
            <?php
        }
        ?>
    </div>
</main>

<style>
.single-page {
    max-width: 1000px;
    margin: 0 auto;
    padding: 40px 20px;
}

.single-post-creative {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.single-post-header-creative {
    background: linear-gradient(135deg, #1B7560 0%, #135243 100%);
    padding: 50px 40px;
    color: #fff;
    text-align: center;
}

.post-header-content {
    max-width: 800px;
    margin: 0 auto;
}

.post-icon {
    font-size: 64px;
    margin-bottom: 20px;
    display: block;
}

.post-title {
    font-size: 36px;
    font-weight: 700;
    margin: 0 0 25px 0;
    color: #fff;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    line-height: 1.3;
}

.post-meta-creative {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.meta-badge {
    background: rgba(255,255,255,0.2);
    padding: 8px 18px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
}

.single-post-content {
    padding: 50px 40px;
}

.entry-content-wrapper {
    font-size: 18px;
    line-height: 1.9;
    color: #333;
}

.entry-content-wrapper h2,
.entry-content-wrapper h3,
.entry-content-wrapper h4 {
    color: #1B7560;
    margin-top: 30px;
    margin-bottom: 15px;
}

.entry-content-wrapper p {
    margin-bottom: 20px;
}

.post-navigation-creative {
    margin-top: 50px;
    padding: 0 40px 40px;
}

.post-navigation-creative .nav-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.post-navigation-creative .nav-previous,
.post-navigation-creative .nav-next {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.post-navigation-creative .nav-previous:hover,
.post-navigation-creative .nav-next:hover {
    background: linear-gradient(135deg, #1B7560 0%, #135243 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(27, 117, 96, 0.3);
}

.post-navigation-creative .nav-previous:hover .nav-title,
.post-navigation-creative .nav-next:hover .nav-title {
    color: #fff;
}

.post-navigation-creative a {
    display: flex;
    align-items: center;
    gap: 15px;
    text-decoration: none;
    color: #333;
}

.nav-arrow {
    font-size: 24px;
    font-weight: bold;
    color: #1B7560;
}

.post-navigation-creative .nav-previous:hover .nav-arrow,
.post-navigation-creative .nav-next:hover .nav-arrow {
    color: #fff;
}

.nav-content {
    flex: 1;
}

.nav-label {
    display: block;
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.post-navigation-creative .nav-previous:hover .nav-label,
.post-navigation-creative .nav-next:hover .nav-label {
    color: rgba(255,255,255,0.8);
}

.nav-title {
    display: block;
    font-weight: 600;
    color: #1B7560;
    font-size: 16px;
}

@media (max-width: 768px) {
    .single-post-header-creative {
        padding: 30px 20px;
    }
    
    .post-title {
        font-size: 28px;
    }
    
    .single-post-content {
        padding: 30px 20px;
    }
    
    .post-navigation-creative {
        padding: 0 20px 30px;
    }
    
    .post-navigation-creative .nav-links {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
