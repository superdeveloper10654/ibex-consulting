<div class="card">
    <div class="card-body p-4">
        <div class="row">
            <div class="col comments-list">
                @if ($resource->comments->isNotEmpty())
                    @if (count($resource->comments) > 5)
                        <div class="button-anchor d-flex justify-content-center my-3">
                            <a href="#new-comment-anchor" class="btn btn-secondary d-inline-block" type="button">
                                <i class="mdi mdi-plus me-1"></i>New comment
                            </a>
                        </div>
                    @endif
                    @foreach ($resource->comments as $comment)
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <img src="{{ asset($comment->commentator->avatar_url()) }}" class="avatar-xs rounded-circle" alt="Commentator avatar">
                            </div>

                            <div class="flex-grow-1 {{ t_profile()->id == $comment->commentator->id ? 'bg-light1' : '' }}">
                                <p class="m-0">{{ $comment->commentator->full_name() }}</p>
                                <p class="text-muted small mb-1">{{ $comment->created_at->format(AppTenant\Models\Statical\Format::DATE_WITH_TIME_READABLE) }}</p>
                                <p>{{ $comment->comment }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="pt-4 has-no-comments">Has no comments yet</p>
                @endif
            </div>
        </div>
        <hr class="my-4">
        <div class="row">
            <div class=" col-12 new-comment-section">
                <form id="add-new-comment">
                    <x-form.textarea label="New comment" name="new-comment" />
                    <button type="submit" class="btn btn-primary btn-rounded w-md float-end mt-3" data-action="add-new-comment">Submit <i class="mdi mdi-send"></i></button>
                </form>
            </div>
        </div>
        <div id="new-comment-anchor"></div>
    </div>
</div>

@push('script')
    <script>
        jQuery(($) => {
            Comments.init({
                request_url     : "{{ $resource->link('add-comment') }}",
                resource_id     : "{{ $resource->id }}",
                resource_name   : "{{ $resource->resourceNameDashed() }}",
            });
        });
    </script>
@endpush