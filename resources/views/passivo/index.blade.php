@extends('layouts.master')
@section('title', 'Passivo')

@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

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
                                data-sortable="true"
                                {{-- data-events="operateEvents" data-formatter="operateFormatter" --}}
                                >Nome</th>
                            <th data-field="curso"
                                data-sortable="true"
                                {{-- data-events="operateEvents" data-formatter="operateFormatter" --}}
                                >Curso</th>
                            <th data-field="atualizacao_nome"
                                data-formatter="trueOrFalseFormatter"
                                data-cell-style="dangerStyle"
                                data-align="center"
                                data-sortable="true"
                                {{-- data-events="operateEvents" data-formatter="operateFormatter" --}}
                                >Atualizado nome?</th>
                            <th data-field="siga"
                                data-formatter="trueOrFalseFormatter"
                                data-cell-style="dangerStyle"
                                data-align="center"
                                data-sortable="true"
                                {{-- data-events="operateEvents" data-formatter="operateFormatter" --}}
                                >SIGA</th>
                            <th data-field="sistec"
                                data-formatter="trueOrFalseFormatter"
                                data-cell-style="dangerStyle"
                                data-align="center"
                                data-sortable="true"
                                {{-- data-events="operateEvents" data-formatter="operateFormatter" --}}
                                >SISTEC</th>
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
<script src="{{asset('/js/custom-bread-passivo.js')}}"></script>
@endpush
