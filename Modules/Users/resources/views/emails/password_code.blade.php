<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() == 'ar') dir="rtl" @endif>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('users::auth.reset_password_mail') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; font-family: 'Cairo', Arial, sans-serif; background-color: #ffffff;">
    <div style="width: 100%; max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); overflow: hidden;">

        <!-- Header -->
        <div style="padding: 20px; background-color: #F6FFF6; text-align: center;">
            <img src="{{ $message->embed(public_path('img/logo.png')) }}" alt="Logo" style="width: 170px; height: 80px;">
        </div>

        <!-- Main Content -->
        <div style="padding: 20px; text-align: center; color: #000000;">
            <h2 style="font-size: 24px; font-weight: 700; color: #000000; margin-bottom: 10px;">
                {{ __('users::auth.reset_password_mail') }}
            </h2>
            <p style="font-size: 14px; line-height: 20px; font-weight: 400;">
                {{ __('users::auth.welcome') }} <strong>{{ $name }}</strong>,
            </p>
            <p style="font-size: 14px; line-height: 20px; font-weight: 400;">
                {{ __('users::auth.your_reset_password_code_is') }} <strong>{{ $code }}</strong>
            </p>
            <p style="font-size: 14px; line-height: 20px; font-weight: 400;">
                {{ __('users::auth.please_use_this_code_to_reset_your_password') }}
            </p>
        </div>

        <!-- Social Media Links -->
        <div style="margin: 20px 0px; text-align: center;">
            <p style="font-size: 14px; line-height: 20px; font-weight: 400; color: #121212">{{ __('campaigns::main.follow_us_on') }}</p>
            <div>
                <a href="{{ get_social_media_url('instagram') }}" style="margin: 0 10px;"><img src="{{ $message->embed(public_path('img/icons/instagram.png')) }}" alt="Instagram" style="width: 20px; height:20px"></a>
                <a href="{{ get_social_media_url('facebook') }}" style="margin: 0 10px;"><img src="{{ $message->embed(public_path('img/icons/facebook.png')) }}" alt="Facebook" style="width: 20px; height:20px"></a>
                <a href="{{ get_social_media_url('youtube') }}" style="margin: 0 10px;"><img src="{{ $message->embed(public_path('img/icons/youtube.png')) }}" alt="YouTube" style="width: 20px; height:20px"></a>
                <a href="{{ get_social_media_url('twitter') }}" style="margin: 0 10px;"><img src="{{ $message->embed(public_path('img/icons/twitter.png')) }}" alt="Twitter" style="width: 20px; height:20px"></a>
                <a href="{{ get_social_media_url('snapchat') }}" style="margin: 0 10px;"><img src="{{ $message->embed(public_path('img/icons/snapchat.png')) }}" alt="Twitter" style="width: 20px; height:20px"></a>
                <a href="{{ get_social_media_url('whatsapp') }}" style="margin: 0 10px;"><img src="{{ $message->embed(public_path('img/icons/whatsapp.png')) }}" alt="WhatsApp" style="width: 20px; height:20px"></a>
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align: center; background-color: #ffffff;">
            <img src="{{ $message->embed(public_path('img/ramadan_kareem_footer.png')) }}" alt="Ramadan Kareem" style="width: 100%; height: auto;">
        </div>
    </div>
</body>
</html>
