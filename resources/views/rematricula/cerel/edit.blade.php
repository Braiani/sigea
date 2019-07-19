@extends('layouts.master')

@section('title')
    Solicitação de {{ $matricula->student->name }}
@endsection

@section('content')
    @if($matricula->intentions->first()->pivot->avaliado_cerel)
        <div class="row">
            <div class="col-sm-12">
                <div class="card bg-danger">
                    <div class="card-header mb-4 bg-info">
                        <h3 class="text-center">Estudante já avaliado!</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Foram encontrados os seguintes registros para o(a) estudante: {{ $matricula->student->name }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('sigea.rematricula.update', $matricula->id) }}" id="form-rematricula">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @foreach($integralizacao as $semestre => $disciplinas)
                                <div class="col-md-6">
                                    <div class="form-group border">
                                        <h4 class="text-center">{{ $semestre }}º Semestre</h4>
                                        <table class="table table-striped table-responsive table-condensed">
                                            <thead>
                                            <tr>
                                                <th>Disciplina</th>
                                                <th>CH</th>
                                                <th class="text-center">Situação</th>
                                                <th class="text-center">Solicitada?</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($disciplinas as $disciplina)
                                                <tr>
                                                    <td>{{ trim(strtoupper(str_replace('*', '', $disciplina['uc_nome']))) }}</td>
                                                    <td class="text-center">{{ $disciplina['carga_horaria'] }}</td>
                                                    <td class="text-center">{{ $disciplina['situacao'] }}</td>
                                                    <td class="text-center">
                                                        @if($disciplina['situacao'] !== "Cursada")
                                                            @foreach($matricula->intentions as $registro)

                                                                @if(strcmp(trim(mb_strtolower(str_replace('*', '', $disciplina['uc_nome']))), trim(mb_strtolower($registro->nome))) == 0)
                                                                    @if($disciplina['situacao'] === "Não cursada")
                                                                        Sim
                                                                        @if(!$registro->pivot->avaliacao_coord && !$registro->pivot->avaliado_cerel)
                                                                            <a href="{{ route('sigea.rematricula.update.dp', [$matricula->id, $registro->id]) }}">É DP?</a>
                                                                        @endif
                                                                    @else
                                                                        Sim
                                                                    @endif
                                                                    @break
                                                                @elseif($loop->last)
                                                                    Não
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            @if(!$matricula->intentions->first()->pivot->avaliado_cerel)
                                <button type="submit" class="btn btn-success" form="form-rematricula">Registrar avaliação</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        $(document).on('pageReady', function () {
            $(".form").on('submit', function (e) {

            })
        });
    </script>
@endpush