@extends('layouts.master')

@section('title', 'Início')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Cadastrar nova confirmação de inscrição</h4>
                    <p class="card-category text-center">Utilize o botão abaixo para acessar a página de cadastro de
                        nova confirmação de inscrição.</p>
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
        {{-- Start Task widget! --}}
        @php
            $tasks_model = new \App\Models\Task;
        @endphp
        <div class="col-md-6">
            @include('tasks', ['tasks_model' => $tasks_model])
        </div>
        {{-- End Task widget! --}}
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Mural de recados</h4>
                    <p class="card-category text-center">Futuro mural de recados a ser implementado</p>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Em breve...</h4>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Agenda do COGEA</h4>
                    <p class="card-category text-center">Abaixo está a agenda do COGEA - Compromissos e eventos</p>
                </div>
                <div class="card-body">
                    <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showCalendars=0&amp;wkst=1&amp;src=cogea.cg%40ifms.edu.br&amp;ctz=America%2FCampo_Grande"
                            width="100%" height="400" frameborder="0"
                            scrolling="no"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
                    @can('create', $tasks_model)
            var url = "{{ route('sigea.tasks.store') }}";
            $('#addTask').on('click', async function () {
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
