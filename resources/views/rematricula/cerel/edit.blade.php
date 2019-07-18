@extends('layouts.master')

@section('title')
    Solicitação de {{ $matricula->student->name }}
@endsection

@section('content')
    {{ dd($integralizacao) }}
    <div class="row">
        <div class="col-md-12">
            <h3>Foram encontrados os seguintes registros para o(a) estudante
                selecionado: {{ $matricula->student->name }}</h3>
            <div class="table-responsive">
                <table id="table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Estudante</th>
                        <th>E-mail</th>
                        <th>Semestre</th>
                        <th data-sortable="true">Disciplina</th>
                        <th>Situação</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($matricula->intentions as $registro)
                        @php
                            $class = '';
                            switch ($registro->pivot->avaliado_cerel) {
                                case '0':
                                    $class = '';
                                    break;
                                case '1':
                                    $class = 'success';
                                    break;
                                case '2':
                                    $class = 'danger';
                                    break;
                                default:
                                    $class = '';
                                    break;
                            }
                        @endphp
                        <tr class="{{ $class }}">
                            <td>{{ $matricula->student->name }}</td>
                            <td>{{ $matricula->student->email }}</td>
                            <td>{{ $registro->pivot->semestre }}</td>
                            <td>{{ $registro->nome }}</td>
                            <td>
                                @if ($registro->pivot->avaliado_cerel)
                                    Avaliado!
                                @else
                                    Não avaliado!
                                @endif
                            </td>
                            <td>
                                @if($registro->pivot->avaliado_cerel)
                                    <a href="#" class="btn btn-primary">Desfazer</a>
                                @else
                                    <a href="#" class="btn btn-success">Aceitar</a>
                                    <a href="#" class="btn btn-warning">Rejeitar</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).on('pageReady', function () {
            $('#table').bootstrapTable({
                toolbar: ".toolbar",
                clickToSelect: false,
                search: true,
                pagination: true,
                searchAlign: 'left',
                pageSize: 15,
                pageList: [8, 10, 25, 50, 100],
            });
        });
    </script>
@endpush