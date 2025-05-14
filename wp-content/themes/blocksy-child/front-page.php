<?php
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
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/front-page.css">

<div id="introBox">
    <!-- 🎥 배경 영상 -->
    <video id="introVideo" autoplay muted loop playsinline>
        <!-- <source src="https://videos.pexels.com/video-files/3129671/3129671-uhd_2560_1440_30fps.mp4" type="video/mp4">-->
        <source src="https://nagil-wordpress.s3.ap-northeast-2.amazonaws.com/videos/korea-bsi-bg-video-1.mov"
                type="video/mp4">
    </video>

    <!-- 🔲 반투명 오버레이 -->
    <div class="videoOverlay"></div>
    <div id="introLogo">
        <img src="/wp-content/themes/blocksy-child/assets/images/logo/korea-bsi-logo-white.png" alt="Site Logo">
    </div>
    <div id="revealMask"></div>
</div>
<div
        id="mainContent" style="opacity: 0;"
        class="<?php echo trim($container_class) ?>"
    <?php echo wp_kses_post(blocksy_sidebar_position_attr()); ?>
    <?php echo $data_container_output; ?>
    <?php echo blocksy_get_v_spacing() ?>>

    <?php do_action('blocksy:single:container:top'); ?>

    <section id="introSection">
        <div class="video-wrapper">
            <video autoplay muted loop playsinline id="bgVideo">
                <source src="https://nagil-wordpress.s3.ap-northeast-2.amazonaws.com/videos/korea-bsi-bg-video-1.mov"
                        type="video/mp4">
            </video>
            <div class="bg-filter"></div>
        </div>
        <div class="intro-content">
            <h1><span style="font-size: 130%;">뇌속에 인간의 성공과 행복이 있다</span></h1>
            <h6><span style="font-size: 130%;">Within the Brain Lies Human Success and Happiness</span></h6>
        </div>
    </section>

    <?php
    /**
     * Note to code reviewers: This line doesn't need to be escaped.
     * Function blocksy_single_content() used here escapes the value properly.
     */
    echo blocksy_single_content();
    ?>

    <?php get_sidebar(); ?>

    <?php do_action('blocksy:single:container:bottom'); ?>
</div>

<?php

blocksy_display_page_elements('separated');

have_posts();
wp_reset_query();

get_footer();
?>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const logo = document.querySelector('#introBox #introLogo img');
        const introBox = document.getElementById('introBox');
        const mainContent = document.getElementById('mainContent');

        const tl = gsap.timeline({defaults: {ease: 'power3.out'}});

        // 1. 로고 페이드 인
        tl.to(logo, {
            opacity: 1,
            duration: 1
        })

            // 2. 로고 약간 확대 효과
            .to(logo, {
                opacity: 0,
                y: -20,
                delay: 1,
                duration: 1,
            })

            // 인트로 박스 페이드아웃
            .to(introBox, {
                opacity: 0,
                onComplete: () => {
                    introBox.style.display = 'none';
                    document.body.style.overflow = 'auto'; // 스크롤 다시 허용
                }
            })

            // 메인 콘텐츠의 클립패스 확장 (동그랗게 점점 보이게)
            .to(mainContent, {
                opacity: 1,
                clipPath: "circle(150% at center)",
                duration: 1.5,
                ease: "power2.inOut",
                onComplete: () => {
                    // ✅ 이제 높이 제한 해제
                    mainContent.style.maxHeight = 'unset';
                    mainContent.style.overflow = 'unset';
                }
            }, "-=0.5");
    });
</script>
<script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/front-page.js"></script>
