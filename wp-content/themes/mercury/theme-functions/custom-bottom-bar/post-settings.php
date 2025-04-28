<?php
// 1️⃣ Přidání checkboxu do editoru příspěvku
function pridat_bottom_bar_checkbox() {
    add_meta_box(
        'bottom_bar_meta_box',
        'Spodní lišta',
        'bottom_bar_meta_box',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'pridat_bottom_bar_checkbox');

function bottom_bar_meta_box($post) {
    $hodnota = get_post_meta($post->ID, '_bottom_bar', true);
    $title = get_post_meta($post->ID, '_bottom_bar_title', true);
    $tag = get_post_meta($post->ID, '_bottom_bar_tag', true);
    $image = get_post_meta($post->ID, '_bottom_bar_image', true);
    $buttonUrl = get_post_meta($post->ID, '_bottom_bar_button_url', true);
    $buttonTitle = get_post_meta($post->ID, '_bottom_bar_button_title', true);

    wp_nonce_field(basename(__FILE__), 'bottom_bar_nonce');
    ?>
    <p>
        <input type="checkbox" name="bottom_bar" id="bottom_bar" value="0" <?php checked($hodnota, '1'); ?> />
        <label for="bottom_bar">Skrýt spodní lištu</label>
    </p>

    <p>
        <label for="bottom_bar_title">Titulek</label>
        <input type="text" name="bottom_bar_title" id="bottom_bar_title" value="<?= $title; ?>" />
    </p>

    <p>
        <label for="bottom_bar_tag">Tag nad titulkem</label>
        <input type="text" name="bottom_bar_tag" id="bottom_bar_tag" value="<?= $tag; ?>" />
    </p>

    <p>
        <input type="text" name="bottom_bar_image" value="<?= esc_url($image); ?>" class="custom-input-field" />
        <button class="button upload_image_button">Nahrát obrázek</button>
        <span style="display:block; "><img src="<?= esc_url($image); ?>" style="max-width:200px;"></span>
    </p>

    <p>
        <label for="bottom_bar_button_title">Titulek tlačítka</label>
        <input type="text" name="bottom_bar_button_title" id="bottom_bar_button_title" value="<?= $buttonTitle; ?>" />
    </p>

    <p>
        <label for="bottom_bar_button_url">URL tlačítka</label>
        <input type="text" name="bottom_bar_button_url" id="bottom_bar_button_url" value="<?= $buttonUrl; ?>" />
    </p>
    <?php
}

// 2️⃣ Uložení hodnoty checkboxu
function ulozit_bottom_bar_checkbox($post_id) {
    if (!isset($_POST['bottom_bar_nonce']) || !wp_verify_nonce($_POST['bottom_bar_nonce'], basename(__FILE__))) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $hodnota = isset($_POST['bottom_bar']) ? '1' : '';
    update_post_meta($post_id, '_bottom_bar', $hodnota);
    update_post_meta($post_id, '_bottom_bar_title', $_POST['bottom_bar_title']);
    update_post_meta($post_id, '_bottom_bar_tag', $_POST['bottom_bar_tag']);
    update_post_meta($post_id, '_bottom_bar_button_title', $_POST['bottom_bar_button_title']);
    update_post_meta($post_id, '_bottom_bar_button_url', $_POST['bottom_bar_button_url']);
    update_post_meta($post_id, '_bottom_bar_image', $_POST['bottom_bar_image']);
}

add_action('save_post', 'ulozit_bottom_bar_checkbox');

wp_enqueue_script('custom-admin-script', get_template_directory_uri() . '/theme-functions/custom-bottom-bar/custom-admin.js?ver=2', ['jquery'], null, true);