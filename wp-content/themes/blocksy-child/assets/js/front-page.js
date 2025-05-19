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
});
