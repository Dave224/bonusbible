<?php
function custom_admin_menu() {
    // Hlavní stránka v sekci "Nastavení"
    add_menu_page(
        'Nastavení šablony', // Titulek stránky
        'Nastavení šablony', // Název v menu
        'manage_options', // Oprávnění
        'custom-settings', // Slug stránky
        'custom_settings_page', // Callback funkce
        'dashicons-admin-generic',
        20
    );

    // Podmenu (první se zobrazí stejně jako hlavní)
    add_submenu_page(
        'custom-settings',
        'Obecné',
        'Obecné',
        'manage_options',
        'custom-settings',
        'custom_settings_page'
    );

    add_submenu_page(
        'custom-settings',     // Parent
        'Nastavení dolní lišty',        // Název
        'Nastavení dolní lišty',        // Název v menu
        'manage_options',      // Potřebná oprávnění
        'bottom-bar-settings',         // Slug
        'custom_menu_page'    // Callback funkce
    );
}
add_action('admin_menu', 'custom_admin_menu');

function custom_settings_page() {
    return;
}

function custom_menu_page() {
    ?>
    <div class="wrap">
        <h1>Nastavení dolní lišty</h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php
            settings_fields('custom_settings_group');
            do_settings_sections('nastaveni-dolni-listy');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function custom_settings_init() {
    register_setting('custom_settings_group', 'custom_text');
    register_setting('custom_settings_group', 'custom_image');
    register_setting('custom_settings_group', 'custom_tag');
    register_setting('custom_settings_group', 'custom_button_text');
    register_setting('custom_settings_group', 'custom_button_url');
    register_setting('custom_settings_group', 'custom_bar_use_all', [
        'sanitize_callback' => function($value) {
            return $value === '1' ? '1' : 'disable';
        }
    ]);

    add_settings_section(
        'custom_settings_section',
        'Vlastní nastavení',
        null,
        'nastaveni-dolni-listy'
    );

    add_settings_field(
        'custom_text',
        'Titulek',
        'custom_text_callback',
        'nastaveni-dolni-listy',
        'custom_settings_section'
    );

    add_settings_field(
        'custom_image',
        'Logo',
        'custom_image_callback',
        'nastaveni-dolni-listy',
        'custom_settings_section'
    );

    add_settings_field(
        'custom_tag',
        'Tag nad titulkem',
        'custom_tag_callback',
        'nastaveni-dolni-listy',
        'custom_settings_section'
    );

    add_settings_field(
        'custom_button_text',
        'Text tlačítka',
        'custom_button_text_callback',
        'nastaveni-dolni-listy',
        'custom_settings_section'
    );

    add_settings_field(
        'custom_button_url',
        'URL tlačítka',
        'custom_button_url_callback',
        'nastaveni-dolni-listy',
        'custom_settings_section'
    );

    add_settings_field(
        'custom_bar_use_all',
        'Použít toto nastavení všude',
        'custom_checkbox_callback',
        'nastaveni-dolni-listy',
        'custom_settings_section'
    );
}
add_action('admin_init', 'custom_settings_init');

function custom_checkbox_callback() {
    $hodnota = get_option('custom_bar_use_all', '');
    echo '<input type="checkbox" class="custom-input-field" name="custom_bar_use_all" id="custom_bar_use_all" value="1" ' . checked($hodnota, '1', false) . ' />';
}

function custom_text_callback() {
    $value = get_option('custom_text', '');
    echo '<input type="text" name="custom_text" value="' . esc_attr($value) . '" class="custom-input-field" />';
}

function custom_image_callback() {
    $value = get_option('custom_image', '');
    echo '<input type="text" name="custom_image" value="' . esc_url($value) . '" class="custom-input-field" />';
    echo '<button class="button upload_image_button">Nahrát obrázek</button>';
    echo '<p><img src="' . esc_url($value) . '" style="max-width:200px;"></p>';
}

function custom_tag_callback() {
    $value = get_option('custom_tag', '');
    echo '<input type="text" name="custom_tag" value="' . esc_attr($value) . '" class="custom-input-field" />';
}

function custom_button_text_callback() {
    $value = get_option('custom_button_text', '');
    echo '<input type="text" name="custom_button_text" value="' . esc_attr($value) . '" class="custom-input-field" />';
}

function custom_button_url_callback() {
    $value = get_option('custom_button_url', '');
    echo '<input type="text" name="custom_button_url" value="' . esc_attr($value) . '" class="custom-input-field" />';
}

function custom_admin_scripts($hook) {
    if ($hook !== 'toplevel_page_nastaveni-dolni-listy') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('custom-admin-script', get_template_directory_uri() . '/theme-functions/custom-bottom-bar/custom-admin.js', ['jquery'], null, true);
    wp_enqueue_style('custom-admin-style', get_template_directory_uri() . '/theme-functions/custom-bottom-bar/custom-style-admin.css');

}
add_action('admin_enqueue_scripts', 'custom_admin_scripts');