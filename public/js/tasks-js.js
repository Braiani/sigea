async function addTask(url, urlGetUsers){
    await swal({
        title: 'Registrar Tarefa',
        html:
        '<div class="card stacked-form">' +
            '<div class="card-body ">' +
                '<div class="form-group">' +
                    '<label>Para</label>' +
                    '<select name="user_to" id="user_to" class="form-control">' +
                        '<option value="X">Carregando...</option>' +
                    '</select>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label>Tarefa</label>' +
                    '<input placeholder="Tarefa" name="task" class="form-control" type="text">' +
                '</div>' +
                '<div class="form-group">' +
                    '<label>Data limite</label>' +
                    '<input placeholder="Data Limite" id="datepicker" name="deadline" class="form-control" type="date">' +
                '</div>' +
            '</div>' +
        '</div>',
        focusConfirm: false,
        onOpen: function() {
            getUsers('GET', urlGetUsers);
        },
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return {
                user_to: $('select[name=user_to]').val(),
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

function getUsers(type, url){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: type,
        url: url,
        cache: false,
        success: function(response) {
            if (!response.error) {
                $('select option[value="X"]').remove();
                $.each(response, function(index, itemData) {
                    $('select').append($('<option>', {
                        value: itemData.id,
                        text: itemData.nome
                    }));
                });
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
