@extends('layouts.master')

@section('title', 'Rematrículas realizadas')

@push('css')
{{-- <link href="{{asset('/css/ajax-bootstrap-select.css')}}" rel="stylesheet" /> --}}
@endpush

@section('content')
<div class="row">
    <div class="col-sm-10 col-md-12">
        <div class="card bootstrap-table">
            <div class="card-body table-full-width">
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <table id="table"
                    class="table table-striped"
                    data-url="{{ route('sigea.coordenacao.table') }}"
                    data-height="600"
                    data-side-pagination="server"
                    data-locale="pt-BR">
                    <thead>
                        <tr>
                            <th data-field="nome"
                                data-sortable="true"
                                {{-- data-events="operateEvents" data-formatter="operateFormatter" --}}
                                >Nome estudante</th>
                            <th data-field="curso"
                                data-sortable="true"
                                {{-- data-formatter="cursoFormatter" --}}
                                >Curso</th>
                            <th data-field="cr"
                                data-align="center"
                                data-sortable="true"
                                {{-- data-events="operateEvents" data-formatter="operateFormatter" --}}
                                >CR</th>
                            <th data-field="situacao" data-sortable="false">Situação</th>
                            <th data-field="avaliacao">Avaliado?</th>
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
    function operateFormatter(value, row, index) {
        return [
            '<a rel="tooltip" title="Visualizar" class="btn btn-link btn-primary table-action" target="_Blank" href="{{ route('sigea.coordenacao.index') }}/' + row.id + '">',
                '<i class="fa fa-eye"></i>',
            '</a>',
        ].join('');
    };

    $(document).ready(function() {
        var $table = $('#table');


        window.operateEvents = {
            'click .ver': function(e, value, row, index) {
                console.log(row);
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

        $('#curso').on('change', function(){

            console.log($table.attr('data-url'));
            $table.bootstrapTable('refresh');
        })

        $(window).resize(function() {
            $table.bootstrapTable('resetView');
        });
    });
</script>
@endpush
