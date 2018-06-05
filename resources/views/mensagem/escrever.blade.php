@extends('layouts.master')
@section('title', 'Escrever Mensagem')

@push('css')
<link rel="stylesheet" href="{{ asset('/css/mensagem-css.css') }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form id="formMail" action="{{ route('sigea.mensagens.store') }}" method="post">
                {{ csrf_field() }}
                <div class="card-header">
                    <h4 class="card-title">Escrever mensagem</h4>
                    <p class="card-category">Mensagens</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label">De: </label>
                        <p class="form-control-static">
                            {{ Auth::user()->name }}
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="to">Destinatário</label>
                        <select id="to" name="to" class="selectpicker" data-title="Selecione o destinatário" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                            @foreach ($usuarios as $usuario)
                                @if (($usuario->id !== Auth::id() and $usuario->id !== 1) or Auth::user()->isAdmin)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="titulo">Assunto</label>
                        <input id="titulo" type="text" class="form-control" name="titulo" placeholder="Título" />
                    </div>
                    <div class="form-group">
                        <label for="mensagem">Mensagem</label>
                        <textarea id="mensagem" class="form-control" rows="10" name="mensagem"></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <button id="btnEnviar" class="btn btn-success btn-lg"><i class="material-icons">send</i> Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('mensagem.partials.fab')
@endsection

@push('script')
<script src="{{ asset('/js/mensagem-js.js') }}"></script>
@endpush
