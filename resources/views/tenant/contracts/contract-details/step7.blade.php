@if (!str_contains($contractType,'TSC'))
<h4 class="card-title mt-4 mb-3">Compensation Events</h4>
<ul class="mb-4">
    <li class="mb-3">The place where weather is to be recorded is
        <input type="text" name="weather_recording_place_is" class="form-control mt-2" required value="{{$contractAppl->weather_recording_place_is}}">
        @error('weather_recording_place_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>weather measurements</i> to be recorded for each calendar month are
    </li>
    <li class="ms-3">the cumulative rainfall (mm)
    </li>
    <li class="ms-3">the number of days with rainfall more than 5 mm
    </li>
    <li class="ms-3">the number of days with minimum air temperature less than 0 degree Celsius
    </li>
    <li class="ms-3 mb-3">the number of days with snow lying at
        <div class="input-group">
            <input name="weather_recording_snow_hour" type="time" class="form-control mt-2" style="flex: inherit; width: 120px;" required value="{{$contractAppl->weather_recording_snow_hour}}">
            <div class="input-group-append">
                <span class="input-group-text mt-2">hours GMT</span>
            </div>
        </div>
        @error('weather_recording_snow_hour')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="ms-3 mb-3">and these measurements:
        <textarea name="weather_recording_additional" class="form-control mt-2" rows="3" required>{{$contractAppl->weather_recording_additional}}</textarea>
        @error('weather_recording_additional')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>weather measurements</i> are supplied by
        <input type="text" name="weather_recording_supplier" class="form-control mt-2" required value="{{$contractAppl->weather_recording_supplier}}">
        @error('weather_recording_supplier')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>weather data</i> are the records of past <i>weather measurements</i> for each calendar month which are recorded at
        <input type="text" name="weather_data_recorded_at" class="form-control mt-2 mb-3" required value="{{$contractAppl->weather_data_recorded_at}}"> and which are available from
        @error('weather_data_recorded_at')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <input type="text" name="weather_data_available_from" class="form-control mt-2" required value="{{$contractAppl->weather_data_available_from}}">
        @error('weather_data_available_from')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <h6 class="mt-3">Where no recorded data are available</h6>
    <li class="mb-3">Assumed values for the ten year return <i>weather data</i> for each <i>weather measurement</i> for each calendar month are
        <textarea name="weather_data_assumed" class="form-control mt-2" rows="3" required>{{$contractAppl->weather_data_assumed}}</textarea>
        @error('weather_data_assumed')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif
@if (str_contains($contractType,'NEC4'))
@if (str_starts_with($contractAppl->main_opt, 'Option A:') || str_starts_with($contractAppl->main_opt, 'Option B:'))
<!-- <h6 class="mt-3">If Option A @if(!str_contains($contractType,'TSC')) or B @endif is used</h6> -->
<ul class="my-4">
    <li class="my-5">The <i>value engineering percentage</i> is 50%, unless another percentage
        is stated here, in which case it is
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input name="a_value_engineering_percentage" type="number" step="1" min="1" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0; width: 100px;" value="{{$nec4Contract->a_value_engineering_percentage}}" required>
            </div>
            <label class="input-group-text">%</label>
        </div>
        @error('a_value_engineering_percentage')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif
@if (!str_contains($contractType,'TSC'))
@if (str_starts_with($contractAppl->main_opt, 'Option B:') || str_starts_with($contractAppl->main_opt, 'Option D:'))
<!-- <h6 class="mt-3">If Option B or D is used</h6> -->
<ul class="my-4" style="margin-left: -1rem !important;">
    <li class="my-5">
        The <i>method of measurement</i> is
        <textarea name="method_of_measurement_is" class="form-control mt-2" rows="3" required>{{$contractAppl->method_of_measurement_is}}</textarea>
        @error('method_of_measurement_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif
@endif
<h6 class="mt-3">If there are additional compensation events</h6>
<ul class="mb-4">
    <li class="mb-3">These are additional compensation events
        <div class="input-group mt-2">
            <textarea name="additional_compansation_events" class="form-control mt-2" rows="3" required>{{$nec4Contract->additional_compansation_events}}</textarea>
        </div>
        @error('additional_compansation_events')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@else
<hr>
<h4 class="card-title mt-4 mb-3">Risks and insurance</h4>
<ul class="mb-4">
    @if (str_contains($contractType,'TSC'))
    <li class="mb-3">The minimum amount of cover for insurance against loss of or damage
        caused by the <i>Contractor</i> to the <i>Employer’s</i> property is
        <input type="number" min=0 step=0.01 name="insurance_min_amount_to_emp_prop" class="form-control mt-2" required value="{{$contractAppl->insurance_min_amount_to_emp_prop}}">
        @error('insurance_min_amount_to_emp_prop')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
    <li class="mb-3">The minimum {{str_contains($contractType,'TSC') ? 'amount of cover' :'limit of indemnity'}} for insurance in respect of loss of or damage to property (except the <i>@if(str_contains($contractType,'TSC')) Employer’s Property @else @if(str_contains($contractType,'ECS')) subcontract @endif works @endif</i>, Plant and Materials and Equipment) and liability for bodily injury to or death of a person (not an employee of the <i>{{str_contains($contractType,'ECS') ? 'Sub' : ''}}Contractor</i>)
        @if(str_contains($contractType,'TSC')) arising from or in connection with the <i>Contractor’s</i> Providing the Service @else caused by activity in connection with this {{str_contains($contractType,'ECS') ? 'Sub' : ''}}contract @endif for any one event is
        <input type="number" min=0 step=0.01 name="insurance_text_1" class="form-control mt-2" required value="{{$contractAppl->insurance_text_1}}">
        @error('insurance_text_1')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The minimum limit of indemnity for insurance in respect of death of or bodily injury to employees of the <i>{{str_contains($contractType,'ECS') ? 'Sub' : ''}}Contractor</i> arising out of and in the course of their employment in connection with this {{str_contains($contractType,'ECS') ? 'sub' : ''}}contract for any one event is
        <input type="number" min=0 step=0.01 name="insurance_min_text_2" class="form-control mt-2" required value="{{$contractAppl->insurance_min_text_2}}">
        @error('insurance_min_text_2')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif