@php   
    $attributes = $attributes->merge([
        'class' => 'customized',
        'type'  => 'checkbox',
        'id'    => $name,
        'value' => '1'
    ])->filter(function($val, $key) {
        return !in_array($key, ['label', 'wrapper-class']);
    });
    $wrapperClass = $wrapperClass ?? '';
    $checked = !empty(old($name, $checked ?? ''));
@endphp

<div class="checkbox-customized-wrapper {{ $wrapperClass }}">
    <span class="checkbox-wrapper">
        <input {{ $attributes }} checked="{{ $checked }}" />
    </span>
    <label for="{{ $name }}">{{ __($label) }}</label>
    <div class="text-danger" data-error="{{ $name }}"></div>

    {{-- In case if field will be used in non-ajax forms --}}
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>