let FilesList = {
    file_rename_modal_jq: '',
    file_rename_modal: '',

    init: function(folder) {
        this.file_rename_modal_jq = $('#rename-file-modal');
        this.file_rename_modal = new bootstrap.Modal(this.file_rename_modal_jq);

        $('#new-files').on('change', function() {
            $('#new-files-form').trigger('submit');
        });

        $('#new-files-form').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);
            showLoader();

            form_ajax(conf.routes['uploads.store'], this, {refresh: false})
                .finally(() => {
                    hideLoader();
                });
        });

        Channels.subscribe(`file.created.${folder}`, (file) => {
            FilesList.addFileLine(file);
        });
    },

    deleteFile: function(btn) {
        let file_line = $(btn).closest('.file-line');

        $.ajax({
            url: conf.routes['uploads.remove'],
            method: 'POST',
            dataType: 'json',
            data: {
                csrf: $('meta[name=csrf-token]').attr('content'),
                file_id: $(file_line).data('file-id'),
            },
            success: (res) => {
                if (res.success) {
                    file_line.remove();
                } else {
                    errorMsg(res.message);
                }
            }
        });
    },

    openRenameFileModal: function(line_btn) {
        let file_line = $(line_btn).closest('.file-line');

        this.file_rename_modal_jq.find('input[name=rename_file_id]').val($(file_line).data('file-id'));
        this.file_rename_modal_jq.find('input[name=new_file_name]').val($(file_line).find('.name').text().trim());
        this.file_rename_modal.show();
    },

    renameFileModalSave: function() {
        form_ajax(conf.routes['uploads.file-rename'], $('#rename-file-form'), {
                refresh: false
            })
            .then((res) => {
                if (res.success) {
                    let renamed_line_id = this.file_rename_modal_jq.find('input[name=rename_file_id]').val();
                    let new_file_name = this.file_rename_modal_jq.find('input[name=new_file_name]').val();
                    $(`.files-list .file-line[data-file-id=${renamed_line_id}] .name a`).text(new_file_name);
                    this.file_rename_modal.hide();
                }
            })
    },

    addFileLine: function(file) {
        let left_content = '';

        if (file.mime_type.includes('image')) {
            left_content = `<a href="${file.link}" target="_blank">
                <img src="${file.link}"
                    style="max-height: 60px; max-width: 60px;" />
            </a>`;
        } else if (file.mime_type.includes('application/zip')) {
            left_content = `<a href="${file.link}" target="_blank">
                <span class="avatar-title rounded-circle bg-light text-dark font-size-24"
                    style="height: 60px; width: 60px;">
                    <i class="mdi mdi-folder-zip-outline"></i>
                </span>
            </a>`;
        } else if (file.mime_type.includes('application/pdf')) {
            left_content = `<a href="${file.link}" target="_blank">
                <span class="avatar-title rounded-circle bg-light text-danger font-size-24"
                    style="height: 60px; width: 60px;">
                    <i class="mdi mdi-file-pdf-outline"></i>
                </span>
            </a>`;
        } else if (file.mime_type.includes('application/vnd.ms-excel') || file.mime_type.includes('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) {
            left_content = `<a href="${file.link}" target="_blank">
                <span class="avatar-title rounded-circle bg-light text-success font-size-24"
                    style="height: 60px; width: 60px;">
                    <i class="mdi mdi-file-excel-outline"></i>
                </span>
            </a>`;
        } else if (file.mime_type.includes('application/msword') || file.mime_type.includes('application/vnd.openxmlformats-officedocument.wordprocessingml.document')) {
            left_content = `<a href="${file.link}" target="_blank">
                <span class="avatar-title rounded-circle bg-light text-info font-size-24"
                    style="height: 60px; width: 60px;">
                    <i class="mdi mdi-file-word-outline"></i>
                </span>
            </a>`;
        } else if (file.mime_type.includes('application/vnd.ms-powerpoint') || file.mime_type.includes('application/vnd.openxmlformats-officedocument.presentationml.presentation')) {
            left_content = `<a href="${file.link}" target="_blank">
                <span class="avatar-title rounded-circle bg-light text-warning font-size-24"
                    style="height: 60px; width: 60px;">
                    <i class="mdi mdi-file-powerpoint-outline"></i>
                </span>
            </a>`;
        } else {
            left_content = `<a href="${file.link}" target="_blank">
                <div class="avatar-sm">
                    <span class="avatar-title rounded-circle bg-light text-secondary font-size-24"
                        style="height: 60px; width: 60px;">
                        <i class="mdi mdi-file-outline"></i>
                    </span>
                </div>
            </a>`;
        }

        let line = `<tr class="file-line" data-file-id="${file.id}">
                <td class="pe-0">
                    ${left_content}
                </td>
                <td class="pe-0">
                    <a href="${file.link}" target="_blank" class="text-dark">
                        <p class="m-0 pt-3" style="white-space: normal;">${file.file_name}</p>
                        <p class="uploaded-at text-muted small">
                            ${file.created_at}
                        </p>
                    </a>
                </td>
            </tr>`;

        $('.files-list tbody').append(line);    
    },

    generateFilesLine: function(file) {
        let maybe_remove_btn = '';

        if (user_profile.can['uploads.remove']) {
            maybe_remove_btn = '<span class="btn dropdown-item" onclick="FilesList.deleteFile(this)">Remove</span>';
        }

        let line = `
        <div class="row file-line border-bottom position-relative" data-file-id="${file.id}">
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
    },
};