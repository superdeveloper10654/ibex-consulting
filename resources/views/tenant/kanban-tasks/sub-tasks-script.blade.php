<script>
    // $('.toggle-sub-task').on('click', function(event) {
    //     event.stopPropagation()
    //     let subTask = $(this).closest('div.actions').next('div.subtasks')
    //     $(this).find('path.arrow').toggle()
    //     let height = 0
    //     if (subTask.height() == 0) {
    //         height = $(this).closest('div.actions').next('div.subtasks').prop('scrollHeight');
    //     }
    //     $(this).closest('div.actions').next('div.subtasks').animate({
    //         "max-height": height,
    //     }, ($(this).closest('div.actions').next('div.subtasks').prop('scrollHeight') * 10))
    // });

    function showSubTask(event) {
        event.stopPropagation()
        let subTask = $(event.target).closest('div.actions').next('div.subtasks')
        $(event.target).find('path.arrow').toggle()
        let height = 0
        if (subTask.height() == 0) {
            height = $(event.target).closest('div.actions').next('div.subtasks').prop('scrollHeight');
        }
        $(event.target).closest('div.actions').next('div.subtasks').animate({
            "max-height": height,
        }, ($(event.target).closest('div.actions').next('div.subtasks').prop('scrollHeight') * 10))
    }
</script>