async function addTask(url){
    await swal({
        title: 'Registrar Tarefa',
        html:
        '<div class="card stacked-form">' +
            '<div class="card-body ">' +
                '<div class="form-group">' +
                    '<label>Para</label>' +
                    '<input placeholder="Para" name="user_to" class="form-control" type="text">' +
                '</div>' +
                '<div class="form-group">' +
                    '<label>Tarefa</label>' +
                    '<input placeholder="Tarefa" name="task" class="form-control" type="text">' +
                '</div>' +
                '<div class="form-group">' +
                    '<label>Data limite</label>' +
                    '<input placeholder="Data Limite" name="deadline" class="form-control" type="text">' +
                '</div>' +
            '</div>' +
        '</div>',
        focusConfirm: false,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return {
                user_to: $('input[name=user_to]').val(),
                task: $('input[name=task]').val(),
                deadline: $('input[name=deadline]').val(),
            }
        }
    }).then((result) => {
        if (result.value) {
            type = 'POST';
            url = url;
            data = {
                'user_to': result.value.user_to,
                'task': result.value.task,
                'deadline': result.value.deadline
            };
            execAjax(type, url, data);
        }
    })
}

function execAjax(type, url, data){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: type,
        url: url,
        data: data,
        cache: false,
        success: function(response) {
            if (!response.error) {
                swal(
                    "Sucesso!",
                    response.message,
                    "success"
                )
            }else {
                swal(
                    "Erro!",
                    response.message,
                    "error"
                )
            }
        },
        error: function (response) {
            swal(
                "Erro interno!",
                "Oops, ocorreu um erro ao tentar salvar as alterações.", // had a missing comma
                "error"
            )
        }
    });
}
