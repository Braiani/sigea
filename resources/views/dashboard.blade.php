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
    <div class="col-md-6">
            <div class="card  card-tasks">
                <div class="card-header ">
                    <h4 class="card-title">Tarefas</h4>
                    <p class="card-category">Tarefas repassadas pelo COGEA</p>
                </div>
                @php
                    $tasks = new App\Task;
                    $anyTask = false;
                @endphp
                <div class="card-body ">
                    <div class="table-full-width">
                        <table class="table">
                            <tbody>
                                @foreach ($tasks->get() as $task)
                                @can('see', $task)
                                @php $anyTask = true; @endphp
                                <tr>
                                    <td>@if($task->deadline > \Carbon\Carbon::now()) Expira @else Prazo terminou @endif {{ $task->deadline->diffForHumans() }}</td>
                                    <td>{{ $task->task }}</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" id="taskDone" title="Tarefa realizada" class="btn btn-info btn-simple btn-link">
                                            <i class="fa fa-check "></i>
                                        </button>
                                        @can('delete', $task)
                                            <button type="button" rel="tooltip" id="removeTask" title="Remove" class="btn btn-danger btn-simple btn-link">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                                @endcan
                                @endforeach
                                @if (!$anyTask)
                                    <tr>Nenhuma tarefa atribuída!</tr>
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="now-ui-icons loader_refresh spin"></i> Atualizado
                        @can('create', $tasks)
                            <div class="pull-right">
                                <button id="addTask" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar tarefa</button>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
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

        @can('create', $tasks)
        var url = "{{ route('sigea.tasks.store') }}";
        $('#addTask').on('click', async function() {
            await addTask(url)
        });
        @endcan

        $('[rel="tooltip"]').tooltip();
    });
</script>
<script src="{{ asset('js/tasks-js.js') }}"></script>
@endpush
