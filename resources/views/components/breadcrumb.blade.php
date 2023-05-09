<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box pt-3 d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
            
            @if (isset($centered_items))
                <div class="text-center d-grid">
                    {!! $centered_items !!}
                </div>
            @endif

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ !empty($li_1_link) ? $li_1_link : 'javascript: void(0)' }}">{{ $li_1 }}</a></li>
                    @if(isset($title))
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    @endif
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->