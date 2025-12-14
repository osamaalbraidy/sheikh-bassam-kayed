<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-container">
        <div class="site-branding">
            <?php
            if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" rel="home">
                    <span class="logo-text">الشّيخ بسّام كايد</span>
                </a>
                <?php
            }
            ?>
        </div>
        
        <button type="button" class="menu-toggle" aria-label="<?php esc_attr_e( 'Toggle Menu', 'sheikh-bassam-kayed' ); ?>" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
        <nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'sheikh-bassam-kayed' ); ?>">
            <button type="button" class="menu-close" aria-label="<?php esc_attr_e( 'Close Menu', 'sheikh-bassam-kayed' ); ?>">
                <span>&times;</span>
            </button>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu',
                'container'      => false,
                'fallback_cb'    => 'sheikh_bassam_kayed_default_menu',
            ) );
            ?>
        </nav>
        
        <div class="mobile-menu-overlay"></div>
    </div>
</header>

<?php
// Default menu fallback
function sheikh_bassam_kayed_default_menu() {
    ?>
    <ul class="primary-menu">
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">الرئيسية</a></li>
        <li class="menu-item-has-children">
            <a href="#">الأقسام <span class="dropdown-arrow">▼</span></a>
            <ul class="sub-menu">
                <li><a href="<?php echo esc_url( home_url( '/books' ) ); ?>">الكتب</a></li>
                <li><a href="<?php echo esc_url( home_url( '/audio-lectures' ) ); ?>">المحاضرات الصوتية</a></li>
                <li><a href="<?php echo esc_url( home_url( '/friday-khutbahs' ) ); ?>">خطب الجمعة</a></li>
                <li><a href="<?php echo esc_url( home_url( '/videos' ) ); ?>">الفيديوهات</a></li>
                <li><a href="<?php echo esc_url( home_url( '/gallery' ) ); ?>">المعرض</a></li>
            </ul>
        </li>
        <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">من نحن</a></li>
        <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">اتصل بنا</a></li>
    </ul>
    <?php
}
?>

