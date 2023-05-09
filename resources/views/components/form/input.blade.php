@php   
    $attributes = $attributes->merge([
        'class' => 'form-control',
        'type'  => 'text',
        'id'    => $name,
        'value' => old($name, $value ?? ''),
    ])->filter(function($val, $key) {
        return !in_array($key, ['label']);
    });;
@endphp

@isset($label)
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
@endisset
<input {{ $attributes }}>
<div class="text-danger" data-error="{{ $name }}"></div>

{{-- In case if field will be used in non-ajax forms --}}
@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror