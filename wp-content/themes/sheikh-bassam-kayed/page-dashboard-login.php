<?php
/**
 * Dashboard Login Page Template
 *
 * @package Sheikh_Bassam_Kayed
 */

get_header();

// If already authenticated, redirect to dashboard
if ( isset( $_SESSION['dashboard_authenticated'] ) && $_SESSION['dashboard_authenticated'] === true ) {
    wp_safe_redirect( home_url( '/dashboard' ) );
    exit;
}

$error = isset( $_SESSION['dashboard_error'] ) ? $_SESSION['dashboard_error'] : '';
unset( $_SESSION['dashboard_error'] );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php _e( 'تسجيل الدخول - لوحة التحكم', 'sheikh-bassam-kayed' ); ?></title>
    <?php wp_head(); ?>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #135243 0%, #1B7560 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            direction: rtl;
        }
        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 400px;
            width: 100%;
        }
        .login-container h1 {
            color: #1B7560;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #1B7560;
        }
        .login-button {
            width: 100%;
            padding: 14px;
            background: #1B7560;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .login-button:hover {
            background: #135243;
        }
        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1><?php _e( 'تسجيل الدخول', 'sheikh-bassam-kayed' ); ?></h1>
        
        <?php if ( $error ) : ?>
            <div class="error-message">
                <?php echo esc_html( $error ); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'dashboard_login_action', 'dashboard_login_nonce' ); ?>
            
            <div class="form-group">
                <label for="dashboard_username"><?php _e( 'اسم المستخدم', 'sheikh-bassam-kayed' ); ?></label>
                <input type="text" id="dashboard_username" name="dashboard_username" required autofocus />
            </div>
            
            <div class="form-group">
                <label for="dashboard_password"><?php _e( 'كلمة المرور', 'sheikh-bassam-kayed' ); ?></label>
                <input type="password" id="dashboard_password" name="dashboard_password" required />
            </div>
            
            <button type="submit" name="dashboard_login" class="login-button">
                <?php _e( 'تسجيل الدخول', 'sheikh-bassam-kayed' ); ?>
            </button>
        </form>
    </div>
    <?php wp_footer(); ?>
</body>
</html>

