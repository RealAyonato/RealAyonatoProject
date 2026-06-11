<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>@yield('title', 'RealAyonato.art — Roblox Visual Portfolio')</title>
<link rel="icon" href="https://i.postimg.cc/qqJzc822/logo.webp">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --red: #dc2626; --red-glow: rgba(220, 38, 38, 0.25); --bg: #0a0a0a; --g950: #080808; 
    --g900: #111111; --g800: #1a1a1a; --g700: #252525; --g500: #6b7280; --g400: #9ca3af; 
    --g300: #d1d5db; --white: #ffffff; 
    --fd: 'Bebas Neue', sans-serif; --fb: 'Nunito', sans-serif; 
    --transition: 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
  }
  html { scroll-behavior: smooth; }
  body { 
    background: var(--bg); color: var(--white); font-family: var(--fb); line-height: 1.6; overflow-x: hidden; 
    background-image: radial-gradient(circle at 75% 35%, rgba(220,38,38,0.04) 0%, transparent 55%);
    background-attachment: fixed;
  }
  body::before {
    content: ''; position: fixed; inset: 0; opacity: 0.025; pointer-events: none; z-index: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  }
  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: #000; }
  ::-webkit-scrollbar-thumb { background: var(--red); border-radius: 3px; }

  /* Loading Screen */
  #loading { position: fixed; inset: 0; background: #000; z-index: 99999; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.55s ease; }
  #loading.gone { opacity: 0; pointer-events: none; visibility: hidden; }
  .ld-logo { width: 72px; height: 72px; border-radius: 50%; border: 3px solid #dc2626; animation: ldPulse 1.2s ease-in-out infinite; margin-bottom: 20px; }
  @keyframes ldPulse { 0%, 100% { box-shadow: 0 0 0 0 rgba(220,38,38,.4); } 70% { box-shadow: 0 0 0 16px rgba(220,38,38,0); } }
  #ld-word { font-family: 'Arial Black', Impact, sans-serif; font-size: clamp(2rem, 6vw, 3rem); letter-spacing: 0.06em; margin-bottom: 6px; min-height: 3.5rem; display: flex; align-items: center; }
  .ld-dot { color: #555; font-size: 0.72rem; letter-spacing: 0.18em; text-transform: uppercase; opacity: 0; transition: opacity 0.3s; }
  .ld-cursor-bar { display: inline-block; width: 3px; height: 0.75em; background: #dc2626; margin-left: 3px; vertical-align: middle; animation: ldBlink 0.7s step-end infinite; }
  @keyframes ldBlink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }

  /* Top Header */
  .top-header { padding: 24px 0 0; position: relative; z-index: 10; }
  .top-header-in { display: flex; justify-content: space-between; align-items: center; width: 100%; }
  
  /* زر العودة للرئيسية */
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

  /* قائمة التصفح العلوية على اليمين */
  .top-nav-links {
    display: flex;
    align-items: center;
    gap: 22px; 
    margin-left: auto;
  }

  .top-nav-links a {
    font-size: 0.85rem; 
    font-weight: 800; 
    text-transform: uppercase; 
    letter-spacing: 0.12em; 
    text-decoration: none; 
    color: var(--white); 
    transition: color 0.2s ease, text-shadow 0.2s ease;
  }
  .top-nav-links a:hover { color: var(--red); }
  .top-nav-links a.active-page { color: var(--red) !important; text-shadow: 0 0 8px var(--red-glow); }

  /* Floating Icons */
  .bg-icon { position: fixed; pointer-events: none; z-index: 0; color: transparent; -webkit-text-stroke: 1.5px rgba(220,38,38,0.35); animation: floatEmj var(--dur, 16s) var(--delay, 0s) infinite ease-in-out; }
  @keyframes floatEmj { 0% { transform: translateY(0px) rotate(-8deg); } 25% { transform: translateY(-30px) rotate(5deg); } 50% { transform: translateY(-52px) rotate(-4deg); } 75% { transform: translateY(-24px) rotate(7deg); } 100% { transform: translateY(0px) rotate(-8deg); } }

  /* Global Section Styles */
  .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 1; }
  .section { padding: 50px 0 70px; position: relative; z-index: 1; }
  .sdark { background: rgba(7, 7, 7, 0.45); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); }
  
  .badge { display: inline-flex; align-items: center; gap: 8px; color: var(--red); margin-bottom: 14px; }
  .bdl { width: 44px; height: 2px; background: var(--red); }
  .bt { font-size: 10px; font-weight: 800; letter-spacing: 0.22em; text-transform: uppercase; }
  .stitle { font-family: var(--fd); font-size: clamp(2.8rem, 6vw, 4.8rem); line-height: 1; letter-spacing: 0.02em; margin-bottom: 14px; }
  .stitle span { color: var(--red); }
  .ssub { color: var(--g400); font-size: 1rem; max-width: 580px; margin: 0 auto; line-height: 1.75; }
  .sheader { text-align: center; margin-bottom: 40px; }

  /* Buttons & Cards */
  .card { background: rgba(17, 17, 17, 0.7); backdrop-filter: blur(4px); border: 1px solid var(--g800); border-radius: 12px; transition: border-color var(--transition); }
  .card:hover { border-color: rgba(220, 38, 38, 0.35); }
  .btn { display: inline-flex; align-items: center; gap: 8px; padding: 13px 26px; border-radius: 8px; font-weight: 700; font-size: 0.9rem; transition: all var(--transition); cursor: pointer; border: none; font-family: inherit; text-decoration: none; }
  .btnp { background: var(--red); color: #fff; }
  .btnp:hover { background: #ef4444; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(220,38,38,0.3); }
  .btno { border: 1px solid rgba(255, 255, 255, 0.18); color: #fff; }
  .btno:hover { border-color: var(--red); color: var(--red); }
  .soc-ic { width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--g700); display: inline-flex; align-items: center; justify-content: center; color: var(--g400); transition: all var(--transition); text-decoration: none; }
  .soc-ic:hover { border-color: var(--red); color: var(--red); }

  /* Footer Styling */
  footer { padding: 48px 0; border-top: 1px solid rgba(255,255,255,0.05); background: var(--g950); position: relative; z-index: 10; }
  .foot-in { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
  
  .foot-logo-link { text-decoration: none; color: inherit; display: inline-block; }
  .foot-logo-link:hover { opacity: 0.9; }
  
  .foot-logo { display: flex; align-items: center; gap: 8px; font-weight: 800; letter-spacing: 0.03em; }
  .foot-logo img { border-radius: 50%; }
  .foot-logo span.art-brand { color: var(--red); margin-left: 0; padding-left: 0; } 
  
  .foot-copy { color: var(--g500); font-size: 0.78rem; }
  .foot-socs { display: flex; gap: 14px; align-items: center; }
  .foot-soc { color: var(--g500); font-size: 1.2rem; transition: color 0.2s, transform 0.2s; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
  
  /* الهوفر الأحمر الموحد للسوشيال ميديا */
  .foot-soc:hover { color: var(--red) !important; transform: translateY(-2px); }
  .foot-soc:hover svg { transform: translateY(-1px) rotate(-5deg); transition: transform 0.2s ease; }

  @media (max-width: 768px) {
    .top-header-in { flex-direction: column; gap: 15px; text-align: center; }
    .top-nav-links { margin: 0 auto; gap: 14px; flex-wrap: wrap; justify-content: center; }
    .foot-in { flex-direction: column; text-align: center; gap: 24px; }
  }
</style>
@stack('styles')
</head>
<body>

<div id="loading">
  <img class="ld-logo" src="https://i.postimg.cc/qqJzc822/logo.webp" alt="logo">
  <div id="ld-word"><span class="ld-cursor-bar"></span></div>
  <div class="ld-dot">.art</div>
</div>

@hasSection('bg_icons')
  @yield('bg_icons')
@else
  <i class="bg-icon fas fa-gamepad" style="left:5%;top:10%;--dur:14s;font-size:72px"></i>
  <i class="bg-icon fas fa-paint-brush" style="left:86%;top:14%;--dur:18s;--delay:2s;font-size:64px"></i>
  <i class="bg-icon fas fa-star" style="left:3%;top:55%;--dur:12s;--delay:5s;font-size:56px"></i>
  <i class="bg-icon fas fa-magic" style="left:44%;top:5%;--dur:15s;--delay:7s;font-size:68px"></i>
@endif

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
        <a href="https://www.roblox.com/users/4266567536/profile" target="_blank" class="foot-soc" aria-label="Roblox">
          <svg viewBox="0 0 24 24" width="19" height="19" fill="currentColor">
            <path d="M5.126 0L0 18.874 18.874 24 24 5.126 5.126 0zm7.143 14.225l-2.482-.665.665-2.482 2.482.665-.665 2.482z"/>
          </svg>
        </a>
      </div>
      
    </div>
  </div>
</footer>

<script>
  (function() {
    const ld = document.getElementById('loading');
    const wordDiv = document.getElementById('ld-word');
    const cursor = wordDiv.querySelector('.ld-cursor-bar');
    const nameChars = [['R','#fff'],['e','#fff'],['a','#fff'],['l','#fff'],['A','#dc2626'],['y','#dc2626'],['o','#dc2626'],['n','#dc2626'],['a','#dc2626'],['t','#dc2626'],['o','#dc2626']];
    let idx = 0;
    
    function addChar() {
      if (idx >= nameChars.length) {
        document.querySelector('.ld-dot').style.opacity = '1';
        setTimeout(() => { if(ld) ld.classList.add('gone'); setTimeout(() => { if(ld) ld.remove(); }, 500); }, 400);
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
    setTimeout(() => { if(ld && ld.parentNode) ld.remove(); }, 4000);
    document.getElementById('yr').textContent = new Date().getFullYear();

    // منع القائمة المنبثقة للزر الأيمن للفأرة لحماية التصاميم
    document.addEventListener('contextmenu', function(e) {
      e.preventDefault();
    });

    // كود التحكم الذكي برابط البراند في الفوتر (الصعود التدريجي للأعلى)
    const brandTrigger = document.getElementById('foot-brand-trigger');
    if (brandTrigger) {
      brandTrigger.addEventListener('click', function(e) {
        if (window.location.pathname === '/' || window.location.pathname === '') {
          e.preventDefault();
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          });
        }
      });
    }
  })();
</script>
@stack('scripts')
</body>
</html>