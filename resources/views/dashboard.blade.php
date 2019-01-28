@extends('layouts.master')
@section('title', 'Início')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card ">
            <div class="card-header ">
                <h4 class="card-title">Arquivo Passivo</h4>
                <p class="card-category">Total de pastas no passivo por Curso</p>
            </div>
            <div class="card-body ">
                {{-- <div id="chartPassivo" class="ct-chart ct-perfect-fourth"></div> --}}
                <canvas id="passivoChart"></canvas>
            </div>
            <div class="card-footer ">
                <div class="legend">

                </div>
            </div>
        </div>
    </div>
    {{-- Start Task widget! --}}
    @php
        $tasks_model = new \App\Models\Task;
    @endphp
    @include('tasks', ['tasks_model' => $tasks_model])
    {{-- End Task widget! --}}
</div>
<div class="row">
	<div class="col-md-3">
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
	<div class="col-md-3">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title text-center">Realizar Matrícula</h4>
				<p class="card-category tex-center">Utilize o botão abaixo para registrar uma matrícula nova.</p>				
			</div>
			<div class="card-body">
				<div class="text-center">
					<a href="{{ route('sigea.matriculas.index') }}" class="btn btn-success">Acessar</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function() {
        @php
            $cursos = $passivo->select('curso_id', DB::raw('count(*) as total'))->groupBy('curso_id')->get();
        @endphp
        var labels = [];
        var count = [];
        @foreach($cursos as $key)
        @if($key->curso_id != null)
        labels.push("{{ $key->curso->nome }}");
        count.push("{{ $key->total }}");
        @endif
        @endforeach
        var title = '';
        var id = 'passivoChart';

        app.initPassivoPie(id, labels, count, title);

        @can('create', $tasks_model)
        var url = "{{ route('sigea.tasks.store') }}";
        $('#addTask').on('click', async function() {
            var urlGetUsers = "{{ route('sigea.tasks.getUsers') }}";
            await addTask(url, urlGetUsers);
            // window.location.reload();
        });
        @endcan

        $('[rel="tooltip"]').tooltip();
    });
</script>
<script src="{{ asset('js/tasks-js.js') }}"></script>
@endpush
