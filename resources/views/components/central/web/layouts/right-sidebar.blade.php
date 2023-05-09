<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center px-3 py-4">

            <h5 class="m-0 me-2">@lang('Activities')</h5>

            <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <!-- Settings -->
        <hr class="mt-0" />
        <ul class="list-group" data-simplebar="init" style="height: calc(100vh - 85px); overflow-x: hidden;">
            <div class="simplebar-wrapper" style="margin: 0px;">
                <div class="simplebar-height-auto-observer-wrapper">
                    <div class="simplebar-height-auto-observer"></div>
                </div>
                <div class="simplebar-mask">
                    <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                        <div class="simplebar-content-wrapper"
                            style="height: auto; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                            <div class="simplebar-content" id="activities-container" style="padding: 0px;">
                                @if ($activities->isEmpty())
                                    <p class="text-center">@lang('Nothing yet')</p>
                                @else
                                    @foreach ($activities as $activity)
                                        <li class="list-group-item border-0 searchable">
                                            <a href="{{ $activity->link }}" class="d-flex text-body" title="Click to open">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-light text-dark fs-5 icon-wrapper">
                                                            {!! $activity->img !!}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p>
                                                        <span class="fst-italic author-name">
                                                            {!! $activity->profile ? $activity->profile->full_name() . '&nbsp;' : '' !!}
                                                        </span>
                                                        <span class="text">
                                                            {!! $activity->text !!}
                                                        </span>
                                                    </p>
                                                    <p class="text-muted small date-created">
                                                        {{ $activity->created_at->format(AppTenant\Models\Statical\Format::DATE_WITH_TIME_READABLE) }}
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach

                                    @if ($has_more_activities)
                                        <li class="load-latest-wrapper text-center">
                                            <button class="btn btn-link btn-load-latest" onclick='RightSidebar.loadMoreActivities()'>Load more</button>
                                        </li>
                                    @endif
                                @endif
                            </div>
                            @if ($has_more_activities)
                                <script>
                                    let last_activity_id = {{ $activities->last()->id }};
                                    let has_more_activities = true;
                                </script>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: 351px; height: 512px;"></div>
        </ul>
    </div>
    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
        <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
    </div>
    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
        <div class="simplebar-scrollbar" style="height: 297px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
    </div>
</div> <!-- end slimscroll-menu-->
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
