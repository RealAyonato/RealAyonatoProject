@extends('layouts.app')

@push('styles')
<style>
  #home { 
    height: 100vh; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    background: transparent; 
    position: relative;
    z-index: 2;
    overflow: hidden; 
  }
  
  .hero-container {
    display: flex;
    flex-direction: column;
    width: 100%;
    gap: 40px;
    position: relative;
  }

  .hero-grid { 
    display: grid; 
    grid-template-columns: 1.15fr 0.85fr; 
    gap: 60px; 
    align-items: center; 
    width: 100%; 
  }
  
  .hero-title { 
    font-family: var(--fd); 
    font-size: clamp(3rem, 6.5vw, 4.5rem); 
    line-height: 1.15; 
    margin-bottom: 24px; 
    letter-spacing: -0.01em;
    color: #fff;
  }
  
  .glitch {
    font-family: 'Arial Black', sans-serif;
    color: #ff4d4d; 
    position: relative;
    display: inline-block;
    line-height: 1.15;
    animation: slowBodyShake 7s infinite steps(1);
  }

  .glitch::before, .glitch::after {
    content: attr(data-text);
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    white-space: nowrap;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    opacity: 0;
  }

  .glitch::before {
    animation: slowSliceTop 7s infinite linear;
    clip-path: inset(0 0 65% 0);
    text-shadow: -2px 0 rgba(0, 255, 255, 0.6);
  }

  .glitch::after {
    animation: slowSliceBottom 7s infinite linear;
    clip-path: inset(65% 0 0 0);
    text-shadow: 2px 0 rgba(255, 0, 200, 0.6);
  }

  @keyframes slowBodyShake {
    0%, 95%, 100% { transform: translate(0, 0) skew(0deg); }
    96% { transform: translate(-2px, 1px) skew(-1deg); }
    98% { transform: translate(2px, -1px) skew(1deg); }
  }

  @keyframes slowSliceTop {
    0%, 94%, 100% { transform: translate(0); opacity: 0; }
    95% { transform: translate(-5px, -1px); opacity: 0.65; clip-path: inset(10% 0 60% 0); }
    97% { transform: translate(4px, 1px); opacity: 0.65; clip-path: inset(25% 0 45% 0); }
  }

  @keyframes slowSliceBottom {
    0%, 94%, 100% { transform: translate(0); opacity: 0; }
    95% { transform: translate(4px, 1px); opacity: 0.65; clip-path: inset(60% 0 10% 0); }
    97% { transform: translate(-4px, -1px); opacity: 0.65; clip-path: inset(45% 0 25% 0); }
  }
  
  .hero-desc-box {
    background: linear-gradient(90deg, rgba(220, 38, 38, 0.04) 0%, rgba(0,0,0,0.2) 100%); 
    border-left: 3px solid var(--red); 
    padding: 20px 24px; 
    border-radius: 0 14px 14px 0; 
    text-align: left;
    max-width: 540px;
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    border-top: 1px solid rgba(255,255,255,0.01);
    border-bottom: 1px solid rgba(255,255,255,0.01);
  }
  
  .hero-desc { 
    color: var(--g400); 
    margin-bottom: 0; 
    font-size: 0.96rem; 
    line-height: 1.7;
    font-weight: 500;
  }
  
  .hero-btn-wrapper {
    position: relative;
    width: 100%;
    display: flex;
    flex-direction: column; 
    align-items: center;
    gap: 16px;
    margin-top: 60px; 
  }

  .cartoon-badge {
    position: absolute;
    top: 55px; 
    left: -70px; 
    font-family: 'Comic Sans MS', 'Arial Black', sans-serif;
    font-size: 1.35rem;
    font-weight: 900;
    color: #ffffff;
    text-shadow: 2px 2px 0px #000000;
    transform: rotate(12deg); 
    pointer-events: none;
    user-select: none;
    animation: badgeFloat 3s infinite ease-in-out;
  }

  @keyframes badgeFloat {
    0%, 100% { transform: rotate(12deg) translateY(0); }
    50% { transform: rotate(14deg) translateY(-6px); }
  }

  .drawing-arrow {
    position: absolute;
    top: -5px; 
    left: 0px; 
    width: 200px; 
    height: 75px;
    pointer-events: none;
    transform: rotate(-5deg); 
    animation: arrowFloat 3s infinite ease-in-out;
  }

  .drawing-arrow path {
    stroke: #dc2626; 
    stroke-width: 3.5;
    stroke-linecap: round;
    stroke-linejoin: round;
    fill: none;
    stroke-dasharray: 280;
    stroke-dashoffset: 280;
    animation: drawAndErase 4s infinite ease-in-out;
  }

  @keyframes arrowFloat {
    0%, 100% { transform: rotate(-5deg) translateY(0); }
    50% { transform: rotate(-4deg) translateY(-6px); }
  }

  @keyframes drawAndErase {
    0% { stroke-dashoffset: 280; opacity: 0; }
    15% { opacity: 1; }
    50%, 75% { stroke-dashoffset: 0; opacity: 1; }
    92% { stroke-dashoffset: -280; opacity: 0; }
    100% { stroke-dashoffset: -280; opacity: 0; }
  }

  .hero-btn-group {
    display: flex; 
    gap: 16px; 
    flex-wrap: wrap; 
    justify-content: center;
    width: 100%;
  }
  
  .hero-btn-group .btn, .hero-btn-single .btn {
    padding: 14px 32px;
    font-size: 0.92rem;
    letter-spacing: 0.04em;
    border-radius: 12px;
    text-transform: none !important; 
    font-weight: 600 !important; 
    position: relative;
    transition: all var(--transition);
  }

  .hero-btn-single {
    display: flex;
    justify-content: center;
    width: 100%;
  }

  .av-wrap { 
    display: flex; 
    justify-content: flex-end; 
    position: relative;
  }

  .av-wrap::before {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    background: rgba(220, 38, 38, 0.15);
    filter: blur(70px);
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 0;
    pointer-events: none;
  }
  
  .av-con { 
    position: relative; 
    width: 400px; 
    display: flex;
    flex-direction: column;
    align-items: center;
    animation: heroLogoAnim 6s infinite ease-in-out; 
    will-change: transform; 
    z-index: 2;
  }
  
  @keyframes heroLogoAnim {
    0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); }
    25% { transform: translateY(-12px) scale(1.01) rotate(1.5deg); }
    50% { transform: translateY(-22px) scale(0.98) rotate(-1deg); }
    75% { transform: translateY(-10px) scale(1.01) rotate(0.5deg); }
  }
  
  .av-ring { 
    width: 260px; 
    height: 260px; 
    border-radius: 40px; 
    border: 3px solid rgba(220,38,38,0.45); 
    overflow: hidden; 
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.65), 0 0 35px rgba(220, 38, 38, 0.2); 
    margin-bottom: 24px;
    background: var(--g900);
    position: relative;
    z-index: 2;
  }

  /* حماية الصور عبر الـ CSS ومنع التحديد أو التحميل بالحفظ المطول */
  .av-ring img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover;
    pointer-events: none; /* تمنع أي تفاعل مباشر أو سحب للأسفل */
    -webkit-user-drag: none; 
    user-select: none;
    -webkit-touch-callout: none; /* تمنع ظهور قائمة الحفظ على هواتف الآيفون والأندرويد */
  }
  
  .hero-dynamic-text { 
    font-family: var(--fb); 
    font-size: 1.95rem; 
    font-weight: 900;
    letter-spacing: 0.05em; 
    height: 2.8rem; 
    line-height: 2.8rem;
    display: flex; 
    align-items: center; 
    justify-content: center;
    overflow: hidden;
    position: relative;
    z-index: 2;
  }
  .h-cursor-bar { display: inline-block; width: 3px; height: 0.75em; background: #dc2626; margin-left: 6px; vertical-align: middle; animation: hBlink 0.7s step-end infinite; }
  @keyframes hBlink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }

  .sketch-arrow {
    position: absolute;
    width: 80px; 
    height: 80px;
    z-index: 3; 
    pointer-events: none;
    transition: transform 0.2s ease;
  }

  .arrow-top-left { top: -55px; left: -5px; animation: arrowMoveTL 1.8s infinite ease-in-out; }
  .arrow-top-right { top: -55px; right: -5px; transform: scaleX(-1); animation: arrowMoveTR 1.8s infinite ease-in-out; }
  .arrow-bottom-left { bottom: 25px; left: -5px; transform: scaleY(-1); animation: arrowMoveBL 1.8s infinite ease-in-out; }
  .arrow-bottom-right { bottom: 25px; right: -5px; transform: scale(-1); animation: arrowMoveBR 1.8s infinite ease-in-out; }

  @keyframes arrowMoveTL {
    0%, 100% { transform: translate(0, 0); opacity: 0.7; }
    50% { transform: translate(8px, 8px); opacity: 1; }
  }
  @keyframes arrowMoveTR {
    0%, 100% { transform: scaleX(-1) translate(0, 0); opacity: 0.7; }
    50% { transform: scaleX(-1) translate(8px, 8px); opacity: 1; }
  }
  @keyframes arrowMoveBL {
    0%, 100% { transform: scaleY(-1) translate(0, 0); opacity: 0.7; }
    50% { transform: scaleY(-1) translate(8px, 8px); opacity: 1; }
  }
  @keyframes arrowMoveBR {
    0%, 100% { transform: scale(-1) translate(0, 0); opacity: 0.7; }
    50% { transform: scale(-1) translate(8px, 8px); opacity: 1; }
  }

  @media (max-width: 992px) { 
    #home { height: auto; padding: 60px 0; }
    .hero-grid { grid-template-columns: 1fr; text-align: center; gap: 45px; } 
    .av-wrap { justify-content: center; } 
    .av-con { width: 300px; }
    .hero-desc-box { margin: 0 auto; border-radius: 12px; border-left: none; border-top: 3px solid var(--red); text-align: center; }
    .sketch-arrow, .cartoon-badge, .drawing-arrow { display: none; } 
    .hero-container { gap: 35px; }
  }
</style>
@endpush

@section('content')
<section id="home">
  <div class="container">
    <div class="hero-container">
      
      <div class="hero-grid">
        
        <div>
          <h1 class="hero-title">
            Roblox Visuals<br>
            <span class="glitch" data-text="That Stop The Scroll">That Stop<br>The Scroll</span>
          </h1>
          
          <div class="hero-desc-box">
              <p class="hero-desc">
                  I am RealAyonato, a professional Roblox graphic designer. I specialize in crafting high-quality thumbnails, GFX, and complete visual identities that grab attention and drive clicks. Every pixel here serves a purpose.
              </p>
          </div>
        </div>
        
        <div class="av-wrap">
          <div class="av-con">
            
            <svg class="sketch-arrow arrow-top-left" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4L16 16M16 16V8M16 16H8" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M7 4L17 14" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" opacity="0.5"/>
            </svg>

            <svg class="sketch-arrow arrow-top-right" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4L16 16M16 16V8M16 16H8" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M7 4L17 14" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" opacity="0.5"/>
            </svg>

            <div class="av-ring">
              <img src="https://i.postimg.cc/qqJzc822/logo.webp" alt="RealAyonato">
            </div>

            <svg class="sketch-arrow arrow-bottom-left" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4L16 16M16 16V8M16 16H8" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M7 4L17 14" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" opacity="0.5"/>
            </svg>

            <svg class="sketch-arrow arrow-bottom-right" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4L16 16M16 16V8M16 16H8" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M7 4L17 14" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" opacity="0.5"/>
            </svg>

            <div class="hero-dynamic-text" id="hero-type-word">
              <span class="h-cursor-bar"></span>
            </div>
            
          </div>
        </div>

      </div>

      <div class="hero-btn-wrapper">
        
        <div class="cartoon-badge">New Designs!</div>
        
        <svg class="drawing-arrow" viewBox="0 0 110 60" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <path d="M 5,42 C 25,38 45,30 52,32 C 62,35 60,52 48,50 C 35,48 42,28 65,22 C 78,18 92,20 102,24 M 92,15 L 104,25 L 88,32" />
        </svg>

        <div class="hero-btn-group">
          <a href="{{ url('/portfolio') }}" class="btn btnp"><i class="fas fa-palette"></i> Portfolio</a>
          <a href="{{ url('/service') }}" class="btn btno"><i class="fas fa-tags"></i> Services</a>
          <a href="{{ url('/feedback') }}" class="btn btno"><i class="fas fa-star"></i> Feedback</a>
          <a href="{{ url('/faq') }}" class="btn btno"><i class="fas fa-question-circle"></i> FAQ</a>
        </div>

        <div class="hero-btn-single">
          <a href="{{ url('/contact') }}" class="btn btno"><i class="fas fa-envelope"></i> Contact</a>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  (function() {
    const wordDiv = document.getElementById('hero-type-word');
    const cursor = wordDiv ? wordDiv.querySelector('.h-cursor-bar') : null;
    if(!wordDiv || !cursor) return;

    const nameChars = [
      ['R','#fff'], ['e','#fff'], ['a','#fff'], ['l','#fff'],
      ['A','#dc2626'], ['y','#dc2626'], ['o','#dc2626'], ['n','#dc2626'], ['a','#dc2626'], ['t','#dc2626'], ['o','#dc2626']
    ];
    
    let isDeleting = false;
    let charIdx = 0;
    let typeTimeout = null;

    function typeEffect() {
      if (document.hidden) return;

      if (!isDeleting && charIdx <= nameChars.length) {
        if (charIdx < nameChars.length) {
          const span = document.createElement('span');
          span.textContent = nameChars[charIdx][0];
          span.style.color = nameChars[charIdx][1];
          span.className = 'char-item';
          wordDiv.insertBefore(span, cursor);
        }
        charIdx++;

        if (charIdx > nameChars.length) {
          typeTimeout = setTimeout(() => { isDeleting = true; typeEffect(); }, 3000);
          return;
        }
        typeTimeout = setTimeout(typeEffect, 120);
      } else {
        const spans = wordDiv.querySelectorAll('.char-item');
        if (spans.length > 0) {
          spans[spans.length - 1].remove();
          charIdx--;
          typeTimeout = setTimeout(typeEffect, 60);
        } else {
          isDeleting = false;
          charIdx = 0;
          typeTimeout = setTimeout(typeEffect, 500);
        }
      }
    }

    typeTimeout = setTimeout(typeEffect, 400);

    document.addEventListener('visibilitychange', function() {
      if (!document.hidden) {
        clearTimeout(typeTimeout);
        wordDiv.querySelectorAll('.char-item').forEach(el => el.remove());
        isDeleting = false;
        charIdx = 0;
        typeEffect();
      }
    });

    // جدار الحماية البرمجي: منع فتح القائمة بزر الفأرة الأيمن ومنع سحب الصور تماماً
    document.addEventListener('contextmenu', function(e) {
      e.preventDefault();
    });

    document.querySelectorAll('img').forEach(img => {
      img.addEventListener('dragstart', function(e) {
        e.preventDefault();
      });
      // إضافي للهواتف الذكية لمنع ظهور قائمة الحفظ عند الضغط المطول
      img.addEventListener('contextmenu', function(e) {
        e.preventDefault();
      });
    });
  })();
</script>
@endpush