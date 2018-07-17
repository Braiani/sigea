@extends('layouts.master')

@section('title')
Solicitação de {{ $aluno->nome }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3>Foram encontrados os seguintes registros para o(a) estudante selecionado: {{ $aluno->nomeFormatado }}</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Estudante</th>
                        <th>CR</th>
                        <th>Disciplina</th>
                        <th>Responsável rematrícula</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aluno->registros as $registro)
                    @php
                        $class = '';
                        switch ($registro->avaliacao) {
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
                            <td>{{ $aluno->nomeFormatado }}</td>
                            <td>{{ $aluno->CRFormatado }}</td>
                            <td>{{ $registro->disciplinas->nomeFormatado }}</td>
                            <td>{{ $registro->user->name }}</td>
                            <td>
                                @if ($registro->avaliacao)
                                @can('desfazer', $registro)
                                <form action="{{ route('sigea.coordenacao.desfazer', [$aluno->id, $registro->id]) }}" class="form pull-right" method="POST">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}
                                    <button class="btn btn-info" type="submit"><i class="fa fa-undo"></i> Desfazer</button>
                                </form>
                                @endcan
                                @else
                                @can('recusar', $registro)
                                <form action="{{ route('sigea.coordenacao.recusar', [$aluno->id, $registro->id]) }}" class="form pull-right" method="POST">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}
                                    <button class="btn btn-warning" type="submit"><i class="fa fa-close"></i> Recusar</button>
                                </form>
                                @endcan
                                @can('aceitar', $registro)
                                <form action="{{ route('sigea.coordenacao.aceitar', [$aluno->id, $registro->id]) }}" class="form pull-right" method="POST">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}
                                    <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Aceitar</button>
                                </form>
                                @endcan
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
