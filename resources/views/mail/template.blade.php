@component('mail::message')

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

@if (! empty($url))
@component('mail::button', ['url' => $url])
{{ $wording }}
@endcomponent
@endif

{{-- <p>{{ trans('notification.end_greeting') }}</p> --}}
<p>Thank you</p>

<p>**This email is auto generated, please do not reply to this email**</p>
@endcomponent
