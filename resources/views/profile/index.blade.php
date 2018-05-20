@extends('layouts.master')
@section('title', 'Meu Perfil')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="card card-user">
                <div class="card-header no-padding">
                    <div class="card-image">
                        <img src="{{asset('/img/full-screen-image-3.jpg')}}" alt="Imagem bonita">
                    </div>
                </div>
                <div class="card-body ">
                    <div class="author">
                        <a href="#">
                            <img class="avatar border-gray" src="{{ Voyager::image(Auth::user()->avatar) }}" alt="{{Auth::user()->name}}">
                            <h5 class="card-title">{{ Auth::user()->name }}</h5>
                        </a>
                        <p class="card-description">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                    <p class="card-description text-center">
                        {{ Auth::user()->about }}
                    </p>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="button-container text-center">
                        <a href="{{route('sigea.profile.edit')}}" class="btn btn-simple btn-link btn-icon">
                            <i class="fa fa-edit"></i> Editar perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
