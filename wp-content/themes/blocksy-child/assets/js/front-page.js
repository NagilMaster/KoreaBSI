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
});
