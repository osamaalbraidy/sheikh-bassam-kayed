<?php
/**
 * The template for displaying single gallery items
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
            $gallery_images = get_post_meta( get_the_ID(), '_gallery_images', true );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-creative' ); ?>>
                <!-- Post Header -->
                <header class="single-post-header-creative">
                    <div class="post-header-content">
                        <div class="post-icon">🖼️</div>
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        <div class="post-meta-creative">
                            <span class="meta-badge"><i>📆</i> <?php echo get_the_date(); ?></span>
                        </div>
                    </div>
                </header>
                
                <!-- Post Content -->
                <div class="single-post-content">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="gallery-featured-image">
                            <?php the_post_thumbnail( 'large', array( 'class' => 'gallery-main-image' ) ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $gallery_images && is_array( $gallery_images ) && count( $gallery_images ) > 0 ) : ?>
                        <div class="gallery-images-grid">
                            <?php foreach ( $gallery_images as $image_url ) : ?>
                                <div class="gallery-image-item">
                                    <a href="<?php echo esc_url( $image_url ); ?>" data-lightbox="gallery" data-title="<?php echo esc_attr( get_the_title() ); ?>">
                                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" />
                                        <div class="gallery-image-overlay">
                                            <span class="view-icon">👁️</span>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
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
    max-width: 1200px;
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

.gallery-featured-image {
    margin-bottom: 25px;
    text-align: center;
}

.gallery-main-image {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.gallery-images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.gallery-image-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.gallery-image-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.gallery-image-item img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    display: block;
}

.gallery-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(27, 117, 96, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-image-item:hover .gallery-image-overlay {
    opacity: 1;
}

.view-icon {
    font-size: 32px;
    color: #fff;
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
    
    .gallery-images-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
