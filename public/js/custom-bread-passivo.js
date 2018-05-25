var $table = $('#table');

function dangerStyle(value, row, index, field) {
    if (value === "Não atualizado") {
        return {
            classes: "danger",
        };
    }else{
        return {};
    }
}

function trueOrFalseFormatter(value, row, index){
    if (value) {
        return 'Atualizado';
    }else{
        return 'Não atualizado';
    }
}

async function message(value, row, index){
    formValues = await getInputs(value, row, index);

    if (formValues) {
        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
        })

        swalWithBootstrapButtons({
            title: 'Você deseja salvar as alterações?',
            // text: "Você deseja salvar as alterações?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, eu quero!',
            cancelButtonText: 'Não, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "PUT",
                    url: "/admin/passivo/" + $id,
                    data: {
                        'id': formValues.id,
                        'nome': formValues.nome,
                        'curso': formValues.curso,
                        'atualizacao_nome': formValues.atualizacao_nome,
                        'siga': formValues.siga,
                        'sistec': formValues.sistec,
                        'observacao': formValues.observacao
                    },
                    cache: false,
                    success: function(response) {
                        if (!response.error) {
                            $table.bootstrapTable('refresh', {silent: true});
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
            } else if ( result.dismiss === swal.DismissReason.cancel) {
                swalWithBootstrapButtons(
                    'Cancelado!',
                    'As alterações foram descartadas!',
                    'error'
                )
            }
        })
    }
}

async function getInputs(value, row, index){
    $id = row.id;
    $nome = row.nome;
    $curso = row.curso;
    if (row.atualizacao_nome) {
        $at_nome = 'checked';
    }else{
        $at_nome = '';
    }
    if (row.siga) {
        $siga = 'checked';
    }else{
        $siga = '';
    }
    if (row.sistec) {
        $sistec = 'checked';
    }else{
        $sistec = '';
    }
    if (row.observacao == null) {
        $observacao = '';
    }else{
        $observacao = row.observacao;
    }


    const {value: formValues} = await swal({
        title: 'Editar registro',
        html:
        '<label for="nome">Nome</label>' +
        '<input id="swal-input-nome" class="swal2-input" value="' + $nome + '">' +
        '<label for="nome">Curso</label>' +
        '<input id="swal-input-curso" class="swal2-input" value="' + $curso + '">' +
        '<label for="nome">Atualização de nome</label> ' +
        '<input type="checkbox" id="swal-input-at_nome" class="" ' + $at_nome + '><br />' +
        '<label for="nome">SIGA</label> ' +
        '<input type="checkbox" id="swal-input-siga" class="" ' + $siga + '><br />' +
        '<label for="nome">SISTEC</label> ' +
        '<input type="checkbox" id="swal-input-sistec" class="" ' + $sistec + '><br />' +
        '<label for="nome">Observação</label> ' +
        '<input id="swal-input-observacao" class="swal2-input" value="' + $observacao + '">',
        focusConfirm: false,
        preConfirm: () => {
            if ($('#swal-input-at_nome').is(':checked')) {
                atualizacao_nome = 1;
            }else{
                atualizacao_nome = 0;
            }
            if ($('#swal-input-siga').is(':checked')) {
                siga = 1;
            }else{
                siga = 0;
            }
            if ($('#swal-input-sistec').is(':checked')) {
                sistec = 1;
            }else{
                sistec = 0;
            }
            return {
                nome: $('#swal-input-nome').val(),
                curso: $('#swal-input-curso').val(),
                atualizacao_nome: atualizacao_nome,
                siga: siga,
                sistec: sistec,
                observacao: $('#swal-input-observacao').val(),
            }
        }
    })
    return formValues;
}

function operateFormatter(value, row, index) {
    return [
        '<a rel="tooltip" title="Edit" class="btn btn-link btn-warning table-action edit" href="javascript:void(0)">',
        '<i class="fa fa-edit"></i>',
        '</a>',
        '<a rel="tooltip" title="Remove" class="btn btn-link btn-danger table-action remove" href="javascript:void(0)">',
        '<i class="fa fa-remove"></i>',
        '</a>'
    ].join('');
}

$().ready(function() {
    window.operateEvents = {
        'click .edit': function(e, value, row, index) {
            message(value, row, index);
        },
        'click .remove': function(e, value, row, index) {
            console.log(row);
            $table.bootstrapTable('remove', {
                field: 'id',
                values: [row.id]
            });
        }
    };
    $table.bootstrapTable({
        toolbar: ".toolbar",
        clickToSelect: false,
        showRefresh: true,
        search: true,
        showToggle: true,
        showColumns: true,
        pagination: true,
        searchAlign: 'left',
        pageSize: 10,
        pageList: [8, 10, 25, 50, 100],
        icons: {
                refresh: 'fa fa-refresh',
                toggle: 'fa fa-th-list',
                columns: 'fa fa-columns',
                detailOpen: 'fa fa-plus-circle',
                detailClose: 'fa fa-minus-circle'
            }
    });

    $(window).resize(function() {
        $table.bootstrapTable('resetView');
    });
});
