<nav class="navbar navbar-expand-lg ">
	<div class="container-fluid">
		<div class="navbar-wrapper">
			<div class="navbar-minimize">
				<button id="minimizeSidebar" class="btn btn-info btn-fill btn-round btn-icon d-none d-lg-block">
					<i class="fa fa-ellipsis-v visible-on-sidebar-regular"></i>
					<i class="fa fa-navicon visible-on-sidebar-mini"></i>
				</button>
			</div>
			<a class="navbar-brand" href="{{ route('sigea.dashboard')}}"> {{ setting('site.title') }} </a>
		</div>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-bar burger-lines"></span>
			<span class="navbar-toggler-bar burger-lines"></span>
			<span class="navbar-toggler-bar burger-lines"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end">
			@php
				$notifi = new App\Classes\Notificacoes;
				$notificacoes = $notifi->handle(Auth::user()->id);
			@endphp
			<ul class="nav navbar-nav mr-auto">
				<li class="dropdown nav-item">
					<a href="#" class="{{ (isset($notificacoes) and $notificacoes['total'] > 0) ? 'dropdown-toggle' : '' }} nav-link"
						@if(isset($notificacoes) and $notificacoes['total'] > 0) data-toggle="dropdown" @endif>
						<i class="nc-icon nc-bell-55"></i>
						@if(isset($notificacoes) and $notificacoes['total'] > 0)
						<span class="notification">{{ $notificacoes['total'] }}</span>
						@endif
						<span class="d-lg-none">Notificações</span>
					</a>
					<ul class="dropdown-menu">
						@if(isset($notificacoes) and $notificacoes['total'] > 0)
						@foreach ($notificacoes['not_cont'] as $notificacao)
						<a class="dropdown-item" href="{{ route($notificacao['link']) }}">{{ $notificacao['mensagem'] }}</a>
						@endforeach
						@endif
					</ul>
				</li>
				{{-- <form class="navbar-form navbar-left navbar-search-form" role="search">
					<div class="input-group">
						<i class="nc-icon nc-zoom-split"></i>
						<input type="text" value="" class="form-control" id="pesquisar" placeholder="Procurar...">
					</div>
				</form> --}}
			</ul>
			<ul class="navbar-nav">
				{{--<li class="dropdown nav-item">
					<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
						<i class="nc-icon nc-planet"></i>
					</a>
					<ul class="dropdown-menu">
						<a class="dropdown-item" href="#">Manage Something</a>
						<a class="dropdown-item" href="#">Do Nothing</a>
						<a class="dropdown-item" href="#">Submit to live</a>
						<li class="divider"></li>
						<a class="dropdown-item" href="#">Another action</a>
					</ul>
				</li> --}}

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="nc-icon nc-bullet-list-67"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="{{ route('sigea.mensagens.index') }}">
							<i class="nc-icon nc-email-85"></i> Mensagens
						</a>
						<a class="dropdown-item" href="#">
							<i class="nc-icon nc-umbrella-13"></i> Ajuda
						</a>
						<a class="dropdown-item" href="{{ route('sigea.configuracoes.index') }}">
							<i class="nc-icon nc-settings-90"></i> Configurações
						</a>
						<div class="divider"></div>
						<a class="dropdown-item" href="{{ route('lockscreen') }}">
							<i class="nc-icon nc-lock-circle-open"></i> Bloquear
						</a>
						<a href="#" class="dropdown-item text-danger" id="sair">
							<i class="nc-icon nc-button-power"></i> Sair
						</a>
						<form method="POST" action="{{ route('sigea.logout') }}" id="form-sair">
							{{ csrf_field() }}
						</form>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
