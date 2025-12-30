<?php
/**
 * Template Name: Videos Archive Page
 * The template for displaying Videos archive as a page
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();
?>

<main class="site-main">
    <div class="content-area">
        <header class="archive-header">
            <h1><?php the_title(); ?></h1>
        </header>
        
        <div class="home-sections">
            <?php
            $videos_query = new WP_Query( array(
                'post_type' => 'video',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_status' => 'publish',
            ) );
            
            if ( $videos_query->have_posts() ) {
                while ( $videos_query->have_posts() ) {
                    $videos_query->the_post();
                    $video_url = get_post_meta( get_the_ID(), '_video_url', true );
                    $video_date = get_post_meta( get_the_ID(), '_video_date', true );
                    ?>
                    <article class="post-item">
                        <a href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'video-thumb', array( 'style' => 'width: 100%; height: auto; border-radius: 8px; margin-bottom: 15px;' ) ); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/video-cover.png' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" style="width: 100%; height: auto; border-radius: 8px; margin-bottom: 15px;" />
                            <?php endif; ?>
                        </a>
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
                wp_reset_postdata();
            } else {
                echo '<p>' . __( 'لا توجد فيديوهات بعد.', 'sheikh-bassam-kayed' ) . '</p>';
            }
            ?>
        </div>
    </div>
</main>

<?php
get_footer();

