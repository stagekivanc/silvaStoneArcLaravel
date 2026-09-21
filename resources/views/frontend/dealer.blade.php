@extends('frontend.layouts.app')

@section('title', data_get($page, 'seo_title') ?: 'Bayilik Başvuru | Silva Arc Panel')
@section('meta_description', data_get($page, 'seo_description') ?: 'Silva Arc Panel bayi ağına katılmak için bayilik başvuru formunu doldurun.')
@section('body_attrs') data-page="dealer" @endsection

@php
  $lang = app()->getLocale();
  $intro = data_get($dealer, 'intro', []);
  $form = data_get($dealer, 'form', []);
  $channels = collect(data_get($dealer, 'channels', []))->values();
  $storesUrl = m_url('stores');
@endphp

@section('content')
  <section class="page-intro page-intro--white">
    <div class="mx-auto max-w-site px-5 md:px-8">
      <div class="page-intro-top">
        <div>
          <p class="page-intro-kicker font-display italic">{{ data_get($intro, 'kicker', 'Bayi Ol') }}</p>
          <h1>{{ data_get($intro, 'title', 'Bayilik başvuru ve bilgi talep formu') }}</h1>
        </div>
        <div class="page-intro-aside">
          <p>{{ data_get($intro, 'text', 'Bayilik başvurusu ve yurtdışı satış için bu formu doldurun. Sizinle en yakın zamanda iletişime geçeceğiz.') }}</p>
          <p class="page-intro-meta">{{ data_get($intro, 'hours', 'Gerçek yaşamın değerlerini büyütün.') }}</p>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-white pb-16 md:pb-24 pt-10">
    <div class="mx-auto grid max-w-site gap-10 px-5 md:px-8 lg:grid-cols-12 lg:items-start lg:gap-12">
      <div class="lg:col-span-4">
        <div class="mt-0 space-y-3">
          @foreach ($channels as $channel)
            @php
              $url = silva_url(data_get($channel, 'url'));
              if (data_get($channel, 'type') === 'store' && (! $url || $url === '#')) {
                  $url = $storesUrl;
              }
            @endphp
            <a href="{{ $url }}" class="contact-card group" @if(str_starts_with((string) $url, 'http')) target="_blank" rel="noopener" @endif>
              <span class="contact-channel-icon"><i class="bx {{ data_get($channel, 'icon', 'bx-phone') }}"></i></span>
              <span>
                <span class="contact-channel-label">{{ data_get($channel, 'label') }}</span>
                <span class="contact-channel-value">{{ data_get($channel, 'value') }}</span>
              </span>
            </a>
          @endforeach
        </div>
      </div>

      <form
        id="dealer-form"
        class="contact-form contact-form--page dealer-form lg:col-span-8"
        method="POST"
        action="{{ route('dealer.store', ['lang' => $lang]) }}"
        novalidate
      >
        @csrf
        <input type="text" name="hp_fax" value="" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true" />

        @if (session('success'))
          <p id="form-success" class="contact-success mb-6" role="status">{{ session('success') }}</p>
        @endif
        @if (session('error'))
          <p class="mb-6 text-sm text-red-600" role="alert">{{ session('error') }}</p>
        @endif
        @if ($errors->any())
          <div class="mb-6 space-y-1 text-sm text-red-600" role="alert">
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif

        <div class="dealer-group">
          <p class="dealer-group-title">{{ data_get($form, 'experience_title', 'İş deneyimi') }}</p>
          <div class="contact-form-grid">
            <div class="contact-field">
              <label for="df-name">{{ data_get($form, 'name_label', 'Ad') }}</label>
              <input id="df-name" type="text" name="name" value="{{ old('name') }}" required autocomplete="given-name" placeholder="{{ data_get($form, 'name_placeholder', 'Adınız') }}" />
            </div>
            <div class="contact-field">
              <label for="df-surname">{{ data_get($form, 'surname_label', 'Soyad') }}</label>
              <input id="df-surname" type="text" name="surname" value="{{ old('surname') }}" required autocomplete="family-name" placeholder="{{ data_get($form, 'surname_placeholder', 'Soyadınız') }}" />
            </div>
            <div class="contact-field">
              <label for="df-phone">{{ data_get($form, 'phone_label', 'Telefon no') }}</label>
              <input id="df-phone" type="tel" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="tel" placeholder="{{ data_get($form, 'phone_placeholder', '05xx xxx xx xx') }}" />
            </div>
            <div class="contact-field">
              <label for="df-email">{{ data_get($form, 'email_label', 'E-posta adresi') }}</label>
              <input id="df-email" type="email" name="email_address" value="{{ old('email_address') }}" required autocomplete="email" placeholder="{{ data_get($form, 'email_placeholder', 'ornek@mail.com') }}" />
            </div>
            <div class="contact-field contact-field--full">
              <label for="df-website">{{ data_get($form, 'website_label', 'Websitesi') }}</label>
              <input id="df-website" type="url" name="website" value="{{ old('website') }}" autocomplete="url" placeholder="{{ data_get($form, 'website_placeholder', 'https://') }}" />
            </div>
          </div>
        </div>

        <div class="dealer-group">
          <p class="dealer-group-title">{{ data_get($form, 'company_title', 'Firma bilgileri') }}</p>
          <div class="contact-form-grid">
            <div class="contact-field contact-field--full">
              <label for="df-company">{{ data_get($form, 'company_label', 'Firma adı') }}</label>
              <input id="df-company" type="text" name="company_name" value="{{ old('company_name') }}" required autocomplete="organization" placeholder="{{ data_get($form, 'company_placeholder', 'Firma veya ünvan') }}" />
            </div>
            <div class="contact-field contact-field--full">
              <label for="df-address">{{ data_get($form, 'address_label', 'Firma adresi') }}</label>
              <input id="df-address" type="text" name="company_address" value="{{ old('company_address') }}" required autocomplete="street-address" placeholder="{{ data_get($form, 'address_placeholder', 'Açık adres') }}" />
            </div>
            <div class="contact-field">
              <label for="df-city">{{ data_get($form, 'city_label', 'Şehir') }}</label>
              <input id="df-city" type="text" name="city" value="{{ old('city') }}" required autocomplete="address-level1" placeholder="{{ data_get($form, 'city_placeholder', 'Şehir') }}" />
            </div>
            <div class="contact-field">
              <label for="df-town">{{ data_get($form, 'town_label', 'İlçe') }}</label>
              <input id="df-town" type="text" name="town" value="{{ old('town') }}" required autocomplete="address-level2" placeholder="{{ data_get($form, 'town_placeholder', 'İlçe') }}" />
            </div>
            <div class="contact-field">
              <label for="df-tax-office">{{ data_get($form, 'tax_office_label', 'Vergi dairesi') }}</label>
              <input id="df-tax-office" type="text" name="tax_department" value="{{ old('tax_department') }}" required placeholder="{{ data_get($form, 'tax_office_placeholder', 'Vergi dairesi') }}" />
            </div>
            <div class="contact-field">
              <label for="df-tax-no">{{ data_get($form, 'tax_no_label', 'Vergi no') }}</label>
              <input id="df-tax-no" type="text" name="tax_no" value="{{ old('tax_no') }}" required inputmode="numeric" placeholder="{{ data_get($form, 'tax_no_placeholder', 'Vergi numarası') }}" />
            </div>
            <div class="contact-field">
              <label for="df-activity">{{ data_get($form, 'activity_label', 'Faaliyet alanı') }}</label>
              <input id="df-activity" type="text" name="field_of_activity" value="{{ old('field_of_activity') }}" placeholder="{{ data_get($form, 'activity_placeholder', 'Örn. zemin kaplama, iç mimari') }}" />
            </div>
            <div class="contact-field">
              <label for="df-refs">{{ data_get($form, 'refs_label', 'Referanslar') }}</label>
              <input id="df-refs" type="text" name="references" value="{{ old('references') }}" placeholder="{{ data_get($form, 'refs_placeholder', 'Varsa referanslarınız') }}" />
            </div>
          </div>
        </div>

        <div class="dealer-group">
          <p class="dealer-group-title">{{ data_get($form, 'type_title', 'Bayilik türü') }}</p>
          <div class="dealer-choices dealer-choices--2" role="radiogroup" aria-label="{{ data_get($form, 'type_title', 'Bayilik türü') }}">
            <label class="dealer-choice">
              <input type="radio" name="dealer_type" value="domestic" @checked(old('dealer_type', 'domestic') === 'domestic') required />
              <span>{{ data_get($form, 'type_domestic', 'Yurtiçi bayilik') }}</span>
            </label>
            <label class="dealer-choice">
              <input type="radio" name="dealer_type" value="abroad" @checked(old('dealer_type') === 'abroad') />
              <span>{{ data_get($form, 'type_abroad', 'Yurtdışı bayilik') }}</span>
            </label>
          </div>
        </div>

        <div class="dealer-group">
          <p class="dealer-group-title">{{ data_get($form, 'notes_title', 'Ek notlarınız') }}</p>
          <div class="contact-field">
            <label for="df-message" class="sr-only">{{ data_get($form, 'notes_title', 'Ek notlarınız') }}</label>
            <textarea id="df-message" name="message" rows="4" placeholder="{{ data_get($form, 'message_placeholder', 'Paylaşmak istediğiniz ek bilgi...') }}">{{ old('message') }}</textarea>
          </div>
        </div>

        <div class="contact-form-foot">
          <label class="contact-consent">
            <input type="checkbox" name="consent" value="1" @checked(old('consent')) required />
            <span>{!! \App\Support\SilvaLegalDefaults::resolveBodyHtml((string) data_get($form, 'consent_html')) !!}</span>
          </label>
          <button type="submit" class="contact-submit">
            <span>{{ data_get($form, 'submit_label', 'Başvuru yap') }}</span>
            <i class="bx bx-right-arrow-alt"></i>
          </button>
        </div>

        @include('frontend.partials.recaptcha')
      </form>
    </div>
  </section>
@endsection

@push('scripts')
  <script src="{{ silva_asset('js/cart.js') }}"></script>
  <script src="{{ silva_asset('js/search.js') }}"></script>
  <script src="{{ silva_asset('js/main.js') }}"></script>
@endpush
