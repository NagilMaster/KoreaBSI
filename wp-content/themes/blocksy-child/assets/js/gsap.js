// ScrollTrigger 플러그인 등록 필요
gsap.registerPlugin(ScrollTrigger);

// Elementor DOM 준비 후 실행
window.addEventListener('DOMContentLoaded', () => {
  const body = document.body;

  // front-page class가 body에 있는지 확인
//   if (body.classList.contains('home') || body.classList.contains('front-page')) {}


  const widgets = document.querySelectorAll('#main-container #main .elementor-widget');

  widgets.forEach((el, i) => {
    gsap.from(el, {
      scrollTrigger: {
        trigger: el,
        start: 'top 90%', // 뷰포트 아래쪽에서 시작
        toggleActions: 'play none none none'
      },
      opacity: 0,
      y: 40,
      duration: 1,
      ease: 'power3.out',
      delay: 0.3 // 순차적으로 보이도록 약간의 딜레이
    });
  });

  // 영상 자동 재생
  const videos = document.querySelectorAll(".elementor-video");
  videos.forEach(video => {
    try {
      video.play();
    } catch (e) {
      console.warn("Video autoplay failed:", e);
    }
  });

  // Elementor 위젯 JS 재실행 (보통 필요 없음, fallback용)
  // if (typeof elementorFrontend !== 'undefined') {
  //   elementorFrontend.hooks.doAction("frontend/init");
  //   elementorFrontend.init();
  // }
});

// Default Effect

// 플러그인 등록
gsap.registerPlugin(ScrambleTextPlugin);

// 사용할 글자 목록
const defaultChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';



/*
// 대상 요소 전부 선택
const chgWords = document.querySelectorAll('.chg-word');

// 이벤트 등록
chgWords.forEach(el => {
  el.addEventListener('mouseenter', () => {
    if (!gsap.isTweening(el)) {
      gsap.to(el, {
        duration: 0.8,
        ease: 'sine.in',
        scrambleText: {
          text: el.innerText,
          speed: 2,
          chars: defaultChars
        }
      });
    }
  });

  el.addEventListener('focus', () => {
    if (!gsap.isTweening(el)) {
      gsap.to(el, {
        duration: 0.8,
        ease: 'sine.in',
        scrambleText: {
          text: el.innerText,
          speed: 2,
          chars: defaultChars
        }
      });
    }
  });
});
*/
