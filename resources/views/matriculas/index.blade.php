@extends('layouts.master')
@section('title', 'Matrículas')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-sm-10">
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
	</div>
</div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/pt-BR.js"></script>
<script>
	$(document).ready(function() {
		$('.select2').select2({
			language: "pt-BR",
			allowClear: true,
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
	});
</script>
@endpush