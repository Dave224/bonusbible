<?php
add_filter('wp_handle_upload_prefilter', 'wp_modify_uploaded_file_names', 1, 1);
function wp_modify_uploaded_file_names($file) {
    $info = pathinfo($file['name']);
    $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
    $name = basename($file['name'], $ext);

    $randomNumber = '';
    for ($i = 0; $i < 5; $i++) {
        $randomNumber .= rand(0, 9);
    }

    $file['name'] = $randomNumber . '-' . $name . $ext;

    return $file;
}


add_action( 'add_attachment', 'my_set_image_meta_upon_image_upload' );
function my_set_image_meta_upon_image_upload( $post_ID ) {

    // Check if uploaded file is an image, else do nothing

    if ( wp_attachment_is_image( $post_ID ) ) {

        $my_image_title = get_post( $post_ID )->post_title;

        // Sanitize the title:  remove hyphens, underscores & extra spaces:
        $my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $my_image_title );
        
        // Create an array with the image meta (Title, Caption, Description) to be updated
        // Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
        $my_image_meta = array(
            'ID'		=> $post_ID,			// Specify the image (ID) to be updated
            'post_title'	=> $my_image_title,		// Set image Title to sanitized title
            //'post_excerpt'	=> $my_image_title,		// Set image Caption (Excerpt) to sanitized title
           // 'post_content'	=> $my_image_title,		// Set image Description (Content) to sanitized title
        );

        // Set the image Alt-Text
        update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );

        // Set the image meta (e.g. Title, Excerpt, Content)
        wp_update_post( $my_image_meta );

    }
}