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


<section class="footer-section">
    <div class="text-block">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
            ex ea commodo consequat.</p>
    </div>
</section>

<?php
do_action('blocksy:content:after');
do_action('blocksy:footer:before');

blocksy_output_footer();

do_action('blocksy:footer:after');
?>
</div>

<?php wp_footer(); ?>

<script src="https://assets.codepen.io/16327/SplitText3-beta.min.js?b=15"></script>
<script src="https://assets.codepen.io/16327/ScrambleTextPlugin3.min.js"></script>

<script>
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
</script>

</body>
</html>
