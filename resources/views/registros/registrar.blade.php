@extends('layouts.master')

@push('css')
<link rel="stylesheet" href="{{asset('css/custom.css') }}">
@endpush

@section('title', 'Registrar intenção')

@section('content')
<form action="{{ route('sigea.registros.update', $aluno->id) }}" method="POST" class="form">
    {{ csrf_field() }}
    {{ method_field("PUT") }}
    <div class="form-group">
        <h3>Estudante: {{ $aluno->nomeFormatado . ' - ' . $aluno->matricula . ' - ' . $aluno->curso->nome }}</h3>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="situacao">Situação do estudante:</label>
                <select name='situacao' class='form-control selectpicker' title="Selecione a situação do estudante" data-style="{{ $errors->has('situacao') ? 'btn-danger' : 'btn-info' }}">
                    <option value="1" {{ old('situacao') == 1 ? 'selected': '' }}>Dependência</option>
                    <option value="2" {{ old('situacao') == 2 ? 'selected': '' }}>Retido</option>
                    <option value="3" {{ old('situacao') == 2 ? 'selected': '' }}>Regular</option>
                </select>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="semestre">Semestre de rematrícula:</label>
                <select name='semestre' class='form-control selectpicker' data-style="{{ $errors->has('semestre') ? 'btn-danger' : 'btn-info' }}">
                    <option value="20191">2019/1</option>
                    <option value="20182" disabled>2018/2</option>
                    <option value="20181" disabled>2018/1</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($disciplinas as $semestre)
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="form-group{{ $errors->has('disciplinas') ? ' has-error' : '' }} border">
                <h4 class="{{ $errors->has('disciplinas') ? 'bg-danger' : '' }}">{{$semestre[0]->semestre}}º semestre</h4>
                @foreach ($semestre as $disciplina)
                <label>
                    <input type="checkbox" name="disciplinas[]" value="{{$disciplina->id}}"
                        @if(old('disciplinas') != null) {{ in_array($disciplina->id, old('disciplinas')) ? 'checked' : '' }} @endif> {{$disciplina->nomeFormatado}}
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
@endsection

