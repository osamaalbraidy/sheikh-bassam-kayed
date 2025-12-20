<?php
/**
 * The template for displaying single videos
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
            $video_url = get_post_meta( get_the_ID(), '_video_url', true );
            $video_file = get_post_meta( get_the_ID(), '_video_file', true );
            $video_date = get_post_meta( get_the_ID(), '_video_date', true );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-creative' ); ?>>
                <!-- Post Header -->
                <header class="single-post-header-creative">
                    <div class="post-header-content">
                        <div class="post-icon">🎬</div>
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        <div class="post-meta-creative">
                            <?php if ( $video_date ) : ?>
                                <span class="meta-badge"><i>📅</i> <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $video_date ) ) ); ?></span>
                            <?php else : ?>
                                <span class="meta-badge"><i>📆</i> <?php echo get_the_date(); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </header>
                
                <!-- Post Content -->
                <div class="single-post-content">
                    <?php if ( $video_url ) : ?>
                        <div class="video-embed-container-creative">
                            <div class="video-wrapper" data-video-url="<?php echo esc_url( $video_url ); ?>">
                                <!-- Video will be embedded via JavaScript -->
                            </div>
                        </div>
                    <?php elseif ( $video_file ) : ?>
                        <div class="video-embed-container-creative">
                            <video controls class="video-player">
                                <source src="<?php echo esc_url( $video_file ); ?>" type="video/mp4">
                                <?php _e( 'متصفحك لا يدعم تشغيل الفيديو', 'sheikh-bassam-kayed' ); ?>
                            </video>
                        </div>
                    <?php elseif ( has_post_thumbnail() ) : ?>
                        <div class="video-thumbnail-single">
                            <?php the_post_thumbnail( 'large', array( 'class' => 'video-thumb-image' ) ); ?>
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

.video-embed-container-creative {
    margin-bottom: 40px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    background: #000;
    position: relative;
    width: 100%;
    padding-bottom: 56.25%; /* Default 16:9 aspect ratio for landscape videos */
    height: 0;
}

/* For portrait videos, this will be overridden by JavaScript */
.video-embed-container-creative.portrait {
    padding-bottom: 0;
    height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 500px;
}

.video-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.video-wrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

/* For portrait videos */
.video-embed-container-creative.portrait .video-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.video-embed-container-creative.portrait .video-wrapper iframe {
    position: relative;
    width: auto;
    height: 100%;
    max-width: 100%;
    max-height: 100%;
}

.video-player {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
}

/* For portrait video files */
.video-embed-container-creative.portrait .video-player {
    position: relative;
    width: auto;
    height: 100%;
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.video-thumbnail-single {
    text-align: center;
    margin-bottom: 40px;
}

.video-thumb-image {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
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
    
    .video-embed-container-creative {
        padding-bottom: 56.25%;
    }
    
    .video-embed-container-creative.portrait {
        height: 400px;
    }
}
</style>

<script>
// Embed video from URL (YouTube, Vimeo, etc.) and detect portrait videos
document.addEventListener('DOMContentLoaded', function() {
    const videoWrapper = document.querySelector('.video-wrapper[data-video-url]');
    const container = document.querySelector('.video-embed-container-creative');
    
    if (videoWrapper) {
        const videoUrl = videoWrapper.getAttribute('data-video-url');
        let embedUrl = '';
        
        // YouTube
        if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
            let videoId = '';
            if (videoUrl.includes('youtube.com/watch?v=')) {
                videoId = videoUrl.split('v=')[1].split('&')[0];
            } else if (videoUrl.includes('youtu.be/')) {
                videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
            }
            embedUrl = 'https://www.youtube.com/embed/' + videoId;
        }
        // Vimeo
        else if (videoUrl.includes('vimeo.com')) {
            const videoId = videoUrl.split('vimeo.com/')[1].split('?')[0];
            embedUrl = 'https://player.vimeo.com/video/' + videoId;
        }
        
        if (embedUrl) {
            const iframe = document.createElement('iframe');
            iframe.src = embedUrl;
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
            iframe.setAttribute('allowfullscreen', '');
            videoWrapper.appendChild(iframe);
            
            // Try to detect portrait video after iframe loads
            iframe.onload = function() {
                setTimeout(function() {
                    checkIfPortrait(iframe, container);
                }, 1000);
            };
        }
    }
    
    // Check for video elements
    const videoPlayer = document.querySelector('.video-player');
    if (videoPlayer && container) {
        // Check if video is already loaded
        if (videoPlayer.readyState >= 1) {
            checkVideoPortrait(videoPlayer, container);
        } else {
            // Wait for metadata to load
            videoPlayer.addEventListener('loadedmetadata', function() {
                checkVideoPortrait(videoPlayer, container);
            });
            // Also check on loadeddata as fallback
            videoPlayer.addEventListener('loadeddata', function() {
                checkVideoPortrait(videoPlayer, container);
            });
        }
    }
});

// Function to check if iframe video is portrait
function checkIfPortrait(iframe, container) {
    if (!iframe || !container) return;
    
    // Check if URL indicates portrait (YouTube Shorts, etc.)
    const iframeSrc = iframe.src;
    if (iframeSrc.includes('shorts') || iframeSrc.includes('short')) {
        container.classList.add('portrait');
        return;
    }
    
    // Try to detect based on iframe dimensions after it renders
    setTimeout(function() {
        try {
            const iframeWidth = iframe.offsetWidth || iframe.clientWidth;
            const iframeHeight = iframe.offsetHeight || iframe.clientHeight;
            
            // If height is significantly larger than width, it's portrait
            if (iframeHeight > iframeWidth * 1.3) {
                container.classList.add('portrait');
            }
        } catch (e) {
            // Cross-origin restrictions might prevent this
            console.log('Cannot detect iframe dimensions due to CORS');
        }
    }, 1500);
}

// Function to check if video element is portrait
function checkVideoPortrait(video, container) {
    if (!video || !container) return;
    
    const videoWidth = video.videoWidth;
    const videoHeight = video.videoHeight;
    
    // If height is larger than width, it's portrait
    if (videoHeight > videoWidth) {
        container.classList.add('portrait');
    }
}
</script>

<?php
get_footer();
