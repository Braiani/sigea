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
                        <th>CR</th>
                        <th data-sortable="true">Semestre</th>
                        <th>Disciplina</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($matricula->intentions as $registro)
                        @php
                            $class = '';
                            switch ($registro->pivot->avaliado_coord) {
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
                            <td>{{ $matricula->cr }}</td>
                            <td>{{ $registro->pivot->semestre }}</td>
                            <td>{{ $registro->nome }}</td>
                            <td>
                                @if ($registro->pivot->avaliado_coord)
                                    <form action="{{ route('sigea.coordenacao.rematricula.online.desfazer', [$matricula->id, $registro->id]) }}"
                                          class="form pull-right" method="POST">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <button class="btn btn-info" type="submit"><i class="fa fa-undo"></i>
                                            Desfazer
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('sigea.coordenacao.rematricula.online.recusar', [$matricula->id, $registro->id]) }}"
                                          class="form pull-right" method="POST">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <button class="btn btn-warning" type="submit"><i class="fa fa-close"></i>
                                            Recusar
                                        </button>
                                    </form>
                                    <form action="{{ route('sigea.coordenacao.rematricula.online.aceitar', [$matricula->id, $registro->id]) }}"
                                          class="form pull-right" method="POST">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <button class="btn btn-success" type="submit"><i class="fa fa-check"></i>
                                            Aceitar
                                        </button>
                                    </form>
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