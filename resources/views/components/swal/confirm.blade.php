@php
    $id = $id ?? ('swal-' . uniqid());
    $title = $title ?? 'Are you sure?';
    $text = $text ?? "";
    $icon = $icon ?? 'warning';
    $confirmButtonColor = $confirmButtonColor ?? '#556ee6';
    $cancelButtonColor = $cancelButtonColor ?? '#74788d';
    $confirmButtonText = $confirmButtonText ?? 'Yes';
    $cancelButtonText = $cancelButtonText ?? 'Cancel';
    $callbackYes = $callbackYes ?? ''; // callback when answer is yes
    $callbackNo = $callbackNo ?? ''; // callback when answer is no

    $attributes = $attributes->except('title');
@endphp

<span class="swal-trigger-wrapper {{ $class ?? '' }}" id="{{ $id }}" {{ $attributes }}>
    {{ $slot }}
</span>

@push('script')
    <script>
        {
            let callbackYes = `{!! $callbackYes !!}`;
            let callbackNo = `{!! $callbackNo !!}`;

            $('#{{ $id }}').on('click', function() {
                Swal.fire({
                    title: "{{ $title }}",
                    text: "{!! $text !!}",
                    icon: "{{ $icon }}",
                    showCancelButton: true,
                    confirmButtonColor: "{{ $confirmButtonColor }}",
                    cancelButtonColor: "{{ $cancelButtonColor }}",
                    confirmButtonText: "{{ $confirmButtonText }}",
                    cancelButtonText: "{{ $cancelButtonText }}",
                }).then(function (res) {
                    if (res.value && callbackYes) {
                        if (typeof window[callbackYes] === 'function') {
                            window[callbackYes]();
                        } else {
                            eval(callbackYes);
                        }
                    } else if (!res.value && callbackNo) {
                        if (typeof window[callbackNo] === 'function') {
                            window[callbackNo]();
                        } else {
                            eval(callbackNo);
                        }
                    }
                });
            });
        }
    </script>
@endpush