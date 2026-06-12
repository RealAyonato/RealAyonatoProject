@extends('layouts.app')
@section('title', 'Services | RealAyonato')

{{-- أيقونات الخلفية المتحركة المتوافقة تماماً مع باقات الأسعار --}}
@section('bg_icons')
  <i class="bg-icon fas fa-tags" style="left:5%;top:15%;--dur:14s;font-size:64px"></i>
  <i class="bg-icon fas fa-box-open" style="left:85%;top:12%;--dur:18s;--delay:2s;font-size:70px"></i>
  <i class="bg-icon fas fa-gem" style="left:4%;top:58%;--dur:13s;--delay:4s;font-size:56px"></i>
  <i class="bg-icon fas fa-medal" style="left:46%;top:6%;--dur:15s;--delay:6s;font-size:64px"></i>
@endsection

@push('styles')
<style>
  .section { position: relative; z-index: 2; }

  /* عناوين الأقسام الفرعية المحدثة */
  .sub-section-title {
    font-family: var(--fd);
    font-size: 2.4rem;
    text-align: center;
    margin-bottom: 40px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
  }
  .sub-section-title span { color: var(--red); text-shadow: 0 0 15px var(--red-glow); }

  /* ==========================================
     تصميم قسم الخدمات الفردية (Standalone Services)
     ========================================== */
  .services-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 900px;
    margin: 0 auto 80px;
  }
  .service-item-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 26px 32px;
    background: rgba(15, 15, 15, 0.5) !important;
    border: 1px solid rgba(255, 255, 255, 0.04) !important;
    border-radius: 16px !important;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1) !important;
  }
  .service-item-card:hover {
    transform: translateX(8px);
    border-color: rgba(220, 38, 38, 0.4) !important;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(220, 38, 38, 0.08);
  }
  .ser-left { display: flex; align-items: center; gap: 24px; }
  .ser-icon {
    width: 52px;
    height: 52px;
    background: rgba(220, 38, 38, 0.08);
    color: var(--red);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.4rem;
    border: 1px solid rgba(220, 38, 38, 0.2);
    flex-shrink: 0;
    transition: all 0.3s ease;
  }
  .service-item-card:hover .ser-icon {
    background: var(--red);
    color: #fff;
    box-shadow: 0 0 15px var(--red-glow);
  }
  .ser-details h4 { font-family: var(--fd); font-size: 1.6rem; letter-spacing: 0.02em; color: #fff; margin-bottom: 4px; }
  .ser-details p { color: var(--g400); font-size: 0.9rem; line-height: 1.5; }
  .ser-right { display: flex; align-items: center; gap: 28px; flex-shrink: 0; }
  .ser-price { font-family: var(--fd); font-size: 2rem; color: #fff; font-weight: 900; }
  .ser-price span { color: var(--red); font-size: 1.3rem; margin-right: 2px; }

  /* ==========================================
     تصميم قسم الباقات المدمجة (Bundles Grid)
     ========================================== */
  .pricing-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); 
    gap: 32px; 
    max-width: 1080px; 
    margin: 0 auto; 
  }
  .price-card { 
    padding: 55px 32px 45px; 
    display: flex; 
    flex-direction: column; 
    position: relative;
    background: rgba(12, 12, 12, 0.7) !important;
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(255, 255, 255, 0.05) !important;
    border-radius: 24px !important;
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), border-color 0.4s ease, box-shadow 0.4s ease !important;
  }
  .price-card:hover {
    transform: translateY(-10px);
    border-color: rgba(220, 38, 38, 0.4) !important;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7), 0 0 25px rgba(220, 38, 38, 0.08);
  }
  
  /* الكارت الذهبي المميز الأكثر مبيعاً */
  .price-card.featured { 
    overflow: visible !important;
    border-color: rgba(220, 38, 38, 0.6) !important; 
    background: rgba(18, 11, 11, 0.8) !important;
    box-shadow: 0 15px 45px rgba(220, 38, 38, 0.15); 
  }
  .price-card.featured:hover {
    border-color: var(--red) !important;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.8), 0 0 30px rgba(220, 38, 38, 0.3);
  }

  /* شارة Best Value الاحترافية أعلى الكارت */
  .p-tag { 
    position: absolute; 
    top: -14px; 
    left: 24px; 
    background: var(--red); 
    color: #fff; 
    padding: 6px 16px; 
    border-radius: 30px; 
    font-size: 0.75rem; 
    font-weight: 900; 
    letter-spacing: 0.08em; 
    text-transform: uppercase; 
    box-shadow: 0 0 15px var(--red-glow); 
  }

  /* إيموجي النار الطائر المتوهج */
  .fire-pop {
    position: absolute;
    top: -45px;
    right: -10px;
    font-size: 4rem;
    z-index: 5;
    filter: drop-shadow(0 0 15px rgba(220, 38, 38, 0.7));
    animation: fireFloat 2s infinite ease-in-out;
    pointer-events: none;
    user-select: none;
    -webkit-user-drag: none;
  }
  @keyframes fireFloat {
    0%, 100% { transform: translateY(0) scale(1) rotate(0deg); }
    50% { transform: translateY(-8px) scale(1.08) rotate(5deg); }
  }
  
  .p-title { font-family: var(--fd); font-size: 2.4rem; letter-spacing: 0.03em; margin-bottom: 8px; color: #fff; }
  
  /* تنسيق عالي الدقة للأسعار */
  .p-cost { 
    font-size: 3.4rem; 
    font-weight: 900; 
    font-family: var(--fd); 
    color: #fff; 
    margin-bottom: 35px; 
    display: flex; 
    align-items: baseline; 
    line-height: 1; 
  }
  .p-cost span { color: var(--red); font-size: 2.2rem; }
  .old-cost {
    font-size: 1.5rem;
    color: var(--g500);
    text-decoration: line-through;
    margin-left: 14px;
    font-weight: 700;
    font-family: var(--fd);
  }

  .p-features { list-style: none; margin-bottom: 40px; display: flex; flex-direction: column; gap: 16px; flex-grow: 1; }
  .p-features li { display: flex; align-items: center; gap: 14px; color: var(--g300); font-size: 0.98rem; line-height: 1.4; }
  .p-features i { color: var(--red); font-size: 0.85rem; background: rgba(220, 38, 38, 0.12); width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; flex-shrink: 0; }

  /* تصميم متسق للأزرار التفاعلية */
  .pkg-btn {
    width: 100%; padding: 15px; border-radius: 12px; font-weight: 800; font-size: 0.9rem; font-family: var(--fb);
    text-transform: uppercase; letter-spacing: 0.05em; text-align: center; text-decoration: none; display: flex;
    align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: all var(--transition);
  }
  .pkg-btn-outline { background: transparent; border: 1px solid rgba(255, 255, 255, 0.12); color: var(--g300); }
  .pkg-btn-outline:hover { border-color: var(--red); color: #fff; box-shadow: 0 0 15px var(--red-glow); transform: translateY(-3px); }
  .pkg-btn-primary { background: var(--red); color: #fff; border: none; box-shadow: 0 6px 20px rgba(220, 38, 38, 0.25); }
  .pkg-btn-primary:hover { background: #ef4444; box-shadow: 0 8px 24px rgba(220, 38, 38, 0.5); transform: translateY(-3px); }

  /* شريط التعديلات الإضافية أسفل البطاقات */
  .extra-revisions-bar {
    max-width: 1080px;
    margin: 60px auto 0;
    background: rgba(220, 38, 38, 0.03);
    border: 1px dashed rgba(220, 38, 38, 0.25);
    padding: 20px;
    border-radius: 14px;
    text-align: center;
    color: var(--g300);
    font-size: 0.98rem;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
  }
  .extra-revisions-bar strong { color: #fff; font-family: var(--fb); }
  .extra-revisions-bar .highlight-price { color: var(--red); font-weight: 900; font-family: var(--fd); font-size: 1.2rem; margin: 0 2px; }

  /* منع سحب أو تفاعل عناصر الصور بالكامل عبر CSS */
  img, svg {
    pointer-events: none;
    -webkit-user-drag: none;
    user-select: none;
    -webkit-touch-callout: none;
  }

  /* ريسبونسيف كامل للشاشات الذكية والهواتف */
  @media(max-width: 768px) {
    .service-item-card { flex-direction: column; align-items: flex-start; gap: 20px; padding: 24px; }
    .ser-right { width: 100%; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 16px; }
    .sub-section-title { font-size: 2rem; }
  }
  @media(max-width: 480px) {
    .fire-pop { top: -38px; right: -5px; font-size: 3.4rem; }
    .p-cost { font-size: 2.8rem; }
  }
</style>
@endpush

@section('content')
<section class="section">
  <div class="container">

    <div class="sheader">
      <div class="badge"><span class="bdl"></span><span class="bt">Services</span></div>
      <h2 class="stitle">Fair Prices.<br><span>Serious Quality.</span></h2>
      <p class="ssub">Choose from standalone services or save more with value-packed bundles — all built for Roblox creators.</p>
    </div>

    <h3 class="sub-section-title">Standalone <span>Services</span></h3>
    <div class="services-list">
      
      <div class="card service-item-card">
        <div class="ser-left">
          <div class="ser-icon"><i class="fas fa-image"></i></div>
          <div class="ser-details">
            <h4>Roblox Thumbnail</h4>
            <p>Full 3D GFX render with custom lighting, character posing, and advanced Photoshop compositing. (2 Revisions Included)</p>
          </div>
        </div>
        <div class="ser-right">
          <div class="ser-price"><span>$</span>15</div>
          <a href="https://discord.gg/HC2xDx3FyN" target="_blank" class="pkg-btn pkg-btn-outline" style="width: auto; padding: 10px 24px;">Order</a>
        </div>
      </div>

      <div class="card service-item-card">
        <div class="ser-left">
          <div class="ser-icon"><i class="fas fa-paint-brush"></i></div>
          <div class="ser-details">
            <h4>YouTube / Roblox Banner</h4>
            <p>Custom banner featuring your brand, characters, and layout — built to match your channel identity. (1 Revision Included)</p>
          </div>
        </div>
        <div class="ser-right">
          <div class="ser-price"><span>$</span>12</div>
          <a href="https://discord.gg/HC2xDx3FyN" target="_blank" class="pkg-btn pkg-btn-outline" style="width: auto; padding: 10px 24px;">Order</a>
        </div>
      </div>

      <div class="card service-item-card">
        <div class="ser-left">
          <div class="ser-icon"><i class="fas fa-user-circle"></i></div>
          <div class="ser-details">
            <h4>GFX / Roblox Icon</h4>
            <p>High-quality avatar render with custom effects, dynamic lighting, and themed backgrounds. (1 Revision Included)</p>
          </div>
        </div>
        <div class="ser-right">
          <div class="ser-price"><span>$</span>10</div>
          <a href="https://discord.gg/HC2xDx3FyN" target="_blank" class="pkg-btn pkg-btn-outline" style="width: auto; padding: 10px 24px;">Order</a>
        </div>
      </div>

    </div>

    <h3 class="sub-section-title">Discounted <span>Bundles</span></h3>
    <div class="pricing-grid">
      
      <div class="card price-card">
        <h3 class="p-title">Starter Kit</h3>
        <div class="p-cost"><span>$</span>20 <span class="old-cost">$37</span></div>
        <ul class="p-features">
          <li><i class="fas fa-check"></i> 1 High-End Roblox Thumbnail</li>
          <li><i class="fas fa-check"></i> 1 GFX Profile Picture</li>
          <li><i class="fas fa-check"></i> 1 Professional Channel Banner</li>
          <li><i class="fas fa-check"></i> Cohesive visual identity across all assets</li>
          <li><i class="fas fa-check"></i> 1 Revision Per Asset</li>
        </ul>
        <a href="https://discord.gg/HC2xDx3FyN" target="_blank" class="pkg-btn pkg-btn-outline">
          <span>Get Started</span> <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <div class="card price-card featured">
        <div class="p-tag">Best Value</div>
        <div class="fire-pop">🔥</div>
        <h3 class="p-title">Creator Bundle</h3>
        <div class="p-cost"><span>$</span>36 <span class="old-cost">$67</span></div>
        <ul class="p-features">
          <li><i class="fas fa-check"></i> 3 Premium Roblox Thumbnails</li>
          <li><i class="fas fa-check"></i> 1 Custom GFX Profile Picture</li>
          <li><i class="fas fa-check"></i> 1 Professional Channel Banner</li>
          <li><i class="fas fa-check"></i> 2 Revisions Per Thumbnail</li>
          <li><i class="fas fa-check"></i> Priority delivery (1–2 days per asset)</li>
        </ul>
        <a href="https://discord.gg/HC2xDx3FyN" target="_blank" class="pkg-btn pkg-btn-primary">
          <span>Get Bundle</span> <i class="fas fa-shopping-cart"></i>
        </a>
      </div>

      <div class="card price-card">
        <h3 class="p-title">Cinematic Pack</h3>
        <div class="p-cost"><span>$</span>120 <span class="old-cost">$204</span></div>
        <ul class="p-features">
          <li><i class="fas fa-check"></i> 10 Cinematic Roblox Thumbnails</li>
          <li><i class="fas fa-check"></i> 3 Custom GFX Profile Pictures</li>
          <li><i class="fas fa-check"></i> 2 Professional Channel Banners</li>
          <li><i class="fas fa-check"></i> 3 Revisions Per Thumbnail</li>
          <li><i class="fas fa-check"></i> Priority delivery (1–2 days per asset)</li>
        </ul>
        <a href="https://discord.gg/HC2xDx3FyN" target="_blank" class="pkg-btn pkg-btn-outline">
          <span>Acquire Pack</span> <i class="fas fa-arrow-right"></i>
        </a>
      </div>

    </div>

    <div class="extra-revisions-bar">
      <i class="fas fa-plus-circle" style="color: var(--red); margin-right: 6px;"></i> 
      <strong>Need more revisions?</strong> Add extra rounds to any asset for just <span class="highlight-price">$2</span> each — no limits.
    </div>

  </div>
</section>
@endsection

@push('scripts')
<script>
  (function() {
    // جدار حماية لتعطيل الـ Context Menu الافتراضي (Right-Click) على كامل الصفحة
    document.addEventListener('contextmenu', function(e) {
      e.preventDefault();
    });

    // منع سحب وحفظ الصور ورموز الـ SVG حتى للهواتف المحمولة
    document.querySelectorAll('img, svg').forEach(el => {
      el.addEventListener('dragstart', function(e) {
        e.preventDefault();
      });
      el.addEventListener('contextmenu', function(e) {
        e.preventDefault();
      });
    });
  })();
</script>
@endpush