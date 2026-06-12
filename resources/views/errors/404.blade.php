@extends('layouts.app')
@section('title', '404 | RealAyonato')

@section('content')
<section class="error-section">
  <div class="glow-orb orb-1"></div>
  <div class="glow-orb orb-2"></div>

  <div class="container error-container">
    <div class="error-box">
      
      <div class="glitch-wrapper">
        <h1 class="glitch-text" data-text="404">404</h1>
      </div>

      <div class="neon-line"></div>

      <h2 class="error-subtitle">Signal <span>Lost</span></h2>
      <p class="error-desc">
        Looks like this page got lost in the void. Head back or check out the work.
      </p>

      <div class="error-actions">
        <a href="{{ url('/') }}" class="error-btn primary-btn">
          <i class="fas fa-rocket"></i> Return To Base
        </a>
        <a href="{{ url('/portfolio') }}" class="error-btn secondary-btn">
          <i class="fas fa-images"></i> View Portfolio
        </a>
      </div>

    </div>
  </div>
</section>

<style>
  /* تنسيق قسم الخطأ ليتناسب ديناميكياً مع الهيدر الثابت */
  .error-section {
    position: relative;
    min-height: calc(100vh - 85px);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: #060606;
    padding: 60px 20px;
    z-index: 1;
  }

  /* كرات التوهج النيون الخلفية (Ambient Glow) */
  .glow-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(140px);
    pointer-events: none;
    z-index: 0;
    opacity: 0.15;
  }
  .orb-1 {
    top: 20%;
    left: 15%;
    width: 300px;
    height: 300px;
    background: var(--red);
    animation: floatOrb 8s infinite alternate ease-in-out;
  }
  .orb-2 {
    bottom: 15%;
    right: 15%;
    width: 350px;
    height: 350px;
    background: #7f1d1d;
    animation: floatOrb 10s infinite alternate-reverse ease-in-out;
  }

  @keyframes floatOrb {
    0% { transform: translateY(0) scale(1); }
    100% { transform: translateY(-30px) scale(1.1); }
  }

  /* الحاوية الرئيسية ومؤثرات الزجاج المظلم */
  .error-container {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
  }
  .error-box {
    background: rgba(10, 10, 10, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    padding: 60px 40px;
    border-radius: 32px;
    max-width: 680px;
    width: 100%;
    text-align: center;
    box-shadow: 0 30px 70px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(255, 255, 255, 0.05);
  }

  /* تصميم الـ Glitch الرقمي الضخم لـ 404 */
  .glitch-wrapper {
    position: relative;
    display: inline-block;
  }
  .glitch-text {
    font-family: var(--fd);
    font-size: clamp(6rem, 15vw, 10rem);
    line-height: 0.9;
    color: #fff;
    letter-spacing: 0.05em;
    position: relative;
    text-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
  }
  .glitch-text::before, .glitch-text::after {
    content: attr(data-text);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #060606;
  }
  .glitch-text::before {
    left: 2px;
    text-shadow: -2px 0 var(--red);
    clip: rect(44px, 450px, 56px, 0);
    animation: glitch-anim 5s infinite linear alternate-reverse;
  }
  .glitch-text::after {
    left: -2px;
    text-shadow: -2px 0 #450a0a;
    clip: rect(85px, 450px, 140px, 0);
    animation: glitch-anim2 5s infinite linear alternate-reverse;
  }

  @keyframes glitch-anim {
    0% { clip: rect(31px, 9999px, 94px, 0); }
    10% { clip: rect(112px, 9999px, 76px, 0); }
    20% { clip: rect(85px, 9999px, 5px, 0); }
    30% { clip: rect(27px, 9999px, 115px, 0); }
    40% { clip: rect(73px, 9999px, 29px, 0); }
    50% { clip: rect(118px, 9999px, 142px, 0); }
    60% { clip: rect(44px, 9999px, 50px, 0); }
    70% { clip: rect(12px, 9999px, 85px, 0); }
    80% { clip: rect(99px, 9999px, 4px, 0); }
    90% { clip: rect(134px, 9999px, 62px, 0); }
    100% { clip: rect(67px, 9999px, 110px, 0); }
  }
  @keyframes glitch-anim2 {
    0% { clip: rect(76px, 9999px, 116px, 0); }
    11% { clip: rect(43px, 9999px, 2px, 0); }
    22% { clip: rect(122px, 9999px, 149px, 0); }
    33% { clip: rect(9px, 9999px, 85px, 0); }
    44% { clip: rect(131px, 9999px, 55px, 0); }
    55% { clip: rect(65px, 9999px, 123px, 0); }
    66% { clip: rect(19px, 9999px, 4px, 0); }
    77% { clip: rect(88px, 9999px, 102px, 0); }
    88% { clip: rect(143px, 9999px, 71px, 0); }
    99% { clip: rect(52px, 9999px, 19px, 0); }
    100% { clip: rect(105px, 9999px, 137px, 0); }
  }

  /* الخط النيوني الفاصل */
  .neon-line {
    height: 1px;
    width: 80px;
    background: var(--red);
    margin: 20px auto 30px;
    box-shadow: 0 0 12px var(--red), 0 0 4px var(--red);
    position: relative;
  }
  .neon-line::after {
    content: '';
    position: absolute;
    top: -2px;
    left: 0;
    width: 6px;
    height: 5px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 0 10px #fff;
    animation: scanLine 3s infinite linear;
  }

  @keyframes scanLine {
    0% { left: 0; }
    50% { left: 74px; }
    100% { left: 0; }
  }

  /* النصوص الفرعية */
  .error-subtitle {
    font-family: var(--fd);
    font-size: 2.2rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: #fff;
    margin-bottom: 15px;
  }
  .error-subtitle span {
    color: var(--red);
    text-shadow: 0 0 15px var(--red-glow);
  }
  .error-desc {
    color: var(--g400);
    font-size: 1rem;
    line-height: 1.7;
    max-width: 500px;
    margin: 0 auto 40px;
    font-family: var(--fb);
  }

  /* مجموعة الأزرار السينمائية */
  .error-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
  }
  .error-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 30px;
    border-radius: 14px;
    font-weight: 800;
    font-size: 0.88rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    text-decoration: none;
    font-family: var(--fb);
    transition: all var(--transition);
    cursor: pointer;
  }
  .primary-btn {
    background: var(--red);
    color: #fff;
    box-shadow: 0 6px 20px rgba(220, 38, 38, 0.2);
    border: none;
  }
  .primary-btn:hover {
    background: #ef4444;
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(220, 38, 38, 0.45);
  }
  .secondary-btn {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: var(--g300);
  }
  .secondary-btn:hover {
    border-color: var(--red);
    color: #fff;
    background: rgba(220, 38, 38, 0.05);
    box-shadow: 0 0 20px var(--red-glow);
    transform: translateY(-3px);
  }

  /* حماية برمجية لعدم سحب أو تحديد الأيقونات والصور */
  img, svg, i, h1 {
    pointer-events: none;
    -webkit-user-drag: none;
    user-select: none;
  }

  @media(max-width: 580px) {
    .error-box { padding: 40px 20px; border-radius: 24px; }
    .error-actions { flex-direction: column; gap: 12px; }
    .error-btn { width: 100%; justify-content: center; }
  }
</style>
@endsection

@push('scripts')
<script>
  (function() {
    // جدار الحماية الصارم لحظر القائمة الافتراضية عند النقر بالزر الأيمن
    document.addEventListener('contextmenu', function(e) {
      e.preventDefault();
    });
  })();
</script>
@endpush