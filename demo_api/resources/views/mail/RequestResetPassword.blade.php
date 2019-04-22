@component('mail::message')

# Reset Password

Hello {{ $user->name }},

Use this temporary password for login:

{{$resetPass}}

Thanks,<br>
{{ env('APP_NAME') }}<br>
{{ env('APP_DOMAIN') }}

@endcomponent
