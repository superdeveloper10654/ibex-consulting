@if($contractType!='TSC')

@if(str_starts_with($contractAppl->main_opt,'Option A') || str_starts_with($contractAppl->main_opt,'Option B') )

<h5>Data for the Short Schedule of Cost Components @if(str_contains($contractType,'NEC4')) (used only with Option A {{!str_contains($contractType,'TSC') ? 'or B' : ''}}) @endif</h5>
<ul class="mt-3 mb-4">
    @if(!str_contains($contractType,'TSC'))<h6 class="mt-3">If Option A or B is used </h6>@endif
    @include('tenant.contracts.contract-details.shorter-schedule-cost-component')
    @if(str_contains($contractType,'NEC4'))
    @include('tenant.contracts.contract-details.schedule-cost-component')
    @endif
    @include('tenant.contracts.contract-details.both-schedule-cost-component')
</ul>

@elseif(str_starts_with($contractAppl->main_opt,'Option C') || str_starts_with($contractAppl->main_opt,'Option D') || str_starts_with($contractAppl->main_opt,'Option E') )

<h5>Data for Schedule of Cost Components @if(str_contains($contractType,'TSC')) (used only with Options C or E) @endif</h5>
<ul class="mt-3 mb-4">
    @if(!str_contains($contractType,'TSC'))<h6 class="mt-3">If Option C , D or E is used</h6>@endif
    @include('tenant.contracts.contract-details.schedule-cost-component')
    @include('tenant.contracts.contract-details.both-schedule-cost-component')
    @if(!str_contains($contractType,'NEC4'))
    @include('tenant.contracts.contract-details.shorter-schedule-cost-component')
    @endif
</ul>

@endif
@endif