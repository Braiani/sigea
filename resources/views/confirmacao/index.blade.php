@extends('layouts.master')

@section('title', 'Confirmações de inscrição')

@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Selecione o processo seletivo:</h4>
			</div>
			<div class="card-body">
				<form action="#" method="get" id="form-selecionar">
					<div class="col-4">
						<select name="inscricao" id="inscricai" class="selectpicker">
							<option value="0">Edital 000/2018</option>
							<option value="1">Edital 001/2018</option>
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
				<h4 class="card-title">Cadastrar nova confirmação de inscrição</h4>
				<p class="card-category">Utilize o botão abaixo para acessar a página de cadastro de nova confirmação de inscrição.</p>
			</div>
			<div class="card-body">
				<a class="btn btn-success" href="{{ route('sigea.confirmacao.create') }}">Cadastrar</a>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card strpied-tabled-with-hover">
			<div class="card-header ">
				<h4 class="card-title">Candidatos que já confirmaram a inscrição</h4>
				<p class="card-category">Essa é a lista dos candidatos que já confirmaram a inscrição para o processo seletivo informado.</p>
			</div>
			<div class="card-body table-full-width table-responsive">
				<table class="table table-hover table-striped">
					<thead>
						<th>ID</th>
						<th>Name</th>
						<th>Salary</th>
						<th>Country</th>
						<th>City</th>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>Dakota Rice</td>
							<td>$36,738</td>
							<td>Niger</td>
							<td>Oud-Turnhout</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Minerva Hooper</td>
							<td>$23,789</td>
							<td>Curaçao</td>
							<td>Sinaai-Waas</td>
						</tr>
						<tr>
							<td>3</td>
							<td>Sage Rodriguez</td>
							<td>$56,142</td>
							<td>Netherlands</td>
							<td>Baileux</td>
						</tr>
						<tr>
							<td>4</td>
							<td>Philip Chaney</td>
							<td>$38,735</td>
							<td>Korea, South</td>
							<td>Overland Park</td>
						</tr>
						<tr>
							<td>5</td>
							<td>Doris Greene</td>
							<td>$63,542</td>
							<td>Malawi</td>
							<td>Feldkirchen in Kärnten</td>
						</tr>
						<tr>
							<td>6</td>
							<td>Mason Porter</td>
							<td>$78,615</td>
							<td>Chile</td>
							<td>Gloucester</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="card-footer">
				<hr>
				<div class="pull-right">
					<a href="{{ route('sigea.confirmacao.edit', 1) }}" class="btn btn-success">Gerar relatório</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection