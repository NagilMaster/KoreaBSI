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
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/page-services.css">


<div
        class="<?php echo trim($container_class) ?>"
    <?php echo wp_kses_post(blocksy_sidebar_position_attr()); ?>
    <?php echo $data_container_output; ?>
    <?php echo blocksy_get_v_spacing() ?>>

    <?php do_action('blocksy:single:container:top'); ?>

    <div id="hardware" class="hardware-section">
        <div class="ct-container title-wrapper">
            <h1>하드웨어 소개</h1>
            <p>한국뇌과학연구소는 뇌파 측정과 뉴로 피드백 훈련에 최적화된 자체 하드웨어를 개발하여, 보다 정밀하고 실용적인 두뇌 활용 솔루션을 제공합니다.</p>
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="swiper-carousel-animate-opacity">
                        <img src="/wp-content/themes/blocksy-child/assets/images/front-page/product-1.jpeg" alt="">
                        <div class="slide-content">
                            <h3>NeuroBrain</h3>
                            <p>뉴로피드백 기반을 통한 무선 뇌파측정 및 분석에 따른 훈련 프로그램 내장</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-carousel-animate-opacity">
                        <img src="/wp-content/themes/blocksy-child/assets/images/front-page/product-2.jpeg" alt="">
                        <div class="slide-content">
                            <h3>NST (Neuro Sound Technology)</h3>
                            <p>특정 주파수를 이용하여 뇌파를 동기화하고, 뇌기능의 균형과 통합, 전 대역 뇌파 훈련을 유도하는 도구.</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-carousel-animate-opacity">
                        <img src="/wp-content/themes/blocksy-child/assets/images/front-page/product-3.jpeg" alt="">
                        <div class="slide-content">
                            <h3>PowerNap</h3>
                            <p>자동 뇌파측정과 분석 후 훈련자에 맞는 주파수와 사운드 설정 30분 세팅으로 휴대성과 간편사용이 장점 43가지 훈련 프로그램 장착</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-carousel-animate-opacity">
                        <img src="/wp-content/themes/blocksy-child/assets/images/front-page/product-5.jpeg" alt="">
                        <div class="slide-content">
                            <h3>NeuroBrain</h3>
                            <p>뉴로피드백 기반을 통한 무선 뇌파측정 및 분석에 따른 훈련 프로그램 내장</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-carousel-animate-opacity">
                        <img src="/wp-content/themes/blocksy-child/assets/images/front-page/product-6.jpeg" alt="">
                        <div class="slide-content">
                            <h3>NeuroWave</h3>
                            <p>NeuroWave는 최첨단 생체 반응 시스템으로 두뇌개발 및 학습능력 향상, 주의력, 집중력 향상을 위한 제품입니다.</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-carousel-animate-opacity">
                        <img src="/wp-content/themes/blocksy-child/assets/images/front-page/product-4.jpeg" alt="">
                        <div class="slide-content">
                            <h3>NeuroBrain</h3>
                            <p>뉴로피드백 기반을 통한 무선 뇌파측정 및 분석에 따른 훈련 프로그램 내장</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-carousel-animate-opacity">
                        <img src="/wp-content/themes/blocksy-child/assets/images/front-page/product-7.jpeg" alt="">
                        <div class="slide-content">
                            <h3>PowerNap</h3>
                            <p>자동 뇌파측정과 분석 후 훈련자에 맞는 주파수와 사운드 설정 30분 세팅으로 휴대성과 간편사용이 장점 43가지 훈련 프로그램 장착</p>
                        </div>
                    </div>
                </div>
                <!-- 필요한 만큼 추가 -->
            </div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>


    </div>

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

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.mySwiper', {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        loop: true,
        // loopAdditionalSlides: 1,
        slidesPerView: "auto",
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        autoplay: {
            delay: 3000
        },
        breakpoints: {
            640: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 5,
            },
            1024: {
                slidesPerView: 5,
            },
        },
        on: {
            progress(swiper) {
                const {slides, rtlTranslate} = swiper;
                const scaleStep = 0.2;
                const opacityStep = 0.33;
                const sideSlides = 2;
                const maxSide = Math.max(Math.min(sideSlides, 3), 1);
                const depthMod = {1: 2, 2: 1, 3: 0.2}[maxSide];
                const shiftMod = {1: 50, 2: 50, 3: 67}[maxSide];

                slides.forEach(slide => {
                    const progress = slide.progress;
                    const absProgress = Math.abs(progress);
                    let adjust = 1;
                    if (absProgress > 1) adjust = 0.3 * (absProgress - 1) * depthMod + 1;

                    const offsetX = progress * adjust * shiftMod * (rtlTranslate ? -1 : 1);
                    const scale = 1 - absProgress * scaleStep;
                    const opacity = absProgress > sideSlides + 1 ? 0 : 1;

                    slide.style.transform = `translateX(${offsetX}%) scale(${scale})`;
                    slide.style.zIndex = slides.length - Math.abs(Math.round(progress));
                    slide.style.opacity = opacity;

                    const fadeEls = slide.querySelectorAll(".swiper-carousel-animate-opacity");
                    fadeEls.forEach(el => {
                        el.style.opacity = 1 - absProgress * opacityStep;
                    });
                });
            },
            setTransition(swiper, duration) {
                swiper.slides.forEach(slide => {
                    slide.style.transitionDuration = `${duration}ms`;
                    const fadeEls = slide.querySelectorAll(".swiper-carousel-animate-opacity");
                    fadeEls.forEach(el => {
                        el.style.transitionDuration = `${duration}ms`;
                    });
                });
            }
        }
    });
</script>


