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
        $tasks_model = new App\Task;
    @endphp
    @include('tasks', ['tasks_model' => $tasks_model])
    {{-- End Task widget! --}}
</div>
<div class="row">

</div>
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function() {
        @php
            $cursos = $passivo->select('curso', DB::raw('count(*) as total'))->groupBy('curso')->get();
        @endphp
        var labels = [];
        var count = [];
        @foreach($cursos as $key)
            labels.push("{{ $key->curso }}");
            count.push("{{ $key->total }}");
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
