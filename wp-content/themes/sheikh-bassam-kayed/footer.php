<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-columns">
            <div class="footer-column">
                <h3>خريطة الموقع</h3>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-menu',
                    'container'      => false,
                    'fallback_cb'    => 'sheikh_bassam_kayed_footer_menu_fallback',
                ) );
                ?>
            </div>
            
            <div class="footer-column">
                <h3>مواقع صديقة</h3>
                <ul>
                    <li><a href="https://www.iumsonline.org/ar/" target="_blank">الاتحاد العالمي لعلماء المسلمين</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>تابعنا</h3>
                <?php sheikh_bassam_kayed_display_social_media( 'footer-social-media' ); ?>
            </div>
            
            <div class="footer-column">
                <h3>تواصل معنا</h3>
                <?php sheikh_bassam_kayed_whatsapp_button( __( 'تواصل عبر واتساب', 'sheikh-bassam-kayed' ) ); ?>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

<?php
// Footer menu fallback
function sheikh_bassam_kayed_footer_menu_fallback() {
    ?>
    <ul>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">الرئيسية</a></li>
        <li><a href="<?php echo esc_url( home_url( '/books' ) ); ?>">الكتب</a></li>
        <li><a href="<?php echo esc_url( home_url( '/audio-lectures' ) ); ?>">المحاضرات الصوتية</a></li>
        <li><a href="<?php echo esc_url( home_url( '/friday-khutbahs' ) ); ?>">خطب الجمعة</a></li>
        <li><a href="<?php echo esc_url( home_url( '/videos' ) ); ?>">الفيديوهات</a></li>
        <li><a href="<?php echo esc_url( home_url( '/gallery' ) ); ?>">المعرض</a></li>
        <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">من نحن</a></li>
        <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">اتصل بنا</a></li>
    </ul>
    <?php
}
?>

