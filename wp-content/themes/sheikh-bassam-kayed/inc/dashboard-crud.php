<?php
/**
 * Dashboard CRUD Operations for Custom Post Types
 *
 * @package Sheikh_Bassam_Kayed
 */

// Handle CRUD operations
function sheikh_bassam_kayed_handle_dashboard_crud() {
    if ( ! sheikh_bassam_kayed_is_dashboard_authenticated() ) {
        return;
    }
    
    // Create new post
    if ( isset( $_POST['create_post'] ) && wp_verify_nonce( $_POST['create_post_nonce'], 'create_post_action' ) ) {
        $post_type = sanitize_text_field( $_POST['post_type'] );
        $post_title = sanitize_text_field( $_POST['post_title'] );
        $post_content = wp_kses_post( $_POST['post_content'] );
        
        $post_id = wp_insert_post( array(
            'post_title'   => $post_title,
            'post_content' => $post_content,
            'post_status'  => 'publish',
            'post_type'    => $post_type,
        ) );
        
        if ( $post_id && ! is_wp_error( $post_id ) ) {
            // Handle custom fields based on post type
            sheikh_bassam_kayed_save_post_meta( $post_id, $post_type );
            
            // Handle featured image
            if ( ! empty( $_POST['featured_image_url'] ) ) {
                $image_url = esc_url_raw( $_POST['featured_image_url'] );
                sheikh_bassam_kayed_set_featured_image_from_url( $post_id, $image_url );
            }
            
            $_SESSION['dashboard_success'] = __( 'تم إنشاء العنصر بنجاح', 'sheikh-bassam-kayed' );
        } else {
            $_SESSION['dashboard_error'] = __( 'حدث خطأ أثناء إنشاء العنصر', 'sheikh-bassam-kayed' );
        }
        
        // Map post types to dashboard tabs
        $post_type_to_tab = array(
            'book' => 'books',
            'audio_lecture' => 'audio',
            'friday_khutbah' => 'khutbahs',
            'video' => 'videos',
            'gallery' => 'gallery'
        );
        $tab = isset( $post_type_to_tab[ $post_type ] ) ? $post_type_to_tab[ $post_type ] : $post_type;
        wp_safe_redirect( home_url( '/dashboard/' . $tab ) );
        exit;
    }
    
    // Update existing post
    if ( isset( $_POST['update_post'] ) && wp_verify_nonce( $_POST['update_post_nonce'], 'update_post_' . $_POST['post_id'] ) ) {
        $post_id = intval( $_POST['post_id'] );
        $post_title = sanitize_text_field( $_POST['post_title'] );
        $post_content = wp_kses_post( $_POST['post_content'] );
        
        wp_update_post( array(
            'ID'           => $post_id,
            'post_title'   => $post_title,
            'post_content' => $post_content,
        ) );
        
        // Handle custom fields
        $post = get_post( $post_id );
        if ( $post ) {
            sheikh_bassam_kayed_save_post_meta( $post_id, $post->post_type );
        }
        
        // Handle featured image
        if ( ! empty( $_POST['featured_image_url'] ) ) {
            $image_url = esc_url_raw( $_POST['featured_image_url'] );
            sheikh_bassam_kayed_set_featured_image_from_url( $post_id, $image_url );
        }
        
        $_SESSION['dashboard_success'] = __( 'تم تحديث العنصر بنجاح', 'sheikh-bassam-kayed' );
        // Map post types to dashboard tabs
        $post_type_to_tab = array(
            'book' => 'books',
            'audio_lecture' => 'audio',
            'friday_khutbah' => 'khutbahs',
            'video' => 'videos',
            'gallery' => 'gallery'
        );
        $tab = isset( $post_type_to_tab[ $post->post_type ] ) ? $post_type_to_tab[ $post->post_type ] : $post->post_type;
        wp_safe_redirect( home_url( '/dashboard/' . $tab ) );
        exit;
    }
    
    // Delete post
    if ( isset( $_GET['delete_post'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'delete_post_' . $_GET['delete_post'] ) ) {
        $post_id = intval( $_GET['delete_post'] );
        $post = get_post( $post_id );
        
        if ( $post && wp_delete_post( $post_id, true ) ) {
            $_SESSION['dashboard_success'] = __( 'تم حذف العنصر بنجاح', 'sheikh-bassam-kayed' );
        } else {
            $_SESSION['dashboard_error'] = __( 'حدث خطأ أثناء حذف العنصر', 'sheikh-bassam-kayed' );
        }
        
        // Map post types to dashboard tabs
        $post_type_to_tab = array(
            'book' => 'books',
            'audio_lecture' => 'audio',
            'friday_khutbah' => 'khutbahs',
            'video' => 'videos',
            'gallery' => 'gallery'
        );
        $tab = isset( $post_type_to_tab[ $post->post_type ] ) ? $post_type_to_tab[ $post->post_type ] : $post->post_type;
        wp_safe_redirect( home_url( '/dashboard/' . $tab ) );
        exit;
    }
}
add_action( 'template_redirect', 'sheikh_bassam_kayed_handle_dashboard_crud' );

// Save post meta based on post type
function sheikh_bassam_kayed_save_post_meta( $post_id, $post_type ) {
    switch ( $post_type ) {
        case 'book':
            if ( isset( $_POST['book_author'] ) ) {
                update_post_meta( $post_id, '_book_author', sanitize_text_field( $_POST['book_author'] ) );
            }
            if ( isset( $_POST['book_year'] ) ) {
                update_post_meta( $post_id, '_book_year', sanitize_text_field( $_POST['book_year'] ) );
            }
            if ( isset( $_POST['book_pdf'] ) ) {
                update_post_meta( $post_id, '_book_pdf', esc_url_raw( $_POST['book_pdf'] ) );
            }
            break;
            
        case 'audio_lecture':
            if ( isset( $_POST['audio_file'] ) ) {
                update_post_meta( $post_id, '_audio_file', esc_url_raw( $_POST['audio_file'] ) );
            }
            if ( isset( $_POST['audio_date'] ) ) {
                update_post_meta( $post_id, '_audio_date', sanitize_text_field( $_POST['audio_date'] ) );
            }
            break;
            
        case 'friday_khutbah':
            if ( isset( $_POST['khutbah_date'] ) ) {
                update_post_meta( $post_id, '_khutbah_date', sanitize_text_field( $_POST['khutbah_date'] ) );
            }
            break;
            
        case 'video':
            if ( isset( $_POST['video_url'] ) ) {
                update_post_meta( $post_id, '_video_url', esc_url_raw( $_POST['video_url'] ) );
            }
            if ( isset( $_POST['video_file'] ) ) {
                update_post_meta( $post_id, '_video_file', esc_url_raw( $_POST['video_file'] ) );
            }
            if ( isset( $_POST['video_date'] ) ) {
                update_post_meta( $post_id, '_video_date', sanitize_text_field( $_POST['video_date'] ) );
            }
            break;
            
        case 'gallery':
            if ( isset( $_POST['gallery_images_text'] ) ) {
                $images_text = sanitize_textarea_field( $_POST['gallery_images_text'] );
                $images = array_filter( array_map( 'trim', explode( "\n", $images_text ) ) );
                $images = array_map( 'esc_url_raw', $images );
                update_post_meta( $post_id, '_gallery_images', $images );
            }
            break;
    }
}

// Set featured image from URL
function sheikh_bassam_kayed_set_featured_image_from_url( $post_id, $image_url ) {
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );
    
    // Check if image is already in media library
    $attachment_id = attachment_url_to_postid( $image_url );
    
    if ( ! $attachment_id ) {
        // Download image to media library
        $tmp = download_url( $image_url );
        if ( is_wp_error( $tmp ) ) {
            return false;
        }
        
        $file_array = array(
            'name'     => basename( $image_url ),
            'tmp_name' => $tmp
        );
        
        $attachment_id = media_handle_sideload( $file_array, $post_id );
        
        if ( is_wp_error( $attachment_id ) ) {
            @unlink( $file_array['tmp_name'] );
            return false;
        }
    }
    
    set_post_thumbnail( $post_id, $attachment_id );
    return true;
}

// Get posts for dashboard listing
function sheikh_bassam_kayed_get_dashboard_posts( $post_type, $posts_per_page = 20 ) {
    return get_posts( array(
        'post_type'      => $post_type,
        'posts_per_page' => $posts_per_page,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    ) );
}

