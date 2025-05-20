window.addEventListener("DOMContentLoaded", () => {
    gsap.registerPlugin(ScrollTrigger);

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
