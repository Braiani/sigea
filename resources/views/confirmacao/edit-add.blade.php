@extends('layouts.master')

@section('title', 'Cadastrar nova Confirmação')

@section('content')
@php
	if (isset($confirmacao['inscricao'])) {
		$editRows = [
			'edit' => true,
			'route' => 'sigea.confirmacao.update',
			'nome' => $confirmacao['nome'],
			'cpf' => $confirmacao['cpf'],
			'processo_seletivo_id' => $confirmacao['processo_seletivo_id'],
			'id' => $confirmacao['id']
		];
	}else {
		$editRows = [
			'route' => 'sigea.confirmacao.store',
			'edit' => false,
			'nome' => '',
			'cpf' => '',
			'processo_seletivo_id' => ''
		];
	}
@endphp
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header ">
				<h4 class="card-title">Cadastrar uma nova confirmação de inscrição:</h4>
				<p class="card-category">Usar esse formulário para cadastrar uma nova confirmação de inscrição.</p>
			</div>
			<div class="card-body">
				<form id="form-confirmacao" action="@if ($editRows['edit']) {{ route($editRows['route'], $editRows['id']) }} @else {{ route($editRows['route']) }} @endif"
					method="post">
					@csrf
					@if ($editRows['edit'])
						@method('PUT')
					@endif
					{{-- <div class="form-row"> --}}
						<div class="form-group">
							<label for="processo_seletivo_id">Processo seletivo:</label>
							<select class="form-control selectpicker @if($errors->has('processo_seletivo_id')) is-invalid @endif" 
								name="processo_seletivo_id" id="processo_seletivo_id">
								<option>---</option>
								@foreach ($editais as $edital)
								<option value="{{ $edital->id }}"
									{{ ($editRows['processo_seletivo_id'] == $edital->id) ? 'selected' : '' }}
									>{{ $edital->edital }} - {{ $edital->descricao }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="cpf">CPF:</label>
							<input type="text" name="cpf" id="cpf" class="form-control @if($errors->has('cpf')) is-invalid @endif" 
								value="{{ old('cpf') != null ? old('cpf') : $editRows['cpf'] }}"
								>
						</div>
						<div class="form-group">
							<label for="nome">Nome:</label>
							<input type="text" name="nome" id="nome" class="form-control @if($errors->has('nome')) is-invalid @endif"
							value="{{ $editRows['nome'] }}"
							>
						</div>
					{{-- </div> --}}
				</form>
			</div>
			<div class="card-footer ">
				<hr>
				<div class="stats">
					<div class="pull-right">
						<button type="submit" form="form-confirmacao" class="btn btn-success"><i class="fa fa-plus"></i> Salvar</button>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection

@push('script')
<script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
	$(document).ready(function(){
		$("#cpf").inputmask("999.999.999-99");
	});
</script>
@endpush