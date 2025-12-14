<?php
/**
 * Dashboard CRUD Tabs for Custom Post Types
 *
 * @package Sheikh_Bassam_Kayed
 */

// Get active tab from parent page-dashboard.php (already set there)
// This file is included, so we use the same variables
$editing_post_id = isset( $_GET['edit'] ) ? intval( $_GET['edit'] ) : 0;
$editing_post = $editing_post_id ? get_post( $editing_post_id ) : null;

// Books Tab
?>
<!-- Books Tab -->
<div class="tab-content <?php echo $active_tab === 'books' ? 'active' : ''; ?>" id="books-tab">
    <div class="form-section">
        <div class="section-header">
            <h3><?php _e( 'إدارة الكتب', 'sheikh-bassam-kayed' ); ?></h3>
            <button type="button" class="add-new-button" data-form="books-form" data-tab="books">
                <?php _e( 'إضافة كتاب جديد', 'sheikh-bassam-kayed' ); ?> ➕
            </button>
        </div>
        
        <!-- Collapsible Form -->
        <div class="crud-form-wrapper <?php echo ( $editing_post && $editing_post->post_type === 'book' ) ? 'show' : ''; ?>" id="books-form">
            <div class="form-header">
                <?php if ( $editing_post && $editing_post->post_type === 'book' ) : ?>
                    <h4><?php _e( 'تعديل كتاب', 'sheikh-bassam-kayed' ); ?></h4>
                <?php else : ?>
                    <h4><?php _e( 'إضافة كتاب جديد', 'sheikh-bassam-kayed' ); ?></h4>
                <?php endif; ?>
                <button type="button" class="close-form-button" data-form="books-form">✕</button>
            </div>
            
            <form method="post" class="crud-form">
            <?php wp_nonce_field( $editing_post ? 'update_post_' . $editing_post_id : 'create_post_action', $editing_post ? 'update_post_nonce' : 'create_post_nonce' ); ?>
            <input type="hidden" name="post_type" value="book" />
            <?php if ( $editing_post ) : ?>
                <input type="hidden" name="post_id" value="<?php echo esc_attr( $editing_post_id ); ?>" />
            <?php endif; ?>
            
            <div class="form-group">
                <label><?php _e( 'عنوان الكتاب', 'sheikh-bassam-kayed' ); ?> *</label>
                <input type="text" name="post_title" value="<?php echo $editing_post ? esc_attr( $editing_post->post_title ) : ''; ?>" required />
            </div>
            
            <div class="form-group">
                <label><?php _e( 'الوصف', 'sheikh-bassam-kayed' ); ?></label>
                <textarea name="post_content"><?php echo $editing_post ? esc_textarea( $editing_post->post_content ) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label><?php _e( 'صورة الغلاف', 'sheikh-bassam-kayed' ); ?></label>
                <div class="image-upload-wrapper">
                    <div class="image-upload-input-wrapper">
                        <input type="url" id="book_featured_image" name="featured_image_url" value="<?php echo $editing_post ? esc_url( get_the_post_thumbnail_url( $editing_post_id, 'full' ) ) : ''; ?>" placeholder="https://..." />
                        <button type="button" class="image-upload-button" data-target="book_featured_image"><?php _e( 'رفع صورة', 'sheikh-bassam-kayed' ); ?></button>
                    </div>
                    <img src="<?php echo $editing_post ? esc_url( get_the_post_thumbnail_url( $editing_post_id, 'full' ) ) : ''; ?>" class="image-preview <?php echo ( $editing_post && get_the_post_thumbnail_url( $editing_post_id ) ) ? '' : 'hidden'; ?>" id="book_featured_image_preview" />
                </div>
            </div>
            
            <div class="form-group">
                <label><?php _e( 'المؤلف', 'sheikh-bassam-kayed' ); ?></label>
                <input type="text" name="book_author" value="<?php echo $editing_post ? esc_attr( get_post_meta( $editing_post_id, '_book_author', true ) ) : ''; ?>" />
            </div>
            
            <div class="form-group">
                <label><?php _e( 'سنة النشر', 'sheikh-bassam-kayed' ); ?></label>
                <input type="number" name="book_year" value="<?php echo $editing_post ? esc_attr( get_post_meta( $editing_post_id, '_book_year', true ) ) : ''; ?>" min="1900" max="<?php echo date( 'Y' ); ?>" />
            </div>
            
            <div class="form-group">
                <label><?php _e( 'رابط تحميل PDF', 'sheikh-bassam-kayed' ); ?></label>
                <div class="image-upload-input-wrapper">
                    <input type="url" id="book_pdf" name="book_pdf" value="<?php echo $editing_post ? esc_url( get_post_meta( $editing_post_id, '_book_pdf', true ) ) : ''; ?>" placeholder="https://..." style="flex: 1;" />
                    <button type="button" class="file-upload-button" data-target="book_pdf" data-type="application/pdf"><?php _e( 'رفع ملف PDF', 'sheikh-bassam-kayed' ); ?></button>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" name="<?php echo $editing_post ? 'update_post' : 'create_post'; ?>" class="submit-button">
                    <?php echo $editing_post ? __( 'تحديث الكتاب', 'sheikh-bassam-kayed' ) : __( 'إضافة كتاب', 'sheikh-bassam-kayed' ); ?>
                </button>
                <button type="button" class="cancel-form-button" data-form="books-form" data-tab="books">
                    <?php _e( 'إلغاء', 'sheikh-bassam-kayed' ); ?>
                </button>
            </div>
            </form>
        </div>
        
        <!-- Data List -->
        <div class="data-list-section">
            <h4><?php _e( 'الكتب الموجودة', 'sheikh-bassam-kayed' ); ?></h4>
        <?php
        $books = sheikh_bassam_kayed_get_dashboard_posts( 'book' );
        if ( $books ) :
            ?>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th><?php _e( 'العنوان', 'sheikh-bassam-kayed' ); ?></th>
                        <th><?php _e( 'المؤلف', 'sheikh-bassam-kayed' ); ?></th>
                        <th><?php _e( 'سنة النشر', 'sheikh-bassam-kayed' ); ?></th>
                        <th><?php _e( 'الإجراءات', 'sheikh-bassam-kayed' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $books as $book ) : ?>
                        <tr>
                            <td><?php echo esc_html( $book->post_title ); ?></td>
                            <td><?php echo esc_html( get_post_meta( $book->ID, '_book_author', true ) ); ?></td>
                            <td><?php echo esc_html( get_post_meta( $book->ID, '_book_year', true ) ); ?></td>
                            <td>
                                <a href="<?php echo esc_url( home_url( '/dashboard/books?edit=' . $book->ID ) ); ?>"><?php _e( 'تعديل', 'sheikh-bassam-kayed' ); ?></a>
                                <a href="<?php echo esc_url( wp_nonce_url( home_url( '/dashboard/books?delete_post=' . $book->ID ), 'delete_post_' . $book->ID ) ); ?>" 
                                   onclick="return confirm('<?php esc_attr_e( 'هل أنت متأكد من حذف هذا الكتاب؟', 'sheikh-bassam-kayed' ); ?>');"
                                   class="delete-link"><?php _e( 'حذف', 'sheikh-bassam-kayed' ); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="empty-state">
                <p><?php _e( 'لا توجد كتب بعد', 'sheikh-bassam-kayed' ); ?></p>
                <button type="button" class="add-new-button" data-form="books-form" data-tab="books">
                    <?php _e( 'إضافة أول كتاب', 'sheikh-bassam-kayed' ); ?>
                </button>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>

<!-- Audio Lectures Tab -->
<div class="tab-content <?php echo $active_tab === 'audio' ? 'active' : ''; ?>" id="audio-tab">
    <div class="form-section">
        <div class="section-header">
            <h3><?php _e( 'إدارة المحاضرات الصوتية', 'sheikh-bassam-kayed' ); ?></h3>
            <button type="button" class="add-new-button" data-form="audio-form" data-tab="audio">
                <?php _e( 'إضافة محاضرة جديدة', 'sheikh-bassam-kayed' ); ?> ➕
            </button>
        </div>
        
        <!-- Collapsible Form -->
        <div class="crud-form-wrapper <?php echo ( $editing_post && $editing_post->post_type === 'audio_lecture' ) ? 'show' : ''; ?>" id="audio-form">
            <div class="form-header">
                <?php if ( $editing_post && $editing_post->post_type === 'audio_lecture' ) : ?>
                    <h4><?php _e( 'تعديل محاضرة صوتية', 'sheikh-bassam-kayed' ); ?></h4>
                <?php else : ?>
                    <h4><?php _e( 'إضافة محاضرة صوتية جديدة', 'sheikh-bassam-kayed' ); ?></h4>
                <?php endif; ?>
                <button type="button" class="close-form-button" data-form="audio-form">✕</button>
            </div>
            
            <form method="post" class="crud-form">
            <?php wp_nonce_field( $editing_post ? 'update_post_' . $editing_post_id : 'create_post_action', $editing_post ? 'update_post_nonce' : 'create_post_nonce' ); ?>
            <input type="hidden" name="post_type" value="audio_lecture" />
            <?php if ( $editing_post ) : ?>
                <input type="hidden" name="post_id" value="<?php echo esc_attr( $editing_post_id ); ?>" />
            <?php endif; ?>
            
            <div class="form-group">
                <label><?php _e( 'عنوان المحاضرة', 'sheikh-bassam-kayed' ); ?> *</label>
                <input type="text" name="post_title" value="<?php echo $editing_post ? esc_attr( $editing_post->post_title ) : ''; ?>" required />
            </div>
            
            <div class="form-group">
                <label><?php _e( 'الوصف', 'sheikh-bassam-kayed' ); ?></label>
                <textarea name="post_content"><?php echo $editing_post ? esc_textarea( $editing_post->post_content ) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label><?php _e( 'ملف الصوت', 'sheikh-bassam-kayed' ); ?></label>
                <div class="image-upload-input-wrapper">
                    <input type="url" id="audio_file" name="audio_file" value="<?php echo $editing_post ? esc_url( get_post_meta( $editing_post_id, '_audio_file', true ) ) : ''; ?>" placeholder="https://..." style="flex: 1;" />
                    <button type="button" class="file-upload-button" data-target="audio_file" data-type="audio"><?php _e( 'رفع ملف صوتي', 'sheikh-bassam-kayed' ); ?></button>
                </div>
            </div>
            
            <div class="form-group">
                <label><?php _e( 'تاريخ المحاضرة', 'sheikh-bassam-kayed' ); ?></label>
                <input type="date" name="audio_date" value="<?php echo $editing_post ? esc_attr( get_post_meta( $editing_post_id, '_audio_date', true ) ) : ''; ?>" />
            </div>
            
            <div class="form-actions">
                <button type="submit" name="<?php echo $editing_post ? 'update_post' : 'create_post'; ?>" class="submit-button">
                    <?php echo $editing_post ? __( 'تحديث المحاضرة', 'sheikh-bassam-kayed' ) : __( 'إضافة محاضرة', 'sheikh-bassam-kayed' ); ?>
                </button>
                <button type="button" class="cancel-form-button" data-form="audio-form" data-tab="audio">
                    <?php _e( 'إلغاء', 'sheikh-bassam-kayed' ); ?>
                </button>
            </div>
            </form>
        </div>
        
        <!-- Data List -->
        <div class="data-list-section">
            <h4><?php _e( 'المحاضرات الموجودة', 'sheikh-bassam-kayed' ); ?></h4>
        <?php
        $audio_lectures = sheikh_bassam_kayed_get_dashboard_posts( 'audio_lecture' );
        if ( $audio_lectures ) :
            ?>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th><?php _e( 'العنوان', 'sheikh-bassam-kayed' ); ?></th>
                        <th><?php _e( 'التاريخ', 'sheikh-bassam-kayed' ); ?></th>
                        <th><?php _e( 'الإجراءات', 'sheikh-bassam-kayed' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $audio_lectures as $lecture ) : ?>
                        <tr>
                            <td><?php echo esc_html( $lecture->post_title ); ?></td>
                            <td><?php echo esc_html( get_post_meta( $lecture->ID, '_audio_date', true ) ); ?></td>
                            <td>
                                <a href="<?php echo esc_url( home_url( '/dashboard/audio?edit=' . $lecture->ID ) ); ?>"><?php _e( 'تعديل', 'sheikh-bassam-kayed' ); ?></a>
                                <a href="<?php echo esc_url( wp_nonce_url( home_url( '/dashboard/audio?delete_post=' . $lecture->ID ), 'delete_post_' . $lecture->ID ) ); ?>" 
                                   onclick="return confirm('<?php esc_attr_e( 'هل أنت متأكد من حذف هذه المحاضرة؟', 'sheikh-bassam-kayed' ); ?>');"
                                   class="delete-link"><?php _e( 'حذف', 'sheikh-bassam-kayed' ); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="empty-state">
                <p><?php _e( 'لا توجد محاضرات صوتية بعد', 'sheikh-bassam-kayed' ); ?></p>
                <button type="button" class="add-new-button" data-form="audio-form" data-tab="audio">
                    <?php _e( 'إضافة أول محاضرة', 'sheikh-bassam-kayed' ); ?>
                </button>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>

<!-- Friday Khutbahs Tab -->
<div class="tab-content <?php echo $active_tab === 'khutbahs' ? 'active' : ''; ?>" id="khutbahs-tab">
    <div class="form-section">
        <div class="section-header">
            <h3><?php _e( 'إدارة خطب الجمعة', 'sheikh-bassam-kayed' ); ?></h3>
            <button type="button" class="add-new-button" data-form="khutbahs-form" data-tab="khutbahs">
                <?php _e( 'إضافة خطبة جديدة', 'sheikh-bassam-kayed' ); ?> ➕
            </button>
        </div>
        
        <!-- Collapsible Form -->
        <div class="crud-form-wrapper <?php echo ( $editing_post && $editing_post->post_type === 'friday_khutbah' ) ? 'show' : ''; ?>" id="khutbahs-form">
            <div class="form-header">
                <?php if ( $editing_post && $editing_post->post_type === 'friday_khutbah' ) : ?>
                    <h4><?php _e( 'تعديل خطبة', 'sheikh-bassam-kayed' ); ?></h4>
                <?php else : ?>
                    <h4><?php _e( 'إضافة خطبة جديدة', 'sheikh-bassam-kayed' ); ?></h4>
                <?php endif; ?>
                <button type="button" class="close-form-button" data-form="khutbahs-form">✕</button>
            </div>
            
            <form method="post" class="crud-form">
            <?php wp_nonce_field( $editing_post ? 'update_post_' . $editing_post_id : 'create_post_action', $editing_post ? 'update_post_nonce' : 'create_post_nonce' ); ?>
            <input type="hidden" name="post_type" value="friday_khutbah" />
            <?php if ( $editing_post ) : ?>
                <input type="hidden" name="post_id" value="<?php echo esc_attr( $editing_post_id ); ?>" />
            <?php endif; ?>
            
            <div class="form-group">
                <label><?php _e( 'عنوان الخطبة', 'sheikh-bassam-kayed' ); ?> *</label>
                <input type="text" name="post_title" value="<?php echo $editing_post ? esc_attr( $editing_post->post_title ) : ''; ?>" required />
            </div>
            
            <div class="form-group">
                <label><?php _e( 'نص الخطبة', 'sheikh-bassam-kayed' ); ?> *</label>
                <textarea name="post_content" style="min-height: 300px;" required><?php echo $editing_post ? esc_textarea( $editing_post->post_content ) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label><?php _e( 'تاريخ الخطبة', 'sheikh-bassam-kayed' ); ?></label>
                <input type="date" name="khutbah_date" value="<?php echo $editing_post ? esc_attr( get_post_meta( $editing_post_id, '_khutbah_date', true ) ) : ''; ?>" />
            </div>
            
            <div class="form-actions">
                <button type="submit" name="<?php echo $editing_post ? 'update_post' : 'create_post'; ?>" class="submit-button">
                    <?php echo $editing_post ? __( 'تحديث الخطبة', 'sheikh-bassam-kayed' ) : __( 'إضافة خطبة', 'sheikh-bassam-kayed' ); ?>
                </button>
                <button type="button" class="cancel-form-button" data-form="khutbahs-form" data-tab="khutbahs">
                    <?php _e( 'إلغاء', 'sheikh-bassam-kayed' ); ?>
                </button>
            </div>
            </form>
        </div>
        
        <!-- Data List -->
        <div class="data-list-section">
            <h4><?php _e( 'الخطب الموجودة', 'sheikh-bassam-kayed' ); ?></h4>
        <?php
        $khutbahs = sheikh_bassam_kayed_get_dashboard_posts( 'friday_khutbah' );
        if ( $khutbahs ) :
            ?>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th><?php _e( 'العنوان', 'sheikh-bassam-kayed' ); ?></th>
                        <th><?php _e( 'التاريخ', 'sheikh-bassam-kayed' ); ?></th>
                        <th><?php _e( 'الإجراءات', 'sheikh-bassam-kayed' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $khutbahs as $khutbah ) : ?>
                        <tr>
                            <td><?php echo esc_html( $khutbah->post_title ); ?></td>
                            <td><?php echo esc_html( get_post_meta( $khutbah->ID, '_khutbah_date', true ) ); ?></td>
                            <td>
                                <a href="<?php echo esc_url( home_url( '/dashboard/khutbahs?edit=' . $khutbah->ID ) ); ?>"><?php _e( 'تعديل', 'sheikh-bassam-kayed' ); ?></a>
                                <a href="<?php echo esc_url( wp_nonce_url( home_url( '/dashboard/khutbahs?delete_post=' . $khutbah->ID ), 'delete_post_' . $khutbah->ID ) ); ?>" 
                                   onclick="return confirm('<?php esc_attr_e( 'هل أنت متأكد من حذف هذه الخطبة؟', 'sheikh-bassam-kayed' ); ?>');"
                                   class="delete-link"><?php _e( 'حذف', 'sheikh-bassam-kayed' ); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="empty-state">
                <p><?php _e( 'لا توجد خطب بعد', 'sheikh-bassam-kayed' ); ?></p>
                <button type="button" class="add-new-button" data-form="khutbahs-form" data-tab="khutbahs">
                    <?php _e( 'إضافة أول خطبة', 'sheikh-bassam-kayed' ); ?>
                </button>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>

<!-- Videos Tab -->
<div class="tab-content <?php echo $active_tab === 'videos' ? 'active' : ''; ?>" id="videos-tab">
    <div class="form-section">
        <div class="section-header">
            <h3><?php _e( 'إدارة الفيديوهات', 'sheikh-bassam-kayed' ); ?></h3>
            <button type="button" class="add-new-button" data-form="videos-form" data-tab="videos">
                <?php _e( 'إضافة فيديو جديد', 'sheikh-bassam-kayed' ); ?> ➕
            </button>
        </div>
        
        <!-- Collapsible Form -->
        <div class="crud-form-wrapper <?php echo ( $editing_post && $editing_post->post_type === 'video' ) ? 'show' : ''; ?>" id="videos-form">
            <div class="form-header">
                <?php if ( $editing_post && $editing_post->post_type === 'video' ) : ?>
                    <h4><?php _e( 'تعديل فيديو', 'sheikh-bassam-kayed' ); ?></h4>
                <?php else : ?>
                    <h4><?php _e( 'إضافة فيديو جديد', 'sheikh-bassam-kayed' ); ?></h4>
                <?php endif; ?>
                <button type="button" class="close-form-button" data-form="videos-form">✕</button>
            </div>
            
            <form method="post" class="crud-form">
            <?php wp_nonce_field( $editing_post ? 'update_post_' . $editing_post_id : 'create_post_action', $editing_post ? 'update_post_nonce' : 'create_post_nonce' ); ?>
            <input type="hidden" name="post_type" value="video" />
            <?php if ( $editing_post ) : ?>
                <input type="hidden" name="post_id" value="<?php echo esc_attr( $editing_post_id ); ?>" />
            <?php endif; ?>
            
            <div class="form-group">
                <label><?php _e( 'عنوان الفيديو', 'sheikh-bassam-kayed' ); ?> *</label>
                <input type="text" name="post_title" value="<?php echo $editing_post ? esc_attr( $editing_post->post_title ) : ''; ?>" required />
            </div>
            
            <div class="form-group">
                <label><?php _e( 'الوصف', 'sheikh-bassam-kayed' ); ?></label>
                <textarea name="post_content"><?php echo $editing_post ? esc_textarea( $editing_post->post_content ) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label><?php _e( 'صورة المعاينة', 'sheikh-bassam-kayed' ); ?></label>
                <div class="image-upload-wrapper">
                    <div class="image-upload-input-wrapper">
                        <input type="url" id="video_featured_image" name="featured_image_url" value="<?php echo $editing_post ? esc_url( get_the_post_thumbnail_url( $editing_post_id, 'full' ) ) : ''; ?>" placeholder="https://..." />
                        <button type="button" class="image-upload-button" data-target="video_featured_image"><?php _e( 'رفع صورة', 'sheikh-bassam-kayed' ); ?></button>
                    </div>
                    <img src="<?php echo $editing_post ? esc_url( get_the_post_thumbnail_url( $editing_post_id, 'full' ) ) : ''; ?>" class="image-preview <?php echo ( $editing_post && get_the_post_thumbnail_url( $editing_post_id ) ) ? '' : 'hidden'; ?>" id="video_featured_image_preview" />
                </div>
            </div>
            
            <div class="form-group">
                <label><?php _e( 'رابط الفيديو (YouTube/Vimeo)', 'sheikh-bassam-kayed' ); ?></label>
                <input type="url" name="video_url" value="<?php echo $editing_post ? esc_url( get_post_meta( $editing_post_id, '_video_url', true ) ) : ''; ?>" placeholder="https://youtube.com/watch?v=..." />
            </div>
            
            <div class="form-group">
                <label><?php _e( 'أو ملف فيديو', 'sheikh-bassam-kayed' ); ?></label>
                <div class="image-upload-input-wrapper">
                    <input type="url" id="video_file" name="video_file" value="<?php echo $editing_post ? esc_url( get_post_meta( $editing_post_id, '_video_file', true ) ) : ''; ?>" placeholder="https://..." style="flex: 1;" />
                    <button type="button" class="file-upload-button" data-target="video_file" data-type="video"><?php _e( 'رفع ملف فيديو', 'sheikh-bassam-kayed' ); ?></button>
                </div>
            </div>
            
            <div class="form-group">
                <label><?php _e( 'تاريخ الفيديو', 'sheikh-bassam-kayed' ); ?></label>
                <input type="date" name="video_date" value="<?php echo $editing_post ? esc_attr( get_post_meta( $editing_post_id, '_video_date', true ) ) : ''; ?>" />
            </div>
            
            <div class="form-actions">
                <button type="submit" name="<?php echo $editing_post ? 'update_post' : 'create_post'; ?>" class="submit-button">
                    <?php echo $editing_post ? __( 'تحديث الفيديو', 'sheikh-bassam-kayed' ) : __( 'إضافة فيديو', 'sheikh-bassam-kayed' ); ?>
                </button>
                <button type="button" class="cancel-form-button" data-form="videos-form" data-tab="videos">
                    <?php _e( 'إلغاء', 'sheikh-bassam-kayed' ); ?>
                </button>
            </div>
            </form>
        </div>
        
        <!-- Data List -->
        <div class="data-list-section">
            <h4><?php _e( 'الفيديوهات الموجودة', 'sheikh-bassam-kayed' ); ?></h4>
        <?php
        $videos = sheikh_bassam_kayed_get_dashboard_posts( 'video' );
        if ( $videos ) :
            ?>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th><?php _e( 'العنوان', 'sheikh-bassam-kayed' ); ?></th>
                        <th><?php _e( 'التاريخ', 'sheikh-bassam-kayed' ); ?></th>
                        <th><?php _e( 'الإجراءات', 'sheikh-bassam-kayed' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $videos as $video ) : ?>
                        <tr>
                            <td><?php echo esc_html( $video->post_title ); ?></td>
                            <td><?php echo esc_html( get_post_meta( $video->ID, '_video_date', true ) ); ?></td>
                            <td>
                                <a href="<?php echo esc_url( home_url( '/dashboard/videos?edit=' . $video->ID ) ); ?>"><?php _e( 'تعديل', 'sheikh-bassam-kayed' ); ?></a>
                                <a href="<?php echo esc_url( wp_nonce_url( home_url( '/dashboard/videos?delete_post=' . $video->ID ), 'delete_post_' . $video->ID ) ); ?>" 
                                   onclick="return confirm('<?php esc_attr_e( 'هل أنت متأكد من حذف هذا الفيديو؟', 'sheikh-bassam-kayed' ); ?>');"
                                   class="delete-link"><?php _e( 'حذف', 'sheikh-bassam-kayed' ); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="empty-state">
                <p><?php _e( 'لا توجد فيديوهات بعد', 'sheikh-bassam-kayed' ); ?></p>
                <button type="button" class="add-new-button" data-form="videos-form" data-tab="videos">
                    <?php _e( 'إضافة أول فيديو', 'sheikh-bassam-kayed' ); ?>
                </button>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>

<!-- Gallery Tab -->
<div class="tab-content <?php echo $active_tab === 'gallery' ? 'active' : ''; ?>" id="gallery-tab">
    <div class="form-section">
        <div class="section-header">
            <h3><?php _e( 'إدارة المعرض', 'sheikh-bassam-kayed' ); ?></h3>
            <button type="button" class="add-new-button" data-form="gallery-form" data-tab="gallery">
                <?php _e( 'إضافة صورة جديدة', 'sheikh-bassam-kayed' ); ?> ➕
            </button>
        </div>
        
        <!-- Collapsible Form -->
        <div class="crud-form-wrapper <?php echo ( $editing_post && $editing_post->post_type === 'gallery' ) ? 'show' : ''; ?>" id="gallery-form">
            <div class="form-header">
                <?php if ( $editing_post && $editing_post->post_type === 'gallery' ) : ?>
                    <h4><?php _e( 'تعديل صورة', 'sheikh-bassam-kayed' ); ?></h4>
                <?php else : ?>
                    <h4><?php _e( 'إضافة صورة جديدة', 'sheikh-bassam-kayed' ); ?></h4>
                <?php endif; ?>
                <button type="button" class="close-form-button" data-form="gallery-form">✕</button>
            </div>
            
            <form method="post" class="crud-form">
            <?php wp_nonce_field( $editing_post ? 'update_post_' . $editing_post_id : 'create_post_action', $editing_post ? 'update_post_nonce' : 'create_post_nonce' ); ?>
            <input type="hidden" name="post_type" value="gallery" />
            <?php if ( $editing_post ) : ?>
                <input type="hidden" name="post_id" value="<?php echo esc_attr( $editing_post_id ); ?>" />
            <?php endif; ?>
            
            <div class="form-group">
                <label><?php _e( 'عنوان الصورة', 'sheikh-bassam-kayed' ); ?> *</label>
                <input type="text" name="post_title" value="<?php echo $editing_post ? esc_attr( $editing_post->post_title ) : ''; ?>" required />
            </div>
            
            <div class="form-group">
                <label><?php _e( 'الوصف', 'sheikh-bassam-kayed' ); ?></label>
                <textarea name="post_content"><?php echo $editing_post ? esc_textarea( $editing_post->post_content ) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label><?php _e( 'الصورة الرئيسية', 'sheikh-bassam-kayed' ); ?></label>
                <div class="image-upload-wrapper">
                    <div class="image-upload-input-wrapper">
                        <input type="url" id="gallery_featured_image" name="featured_image_url" value="<?php echo $editing_post ? esc_url( get_the_post_thumbnail_url( $editing_post_id, 'full' ) ) : ''; ?>" placeholder="https://..." />
                        <button type="button" class="image-upload-button" data-target="gallery_featured_image"><?php _e( 'رفع صورة', 'sheikh-bassam-kayed' ); ?></button>
                    </div>
                    <img src="<?php echo $editing_post ? esc_url( get_the_post_thumbnail_url( $editing_post_id, 'full' ) ) : ''; ?>" class="image-preview <?php echo ( $editing_post && get_the_post_thumbnail_url( $editing_post_id ) ) ? '' : 'hidden'; ?>" id="gallery_featured_image_preview" />
                </div>
            </div>
            
            <div class="form-group">
                <label><?php _e( 'صور إضافية (روابط مفصولة بفواصل)', 'sheikh-bassam-kayed' ); ?></label>
                <textarea name="gallery_images_text" placeholder="https://...&#10;https://...&#10;https://..."><?php 
                    if ( $editing_post ) {
                        $gallery_images = get_post_meta( $editing_post_id, '_gallery_images', true );
                        if ( is_array( $gallery_images ) ) {
                            echo esc_textarea( implode( "\n", $gallery_images ) );
                        }
                    }
                ?></textarea>
                <p class="description"><?php _e( 'أدخل رابط صورة واحد في كل سطر', 'sheikh-bassam-kayed' ); ?></p>
            </div>
            
            <div class="form-actions">
                <button type="submit" name="<?php echo $editing_post ? 'update_post' : 'create_post'; ?>" class="submit-button">
                    <?php echo $editing_post ? __( 'تحديث الصورة', 'sheikh-bassam-kayed' ) : __( 'إضافة صورة', 'sheikh-bassam-kayed' ); ?>
                </button>
                <button type="button" class="cancel-form-button" data-form="gallery-form" data-tab="gallery">
                    <?php _e( 'إلغاء', 'sheikh-bassam-kayed' ); ?>
                </button>
            </div>
            </form>
        </div>
        
        <!-- Data List -->
        <div class="data-list-section">
            <h4><?php _e( 'الصور الموجودة', 'sheikh-bassam-kayed' ); ?></h4>
        <?php
        $gallery_items = sheikh_bassam_kayed_get_dashboard_posts( 'gallery' );
        if ( $gallery_items ) :
            ?>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th><?php _e( 'العنوان', 'sheikh-bassam-kayed' ); ?></th>
                        <th><?php _e( 'الصورة', 'sheikh-bassam-kayed' ); ?></th>
                        <th><?php _e( 'الإجراءات', 'sheikh-bassam-kayed' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $gallery_items as $item ) : ?>
                        <tr>
                            <td><?php echo esc_html( $item->post_title ); ?></td>
                            <td style="text-align: center;">
                                <?php if ( has_post_thumbnail( $item->ID ) ) : ?>
                                    <img src="<?php echo esc_url( get_the_post_thumbnail_url( $item->ID, 'thumbnail' ) ); ?>" />
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo esc_url( home_url( '/dashboard/gallery?edit=' . $item->ID ) ); ?>"><?php _e( 'تعديل', 'sheikh-bassam-kayed' ); ?></a>
                                <a href="<?php echo esc_url( wp_nonce_url( home_url( '/dashboard/gallery?delete_post=' . $item->ID ), 'delete_post_' . $item->ID ) ); ?>" 
                                   onclick="return confirm('<?php esc_attr_e( 'هل أنت متأكد من حذف هذه الصورة؟', 'sheikh-bassam-kayed' ); ?>');"
                                   class="delete-link"><?php _e( 'حذف', 'sheikh-bassam-kayed' ); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="empty-state">
                <p><?php _e( 'لا توجد صور بعد', 'sheikh-bassam-kayed' ); ?></p>
                <button type="button" class="add-new-button" data-form="gallery-form" data-tab="gallery">
                    <?php _e( 'إضافة أول صورة', 'sheikh-bassam-kayed' ); ?>
                </button>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>

