dragula([document.getElementById("upcoming-task"), document.getElementById("inprogress-task"), document.getElementById("complete-task")]).on('drop', function (element, target, source, sibling) {
    if (target.id != source.id) {
        let progress;

        if (target.id == 'inprogress-task') {
            progress = 0.1;

        } else if (target.id == 'complete-task') {
            progress = 1;

        } else if (target.id == 'upcoming-task') {
            progress = 0;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/tasks-kanban/' + element.id.split('-').pop() + '/update-attribute',
            method: 'POST',
            data: { progress: progress },
            success: (res) => {

                addTaskCard(res.task, res.subTasks)

            },
            error: (error) => {
                console.log('error', error)
            }
        });
    }
});