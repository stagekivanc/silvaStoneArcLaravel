@extends('frontend.layouts.app')

@section('title', data_get($page, 'seo_title') ?: 'Silva Arc Panel | Acarkon Dekoratif Duvar Panelleri')
@section('meta_description', data_get($page, 'seo_description') ?: 'Silva Arc Panel by Acarkon — modern iç mekânlar için dekoratif duvar panelleri.')

@php
  $hero = data_get($homepage, 'hero', []);
  $slides = collect(data_get($hero, 'slides', []))->values();
  $firstSlide = $slides->first() ?: [];
  $intro = data_get($homepage, 'intro', []);
  $features = data_get($homepage, 'features', []);
  $featureItems = collect(data_get($features, 'items', []))->values();
  $productsSec = data_get($homepage, 'products', []);
  $spaces = data_get($homepage, 'spaces', []);
  $spaceItems = collect(data_get($spaces, 'items', []))->values();
  $stores = data_get($homepage, 'stores', []);
@endphp

@section('content')
  {{-- Hero --}}
  <section class="hero relative min-h-[100svh] overflow-hidden bg-void">
    <div class="hero-media absolute inset-0" aria-hidden="true">
      @foreach ($slides as $i => $slide)
        <img
          src="{{ homepage_media_url(data_get($slide, 'image')) }}"
          alt=""
          class="hero-media-img {{ $i === 0 ? 'is-active' : '' }}"
          data-hero-bg="{{ $i }}"
        />
      @endforeach
      <div class="hero-media-shade absolute inset-0"></div>
    </div>

    <div class="hero-copy relative z-10 mx-auto flex min-h-[100svh] max-w-site flex-col items-center justify-center px-5 py-28 text-center md:px-8 md:py-24">
      <div class="max-w-2xl">
        <p id="hero-kicker" class="hero-reveal hero-delay-1 font-display italic text-[15px] tracking-[0.06em] text-white/70 md:text-base">
          {{ data_get($firstSlide, 'kicker') }}
        </p>
        <h1 id="hero-title" class="hero-reveal hero-delay-1 mt-2 text-[clamp(2.4rem,8vw,5.4rem)] font-light leading-[0.94] tracking-[-0.045em] text-white">
          {{ data_get($firstSlide, 'title') }}
        </h1>
        <p id="hero-lead" class="hero-reveal hero-delay-2 mx-auto mt-5 max-w-md text-[15px] font-light leading-relaxed text-white/80 md:mt-6 md:text-base">
          {{ data_get($firstSlide, 'lead') }}
        </p>
        <div class="hero-reveal hero-delay-3 mt-8 flex flex-wrap items-center justify-center gap-3 md:mt-10">
          <a id="hero-cta" href="{{ silva_url(data_get($hero, 'primary_url', m_url('products'))) }}" class="rounded-full bg-white px-6 py-3.5 text-[13px] font-medium text-ink transition hover:bg-mist">
            {{ data_get($hero, 'primary_label', 'Koleksiyonu incele') }}
          </a>
          <a href="{{ silva_url(data_get($hero, 'secondary_url', m_url('stores'))) }}" class="rounded-full border border-white/35 px-6 py-3.5 text-[13px] font-medium text-white transition hover:border-white hover:bg-white/10">
            {{ data_get($hero, 'secondary_label', 'Showroom') }}
          </a>
        </div>
      </div>
    </div>

    <div class="hero-scene-bar">
      <div class="hero-scene-dots" id="hero-scene-dots"></div>
    </div>
  </section>

  {{-- Intro --}}
  <section class="bg-white">
    <div class="mx-auto grid max-w-site gap-10 px-5 py-16 md:grid-cols-12 md:gap-12 md:px-8 md:py-24">
      <p class="text-[11px] font-medium uppercase tracking-[0.22em] text-stone md:col-span-3">{{ data_get($intro, 'eyebrow') }}</p>
      <div class="md:col-span-9">
        <p class="max-w-3xl text-[clamp(1.4rem,2.8vw,2.25rem)] font-light leading-snug tracking-[-0.02em] text-ink">
          {{ data_get($intro, 'title') }}
        </p>
        <p class="mt-6 max-w-2xl text-[15px] font-light leading-relaxed text-stone">
          {{ data_get($intro, 'text') }}
        </p>
      </div>
    </div>
  </section>

  {{-- Features --}}
  <section id="neden" class="bg-white py-16 md:py-24">
    <div class="mx-auto max-w-site px-5 md:px-8">
      <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
          <h2 class="text-[clamp(1.75rem,3vw,2.5rem)] font-light tracking-[-0.03em]">{{ data_get($features, 'title') }}</h2>
          <p class="mt-3 max-w-xl text-[15px] font-light text-stone">{{ data_get($features, 'subtitle') }}</p>
        </div>
        <a href="{{ silva_url(data_get($features, 'catalog_url')) }}" class="text-[13px] font-medium text-ink underline decoration-line underline-offset-8 transition hover:decoration-ink">
          {{ data_get($features, 'catalog_label') }}
        </a>
      </div>
      <div class="feature-grid">
        @foreach ($featureItems as $i => $item)
          <article class="feature-item">
            <span>{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
            <div>
              <h3>{{ data_get($item, 'title') }}</h3>
              <p>{{ data_get($item, 'text') }}</p>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Products --}}
  <section id="katalog" class="home-catalog">
    <div class="mx-auto max-w-site px-5 md:px-8">
      <div class="home-catalog-head">
        <h2>{{ data_get($productsSec, 'title') }}</h2>
        <p>{{ data_get($productsSec, 'subtitle', data_get($productsSec, 'eyebrow')) }}</p>
      </div>
      <div class="home-cat-filters" id="home-cat-filters" role="tablist" aria-label="{{ data_get($productsSec, 'title') }}"></div>
      <div class="home-catalog-grid" id="home-catalog-grid"></div>
      <p class="home-catalog-empty" id="home-catalog-empty" hidden>{{ __t('ui_no_products', 'Bu seçime uygun ürün yok.', 'frontend') }}</p>
      <div class="home-catalog-foot">
        <a href="{{ silva_url(data_get($productsSec, 'cta_url')) }}" class="home-catalog-cta">{{ data_get($productsSec, 'cta_label') }}</a>
      </div>
    </div>
  </section>

  {{-- Spaces --}}
  <section id="alanlar" class="bg-white py-20 md:py-28">
    <div class="mx-auto max-w-site px-5 md:px-8">
      <div class="mb-10 max-w-xl">
        <h2 class="text-[clamp(1.75rem,3vw,2.5rem)] font-light tracking-[-0.03em]">{{ data_get($spaces, 'title') }}</h2>
        <p class="mt-3 text-[15px] font-light text-stone">{{ data_get($spaces, 'subtitle') }}</p>
      </div>
      <div class="space-grid">
        @foreach ($spaceItems as $item)
          <a href="{{ silva_url(data_get($item, 'url')) }}" class="space-tile">
            <i class="bx {{ data_get($item, 'icon', 'bx-home-alt-2') }}" aria-hidden="true"></i>
            <h3>{{ data_get($item, 'title') }}</h3>
            <p>{{ data_get($item, 'text') }}</p>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Stores --}}
  <section class="overflow-hidden bg-white py-20 md:py-28">
    <div class="mx-auto max-w-site px-5 md:px-8">
      <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
        <div class="max-w-xl">
          <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-stone">{{ data_get($stores, 'eyebrow') }}</p>
          <h2 class="mt-3 text-[clamp(1.75rem,3vw,2.5rem)] font-light tracking-[-0.03em]">{{ data_get($stores, 'title') }}</h2>
          <p class="mt-3 text-[15px] font-light text-stone">{{ data_get($stores, 'subtitle') }}</p>
        </div>
        <a href="{{ silva_url(data_get($stores, 'cta_url')) }}" class="inline-flex items-center gap-2 text-[13px] font-medium text-ink underline decoration-line underline-offset-8 transition hover:decoration-ink">
          <span>{{ data_get($stores, 'cta_label') }}</span>
          <i class="bx bx-right-arrow-alt text-lg"></i>
        </a>
      </div>
    </div>
    <div class="store-marquee store-marquee--cities mt-10" aria-label="{{ __t('ui_showroom_cities', 'Showroom şehirleri', 'frontend') }}">
      <div class="store-marquee-row" data-store-rail="ltr"></div>
      <div class="store-marquee-row store-marquee-row--rtl" data-store-rail="rtl"></div>
    </div>
  </section>
@endsection

@push('scripts')
  @php
    $jsSlides = $slides->map(function ($s) {
      return [
        'img' => homepage_media_url(data_get($s, 'image')),
        'kicker' => data_get($s, 'kicker'),
        'title' => data_get($s, 'title'),
        'lead' => data_get($s, 'lead'),
        'tone' => data_get($s, 'tone', 'dark'),
      ];
    })->values();

    $homeProducts = \App\Models\Product::query()
      ->where('status', true)
      ->where('home_status', true)
      ->with(['translations', 'category.translations'])
      ->orderBy('order')
      ->orderBy('id')
      ->limit(12)
      ->get()
      ->map(fn ($p) => $p->toFrontendArray())
      ->values();

    if ($homeProducts->isEmpty()) {
      $homeProducts = \App\Models\Product::query()
        ->where('status', true)
        ->with(['translations', 'category.translations'])
        ->orderBy('order')
        ->orderBy('id')
        ->limit(12)
        ->get()
        ->map(fn ($p) => $p->toFrontendArray())
        ->values();
    }

    $homeCatMap = [];
    foreach (\App\Models\ProductCategory::query()->where('status', true)->orderBy('order')->get() as $category) {
      $homeCatMap[$category->slug] = $category->name;
    }
    $homeCats = array_merge(['all' => __t('ui_all', 'Hepsi', 'frontend')], $homeCatMap);
    $homeProductCodes = $homeProducts->pluck('code')->values();
    $preferredHome = ['MT012', 'MT011', 'TYD13', 'HY01217-1', 'SH-34', 'PM-48', 'SH-60', 'CT-05'];
    $byCode = $homeProducts->keyBy('code');
    $orderedCodes = collect($preferredHome)->filter(fn ($code) => $byCode->has($code))->values();
    $extraCodes = $homeProductCodes->diff($orderedCodes)->values();
    $homeProductCodes = $orderedCodes->concat($extraCodes)->values();
    $homeProducts = $homeProductCodes
      ->map(fn ($code) => $byCode->get($code))
      ->filter()
      ->values();
    $homeColorMap = \App\Models\ProductColor::filterMap();
    $homeProductsUrl = m_url('products');
  @endphp
  <script>
    window.SILVA_HERO_SLIDES = @json($jsSlides);
    window.SILVA_CATS = @json($homeCats);
    window.SILVA_COLORS = @json($homeColorMap);
    window.SILVA_PRODUCTS = @json($homeProducts);
    window.SILVA_HOME_FEATURED = @json($homeProductCodes);
    window.SILVA_PRODUCTS_URL = @json($homeProductsUrl);
    window.silvaHref = function (p) {
      if (p && p.href) return p.href;
      var slug = (p && (p.slug || p.code)) || '';
      var lang = @json(app()->getLocale());
      var module = lang === 'en' ? 'product' : 'urun';
      return '/' + lang + '/' + module + '/' + encodeURIComponent(slug);
    };
  </script>
  <script src="{{ silva_asset('js/products.js') }}"></script>
  <script>
    window.silvaHref = function (p) {
      if (p && p.href) return p.href;
      var slug = (p && (p.slug || p.code)) || '';
      var lang = @json(app()->getLocale());
      var module = lang === 'en' ? 'product' : 'urun';
      return '/' + lang + '/' + module + '/' + encodeURIComponent(slug);
    };
  </script>
  <script src="{{ silva_asset('js/cart.js') }}"></script>
  <script src="{{ silva_asset('js/search.js') }}"></script>
  <script src="{{ silva_asset('js/stores.js') }}"></script>
  <script src="{{ silva_asset('js/main.js') }}"></script>
@endpush
