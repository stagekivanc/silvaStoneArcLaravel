const yearEl = document.getElementById('year');
if (yearEl) yearEl.textContent = new Date().getFullYear();

/* Header */
const header = document.getElementById('site-header');
function onScroll() {
  if (!header) return;
  const inner = Boolean(document.body.dataset.page);
  header.classList.toggle('is-scrolled', inner || window.scrollY > 40);
}
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

document.querySelectorAll('.lang-btn').forEach((btn) => {
  btn.addEventListener('click', () => {
    const lang = btn.getAttribute('data-lang');
    document.querySelectorAll('.lang-btn').forEach((el) => {
      el.classList.toggle('is-active', el.getAttribute('data-lang') === lang);
    });
  });
});

/* Animated dropdown menu */
const menuToggle = document.getElementById('menu-toggle');
const navDropdown = document.getElementById('nav-dropdown');
const menuToggleIcon = document.getElementById('menu-toggle-icon');
const menuWrap = document.querySelector('.menu-wrap');

function isMobileNav() {
  return window.matchMedia('(max-width: 1023px)').matches;
}

function placeNav() {
  if (!navDropdown || !menuWrap) return;
  if (isMobileNav()) {
    if (navDropdown.parentElement !== document.body) document.body.appendChild(navDropdown);
  } else if (navDropdown.parentElement !== menuWrap) {
    menuWrap.appendChild(navDropdown);
  }
}

function openMenu() {
  if (!navDropdown || !menuToggle) return;
  placeNav();
  navDropdown.classList.add('is-open');
  navDropdown.setAttribute('aria-hidden', 'false');
  menuToggle.setAttribute('aria-expanded', 'true');
  document.body.classList.add('menu-open');
  if (menuToggleIcon) {
    menuToggleIcon.classList.remove('bx-grid-alt');
    menuToggleIcon.classList.add('bx-x');
  }
}

function closeMenu() {
  if (!navDropdown || !menuToggle) return;
  navDropdown.classList.remove('is-open');
  navDropdown.setAttribute('aria-hidden', 'true');
  menuToggle.setAttribute('aria-expanded', 'false');
  document.body.classList.remove('menu-open');
  if (menuToggleIcon) {
    menuToggleIcon.classList.remove('bx-x');
    menuToggleIcon.classList.add('bx-grid-alt');
  }
}

if (menuToggle && navDropdown) {
  placeNav();
  window.addEventListener('resize', () => {
    placeNav();
    if (!isMobileNav() && document.body.classList.contains('menu-open')) closeMenu();
  });

  menuToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    if (navDropdown.classList.contains('is-open')) closeMenu();
    else openMenu();
  });

  document.querySelectorAll('.nav-drop-close').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      closeMenu();
    });
  });

  document.querySelectorAll('.nav-drop-link, .nav-drop-cta, .nav-drop-phone').forEach((link) => {
    link.addEventListener('click', closeMenu);
  });

  document.addEventListener('click', (e) => {
    if (!navDropdown.classList.contains('is-open')) return;
    if (menuWrap && menuWrap.contains(e.target)) return;
    if (navDropdown.contains(e.target)) return;
    closeMenu();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && navDropdown.classList.contains('is-open')) closeMenu();
  });
}

/* Hero scene slider */
const heroSection = document.querySelector('.hero');
if (heroSection) {
  const scenes = window.SILVA_HERO_SLIDES || [];
  const bgImgs = [...heroSection.querySelectorAll('[data-hero-bg]')];
  const kickerEl = document.getElementById('hero-kicker');
  const titleEl = document.getElementById('hero-title');
  const leadEl = document.getElementById('hero-lead');
  const sceneDotsWrap = document.getElementById('hero-scene-dots');
  let sceneIndex = 0;
  let sceneTimer = null;
  const SCENE_MS = 6500;

  if (sceneDotsWrap && scenes.length) {
    sceneDotsWrap.innerHTML = scenes
      .map((_, i) => `<button type="button"${i === 0 ? ' class="is-active"' : ''} data-scene="${i}" aria-label="Sahne ${i + 1}"></button>`)
      .join('');
  }
  const sceneDots = [...heroSection.querySelectorAll('[data-scene]')];

  const goScene = (next) => {
    if (!scenes.length) return;
    sceneIndex = (next + scenes.length) % scenes.length;
    const slide = scenes[sceneIndex];
    bgImgs.forEach((img) => img.classList.toggle('is-active', Number(img.dataset.heroBg) === sceneIndex));
    heroSection.classList.toggle('is-light', slide.tone === 'light');
    if (kickerEl) kickerEl.textContent = slide.kicker;
    if (titleEl) titleEl.textContent = slide.title;
    if (leadEl) leadEl.textContent = slide.lead;
    sceneDots.forEach((dot, i) => dot.classList.toggle('is-active', i === sceneIndex));
  };

  const stopScene = () => {
    if (sceneTimer) {
      clearInterval(sceneTimer);
      sceneTimer = null;
    }
  };
  const startScene = () => {
    stopScene();
    if (scenes.length < 2 || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    sceneTimer = setInterval(() => goScene(sceneIndex + 1), SCENE_MS);
  };

  sceneDots.forEach((dot) => {
    dot.addEventListener('click', (e) => {
      e.stopPropagation();
      goScene(Number(dot.dataset.scene));
      startScene();
    });
  });

  const isHeroControl = (target) =>
    Boolean(target.closest('.hero-scene-dots, a, button'));

  const stepFromPoint = (clientX) => {
    const rect = heroSection.getBoundingClientRect();
    goScene(clientX - rect.left < rect.width / 2 ? sceneIndex - 1 : sceneIndex + 1);
    startScene();
  };

  heroSection.addEventListener('mousemove', (e) => {
    if (isHeroControl(e.target)) {
      heroSection.style.cursor = '';
      return;
    }
    const rect = heroSection.getBoundingClientRect();
    heroSection.style.cursor = e.clientX - rect.left < rect.width / 2 ? 'w-resize' : 'e-resize';
  });
  heroSection.addEventListener('mouseleave', () => {
    heroSection.style.cursor = '';
  });

  let dragX = 0;
  let dragging = false;
  heroSection.addEventListener('pointerdown', (e) => {
    if (e.pointerType === 'mouse' && e.button !== 0) return;
    if (isHeroControl(e.target)) return;
    dragging = true;
    dragX = e.clientX;
  });
  heroSection.addEventListener('pointerup', (e) => {
    if (!dragging) return;
    dragging = false;
    const delta = e.clientX - dragX;
    if (Math.abs(delta) >= 40) {
      goScene(delta < 0 ? sceneIndex + 1 : sceneIndex - 1);
      startScene();
      return;
    }
    stepFromPoint(e.clientX);
  });
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) stopScene();
    else startScene();
  });
  goScene(0);
  startScene();
}

/* Home product catalog */
const homeCatalog = document.querySelector('.home-catalog');
if (homeCatalog) {
  const filtersEl = document.getElementById('home-cat-filters');
  const gridEl = document.getElementById('home-catalog-grid');
  const emptyEl = document.getElementById('home-catalog-empty');
  const cats = window.SILVA_CATS || {};
  const allProducts = window.SILVA_PRODUCTS || [];
  const featuredCodes = window.SILVA_HOME_FEATURED || [];
  const products = featuredCodes.length
    ? featuredCodes.map((code) => allProducts.find((p) => p.code === code)).filter(Boolean)
    : allProducts;
  const esc = (v) => String(v).replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
  let activeCat = 'all';

  const renderFilters = () => {
    if (!filtersEl) return;
    filtersEl.innerHTML = Object.entries(cats)
      .map(
        ([key, label]) =>
          `<button type="button" role="tab" data-cat="${esc(key)}" aria-selected="${key === activeCat ? 'true' : 'false'}" class="${key === activeCat ? 'is-active' : ''}">${esc(label)}</button>`
      )
      .join('');
  };

  const renderGrid = () => {
    if (!gridEl) return;
    const list = products.filter((p) => activeCat === 'all' || p.cat === activeCat);
    if (emptyEl) emptyEl.hidden = list.length > 0;
    gridEl.innerHTML = list
      .map((p) => {
        const href = window.silvaHref(p);
        const name = window.silvaTitle(p);
        const badge = p.badge || p.code;
        const spec = window.silvaSpec ? window.silvaSpec(p) : '';
        const img = p.img
          ? `<img src="${esc(p.img)}" alt="${esc(p.name)}" loading="lazy" />`
          : '<span class="plp-ph">Ürün resmi hazırlanıyor</span>';
        return `<article class="home-card">
          <a class="home-card-media" href="${esc(href)}" aria-label="${esc(name)}">
            ${img}
            ${badge ? `<span class="home-card-badge">${esc(badge)}</span>` : ''}
          </a>
          <div class="home-card-body">
            <h3>${esc(name)}</h3>
            ${spec ? `<p>${esc(spec)}</p>` : ''}
            <a class="home-card-more" href="${esc(href)}">incele →</a>
          </div>
        </article>`;
      })
      .join('');
  };

  filtersEl?.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-cat]');
    if (!btn) return;
    activeCat = btn.dataset.cat;
    renderFilters();
    renderGrid();
  });

  renderFilters();
  renderGrid();
}

/* Scroll reveal */
const revealEls = document.querySelectorAll('.feature-grid, .space-tile');
if ('IntersectionObserver' in window) {
  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.22, rootMargin: '0px 0px -12% 0px' }
  );
  revealEls.forEach((el) => io.observe(el));
} else {
  revealEls.forEach((el) => el.classList.add('is-visible'));
}

function handleForm(event) {
  event.preventDefault();
  document.getElementById('form-success').classList.remove('hidden');
  event.target.reset();
  return false;
}

/* Showroom city + nearest filter */
const storeGrid = document.getElementById('store-grid');
if (storeGrid) {
  const cards = [...storeGrid.querySelectorAll('.store-card')];
  const citySelect = document.getElementById('store-city');
  const nearBtn = document.getElementById('store-near');
  const note = document.getElementById('store-filter-note');
  let activeCity = 'all';

  const toRad = (d) => (d * Math.PI) / 180;
  const kmBetween = (aLat, aLng, bLat, bLng) => {
    const R = 6371;
    const dLat = toRad(bLat - aLat);
    const dLng = toRad(bLng - aLng);
    const h =
      Math.sin(dLat / 2) ** 2 +
      Math.cos(toRad(aLat)) * Math.cos(toRad(bLat)) * Math.sin(dLng / 2) ** 2;
    return 2 * R * Math.asin(Math.sqrt(h));
  };

  const formatKm = (km) => (km < 10 ? `${km.toFixed(1)} km` : `${Math.round(km)} km`);

  const setNote = (text) => {
    if (!note) return;
    note.hidden = !text;
    note.textContent = text || '';
  };

  const applyFilter = () => {
    cards.forEach((card) => {
      const match = activeCity === 'all' || card.dataset.city === activeCity;
      card.classList.toggle('is-hidden', !match);
    });
    syncMap();
  };

  const setCity = (city, { fromNear = false } = {}) => {
    activeCity = city;
    if (citySelect && citySelect.value !== city) citySelect.value = city;
    if (!fromNear && nearBtn) nearBtn.classList.remove('is-active');
    applyFilter();
  };

  const applyDistances = (lat, lng) => {
    const ranked = cards
      .map((card) => {
        const km = kmBetween(lat, lng, Number(card.dataset.lat), Number(card.dataset.lng));
        return { card, km };
      })
      .sort((a, b) => a.km - b.km);

    ranked.forEach(({ card, km }, i) => {
      card.classList.toggle('is-nearest', i === 0);
      let dist = card.querySelector('.store-card-dist');
      if (!dist) {
        dist = document.createElement('p');
        dist.className = 'store-card-dist';
        card.querySelector('.store-card-top').after(dist);
      }
      dist.textContent = formatKm(km);
      storeGrid.appendChild(card);
    });

    return ranked[0];
  };

  citySelect?.addEventListener('change', () => {
    const city = citySelect.value || 'all';
    setCity(city);
    if (city === 'all') setNote('');
    else {
      const label = citySelect.options[citySelect.selectedIndex]?.textContent.trim() || city;
      const count = cards.filter((c) => c.dataset.city === city).length;
      setNote(`${label} · ${count} showroom`);
    }
  });

  const qCity = new URLSearchParams(location.search).get('city');
  if (qCity && citySelect?.querySelector(`option[value="${CSS.escape(qCity)}"]`)) {
    setCity(qCity);
    const label = citySelect.options[citySelect.selectedIndex]?.textContent.trim() || qCity;
    const count = cards.filter((c) => c.dataset.city === qCity).length;
    setNote(`${label} · ${count} showroom`);
  }

  if (nearBtn) {
    const locate = (options) =>
      new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject, options);
      });

    const geoMessage = (err) => {
      const code = err && err.code;
      if (!window.isSecureContext) return 'Konum için sayfanın https ile açılması gerekir.';
      if (code === 1) return 'Konum izni tarayıcı veya macOS/iOS ayarlarında kapalı. Chrome/Safari için Sistem Ayarları > Gizlilik > Konum’u kontrol edin.';
      if (code === 2) return 'Konum şu an alınamadı. Wi‑Fi açıkken tekrar deneyin veya şehir listesinden seçin.';
      if (code === 3) return 'Konum zaman aşımına uğradı. Tekrar deneyin veya şehir listesinden seçin.';
      return 'Konum alınamadı. Şehir listesinden seçim yapabilirsiniz.';
    };

    nearBtn.addEventListener('click', async () => {
      if (!navigator.geolocation) {
        setNote('Tarayıcınız konum özelliğini desteklemiyor.');
        return;
      }
      if (!window.isSecureContext) {
        setNote(geoMessage({ code: 0 }));
        return;
      }
      nearBtn.disabled = true;
      setNote('Konumunuz alınıyor…');
      try {
        let pos;
        try {
          pos = await locate({ enableHighAccuracy: false, timeout: 20000, maximumAge: 300000 });
        } catch (first) {
          if (first && first.code === 3) {
            pos = await locate({ enableHighAccuracy: false, timeout: 25000, maximumAge: 0 });
          } else {
            throw first;
          }
        }
        const nearest = applyDistances(pos.coords.latitude, pos.coords.longitude);
        if (!nearest) throw new Error('no-store');
        const city = nearest.card.dataset.city;
        const cityLabel = nearest.card.querySelector('.store-card-city').textContent.trim();
        setCity(city, { fromNear: true });
        nearBtn.classList.add('is-active');
        setNote(`Size en yakın şehir: ${cityLabel} · ${formatKm(nearest.km)}`);
      } catch (err) {
        setNote(geoMessage(err));
      } finally {
        nearBtn.disabled = false;
      }
    });
  }
}

let storeMap = null;
let storeMarkers = [];

function syncMap() {
  if (!storeMap || !window.L || !storeMarkers.length) return;
  const city = document.getElementById('store-city')?.value || 'all';
  const visible = storeMarkers.filter((m) => city === 'all' || m._storeCity === city);
  storeMarkers.forEach((m) => {
    const on = city === 'all' || m._storeCity === city;
    m.setOpacity(on ? 1 : 0.35);
    m.setZIndexOffset(on ? 200 : 0);
  });
  const group = visible.length ? visible : storeMarkers;
  storeMap.fitBounds(L.featureGroup(group).getBounds().pad(group.length === 1 ? 0.45 : 0.22), {
    maxZoom: group.length === 1 ? 14 : 6,
    animate: true,
  });
}

function initStoreMap() {
  const mapEl = document.getElementById('store-map');
  if (!mapEl || !window.L) return;
  const cards = [...document.querySelectorAll('#store-grid .store-card')];
  if (!cards.length) return;

  const esc = (s) =>
    String(s).replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));

  storeMap = L.map(mapEl, {
    scrollWheelZoom: false,
    zoomControl: true,
    attributionControl: true,
  }).setView([39.2, 35.1], 6);

  L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
    attribution: '&copy; Google',
  }).addTo(storeMap);

  storeMarkers = cards
    .map((card) => {
      const lat = Number(card.dataset.lat);
      const lng = Number(card.dataset.lng);
      if (!Number.isFinite(lat) || !Number.isFinite(lng)) return null;
      const num = card.querySelector('.store-card-num')?.textContent.trim() || '';
      const name = card.querySelector('.store-card-name')?.textContent.trim() || '';
      const city = card.querySelector('.store-card-city')?.textContent.trim() || '';
      const addr = card.querySelector('.store-card-addr')?.textContent.trim() || '';
      const phone = card.querySelector('.store-card-link[href^="tel:"]');
      const mapLink = card.querySelector('.store-card-link--map');
      const phoneHref = phone?.getAttribute('href') || 'tel:+908503460226';
      const phoneLabel = phone?.textContent.replace(/\s+/g, ' ').trim() || '+90 850 346 02 26';
      const dirHref = mapLink?.getAttribute('href') || '';

      const marker = L.marker([lat, lng], {
        icon: L.divIcon({
          className: 'store-marker-wrap',
          html: `<span class="store-marker"><b>${esc(num)}</b></span>`,
          iconSize: [32, 42],
          iconAnchor: [16, 40],
          popupAnchor: [0, -36],
        }),
        title: name,
      }).addTo(storeMap);

      marker._storeCity = card.dataset.city;
      marker._storeCard = card;
      marker.bindPopup(
        `<div class="store-popup">
          <p class="store-popup-city">${esc(city)}</p>
          <strong>${esc(name)}</strong>
          <p class="store-popup-addr">${esc(addr)}</p>
          <div class="store-popup-actions">
            <a href="${esc(phoneHref)}">${esc(phoneLabel)}</a>
            ${dirHref ? `<a href="${esc(dirHref)}" target="_blank" rel="noopener">Yol tarifi al</a>` : ''}
          </div>
        </div>`,
        { maxWidth: 280, minWidth: 220, className: 'store-popup-wrap' }
      );
      return marker;
    })
    .filter(Boolean);

  cards.forEach((card) => {
    card.addEventListener('click', (e) => {
      if (e.target.closest('a')) return;
      const marker = storeMarkers.find((m) => m._storeCard === card);
      if (!marker) return;
      storeMap.setView(marker.getLatLng(), 14, { animate: true });
      marker.openPopup();
      mapEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
  });

  mapEl.addEventListener('click', () => storeMap.scrollWheelZoom.enable());
  storeMap.on('mouseout', () => storeMap.scrollWheelZoom.disable());

  requestAnimationFrame(() => {
    storeMap.invalidateSize();
    syncMap();
  });
}

initStoreMap();

