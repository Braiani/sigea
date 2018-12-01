@extends('layouts.master')

@section('title', 'Cadastrar nova Confirmação')

@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header ">
				<h4 class="card-title">Cadastrar uma nova confirmação de inscrição:</h4>
				<p class="card-category">Usar esse formulário para cadastrar uma nova confirmação de inscrição.</p>
			</div>
			<div class="card-body">
				<form id="form-confirmacao" action="{{ route('sigea.confirmacao.store') }}" method="post">
					@csrf
					{{-- <div class="form-row"> --}}
						<div class="form-group">
							<label for="inscricao">Processo seletivo:</label>
							<select class="form-control selectpicker" name="inscricao" id="inscricao">
								<option value="0" {{ (isset($confirmacao['inscricao']) and $confirmacao['inscricao'] == 0) ? 'selected' : '' }}>Edital 000/2018</option>
								<option value="1" {{ (isset($confirmacao['inscricao']) and $confirmacao['inscricao'] == 1) ? 'selected' : '' }}>Edital 001/2018</option>
							</select>
						</div>
						<div class="form-group">
							<label for="cpf">CPF:</label>
							<input type="text" name="cpf" id="cpf" class="form-control" 
								value="{{ (isset($confirmacao['cpf']) and $confirmacao['cpf'] !== null) ? $confirmacao['cpf'] : '' }}"
								>
						</div>
						<div class="form-group">
							<label for="nome">Nome:</label>
							<input type="text" name="nome" id="nome" class="form-control"
							value="{{ (isset($confirmacao['nome']) and $confirmacao['nome'] !== null) ? $confirmacao['nome'] : '' }}"
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