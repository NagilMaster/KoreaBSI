// Elementor DOM 준비 후 실행
window.addEventListener('DOMContentLoaded', () => {
  const body = document.body;

  // front-page class가 body에 있는지 확인
//   if (body.classList.contains('home') || body.classList.contains('front-page')) {}

	
    // 원하는 애니메이션 대상 선택 (예: 메인 타이틀, 섹션 등)
    const hero = document.querySelector('.elementor-section');
    const elements = document.querySelectorAll('.elementor-widget');

    // 기본 GSAP 타임라인 설정
    const tl = gsap.timeline({ defaults: { ease: 'power3.out', duration: 1 } });

    // 애니메이션 시작
    if (hero) {
      tl.from(hero, { opacity: 0, y: 50 });
    }

    if (elements.length) {
      tl.from(elements, {
        opacity: 0,
        y: 30,
        stagger: 0.1,
        duration: 0.8
      }, "-=0.5");
    }

    // 기타 영상 자동 재생
    const videos = document.querySelectorAll(".elementor-video");
    videos.forEach(video => {
      try {
        video.play();
      } catch (e) {
        console.warn("Video autoplay failed:", e);
      }
    });

  // Elementor 위젯 JS 재실행 (보통 필요 없음, fallback용)
  if (typeof elementorFrontend !== 'undefined') {
    elementorFrontend.hooks.doAction("frontend/init");
    elementorFrontend.init();
  }
});
