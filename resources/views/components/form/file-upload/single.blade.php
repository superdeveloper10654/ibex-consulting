@php   
    $attributes = $attributes->merge([
        'class' => 'form-control',
        'type'  => 'text',
        'id'    => $name,
    ])->filter(function($val, $key) {
        return !in_array($key, ['label']);
    });

    $id_camelized = Illuminate\Support\Str::camel($name);
    $text = $text ?? 'Drop image here or click to upload';
    $icon = $icon ?? 'display-4 text-muted bx bxs-cloud-upload';
    $accepted_files = ".jpeg, .jpg, .png, .gif, .svg";
    $max_filesize = $maxFilesize ?? 5; // Mb
    $thumbnail_width = $thumbnailWidth ?? 300;
    $existing_file = !empty($existingFile) ? $existingFile : '';
@endphp

@isset($label)
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
@endisset
<!-- id will be used for genrating file element name attribute -->
<div id="{{ $name }}" class="dropzone single-file" action="placeholder">
    <div class="fallback">
        <input name="{{ $name }}" type="file" />
    </div>
    <div class="dz-message needsclick">
        <div class="mb-3">
            <i class="{{ $icon }}"></i>
        </div>

        <h4>{{ $text }}</h4>
    </div>
</div>

<div class="text-danger" data-error="{{ $name }}"></div>
{{-- In case if field will be used in non-ajax forms --}}
@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror

@push('css')
    <style>
        #{{ $name }} .dz-image {
            width: {{ $thumbnail_width }}px;
            height: auto;
        }
    </style>
@endpush

@push('script')
    <script>
        {
            let form = $('#{{ $name }}').closest('form');
            let existing_file = '';

            @if ($existing_file)
                existing_file = '{{ $existing_file }}';
            @endif

            Dropzone.options['{{ $id_camelized }}'] = { // The camelized version of the ID of the form element
                autoProcessQueue: false,
                uploadMultiple: false,
                maxFiles: 1,
                acceptedFiles: '{{ $accepted_files }}',
                maxFilesize: '{{ $max_filesize }}',
                thumbnailWidth: '{{ $thumbnail_width }}',
                thumbnailHeight: null,

                init: function() {
                    var myDropzone = this;

                    myDropzone.on('addedfile', function(file) {
                        $(file.previewElement).find('.dz-progress').hide();

                        if (!file.size) {
                            $(file.previewElement).find('.dz-size').hide();
                        }
                        if (!file.name) {
                            $(file.previewElement).find('.dz-filename').hide();
                        }

                        let previousFilePrev = $(myDropzone.element).find('.dz-preview').not(file.previewElement);
                        if (previousFilePrev) {
                            previousFilePrev.remove();
                        }

                        // only 1 file can be uploaded
                        if (myDropzone.getAcceptedFiles().length && myDropzone.getRejectedFiles().length){
                            let accepted_file = myDropzone.getAcceptedFiles()[0];
                            myDropzone.removeFile(accepted_file);
                        }

                        let form_data = new FormData(form[0]);
                        form_data.append("icon", file); 
                        
                        file.tippy = tippy(file.previewElement, {
                            content     : `<button type="button" class="btn btn-danger waves-effect waves-light w-sm remove-file" role="button">
                                                <i class="mdi mdi-trash-can d-block font-size-16"></i> Delete
                                            </button>`,
                            allowHTML   : true,
                            placement   : 'bottom',
                            theme       : 'bg-transparent',
                            trigger     : 'mouseenter focus focusin click',
                            interactive : true,
                        });
                    });

                    if (existing_file) {
                        myDropzone.displayExistingFile({}, existing_file);
                    }
                }
            }

            $(document).on('click', '.remove-file', function() {
                $(this).closest('.dropzone').find('.dz-preview').remove();
                $(this).closest('.dropzone')[0].dropzone.removeAllFiles();
                $(this).closest('.dropzone').removeClass('dz-started'); // remove class to show message
                form.append("<input type='hidden' name='{{ $name }}_delete' value='1' />"); // mark this file to be deleted for backend
                $(this).remove();
            });
        }
    </script>
@endpush