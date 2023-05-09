@php
    $firstOpt = $firstOpt ?? "Select";
    $selected = old($name, $selected ?? '');
    $showOptionCustomAttrs = $showOptionCustomAttrs ?? false;

    $attributes = $attributes->merge([
        'class' => 'form-select select2',
        'id'    => $name
    ])->filter(function($val, $key) {
        return !in_array($key, ['options', 'label', 'selected']);
    });
@endphp

@isset($label)
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
@endisset
<select {{ $attributes }}>
    @if ($firstOpt)
        <option value="">{{ $firstOpt }}</option>
    @endif
    @if (!empty($options))
        @foreach ($options as $key => $value)
            @if (!is_object($value))
                <option value="{{ $key }}" {{ $key == $selected ? 'selected' : '' }}>{{ $value }}</option>
            @else
                <option value="{{ $value->id }}" 
                    {{ $value->id == $selected ? 'selected' : '' }}
                    {{ !empty($value->visible_for) ? 
                        ("data-visible-for=" . array_key_first($value->visible_for)
                            . " data-visible-for-value=" . current($value->visible_for))
                        : '' }}

                    @if ($showOptionCustomAttrs)
                        @foreach (array_keys((array) $value) as $key)
                            {{ !in_array($key, ['id', 'text', 'name', 'visible_for', 'icon']) ? ('data-' . $key . (!empty($value->$key) ? '=' . $value->$key : '')) : '' }}
                        @endforeach
                    @endif
                >
                    @if (!empty($value->icon))
                        {{ '<span class="option-icon me-2">' . $value->icon . '</span>' }}
                    @endif
                    {{ $value->text ?? $value->name ?? '' }}
                </option>
            @endif
        @endforeach
    @endif
</select>
<div class="text-danger" data-error="{{ $name }}"></div>

{{-- In case if field will be used in non-ajax forms --}}
@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror