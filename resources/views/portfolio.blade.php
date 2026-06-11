@extends('layouts.app')
@section('title', 'Portfolio | RealAyonato')

@push('styles')
<style>
  /* ضمان شفافية الخلفية لظهور الإيموجيات المضيئة بالخلفية */
  .section.sdark {
    background: none !important;
    background-color: transparent !important;
    box-shadow: none !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
    position: relative;
    z-index: 2;
  }

  .sheader .badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  /* فلاتر على طريقة سبوتيفاي الاحترافية */
  .filter-wrapper { display: flex; justify-content: center; gap: 12px; margin-bottom: 40px; flex-wrap: wrap; }
  .filter-btn { padding: 11px 24px; border-radius: 30px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); color: var(--g400); font-weight: 800; cursor: pointer; transition: all var(--transition); font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.05em; }
  .filter-btn.active, .filter-btn:hover { background: var(--red); color: #fff; border-color: var(--red); box-shadow: 0 0 20px var(--red-glow); transform: scale(1.05); }
  
  /* الحاوية الرئيسية للشبكة */
  .portfolio-grid { 
    position: relative;
    width: 100%;
    margin: 0 auto;
    min-height: 550px; 
    transition: height 0.4s cubic-bezier(0.25, 1, 0.5, 1); 
  }

  /* تنسيق كروت الصور التفاعلية */
  .portfolio-item { 
    position: absolute; 
    cursor: pointer; 
    border-radius: 14px; 
    overflow: hidden; 
    box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
    user-select: none;
    -webkit-user-drag: none;
    background: #111 !important;
    border: 2px solid rgba(255,255,255,0.03) !important;
    padding: 0 !important;
    
    opacity: 0;
    filter: blur(10px);
    transform: scale(0.9);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.35s ease, filter 0.35s ease, border-color 0.3s ease, box-shadow 0.3s ease;
  }

  /* عند تفعيل الظهور */
  .portfolio-item.show-pop {
    opacity: 1;
    filter: blur(0px);
    transform: scale(1);
  }
  
  /* أوفرلاي وتوهج أحمر فخم جداً عند تمرير الماوس */
  .portfolio-item:hover {
    border-color: var(--red) !important;
    box-shadow: 0 0 25px rgba(220, 38, 38, 0.5), 0 15px 35px rgba(0,0,0,0.6);
  }
  
  .portfolio-item img { 
    width: 100%; 
    height: auto; 
    display: block; 
    transition: transform 0.5s ease; 
    pointer-events: none;
    -webkit-user-drag: none;
  }
  
  .portfolio-item:hover img {
    transform: scale(1.03);
  }

  /* بادج للمشاريع الحصرية والجديدة */
  .badge-new {
    position: absolute;
    top: 14px;
    left: 14px;
    background: var(--red);
    color: #ffffff;
    font-size: 0.75rem;
    font-weight: 900;
    padding: 4px 14px;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.5);
    z-index: 5;
    border-radius: 30px; 
    letter-spacing: 0.05em;
    text-transform: uppercase;
    pointer-events: none;
  }
  
  /* طبقة الأوفرلاي التفاعلية السفلية */
  .portfolio-overlay { 
    position: absolute; 
    inset: 0; 
    background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0) 100%); 
    display: flex; 
    flex-direction: column; 
    justify-content: flex-end; 
    padding: 24px; 
    opacity: 0; 
    transition: opacity 0.3s ease;
    z-index: 3;
  }
  
  .portfolio-item:hover .portfolio-overlay { opacity: 1; }
  
  .item-cat { 
    font-size: 0.85rem; 
    font-weight: 900; 
    text-transform: uppercase; 
    color: var(--red); 
    letter-spacing: 2px; 
    transform: translateY(10px);
    transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1);
  }
  .item-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    margin-top: 4px;
    transform: translateY(10px);
    transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1) 0.05s;
  }
  .portfolio-item:hover .item-cat,
  .portfolio-item:hover .item-title { transform: translateY(0); }

  /* ------------------------------------------ */
  /* المودال والـ Lightbox المطور */
  /* ------------------------------------------ */
  .lightbox-modal { 
    position: fixed; 
    inset: 0; 
    background: rgba(5,5,5,0.96); 
    backdrop-filter: blur(16px); 
    -webkit-backdrop-filter: blur(16px);
    z-index: 10000; 
    display: flex; 
    flex-direction: column;
    align-items: center; 
    justify-content: center; 
    opacity: 0; 
    pointer-events: none; 
    transition: opacity 0.4s ease; 
  }
  .lightbox-modal.active { opacity: 1; pointer-events: auto; }
  
  .lightbox-wrapper {
    position: relative;
    max-width: 85vw;
    max-height: 70vh;
    border-radius: 16px;
    border: 2px solid rgba(220, 38, 38, 0.4); 
    box-shadow: 0 0 40px rgba(220, 38, 38, 0.25), 0 30px 70px rgba(0,0,0,0.9);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0d0d0d;
  }

  .lightbox-content { 
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.35s ease, filter 0.35s ease;
  }
  
  .lightbox-content.zooming,
  .lightbox-content.zooming .lightbox-img {
    cursor: cell !important;
  }
  
  /* أنيميشن التنقل الذكي والسلس */
  .slide-out-left { transform: translateX(-60px) scale(0.95); opacity: 0; filter: blur(10px); }
  .slide-out-right { transform: translateX(60px) scale(0.95); opacity: 0; filter: blur(10px); }
  .slide-in-left { transform: translateX(-60px) scale(0.95); opacity: 0; filter: blur(10px); }
  .slide-in-right { transform: translateX(60px) scale(0.95); opacity: 0; filter: blur(10px); }

  .lightbox-img { 
    max-width: 100%; 
    max-height: 70vh; 
    display: block;
    object-fit: contain;
    user-select: none;
    -webkit-user-drag: none;
  }

  /* عدسة المكبر الدائرية */
  .img-magnifier-glass {
    position: fixed; 
    border: 2px solid var(--red);
    border-radius: 50%;
    width: 200px; 
    height: 200px; 
    box-shadow: 0 0 25px rgba(220,38,38,0.5), inset 0 0 20px rgba(0,0,0,0.7);
    display: none; 
    pointer-events: none; 
    z-index: 10010;
  }
  
  /* شريط التحكم السفلي بتصميم مستوحى من تطبيقات الميوزك */
  .lightbox-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 24px;
    margin-top: 30px;
    z-index: 10005;
    background: rgba(15,15,15,0.85);
    padding: 10px 30px;
    border-radius: 40px;
    border: 1px solid rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
  }

  .lightbox-nav { 
    background: none;
    border: none;
    color: var(--g400); 
    font-size: 1.1rem;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--transition);
  }
  .lightbox-nav:hover { background: var(--red); color: #fff; box-shadow: 0 0 15px var(--red-glow); transform: scale(1.05); }
  
  .lightbox-close-btn {
    background: none;
    border: none;
    color: var(--g500);
    font-size: 1.1rem;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--transition);
    margin-left: 10px;
    border-left: 1px solid rgba(255,255,255,0.08);
    padding-left: 20px;
  }
  .lightbox-close-btn:hover { color: var(--red); transform: scale(1.1) rotate(90deg); }

  .lightbox-cat {
    color: #fff;
    font-size: 0.85rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 2px;
    min-width: 130px;
    text-align: center;
  }
</style>
@endpush

@section('content')
<section class="section sdark">
  <div class="container">
    
    <div class="sheader">
      <div class="badge"><span class="bdl"></span><span class="bt">Portfolio</span></div>
      <h2 class="stitle">DESIGNS BUILT TO<br><span>GO VIRAL</span></h2>
      <p class="ssub">Scroll through my best work — thumbnails, GFX, and banners that actually get clicks.</p>
    </div>

    <div class="filter-wrapper">
      <button class="filter-btn active" data-filter="all">All Projects</button>
      <button class="filter-btn" data-filter="Thumbnail">Thumbnails</button>
      <button class="filter-btn" data-filter="GFX">GFX</button>
      <button class="filter-btn" data-filter="Banner">Banners</button>
    </div>

    <div class="portfolio-grid" id="portfolioGrid"></div>
  </div>
</section>

<div class="lightbox-modal" id="lightboxModal">
  <div class="lightbox-wrapper">
    <div class="lightbox-content" id="lightboxContent">
      <img src="" class="lightbox-img" id="lightboxImg" alt="Showcase">
    </div>
  </div>

  <div class="lightbox-controls">
    <button class="lightbox-nav" id="lightboxPrev"><i class="fas fa-chevron-left"></i></button>
    <div class="lightbox-cat" id="lightboxCat">CATEGORY</div>
    <button class="lightbox-nav" id="lightboxNext"><i class="fas fa-chevron-right"></i></button>
    <button class="lightbox-close-btn" id="lightboxClose"><i class="fas fa-times"></i></button>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // قاعدة البيانات الأساسية للمشاريع - تم إصلاح الخطأ البرمجي في السطر الأخير
  const rawPortfolio = [
      { cat:'Thumbnail', img:'https://i.postimg.cc/0jkbGp7Y/TUMBNAIL-1.webp', title:'Epic Battle Layout', isNew: false },
      { cat:'GFX', img:'https://i.postimg.cc/mkLt3Q7H/GFX-1.webp', title:'Cyber GFX Edition', isNew: true }, 
      { cat:'Banner', img:'https://i.postimg.cc/G2J4sMTk/BANNER-1.webp', title:'Channel Header Art', isNew: false },
      { cat:'Thumbnail', img:'https://i.postimg.cc/sxjvPp5J/TUMBNAIL-2.webp', title:'Speed Demon Graphics', isNew: true }, 
      { cat:'GFX', img:'https://i.postimg.cc/fyzJ7xYS/GFX-2.webp', title:'Mystic Character Concept', isNew: false },
      { cat:'Banner', img:'https://i.postimg.cc/sxjvPp5B/BANNER-2.webp', title:'Dark Fantasy Layout', isNew: false },
      { cat:'Thumbnail', img:'https://i.postimg.cc/PJXPbm14/TUMBNAIL-3.webp', title:'Neon Velocity Theme', isNew: false },
      { cat:'GFX', img:'https://i.postimg.cc/XqjpKw9G/GFX-3.webp', title:'Royal Identity GFX', isNew: false },
      { cat:'Thumbnail', img:'https://i.postimg.cc/BbSX5x2p/TUMBNAIL-4.webp', title:'Blaze Stream Design', isNew: true }, 
      { cat:'GFX', img:'https://i.postimg.cc/Vvfd9jX9/GFX-4.webp', title:'Galactic Space Banner', isNew: false }
  ];

  // خلط عشوائي للمشاريع عند أول تحميل لتظهر الصفحة متجددة دائماً
  const shuffledPortfolio = [...rawPortfolio].sort(() => Math.random() - 0.5);
  const grid = document.getElementById('portfolioGrid');
  let activeItems = [...shuffledPortfolio];
  let currentLightboxIdx = 0;

  // الحساب المتقدم لتوزيع الميسونري (Masonry Layout Grid)
  function layoutMasonry() {
    const items = grid.getElementsByClassName('portfolio-item');
    if(items.length === 0) return;

    const gap = 20;
    const gridWidth = grid.offsetWidth;
    
    let columnsCount = 3;
    if (gridWidth < 650) columnsCount = 1;
    else if (gridWidth < 1000) columnsCount = 2;

    const columnWidth = (gridWidth - (gap * (columnsCount - 1))) / columnsCount;
    const columnHeights = Array(columnsCount).fill(0);

    Array.from(items).forEach(item => {
      item.style.width = `${columnWidth}px`;
      
      const minColumnIdx = columnHeights.indexOf(Math.min(...columnHeights));
      const leftPosition = minColumnIdx * (columnWidth + gap);
      const topPosition = columnHeights[minColumnIdx];

      item.style.left = `${leftPosition}px`;
      item.style.top = `${topPosition}px`;
      
      columnHeights[minColumnIdx] += item.offsetHeight + gap;

      // تأثير الظهور التفاعلي المتدرج
      setTimeout(() => { item.classList.add('show-pop'); }, 60);
    });

    grid.style.height = `${Math.max(...columnHeights) - gap}px`;
  }

  // توليد كروت المشاريع بالـ DOM بشكل حي
  function renderGrid(itemsToRender) {
    grid.innerHTML = '';
    itemsToRender.forEach((item, index) => {
      const el = document.createElement('div');
      el.className = `portfolio-item`; 
      
      let badgeHTML = item.isNew ? `<div class="badge-new">New</div>` : '';
      
      el.innerHTML = `
        ${badgeHTML}
        <img src="${item.img}" alt="${item.title}" draggable="false">
        <div class="portfolio-overlay">
          <div class="item-cat">${item.cat}</div>
          <div class="item-title">${item.title}</div>
        </div>
      `;
      
      el.querySelector('img').addEventListener('load', layoutMasonry);
      el.addEventListener('click', () => openLightbox(index));
      grid.appendChild(el);
    });
    setTimeout(layoutMasonry, 100);
  }
  
  // التشغيل المبدئي للجريد
  renderGrid(shuffledPortfolio);
  window.addEventListener('resize', layoutMasonry);
  window.addEventListener('load', layoutMasonry); // إضافة لضمان الأبعاد عند البناء المحلي

  // أنيميشن الفلترة التفاعلي (مثل نظام الفئات في سبوتيفاي)
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const activeBtn = document.querySelector('.filter-btn.active');
      if (activeBtn) activeBtn.classList.remove('active');
      
      e.target.classList.add('active');
      const filter = e.target.getAttribute('data-filter');
      
      // إخفاء العناصر أولاً بسلاسة قبل الفلترة
      const items = grid.getElementsByClassName('portfolio-item');
      Array.from(items).forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'scale(0.9) translateY(10px)';
        item.style.filter = 'blur(10px)';
      });

      setTimeout(() => {
        activeItems = filter === 'all' ? [...shuffledPortfolio] : shuffledPortfolio.filter(i => i.cat === filter);
        renderGrid(activeItems);
      }, 300); // الانتظار حتى ينتهي أنيميشن الاختفاء
    });
  });

  /* نظام البوب أب والـ Lightbox المطور */
  const modal = document.getElementById('lightboxModal');
  const modalImg = document.getElementById('lightboxImg');
  const modalContent = document.getElementById('lightboxContent');
  const modalCat = document.getElementById('lightboxCat');
  let glass; 

  function openLightbox(idx) { 
    currentLightboxIdx = idx;
    destroyMagnifier();
    
    modalImg.src = activeItems[currentLightboxIdx].img; 
    modalCat.textContent = activeItems[currentLightboxIdx].cat + " — " + (currentLightboxIdx + 1) + "/" + activeItems.length;
    
    modalContent.className = "lightbox-content"; 
    modal.classList.add('active'); 
    
    setTimeout(() => { initMagnifier(modalImg, 2); }, 200); 
  }

  function navigateLightbox(direction) {
    destroyMagnifier();
    
    if (direction === 'next') {
      modalContent.classList.add('slide-out-left');
      setTimeout(() => {
        currentLightboxIdx = (currentLightboxIdx + 1) % activeItems.length;
        updateModalData();
        modalContent.className = 'lightbox-content slide-in-right';
        setTimeout(() => { finishNavigation(); }, 50);
      }, 250);
      
    } else {
      modalContent.classList.add('slide-out-right');
      setTimeout(() => {
        currentLightboxIdx = (currentLightboxIdx - 1 + activeItems.length) % activeItems.length;
        updateModalData();
        modalContent.className = 'lightbox-content slide-in-left';
        setTimeout(() => { finishNavigation(); }, 50);
      }, 250);
    }
  }

  function updateModalData() {
    modalImg.src = activeItems[currentLightboxIdx].img;
    modalCat.textContent = activeItems[currentLightboxIdx].cat + " — " + (currentLightboxIdx + 1) + "/" + activeItems.length;
  }

  function finishNavigation() {
    modalContent.className = 'lightbox-content'; 
    initMagnifier(modalImg, 2);
  }

  // أحداث أزرار التحكم والكي بورد للتنقل السريع
  document.getElementById('lightboxNext').addEventListener('click', () => navigateLightbox('next'));
  document.getElementById('lightboxPrev').addEventListener('click', () => navigateLightbox('prev'));
  document.getElementById('lightboxClose').addEventListener('click', () => { modal.classList.remove('active'); destroyMagnifier(); });
  modal.addEventListener('click', (e) => { if(e.target === modal) { modal.classList.remove('active'); destroyMagnifier(); } });

  document.addEventListener('keydown', (e) => {
    if (!modal.classList.contains('active')) return;
    if (e.key === 'ArrowRight') navigateLightbox('next');
    if (e.key === 'ArrowLeft') navigateLightbox('prev');
    if (e.key === 'Escape') { modal.classList.remove('active'); destroyMagnifier(); }
  });

  /* عدسة التكبير الاحترافية متوافقة مع الماوس واللمس */
  function initMagnifier(img, zoom) {
    let isZooming = false;
    
    glass = document.createElement("DIV");
    glass.setAttribute("class", "img-magnifier-glass");
    document.getElementById('lightboxModal').appendChild(glass);
    
    glass.style.backgroundImage = "url('" + img.src + "')";
    glass.style.backgroundRepeat = "no-repeat";

    img.parentElement.addEventListener("mousedown", (e) => { startZoom(e); });
    window.addEventListener("mouseup", () => { stopZoom(); });
    img.parentElement.addEventListener("mousemove", (e) => { if (isZooming) moveMagnifier(e); });
    
    img.parentElement.addEventListener("touchstart", (e) => { startZoom(e); }, {passive: false});
    window.addEventListener("touchend", () => { stopZoom(); });
    img.parentElement.addEventListener("touchmove", (e) => { if (isZooming) moveMagnifier(e); }, {passive: false});

    function startZoom(e) {
      isZooming = true;
      glass.style.display = "block";
      modalContent.classList.add('zooming'); 
      moveMagnifier(e);
    }

    function stopZoom() {
      isZooming = false;
      if(glass) glass.style.display = "none";
      modalContent.classList.remove('zooming'); 
    }

    function moveMagnifier(e) {
      e.preventDefault();
      
      const imgWidth = img.offsetWidth;
      const imgHeight = img.offsetHeight;
      glass.style.backgroundSize = (imgWidth * zoom) + "px " + (imgHeight * zoom) + "px";

      let clientX = 0, clientY = 0;
      if (e.changedTouches && e.changedTouches.length > 0) {
        clientX = e.changedTouches[0].clientX;
        clientY = e.changedTouches[0].clientY;
      } else {
        clientX = e.clientX;
        clientY = e.clientY;
      }

      const glassRect = glass.getBoundingClientRect();
      const w = glassRect.width / 2;
      const h = glassRect.height / 2;

      glass.style.left = (clientX - w) + "px";
      glass.style.top = (clientY - h) + "px";
      
      let imgRect = img.getBoundingClientRect();
      let x = clientX - imgRect.left;
      let y = clientY - imgRect.top;
      
      if (x > imgWidth) { x = imgWidth; }
      if (x < 0) { x = 0; }
      if (y > imgHeight) { y = imgHeight; }
      if (y < 0) { y = 0; }
      
      let pctX = (x / imgWidth) * 100;
      let pctY = (y / imgHeight) * 100;
      
      glass.style.backgroundPosition = `${pctX}% ${pctY}%`;
    }
  }

  function destroyMagnifier() {
    const existingGlasses = document.querySelectorAll('.img-magnifier-glass');
    existingGlasses.forEach(g => g.remove());
    modalContent.classList.remove('zooming');
  }

  document.addEventListener('dragstart', function(e) { if (e.target.tagName === 'IMG') e.preventDefault(); });
  document.addEventListener('contextmenu', function(e) { e.preventDefault(); });
</script>
@endpush