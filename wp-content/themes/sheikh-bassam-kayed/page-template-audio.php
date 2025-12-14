<?php
/**
 * Template Name: Audio Lectures Archive Page
 * The template for displaying Audio Lectures archive as a page
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
        
        <?php
        $audio_query = new WP_Query( array(
            'post_type' => 'audio_lecture',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ) );
        
        if ( $audio_query->have_posts() ) {
            while ( $audio_query->have_posts() ) {
                $audio_query->the_post();
                $audio_file = get_post_meta( get_the_ID(), '_audio_file', true );
                $audio_date = get_post_meta( get_the_ID(), '_audio_date', true );
                $audio_category = get_post_meta( get_the_ID(), '_audio_category', true );
                ?>
                <article class="post-item">
                    <header class="entry-header">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="post-meta">
                            <?php if ( $audio_date ) : ?>
                                <span><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $audio_date ) ) ); ?></span>
                            <?php else : ?>
                                <span><?php echo get_the_date(); ?></span>
                            <?php endif; ?>
                            <?php if ( $audio_category ) : ?>
                                <span> | <?php echo esc_html( $audio_category ); ?></span>
                            <?php endif; ?>
                        </div>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                        <?php if ( $audio_file ) : ?>
                            <div class="audio-player-container">
                                <audio controls>
                                    <source src="<?php echo esc_url( $audio_file ); ?>" type="audio/mpeg">
                                    <?php _e( 'متصفحك لا يدعم تشغيل الصوت', 'sheikh-bassam-kayed' ); ?>
                                </audio>
                            </div>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="read-more">اقرأ المزيد</a>
                    </div>
                </article>
                <?php
            }
            wp_reset_postdata();
        } else {
            echo '<p>' . __( 'لا توجد محاضرات صوتية بعد.', 'sheikh-bassam-kayed' ) . '</p>';
        }
        ?>
    </div>
</main>

<?php
get_footer();

