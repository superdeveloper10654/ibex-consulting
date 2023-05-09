@extends('tenant.layouts.master')

@section('title')
    Edit Early Warning {{ $early_warning->name }}
@endsection

@push('css')
    @include('tenant.early-warnings.create-edit-styles')
@endpush

@section('content')
    <x-resource.breadcrumb :resource="$early_warning" :title="'Edit Early Warning ' . $early_warning->name" />

    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="update-early-warning" method="POST" autocomplete="off">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract" :options="$contracts->pluck('contract_name', 'id')" :selected="old('contract', $early_warning->contract->id)" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Programme" name="programme" :options="$programmes" :selected="old('programme', $early_warning->programme->id)" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="Title" name="title" :value="old('title', $early_warning->title)" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.textarea label="Description" name="description"
                                    placeholder="In accordance with clause 16.1 of the contract, I notify you" :value="old('description', $early_warning->description)" />
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label pb-3">This matter could:</label>

                                <input type="hidden" name="effect1" value="0">
                                <input type="hidden" name="effect2" value="0">
                                <input type="hidden" name="effect3" value="0">
                                <input type="hidden" name="effect4" value="0">

                                <div class="row">
                                    <x-form.checkbox-customized label="increase the total of the Prices" name="effect1" :checked="old('effect1', $early_warning->effect1) == 1 ? 'checked' : false" />
                                </div>
                                <div class="row">
                                    <x-form.checkbox-customized label="delay Completion" name="effect2" :checked="old('effect2', $early_warning->effect2) == 1 ? 'checked' : false" />
                                </div>
                                <div class="row">
                                    <x-form.checkbox-customized label="delay meeting a Key Date" name="effect3" :checked="old('effect3', $early_warning->effect3) == 1 ? 'checked' : false" />
                                </div>
                                <div class="row">
                                    <x-form.checkbox-customized label="impair the performance of the works in use" name="effect4"
                                        :checked="old('effect4', $early_warning->effect4) == 1 ? 'checked' : false" />
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row mb-5">
                            <label class="form-label">Risk Score:</label>
                            <table class="score-table col-md-6">
                                <tr id="consequence">
                                    <td style="color: var(--bs-body-color);" colspan="6">Consequence</td>
                                </tr>
                                <tr id="likelihood">
                                    <td rowspan="6"></td>
                                </tr>
                                <input type="hidden" name="risk_score" id="risk_score" value="0">
                                <input type="hidden" name="score_order" id="score_order" value="0">
                                @foreach ($table['table'] as $rowKey => $tableRow)
                                    <tr>
                                        @foreach ($tableRow as $cellKey => $risk_score)
                                            <td class="selectable" data-score="{{ $risk_score }}" data-order="{{ $rowKey }}" 
                                                style="background-color: {{ $table['colors'][$risk_score] }}">{{ $risk_score }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>

                            <div class="col-md-6 p-5">
                                <div class="p-2">
                                    <span class="legend-colour slight"></span><span>Slight</span>
                                </div>
                                <div class="p-2">
                                    <span class="legend-colour trivial"></span><span>Trivial</span>
                                </div>
                                <div class="p-2">
                                    <span class="legend-colour minor"></span><span>Minor</span>
                                </div>
                                <div class="p-2">
                                    <span class="legend-colour modest"></span><span>Modest</span>
                                </div>
                                <div class="p-2">
                                    <span class="legend-colour major"></span><span>Major</span>
                                </div>
                                <div class="p-2">
                                    <span class="legend-colour critical"></span><span>Critical</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row float-end mt-5 pb-3">
                            <div class="col-6">
                                <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('tenant.early-warnings.create-edit-scripts')
    <script>
        jQuery(($) => {
            $('#update-early-warning').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax("{{ t_route('early-warnings.update', $early_warning->id) }}", this, {
                    redirect: "{{ t_route('early-warnings.show', $early_warning->id) }}"
                });
            });

            $(".score-table td.selectable[data-score='{{ $early_warning->risk_score }}'][data-order='{{ $early_warning->score_order }}']").click();
        });
    </script>
@endsection
