@php   
    $attributes = $attributes->merge([
        'class' => 'form-control my-colorpicker',
        'type'  => 'text',
        'id'    => $name,
    ])->filter(function($val, $key) {
        return !in_array($key, ['label']);
    });

    $value = old($name, $value ?? '');
@endphp

@isset($label)
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
@endisset
<div class="input-group">
    <input {{ $attributes }} />
    <span class="input-group-text py-0 px-2">
        <input class="border-0" type="color" role="button" value="{{ $value }}" />
    </span>
</div>
<div class="text-danger" data-error="{{ $name }}"></div>

{{-- In case if field will be used in non-ajax forms --}}
@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror

@push('script')
    <script>
        jQuery(($) => {
            $('#{{ $name }}').on('input', function() {
                let hex = '';

                if (isHex(this.value)) {
                    hex = this.value;

                } else if (isRgb(this.value)) {
                    hex = rgbToHex(this.value);
                }

                if (hex.length) {
                    let color_el = $('#{{ $name }}').next().find('input[type=color]');
                    color_el.val(hex);
                }
            });

            $('#{{ $name }} + * > input[type=color]').on('input', function() {
                $('#{{ $name }}').val(this.value);
            });
        });
    </script>
@endpush