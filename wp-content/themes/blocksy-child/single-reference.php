<?php
/*
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Blocksy
 */

get_header();

if (have_posts()) {
    the_post();
}

if (
    function_exists('blc_get_content_block_that_matches')
    &&
    blc_get_content_block_that_matches([
        'template_type' => 'single',
        'template_subtype' => 'canvas'
    ])
) {
    echo blc_render_content_block(
        blc_get_content_block_that_matches([
            'template_type' => 'single',
            'template_subtype' => 'canvas'
        ])
    );
    have_posts();
    wp_reset_query();
    return;
}

/**
 * Note to code reviewers: This line doesn't need to be escaped.
 * Function blocksy_output_hero_section() used here escapes the value properly.
 */
if (apply_filters('blocksy:single:has-default-hero', true)) {
    echo blocksy_output_hero_section([
        'type' => 'type-2'
    ]);
}

$page_structure = blocksy_get_page_structure();

$container_class = 'ct-container-full';
$data_container_output = '';

if ($page_structure === 'none' || blocksy_post_uses_vc()) {
    $container_class = 'ct-container';

    if ($page_structure === 'narrow') {
        $container_class = 'ct-container-narrow';
    }
} else {
    $data_container_output = 'data-content="' . $page_structure . '"';
}

?>

    <style>
        .attachments {
            margin-top: 60px;
            padding-top: 60px;
            border-top: 1px solid rgba(255, 255, 255, 0.6);

            .file-wrapper {
                display: inline-block;
                margin-bottom: 15px;
                margin-right: 15px;

                a {
                    display: flex;
                    flex-direction: row;
                    justify-content: flex-start;
                    align-items: center;
                    padding: 15px;
                    border: 1px solid white;
                    border-radius: 15px;
                    color: white;

                    span {
                        margin-right: 30px;
                    }

                    .first-icon {
                        svg {
                            margin-right: 15px;
                        }
                    }
                    .second-icon {
                        svg {
                            margin-left: 15px;
                            width: 15px;
                            height: 15px;
                        }
                    }

                    svg {
                        width: 30px;
                        height: 30px;
                    }
                }
            }
        }

        .elementor-icon {
            svg {
                fill: white;
                border-color: white;
            }
        }
    </style>

    <div
            class="<?php echo trim($container_class) ?>"
        <?php echo wp_kses_post(blocksy_sidebar_position_attr()); ?>
        <?php echo $data_container_output; ?>
        <?php echo blocksy_get_v_spacing() ?>>

        <?php do_action('blocksy:single:container:top'); ?>

        <?php
        /**
         * Note to code reviewers: This line doesn't need to be escaped.
         * Function blocksy_single_content() used here escapes the value properly.
         */
        echo blocksy_single_content();

        $attachments = get_field('reference');
        ?>

        <?php if ($attachments): ?>
            <div class="ct-container attachments">
                <h3>첨부파일</h3>

                <?php foreach ($attachments as $file): ?>
                    <div class="file-wrapper">
                        <a href="<?php echo $file['file']['url']; ?>"
                           download="<?php echo $file['file']['filename']; ?>">
                            <div class="elementor-icon first-icon">
                                <svg aria-hidden="true" class="e-font-icon-svg e-far-file-alt" viewBox="0 0 384 512"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M288 248v28c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-28c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm-12 72H108c-6.6 0-12 5.4-12 12v28c0 6.6 5.4 12 12 12h168c6.6 0 12-5.4 12-12v-28c0-6.6-5.4-12-12-12zm108-188.1V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V48C0 21.5 21.5 0 48 0h204.1C264.8 0 277 5.1 286 14.1L369.9 98c9 8.9 14.1 21.2 14.1 33.9zm-128-80V128h76.1L256 51.9zM336 464V176H232c-13.3 0-24-10.7-24-24V48H48v416h288z"></path>
                                </svg>
                            </div>
                            <span><?php echo $file['file']['filename']; ?></span>
                            다운로드
                            <div class="elementor-icon second-icon">
                                <svg aria-hidden="true" class="e-font-icon-svg e-fas-download" viewBox="0 0 512 512"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24zm296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php get_sidebar(); ?>

        <?php do_action('blocksy:single:container:bottom'); ?>
    </div>

<?php

blocksy_display_page_elements('separated');

have_posts();
wp_reset_query();

get_footer();
