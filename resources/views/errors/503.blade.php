@extends('errors.layout')

@section('title', 'Em Manutenção')

@section('message')
    @if($exception->getMessage() !== "")
        <h1>{{ $exception->getMessage() }}<br></h1>
        <p>Retornaremos as: {{$exception->willBeAvailableAt->format('h:i:s')}}</p>
    @else
        <h1>Em manutenção! <br></h1>
        <p>Retornaremos em breve!</p>
    @endif
@endsection
