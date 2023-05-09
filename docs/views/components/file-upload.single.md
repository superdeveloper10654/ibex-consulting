# Single file upload

## Example:
```
<x-form.file-upload.single label="Icon" name="icon" />
```


## Generates following structure (without including scripts):

```
<label for="icon" class="form-label">Icon</label>
<!-- id will be used for genrating file element name attribute -->
<div id="icon" class="dropzone single-file dz-clickable" action="placeholder">
    <div class="dz-message needsclick">
        <div class="mb-3">
            <i class="display-4 text-muted bx bxs-cloud-upload"></i>
        </div>

        <h4>Drop icon here or click to upload</h4>
    </div>
</div>
<div class="text-danger" data-error="icon">Message that will be shown when form_ajax() returns validation errror</div>
```

## Accepted attributes:
 * `name` - name of the input (either will be used for `id` attribute);
 * `text` (default: 'Drop image here or click to upload') - text that will be shown on drop area;
 * `icon` (default: 'display-4 text-muted bx bxs-cloud-upload') - icon that will be shown on drop area;
 * `accepted-files` (default: '.jpeg, .jpg, .png, .gif, .svg') - list of accepted file extensions;
 * `max-filezise` (default: 5) - file max size;
 * `existing-file` (optional) - link to existing file that already upoaded;

## Notes:
 - element will be generated using [dropzone.js](https://docs.dropzone.dev/) library;