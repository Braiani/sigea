<div class="row">
	<div class="col-md-12">
		<div class="card strpied-tabled-with-hover">
			<div class="card-header ">
				<h4 class="card-title">Candidatos que já confirmaram a inscrição</h4>
				<p class="card-category">Essa é a lista dos candidatos que já confirmaram a inscrição para o processo seletivo informado.</p>
			</div>
			<div class="card-body table-responsive">
				<table class="table table-hover table-striped">
					<thead>
						<th>#</th>
						<th>Edital</th>
						<th>CPF</th>
						<th>Nome</th>
						<th>Ações</th>
					</thead>
					<tbody>
					@foreach ($confirmacoes as $confirmacao)
						<tr>
							<td>{{ $confirmacao->id }}</td>
							<td>{{ $confirmacao->edital->edital }} - {{ $confirmacao->edital->descricao }}</td>
							<td>{{ $confirmacao->cpf }}</td>
							<td>{{ $confirmacao->nome }}</td>
							<td>
								<div class="row">
									<a href="{{ route('sigea.confirmacao.edit', $confirmacao->id) }}" class="btn btn-link btn-warning table-action">
										<i class="fa fa-edit"></i> Editar
									</a>
									<form action="{{ route('sigea.confirmacao.destroy', $confirmacao->id) }}" method="post">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-link btn-danger table-action">
											<i class="fa fa-remove"></i>Apagar
										</button>
									</form>
								</div>
							</td>
						</tr>
					@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">{{ $confirmacoes->appends(Request::except('page'))->links() }}</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="card-footer">
				<hr>
				<div class="pull-right">
					
					<a href="#" class="btn btn-success">Gerar relatório</a>
				</div>
			</div>
		</div>
	</div>
</div>