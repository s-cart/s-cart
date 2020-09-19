<style>
    #{{ $idButtonForm ?? 'button-form-process'}}{
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
        data-action='submit'>{{ $titleButton ?? trans('front.captcha_action.submit') }}</button>
<script>
    function onSubmit(token) {
        document.getElementById("{{ $idForm ?? "form-process" }}").submit();
    }
</script>