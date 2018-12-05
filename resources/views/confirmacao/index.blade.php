@extends('layouts.master')

@section('title', 'Confirmações de inscrição')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Selecione o processo seletivo:</h4>
			</div>
			<div class="card-body">
				<form action="" method="get" id="form-selecionar">
					<div class="col-8">
						<select name="edital" id="inscricai" class="selectpicker">
							@foreach ($editais as $edital)
								<option value="{{ $edital->id }}">{{ $edital->edital }} - {{ $edital->descricao }}</option>
							@endforeach
						</select>
					</div>
				</form>
			</div>
			<div class="card-footer">
				<hr>
				<button type="submit" form="form-selecionar" class="btn btn-success">Consultar</button>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title text-center">Cadastrar nova confirmação de inscrição</h4>
				<p class="card-category text-center">Utilize o botão abaixo para acessar a página de cadastro de nova confirmação de inscrição.</p>
			</div>
			<div class="card-body">
				<div class="text-center">
					<a class="btn btn-success" href="{{ route('sigea.confirmacao.create') }}">Cadastrar</a>
				</div>
			</div>
		</div>
	</div>
</div>
@if (Request::get('edital'))
	@include('confirmacao.lista-confirmacao', ['confirmacoes' => $confirmacoes])
@endif
@endsection