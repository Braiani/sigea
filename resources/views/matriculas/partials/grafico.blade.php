<div class="col-sm-12">
	<canvas id="matriculadosChart"></canvas>
</div>

@push('script-matricula-functions')
<script>
	function execAjaxMatricula() {
		var url = '{{ route('sigea.matriculas.relatorio.matriculados') }}';
		$.ajax({
			url: url,
		}).done(function(response){
			criarChart(response);
		});
	}

	function criarChart(dados) {
		var color = [];
		for(i = 0; i < 25; i++){
			color.push(
				'rgba('+Math.floor(Math.random() * 255)+','+Math.floor(Math.random() * 255)+','+Math.floor(Math.random() * 255)+',0.2)'
			);
		}

		var labels = [];
		var count = [];
		var title = '';

		$.each(dados, function(index, value){
			labels.push(value.descricao + ' (' + value.candidatos.length + ')');
			count.push(value.candidatos.length);
		});

		var ctx = document.getElementById('matriculadosChart').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'pie',
			data: {
				labels: labels,
				datasets: [{
					label: title,
					data: count,
					backgroundColor: color,
					borderColor: color,
					borderWidth: 1
				}]
			}
		});
	}
</script>
@endpush

@push('script')
<script>
	$(document).on('atualizarGrafico', function () {
		execAjaxMatricula();
	});
</script>
@endpush