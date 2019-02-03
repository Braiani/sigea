@extends('layouts.master')

@section('title', 'Rematrículas realizadas')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-10">
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
                                    @foreach($situacoes as $situacao)
                                        <option value="{{ $situacao->situacoes->id }}">{{ $situacao->situacoes->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="curso">Curso:</label>
                                <select name="curso" id="curso" class="form-control select2">
                                    <option value=""></option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->curso->id }}">{{ $curso->curso->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Relatório</h4>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <a href="{{ route('sigea.coordenacao.relatorio') }}" class="btn btn-primary">Gerar relatório</a>
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
                               data-url="{{ route('sigea.coordenacao.table') }}"
                               data-query-params="queryParams"
                               data-height="600"
                               data-side-pagination="server"
                               data-row-style="colorStyle"
                               data-locale="pt-BR">
                            <thead>
                            <tr>
                                <th data-field="nome"
                                    data-sortable="true"
                                >Nome estudante
                                </th>
                                <th data-field="matricula" data-sortable="true">Matrícula</th>
                                <th data-field="curso"
                                    data-sortable="true"
                                    data-formatter="cursoFormatter"
                                >Curso
                                </th>
                                <th data-field="CR"
                                    data-align="center"
                                    data-sortable="true"
                                    data-formatter="crFormatter"
                                >CR
                                </th>
                                <th data-field="registros"
                                    data-sortable="false"
                                    data-formatter="situacaoFormatter"
                                >Situação
                                </th>
                                <th data-field="registros" data-formatter="avaliadoFormatter">Avaliado?</th>
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
                '<a rel="tooltip" title="Visualizar" class="btn btn-link btn-primary table-action" target="_Blank" href="{{ route('sigea.coordenacao.index') }}/' + row.id + '">',
                '<i class="fa fa-eye"></i>',
                '</a>',
            ].join('');
        };

        function cursoFormatter(value, row, index) {
            if (value != null) {
                return value.nome;
            } else {
                return '-';
            }
        }

        function crFormatter(value) {
            return value.toFixed(4);
        }

        function situacaoFormatter(value) {
            if (value != null) {
                var resposta;
                var semestre;
                if ($("#semestre").val() != '') {
                    semestre = $("#semestre").val();
                } else {
                    semestre = '20191';
                }
                $.each(value, function (index, valor) {
                    if (valor.semestre == semestre) {
                        resposta = valor.situacoes.nome;
                    }
                });
                return resposta;
            } else {
                return '-';
            }
        }

        function avaliadoFormatter(value) {
            var avaliado = true;
            var semestre;
            if ($("#semestre").val() != '') {
                semestre = $("#semestre").val();
            } else {
                semestre = '20191';
            }
            $.each(value, function (index, valor) {
                if (valor.semestre == semestre && valor.avaliacao === 0) {
                    avaliado = false;
                }
            });

            if (avaliado) {
                return 'Avaliado';
            } else {
                return 'Pendente';
            }
        }

        function colorStyle(row) {
            if (avaliadoFormatter(row.registros) == 'Avaliado') {
                return {
                    classes: 'success'
                }
            }
            return {};
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

            $('#curso').on('change', function () {
                $table.bootstrapTable('refresh');
            });

            $(window).resize(function () {
                $table.bootstrapTable('resetView');
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
        });
    </script>
@endpush
