@php
    $attributes = $attributes->merge([
        'class' => 'tick'
    ]);
@endphp

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/flip/flip.min.css') }}">
@endpush

<div {{ $attributes }} data-did-init="startDateCountdown">
    <div data-repeat="true" data-layout="horizontal center fit" data-transform="preset(d, h, m, s) -> delay">
        <div class="tick-group">
            <div data-key="value" data-transform="pad(00)">
                <span data-view="flip"></span>
            </div>
            <span data-key="label" data-view="text" class="tick-label"></span>
        </div>
    </div>
</div>

@push('script')
    <script src="{{ asset('assets/libs/flip/flip.min.js') }}"></script>

    <script>
        function startDateCountdown(tick)
        {
            var counter = Tick.count.down('{{ $date }}', {
                format: ['d', 'h', 'm', 's']
            });

            counter.onupdate = function(value) {
                // by default value will contain an
                // array with days, hours, minutes, seconds
                tick.value = value;
            };
            counter.onended = function() {
                // reached target date!
            }
        }
    </script>
@endpush