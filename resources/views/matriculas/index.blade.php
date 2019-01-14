@extends('layouts.master')
@section('title', 'Matrículas')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('css/custom.css')}}">
@endpush

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title text-center">Escolha o candidato abaixo:</h3>
							<p class="card-category text-center">Digite o nome ou CPF do candidato</p>
						</div>
						<div class="card-body ">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<select id="candidato" name="candidato" class="form-control select2"></select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="card card-tasks">
						<div class="card-header ">
							<h4 class="card-title text-center">Nova Matrícula</h4>
							<p class="card-category text-center" id="nome">Selecione o candidato acima...</p>
						</div>
						<div class="card-body ">
							<form action="{{ route('sigea.matriculas.store') }}" method="post" id="form-matricula">
								@csrf
								<div class="row">
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label for="nome">Nome Completo</label>
											<input type="hidden" name="id" id="id_candidato">
											<input type="text" name="nome" id="nome_input" class="form-control">
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label for="cota_candidato">Cota do Candidato</label>
													<input type="text" id="cota_candidato" readonly class="form-control disabled">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label for="cota_ingresso">Cota de Ingresso</label>
													<input type="text" id="cota_ingresso" readonly class="form-control disabled">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="nome">E-mail</label>
											<p class="text-muted">Será enviado informações sobre a matrícula para este e-mail</p>
											<input type="email" name="email" id="email" class="form-control">
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="table-full-width">
											<table class="table table-documentos">
												<tbody id="ckechklist">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="card-footer ">
							<hr>
							<div class="stats">
								<button id="btn-submit" type="submit" hidden form="form-matricula" class="btn btn-success">Salvar</button>
								<button id="reclassificacao" type="button" hidden class="btn btn-danger">Reclassificação</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title text-center">Visão Geral das Matrículas</h3>
					<p class="card-category text-center">Aqui estão as matrículas por status</p>
				</div>
				<div class="card-body">
					@include('matriculas.partials.grafico')
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/pt-BR.js"></script>
@stack('script-matricula-functions')
<script>
	function clearChecklist(){
		var checklist = $("#ckechklist > tr");
		checklist.remove();
	}

	function clearCampos() {
		clearChecklist();

		$("#nome").text('');
		$("#id_candidato").val('');
		$("#nome_input").val('');
		$("#email").val('');
		$("#cota_candidato").val('');
		$("#cota_ingresso").val('');

		$("#btn-submit").attr('hidden', true);
		$("#reclassificacao").attr('hidden', true);
	}

	function exibeInformacoesCandidato(candidato, respostaAjax) {
		clearChecklist();
				
		$("#nome").text(candidato['nome']);
		$("#id_candidato").val(candidato['id']);
		$("#nome_input").val(candidato['nome']);
		$("#email").val(candidato['email']);
		$("#cota_candidato").val(candidato['cota_candidato']['sigla']);
		$("#cota_ingresso").val(candidato['cota_ingresso']['sigla']);

		$.each(respostaAjax['documentos'], function(index, value){
			$("#ckechklist").append(
				'<tr>' +
					'<td>' +
						'<div class="form-check">' +
							'<label class="form-check-label">' +
								'<input class="form-check-input" type="checkbox" name="documentos[]" checked value="'+ value.descricao +'">' +
								'<span class="form-check-sign"></span>' +
							'</label>' +
						'</div>' +
					'</td>' +
					'<td>'+ value.descricao +'</td>' +
				'</tr>'
			);
		});
		$("#btn-submit").removeAttr('hidden');
		$("#reclassificacao").removeAttr('hidden');
	}

	function reclassificacao(candidatoId) {
		var obs;
		swal({
			title: 'Registrar Reclassificação',
			text: 'Qual o motivo para a reclassificação?',
			input: 'text',
			type: 'warning',
			showCancelButton: true,
			allowOutsideClick: false,
			inputValidator: (value) => {
				return new Promise((resolve) => {
					if (value !== '') {
						resolve();
					} else {
						resolve('Campo observação em branco! :D');
					}
				});
			},
			preConfirm: (observacao) => {
				obs = observacao;
			}
		}).then((result) => {
			if (result.value) {
				var $data = {
					'id': candidatoId,
					'observacao': obs
				}
				execAjax('POST', '{{ route('sigea.matriculas.reclassificacao') }}', $data);
			}
		});
	}

	function execAjax(type, url, data){
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: type,
			url: url,
			data: data,
			cache: false,
			success: function(response) {
				if (!response.error) {
					$(document).trigger('atualizarGrafico');
					swal(
						"Sucesso!",
						response.message,
						"success"
					)
					clearCampos();
				}else {
					swal(
						"Erro!",
						response.message,
						"error"
					)
				}
			},
			error: function (response) {
				if (response.error) {
					swal(
						"Erro!",
						response.message,
						"error"
					)
				} else {
					swal(
						"Erro interno!",
						"Oops, ocorreu um erro ao tentar salvar as alterações.", // had a missing comma
						"error"
					)
				}
			}
		});
	}

	$(document).ready(function() {
		clearCampos();
		$(document).trigger('atualizarGrafico');
		$('.select2').select2({
			language: "pt-BR",
			placeholder: "Selecione um candidato...",
			minimumInputLength: 3,
			ajax: {
				url: '{{ route('sigea.matriculas.candidatos') }}',
				dataType: 'json',
				data : function(params){
					return {
						q : $.trim(params.term)
					};
				},
				processResults : function(data){
					return {
						results : data,
					}
				},
			}
		});
		$("#candidato").on('change', function () {
			var candidato = $(this).select2('data')[0]['candidato'];
			if (candidato['chamada'] != null) {
				if (candidato['status_matricula_id'] == null) {
					$.ajax({
						url: '{{ route('sigea.matriculas.cota') }}',
						dataType: 'json',
						data : {id: candidato['cota_ingresso']['id']},
					}).done(function(response){
						exibeInformacoesCandidato(candidato, response);
					});
				}else{
					clearCampos();
					Swal(
						'Oops!',
						'Candidato matriculado anteriormente!',
						'error'
					);
				}
			}else{
				clearCampos();
				Swal(
					'Oops!',
					'Parece que esse candidato está na lista de espera!',
					'error'
				);
			}
		});
		$("#reclassificacao").on('click', function (e) {
			e.preventDefault();
			reclassificacao($("#id_candidato").val());
		});
	});
</script>
@endpush