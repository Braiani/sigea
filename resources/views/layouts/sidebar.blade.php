@php
    $selected_color = Auth::user()->settings;
    if (isset($selected_color['sidebar_color'])) {
        $color = $selected_color['sidebar_color'];
    }else {
        $color = 'black';
    }
@endphp
<div class="sidebar" data-color="{{ $color }}" data-image="https://source.unsplash.com/collection/3156495/1920x1080/">
    <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
-->
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{route('sigea.dashboard')}}" class="simple-text logo-mini">
                SG
            </a>
            <a href="{{route('sigea.dashboard')}}" class="simple-text logo-normal">
                {{setting('site.title')}}
            </a>
        </div>
        <div class="user">
            <div class="photo">
                <img src="{{Voyager::image(Auth::user()->avatar)}}" />
            </div>
            <div class="info ">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>{{Auth::user()->name}}
                        <b class="caret"></b>
                    </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a class="profile-dropdown" href="{{route('sigea.profile.index')}}">
                                <span class="sidebar-mini">MP</span>
                                <span class="sidebar-normal">Meu Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a class="profile-dropdown" href="{{route('sigea.profile.edit')}}">
                                <span class="sidebar-mini">EP</span>
                                <span class="sidebar-normal">Editar Perfil</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {!! menu('sidebar', 'layouts.custom-menu-side') !!}
    </div>
</div>
