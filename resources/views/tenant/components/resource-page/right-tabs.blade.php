@if (!$resource->isDraft())
    <div class="right-col col-md-4 pt-2 d-print-none">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="uploads-tab" data-bs-toggle="tab" data-bs-target="#uploads" type="button" role="tab"
                    aria-controls="uploads" aria-selected="true"><i class="mdi mdi-paperclip"></i> Uploads</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab"
                    aria-controls="comments" aria-selected="false"><i class="mdi mdi-chat-processing-outline"></i> Comments</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="uploads" role="tabpanel" aria-labelledby="uploads-tab">
                <div class="card">
                    <div class="card-body p-4">
                        <x-uploads.files-list 
                            :files="$uploadsFiles"
                            :folder="$uploadsFolder"
                            :resource-id="$resource->id"
                            hide-empty-list="true"
                        >
                            <div>
                                <ul class="list-group" data-simplebar="init" style="max-height: 350px;">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper"
                                                    style="height: auto; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                                                    <div class="simplebar-content" style="padding: 0px;">
                                                        <div class="mb-3">
                                                            <p class="text-muted text-center"><i
                                                                    class="bx bx-info-circle"></i>&nbsp;<small>Upload any related files
                                                                    here</small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simplebar-placeholder" style="width: 351px; height: 512px;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                        <div class="simplebar-scrollbar"
                                            style="height: 297px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                    </div>
                                </ul>
                            </div>
                            <div>
                                <ul class="list-group" data-simplebar="init" style="max-height: 350px;">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper"
                                                    style="height: auto; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                                                    <div class="simplebar-content" style="padding: 0px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simplebar-placeholder" style="width: 351px; height: 512px;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                        <div class="simplebar-scrollbar"
                                            style="height: 297px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                    </div>
                                </ul>
                            </div>
                            <div class="mb-3 text-center">
                                <button type="button" class="btn btn-secondary btn-rounded w-md waves-effect waves-light" onclick="$('#new-files').click()">
                                    <i class="mdi mdi-upload me-1"></i>&nbsp;Upload
                                </button>
                            </div>                        
                        </x-uploads.files-list>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                <x-resource-page.comments :resource="$resource" />
            </div>
        </div>
    </div>
@endif