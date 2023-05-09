let RightSidebar = {
    addActivity: function(activity) {
        let $activity = $(`<li class="list-group-item border-0 searchable">
            <a href="${activity.link}" class="d-flex text-body" title="Click to open">
                <div class="flex-shrink-0 me-3">
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-light text-dark fs-5 icon-wrapper">
                            ${activity.img}
                        </span>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <p>
                        <span class="fst-italic author-name">${activity.author}&nbsp;</span>
                        <span class="text">${activity.text}</span>
                    </p>
                    <p class="text-muted small date-created">${activity.date}</p>
                </div>
            </a>
        </li>`);
        $('#activities-container').prepend($activity);
        $('#topbar-activities-counter').text(Number($('#topbar-activities-counter').text()) + 1);
    },

    init: function() {
        $('.right-bar-toggle').on('click', function (e) {
            $('body').toggleClass('right-bar-enabled');
        });

        $(document).on('click', 'body', function (e) {
            if ($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
                return;
            }

            $('body').removeClass('right-bar-enabled');
            return;
        });
    },

    loadMoreActivities: function() {
        myAjax(conf.routes['activities.load-previous'], {
            before: last_activity_id
        }).then(res => {
            if (res.data.activities.length) {
                res.data.activities.map(activity => {
                    let $activity = $('#activities-container .list-group-item:last').clone();
                    $activity.find('.icon-wrapper').html(activity.icon);
                    $activity.find('.author-name').text(activity.author_name);
                    $activity.find('.text').html(activity.text);
                    $activity.find('.date-created').text(activity.date_created);
                    $activity.insertAfter($('#activities-container .list-group-item:last'));
                });

                last_activity_id = res.data.activities[res.data.activities.length - 1].id;
                has_more_activities = res.data.has_other_items;
            } else {
                has_more_activities = false;
            }

            if (!has_more_activities) {
                $('#activities-container .load-latest-wrapper').hide();
            }
        });
    },
};