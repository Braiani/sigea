@extends('layouts.master')
@section('title', 'Editar Perfil')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-6">
            <form class="form" method="POST" action="{{route('sigea.profile.update')}}" enctype="multipart/form-data" >
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card ">
                    <div class="card-header ">
                        <div class="card-header">
                            <h4 class="card-title">Editar Perfil</h4>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <div class="form-group">
                                    <label>Setor</label>
                                    <input type="text" class="form-control" disabled="" placeholder="Company" value="CEREL - Campus Campo Grande">
                                </div>
                            </div>
                            <div class="col-md-6 pl-1">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" name="email" class="form-control" placeholder="E-mail" value="{{ Auth::user()->email }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Senha</label>
                                    <input type="password" name="password" class="form-control" placeholder="Deixe em branco caso não queira trocar">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-4 pr-1">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" placeholder="City" value="Mike">
                                </div>
                            </div>
                            <div class="col-md-4 px-1">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" placeholder="Country" value="Andrew">
                                </div>
                            </div>
                            <div class="col-md-4 pl-1">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="number" class="form-control" placeholder="ZIP Code">
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sobre</label>
                                    <input name="about" type="text" class="form-control" placeholder="Aqui você pode contar um pouco de você" value="{{ Auth::user()->about }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info btn-fill pull-right">Atualizar Perfil</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="card-header no-padding">
                        <div class="card-image">
                            <img src="https://source.unsplash.com/collection/3156495/640x480/" alt="...">
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="author">
                            <img class="avatar border-gray" src="{{Voyager::image(Auth::user()->avatar)}}" alt="...">
                            <input type="file" data-name="avatar" name="avatar">
                            <p class="card-description"><br></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <iframe id="form_target" name="form_target" style="display:none"></iframe>
    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
        {{ csrf_field() }}
        <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
        <input type="hidden" name="type_slug" id="type_slug" value="users">
    </form>
</div>
@endsection
