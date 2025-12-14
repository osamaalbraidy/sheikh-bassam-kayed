<?php
/**
 * The template for displaying video archives
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();
?>

<main class="site-main">
    <div class="content-area">
        <header class="archive-header">
            <h1><?php post_type_archive_title(); ?></h1>
        </header>
        
        <div class="home-sections">
            <?php
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    $video_url = get_post_meta( get_the_ID(), '_video_url', true );
                    $video_date = get_post_meta( get_the_ID(), '_video_date', true );
                    ?>
                    <article class="post-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'video-thumb', array( 'style' => 'width: 100%; height: auto; border-radius: 8px; margin-bottom: 15px;' ) ); ?>
                            </a>
                        <?php endif; ?>
                        <header class="entry-header">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="post-meta">
                                <?php if ( $video_date ) : ?>
                                    <span><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $video_date ) ) ); ?></span>
                                <?php else : ?>
                                    <span><?php echo get_the_date(); ?></span>
                                <?php endif; ?>
                            </div>
                        </header>
                        
                        <div class="entry-content">
                            <?php the_excerpt(); ?>
                            <a href="<?php the_permalink(); ?>" class="read-more">شاهد الفيديو</a>
                        </div>
                    </article>
                    <?php
                }
                
                // Pagination
                the_posts_pagination();
            } else {
                ?>
                <p><?php _e( 'لا توجد فيديوهات في هذا الأرشيف.', 'sheikh-bassam-kayed' ); ?></p>
                <?php
            }
            ?>
        </div>
    </div>
</main>

<?php
get_footer();

