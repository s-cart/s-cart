<style>
    #{{ $idButtonForm ?? 'sc_button-form-process'}}{
        display: none !important;
    }
</style>
<script src="https://www.google.com/recaptcha/api.js"></script>
@if ($errors->has('captcha_field'))
<span class="help-block">
    {{ $errors->first('captcha_field') }}
</span>
@endif
<button class="g-recaptcha button" 
        data-sitekey="{{ sc_config('GoogleCaptcha_site_key') }}" 
        data-callback='onSubmit' 
        data-action='submit'>{{ $titleButton ?? sc_language_render('front.captcha_action.submit') }}</button>
<script>
    function onSubmit(token) {
        document.getElementById("{{ $idForm ?? "sc_form-process" }}").submit();
    }
</script>