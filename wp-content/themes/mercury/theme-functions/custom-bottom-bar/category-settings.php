<?php
// Přidání vlastního metaboxu do kategorií
function custom_category_metabox( $term ) {
    // Získání uložených hodnot
    $hodnota = get_term_meta($term->term_id, 'bottom_bar', true);
    $text1 = get_term_meta( $term->term_id, 'category_title', true );
    $text2 = get_term_meta( $term->term_id, 'category_tag', true );
    $text3 = get_term_meta( $term->term_id, 'category_button_title', true );
    $text4 = get_term_meta( $term->term_id, 'category_button_url', true );
    $checkbox = get_term_meta( $term->term_id, 'category_bottom_bar', true );
    $image = get_term_meta( $term->term_id, 'category_image', true );
    ?>

    <table class="form-table">
        <tr class="form-field term-group">
            <td style="width: 100%;">
                <h2><?= __('Nastavení spodní lišty u příspěvků', 'SLOTH'); ?></h2>
            </td>
        </tr>
        <tr>
            <th><label for="bottom_bar">Skrýt spodní lištu u všechn příspěvků v kategorii</label></th>
            <td>
                <input type="checkbox" name="bottom_bar" id="bottom_bar" value="0" <?php checked($hodnota, 1); ?> />
            </td>
        </tr>
        <tr>
            <th><label for="category_bottom_bar">Použít toto nastavení u všech příspěvku v kategorii</label></th>
            <td>
                <input type="checkbox" name="category_bottom_bar" id="category_bottom_bar" value="0" <?php checked( $checkbox, 1 ); ?>>
            </td>
        </tr>
        <tr>
            <th><label for="category_title">Titulek</label></th>
            <td><input type="text" name="category_title" id="category_title" value="<?php echo esc_attr( $text1 ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="category_tag">Tag nad titulkem</label></th>
            <td><input type="text" name="category_tag" id="category_tag" value="<?php echo esc_attr( $text2 ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="category_button_title">Text tlačítka</label></th>
            <td><input type="text" name="category_button_title" id="category_button_title" value="<?php echo esc_attr( $text3 ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="category_button_url">URL tlačítka</label></th>
            <td><input type="text" name="category_button_url" id="category_button_url" value="<?php echo esc_attr( $text4 ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="category_image">Obrázek</label></th>
            <td>
                <input type="text" name="category_image" id="category_image" value="<?php echo esc_attr( $image ); ?>" class="regular-text">
                <button class="button custom_upload_button">Vybrat obrázek</button>
                <span style="display:block;"><img src="<?php echo esc_url( $image ); ?>" style="max-width: 150px; margin-top: 10px;"></span>
            </td>
        </tr>
    </table>

    <script>
        jQuery(document).ready(function($) {
            $('.custom_upload_button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var custom_uploader = wp.media({
                    title: 'Vyber obrázek',
                    button: { text: 'Použít tento obrázek' },
                    multiple: false
                }).on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    button.prev().val(attachment.url);
                    button.next('span').find('img').attr('src', attachment.url);
                }).open();
            });
        });
    </script>

    <?php
}
add_action( 'category_edit_form_fields', 'custom_category_metabox' );

// Uložení metadat kategorie
function save_custom_category_metabox( $term_id ) {
    $hodnota = isset($_POST['bottom_bar']) ? '1' : '';
    update_term_meta($term_id, 'bottom_bar', $hodnota);
    update_term_meta( $term_id, 'category_title', sanitize_text_field( $_POST['category_title'] ?? '' ) );
    update_term_meta( $term_id, 'category_tag', sanitize_text_field( $_POST['category_tag'] ?? '' ) );
    update_term_meta( $term_id, 'category_button_title', sanitize_text_field( $_POST['category_button_title'] ?? '' ) );
    update_term_meta( $term_id, 'category_button_url', sanitize_text_field( $_POST['category_button_url'] ?? '' ) );
    update_term_meta( $term_id, 'category_bottom_bar', isset( $_POST['category_bottom_bar'] ) ? 1 : 0 );
    update_term_meta( $term_id, 'category_image', esc_url_raw( $_POST['category_image'] ?? '' ) );
}
add_action( 'edited_category', 'save_custom_category_metabox' );