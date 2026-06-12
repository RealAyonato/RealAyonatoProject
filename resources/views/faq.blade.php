@extends('layouts.app')
@section('title', 'FAQ | RealAyonato')

{{-- أيقونات الخلفية التفاعلية المخصصة لقسم الأسئلة الشائعة --}}
@section('bg_icons')
  <i class="bg-icon fas fa-question-circle" style="left:8%;top:15%;--dur:14s;font-size:68px"></i>
  <i class="bg-icon fas fa-lightbulb" style="left:85%;top:20%;--dur:16s;--delay:2s;font-size:62px"></i>
  <i class="bg-icon fas fa-comments" style="left:5%;top:65%;--dur:13s;--delay:4s;font-size:54px"></i>
  <i class="bg-icon fas fa-info-circle" style="left:45%;top:10%;--dur:15s;--delay:6s;font-size:60px"></i>
@endsection

@push('styles')
<style>
  .section {
    position: relative;
    z-index: 2;
    /* منع تحديد النصوص أو نسخها في كامل قسم الأسئلة الشائعة */
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
  }

  /* حاوية الأسئلة الشائعة */
  .faq-wrap { 
    max-width: 850px; 
    margin: 40px auto 60px; 
    display: flex; 
    flex-direction: column; 
    gap: 16px; 
  }

  /* تصميم الكارت الزجاجي العصري */
  .faq-card { 
    border: 1px solid rgba(255, 255, 255, 0.04) !important; 
    border-radius: 16px !important; 
    background: rgba(15, 15, 15, 0.6) !important; 
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    overflow: hidden; 
    transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease; 
  }

  /* تأثير الهوفر قبل الضغط */
  .faq-card:hover {
    border-color: rgba(220, 38, 38, 0.25) !important;
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
  }
  
  /* زر تفعيل السؤال */
  .faq-trigger { 
    width: 100%; 
    padding: 22px 30px; 
    background: none; 
    border: none; 
    text-align: left; 
    color: var(--g300); 
    font-weight: 800; 
    font-size: 1.1rem; 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    cursor: pointer; 
    font-family: var(--fb); 
    transition: color 0.3s ease;
    gap: 20px;
  }

  .faq-card:hover .faq-trigger {
    color: #fff;
  }
  
  /* تصميم دائرة الأيقونة المتنقلة */
  .faq-icon { 
    width: 34px; 
    height: 34px; 
    border-radius: 50%; 
    background: rgba(255, 255, 255, 0.03); 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    border: 1px solid rgba(255, 255, 255, 0.08); 
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease; 
    font-size: 0.85rem; 
    color: var(--g400);
    flex-shrink: 0;
  }
  
  /* محتوى الإجابة الداخلي */
  .faq-content { 
    max-height: 0; 
    overflow: hidden; 
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
    background: rgba(8, 8, 8, 0.15); 
  }
  
  .faq-inner { 
    padding: 0 30px 24px; 
    color: var(--g400); 
    font-size: 0.98rem; 
    line-height: 1.75; 
    font-style: italic;
  }
  
  /* التنسيق النشط والكارت مفتوح */
  .faq-card.active { 
    border-color: rgba(220, 38, 38, 0.4) !important; 
    background: rgba(20, 12, 12, 0.65) !important;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), 0 0 20px rgba(220, 38, 38, 0.08);
  }

  .faq-card.active .faq-trigger {
    color: #fff;
  }

  .faq-card.active .faq-icon { 
    background: var(--red); 
    border-color: var(--red); 
    transform: rotate(180deg); 
    color: #fff; 
    box-shadow: 0 0 12px var(--red-glow); 
  }

  /* منع تفاعل وسحب الأيقونات أو الصور التعبيرية */
  img, svg, i {
    pointer-events: none;
    -webkit-user-drag: none;
    -webkit-touch-callout: none;
  }

  /* ريسبونسيف للشاشات الصغيرة */
  @media(max-width: 576px) {
    .faq-trigger { padding: 18px 20px; font-size: 1rem; gap: 12px; }
    .faq-inner { padding: 0 20px 20px; font-size: 0.92rem; }
    .faq-icon { width: 30px; height: 30px; font-size: 0.75rem; }
  }
</style>
@endpush

@section('content')
<section class="section">
  <div class="container">

    <div class="sheader reveal active">
      <div class="badge"><span class="bdl"></span><span class="bt">FAQ</span></div>
      <h2 class="stitle">Questions?<br><span>I've Got You.</span></h2>
      <p class="ssub">Everything you need to know before placing your first order.</p>
    </div>

    <div class="faq-wrap reveal active" id="faqWrap"></div>

  </div>
</section>
@endsection

@push('scripts')
<script>
  (function() {
    const faqData = [
      { q: 'What exactly do you create?', a: 'I make Roblox thumbnails, GFX profile pictures, and channel banners — all built with 3D rendering and custom effects. Basically anything visual for your Roblox channel, I can build it.' },
      { q: 'How long will my order take?', a: 'Most orders are done within 6 to 48 hours. For bundles, I deliver each asset one by one so nothing feels rushed. Need it faster? Just mention your deadline when you order.' },
      { q: 'How do revisions work?', a: 'Every service includes a set number of free revisions. Need more? You can add extra rounds for $2 each — I want you to be 100% happy with the result.' },
      { q: 'What information do you need to get started?', a: 'Your Roblox username, a description of what you want, any references or examples, your color preferences, and your deadline. The more detail you share, the better the final result.' },
      { q: 'How do I pay?', a: 'I accept PayPal and Ko-fi. Once we lock in the details, you pay and I get started right away — straightforward and no hassle.' },
      { q: 'Do you offer refunds?', a: 'Due to the custom nature of the work, I don\'t offer refunds once the design process has started. However, I\'ll work with you through revisions until you\'re satisfied.' },
      { q: 'Can I use the designs commercially?', a: 'Yes — once delivered and paid for, the designs are fully yours to use on YouTube, Roblox, or anywhere else.' },
      { q: 'Can you match my existing style or branding?', a: 'Absolutely. Just send over examples of your current visuals and I\'ll make sure everything stays consistent with your brand.' },
      { q: 'Do returning clients get any perks?', a: 'Yes! Repeat clients get priority in the queue and occasional discounts — just mention it\'s not your first order.' },
      { q: 'How do I place an order?', a: 'Head over to my Discord, open a ticket, and talk to me directly. That\'s where all orders are handled — fastest way to get started.' }
    ];

    const wrap = document.getElementById('faqWrap');
    
    faqData.forEach(f => {
      const card = document.createElement('div'); 
      card.className = 'faq-card';
      card.innerHTML = `
        <button class="faq-trigger">
          <span>${f.q}</span> 
          <span class="faq-icon"><i class="fas fa-chevron-down"></i></span>
        </button>
        <div class="faq-content">
          <div class="faq-inner">${f.a}</div>
        </div>
      `;
      
      wrap.appendChild(card);
      
      card.querySelector('.faq-trigger').addEventListener('click', function() {
        const isActive = card.classList.contains('active');
        
        // إغلاق أي كارت مفتوح مسبقاً بطريقة ناعمة وسلسة
        document.querySelectorAll('.faq-card').forEach(c => { 
          if (c !== card) {
            c.classList.remove('active'); 
            c.querySelector('.faq-content').style.maxHeight = null; 
          }
        });
        
        // تبديل حالة الكارت الذي تم الضغط عليه حالياً
        if (isActive) {
          card.classList.remove('active');
          card.querySelector('.faq-content').style.maxHeight = null;
        } else {
          card.classList.add('active');
          const content = card.querySelector('.faq-content'); 
          content.style.maxHeight = content.scrollHeight + "px"; 
        }
      });
    });

    // جدار الحماية لمنع الـ Right-Click على الصفحة بالكامل
    document.addEventListener('contextmenu', function(e) {
      e.preventDefault();
    });

    // حماية الأيقونات والصور والـ SVGs من السحب العشوائي
    document.querySelectorAll('img, svg, i').forEach(el => {
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