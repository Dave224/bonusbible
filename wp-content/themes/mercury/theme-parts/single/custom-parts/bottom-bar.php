<?php
$postId = get_the_ID();
$postTerms = wp_get_post_terms($postId, 'category');
$useCategorySettings = false;
$categoryId = null;
foreach($postTerms as $postTerm) {
    $useSettings = get_term_meta($postTerm->term_id, 'category_bottom_bar', true);
    if ($useSettings) {
        $useCategorySettings = true;
        $categoryId = $postTerm->term_id;
        break;
    }
}
$bottomBarMain = get_option('custom_bar_use_all');

if (get_post_meta($postId, '_bottom_bar_title', true)) {
    $titleExtra = get_post_meta($postId, '_bottom_bar_title', true);
    $tagExtra = get_post_meta($postId, '_bottom_bar_tag', true);
    $image = get_post_meta($postId, '_bottom_bar_image', true);
    $buttonUrl = get_post_meta($postId, '_bottom_bar_button_url', true);
    $buttonTitle = get_post_meta($postId, '_bottom_bar_button_title', true);
} else if ($useCategorySettings) {
    $titleExtra = get_term_meta($categoryId, 'category_title', true);
    $tagExtra = get_term_meta($categoryId, 'category_tag', true);
    $image = get_term_meta($categoryId, 'category_image', true);
    $buttonUrl = get_term_meta($categoryId, 'category_button_url', true);
    $buttonTitle = get_term_meta($categoryId, 'category_button_title', true);
} else if ($bottomBarMain && $bottomBarMain != "disable") {
    $titleExtra = get_option('custom_text');
    $buttonTitle = get_option('custom_button_text');
    $buttonUrl = get_option('custom_button_url');
    $image = get_option('custom_image');
    $tagExtra = get_option('custom_tag');
}

$content = get_the_content();
// Najdi první <a class="btn...> a vytáhni href
$link = '';
if (preg_match('/<a[^>]*class=["\'][^"\']*btn[^"\']*["\'][^>]*href=["\']([^"\']+)["\']/i', $content, $matches)) {
    $link = $matches[1];
    // Získání ID z odkazu jako /?p=2345
    if (preg_match('/[?&]p=(\d+)/', $link, $id_match)) {
        $post_id = intval($id_match[1]);

        // Získání přeloženého permalinku
        $link = get_permalink($post_id);
    }
}

$title = $titleExtra ?: get_the_title();
$button_title = $buttonTitle ?: __('Hrát', 'SLOTH');
$button_url = $buttonUrl ?: $link;
$thumbnail_id = $image ? attachment_url_to_postid($image) : get_post_thumbnail_id();
$tag = $tagExtra ?: '';
?>
<!-- Organization Float Bar Start -->

<script type="text/javascript">
    jQuery(document).ready(function($) {
        'use strict';

        var stickyOffset = $('.space-organization-float-bar-bg').offset().top;

        $(window).scroll(function(){
            'use strict';
            var sticky = $('.space-organization-float-bar-bg'),
                scroll = $(window).scrollTop();

            if (scroll >= 400) sticky.addClass('show');
            else sticky.removeClass('show');
        });

    });
</script>

<style type="text/css">
    .space-footer {
        padding-bottom: 110px;
    }
    @media screen and (max-width: 479px) {
        .space-footer {
            padding-bottom: 100px;
        }
        .single-organization #scrolltop.show {
            opacity: 1;
            visibility: visible;
            bottom: 120px;
        }
    }
    .tag-over-title {
        font-size: 15px;
        color: #9131f7;
    }
</style>

<div class="space-organization-float-bar-bg box-100">
    <div class="space-organization-float-bar-bg-ins space-page-wrapper relative">
        <div class="space-organization-float-bar relative">
            <div class="space-organization-float-bar-data box-75 relative">
                <div class="space-organization-float-bar-data-ins relative">
                    <div class="space-organization-float-bar-logo relative">
                        <div class="space-organization-float-bar-logo-img relative">
                            <?php
                            $post_title_attr = the_title_attribute( 'echo=0' );
                            if ( wp_get_attachment_image($thumbnail_id) ) {
                                echo wp_get_attachment_image( $thumbnail_id, 'mercury-100-100', "", array( "alt" => $post_title_attr ) );
                            } ?>
                        </div>
                    </div>
                    <div class="space-organization-float-bar-title box-50 relative">
                        <div class="space-organization-float-bar-title-wrap box-100 relative">
                            <?php if ($tag) { ?>
                                <span class="tag-over-title"><?= $tag; ?></span><br />
                            <?php } ?>
                            <?= $title; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-organization-float-bar-button box-25 relative">
                <div class="space-organization-float-bar-button-all text-center relative">
                    <div class="space-organization-float-bar-button-ins relative">
                        <div class="relative">
                            <a href="<?= $button_url; ?>" class="btn" title="<?= $button_title; ?>" target="_blank" rel="noopener noreferrer">
                                <?= $button_title; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Organization Float Bar End -->