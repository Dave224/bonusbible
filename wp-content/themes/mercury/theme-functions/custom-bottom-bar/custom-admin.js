jQuery(document).ready(function($) {
    $('.upload_image_button').click(function(e) {
        e.preventDefault();
        var button = $(this);
        var customUploader = wp.media({
            title: 'Vyber obrázek',
            button: { text: 'Vybrat' },
            multiple: false
        }).on('select', function() {
            var attachment = customUploader.state().get('selection').first().toJSON();
            button.prev().val(attachment.url);
            button.next('p').find('img').attr('src', attachment.url);
            button.next('span').find('img').attr('src', attachment.url);
        }).open();
    });
});