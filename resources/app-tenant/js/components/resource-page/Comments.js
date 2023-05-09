let Comments = {
    add: function(comment) {
        let $list = $('#comments .comments-list');
        $list.append(`<div class="d-flex">
            <div class="flex-shrink-0 me-3">
                <img src="${comment.icon_url}" class="avatar-xs rounded-circle" alt="Commentator avatar">
            </div>

            <div class="flex-grow-1 ${comment.author_profile_id == user_profile.id ? 'bg-light1' : ''}">
                <p class="m-0">${comment.author}</p>
                <p class="text-muted small mb-1">${comment.date}</p>
                <p>${comment.text}</p>
            </div>
        </div>`);

        $('#comments .has-no-comments').hide()
    },

    init: function(params) {
        $('#add-new-comment').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax(params.request_url, this, {callback: () => {
                $('#add-new-comment #new-comment').val('');
            }});
        });
        
        Channels.subscribe(`comment.created.${params.resource_name}.${params.resource_id}`, (comment) => {
            Comments.add(comment);
        });
    },
};