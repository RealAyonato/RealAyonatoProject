@extends('layouts.app')
@section('title', 'Feedback | RealAyonato')

{{-- أيقونات الخلفية المتوافقة مع التقييمات --}}
@section('bg_icons')
  <i class="bg-icon fas fa-star" style="left:6%;top:12%;--dur:14s;font-size:68px"></i>
  <i class="bg-icon fas fa-comment-alt" style="left:88%;top:18%;--dur:16s;--delay:2s;font-size:60px"></i>
  <i class="bg-icon fas fa-thumbs-up" style="left:4%;top:60%;--dur:13s;--delay:4s;font-size:54px"></i>
  <i class="bg-icon fas fa-quote-left" style="left:45%;top:8%;--dur:15s;--delay:6s;font-size:64px"></i>
@endsection

@push('styles')
<style>
  .section {
    position: relative;
    z-index: 2;
  }

  /* قسم الإحصائيات */
  .stats-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-bottom: 60px;
    flex-wrap: wrap;
    text-align: center;
  }
  .stat-box {
    background: rgba(17, 17, 17, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.03);
    padding: 20px 40px;
    border-radius: 18px;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    min-width: 180px;
    transition: transform 0.3s ease;
  }
  .stat-box:hover {
    transform: translateY(-3px);
  }
  .stat-num {
    font-family: var(--fd);
    font-size: 2.8rem;
    color: var(--white);
    line-height: 1;
    font-weight: 900;
  }
  .stat-num span { color: var(--red); text-shadow: 0 0 10px var(--red-glow); }
  .stat-label {
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--g500);
    margin-top: 6px;
    font-weight: 800;
  }

  /* شبكة كروت التقييمات */
  .review-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); 
    gap: 30px; 
    max-width: 1100px; 
    margin: 0 auto 40px; 
  }
  
  .review-card { 
    padding: 32px; 
    position: relative; 
    background: rgba(15, 15, 15, 0.65) !important;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.05) !important;
    border-radius: 20px !important;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), border-color 0.4s ease, box-shadow 0.4s ease !important;
  }
  
  .review-card:hover {
    transform: translateY(-8px);
    border-color: rgba(220, 38, 38, 0.4) !important;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6), 0 0 20px rgba(220, 38, 38, 0.08);
  }

  /* تحسين إخفاء وظهور الكروت الإضافية بسلاسة */
  .review-card.hidden-review {
    display: none;
    opacity: 0;
    transform: translateY(25px);
    transition: opacity 0.5s cubic-bezier(0.25, 1, 0.5, 1), transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
  }

  .rev-user { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; }
  .rev-avatar { 
    width: 54px; 
    height: 54px; 
    border-radius: 50%; 
    border: 2px solid rgba(255, 255, 255, 0.08); 
    transition: all 0.3s ease;
    object-fit: cover;
  }
  .review-card:hover .rev-avatar {
    border-color: var(--red);
    box-shadow: 0 0 12px var(--red-glow);
  }
  
  .rev-name { font-weight: 800; font-size: 1.15rem; color: var(--white); letter-spacing: 0.01em; }
  .rev-role { font-size: 0.75rem; color: var(--g500); font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 1px; }
  
  /* النجوم المضيئة باللون الأحمر */
  .rev-stars { 
    color: var(--red); 
    font-size: 0.85rem; 
    margin-top: 4px; 
    letter-spacing: 2px;
    text-shadow: 0 0 8px rgba(220, 38, 38, 0.5);
  }
  
  .rev-text { 
    color: var(--g300); 
    font-size: 0.98rem; 
    line-height: 1.7; 
    font-style: italic; 
    position: relative;
    z-index: 2;
    flex-grow: 1;
  }
  
  .quote-icon { 
    position: absolute; 
    bottom: 24px; 
    right: 24px; 
    color: rgba(220, 38, 38, 0.03); 
    font-size: 3.8rem; 
    transition: all 0.4s ease;
    pointer-events: none;
  }
  .review-card:hover .quote-icon {
    color: rgba(220, 38, 38, 0.08);
    transform: scale(1.1) rotate(-8deg);
  }

  /* حاوية وزر عرض المزيد */
  .more-btn-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 30px;
  }
  .more-reviews-btn {
    background: transparent !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    color: var(--g300) !important;
    font-family: var(--fb);
    padding: 14px 32px;
    border-radius: 10px;
    font-weight: 800;
    font-size: 0.9rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    transition: all var(--transition);
  }
  .more-reviews-btn:hover {
    border-color: var(--red) !important;
    color: #fff !important;
    box-shadow: 0 0 15px var(--red-glow);
    transform: translateY(-3px);
  }
  .more-reviews-btn i {
    transition: transform 0.3s ease;
  }
  .more-reviews-btn:hover i {
    transform: translateY(2px);
  }

  /* شاشات الموبايل */
  @media(max-width: 576px) {
    .stats-container { gap: 16px; }
    .stat-box { padding: 16px 24px; min-width: 130px; flex-grow: 1; }
    .stat-num { font-size: 2.2rem; }
    .review-card { padding: 24px; }
    .quote-icon { font-size: 3rem; bottom: 16px; right: 16px; }
  }
</style>
@endpush

@section('content')
<section class="section">
  <div class="container">

    <div class="sheader reveal active">
      <div class="badge"><span class="bdl"></span><span class="bt">Feedback</span></div>
      <h2 class="stitle">What Creators<br><span>Are Saying</span></h2>
      <p class="ssub">Honest words from Roblox creators and developers who've leveled up their visual identity.</p>
    </div>

    <div class="stats-container reveal active">
      <div class="stat-box">
        <div class="stat-num">38<span>+</span></div>
        <div class="stat-label">Total Clients</div>
      </div>
      <div class="stat-box">
        <div class="stat-num">4.8</div>
        <div class="stat-label">Rating</div>
      </div>
      <div class="stat-box">
        <div class="stat-num">94<span>%</span></div>
        <div class="stat-label">Always On Time</div>
      </div>
    </div>

    <div class="review-grid" id="reviewGrid">
      
      <div class="card review-card reveal active">
        <div class="rev-user">
          <img src="https://yt3.googleusercontent.com/zCNIdyHkYdReYWd_h3h2x7uLdJNIRmEppQft1FrOjJ0cdzrwCwGv-75Ul_Tc22si5opRnEN0_g=s160-c-k-c0x00ffffff-no-rj" class="rev-avatar" alt="WasimoX">
          <div>
            <div class="rev-name">WasimoX</div>
            <div class="rev-role">Content Creator</div>
            <div class="rev-stars">★★★★★</div>
          </div>
        </div>
        <p class="rev-text">"bro i wasn't expecting this at all. Ordered a thumbnail and when I saw the result I was genuinely speechless. My CTR went up the same day I posted it."</p>
        <i class="fas fa-quote-right quote-icon"></i>
      </div>

      <div class="card review-card reveal active">
        <div class="rev-user">
          <img src="https://yt3.googleusercontent.com/R-6zthJWVPIn3XOtGWVdxpkNfeNh07_Nk5ziWrRJ_XXEnU4c5gRtOZ6-V0Aa11eA5T2c0mY02A=s160-c-k-c0x00ffffff-no-rj" class="rev-avatar" alt="Dragon V">
          <div>
            <div class="rev-name">Dragon V</div>
            <div class="rev-role">Roblox Youtuber</div>
            <div class="rev-stars">★★★★☆</div>
          </div>
        </div>
        <p class="rev-text">"Really solid work, the style matched exactly what I had in mind. Took a couple revisions but he was patient about it. Would come back for the next series for sure."</p>
        <i class="fas fa-quote-right quote-icon"></i>
      </div>
      
      <div class="card review-card reveal active">
        <div class="rev-user">
          <img src="https://yt3.googleusercontent.com/U2Rrp1eEJLRHGZapPfuiPjlBR_GmXu5etuyx_7p-Vt7UEig6EJ4mTduBRlUI8WYBDwKJOe24=s160-c-k-c0x00ffffff-no-rj" class="rev-avatar" alt="Takzo">
          <div>
            <div class="rev-name">Takzo</div>
            <div class="rev-role">Content Creator</div>
            <div class="rev-stars">★★★★★</div>
          </div>
        </div>
        <p class="rev-text">"Gave him a pretty vague idea and he turned it into something way better than I imagined. My audience literally commented on the thumbnail lol. Worth every penny."</p>
        <i class="fas fa-quote-right quote-icon"></i>
      </div>

      <div class="card review-card hidden-review">
        <div class="rev-user">
          <img src="https://yt3.googleusercontent.com/RGavIAzzWEjU9TcSbbUej0ibmrulp3ETMn3lkYwltk3lIeivqJX5rW51esekvXXxWZ4hg2Y7=s160-c-k-c0x00ffffff-no-rj" class="rev-avatar" alt="Yaso Plays">
          <div>
            <div class="rev-name">Yaso Plays</div>
            <div class="rev-role">Roblox Youtuber</div>
            <div class="rev-stars">★★★★★</div>
          </div>
        </div>
        <p class="rev-text">"The GFX hits different fr. My old thumbnails look so boring compared to this now. Other creators were actually asking who made it."</p>
        <i class="fas fa-quote-right quote-icon"></i>
      </div>

      <div class="card review-card hidden-review">
        <div class="rev-user">
          <img src="https://yt3.googleusercontent.com/e3v9QCrFLag6KIqHHKlQhslQhlPYxuIwko7cG3tLOfltyPJFntrxe7WH_UXuKwLSv5i7WytW=s160-c-k-c0x00ffffff-no-rj" class="rev-avatar" alt="Md7">
          <div>
            <div class="rev-name">Md7</div>
            <div class="rev-role">Roblox Youtuber</div>
            <div class="rev-stars">★★★★★</div>
          </div>
        </div>
        <p class="rev-text">"Fast and clean, didn't have to explain things twice. He just got it. Looks insane on mobile too which matters a lot for Roblox content."</p>
        <i class="fas fa-quote-right quote-icon"></i>
      </div>

      <div class="card review-card hidden-review">
        <div class="rev-user">
          <img src="https://yt3.ggpht.com/lv-o4bw3Tub9UigdNSSl2LyKYuhz6270_wa0lT60C2PUQrPNaM0iGYJHuzbgzGDaApEG9cyvHhQ=s176-c-k-c0x00ffffff-no-rj-mo" class="rev-avatar" alt="Abo Som">
          <div>
            <div class="rev-name">Abo Som</div>
            <div class="rev-role">Roblox Developer</div>
            <div class="rev-stars">★★★★☆</div>
          </div>
        </div>
        <p class="rev-text">"Delivered on time and the renders were clean. Had one small revision and he handled it with no issues. Straightforward to work with, will use again."</p>
        <i class="fas fa-quote-right quote-icon"></i>
      </div>

    </div>

    <div class="more-btn-wrapper reveal active" id="loadMoreContainer">
      <button class="more-reviews-btn" id="btnLoadMore">
        <span>Show More Reviews</span> 
        <i class="fas fa-chevron-down"></i>
      </button>
    </div>

  </div>
</section>
@endsection

@push('scripts')
<script>
  document.getElementById('btnLoadMore').addEventListener('click', function() {
    const hiddenReviews = document.querySelectorAll('.hidden-review');
    
    hiddenReviews.forEach((review, index) => {
      // إظهار العنصر في شجرة الـ DOM أولاً لتهيئة المساحة المخصصة له
      review.style.display = 'flex';
      
      // توقيت متتابع متناهي الصغر لعمل تأثير تدرج حركي رهيب (Staggered Animation)
      setTimeout(() => {
        review.style.opacity = '1';
        review.style.transform = 'translateY(0)';
      }, index * 80); 
    });

    // إخفاء حاوية الزر تماماً بعد استعراض كافة الآراء
    document.getElementById('loadMoreContainer').style.display = 'none';
  });
</script>
@endpush