<?php
add_shortcode('intro_people', function () {


    ?>

    <style>
        .leader-section {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 30px;

            .thumbnail-wrapper {
                width: 35%;

                img {
                    border-radius: 30px;
                }
            }

            .info-wrapper {
                width: 65%;
                padding: 30px;

                .name-title {
                    display: flex;
                    flex-direction: row;
                    gap: 15px;
                    align-items: baseline;
                    margin-bottom: 60px;

                    h5 {
                        color: #00B2DB;
                    }
                }

                .info-group {
                    column-count: 2;
                    gap: 45px;

                    div {
                        display: inline-block;
                        width: 100%; /* 중요: column 레이아웃에선 inline-block + width 100% */
                        box-sizing: border-box;
                        margin-bottom: 45px;

                        h6 {
                            color: #00B2DB;
                        }
                    }
                }
            }
        }

        .people-list {
            margin-top: 90px;
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: flex-start;

            .person-wrapper {
                width: calc(20% - 15px);
                margin-right: 15px;
                margin-bottom: 60px;

                .thumbnail-wrapper {
                    position: relative;

                    img {
                        /*background: linear-gradient(0, #ffffff 0%, #eaeaea 100%);*/
                        background: white;
                        border-radius: 15px;
                    }

                    .position {
                        border-radius: 5px;
                        background: #041823aa;
                        padding: 5px 20px;
                        text-align: center;
                        font-weight: 600;
                        font-size: 16px;
                        position: absolute;
                        bottom: 10px;
                        right: 10px;
                    }
                }

                .name {
                    margin-top: 15px;
                }

                .info-wrapper {
                    height: 200px;
                    margin-bottom: 15px;
                    position: relative;
                    overflow: hidden;

                    .career, .lecture, .thesis, .books, .history {
                        margin-bottom: 30px;

                        h6 {
                            color: #00B2DB;
                        }

                        div {
                            font-size: 90%;
                        }
                    }
                }

                .info-wrapper:after {
                    content: '';
                    height: 50px;
                    width: 100%;
                    position: absolute;
                    left: 0;
                    bottom: 0;
                    background: linear-gradient(0deg, #041823 0%, #04182300 100%);
                }

                .info-wrapper.open {
                    height: auto;
                }
                .info-wrapper.open:after {
                    opacity: 0;
                }

                .btn {
                    padding: 5px 30px;
                    border-radius: 5px;
                    width: 100%;
                }
            }

            .person-wrapper:nth-child(5) {
                margin-right: 0;
            }
        }

        @media (min-width: 768px) and (max-width: 1290px) {
            .people-list {
                .person-wrapper {
                    width: calc(100% / 3 - 15px);

                    .thumbnail-wrapper {
                        .position {
                            border-radius: 3px;
                            font-size: 13px;
                        }
                    }
                }
            }

            .person-wrapper:nth-child(3) {
                margin-right: 0;
            }
        }

        @media (max-width: 767px) {
            .leader-section {
                flex-direction: column;

                .info-wrapper {
                    padding: 0;

                    .name-title {
                        margin-top: 15px;
                        margin-bottom: 15px;
                    }

                    .info-group {
                        div {
                            font-size: 13px;
                            margin-bottom: 30px;
                        }
                    }
                }

                .thumbnail-wrapper, .info-wrapper {
                    width: 100%;

                    img {
                        border-radius: 15px;
                    }
                }
            }

            .people-list {
                .person-wrapper {
                    width: calc(50% - 15px);

                    .thumbnail-wrapper {
                        .position {
                            border-radius: 3px;
                            font-size: 13px;
                        }
                    }
                }

                .person-wrapper:nth-child(2) {
                    margin-right: 0;
                }
            }
        }

        @media (max-width: 500px) {
            .leader-section {
                flex-direction: column;

                .info-wrapper {
                    padding: 0;

                    .name-title {
                        margin-top: 15px;
                        margin-bottom: 15px;
                    }

                    .info-group {
                        div {
                            font-size: 13px;
                            margin-bottom: 30px;
                        }
                    }
                }

                .thumbnail-wrapper, .info-wrapper {
                    width: 100%;

                    img {
                        border-radius: 15px;
                    }
                }
            }

            .people-list {
                .person-wrapper {
                    width: 100%;
                    margin-right: 0;
                }
            }
        }
    </style>
    <!-- 연구소장 -->
    <div
            class="leader-section"
    >
        <div class="thumbnail-wrapper">
            <img src="/wp-content/themes/blocksy-child/assets/images/front-page/person-back.jpeg" alt="백기자 연구소장">
        </div>
        <div class="info-wrapper">
            <div class="name-title">
                <h3>백기자 박사</h3>
                <h5>연구소장</h5>
            </div>
            <div class="info-group">
                <div class="career">
                    <h6>학력 및 경력</h6>
                    뇌과학 박사(뉴로피드백)<br/>
                    現)한국뇌과학연구소 연구소장<br/>
                    現)국제차세대융합기술학회 부회장(등기이사)<br/>
                    前) 서울불교대학원대학교 뇌과학 전공교수
                </div>
                <div class="lecture">
                    <h6>강의분야</h6>
                    뉴로피드백<br/>
                </div>
                <div class="thesis">
                    <h6>논문</h6>
                    NST 훈련이 비만인의 스트레스와 체중조절에 미치는 영향, JNCTA, 7(4) 614-620, 2023 외 KCI 50 여편
                </div>
                <div class="books">
                    <h6>저서</h6>
                    뇌과학의 라이프스타일<br/>
                    뇌.도형심리 이해와 실제<br/>
                    브레인디톡스<br/>
                    키메이커<br/>
                    뇌를 알면 우리아이의 미래가 열린다<br/>
                    행복한 뇌를 위한 똑똑한 밥상
                </div>
                <div class="history">
                    <h6>주요 개발 경력</h6>
                    BPS [ Brainwave Profiling Service 진로분석 ]<br/>
                    GPS[Growth Predition Service 키 성장 예측)<br/>
                    BFA[Brain Function Analysis 뇌기능 분석)<br/>
                </div>
            </div>
        </div>
    </div>

    <?php if (have_rows('people')): ?>

        <div class="people-list">
        <?php
        while (have_rows('people')) : the_row();

            $thumbnail = get_sub_field('thumbnail');
            $name = get_sub_field('name');
            $position = get_sub_field('position');
            $career = get_sub_field('career');
            $lecture = get_sub_field('lecture');
            $thesis = get_sub_field('thesis');
            $books = get_sub_field('books');
            $history = get_sub_field('history');
            ?>

            <div class="person-wrapper">
                <div class="thumbnail-wrapper">
                    <img src="<?php echo($thumbnail); ?>" alt="연구원 사진">
                    <div class="position"><?php echo($position); ?></div>
                </div>
                <h5 class="name"><?php echo($name); ?></h5>
                <div class="info-wrapper">
                    <?php if ($career): ?>
                        <div class="career">
                            <h6>학력 및 경력</h6>
                            <div><?php echo($career); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($lecture): ?>
                        <div class="lecture">
                            <h6>강의분야</h6>
                            <div><?php echo($lecture); ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if ($thesis): ?>
                        <div class="thesis">
                            <h6>논문</h6>
                            <div><?php echo($thesis); ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if ($books): ?>
                        <div class="books">
                            <h6>저서</h6>
                            <div><?php echo($books); ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if ($history): ?>
                        <div class="history">
                            <h6>자격 및 주요 강의 경력</h6>
                            <div><?php echo($history); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="button btn toggle-btn" data-toggle="close">더보기</button>
            </div>

        <?php endwhile; ?>

    <?php endif; ?>
    </div>

    <?php
});
