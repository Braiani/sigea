@extends('layouts.master')
@section('title')
    {{ $mensagem->titulo}}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $mensagem->titulo }}</h4>
                <p class="card-category">Enviado por: {{$mensagem->from->name }}</p>
            </div>
            <div class="card-body">
                <p>{{$mensagem->mensagem }}</p>
            </div>
            <div class="card-footer">
                <hr>
                @php
                    $route = $mensagem->user_id == Auth::user()->id ? 'sigea.mensagens.saida' : 'sigea.mensagens.index';
                @endphp
                <a class="btn btn-info" id="btnVoltar"  href="{{ route($route) }}">Voltar</a>
                @if ($mensagem->user_id !== Auth::user()->id)
                <a class="btn btn-warning" id="btnUnread" href="{{ route('sigea.mensagens.unread', $mensagem->id) }}">Marcar como não lida</a>
                <a class="btn btn-danger" id="btnExcluir" href="{{ route('sigea.mensagens.destroy', $mensagem->id) }}">Excluir</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
