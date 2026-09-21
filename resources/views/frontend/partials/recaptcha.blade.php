@if(recaptcha_enabled())
    <div class="formRecaptcha">
        <div class="g-recaptcha" data-sitekey="{{ recaptcha_site_key() }}"></div>
        @error('g-recaptcha-response')
            <p class="formRecaptchaError">{{ $message }}</p>
        @enderror
    </div>
    @once('recaptcha-api-script')
        @push('scripts')
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endpush
    @endonce
@endif
