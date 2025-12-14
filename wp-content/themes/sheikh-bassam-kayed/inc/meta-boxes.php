<?php
/**
 * Custom Meta Boxes for Custom Post Types
 *
 * @package Sheikh_Bassam_Kayed
 */

// Books Meta Box
function sheikh_bassam_kayed_book_meta_box() {
    add_meta_box(
        'book_details',
        __( 'تفاصيل الكتاب', 'sheikh-bassam-kayed' ),
        'sheikh_bassam_kayed_book_meta_box_callback',
        'book',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sheikh_bassam_kayed_book_meta_box' );

function sheikh_bassam_kayed_book_meta_box_callback( $post ) {
    wp_nonce_field( 'sheikh_bassam_kayed_book_meta_box', 'sheikh_bassam_kayed_book_meta_box_nonce' );
    
    $book_author = get_post_meta( $post->ID, '_book_author', true );
    $book_year = get_post_meta( $post->ID, '_book_year', true );
    $book_pdf = get_post_meta( $post->ID, '_book_pdf', true );
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="book_author"><?php _e( 'المؤلف', 'sheikh-bassam-kayed' ); ?></label></th>
            <td><input type="text" id="book_author" name="book_author" value="<?php echo esc_attr( $book_author ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="book_year"><?php _e( 'سنة النشر', 'sheikh-bassam-kayed' ); ?></label></th>
            <td><input type="number" id="book_year" name="book_year" value="<?php echo esc_attr( $book_year ); ?>" min="1900" max="<?php echo date( 'Y' ); ?>" /></td>
        </tr>
        <tr>
            <th><label for="book_pdf"><?php _e( 'رابط تحميل PDF', 'sheikh-bassam-kayed' ); ?></label></th>
            <td>
                <input type="text" id="book_pdf" name="book_pdf" value="<?php echo esc_url( $book_pdf ); ?>" class="regular-text" />
                <button type="button" class="button" id="book_pdf_upload_btn"><?php _e( 'رفع ملف', 'sheikh-bassam-kayed' ); ?></button>
                <p class="description"><?php _e( 'أدخل رابط ملف PDF أو استخدم زر الرفع', 'sheikh-bassam-kayed' ); ?></p>
            </td>
        </tr>
    </table>
    <script>
    jQuery(document).ready(function($) {
        $('#book_pdf_upload_btn').on('click', function(e) {
            e.preventDefault();
            var file_frame = wp.media({
                title: '<?php _e( 'اختر ملف PDF', 'sheikh-bassam-kayed' ); ?>',
                button: { text: '<?php _e( 'استخدم هذا الملف', 'sheikh-bassam-kayed' ); ?>' },
                multiple: false,
                library: { type: 'application/pdf' }
            });
            file_frame.on('select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();
                $('#book_pdf').val(attachment.url);
            });
            file_frame.open();
        });
    });
    </script>
    <?php
}

function sheikh_bassam_kayed_save_book_meta( $post_id ) {
    if ( ! isset( $_POST['sheikh_bassam_kayed_book_meta_box_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['sheikh_bassam_kayed_book_meta_box_nonce'], 'sheikh_bassam_kayed_book_meta_box' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    if ( isset( $_POST['book_author'] ) ) {
        update_post_meta( $post_id, '_book_author', sanitize_text_field( $_POST['book_author'] ) );
    }
    if ( isset( $_POST['book_year'] ) ) {
        update_post_meta( $post_id, '_book_year', sanitize_text_field( $_POST['book_year'] ) );
    }
    if ( isset( $_POST['book_pdf'] ) ) {
        update_post_meta( $post_id, '_book_pdf', esc_url_raw( $_POST['book_pdf'] ) );
    }
}
add_action( 'save_post_book', 'sheikh_bassam_kayed_save_book_meta' );

// Audio Lecture Meta Box
function sheikh_bassam_kayed_audio_lecture_meta_box() {
    add_meta_box(
        'audio_lecture_details',
        __( 'تفاصيل المحاضرة الصوتية', 'sheikh-bassam-kayed' ),
        'sheikh_bassam_kayed_audio_lecture_meta_box_callback',
        'audio_lecture',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sheikh_bassam_kayed_audio_lecture_meta_box' );

function sheikh_bassam_kayed_audio_lecture_meta_box_callback( $post ) {
    wp_nonce_field( 'sheikh_bassam_kayed_audio_lecture_meta_box', 'sheikh_bassam_kayed_audio_lecture_meta_box_nonce' );
    
    $audio_file = get_post_meta( $post->ID, '_audio_file', true );
    $audio_date = get_post_meta( $post->ID, '_audio_date', true );
    $audio_category = get_post_meta( $post->ID, '_audio_category', true );
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="audio_file"><?php _e( 'ملف الصوت', 'sheikh-bassam-kayed' ); ?></label></th>
            <td>
                <input type="text" id="audio_file" name="audio_file" value="<?php echo esc_url( $audio_file ); ?>" class="regular-text" />
                <button type="button" class="button" id="audio_file_upload_btn"><?php _e( 'رفع ملف', 'sheikh-bassam-kayed' ); ?></button>
                <p class="description"><?php _e( 'رفع ملف صوتي (MP3, WAV, etc.)', 'sheikh-bassam-kayed' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="audio_date"><?php _e( 'تاريخ المحاضرة', 'sheikh-bassam-kayed' ); ?></label></th>
            <td><input type="date" id="audio_date" name="audio_date" value="<?php echo esc_attr( $audio_date ); ?>" /></td>
        </tr>
        <tr>
            <th><label for="audio_category"><?php _e( 'التصنيف', 'sheikh-bassam-kayed' ); ?></label></th>
            <td>
                <input type="text" id="audio_category" name="audio_category" value="<?php echo esc_attr( $audio_category ); ?>" class="regular-text" />
                <p class="description"><?php _e( 'مثال: تفسير، فقه، عقيدة', 'sheikh-bassam-kayed' ); ?></p>
            </td>
        </tr>
    </table>
    <script>
    jQuery(document).ready(function($) {
        $('#audio_file_upload_btn').on('click', function(e) {
            e.preventDefault();
            var file_frame = wp.media({
                title: '<?php _e( 'اختر ملف صوتي', 'sheikh-bassam-kayed' ); ?>',
                button: { text: '<?php _e( 'استخدم هذا الملف', 'sheikh-bassam-kayed' ); ?>' },
                multiple: false,
                library: { type: 'audio' }
            });
            file_frame.on('select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();
                $('#audio_file').val(attachment.url);
            });
            file_frame.open();
        });
    });
    </script>
    <?php
}

function sheikh_bassam_kayed_save_audio_lecture_meta( $post_id ) {
    if ( ! isset( $_POST['sheikh_bassam_kayed_audio_lecture_meta_box_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['sheikh_bassam_kayed_audio_lecture_meta_box_nonce'], 'sheikh_bassam_kayed_audio_lecture_meta_box' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    if ( isset( $_POST['audio_file'] ) ) {
        update_post_meta( $post_id, '_audio_file', esc_url_raw( $_POST['audio_file'] ) );
    }
    if ( isset( $_POST['audio_date'] ) ) {
        update_post_meta( $post_id, '_audio_date', sanitize_text_field( $_POST['audio_date'] ) );
    }
    if ( isset( $_POST['audio_category'] ) ) {
        update_post_meta( $post_id, '_audio_category', sanitize_text_field( $_POST['audio_category'] ) );
    }
}
add_action( 'save_post_audio_lecture', 'sheikh_bassam_kayed_save_audio_lecture_meta' );

// Friday Khutbah Meta Box
function sheikh_bassam_kayed_friday_khutbah_meta_box() {
    add_meta_box(
        'friday_khutbah_details',
        __( 'تفاصيل الخطبة', 'sheikh-bassam-kayed' ),
        'sheikh_bassam_kayed_friday_khutbah_meta_box_callback',
        'friday_khutbah',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sheikh_bassam_kayed_friday_khutbah_meta_box' );

function sheikh_bassam_kayed_friday_khutbah_meta_box_callback( $post ) {
    wp_nonce_field( 'sheikh_bassam_kayed_friday_khutbah_meta_box', 'sheikh_bassam_kayed_friday_khutbah_meta_box_nonce' );
    
    $khutbah_date = get_post_meta( $post->ID, '_khutbah_date', true );
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="khutbah_date"><?php _e( 'تاريخ الخطبة', 'sheikh-bassam-kayed' ); ?></label></th>
            <td><input type="date" id="khutbah_date" name="khutbah_date" value="<?php echo esc_attr( $khutbah_date ); ?>" /></td>
        </tr>
        <tr>
            <td colspan="2">
                <p class="description"><?php _e( 'النص الكامل للخطبة يمكن إضافته في محرر المحتوى أعلاه', 'sheikh-bassam-kayed' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function sheikh_bassam_kayed_save_friday_khutbah_meta( $post_id ) {
    if ( ! isset( $_POST['sheikh_bassam_kayed_friday_khutbah_meta_box_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['sheikh_bassam_kayed_friday_khutbah_meta_box_nonce'], 'sheikh_bassam_kayed_friday_khutbah_meta_box' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    if ( isset( $_POST['khutbah_date'] ) ) {
        update_post_meta( $post_id, '_khutbah_date', sanitize_text_field( $_POST['khutbah_date'] ) );
    }
}
add_action( 'save_post_friday_khutbah', 'sheikh_bassam_kayed_save_friday_khutbah_meta' );

// Video Meta Box
function sheikh_bassam_kayed_video_meta_box() {
    add_meta_box(
        'video_details',
        __( 'تفاصيل الفيديو', 'sheikh-bassam-kayed' ),
        'sheikh_bassam_kayed_video_meta_box_callback',
        'video',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sheikh_bassam_kayed_video_meta_box' );

function sheikh_bassam_kayed_video_meta_box_callback( $post ) {
    wp_nonce_field( 'sheikh_bassam_kayed_video_meta_box', 'sheikh_bassam_kayed_video_meta_box_nonce' );
    
    $video_url = get_post_meta( $post->ID, '_video_url', true );
    $video_file = get_post_meta( $post->ID, '_video_file', true );
    $video_date = get_post_meta( $post->ID, '_video_date', true );
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="video_url"><?php _e( 'رابط الفيديو (YouTube/Vimeo)', 'sheikh-bassam-kayed' ); ?></label></th>
            <td>
                <input type="url" id="video_url" name="video_url" value="<?php echo esc_url( $video_url ); ?>" class="regular-text" />
                <p class="description"><?php _e( 'أدخل رابط YouTube أو Vimeo', 'sheikh-bassam-kayed' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="video_file"><?php _e( 'أو رفع ملف فيديو', 'sheikh-bassam-kayed' ); ?></label></th>
            <td>
                <input type="text" id="video_file" name="video_file" value="<?php echo esc_url( $video_file ); ?>" class="regular-text" />
                <button type="button" class="button" id="video_file_upload_btn"><?php _e( 'رفع ملف', 'sheikh-bassam-kayed' ); ?></button>
                <p class="description"><?php _e( 'استخدم هذا إذا لم يكن لديك رابط YouTube/Vimeo', 'sheikh-bassam-kayed' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="video_date"><?php _e( 'تاريخ الفيديو', 'sheikh-bassam-kayed' ); ?></label></th>
            <td><input type="date" id="video_date" name="video_date" value="<?php echo esc_attr( $video_date ); ?>" /></td>
        </tr>
    </table>
    <script>
    jQuery(document).ready(function($) {
        $('#video_file_upload_btn').on('click', function(e) {
            e.preventDefault();
            var file_frame = wp.media({
                title: '<?php _e( 'اختر ملف فيديو', 'sheikh-bassam-kayed' ); ?>',
                button: { text: '<?php _e( 'استخدم هذا الملف', 'sheikh-bassam-kayed' ); ?>' },
                multiple: false,
                library: { type: 'video' }
            });
            file_frame.on('select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();
                $('#video_file').val(attachment.url);
            });
            file_frame.open();
        });
    });
    </script>
    <?php
}

function sheikh_bassam_kayed_save_video_meta( $post_id ) {
    if ( ! isset( $_POST['sheikh_bassam_kayed_video_meta_box_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['sheikh_bassam_kayed_video_meta_box_nonce'], 'sheikh_bassam_kayed_video_meta_box' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    if ( isset( $_POST['video_url'] ) ) {
        update_post_meta( $post_id, '_video_url', esc_url_raw( $_POST['video_url'] ) );
    }
    if ( isset( $_POST['video_file'] ) ) {
        update_post_meta( $post_id, '_video_file', esc_url_raw( $_POST['video_file'] ) );
    }
    if ( isset( $_POST['video_date'] ) ) {
        update_post_meta( $post_id, '_video_date', sanitize_text_field( $_POST['video_date'] ) );
    }
}
add_action( 'save_post_video', 'sheikh_bassam_kayed_save_video_meta' );

// Gallery Meta Box
function sheikh_bassam_kayed_gallery_meta_box() {
    add_meta_box(
        'gallery_details',
        __( 'تفاصيل الصورة', 'sheikh-bassam-kayed' ),
        'sheikh_bassam_kayed_gallery_meta_box_callback',
        'gallery',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sheikh_bassam_kayed_gallery_meta_box' );

function sheikh_bassam_kayed_gallery_meta_box_callback( $post ) {
    wp_nonce_field( 'sheikh_bassam_kayed_gallery_meta_box', 'sheikh_bassam_kayed_gallery_meta_box_nonce' );
    
    $gallery_images = get_post_meta( $post->ID, '_gallery_images', true );
    $gallery_images = $gallery_images ? explode( ',', $gallery_images ) : array();
    
    ?>
    <table class="form-table">
        <tr>
            <th><label><?php _e( 'الصور', 'sheikh-bassam-kayed' ); ?></label></th>
            <td>
                <div id="gallery_images_container">
                    <?php if ( ! empty( $gallery_images ) ) : ?>
                        <?php foreach ( $gallery_images as $image_id ) : ?>
                            <?php if ( $image_id ) : ?>
                                <div class="gallery-image-item" style="display: inline-block; margin: 5px;">
                                    <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
                                    <input type="hidden" name="gallery_images[]" value="<?php echo esc_attr( $image_id ); ?>" />
                                    <button type="button" class="button remove-gallery-image"><?php _e( 'حذف', 'sheikh-bassam-kayed' ); ?></button>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="button" class="button" id="gallery_images_upload_btn"><?php _e( 'إضافة صور', 'sheikh-bassam-kayed' ); ?></button>
                <p class="description"><?php _e( 'يمكنك إضافة صور متعددة', 'sheikh-bassam-kayed' ); ?></p>
            </td>
        </tr>
    </table>
    <script>
    jQuery(document).ready(function($) {
        $('#gallery_images_upload_btn').on('click', function(e) {
            e.preventDefault();
            var file_frame = wp.media({
                title: '<?php _e( 'اختر الصور', 'sheikh-bassam-kayed' ); ?>',
                button: { text: '<?php _e( 'استخدم هذه الصور', 'sheikh-bassam-kayed' ); ?>' },
                multiple: true,
                library: { type: 'image' }
            });
            file_frame.on('select', function() {
                var attachments = file_frame.state().get('selection').toJSON();
                attachments.forEach(function(attachment) {
                    var imageHtml = '<div class="gallery-image-item" style="display: inline-block; margin: 5px;">' +
                        '<img src="' + attachment.url + '" style="max-width: 150px; height: auto;" />' +
                        '<input type="hidden" name="gallery_images[]" value="' + attachment.id + '" />' +
                        '<button type="button" class="button remove-gallery-image"><?php _e( 'حذف', 'sheikh-bassam-kayed' ); ?></button>' +
                        '</div>';
                    $('#gallery_images_container').append(imageHtml);
                });
            });
            file_frame.open();
        });
        
        $(document).on('click', '.remove-gallery-image', function() {
            $(this).closest('.gallery-image-item').remove();
        });
    });
    </script>
    <?php
}

function sheikh_bassam_kayed_save_gallery_meta( $post_id ) {
    if ( ! isset( $_POST['sheikh_bassam_kayed_gallery_meta_box_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['sheikh_bassam_kayed_gallery_meta_box_nonce'], 'sheikh_bassam_kayed_gallery_meta_box' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    if ( isset( $_POST['gallery_images'] ) && is_array( $_POST['gallery_images'] ) ) {
        $gallery_images = array_map( 'absint', $_POST['gallery_images'] );
        update_post_meta( $post_id, '_gallery_images', implode( ',', $gallery_images ) );
    } else {
        delete_post_meta( $post_id, '_gallery_images' );
    }
}
add_action( 'save_post_gallery', 'sheikh_bassam_kayed_save_gallery_meta' );

