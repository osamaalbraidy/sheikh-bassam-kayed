<?php
/**
 * The template for displaying single books
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
            $book_author = get_post_meta( get_the_ID(), '_book_author', true );
            $book_year = get_post_meta( get_the_ID(), '_book_year', true );
            $book_pdf = get_post_meta( get_the_ID(), '_book_pdf', true );
            $book_pdf = sheikh_bassam_kayed_fix_url( $book_pdf );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-creative' ); ?>>
                <!-- Post Header -->
                <header class="single-post-header-creative">
                    <div class="post-header-content">
                        <div class="post-icon">📚</div>
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        <div class="post-meta-creative">
                            <?php if ( $book_author ) : ?>
                                <span class="meta-badge"><i>👤</i> <?php echo esc_html( $book_author ); ?></span>
                            <?php endif; ?>
                            <?php if ( $book_year ) : ?>
                                <span class="meta-badge"><i>📅</i> <?php echo esc_html( $book_year ); ?></span>
                            <?php endif; ?>
                            <span class="meta-badge"><i>📆</i> <?php echo get_the_date(); ?></span>
                        </div>
                    </div>
                </header>
                
                <!-- Post Content -->
                <div class="single-post-content">
                    <div class="book-cover-single">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'large', array( 'class' => 'book-cover-image' ) ); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/empty-book-cover.png' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="book-cover-image" />
                        <?php endif; ?>
                    </div>
                    
                    <div class="entry-content-wrapper">
                        <?php the_content(); ?>
                    </div>
                    
                    <?php if ( $book_pdf ) : ?>
                        <div class="book-download-section">
                            <a href="<?php echo esc_url( $book_pdf ); ?>" target="_blank" class="book-download-btn-large">
                                <span class="download-icon">📥</span>
                                <span class="download-text">تحميل الكتاب PDF</span>
                            </a>
                        </div>
                    <?php endif; ?>
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
    padding: 20px;
}

.single-post-creative {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.single-post-header-creative {
    background: linear-gradient(135deg, #1B7560 0%, #135243 100%);
    padding: 35px 30px;
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
    padding: 30px 25px;
}

.book-cover-single {
    text-align: center;
    margin-bottom: 25px;
}

.book-cover-image {
    max-width: 400px;
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
}

.book-cover-image:hover {
    transform: scale(1.02);
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

.book-download-section {
    margin-top: 30px;
    padding: 20px;
    background: linear-gradient(135deg, rgba(27, 117, 96, 0.05) 0%, rgba(19, 82, 67, 0.05) 100%);
    border-radius: 15px;
    text-align: center;
    border: 2px dashed #1B7560;
}

.book-download-btn-large {
    display: inline-flex;
    align-items: center;
    gap: 15px;
    background: linear-gradient(135deg, #1B7560 0%, #135243 100%);
    color: #fff;
    padding: 18px 40px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 18px;
    font-weight: 700;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(27, 117, 96, 0.3);
}

.book-download-btn-large:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(27, 117, 96, 0.4);
}

.download-icon {
    font-size: 24px;
}

.post-navigation-creative {
    margin-top: 30px;
    padding: 0 25px 25px;
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
    
    .post-meta-creative {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<?php
get_footer();
