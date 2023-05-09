@php   
    $attributes = $attributes->merge([
        'class' => 'form-control',
        'type'  => 'file',
        'id'    => $name,
    ])->filter(function($val, $key) {
        return !in_array($key, ['label']);
    });
@endphp

@error($name)
    @php
        $attributes = $attributes->merge([
            'class' => 'is-invalid',
        ]);
    @endphp
@enderror

@isset($label)
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
@endisset
<input {{ $attributes }}>
{{-- In case if field will be used in ajax forms --}}
<div class="text-danger" data-error="{{ $name }}"></div>

{{-- In case if field will be used in non-ajax forms --}}
@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror