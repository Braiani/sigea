@extends('layouts.master')
@section('title', 'Configurações')

{{-- @push('css')
    <link rel="stylesheet" href="{{ asset('/css/image-picker.css') }}">
@endpush --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-10">
            <form class="form" method="POST" action="{{route('sigea.configuracoes.update')}}" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <div class="card ">
                    <div class="card-header ">
                        <div class="card-header">
                            <h4 class="card-title">Configurações</h4>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <label for="sidebar_color">Selecione uma cor para o menu lateral</label>
                                @php
                                    $selected_color = Auth::user()->settings;
                                    if (isset($selected_color['sidebar_color'])) {
                                        $color = $selected_color['sidebar_color'];
                                    }else {
                                        $color = 'black';
                                    }
                                @endphp
                                <select name="sidebar_color" class="selectpicker" data-title="Selecione uma cor"
                                        data-style="btn-default btn-outline" data-menu-style="dropdown-blue"
                                        id="select_sidebar_color">
                                        {{-- purple | blue | green | orange | red --}}
                                    <option {{ $color == 'black' ? 'selected' : '' }} value="black">Preto - Padrão</option>
                                    <option {{ $color == 'purple' ? 'selected' : '' }} value="purple">Roxo</option>
                                    <option {{ $color == 'blue' ? 'selected' : '' }} value="blue">Azul</option>
                                    <option {{ $color == 'green' ? 'selected' : '' }} value="green">Verde</option>
                                    <option {{ $color == 'orange' ? 'selected' : '' }} value="orange">Laranja</option>
                                    <option {{ $color == 'red' ? 'selected' : '' }} value="red">Vermelho</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Selecione uma imagem para o menu lateral</label>
                                    <select class="image-picker show-html">
                                        <option data-img-src="{{ asset('/img/sidebar-1.jpg') }}" value="1">  Page 1  </option>
                                        <option data-img-src="{{ asset('/img/sidebar-2.jpg') }}" value="2">  Page 2  </option>
                                        <option data-img-src="{{ asset('/img/sidebar-3.jpg') }}" value="3">  Page 3  </option>
                                        <option data-img-src="{{ asset('/img/sidebar-4.jpg') }}" value="3">  Page 3  </option>
                                        <option data-img-src="{{ asset('/img/sidebar-5.jpg') }}" value="12"> Page 12 </option>
                                    </select>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-1">
                                <div class="img-container">
                                    <img class="img_sidebar" src="{{ asset('/img/sidebar-1.jpg') }}" alt="">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="img-container">
                                    <img class="img_sidebar" src="{{ asset('/img/sidebar-2.jpg') }}" alt="">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="img-container">
                                    <img class="img_sidebar" src="{{ asset('/img/sidebar-3.jpg') }}" alt="">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="img-container">
                                    <img class="img_sidebar" src="{{ asset('/img/sidebar-4.jpg') }}" alt="">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="img-container">
                                    <img class="img_sidebar" src="{{ asset('/img/sidebar-5.jpg') }}" alt="">
                                </div>
                            </div> --}}
                        {{-- </div> --}}
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <button type="submit" class="btn btn-info btn-fill">Salvar configurações</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
{{-- <script src="{{ asset('/js/plugins/image-picker.min.js') }}"></script> --}}
<script>
    $(document).ready(function(){
        $('#select_sidebar_color').on('change', function(){
            $('.sidebar').attr('data-color', $(this).val());
        });

        // $('.img_sidebar').on('click', function(){
        //     $('.sidebar').attr('data-image', $(this).attr('src'));
        //     console.log($('.sidebar').data('image'));
        // });
        // $(".image-picker").imagepicker();

        // $('.img_sidebar').on('click', function(){
        //     // $full_page_background = $('.full-page-background');
        //     var new_image = $(this).attr('src');
        //     $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
        // });
    });
</script>
@endpush
