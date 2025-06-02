<?php
add_shortcode('thesis_list', function () {

    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/css/lightbox.min.css" integrity="sha512-xtV3HfYNbQXS/1R1jP53KbFcU9WXiSA1RFKzl5hRlJgdOJm4OxHCWYpskm6lN0xp0XtKGpAfVShpbvlFH3MDAA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .thesis-list {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;

            .img-wrapper {
                display: block;
                width: calc(25% - 15px);
                margin-right: 15px;
                margin-bottom: 15px;
                overflow: hidden;
                border-radius: 5px;
                img {
                    display: block;
                }
            }
            .img-wrapper:nth-child(4) {
                margin-right: 0;
            }
        }
        #lightbox {
            .lb-image {
                border: 0;
            }
        }
        @media (max-width: 767px) {
            .thesis-list {
                .img-wrapper {
                    width: calc(50% - 15px);
                }

                .img-wrapper:nth-child(2) {

                }
            }
        }
    </style>

    <?php if (have_rows('thesis')): ?>

        <div class="thesis-list">
            <?php while (have_rows('thesis')) : the_row();
                $img = get_sub_field('img');
                ?>
                <?php if ($img): ?>
                <a href="<?php echo $img; ?>" class="img-wrapper" data-lightbox="thesis">
                    <img src="<?php echo $img; ?>" alt="논문 이미지">
                </a>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/js/lightbox.min.js" integrity="sha512-KbRFbjA5bwNan6DvPl1ODUolvTTZ/vckssnFhka5cG80JVa5zSlRPCr055xSgU/q6oMIGhZWLhcbgIC0fyw3RQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php
});
