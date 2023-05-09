<div class="files-list-wrapper row">

    {{ $slot }}

    <form id="new-files-form">
        <input type="file" name="new_files[]" id="new-files" class="d-none" multiple />
        <x-form.input type="hidden" name="upload_to_folder" :value="$folder" />

        @if (!empty($resourceId))
            <x-form.input type="hidden" name="resource_id" :value="$resourceId" />
        @endif
    </form>

    @if ($files->isNotEmpty() || ($files->isEmpty() && empty($hideEmptyList)))
        <div class="files-list">
            <table class="table table-nowrap align-middle table-hover mb-0">
                <tbody>
                    @if ($files->isNotEmpty())
                        @foreach ($files as $file)
                            <tr class="file-line" data-file-id="{{ $file->id }}">
                                <td class="pe-0">
                                    @if (str_contains($file->mime_type, 'image'))
                                        <a href="{{ route('uploads.download', $file->id) }}" target="_blank">
                                            <img src="{{ route('uploads.download', $file->id) }}"
                                                style="max-height: 60px; max-width: 60px;" />
                                        </a>
                                    @elseif(str_contains($file->mime_type, 'application/zip'))
                                        <a href="{{ route('uploads.download', $file->id) }}" target="_blank">
                                            <span class="avatar-title rounded-circle bg-light text-dark font-size-24"
                                                style="height: 60px; width: 60px;">
                                                <i class="mdi mdi-folder-zip-outline"></i>
                                            </span>
                                        </a>
                                    @elseif(str_contains($file->mime_type, 'application/pdf'))
                                        <a href="{{ route('uploads.download', $file->id) }}" target="_blank">
                                            <span class="avatar-title rounded-circle bg-light text-danger font-size-24"
                                                style="height: 60px; width: 60px;">
                                                <i class="mdi mdi-file-pdf-outline"></i>
                                            </span>
                                        </a>
                                    @elseif(str_contains($file->mime_type, 'application/vnd.ms-excel') ||
                                            str_contains($file->mime_type, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))
                                        <a href="{{ route('uploads.download', $file->id) }}" target="_blank">
                                            <span class="avatar-title rounded-circle bg-light text-success font-size-24"
                                                style="height: 60px; width: 60px;">
                                                <i class="mdi mdi-file-excel-outline"></i>
                                            </span>
                                        </a>
                                    @elseif(str_contains($file->mime_type, 'application/msword') ||
                                            str_contains($file->mime_type, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'))
                                        <a href="{{ route('uploads.download', $file->id) }}" target="_blank">
                                            <span class="avatar-title rounded-circle bg-light text-info font-size-24"
                                                style="height: 60px; width: 60px;">
                                                <i class="mdi mdi-file-word-outline"></i>
                                            </span>
                                        </a>
                                    @elseif(str_contains($file->mime_type, 'application/vnd.ms-powerpoint') ||
                                            str_contains($file->mime_type, 'application/vnd.openxmlformats-officedocument.presentationml.presentation'))
                                        <a href="{{ route('uploads.download', $file->id) }}" target="_blank">
                                            <span class="avatar-title rounded-circle bg-light text-warning font-size-24"
                                                style="height: 60px; width: 60px;">
                                                <i class="mdi mdi-file-powerpoint-outline"></i>
                                            </span>
                                        </a>
                                    @else
                                        <a href="{{ route('uploads.download', $file->id) }}" target="_blank">
                                            <div class="avatar-sm">
                                                <span class="avatar-title rounded-circle bg-light text-secondary font-size-24"
                                                    style="height: 60px; width: 60px;">
                                                    <i class="mdi mdi-file-outline"></i>
                                                </span>
                                            </div>
                                        </a>
                                    @endif
                                </td>
                                <td class="pe-0">
                                    <a href="{{ route('uploads.download', $file->id) }}" target="_blank" class="text-dark">
                                        <p class="m-0 pt-3" style="white-space: normal;">{{ $file->file_name }}</p>
                                        <p class="uploaded-at text-muted small">
                                            {{ date(AppTenant\Models\Statical\Format::DATE_WITH_TIME_READABLE, strtotime($file->created_at)) }}
                                        </p>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    @endif

    @push('script')
        <script>
            FilesList.init('{{ $folder }}');
        </script>
    @endpush

    @push('modals')
        <!-- Rename file modal -->
        <div class="modal fade" id="rename-file-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="rename-file-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rename-file-label"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="rename-file-form">
                            <x-form.input type="hidden" name="rename_file_id" />
                            <x-form.input label="New file name" name="new_file_name" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="renameFileModalSave()">Rename</button>
                    </div>
                </div>
            </div>
        </div>

        <x-overlay.loader />
    @endpush
</div>
