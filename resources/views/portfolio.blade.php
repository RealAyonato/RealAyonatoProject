@extends('layouts.app')
@section('title', 'My Portfolio — RealAyonato')

@push('styles')
<style>
  /* ضمان شفافية الخلفية لظهور الإيموجيات */
  .section.sdark {
    background: none !important;
    background-color: transparent !important;
    box-shadow: none !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
    position: relative;
    z-index: 2;
  }

  /* إرجاع البادج العلوي للوضع الافتراضي المستقر بدون أي تحريك */
  .sheader .badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .filter-wrapper { display: flex; justify-content: center; gap: 12px; margin-bottom: 30px; flex-wrap: wrap; }
  .filter-btn { padding: 10px 22px; border-radius: 30px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: var(--g400); font-weight: 700; cursor: pointer; transition: all var(--transition); font-size: 0.88rem; }
  .filter-btn.active, .filter-btn:hover { background: var(--red); color: #fff; border-color: var(--red); box-shadow: 0 0 15px var(--red-glow); }
  
  /* الحاوية الرئيسية للشبكة */
  .portfolio-grid { 
    position: relative;
    width: 100%;
    margin: 0 auto;
    min-height: 550px; 
    transition: height 0.3s ease; 
  }

  /* تنسيق كروت الصور */
  .portfolio-item { 
    position: absolute; 
    cursor: pointer; 
    border-radius: 12px; 
    overflow: hidden; 
    box-shadow: 0 10px 25px rgba(0,0,0,0.3); 
    user-select: none;
    -webkit-user-drag: none;
    background: transparent !important;
    border: 2px solid transparent !important;
    padding: 0 !important;
    
    opacity: 0;
    filter: blur(15px);
    transform: scale(0.85);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.4s ease, filter 0.4s ease, border-color 0.3s ease, box-shadow 0.3s ease;
  }

  .portfolio-item.show-pop {
    opacity: 1;
    filter: blur(0px);
    transform: scale(1);
  }
  
  /* أوت لاين أحمر متوهج عند الهوفر */
  .portfolio-item:hover {
    border-color: #ff0000 !important;
    box-shadow: 0 0 20px rgba(255, 0, 0, 0.6), 0 10px 25px rgba(0,0,0,0.5);
  }
  
  .portfolio-item img { 
    width: 100%; 
    height: auto; 
    display: block; 
    transition: transform 0.4s ease; 
    pointer-events: none;
    -webkit-user-drag: none;
  }

  /* تثبيت مطلق آمن داخل إطار الصورة يمنع التشوه */
  .badge-new {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: #ff0000;
    color: #ffffff;
    font-size: 0.78rem;
    font-weight: 800;
    padding: 4px 14px;
    box-shadow: 0 4px 12px rgba(255, 0, 0, 0.5);
    z-index: 5;
    border-radius: 30px; 
    letter-spacing: 0.5px;
    pointer-events: none;
  }
  
  /* طبقة الهوفر بالأسفل */
  .portfolio-overlay { 
    position: absolute; 
    inset: 0; 
    background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.4) 40%, rgba(0, 0, 0, 0) 100%); 
    display: flex; 
    flex-direction: column; 
    justify-content: flex-end; 
    padding: 20px; 
    opacity: 0; 
    transition: opacity 0.3s ease;
    z-index: 3;
  }
  
  .portfolio-item:hover .portfolio-overlay { opacity: 1; }
  
  .item-cat { 
    font-size: 0.9rem; 
    font-weight: 800; 
    text-transform: uppercase; 
    color: #fff; 
    letter-spacing: 1.5px; 
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8); 
    transform: translateY(8px);
    transition: transform 0.3s ease;
  }
  .portfolio-item:hover .item-cat { transform: translateY(0); }

  /* ------------------------------------------ */
  /* المودال والبوب أب المطور (Lightbox) */
  /* ------------------------------------------ */
  .lightbox-modal { 
    position: fixed; 
    inset: 0; 
    background: rgba(4,4,4,0.92); 
    backdrop-filter: blur(20px); 
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
    border-radius: 14px;
    border: 3px solid #ff0000; 
    box-shadow: 0 0 35px rgba(255, 0, 0, 0.5), 0 25px 60px rgba(0,0,0,0.8);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #111;
  }

  .lightbox-content { 
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.4s ease, filter 0.4s ease;
  }
  
  /* شكل الماوس على هيئة علامة زائد (+) صريحة ومميزة عند عملية الزوم */
  .lightbox-content.zooming,
  .lightbox-content.zooming .lightbox-img {
    cursor: cell !important;
  }
  
  /* أنيميشن التنقل */
  .slide-out-left { transform: translateX(-100px) scale(0.95); opacity: 0; filter: blur(20px); }
  .slide-out-right { transform: translateX(100px) scale(0.95); opacity: 0; filter: blur(20px); }
  .slide-in-left { transform: translateX(-100px) scale(0.95); opacity: 0; filter: blur(20px); }
  .slide-in-right { transform: translateX(100px) scale(0.95); opacity: 0; filter: blur(20px); }

  .lightbox-img { 
    max-width: 100%; 
    max-height: 70vh; 
    display: block;
    object-fit: contain;
    user-select: none;
    -webkit-user-drag: none;
  }

  /* عدسة المكبر المحدثة */
  .img-magnifier-glass {
    position: fixed; 
    border: 3px solid #ff0000;
    border-radius: 50%;
    width: 180px; 
    height: 180px; 
    box-shadow: 0 0 20px rgba(255,0,0,0.6), inset 0 0 15px rgba(0,0,0,0.6);
    display: none; 
    pointer-events: none; 
    z-index: 10010;
  }
  
  /* شريط التحكم السفلي المدمج */
  .lightbox-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-top: 25px;
    z-index: 10005;
    background: rgba(0,0,0,0.75);
    padding: 8px 25px;
    border-radius: 40px;
    border: 1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
  }

  .lightbox-nav { 
    background: none;
    border: none;
    color: #fff; 
    font-size: 1.2rem;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
  }
  .lightbox-nav:hover { background: #ff0000; color: #fff; box-shadow: 0 0 15px rgba(255,0,0,0.6); }
  
  .lightbox-close-btn {
    background: none;
    border: none;
    color: rgba(255,255,255,0.6);
    font-size: 1.2rem;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    margin-left: 10px;
    border-left: 1px solid rgba(255,255,255,0.1);
    padding-left: 15px;
  }
  .lightbox-close-btn:hover { color: #ff0000; transform: scale(1.1); }

  .lightbox-cat {
    color: #fff;
    font-size: 0.95rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    min-width: 110px;
    text-align: center;
  }
</style>
@endpush

@section('content')
<section class="section sdark">
  <div class="container">
    
    <div class="sheader reveal active">
      <div class="badge"><span class="bdl"></span><span class="bt">Portfolio</span></div>
      <h2 class="stitle">DESIGNS BUILT TO<br><span>GO VIRAL</span></h2>
      <p class="ssub">Scroll through my best work — thumbnails, GFX, and banners that actually get clicks.</p>
    </div>

    <div class="filter-wrapper reveal active">
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

  const shuffledPortfolio = [...rawPortfolio].sort(() => Math.random() - 0.5);
  const grid = document.getElementById('portfolioGrid');
  let activeItems = [...shuffledPortfolio];
  let currentLightboxIdx = 0;

  function layoutMasonry() {
    const items = grid.getElementsByClassName('portfolio-item');
    if(items.length === 0) return;

    const gap = 16;
    const gridWidth = grid.offsetWidth;
    
    let columnsCount = 3;
    if (gridWidth < 600) columnsCount = 1;
    else if (gridWidth < 992) columnsCount = 2;

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

      setTimeout(() => { item.classList.add('show-pop'); }, 50);
    });

    grid.style.height = `${Math.max(...columnHeights) - gap}px`;
  }

  function renderGrid(itemsToRender) {
    grid.innerHTML = '';
    itemsToRender.forEach((item, index) => {
      const el = document.createElement('div');
      el.className = `portfolio-item`; 
      
      let badgeHTML = item.isNew ? `<div class="badge-new">New!</div>` : '';
      
      el.innerHTML = `${badgeHTML}<img src="${item.img}" alt="${item.cat}" draggable="false"><div class="portfolio-overlay"><div class="item-cat">${item.cat}</div></div>`;
      
      el.querySelector('img').addEventListener('load', layoutMasonry);
      el.addEventListener('click', () => openLightbox(index));
      grid.appendChild(el);
    });
    setTimeout(layoutMasonry, 100);
  }
  
  renderGrid(shuffledPortfolio);
  window.addEventListener('resize', layoutMasonry);

  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      document.querySelector('.filter-btn.active').classList.remove('active');
      e.target.classList.add('active');
      const filter = e.target.getAttribute('data-filter');
      activeItems = filter === 'all' ? [...shuffledPortfolio] : shuffledPortfolio.filter(i => i.cat === filter);
      renderGrid(activeItems);
    });
  });

  /* البوب أب والتحكم */
  const modal = document.getElementById('lightboxModal');
  const modalImg = document.getElementById('lightboxImg');
  const modalContent = document.getElementById('lightboxContent');
  const modalCat = document.getElementById('lightboxCat');
  
  let glass; 

  function openLightbox(idx) { 
    currentLightboxIdx = idx;
    destroyMagnifier();
    
    modalImg.src = activeItems[currentLightboxIdx].img; 
    modalCat.textContent = activeItems[currentLightboxIdx].cat;
    
    modalContent.className = "lightbox-content"; 
    modal.classList.add('active'); 
    
    setTimeout(() => { initMagnifier(modalImg, 1.8); }, 150); 
  }

  function navigateLightbox(direction) {
    destroyMagnifier();
    
    if (direction === 'next') {
      modalContent.classList.add('slide-out-left');
      setTimeout(() => {
        currentLightboxIdx = (currentLightboxIdx + 1) % activeItems.length;
        modalImg.src = activeItems[currentLightboxIdx].img;
        modalCat.textContent = activeItems[currentLightboxIdx].cat;
        modalContent.className = 'lightbox-content slide-in-right';
        
        setTimeout(() => { 
          modalContent.className = 'lightbox-content'; 
          initMagnifier(modalImg, 1.8);
        }, 50);
      }, 300);
      
    } else {
      modalContent.classList.add('slide-out-right');
      setTimeout(() => {
        currentLightboxIdx = (currentLightboxIdx - 1 + activeItems.length) % activeItems.length;
        modalImg.src = activeItems[currentLightboxIdx].img;
        modalCat.textContent = activeItems[currentLightboxIdx].cat;
        modalContent.className = 'lightbox-content slide-in-left';
        
        setTimeout(() => { 
          modalContent.className = 'lightbox-content'; 
          initMagnifier(modalImg, 1.8);
        }, 50);
      }, 300);
    }
  }

  document.getElementById('lightboxNext').addEventListener('click', () => navigateLightbox('next'));
  document.getElementById('lightboxPrev').addEventListener('click', () => navigateLightbox('prev'));
  document.getElementById('lightboxClose').addEventListener('click', () => { modal.classList.remove('active'); destroyMagnifier(); });
  modal.addEventListener('click', (e) => { if(e.target === modal) { modal.classList.remove('active'); destroyMagnifier(); } });

  /* نظام السنترة المطلق للعدسة مع مؤشر الماوس المتغير إلى (+) بشكل ثابت */
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
    
    img.parentElement.addEventListener("touchstart", (e) => { startZoom(e); });
    window.addEventListener("touchend", () => { stopZoom(); });
    img.parentElement.addEventListener("touchmove", (e) => { if (isZooming) moveMagnifier(e); });

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

      // حساب منصف الدائرة هندسياً بدقة متناهية
      const glassRect = glass.getBoundingClientRect();
      const w = glassRect.width / 2;
      const h = glassRect.height / 2;

      // وضع مركز عدسة التكبير تحت رأس كورسور الـ (+) تماماً وبدون أي انزياح
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