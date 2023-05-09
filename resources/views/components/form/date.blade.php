@php   
    $attributes = $attributes->merge([
        'class' => 'form-control',
        'type'  => 'date',
        'id'    => $name,
    ])->filter(function($val, $key) {
        return !in_array($key, ['label', 'value']);
    });

    $value = old($name, $value ?? '');
    $value = !empty($value) ? date('Y-m-d', strtotime($value)) : '';
@endphp

@isset($label)
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
@endisset
<input {{ $attributes }} value="{{ $value }}">
<div class="text-danger" data-error="{{ $name }}"></div>

{{-- In case if field will be used in non-ajax forms --}}
@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror