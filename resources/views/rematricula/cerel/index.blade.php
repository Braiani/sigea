@extends('layouts.master')

@section('title', 'Rematrículas realizadas Online')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="cad-title text-center">Filtros</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="semestre">Semestre:</label>
                                <select name="semestre" id="semestre" class="form-control select2">
                                    <option value=""></option>
                                    @foreach($semestres as $semestre)
                                        <option value="{{ $semestre->semestre }}">{{ $semestre->semestre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="situacao">Situação:</label>
                                <select name="situacao" id="situacao" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="curso">Curso:</label>
                                <select name="curso" id="curso" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card bootstrap-table">
                <div class="card-body table-full-width">
                    <div class="col-sm-12">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <table id="table"
                               class="table table-striped"
                               data-url="{{ route('sigea.rematricula.table', Request::query()) }}"
                               data-query-params="queryParams"
                               data-side-pagination="server"
                               data-row-style="colorStyle"
                               data-locale="pt-BR">
                            <thead>
                            <tr>
                                <th data-field="student"
                                    data-formatter="studentFormatter"
                                    {{--data-sortable="true"--}}
                                >Estudante
                                </th>
                                <th data-field="id" data-sortable="true">Matrícula</th>
                                <th data-field="course"
                                    data-sortable="true"
                                    data-formatter="cursoFormatter"
                                >Curso
                                </th>
                                <th data-field="actions" class="td-actions text-right" data-events="operateEvents"
                                    data-formatter="operateFormatter">Ações
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/pt-BR.js"></script>
    <script>
        function operateFormatter(value, row, index) {
            return [
                '<a rel="tooltip" title="Visualizar" class="btn btn-link btn-primary table-action" target="_Blank" href="{{ route('sigea.rematricula.index') }}/' + row.id + '">',
                '<i class="fa fa-eye"></i>',
                '</a>',
            ].join('');
        }

        function colorStyle(row) {
            if (row.intentions[0].pivot.avaliado_cerel) {
                return {
                    classes: 'success'
                }
            }
            return {}
        }

        function studentFormatter(value) {
            return value.name;
        }

        function cursoFormatter(value) {
            return value.nome;
        }

        function queryParams(params) {
            if ($("#semestre").val() !== '') {
                params.semestre = $("#semestre").val();
            }
            if ($("#situacao").val() !== '') {
                params.situacao = $("#situacao").val();
            }
            if ($("#curso").val() !== '') {
                params.curso = $("#curso").val();
            }
            return params;
        }

        $(document).on('pageReady', function () {
            var $table = $('#table');


            window.operateEvents = {
                'click .ver': function (e, value, row, index) {
                    console.log(row);
                }
            };
            $table.bootstrapTable({
                toolbar: ".toolbar",
                clickToSelect: false,
                showRefresh: true,
                search: false, // Desabilitado por enquanto
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

            $('#curso').on('change', function () {
                $table.bootstrapTable('refresh');
            });

            $(window).resize(function () {
                $table.bootstrapTable('resetView');
            });

            window.addEventListener('focus', function () {
                $table.bootstrapTable('refresh');
            });

            $("#semestre").select2({
                placeholder: "Selecione o semestre",
                allowClear: true
            });
            $("#situacao").select2({
                placeholder: "Selecione a situação",
                allowClear: true
            });
            $("#curso").select2({
                placeholder: "Selecione o curso",
                allowClear: true
            });

            $("#semestre").on('change', function () {
                $table.bootstrapTable('refresh');
            });
            $("#situacao").on('change', function () {
                $table.bootstrapTable('refresh');
            });
            $('#relatorio').select2({
                width: '100%',
                placeholder: 'Seleciono o relatório',
                dropdownParent: $('#relatorioModal')
            });
        });
    </script>
@endpush
