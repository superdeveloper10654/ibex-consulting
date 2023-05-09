@component('mail::message')
    <h1>New Contract</h1>
    <p>Contract "{{ $contract->contract_name }}" has been created.</p>
    @component('mail::button', ['url' => t_route('contracts.show', $contract->id)])
        Link to contract
    @endcomponent
    Logo example that will be shown only in emails for new contract created (path: resources/views/emails/contract/created.blade.php)
    <img src="{{ URL::asset('/assets/images/ibex-logo.png') }}" 
        alt="Ibex Logo"
        height="60"
        style=""
    />
    Thanks,<br>
    {{ config('app.name') }}
@endcomponent