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
            <header class="page-header">
                <h1 class="page-title">404 - الصفحة غير موجودة</h1>
            </header>
            
            <div class="page-content">
                <p>عذراً، الصفحة التي تبحث عنها غير موجودة.</p>
                <p>يمكنك:</p>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">العودة إلى الصفحة الرئيسية</a></li>
                    <li>استخدام البحث للعثور على ما تبحث عنه</li>
                </ul>
                
                <?php get_search_form(); ?>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();

