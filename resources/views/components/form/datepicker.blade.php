@php   
    $attributes = $attributes->merge([
        'class'                 => 'form-control',
        'type'                  => 'text',
        'data-date-container'   => '#' . $name,
        'data-date-format'      => $format ?? 'dd/mm/yyyy',
        'data-provide'          => 'datepicker',
    ])->filter(function($val, $key) {
        return !in_array($key, ['label', 'value']);
    });

    $value = old($name, $value ?? '');
    $phpDateFormat = $phpDateFormat ?? 'd/m/Y';
    $value = !empty($value) ? date($phpDateFormat, strtotime($value)) : '';
@endphp

@isset($label)
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
@endisset
<div class="input-group" id="{{ $name }}">
    <input {{ $attributes }} value="{{ $value }}" />
    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
</div>
<div class="text-danger" data-error="{{ $name }}"></div>

{{-- In case if field will be used in non-ajax forms --}}
@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror
