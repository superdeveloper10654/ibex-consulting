@php    
    $attributes = $attributes->merge([
        'class' => 'form-control',
        'rows'  => 5,
        'id'    => $name,
    ])->filter(function($val, $key) {
        return !in_array($key, ['label', 'value']);
    });;
@endphp

@isset($label)
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
@endisset
<textarea {{ $attributes }}>{{ old($name, $value ?? '') }}</textarea>
<div class="text-danger" data-error="{{ $name }}"></div>

{{-- In case if field will be used in non-ajax forms --}}
@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror