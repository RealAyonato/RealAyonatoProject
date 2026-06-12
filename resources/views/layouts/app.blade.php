<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>@yield('title', 'RealAyonato')</title>

<link class="js-fav" rel="icon" type="image/x-icon" href="/favicon.ico">
<link class="js-fav" rel="shortcut icon" href="/favicon.ico">

@php
    $currentPath = request()->path();
    $coverImage = asset('hero_cover.jpg'); 

    if ($currentPath === 'portfolio') {
        $coverImage = asset('portfolio_cover.jpg');
    } elseif ($currentPath === 'service' || $currentPath === 'services') {
        $coverImage = asset('services_cover.jpg');
    } elseif ($currentPath === 'feedback') {
        $coverImage = asset('feedback_cover.jpg');
    } elseif ($currentPath === 'faq') {
        $coverImage = asset('faq_cover.jpg');
    } elseif ($currentPath === 'contact') {
        $coverImage = asset('contact_cover.jpg');
    }
@endphp

<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('meta_title', 'RealAyonato')">
<meta property="og:description" content="@yield('meta_description', 'Premium Roblox GFX and thumbnails by RealAyonato. Designed to stop the scroll.')">
<meta property="og:image" content="@yield('meta_image', $coverImage)">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('meta_title', 'RealAyonato — Roblox Visual Portfolio')">
<meta name="twitter:description" content="@yield('meta_description', 'Explore my official portfolio featuring GFX designs, Roblox UI interfaces, and visual arts.')">
<meta name="twitter:image" content="@yield('meta_image', $coverImage)">

<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --red: #dc2626; --red-glow: rgba(220, 38, 38, 0.4); --bg: #0a0a0a; --g950: #080808; 
    --g900: #111111; --g800: #1a1a1a; --g700: #252525; --g500: #6b7280; --g400: #9ca3af; 
    --g300: #d1d5db; --white: #ffffff; 
    --fd: 'Bebas Neue', sans-serif; --fb: 'Nunito', sans-serif; 
    --transition: 0.3s cubic-bezier(0.25, 1, 0.5, 1);
  }
  
  html { 
    scroll-behavior: auto !important;
    height: 100%;
  }
  
  /* قفل السكرول الصارم أثناء التحميل */
  html.loading-active, body.loading-active {
    overflow: hidden !important;
    height: 100% !important;
  }
  
  body { 
    background: var(--bg); color: var(--white); font-family: var(--fb); line-height: 1.6; overflow-x: hidden; 
    background-image: radial-gradient(circle at 75% 35%, rgba(220,38,38,0.05) 0%, transparent 55%);
    background-attachment: fixed;
    height: 100%;
    padding-top: 85px; 
  }
  body::before {
    content: ''; position: fixed; inset: 0; opacity: 0.025; pointer-events: none; z-index: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  }

  /* إخفاء شريط المتصفح الافتراضي الأصلي */
  html::-webkit-scrollbar, body::-webkit-scrollbar {
    display: none;
    width: 0 !important;
  }
  html, body {
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  /* منطقة الاستشعار الخلفية للشريط المخصص */
  .custom-scrollbar-track {
    position: fixed;
    top: 0;
    right: 0;
    width: 10px;
    height: 100%;
    background: transparent;
    z-index: 999999999; 
    user-select: none;
    display: none; /* يظهر فقط عبر الـ JS بعد التحميل */
  }
  
  /* مقبض الشريط المخصص */
  .custom-scrollbar-thumb {
    position: absolute;
    top: 0;
    right: 0;
    width: 8px;
    height: 50px; 
    background: rgba(255, 255, 255, 0.25);
    border-radius: 4px 0 0 4px;
    cursor: pointer;
    will-change: transform, height;
    transition: width 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
  }
  
  .custom-scrollbar-track:hover .custom-scrollbar-thumb, .custom-scrollbar-track.dragging .custom-scrollbar-thumb {
    width: 10px;
    background-color: var(--red);
    box-shadow: -2px 0 12px var(--red-glow), 0 0 8px var(--red);
  }

  body.user-is-dragging-scroll {
    user-select: none !important;
    -webkit-user-select: none !important;
    cursor: grabbing !important;
  }

  /* Loading Screen */
  #loading { position: fixed; inset: 0; background: #000; z-index: 99999999; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.55s ease; }
  #loading.gone { opacity: 0; pointer-events: none; visibility: hidden; }
  .ld-logo { width: 72px; height: 72px; border-radius: 50%; border: 3px solid #dc2626; animation: ldPulse 1.2s ease-in-out infinite; margin-bottom: 20px; }
  @keyframes ldPulse { 0%, 100% { box-shadow: 0 0 0 0 rgba(220,38,38,.4); } 70% { box-shadow: 0 0 0 16px rgba(220,38,38,0); } }
  #ld-word { font-family: 'Arial Black', Impact, sans-serif; font-size: clamp(2rem, 6vw, 3rem); letter-spacing: 0.06em; margin-bottom: 6px; min-height: 3.5rem; display: flex; align-items: center; }
  .ld-dot { color: #555; font-size: 0.72rem; letter-spacing: 0.18em; text-transform: uppercase; opacity: 0; transition: opacity 0.3s; }
  .ld-cursor-bar { display: inline-block; width: 3px; height: 0.75em; background: #dc2626; margin-left: 3px; vertical-align: middle; animation: ldBlink 0.7s step-end infinite; }
  @keyframes ldBlink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }

  /* الهيدر الثابت الملتصق بالأعلى */
  .top-header { 
    padding: 24px 0; 
    position: fixed !important; 
    top: 0 !important; 
    left: 0 !important;
    right: 0 !important;
    width: 100%;
    margin: 0 !important;
    z-index: 9999999 !important; 
    background: linear-gradient(to bottom, rgba(10,10,10,0.95), rgba(10,10,10,0.75)) !important; 
    backdrop-filter: blur(14px) !important; 
    -webkit-backdrop-filter: blur(14px) !important; 
    border-bottom: 1px solid rgba(255, 255, 255, 0.02);
  }
  .top-header-in { display: flex; justify-content: space-between; align-items: center; width: 100%; }
  
  .top-header, .mobile-burger-btn, .pop-nav-menu {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
  }

  .who-am-i-btn { 
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem; 
    font-weight: 800; 
    text-transform: uppercase; 
    letter-spacing: 0.12em; 
    color: var(--g400); 
    text-decoration: none; 
    transition: color var(--transition); 
  }
  .who-am-i-btn i { transition: transform var(--transition); }
  .who-am-i-btn span { display: inline-block; transition: transform var(--transition); }
  .who-am-i-btn:hover { color: var(--red); text-shadow: 0 0 8px var(--red-glow); }
  .who-am-i-btn:hover span { transform: translateX(6px); }

  .top-nav-links {
    display: flex;
    align-items: center;
    gap: 24px; 
    margin-left: auto;
  }
  .top-nav-links a {
    font-size: 0.85rem; 
    font-weight: 800; 
    text-transform: uppercase; 
    letter-spacing: 0.12em; 
    text-decoration: none; 
    color: var(--g400); 
    transition: all var(--transition);
    position: relative;
    padding: 6px 0;
  }
  .top-nav-links a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: var(--red);
    box-shadow: 0 0 8px var(--red);
    transition: all var(--transition);
    transform: translateX(-50%);
  }
  .top-nav-links a:hover { color: var(--white); }
  .top-nav-links a.active-page { color: var(--white) !important; font-weight: 900; }
  .top-nav-links a.active-page::after, .top-nav-links a:hover::after { width: 100%; }

  .mobile-burger-btn {
    display: none;
    background: none;
    border: none;
    color: var(--white);
    font-size: 1.5rem;
    cursor: pointer;
    padding: 8px;
    transition: color var(--transition);
    z-index: 10000000 !important;
  }
  .mobile-burger-btn:hover { color: var(--red); }

  .pop-nav-menu {
    position: fixed;
    inset: 0;
    background: rgba(5, 5, 5, 0.75);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    z-index: 10000001 !important;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.4s cubic-bezier(0.25, 1, 0.5, 1);
  }
  .pop-nav-menu.open { opacity: 1; pointer-events: auto; }
  .pop-close-btn {
    position: absolute;
    top: 24px;
    right: 24px;
    background: none;
    border: none;
    color: var(--g400);
    font-size: 1.8rem;
    cursor: pointer;
    transition: color 0.3s ease, transform 0.3s ease;
  }
  .pop-close-btn:hover { color: var(--red); transform: rotate(90deg); }
  .pop-links-wrapper {
    display: flex;
    flex-direction: column;
    gap: 30px;
    text-align: center;
    transform: translateY(20px);
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
  }
  .pop-nav-menu.open .pop-links-wrapper { transform: translateY(0); }
  .pop-links-wrapper a {
    font-family: var(--fd);
    font-size: 2.5rem;
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--g400);
    text-decoration: none;
    transition: all var(--transition);
    position: relative;
  }
  .pop-links-wrapper a:hover, .pop-links-wrapper a.active-page {
    color: var(--white);
    text-shadow: 0 0 15px var(--red-glow);
    transform: scale(1.05);
  }

  .bg-icon { position: fixed; pointer-events: none; z-index: 0; color: transparent; -webkit-text-stroke: 1.5px rgba(220,38,38,0.2); animation: floatEmj var(--dur, 16s) var(--delay, 0s) infinite ease-in-out; }
  @keyframes floatEmj { 0% { transform: translateY(0px) rotate(-8deg); } 25% { transform: translateY(-30px) rotate(5deg); } 50% { transform: translateY(-52px) rotate(-4deg); } 75% { transform: translateY(-24px) rotate(7deg); } 100% { transform: translateY(0px) rotate(-8deg); } }

  .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 1; }
  .section { padding: 40px 0 90px; position: relative; z-index: 1; }
  .sdark { background: rgba(11, 11, 11, 0.55); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.03); }
  
  .badge { display: inline-flex; align-items: center; gap: 8px; color: var(--red); margin-bottom: 14px; }
  .bdl { width: 32px; height: 2px; background: var(--red); box-shadow: 0 0 6px var(--red); }
  .bt { font-size: 11px; font-weight: 900; letter-spacing: 0.25em; text-transform: uppercase; }
  .stitle { font-family: var(--fd); font-size: clamp(3rem, 7vw, 5rem); line-height: 1; letter-spacing: 0.02em; margin-bottom: 16px; text-transform: uppercase; }
  .stitle span { color: var(--red); text-shadow: 0 0 20px rgba(220, 38, 38, 0.2); }
  .ssub { color: var(--g400); font-size: 1.05rem; max-width: 600px; margin: 0 auto 40px; line-height: 1.8; }
  .sheader { text-align: center; margin-bottom: 50px; }

  .card { background: rgba(17, 17, 17, 0.45); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border: 1px solid var(--g800); border-radius: 16px; transition: all var(--transition); }
  .card:hover { border-color: rgba(220, 38, 38, 0.4); background: rgba(20, 20, 20, 0.6); transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.4); }
  
  .btn { display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; border-radius: 30px; font-weight: 800; font-size: 0.9rem; transition: all var(--transition); cursor: pointer; border: none; font-family: inherit; text-decoration: none; text-transform: uppercase; letter-spacing: 0.05em; }
  .btnp { background: var(--red); color: #fff; box-shadow: 0 4px 15px rgba(220,38,38,0.2); }
  .btnp:hover { background: #ef4444; transform: translateY(-3px); box-shadow: 0 8px 24px rgba(220,38,38,0.45); }
  .btno { border: 1px solid rgba(255, 255, 255, 0.15); color: #fff; background: transparent; }
  .btno:hover { border-color: var(--red); color: var(--white); background: rgba(220,38,38,0.08); box-shadow: 0 0 15px var(--red-glow); transform: translateY(-2px); }
  
  .soc-ic { width: 36px; height: 36px; border-radius: 50%; border: 1px solid var(--g700); display: inline-flex; align-items: center; justify-content: center; color: var(--g400); transition: all var(--transition); text-decoration: none; }
  .soc-ic:hover { border-color: var(--red); color: var(--white); background: var(--red); transform: translateY(-3px); box-shadow: 0 5px 15px var(--red-glow); }

  footer { padding: 50px 0; border-top: 1px solid rgba(255,255,255,0.03); background: var(--g950); position: relative; z-index: 10; }
  .foot-in { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
  .foot-logo-link { text-decoration: none; color: inherit; display: inline-block; }
  .foot-logo-link:hover { opacity: 0.9; }
  .foot-logo { display: flex; align-items: center; gap: 10px; font-weight: 900; letter-spacing: 0.03em; font-size: 1.1rem; }
  .foot-logo img { border-radius: 50%; border: 1px solid rgba(255,255,255,0.1); }
  .foot-logo span.art-brand { color: var(--red); text-shadow: 0 0 8px var(--red-glow); } 
  .foot-copy { color: var(--g500); font-size: 0.82rem; font-weight: 500; }
  .foot-socs { display: flex; gap: 16px; align-items: center; }
  .foot-soc { color: var(--g400); font-size: 1.25rem; transition: all 0.25s ease; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
  .foot-soc:hover { color: var(--white) !important; transform: translateY(-3px) scale(1.1); filter: drop-shadow(0 0 5px var(--red)); }

  @media (max-width: 768px) {
    body { padding-top: 75px; }
    .top-header { padding: 16px 0; }
    .top-header-in { flex-direction: row; justify-content: space-between; align-items: center; text-align: left; }
    .top-nav-links { display: none !important; } 
    .mobile-burger-btn { display: block; } 
    .foot-in { flex-direction: column; text-align: center; gap: 24px; }
    .custom-scrollbar-track { display: none !important; } 
  }
</style>
<script>
  // تفعيل قفل السكرول الصارم فوراً قبل بناء شجرة الـ DOM لمنع أي نزول مفاجئ
  document.documentElement.classList.add('loading-active');
</script>
@stack('styles')
</head>
<body class="loading-active">

{{-- شريط التمرير المخصص --}}
<div class="custom-scrollbar-track" id="scrollTrack">
  <div class="custom-scrollbar-thumb" id="scrollThumb"></div>
</div>

<div id="loading">
  <img class="ld-logo" src="https://i.postimg.cc/qqJzc822/logo.webp" alt="logo">
  <div id="ld-word"><span class="ld-cursor-bar"></span></div>
  <div class="ld-dot">.art</div>
</div>

@if(request()->path() !== '/' && request()->path() !== '')
<div class="top-header">
  <div class="container top-header-in">
    
    <a href="{{ url('/') }}" class="who-am-i-btn">
      <i class="fas fa-arrow-left"></i>
      <span>Who Am I ?</span>
    </a>

    <div class="top-nav-links">
      <a href="{{ url('/portfolio') }}" class="{{ request()->is('portfolio') ? 'active-page' : '' }}">Portfolio</a>
      <a href="{{ url('/service') }}" class="{{ request()->is('service') ? 'active-page' : '' }}">Services</a>
      <a href="{{ url('/feedback') }}" class="{{ request()->is('feedback') ? 'active-page' : '' }}">Feedback</a>
      <a href="{{ url('/faq') }}" class="{{ request()->is('faq') ? 'active-page' : '' }}">FAQ</a>
      <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active-page' : '' }}">Contact</a>
    </div>

    <button class="mobile-burger-btn" id="burgerBtn" aria-label="Open Navigation Menu">
      <i class="fas fa-bars"></i>
    </button>

  </div>
</div>

<div class="pop-nav-menu" id="popNavMenu">
  <button class="pop-close-btn" id="popCloseBtn" aria-label="Close Navigation Menu">
    <i class="fas fa-times"></i>
  </button>
  <div class="pop-links-wrapper">
    <a href="{{ url('/portfolio') }}" class="{{ request()->is('portfolio') ? 'active-page' : '' }}">Portfolio</a>
    <a href="{{ url('/service') }}" class="{{ request()->is('service') ? 'active-page' : '' }}">Services</a>
    <a href="{{ url('/feedback') }}" class="{{ request()->is('feedback') ? 'active-page' : '' }}">Feedback</a>
    <a href="{{ url('/faq') }}" class="{{ request()->is('faq') ? 'active-page' : '' }}">FAQ</a>
    <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active-page' : '' }}">Contact</a>
  </div>
</div>
@endif

@yield('content')

<footer>
  <div class="container">
    <div class="foot-in">
      <a href="{{ url('/') }}" class="foot-logo-link" id="foot-brand-trigger">
        <div class="foot-logo">
          <img src="https://i.postimg.cc/qqJzc822/logo.webp" width="38" height="38" alt="logo">
          RealAyonato<span class="art-brand">.art</span>
        </div>
      </a>
      <div>
        <p class="foot-copy">© <span id="yr"></span> RealAyonato. All rights reserved.</p>
      </div>
      <div class="foot-socs">
        <a href="https://discord.gg/HC2xDx3FyN" target="_blank" class="foot-soc" aria-label="Discord"><i class="fab fa-discord"></i></a>
        <a href="https://www.instagram.com/realayonato/" target="_blank" class="foot-soc" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://x.com/RealAyonato" target="_blank" class="foot-soc" aria-label="X (Twitter)"><i class="fab fa-x-twitter"></i></a>
        <a href="https://www.youtube.com/@RealAyonato" target="_blank" class="foot-soc" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        <a href="https://www.tiktok.com/@realayonato_" target="_blank" class="foot-soc" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
      </div>
    </div>
  </div>
</footer>

<script>
  // مصفوفة وظائف ستنفذ فور تفعيل شريط التمرير المخصص
  let globalTriggerScrollUpdate = function() {};

  (function() {
    const ld = document.getElementById('loading');
    const wordDiv = document.getElementById('ld-word');
    const cursor = wordDiv.querySelector('.ld-cursor-bar');
    const track = document.getElementById("scrollTrack");
    const nameChars = [['R','#fff'],['e','#fff'],['a','#fff'],['l','#fff'],['A','#dc2626'],['y','#dc2626'],['o','#dc2626'],['n','#dc2626'],['a','#dc2626'],['t','#dc2626'],['o','#dc2626']];
    let idx = 0;
    
    // إرجاع النافذة لـ 0 مجدداً بشكل صارم قبل أي معالجة بصرية
    window.scrollTo(0, 0);

    function addChar() {
      if (idx >= nameChars.length) {
        const dot = document.querySelector('.ld-dot');
        if(dot) dot.style.opacity = '1';
        
        setTimeout(() => { 
          if(ld) ld.classList.add('gone'); 
          
          // فتح السكرول وإصلاح مشكلة الحسابات المغلوطة
          document.documentElement.classList.remove('loading-active');
          document.body.classList.remove('loading-active');
          
          if(track && window.innerWidth > 768) {
            track.style.display = "block";
          }

          // استدعاء دالة تحديث الحجم فوراً بعد انتهاء شاشة التحميل للحصول على الطول المثالي
          globalTriggerScrollUpdate();

          setTimeout(() => { if(ld) ld.remove(); }, 550); 
        }, 400);
        return;
      }
      if(wordDiv && cursor) {
        const span = document.createElement('span');
        span.textContent = nameChars[idx][0];
        span.style.color = nameChars[idx][1];
        wordDiv.insertBefore(span, cursor);
      }
      idx++;
      setTimeout(addChar, 80);
    }
    addChar();
    document.getElementById('yr').textContent = new Date().getFullYear();
  })();

  document.addEventListener("DOMContentLoaded", () => {
    const burgerBtn = document.getElementById("burgerBtn");
    const popCloseBtn = document.getElementById("popCloseBtn");
    const popNavMenu = document.getElementById("popNavMenu");

    if (burgerBtn && popNavMenu && popCloseBtn) {
      burgerBtn.addEventListener("click", () => {
        popNavMenu.classList.add("open");
        document.body.style.overflow = "hidden"; 
      });

      const closeMenu = () => {
        popNavMenu.classList.remove("open");
        if(!document.body.classList.contains('loading-active')) {
          document.body.style.overflow = ""; 
        }
      };

      popCloseBtn.addEventListener("click", closeMenu);
      popNavMenu.querySelectorAll(".pop-links-wrapper a").forEach(link => {
        link.addEventListener("click", closeMenu);
      });
    }

    const track = document.getElementById("scrollTrack");
    const thumb = document.getElementById("scrollThumb");
    if (!track || !thumb) return;

    let isDragging = false;
    let startY = 0;
    let startScrollTop = 0;
    let ticked = false;

    function updateScrollbar() {
      // إيقاف المعالجة إذا كان المستخدم لا يزال عالقاً في شاشة التحميل
      if (document.body.classList.contains('loading-active')) return;

      const windowHeight = window.innerHeight;
      const docHeight = document.documentElement.scrollHeight;
      const scrollTop = window.scrollY || document.documentElement.scrollTop;

      // حساب الارتفاع بنسبة وتناسب دقيق جداً ليعبر عن أبعاد الموقع الفعلية
      const thumbHeight = Math.max((windowHeight / docHeight) * windowHeight, 60);
      thumb.style.height = `${thumbHeight}px`;

      const maxTrackTop = windowHeight - thumbHeight;
      const maxScrollTop = docHeight - windowHeight;
      
      if (maxScrollTop > 0) {
        const thumbTop = (scrollTop / maxScrollTop) * maxTrackTop;
        thumb.style.transform = `translate3d(0, ${thumbTop}px, 0)`;
        if(window.innerWidth > 768) track.style.display = "block";
      } else {
        track.style.display = "none";
      }
      ticked = false;
    }

    // تصدير الدالة لتشغيلها بشكل خارجي عند إغلاق شاشة التحميل
    globalTriggerScrollUpdate = function() {
      updateScrollbar();
    };

    function requestTick() {
      if (!ticked) {
        requestAnimationFrame(updateScrollbar);
        ticked = true;
      }
    }

    thumb.addEventListener("mousedown", (e) => {
      if (document.body.classList.contains('loading-active')) return;
      isDragging = true;
      startY = e.clientY;
      startScrollTop = window.scrollY || document.documentElement.scrollTop;

      track.classList.add("dragging");
      document.body.classList.add("user-is-dragging-scroll");
      e.preventDefault(); 
    });

    window.addEventListener("mousemove", (e) => {
      if (!isDragging) return;

      const windowHeight = window.innerHeight;
      const docHeight = document.documentElement.scrollHeight;
      const thumbHeight = thumb.offsetHeight;

      const deltaY = e.clientY - startY;
      const maxTrackTop = windowHeight - thumbHeight;
      const maxScrollTop = docHeight - windowHeight;

      const currentThumbTop = ((startScrollTop / maxScrollTop) * maxTrackTop) + deltaY;
      const safeThumbTop = Math.max(0, Math.min(currentThumbTop, maxTrackTop));

      const targetScrollTop = (safeThumbTop / maxTrackTop) * maxScrollTop;
      window.scrollTo(0, targetScrollTop);
    });

    window.addEventListener("mouseup", () => {
      if (isDragging) {
        isDragging = false;
        track.classList.remove("dragging");
        document.body.classList.remove("user-is-dragging-scroll");
      }
    });

    window.addEventListener("scroll", requestTick, { passive: true });
    window.addEventListener("resize", requestTick, { passive: true });
    
    const resizeObserver = new ResizeObserver(() => requestTick());
    resizeObserver.observe(document.body);
  });
</script>
@stack('scripts')
</body>
</html>