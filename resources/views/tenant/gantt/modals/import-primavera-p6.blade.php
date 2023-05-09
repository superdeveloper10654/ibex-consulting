<style type="text/css">
.datepicker {
    z-index: 9999 !important;
}
.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom {
    z-index: 999999999 !important;
}

input[type=file]::-webkit-file-upload-button {
  display: none;
}

input[type=file]::file-selector-button {
  display: none;
}
</style>
<div class="modal" tabindex="-1" id="modal_import_primavera_p6">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Import Primavera P6 file</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="ImportPrimaveraP6" action="" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
          <p>
         Please choose an XER or XML file to import
        </p>
          <div class="row">
            <div class="col-md-12">
              <input type="file" id="primaveraFile" class="btn btn-light btn-rounded w-100 waves-effect waves-light" name="file" accept=".mpp,.xml,.xer, text/xml, application/xml, application/xer, application/vnd.ms-project, application/msproj, application/msproject, application/x-msproject, application/x-ms-project, application/x-dos_ms_project, application/mpp, zz-application/zz-winassoc-mpp" style="display: none;"/>
                                <label for="primaveraFile" id="primaveraFile-label" class="btn btn-light btn-rounded w-100 waves-effect waves-light">Select Primavera P6 file</label>
            </div>
          </div> 
    </div>
      <div class="modal-footer">
        <button type="submit" id="primaveraImportBtn" class="btn btn-primary btn-rounded waves-effect waves-light w-md mx-1" type="submit" style="display: none"><i class="mdi mdi-file-upload-outline font-size-16 align-middle"></i> Import</button>
      </div>
        </form>
  </div>
</div>
</div>
  