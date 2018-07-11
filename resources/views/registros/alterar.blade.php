@extends('layouts.master')

@section('title', 'Registro de intenção')

@section('content')
<div class="row">
    <div class="col-sm-10">
        <form action="{{ route('sigea.registros.salvarUpdate', $aluno->id) }}" method="POST" class="form">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <h3>Estudante: {{ $aluno->nomeFormatado . ' - ' . $aluno->matricula . ' - ' . $aluno->curso->nome }}</h3>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="situacao">Situação do estudante:</label>
                        <select name='situacao' class='form-control selectpicker' title="Selecione a situação do estudante" data-style="{{ $errors->has('situacao') ? 'btn-danger' : 'btn-info' }}">
                            <option></option>
                            <option value="1" {{ $registros[0]->situacao == 1 ? 'selected': '' }}>Dependência</option>
                            <option value="2" {{ $registros[0]->situacao == 2 ? 'selected': '' }}>Retido</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="semestre">Semestre de rematrícula:</label>
                        <select name='semestre' class='form-control selectpicker' data-style="{{ $errors->has('semestre') ? 'btn-danger' : 'btn-info' }}">
                            <option value="20181">2018/1</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($disciplinas as $semestre)
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group{{ $errors->has('disciplinas') ? ' has-error' : '' }} border">
                        <h4>{{$semestre[0]->semestre}}º semestre</h4>
                        @foreach ($semestre as $disciplina)
                        <label>
                            <input type="checkbox" name="disciplinas[]"
                                value="{{ $disciplina->id }}" {{ $registros->contains('id_disciplina_cursos', $disciplina->id) ? 'checked' : '' }}> {{$disciplina->nomeFormatado}}
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-info">Salvar registro</button>
            </div>
        </form>
    </div>
    <div class="col-sm-2">
        <div class="alert alert-info fixed-message">
            <p><b>Disciplinas já cadastradas:</b></p>
            @foreach ($registros as $registro)
                <p>{{$registro->disciplinas->nomeFormatado}}</p>
            @endforeach
        </div>
    </div>
</div>
@endsection
