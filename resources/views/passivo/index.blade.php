@extends('layouts.master')
@section('title', 'Passivo')

@section('content')
<div class="row">
    <div class="col-sm-4">
        <a href="{{ route('sigea.passivo.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Cadastrar pasta no passivo</a>
    </div>
    <div class="col-md-12">
        <div class="card bootstrap-table">
            <div class="card-body table-full-width">
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <table id="table"
                    class="table table-striped"
                    data-url="{{ route('sigea.passivo.table') }}"
                    data-height="600"
                    data-side-pagination="server"
                    data-locale="pt-BR">
                    <thead>
                        <tr>
                            {{-- <th data-field="state" data-checkbox="true"></th> --}}
                            <th data-field="id" data-align="center">Nº Pasta</th>
                            <th data-field="nome"
                                data-sortable="true">Nome</th>
                            <th data-field="curso"
                                data-sortable="true">Curso</th>
                            <th data-field="atualizacao_nome"
                                data-formatter="trueOrFalseFormatter"
                                data-cell-style="dangerStyle"
                                data-align="center"
                                data-sortable="true">Atualizado nome?</th>
                            <th data-field="siga"
                                data-formatter="trueOrFalseFormatter"
                                data-cell-style="dangerStyle"
                                data-align="center"
                                data-sortable="true">SIGA</th>
                            <th data-field="sistec"
                                data-formatter="trueOrFalseFormatter"
                                data-cell-style="dangerStyle"
                                data-align="center"
                                data-sortable="true">SISTEC</th>
                            <th data-field="observacao">Observação</th>
                            <th data-field="actions" class="td-actions text-right" data-events="operateEvents" data-formatter="operateFormatter">Ações</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
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

    function operateFormatter(value, row, index) {
        return [
            '<a rel="tooltip" title="Edit" class="btn btn-link btn-warning table-action edit" href="javascript:void(0)">',
            '<i class="fa fa-edit"></i>',
            '</a>',
            @can('delete', $passivo_model)
            '<a rel="tooltip" title="Remove" class="btn btn-link btn-danger table-action remove" href="javascript:void(0)">',
            '<i class="fa fa-remove"></i>',
            '</a>'
            @endcan
        ].join('');
    }

    $().ready(function() {
        window.operateEvents = {
            'click .edit': function(e, value, row, index) {
                info = JSON.stringify(row);

                swal('You click edit icon, row: ', info);
                console.log(info);
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
</script>
@endpush
