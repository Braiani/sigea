@extends('layouts.master')

@section('title', 'Registro realizado')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3>Foram encontrados os seguintes registros para o(a) estudante selecionado: {{ $aluno->nomeFormatado }}</h3>
        <div class="row">
            <div class="pull-right">
                <a href="{{ route('sigea.registros.editar', $aluno->id) }}" class="btn btn-success">+ Adicionar disciplina</a>
                <a href="{{ route('sigea.registros.comprovante', $aluno->id) }}" class="btn btn-info">Imprimir comprovante</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Disciplina</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registros as $registro)
                        <tr>
                            <td>{{ $registro->disciplinas->nomeFormatado }}</td>
                            <td>
                                @can('delete', $registro)
                                <form action="{{ route('sigea.registros.destroy', $registro->id) }}" class="form pull-right" method="POST">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger" type="submit">Apagar</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
