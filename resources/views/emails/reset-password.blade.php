@component('mail::message')
# Reset Password Request

You requested to reset your password. Click the button below to reset it:

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

If you did not request a password reset, no further action is required.

Thanks,  
{{ config('app.name') }}
@endcomponent
