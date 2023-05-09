@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
Logo example that will be shown in all emails (path: resources/views/vendor/mail/html/message.blade.php)
<img class="logo"
    src="{{ URL::asset('/assets/images/ibex-consulting-logo-light.png') }}"
    alt="logo"
    height="60"
    style="display:block;margin:10px auto;"
/>
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
