window.addEventListener("DOMContentLoaded", () => {
    gsap.registerPlugin(ScrollTrigger);

    var viewportHeight = window.innerHeight;
    var viewportWidth = window.innerWidth;

    gsap.timeline({
        scrollTrigger: {
            scrub: 1,
            trigger: "#introSection",
            start: "top top",
            end: '+=200',
        },
    }).to(".video-wrapper",
        {
            width: 'calc(100% - 90px)',
            height: 'calc(100% - 90px)',
            top: '45px',
            left: '45px',
            borderRadius: '45px',
            ease: "power1.in",
        });

    gsap.timeline({
        scrollTrigger: {
            trigger: ".pin-gallery",
            start: "top top",
            end: () => innerHeight * 4,
            pin: '.pin-gallery',
            scrub: 1,
            anticipatePin: 1,
        },
    }).from(".lab-img", {
        scale: 5,
        ease: "none"
    });

    gsap.from(".service-title-wrapper", {
        scrollTrigger: {
            trigger: "#subServiceSection",
            start: 'top 80%', // 뷰포트 아래쪽에서 시작
            toggleActions: 'play none none none',
            scrub: 1,
        },
        opacity: 0,
        y: 40,
        duration: 1,
        ease: 'power3.out',
        delay: 0.3 // 순차적으로 보이도록 약간의 딜레이
    });

    const serviceBoxs = document.querySelectorAll('.service-box');
    serviceBoxs.forEach((el, i) => {
        gsap.from(el, {
            scrollTrigger: {
                trigger: el,
                start: 'top 90%', // 뷰포트 아래쪽에서 시작
                toggleActions: 'play none none none',
                scrub: 1,
            },
            opacity: 0,
            y: 40,
            duration: 1,
            ease: 'power3.out',
            delay: 0.3 * i // 순차적으로 보이도록 약간의 딜레이
        });
    });

    // NeuroFeedBack
    const neurofeedbackGSAP = gsap.timeline({
        scrollTrigger: {
            trigger: "#neurofeedbackSection",
            start: "top top",
            end: "+=3000",       // 스크롤 이동 거리 (고정되는 시간)
            scrub: true,         // 스크롤에 따라 반응
            pin: true,           // 고정
        }
    });

    neurofeedbackGSAP
        .from(".normal-title", {
            y: 100, opacity: 0, duration: 0.8
        })
        .from(".info-wrapper", {
            y: 100, opacity: 0, duration: 0.8
        })
        .addLabel('opaGroup')
        .to("#neurofeedbackSection .bg-filter", {
            opacity: 0.7, duration: 0.6
        }, "opaGroup")
        .to(".img-wrapper", {
            opacity: 1, duration: 0.2
        }, "opaGroup")
        .addLabel('imageGroup')
        .to(".prod1", {
            y: -viewportHeight,
            duration: 2,
            ease: "power2.out"
        }, "imageGroup")
        .to(".prod2", {
            y: (viewportWidth > 767) ? -viewportHeight * 1.5 : -viewportHeight * 1.3,
            duration: 2,
            ease: "power2.out"
        }, "imageGroup")
        .to(".prod3", {
            y: (viewportWidth > 767) ? -viewportHeight * 0.05 : -viewportHeight * 0.9,
            duration: 2,
            ease: "power2.out"
        }, "imageGroup")
        .to(".prod4", {
            y: (viewportWidth > 767) ? -viewportHeight * 0.8 : -viewportHeight * 0.05,
            duration: 2,
            ease: "power2.out"
        }, "imageGroup")
        .to(".prod5", {
            y: (viewportWidth > 767) ? -viewportHeight * 1.2 : -viewportHeight * 0.5,
            duration: 2,
            ease: "power2.out"
        }, "imageGroup")
        .to(".prod6", {
            y: (viewportWidth > 767) ? -viewportHeight * 0.2 : -viewportHeight * 0.25,
            duration: 2,
            ease: "power2.out"
        }, "imageGroup");

console.log(viewportHeight, viewportWidth)
    const dataimages = document.querySelectorAll('.data-img-wrapper');
    dataimages.forEach((el, i) => {
        gsap.from(el, {
            scrollTrigger: {
                trigger: el,
                start: 'top 80%', // 뷰포트 아래쪽에서 시작
                end: "+=200",
                toggleActions: 'play none none none',
                scrub: 1,
            },
            opacity: 0,
            y: 40,
            duration: 1,
            ease: 'power3.out',
            delay: 0.5 * i // 순차적으로 보이도록 약간의 딜레이
        });
    })

    // Mouse Motion
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
            jQuery('.box-1').css({"transform": "translate(" + newvalueX + "px," + newvalueY + "px)"});
            jQuery('.box-2').css({"transform": "translate(" + newvalueX * (-1) + "px," + newvalueY * (-1) + "px)"});
            jQuery('.box-3').css({"transform": "translate(" + newvalueX * 2 + "px," + newvalueY * 2 + "px)"});
            jQuery('.box-4').css({"transform": "translate(" + newvalueX * (-1) + "px," + newvalueY * 2 + "px)"});
            // jQuery('.box-5').css({"transform": "translate(" + newvalueX * 2 + "px," + newvalueY * (-1) + "px)"});
        });
    }

    /*
    jQuery(window).on('load', function () {
        setTimeout(function () {
            mousemove();
        }, 1000)
    });
    */
});
