<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blocksy
 */

blocksy_after_current_template();
do_action('blocksy:content:bottom');

?>
</main>


<!--
<section class="footer-section">
    <video id="introVideo" autoplay muted loop playsinline>
        <source src="https://videos.pexels.com/video-files/3129671/3129671-uhd_2560_1440_30fps.mp4" type="video/mp4">
    </video>
    -->

    <!-- 🔲 반투명 오버레이 -->
<!--
<div class="videoOverlay"></div>

    <div class="text-block">
        <p>
            In the vast complexity of the human brain lies the true foundation of happiness and success.
            The Korea Institute of Brain Science brings together leading experts in neuroscience from Korea and around the world to explore the full potential of the human mind.
            Through advanced brain training systems and science-based educational programs, we aim to create a healthier, more balanced, and fulfilling life experience for all.
        </p>
    </div>
</section>
-->
<?php
do_action('blocksy:content:after');
do_action('blocksy:footer:before');

blocksy_output_footer();

do_action('blocksy:footer:after');
?>
</div>

<?php wp_footer(); ?>

<!--<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/SplitText.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrambleTextPlugin.min.js"></script>

<script>
    gsap.registerPlugin(ScrambleTextPlugin,SplitText)

    const st = SplitText.create("p", {type: "chars", charsClass: "char"});

    st.chars.forEach((char) => {
        gsap.set(char, {attr: {"data-content": char.innerHTML}});
    });

    const textBlock = document.querySelector(".text-block");

    textBlock.onpointermove = (e) => {
        st.chars.forEach((char) => {
            const rect = char.getBoundingClientRect();
            const cx = rect.left + rect.width / 2;
            const cy = rect.top + rect.height / 2;
            const dx = e.clientX - cx;
            const dy = e.clientY - cy;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < 100)
                gsap.to(char, {
                    overwrite: true,
                    duration: 1.2 - dist / 100,
                    scrambleText: {
                        text: char.dataset.content,
                        chars: ".:",
                        speed: 0.5,
                    },
                    ease: 'none'
                });
        });
    };
</script>-->

</body>
</html>
