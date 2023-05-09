@extends('tenant.layouts.master')

@section('title') @lang('Uploads') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Uploads @endslot
        @slot('title') Shared Uploads @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-0 py-3">
                    <div class="px-3">
                        <h4 class="card-title">Folders</h4>

                        <form id="create-new-folder" style="display: none;">
                            <div class="new-folder-wrapper d-flex">
                                <div class="folder-name-wrapper input-group input-group-sm me-2">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Name:</span>
                                    <x-form.input name="folder_name" aria-describedby="inputGroup-sizing-sm" />
                                </div>
                                
                                <button class="btn btn-primary btn-rounded btn-sm w-xs waves-effect waves-light" type="submit">
                                    <i class="mdi mdi-plus me-1"></i> Create
                                </button>
                            </div>
                        </form>
                      
                    </div>
                    <div class="folders-list mt-4">
                        @if ($folders->isNotEmpty())
                            @foreach ($folders as $folder)
                                <div class="line">
                                    <span class="folder-link d-flex align-items-center justify-content-between w-100 p-1 px-3 {{ $folder->name != AppTenant\Models\Statical\MediaCollection::COLLECTION_ROOT ? 'ps-4' : '' }}"
                                        data-folder-name="{{ $folder->name }}"
                                        role="button"
                                    >
                                        <i class="folder-icon bx bxs-folder h2 text-warning mb-1 me-3"></i>
                                        <span class="name me-auto">{{ $folder->name }}</span>

                                        @if (!in_array($folder->name, AppTenant\Models\Statical\MediaCollection::getAll()))
                                            <span class="dropdown">
                                                <span class="font-size-16 text-muted dropdown-toggle" role="span"
                                                    data-bs-toggle="dropdown" aria-haspopup="true">
                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <span class="btn dropdown-item" onclick="openRenameFolderModal(this)"><i class="bx bx-pencil me-3"></i>Rename</span>

                                                    <form class="remove-folder">
                                                        <input type="hidden" name="name" id="folder-{{ $folder->name }}" value="{{ $folder->name }}" />
                                                        <button class="btn dropdown-item text-danger" type="submit"><i class="bx bx-trash me-3"></i></i>Remove</button>
                                                    </form>
                                                </div>
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <div class="line">Has no folders</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card filemanager-storage">
                <div class="card-body">
                    <div class="text-center">
                        <h5 class="font-size-15 mb-4">Storage</h5>
                        <div class="apex-charts" id="radial-chart-space-used"></div>

                        <p class="text-muted mt-4">{{ $space_used }} of {!! $space_available != App\Models\Statical\Constant::INFINITY ? $space_available : "<i class='mdi mdi-infinity mx-1'></i>" !!} used</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <!-- Component -->
                    <x-uploads.files-list :files="collect([])" :folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_ROOT">
                      <h4 class="card-title main-title"></h4>
                        <div class="p-3 mb-4 text-center border-bottom d-print-none">
                            <button type="button" class="btn btn-light btn-rounded w-md waves-effect waves-light" onclick="$('#new-files').click()">
                                Choose
                            </button>
                        </div>
                    </x-uploads.files-list>
                    <!-- End component -->
                </div>
            </div>
        </div>
    </div>

@push('modals')
    <!-- Rename folder modal -->
    <div class="modal fade" id="rename-folder-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rename-folder-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rename-folder-label"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="rename-folder-form">
                        <x-form.input type="hidden" name="rename_folder_name" />
                        <x-form.input label="New folder name" name="new_folder_name" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="renameFolderModalSave()">Rename</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script>
        let folder_rename_modal_jq;
        let folder_rename_modal;

        new ApexCharts(document.querySelector("#radial-chart-space-used"), { 
            series: [{{ $space_used_percents }}], 
            chart: { 
                height: 150,
                type: "radialBar",
                sparkline: {
                    enabled: !0
                }
            },
            colors: ["#556ee6"], 
            plotOptions: { 
                radialBar: { 
                    startAngle: -90, 
                    endAngle: 90, 
                    track: { 
                        background: "#e7e7e7", 
                        strokeWidth: "97%", 
                        margin: 5
                    },
                    hollow: {
                        size: "60%"
                    }, 
                    dataLabels: { 
                        name: { 
                            show: !1 
                        }, 
                        value: { 
                            offsetY: -2, 
                            fontSize: "16px" 
                        } 
                    } 
                } 
            }, 
            grid: { 
                padding: { 
                    top: -10 
                } 
            }, 
            stroke: { 
                dashArray: 3 
            }, 
            labels: ["Storage"] 
        }).render();

        jQuery(($) => {
            folder_rename_modal_jq = $('#rename-folder-modal');
            folder_rename_modal = new bootstrap.Modal(folder_rename_modal_jq);

            $('#create-new-folder').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("uploads.create-folder") }}', this);
            });

            $('.remove-folder').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("uploads.remove-folder") }}', this);
            });

            $('.folder-link').on('click', function() {
                if ($(this).hasClass('active')) {
                    return ;
                }

                let old_folder_name = $('.folder-link.active').data('folder-name');
                Channels.unsubscribe(`file.created.${old_folder_name}`);

                toggleFolderLineActive($('.folders-list .folder-link.active'));
                toggleFolderLineActive(this);

                let folder_name = $('.folder-link.active').data('folder-name');
                $('.files-list-wrapper .main-title').text(folder_name);

                Channels.subscribe(`file.created.${folder_name}`, (file) => {
                    let line = generateFilesLine(file);
                    $('.files-list-wrapper .no-files-line').remove();
                    $('.files-list-wrapper .files-list').append(line);
                });

                showLoader();

                $.ajax({
                    url         : "{{ t_route('uploads.files-ajax') }}",
                    method      : 'POST',
                    dataType    : 'json',
                    data        : {
                        csrf    : $('meta[name=csrf-token]').attr('content'),
                        folder  : folder_name,
                    },
                    success: (res) => {
                        hideLoader();
                        $('.files-list-wrapper .files-list').html('');

                        if (res.data.length) {
                            for (let file of res.data) {
                                let line = generateFilesLine(file);
                                $('.files-list-wrapper .files-list').append(line); // see uploads.files component
                            }
                        } else {
                            $('.files-list-wrapper .files-list').html(`
                                <tr class="no-files-line">
                                    <td colspan="10">No files in folder</td>
                                </tr>
                            `);
                        }
                    },
                    error: () => {
                        hideLoader();
                    }
                });

                $('#upload_to_folder').val(folder_name);
                addOrUpdateUrlParam('folder', folder_name);
            });

            let initial_folder = getUrlParam('folder');
            initial_folder = initial_folder ? initial_folder : '{{ AppTenant\Models\Statical\MediaCollection::COLLECTION_ROOT }}';

            $(`.folder-link[data-folder-name='${initial_folder}']`).click();
        });

        function toggleFolderLineActive(line)
        {
            $(line).toggleClass('active');
            $(line).find('.folder-icon').toggleClass('bxs-folder').toggleClass('bxs-folder-open');
        }

        /**
         * Creates file html string for Files container
         *
         * @param {string} file data
         *
         * @return string
         */
        function generateFilesLine(file)
        {
            let maybe_remove_btn = '';

            @t_can('uploads.remove')
                maybe_remove_btn = '<span class="btn dropdown-item" onclick="deleteFile(this)">Remove</span>';
            @endt_can

            let line = `
                <div class="row file-line position-relative" data-file-id="${file.id}">
                    <div class="name">
                        <a href="${file.link}" target="_blank">${file.file_name}</a>
                    </div>        
                    <div class="list-inline float-sm-end mb-sm-0">
                        <p class="text-muted small">${file.created_at}<br>${file.human_readable_size}</p>
                    </div>
                    <div class="actions position-absolute w-auto end-0 top-0">
                        <div class="dropdown">
                            <a class="font-size-16 text-muted dropdown-toggle" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <span class="btn dropdown-item" onclick="FilesList.openRenameFileModal(this)">Rename</span>
                                ${maybe_remove_btn}
                            </div>
                        </div>
                    <div>
                </div>
            `;

            return line;
        }

        function openRenameFolderModal(line_btn)
        {
            let folder_line = $(line_btn).closest('.line');
            let folder_name = $(folder_line).find('[data-folder-name]').data('folder-name');
            
            folder_rename_modal_jq.find('input[name=rename_folder_name]').val(folder_name);
            folder_rename_modal_jq.find('input[name=new_folder_name]').val(folder_name);
            folder_rename_modal.show();
        }

        function renameFolderModalSave()
        {
            form_ajax('{{ t_route("uploads.rename-folder") }}', $('#rename-folder-form'), {refresh: false})
                .then((res) => {
                    if (res.success) {
                        let renamed_folder = folder_rename_modal_jq.find('input[name=rename_folder_name]').val();
                        let new_folder_name = folder_rename_modal_jq.find('input[name=new_folder_name]').val();
                        $(`.folders-list .folder-link[data-folder-name="${renamed_folder}"] .name`).text(new_folder_name);
                        $(`.folders-list .folder-link[data-folder-name="${renamed_folder}"]`).attr('folder-name', new_folder_name);
                        folder_rename_modal.hide();

                    } else {
                        errorMsg(res.message);
                    }
                });
        }
    </script>
@endpush

@endsection