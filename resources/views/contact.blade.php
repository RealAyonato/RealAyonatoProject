@extends('layouts.app')
@section('title', 'Contact | RealAyonato')

{{-- أيقونات الخلفية التفاعلية المخصصة لقسم اتصل بنا --}}
@section('bg_icons')
  <i class="bg-icon fab fa-discord" style="left:7%;top:18%;--dur:14s;font-size:64px"></i>
  <i class="bg-icon fab fa-tiktok" style="left:88%;top:12%;--dur:16s;--delay:2s;font-size:60px"></i>
  <i class="bg-icon fab fa-youtube" style="left:4%;top:62%;--dur:13s;--delay:4s;font-size:56px"></i>
  <i class="bg-icon fab fa-x-twitter" style="left:46%;top:8%;--dur:15s;--delay:6s;font-size:62px"></i>
@endsection

@push('styles')
<style>
  :root {
    --neon-red: #dc2626;
    --neon-glow: rgba(220, 38, 38, 0.4);
    --panel-bg: rgba(10, 10, 10, 0.75);
  }

  .section {
    position: relative;
    z-index: 2;
    overflow: hidden;
  }

  /* حاوية العرض الديناميكية المحترفة */
  .motion-contact-grid {
    max-width: 1100px;
    margin: 60px auto 90px;
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 35px;
    position: relative;
  }

  /* ==========================================
     لوحة محرك ديسكورد السينمائية
     ========================================== */
  .discord-cinema-panel {
    background: linear-gradient(135deg, rgba(16, 10, 10, 0.85) 0%, rgba(5, 5, 5, 0.9) 100%) !important;
    border: 1px solid rgba(220, 38, 38, 0.15) !important;
    border-radius: 20px !important;
    padding: 50px;
    position: relative;
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.95), inset 0 1px 1px rgba(255, 255, 255, 0.05);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    overflow: hidden;
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
  }

  /* زوايا استوديو تفاعلية حادة */
  .discord-cinema-panel::before, .discord-cinema-panel::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    border-color: var(--neon-red);
    border-style: solid;
    opacity: 0.6;
    transition: all 0.4s ease;
  }
  .discord-cinema-panel::before { top: 24px; left: 24px; border-width: 2px 0 0 2px; }
  .discord-cinema-panel::after { bottom: 24px; right: 24px; border-width: 0 2px 2px 0; }

  .discord-cinema-panel:hover {
    border-color: rgba(220, 38, 38, 0.4) !important;
    box-shadow: 0 40px 90px rgba(0, 0, 0, 0.95), 0 0 30px rgba(220, 38, 38, 0.08);
  }

  /* لوجو الديسكورد المتوهج */
  .discord-panel-logo {
    font-size: 3rem;
    color: var(--neon-red);
    margin-bottom: 20px;
    filter: drop-shadow(0 0 12px var(--neon-glow));
    animation: smoothPulse 3s infinite ease-in-out;
  }

  @keyframes smoothPulse {
    0%, 100% { transform: scale(1); filter: drop-shadow(0 0 12px var(--neon-glow)); }
    50% { transform: scale(1.05); filter: drop-shadow(0 0 20px rgba(220, 38, 38, 0.6)); }
  }

  /* تنسيق خط الفقرة التوضيحية */
  .statement-paragraph {
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important; 
    font-size: 1.1rem;
    line-height: 1.65;
    color: var(--g300);
    margin: 0 0 35px 0;
    font-weight: 400; 
    text-align: left;
    letter-spacing: 0.01em;
    text-transform: none !important; 
  }

  .statement-paragraph span {
    color: #ffffff;
    font-weight: 500; 
    text-transform: none !important;
  }

  /* زر ديسكورد التفاعلي */
  .vector-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 18px;
    background: linear-gradient(135deg, var(--neon-red) 0%, #991b1b 100%) !important;
    color: #ffffff !important;
    padding: 15px 38px;
    border-radius: 12px;
    font-weight: 500; 
    font-size: 1rem;
    font-family: var(--fb);
    text-transform: none !important; 
    letter-spacing: 0.05em;
    text-decoration: none;
    box-shadow: 0 12px 30px rgba(220, 38, 38, 0.3);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .vector-action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 40px rgba(220, 38, 38, 0.5), 0 0 20px var(--neon-glow);
    background: linear-gradient(135deg, #ef4444 0%, var(--neon-red) 100%) !important;
  }

  .vector-action-btn .arrow-pack {
    display: flex;
    align-items: center;
  }

  .vector-action-btn .arrow-pack i {
    transition: transform 0.3s ease;
    font-size: 0.85rem;
  }

  .vector-action-btn:hover .arrow-pack i:nth-child(1) { transform: translateX(5px); }
  .vector-action-btn:hover .arrow-pack i:nth-child(2) { transform: translateX(3px); }

  /* ==========================================
     العمود الجانبي للمنصات الأخرى
     ========================================== */
  .motion-side-stack {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  .stack-card {
    background: var(--panel-bg) !important;
    border: 1px solid rgba(255, 255, 255, 0.02) !important;
    border-radius: 16px !important;
    padding: 24px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-decoration: none;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
  }

  .stack-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 0;
    background: var(--neon-red);
    box-shadow: 0 0 10px var(--neon-red);
    transition: height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .stack-meta {
    display: flex;
    align-items: center;
    gap: 20px;
  }

  .stack-icon-box {
    width: 46px;
    height: 46px;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: var(--g400);
    transition: all 0.3s ease;
  }

  .stack-info h4 {
    font-family: var(--fb);
    font-size: 0.85rem;
    font-weight: 800; 
    text-transform: uppercase; 
    letter-spacing: 0.08em;
    color: #ffffff;
    margin-bottom: 2px;
  }

  .stack-info p {
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important; 
    font-size: 0.95rem;
    font-weight: 400;
    color: var(--g400);
    text-transform: none !important; 
    letter-spacing: 0.02em;
  }

  .stack-indicator {
    font-size: 0.9rem;
    color: var(--g500);
    transition: all 0.3s ease;
  }

  .stack-card:hover {
    border-color: rgba(220, 38, 38, 0.25) !important;
    background: rgba(18, 12, 12, 0.5) !important;
    transform: translateX(6px);
  }

  .stack-card:hover::before { height: 50%; }

  .stack-card:hover .stack-icon-box {
    color: #ffffff;
    background: var(--neon-red);
    border-color: var(--neon-red);
    box-shadow: 0 0 12px var(--neon-glow);
  }

  .stack-card:hover .stack-indicator {
    color: var(--neon-red);
    transform: translateX(4px);
    filter: drop-shadow(0 0 5px var(--neon-glow));
  }

  /* التوافق مع الشاشات الصغيرة والمتوسطة */
  @media (max-width: 950px) {
    .motion-contact-grid { grid-template-columns: 1fr; gap: 25px; margin: 40px auto 60px; }
    .discord-cinema-panel { padding: 45px 24px; align-items: center; text-align: center; }
    .statement-paragraph { text-align: center; font-size: 1.05rem; }
    .vector-action-btn { width: 100%; justify-content: center; }
  }
</style>
@endpush

@section('content')
<section class="section">
  <div class="container">

    <div class="sheader reveal active">
      <div class="badge"><span class="bdl"></span><span class="bt">Contact</span></div>
      <h2 class="stitle">Let's Create.<br><span>Get In Touch.</span></h2>
      <p class="ssub">Ready to order or just have a question? Everything goes through Discord — fast, easy, and direct.</p>
    </div>

    <div class="motion-contact-grid reveal active">
      
      <div class="card discord-cinema-panel">
        <div class="discord-panel-logo">
          <i class="fab fa-discord"></i>
        </div>
        
        <p class="statement-paragraph">
          The fastest way to place orders, request revisions, and talk to me directly — <span>everything happens through my Discord ticketing system.</span>
        </p>
        
        <a href="https://discord.gg/HC2xDx3FyN" target="_blank" class="vector-action-btn">
          <span>Open a ticket</span>
          <span class="arrow-pack">
            <i class="fas fa-chevron-right"></i>
            <i class="fas fa-chevron-right" style="opacity: 0.5; margin-left: -3px;"></i>
          </span>
        </a>
      </div>

      <div class="motion-side-stack">
        
        <a href="https://x.com/RealAyonato" target="_blank" class="stack-card">
          <div class="motion-meta-wrapper">
            <div class="stack-meta">
              <div class="stack-icon-box"><i class="fab fa-x-twitter"></i></div>
              <div class="stack-info">
                <h4>X / Twitter</h4>
                <p>@RealAyonato</p>
              </div>
            </div>
          </div>
          <div class="stack-indicator"><i class="fas fa-arrow-right"></i></div>
        </a>

        <a href="https://www.instagram.com/realayonato/" target="_blank" class="stack-card">
          <div class="motion-meta-wrapper">
            <div class="stack-meta">
              <div class="stack-icon-box"><i class="fab fa-instagram"></i></div>
              <div class="stack-info">
                <h4>Instagram</h4>
                <p>@RealAyonato</p>
              </div>
            </div>
          </div>
          <div class="stack-indicator"><i class="fas fa-arrow-right"></i></div>
        </a>

        <a href="https://www.tiktok.com/@realayonato" target="_blank" class="stack-card">
          <div class="motion-meta-wrapper">
            <div class="stack-meta">
              <div class="stack-icon-box"><i class="fab fa-tiktok"></i></div>
              <div class="stack-info">
                <h4>TikTok</h4>
                <p>@RealAyonato</p>
              </div>
            </div>
          </div>
          <div class="stack-indicator"><i class="fas fa-arrow-right"></i></div>
        </a>

        <a href="https://www.youtube.com/@RealAyonato" target="_blank" class="stack-card">
          <div class="motion-meta-wrapper">
            <div class="stack-meta">
              <div class="stack-icon-box"><i class="fab fa-youtube"></i></div>
              <div class="stack-info">
                <h4>YouTube</h4>
                <p>@RealAyonato</p>
              </div>
            </div>
          </div>
          <div class="stack-indicator"><i class="fas fa-arrow-right"></i></div>
        </a>

      </div>

    </div>

  </div>
</section>
@endsection