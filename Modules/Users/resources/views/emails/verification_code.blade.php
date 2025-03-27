@component('mail::message')  
# {{ __('users::auth.email_verification_code') }}  

{{ __('users::auth.welecome') }} **{{ $name }}**  

{{ __('users::auth.your_email_verification_code_is') }} **{{ $code }}**  

{{ __('users::auth.please_use_this_code_to_verify_your_email') }}  

{{ __('users::auth.thank_you_for_using_our_application') }}  


@component('mail::footer')  
© {{ date('Y') }} {{ config('app.name') }}. {{ __('users::auth.all_rights_reserved') }}  
@endcomponent  
@endcomponent