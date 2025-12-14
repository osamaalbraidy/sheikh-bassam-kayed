<?php
/**
 * Dashboard Authentication System
 *
 * @package Sheikh_Bassam_Kayed
 */

// Start session for dashboard authentication
function sheikh_bassam_kayed_start_session() {
    if ( ! session_id() ) {
        session_start();
    }
}
add_action( 'init', 'sheikh_bassam_kayed_start_session' );

// Create custom dashboard user role (only admin can manage)
function sheikh_bassam_kayed_create_dashboard_role() {
    // Get existing users before removing role
    $existing_users = array();
    if ( get_role( 'dashboard_user' ) ) {
        $existing_users = get_users( array( 'role' => 'dashboard_user' ) );
        remove_role( 'dashboard_user' );
    }
    
    add_role(
        'dashboard_user',
        __( 'مستخدم لوحة التحكم', 'sheikh-bassam-kayed' ),
        array(
            'read' => true,
            'upload_files' => true, // Required for media uploader
            'edit_posts' => true, // Required for managing content
            'edit_published_posts' => true,
            'publish_posts' => true,
            'delete_posts' => true,
            'delete_published_posts' => true,
        )
    );
    
    // Re-assign role to existing users (WordPress should handle this automatically, but we'll ensure it)
    foreach ( $existing_users as $user ) {
        $user_obj = new WP_User( $user->ID );
        $user_obj->set_role( 'dashboard_user' );
    }
}
add_action( 'init', 'sheikh_bassam_kayed_create_dashboard_role' );

// Dashboard login handler
function sheikh_bassam_kayed_dashboard_login() {
    if ( isset( $_POST['dashboard_login'] ) && wp_verify_nonce( $_POST['dashboard_login_nonce'], 'dashboard_login_action' ) ) {
        $username = sanitize_text_field( $_POST['dashboard_username'] );
        $password = $_POST['dashboard_password'];
        
        // Check if user exists and has dashboard_user role
        $user = get_user_by( 'login', $username );
        
        if ( $user && wp_check_password( $password, $user->user_pass, $user->ID ) ) {
            $user_roles = $user->roles;
            if ( in_array( 'dashboard_user', $user_roles ) || in_array( 'administrator', $user_roles ) ) {
                $_SESSION['dashboard_authenticated'] = true;
                $_SESSION['dashboard_user_id'] = $user->ID;
                
                // Also log the user into WordPress (required for media uploader AJAX)
                wp_set_current_user( $user->ID );
                wp_set_auth_cookie( $user->ID, true );
                
                wp_safe_redirect( home_url( '/dashboard/hero' ) );
                exit;
            } else {
                $_SESSION['dashboard_error'] = __( 'ليس لديك صلاحية للوصول إلى لوحة التحكم', 'sheikh-bassam-kayed' );
            }
        } else {
            $_SESSION['dashboard_error'] = __( 'اسم المستخدم أو كلمة المرور غير صحيحة', 'sheikh-bassam-kayed' );
        }
    }
}
add_action( 'template_redirect', 'sheikh_bassam_kayed_dashboard_login' );

// Check if user is authenticated
function sheikh_bassam_kayed_is_dashboard_authenticated() {
    return isset( $_SESSION['dashboard_authenticated'] ) && $_SESSION['dashboard_authenticated'] === true;
}

// Dashboard logout
function sheikh_bassam_kayed_dashboard_logout() {
    if ( isset( $_GET['dashboard_logout'] ) ) {
        if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'dashboard_logout' ) ) {
            unset( $_SESSION['dashboard_authenticated'] );
            unset( $_SESSION['dashboard_user_id'] );
            session_destroy();
            
            // Also log out from WordPress
            wp_logout();
            
            wp_safe_redirect( home_url( '/dashboard-login' ) );
            exit;
        }
    }
}
add_action( 'template_redirect', 'sheikh_bassam_kayed_dashboard_logout' );

// Set WordPress user for dashboard sessions (required for media uploader AJAX)
// This filter runs early and allows WordPress to recognize the user for AJAX requests
function sheikh_bassam_kayed_set_dashboard_user_for_wordpress( $user_id ) {
    // If WordPress already determined a user, use that
    if ( $user_id ) {
        return $user_id;
    }
    
    // Otherwise, check if user is authenticated via dashboard session
    if ( sheikh_bassam_kayed_is_dashboard_authenticated() && isset( $_SESSION['dashboard_user_id'] ) ) {
        $dashboard_user_id = intval( $_SESSION['dashboard_user_id'] );
        if ( $dashboard_user_id > 0 ) {
            return $dashboard_user_id;
        }
    }
    
    return $user_id;
}
add_filter( 'determine_current_user', 'sheikh_bassam_kayed_set_dashboard_user_for_wordpress', 20 );

// Protect dashboard pages
function sheikh_bassam_kayed_protect_dashboard() {
    // Skip if already redirected (prevent loops)
    if ( headers_sent() ) {
        return;
    }
    
    // Skip protection for login page
    $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
    if ( strpos( $request_uri, '/dashboard-login' ) !== false ) {
        return;
    }
    
    // Check if it's a dashboard page by checking the queried object
    $current_page = get_queried_object();
    $is_dashboard_page = false;
    
    if ( $current_page && isset( $current_page->post_name ) ) {
        $page_slug = $current_page->post_name;
        if ( $page_slug === 'dashboard' ) {
            $is_dashboard_page = true;
        }
    }
    
    // Also check URL pattern for /dashboard/* routes (from rewrite rules)
    $dashboard_tab = get_query_var( 'dashboard_tab' );
    if ( ! empty( $dashboard_tab ) ) {
        $is_dashboard_page = true;
    } elseif ( preg_match( '/\/dashboard(\/|$)/', $request_uri ) ) {
        $is_dashboard_page = true;
    }
    
    // If it's a dashboard page and user is not authenticated, redirect to login
    if ( $is_dashboard_page && ! sheikh_bassam_kayed_is_dashboard_authenticated() ) {
        // Only redirect if we're not already on the login page (prevent loop)
        if ( strpos( $request_uri, '/dashboard-login' ) === false ) {
            wp_safe_redirect( home_url( '/dashboard-login' ) );
            exit;
        }
    }
}
add_action( 'template_redirect', 'sheikh_bassam_kayed_protect_dashboard', 5 );

// Prevent dashboard users from accessing WordPress admin (they should use custom dashboard)
function sheikh_bassam_kayed_prevent_dashboard_user_admin_access() {
    if ( is_admin() && ! wp_doing_ajax() ) {
        $current_user = wp_get_current_user();
        if ( $current_user && in_array( 'dashboard_user', $current_user->roles ) && ! current_user_can( 'manage_options' ) ) {
            // Redirect to custom dashboard instead
            wp_safe_redirect( home_url( '/dashboard/hero' ) );
            exit;
        }
    }
}
add_action( 'admin_init', 'sheikh_bassam_kayed_prevent_dashboard_user_admin_access', 1 );

// Admin page to create dashboard users
function sheikh_bassam_kayed_add_dashboard_user_admin_page() {
    add_submenu_page(
        'users.php',
        __( 'إدارة مستخدمي لوحة التحكم', 'sheikh-bassam-kayed' ),
        __( 'مستخدمي لوحة التحكم', 'sheikh-bassam-kayed' ),
        'manage_options',
        'dashboard-users',
        'sheikh_bassam_kayed_dashboard_users_page'
    );
}
add_action( 'admin_menu', 'sheikh_bassam_kayed_add_dashboard_user_admin_page' );

// Dashboard users management page
function sheikh_bassam_kayed_dashboard_users_page() {
    // Handle user creation
    if ( isset( $_POST['create_dashboard_user'] ) && wp_verify_nonce( $_POST['create_user_nonce'], 'create_dashboard_user' ) ) {
        $username = sanitize_user( $_POST['new_username'] );
        $email = sanitize_email( $_POST['new_email'] );
        $password = $_POST['new_password'];
        
        if ( username_exists( $username ) ) {
            $message = __( 'اسم المستخدم موجود بالفعل', 'sheikh-bassam-kayed' );
            $message_type = 'error';
        } elseif ( email_exists( $email ) ) {
            $message = __( 'البريد الإلكتروني موجود بالفعل', 'sheikh-bassam-kayed' );
            $message_type = 'error';
        } else {
            $user_id = wp_create_user( $username, $password, $email );
            if ( ! is_wp_error( $user_id ) ) {
                $user = new WP_User( $user_id );
                $user->set_role( 'dashboard_user' );
                $message = __( 'تم إنشاء المستخدم بنجاح', 'sheikh-bassam-kayed' );
                $message_type = 'success';
            } else {
                $message = $user_id->get_error_message();
                $message_type = 'error';
            }
        }
    }
    
    // Handle user deletion
    if ( isset( $_POST['delete_user'] ) && wp_verify_nonce( $_POST['delete_user_nonce'], 'delete_dashboard_user_' . $_POST['user_id'] ) ) {
        $user_id = intval( $_POST['user_id'] );
        if ( $user_id && $user_id != get_current_user_id() ) {
            wp_delete_user( $user_id );
            $message = __( 'تم حذف المستخدم بنجاح', 'sheikh-bassam-kayed' );
            $message_type = 'success';
        }
    }
    
    // Get all dashboard users
    $dashboard_users = get_users( array( 'role' => 'dashboard_user' ) );
    ?>
    <div class="wrap">
        <h1><?php _e( 'إدارة مستخدمي لوحة التحكم', 'sheikh-bassam-kayed' ); ?></h1>
        
        <?php if ( isset( $message ) ) : ?>
            <div class="notice notice-<?php echo esc_attr( $message_type ); ?> is-dismissible">
                <p><?php echo esc_html( $message ); ?></p>
            </div>
        <?php endif; ?>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            <div>
                <h2><?php _e( 'إنشاء مستخدم جديد', 'sheikh-bassam-kayed' ); ?></h2>
                <form method="post">
                    <?php wp_nonce_field( 'create_dashboard_user', 'create_user_nonce' ); ?>
                    <table class="form-table">
                        <tr>
                            <th><label for="new_username"><?php _e( 'اسم المستخدم', 'sheikh-bassam-kayed' ); ?></label></th>
                            <td><input type="text" id="new_username" name="new_username" required class="regular-text" /></td>
                        </tr>
                        <tr>
                            <th><label for="new_email"><?php _e( 'البريد الإلكتروني', 'sheikh-bassam-kayed' ); ?></label></th>
                            <td><input type="email" id="new_email" name="new_email" required class="regular-text" /></td>
                        </tr>
                        <tr>
                            <th><label for="new_password"><?php _e( 'كلمة المرور', 'sheikh-bassam-kayed' ); ?></label></th>
                            <td><input type="password" id="new_password" name="new_password" required class="regular-text" /></td>
                        </tr>
                    </table>
                    <p class="submit">
                        <input type="submit" name="create_dashboard_user" class="button button-primary" value="<?php esc_attr_e( 'إنشاء مستخدم', 'sheikh-bassam-kayed' ); ?>" />
                    </p>
                </form>
            </div>
            
            <div>
                <h2><?php _e( 'المستخدمون الحاليون', 'sheikh-bassam-kayed' ); ?></h2>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php _e( 'اسم المستخدم', 'sheikh-bassam-kayed' ); ?></th>
                            <th><?php _e( 'البريد الإلكتروني', 'sheikh-bassam-kayed' ); ?></th>
                            <th><?php _e( 'الإجراءات', 'sheikh-bassam-kayed' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( empty( $dashboard_users ) ) : ?>
                            <tr>
                                <td colspan="3"><?php _e( 'لا يوجد مستخدمون', 'sheikh-bassam-kayed' ); ?></td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ( $dashboard_users as $user ) : ?>
                                <tr>
                                    <td><?php echo esc_html( $user->user_login ); ?></td>
                                    <td><?php echo esc_html( $user->user_email ); ?></td>
                                    <td>
                                        <form method="post" style="display: inline;" onsubmit="return confirm('<?php esc_attr_e( 'هل أنت متأكد من حذف هذا المستخدم؟', 'sheikh-bassam-kayed' ); ?>');">
                                            <?php wp_nonce_field( 'delete_dashboard_user_' . $user->ID, 'delete_user_nonce' ); ?>
                                            <input type="hidden" name="user_id" value="<?php echo esc_attr( $user->ID ); ?>" />
                                            <input type="submit" name="delete_user" class="button button-small" value="<?php esc_attr_e( 'حذف', 'sheikh-bassam-kayed' ); ?>" />
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
}

