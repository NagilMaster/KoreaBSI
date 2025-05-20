<?php
add_shortcode('main-slogan', function () {
    ?>

    <div class="mt_ty1">test</div>

    <script>
        var detect;

        var movementStrength = 16;
        var height = movementStrength / jQuery(window).height();
        var width = movementStrength / jQuery(window).width();

        function mousemove() {
            jQuery(window).on('mousemove', function (e) {
                // console.log(e.pageX,  e.pageY);
                var pageX = e.pageX - (jQuery(window).width() / 2);
                var pageY = e.pageY - (jQuery(window).height() / 2);
                //console.log(pageX,  pageY);
                var newvalueX = width * pageX * -1;
                var newvalueY = height * pageY * -1;
                jQuery('.mt_ty1').css({"transform": "translate(" + newvalueX + "px," + newvalueY + "px)"});
                jQuery('.mt_ty2').css({"transform": "translate(" + newvalueX * (-1) + "px," + newvalueY * (-1) + "px)"});
                jQuery('.mt_ty3').css({"transform": "translate(" + newvalueX * 2 + "px," + newvalueY * 2 + "px)"});
                jQuery('.mt_ty4').css({"transform": "translate(" + newvalueX * (-1) + "px," + newvalueY * 2 + "px)"});
                jQuery('.mt_ty5').css({"transform": "translate(" + newvalueX * 2 + "px," + newvalueY * (-1) + "px)"});
            });
        }

        jQuery(window).on('load', function () {
            setTimeout(function () {
                mousemove();
            }, 1000)
        });
    </script>
    <?php
});
