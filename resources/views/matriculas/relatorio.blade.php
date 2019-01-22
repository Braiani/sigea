@extends('layouts.master')

@section('title', 'Matrículas')

@section('content')
{{-- <div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title text-center">Gráfico por curso</h4>
				<p class="card-category text-center">Visão das matrículas por curso</p>
			</div>
			<div class="card-body">
				@include('matriculas.partials.grafico-relatorios')
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title text-center">Gráfico por cota</h4>
				<p class="card-category text-center">Visão das matrículas por cota</p>
			</div>
			<div class="card-body">
				<h4>Gráfico aqui!</h4>
			</div>
		</div>
	</div>
</div> --}}
<div class="row">
	<div class="col-sm-12">
		<div class="card bootstrap-table">
			<div class="card-body table-full-width">
				<div class="toolbar">
					<!--        Here you can write extra buttons/actions for the toolbar              -->
				</div>
				<div class="col-sm-12">
					<table id="table"
						class="table table-condensed"
						data-url="{{ route('sigea.matriculas.relatorio.lista') }}"
						data-height="600"
						data-row-style="colorStyle"
						data-side-pagination="server"
						data-locale="pt-BR">
						<thead>
							<tr>
								<th data-field="nome" data-sortable="true">Nome</th>
								<th data-field="curso"
									data-align="center"
									data-formatter="cursoFormatter">
									Curso
								</th>
								<th data-field="chamada"
									data-sortable="true"
									data-align="center"
									data-formatter="chamadaFormatter">
									Chamada
								</th>
								<th data-field="cota_candidato"
									data-align="center"
									data-formatter="cotaFormatter">
									Cota Candidato
								</th>
								<th data-field="cota_ingresso"
									data-align="center"
									data-formatter="cotaFormatter">
									Cota Ingresso
								</th>
								<th data-field="status"
									data-formatter="statusFormatter"
									data-align="center">
									Status
								</th>
								<th data-field="observacao"
									data-align="center"
									data-formatter="observacaoFormatter">
									Observação
								</th>
								<th data-field="servidor"
									data-align="center"
									data-formatter="servidorFormatter">
									Servidor
								</th>
								@if(Auth::user()->isNuged or Auth::user()->isCogea or Auth::user()->isAdmin)
								<th data-field="actions" class="td-actions text-right"
									data-events="operateEvents" data-formatter="operateFormatter">
									Ações
								</th>
								@endif
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@stack('script-matricula-graficos')
@push('script')
<script>
	function operateFormatter(value, row, index) {
		if (row.status.padrao_analise) {
			return [
				'<a rel="tooltip" title="Deferir" class="btn btn-link btn-success table-action deferido" href="javascript:void(0)">',
					'<i class="fa fa-check"></i>',
				'</a>',
				'<a rel="tooltip" title="Indeferir" class="btn btn-link btn-danger table-action indeferido" href="javascript:void(0)">',
					'<i class="fa fa-remove"></i>',
				'</a>'
			].join('');
		}else if (row.status.descricao == "Deferido") {
			@if(Auth::user()->isCogea or Auth::user()->isCerel)
			return [
				'<a rel="tooltip" title="Matricular" class="btn btn-link btn-info table-action matricular" href="javascript:void(0)">',
					'<i class="fa fa-graduation-cap"></i>',
				'</a>'
			].join('')
			@endif
		}else if (row.status.descricao == "Indeferido") {
			@if(Auth::user()->isCogea)
			return [
				'<a rel="tooltip" title="Reclassificar" class="btn btn-link btn-danger table-action reclassificar" href="javascript:void(0)">',
					'<i class="fa fa-archive"></i>',
				'</a>'
			].join('')
			@endif
		}
	}

	function colorStyle(row, index) {
		if (row.status.padrao_matriculado) {
			return {
				classes: 'success'
			}
		}else if (row.status.padrao_analise) {
			return {
				classes: 'warning'
			}
		}else if (row.status.padrao_reclassificacao) {
			return {
				classes: 'danger'
			}
		}else{
			return {};
		}
	}

	function observacaoFormatter(value) {
		if (value != null) {
			return value;
		}else{
			return 'Sem observações.';
		}
	}

	function cotaFormatter(value) {
		return value.sigla;
	}

	function cursoFormatter(value) {
		return value.nome;
	}

	function servidorFormatter(value) {
		if (value != null) {
			return value.name;
		}
	}

	function statusFormatter(value) {
		return value.descricao;
	}

	function chamadaFormatter(value) {
		return value + "ª Chamada";
	}

	function reclassificacao(candidatoId, table) {
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
				ajaxMatricula('POST', '{{ route('sigea.matriculas.reclassificacao') }}', $data, table);
			}
		});
	}

	function ajaxMatricula(type, url, data, table){
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
					table.bootstrapTable('refresh');
					swal(
						"Sucesso!",
						response.message,
						"success"
					)
				}else {
					swal(
						"Erro!",
						response.message,
						"error"
					)
				}
			},
			error: function (response) {
				swal(
					"Erro interno!",
					"Oops, ocorreu um erro ao tentar salvar as alterações.", // had a missing comma
					"error"
				)
			}
		});
	}
	
	$(document).on('pageReady', function () {
		$(document).trigger('atualizarGrafico');
		var $table = $('#table');

		window.operateEvents = {
			'click .deferido': function(e, value, row, index) {
				data = {
					id: row.id
				};
				ajaxMatricula('POST', "{{ route('sigea.matriculas.analise.deferido') }}", data, $table);
			},
			'click .reclassificar': function(e, value, row, index) {
				reclassificacao(row.id, $table);
			},
			'click .indeferido': function(e, value, row, index) {
				data = {
					id: row.id
				};
				ajaxMatricula('POST', "{{ route('sigea.matriculas.analise.indeferido') }}", data, $table);
			},
			'click .matricular': function(e, value, row, index) {
				data = {
					id: row.id
				};
				ajaxMatricula('POST', "{{ route('sigea.matriculas.analise.matricular') }}", data, $table);
			}
		};

		$table.bootstrapTable({
			toolbar: ".toolbar",
			clickToSelect: false,
			showRefresh: true,
			search: true,
			showToggle: true,
			showColumns: true,
			pagination: true,
			searchAlign: 'left',
			pageSize: 10,
			pageList: [5, 10, 15, 20, 50, 100],
			icons: {
					refresh: 'fa fa-refresh',
					toggle: 'fa fa-th-list',
					columns: 'fa fa-columns',
					detailOpen: 'fa fa-plus-circle',
					detailClose: 'fa fa-minus-circle'
				}
		});

		$(window).resize(function() {
			$table.bootstrapTable('resetView');
		});
	});
</script>
@endpush