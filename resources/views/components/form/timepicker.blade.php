@php   
    $attributes = $attributes->merge([
        'class'                 => 'form-control',
        'type'                  => 'text',
        'data-time-format'      => $format ?? 'h:m',
        'data-provide'          => 'timepicker',
        'id'                    => $name,
    ])->filter(function($val, $key) {
        return !in_array($key, ['label', 'value']);
    });

    $phpTimeFormat = $phpTimeFormat ?? 'H:i';
    $value = old($name, $value ?? '');
    $value = !empty($value) ? date($phpTimeFormat, strtotime($value)) : '';
    $wrapperId = $wrapperId ?? ($name . '-wrapper');
@endphp

@isset($label)
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
@endisset
<div class="input-group" id="{{ $wrapperId }}">
    <input {{ $attributes }} value="{{ $value }}" />
    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
</div>
<div class="text-danger" data-error="{{ $name }}"></div>

{{-- In case if field will be used in non-ajax forms --}}
@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror

@push('script')
    <script>
        $('#{{ $name }}').timepicker({
            showMeridian: !1,
            icons: {
                up: "mdi mdi-chevron-up",
                down: "mdi mdi-chevron-down"
            },
            appendWidgetTo: '#{{ $wrapperId }}',
        });
    </script>
@endpush