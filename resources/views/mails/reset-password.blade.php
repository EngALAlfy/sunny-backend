@component('mail::message')
    # Reset Password
    Hello {{$user->name}},
    You Have request reset your password!

    This is your new password : {{$password}}

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
