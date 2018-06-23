@php
    if (Auth::user()->isAdmin or Auth::user()->isCogea) {
        $tasks = $tasks_model->orderBy('deadline', 'ASC')->paginate(6);
    }else{
        $tasks = $tasks_model->where('user_to', Auth::id())
                            // ->whereNull('completed')->orWhere('completed', 0)
                            ->latest()->paginate(6);
    }
    $anyTask = $tasks->count() == 0;
@endphp
<div class="col-md-6">
    <div class="card card-tasks">
        <div class="card-header">
            <h4 class="card-title">Tarefas</h4>
            <p class="card-category">Tarefas repassadas pelo COGEA</p>
        </div>
        <div class="card-body">
            <div class="table-full-width">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Prazo</th>
                            @can('create', $tasks_model)
                                <th>Servidor</th>
                            @endcan
                            <th>Tarefa</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($anyTask)
                        <tr>
                            <td>Nenhuma tarefa atribuída!</td>
                        </tr>
                        @endif
                        @foreach ($tasks as $task)
                        @php
                            if($task->deadline->isSameDay(\Carbon\Carbon::today(-4))){
                                $deadline = "Prazo termina hoje!";
                                $class = 'warning';
                            }elseif($task->deadline < \Carbon\Carbon::today(-4)){
                                $deadline = 'Expirou ' . $task->deadline->diffForHumans();
                                $class = 'danger';
                            }else{
                                $deadline = 'Expira ' . $task->deadline->diffForHumans();
                                $class = '';
                            }
                            if ($task->completed) {
                                $complete_init = "<del>";
                                $complete_end = "</del>";
                            }else{
                                $complete_init = "";
                                $complete_end = "";
                            }
                        @endphp
                        @if ($task->completed)
                        <tr class="success">
                        @else
                        <tr class="{{ $class }}">
                        @endif
                            <td>{!! $complete_init . $deadline . $complete_end !!}</td>
                            @can('create', $task)
                            <td>{!! $complete_init . $task->userTo->name . $complete_end !!}</td>
                            @endcan
                            <td>{!! $complete_init . $task->task . $complete_end !!}</td>
                            <td class="td-actions text-right">
                                @if (!$task->completed)
                                <form action="{{ route('sigea.tasks.update', $task->id) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <button rel="tooltip" title="Tarefa realizada" class="btn btn-info btn-simple btn-link">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('sigea.tasks.update', $task->id) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <button rel="tooltip" title="Tarefa realizada" class="btn btn-info btn-simple btn-link">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                </form>
                                @endif
                                @can('delete', $tasks_model)
                                <form action="{{ route('sigea.tasks.update', $task->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-link">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        {{ $tasks->links() }}
        <div class="card-footer ">
            <hr>
            <div class="stats">
                <i class="now-ui-icons loader_refresh spin"></i> Atualizado
                @can('create', $tasks_model)
                    <div class="pull-right">
                        <button id="addTask" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar tarefa</button>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>
