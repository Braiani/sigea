@extends('layouts.master')

@section('title')
    Solicitação de {{ $matricula->student->name }}
@endsection

@section('content')
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
                        <th data-sortable="true">Semestre</th>
                        <th>Disciplina</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($matricula->intentions as $registro)
                        @php
                            $class = '';
                            switch ($registro->pivot->avaliado_cerel) {
                                case '1':
                                    $class = '';
                                    break;
                                case '0':
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
                                @if ($registro->pivot->avaliacao)
                                    Avaliado!
                                @else
                                    Não avaliado!
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
                pageSize: 10,
                pageList: [8, 10, 25, 50, 100],
            });
        });
    </script>
@endpush