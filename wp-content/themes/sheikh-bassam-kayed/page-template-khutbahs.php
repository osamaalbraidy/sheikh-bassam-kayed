<?php
/**
 * Template Name: Friday Khutbahs Archive Page
 * The template for displaying Friday Khutbahs archive as a page
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
        $khutbahs_query = new WP_Query( array(
            'post_type' => 'friday_khutbah',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ) );
        
        if ( $khutbahs_query->have_posts() ) {
            while ( $khutbahs_query->have_posts() ) {
                $khutbahs_query->the_post();
                $khutbah_date = get_post_meta( get_the_ID(), '_khutbah_date', true );
                ?>
                <article class="post-item">
                    <header class="entry-header">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="post-meta">
                            <?php if ( $khutbah_date ) : ?>
                                <span><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $khutbah_date ) ) ); ?></span>
                            <?php else : ?>
                                <span><?php echo get_the_date(); ?></span>
                            <?php endif; ?>
                        </div>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                        <a href="<?php the_permalink(); ?>" class="read-more">اقرأ الخطبة كاملة</a>
                    </div>
                </article>
                <?php
            }
            wp_reset_postdata();
        } else {
            echo '<p>' . __( 'لا توجد خطب بعد.', 'sheikh-bassam-kayed' ) . '</p>';
        }
        ?>
    </div>
</main>

<?php
get_footer();

