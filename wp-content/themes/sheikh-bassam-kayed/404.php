<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();
?>

<main class="site-main">
    <div class="content-area">
        <section class="error-404 not-found">
            <div class="error-404-container">
                <div class="error-404-content">
                    <div class="error-404-icon">
                        <span class="error-number">404</span>
                    </div>
                    
                    <header class="error-header">
                        <h1 class="error-title">الصفحة غير موجودة</h1>
                        <p class="error-description">عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.</p>
                    </header>
                    
                    <div class="error-actions">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="error-button error-button-primary">
                            <span>🏠</span>
                            العودة إلى الصفحة الرئيسية
                        </a>
                        
                        <a href="<?php echo esc_url( home_url( '/books' ) ); ?>" class="error-button error-button-secondary">
                            <span>📚</span>
                            تصفح الكتب
                        </a>
                    </div>
                    
                    <div class="error-search">
                        <h3>ابحث عما تريد</h3>
                        <?php get_search_form(); ?>
                    </div>
                    
                    <div class="error-links">
                        <h3>روابط مفيدة</h3>
                        <ul class="error-links-list">
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">الرئيسية</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/books' ) ); ?>">الكتب</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/audio-lectures' ) ); ?>">المحاضرات الصوتية</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/videos' ) ); ?>">الفيديوهات</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">من نحن</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">اتصل بنا</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();

