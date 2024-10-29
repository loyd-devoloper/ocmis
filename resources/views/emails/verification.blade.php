<x-mail::message>
# Verify Your Email Address

We've received your request to verify your email address.

To proceed, please click the button below to verify your email address.


<x-mail::button :url="$link">
    Verify Email Address
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
