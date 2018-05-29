@extends('layouts.master')
@section('title', 'Mensagens')

@push('css')
<link rel="stylesheet" href="{{ asset('/css/mensagem-css.css') }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card strpied-tabled-with-hover">
            <div class="card-header ">
                <h4 class="card-title">Caixa de saída</h4>
                <p class="card-category">Mensagens</p>
            </div>
            <div class="card-body table-full-width table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>Para</th>
                        <th>Título</th>
                        <th>Mensagem</th>
                        <th>Enviada em</th>
                        <th>Ações</th>
                    </thead>
                    <tbody>
                    @foreach ($mensagens as $mensagem)
                        <tr @if ($mensagem->read) class="success" @endif data-id="{{ $mensagem->id }}">
                            <td>{{ $mensagem->messageTo->name }}</td>
                            <td>{{ $mensagem->titulo }}</td>
                            <td>{{ $mensagem->mensagem }}</td>
                            <td>{{ $mensagem->created_at }}</td>
                            <td>
                                <a rel="tooltip" title="Ler" class="btn btn-link btn-info" href="{{ route('sigea.mensagens.show', $mensagem->id) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$mensagens->links()}}
            </div>
        </div>
    </div>
</div>
@include('mensagem.partials.fab')
@endsection

@push('script')
<script src="{{ asset('/js/mensagem-js.js') }}"></script>
@endpush
