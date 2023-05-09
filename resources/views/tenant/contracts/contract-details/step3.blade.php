<h5 class="pt-5 border-top">Part one - Data provided by the <i>{{str_contains($contractType,'ECS') ? 'Contractor' :( str_contains($contractType,'NEC4') ? 'Client':'Employer')}}</i></h5>
<hr>
<h4 class="card-title mt-2 mb-3">General</h4>
<ul class="mb-4">
    <li class="mb-3">The <i>conditions of {{str_contains($contractType,'ECS') ? 'sub' : ''}}contract</i> are the core clauses and the clauses for main -
        <span class="selected_main_option">{{$contractAppl->main_opt}}</span>, dispute resolution Option - <span class="selected_dispute_resolution_option">{{$contractAppl->resolution_opt}}</span> and Secondary Options
        <span id="selected_secondary_options"></span> of the
        <span class="selected_contract">
            {{str_contains($contractType,'NEC4') ? 'NEC4' : 'NEC3'}}
            @if(str_contains($contractType,'TSC'))
            Term Services Contract
            @else
            Engineering and Construction {{str_contains($contractType,'ECS') ? 'Subcontract' : 'Contract'}}
            @endif
            {{str_contains($contractType,'NEC4') ? 'June 27' : 'April 2013'}}
            .
        </span>
    </li>
    <li class="mb-3" style="display:block;page-break-inside:avoid;">The <i>{{str_contains($contractType,'TSC') ? 'service':'works' }}</i>@if(str_contains($contractType,'ECS')) in the main contract @endif {{str_contains($contractType,'TSC') ? 'is':'are'}}
        <textarea name="works_are" class="form-control mt-2" style="display:block;page-break-inside:avoid;" rows="3" required>{{$contractAppl->works_are}}</textarea>
        @error('works_are')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @if(str_contains($contractType,'ECS'))
    <li class="mb-3">The <i>subcontract works</i> are
        <textarea name="subcontract_works_are" class="form-control mt-2" rows="3" required>{{$contractAppl->subcontract_works_are}}</textarea>
        @error('subcontract_works_are')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>Contractor</i> is
        <p class="mb-0 mt-3">Name</p>
        <input type="text" class="form-control mt-2" value="{{$contract->contractor_profile->organisation}}" disabled />
        <p class="mb-0 mt-3">Address @if(str_contains($contractType,'NEC4')) for communications @endif</p>
        <textarea class="form-control mt-2" rows="3" disabled>{{$contract->contractor_profile->address}}</textarea>
        @if(str_contains($contractType,'NEC4'))
        <p class="mb-0 mt-3">Address for electronic communications</p>
        <textarea class="form-control mt-2" rows="3" disabled>{{$contract->contractor_profile->electronic_address}}</textarea>
        @endif
    </li>
    @endif
    <li class="mb-3">The <i>{{str_contains($contractType,'NEC4') ? 'Client' : 'Employer'}}</i> @if(str_contains($contractType,'ECS')) in the main contract @endif is
        <p class="mb-0 mt-3">Name</p>
        <!--
        <select class="form-control mt-2 select-user" name="employer_or_client_id" required>
            <option value="">select</option>
            @foreach ($employerProfiles as $profile)
            <option value="{{$profile->id}}" @if($profile->id==$contractAppl->employer_or_client_id) selected @endif data="{{$profile}}">{{$profile->name}}</option>
            @endforeach
        </select>
        -->
        <input type="text" class="form-control mt-2" name="employer_name_is" required />
        @error('employer_name_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="mb-0 mt-3">Address @if(str_contains($contractType,'NEC4')) for communications @endif</p>
        <textarea class="form-control mt-2 address" rows="3" required>{{$contractAppl->employer_address_is}}</textarea>
        @if(str_contains($contractType,'NEC4'))
        <p class="mb-0 mt-3">Address for electronic communications</p>
        <textarea class="form-control mt-2 elec-address" rows="3" required>{{$contractAppl->employer_electronic_address_is}}</textarea>
        @endif
    </li>
    <li class="mb-3">The <i>{{str_contains($contractType,'TSC') ? 'Service':'Project'}} Manager</i> @if(str_contains($contractType,'ECS')) in the main contract @endif is
        <p class="mb-0 mt-3">Name</p>
        <select class="form-control mt-2 select-user" name="pm_or_sm_id" {{ isPaidSubscription() ? 'required' : 'disabled' }}>
            <option value="">select</option>
            @if (isPaidSubscription())
            @foreach ($projectManagerProfiles as $profile)
            <option value="{{$profile->id}}" @if($profile->id==$contractAppl->pm_or_sm_id) selected @endif data="{{$profile}}">{{$profile->name}}</option>
            @endforeach
            @else
            <option value="#" selected>{{ $contract->project_manager()->name }}</option>
            @endif
        </select>
        @error('pm_or_sm_id')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="mb-0 mt-3">Address</p>
        <textarea class="form-control mt-2 address" rows="3" required disabled>{{$contractAppl->pm_address_is}}</textarea>
        @if(str_contains($contractType,'NEC4'))
        <p class="mb-0 mt-3">Address for electronic communications</p>
        <textarea class="form-control mt-2 elec-address" rows="3" required disabled>{{$contractAppl->pm_electronic_address_is}}</textarea>
        @endif
    </li>
    @if(!str_contains($contractType,'TSC'))
    <li class="mb-3">The <i>Supervisor</i> @if(str_contains($contractType,'ECS')) in the main contract @endif is
        <p class="mb-0 mt-3">Name</p>
        <select class="form-control mt-2 select-user" name="sup_id" {{ isPaidSubscription() ? 'required' : 'disabled' }}>
            <option value="">select</option>
            @if (isPaidSubscription())
            @foreach ($supervisorProfiles as $profile)
            <option value="{{$profile->id}}" @if($profile->id==$contractAppl->sup_id) selected @endif data="{{$profile}}">{{$profile->name}}</option>
            @endforeach
            @else
            <option value="#" selected>{{ $contract->supervisor()->name }}</option>
            @endif
        </select>
        @error('sup_id')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="mb-0 mt-3">Address</p>
        <textarea class="form-control mt-2 address" rows="3" required disabled>{{$contractAppl->sup_address_is}}</textarea>
        @if(str_contains($contractType,'NEC4'))
        <p class="mb-0 mt-3">Address for electronic communications</p>
        <textarea class="form-control mt-2 elec-address" rows="3" required disabled>{{$contractAppl->sup_electronic_address_is}}</textarea>
        @endif
    </li>
    @endif
    @if(!str_contains($contractType,'NEC4'))
    @if(str_contains($contractType,'ECS'))
    <li class="mb-3">The <i>Adjudicator</i> in this subcontract is
        <p class="mb-0 mt-3">Name</p>
        <select class="form-control mt-2 select-user" name="sub_adj_id" required>
            <option value="">select</option>
            @foreach ($adjudicatorProfiles as $profile)
            <option value="{{$profile->id}}" @if($profile->id==$contractAppl->sub_adj_id) selected @endif data="{{$profile}}">{{$profile->name}}</option>
            @endforeach
        </select>
        @error('sub_adj_id')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="mb-0 mt-3">Address</p>
        <textarea class="form-control mt-2 address" rows="3" required disabled>{{$contractAppl->adj_address_is}}</textarea>
    </li>
    @endif
    <li class="mb-3">The <i>@if(str_contains($contractType,'ECS')) Main Contract @endif Adjudicator</i> is
        <p class="mb-0 mt-3">Name</p>
        <select class="form-control mt-2 select-user" name="adj_id" required>
            <option value="">select</option>
            @foreach ($adjudicatorProfiles as $profile)
            <option value="{{$profile->id}}" @if($profile->id==$contractAppl->adj_id) selected @endif data="{{$profile}}">{{$profile->name}}</option>
            @endforeach
        </select>
        @error('adj_id')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="mb-0 mt-3">Address</p>
        <textarea class="form-control mt-2 address" rows="3" required disabled>{{$contractAppl->main_adj_address_is}}</textarea>
    </li>
    @endif
    @if(str_contains($contractType,'TSC'))
    <li class="mb-3">The <i>Affected</i> Property is
        <textarea name="affected_property_is" class="form-control mt-2" rows="3" required>{{$contractAppl->affected_property_is}}</textarea>
        @error('affected_property_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
</ul>