@extends('layouts.master')

@section('title', 'Relatorios')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Gerar lista</h4>
                    <p class="card-category text-center">Use o formulario abaixo para gerar a lista de confirmações</p>
                </div>
                <div class="card-body">
                    <form id="form-relatorio" method="post"
                          action="#"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <h4 class="card-title">Processo seletivo: {{ $edital->edital }}
                                - {{ $edital->descricao }}</h4>
                        </div>
                        <div class="form-group">
                            <label for="arquivo">Selecione o arquivo em formato CSV:</label>
                            <input class="form-control-file" type="file" name="arquivo" id="arqvuivo" accept="text/csv">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="col-sm-12">
                        <progress id="progress" class="progress-relatorio" value="0" max="100"></progress>
                    </div>
                    <hr>
                    <button type="submit" id="gerar" form="form-relatorio" class="btn btn-success">Gerar arquivo
                    </button>
                    <button type="submit" id="checar" form="form-relatorio" class="btn btn-info">Checar Lista</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">Instruções:</h3>
                </div>
                <div class="card-body">
                    <p class="card-title">Utilize o botão "Checar" para verificar as possíveis inconsistências entre o
                        arquivo anexado e os dados cadastrados.</p>
                    <p class="card-title">Utilize o botão "Gerar arquivo" para gerar a lista que deve ser enviada à
                        COPOG.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card invisible" id="checarPanel">
                <div class="card-header">
                    <h4 class="card-title text-center">Inconsistências:</h4>
                    <p class="card-category text-center">Essa é a lista de nomes registrados no sistema e que não
                        constam na lista anexa.</p>
                </div>
                <div class="card-body">
                    <div class="col-sm-12">
                        <div class="row" id="resultado">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .progress-relatorio {
            width: 100%;
        }

        .border-resultado {
            border: 1px solid black;
        }
    </style>
@endpush

@push('script')
    <script src="http://malsup.github.io/jquery.form.js"></script>
    <script>
        function exibeResposta(response) {
            if ($("#checarPanel").hasClass('invisible')) {
                $("#checarPanel").removeClass('invisible');
            }
            $.each(response, function (index, value) {
                $("#resultado").append([
                    '<div class="col-sm-3 border-resultado">' +
                    '<p> <b>Nome</b>: ' + value.nome + '</p>' +
                    '<p> <b>CPF</b>: ' + value.cpf + '</p>' +
                    '<p> <b>Data da confirmação</b>: ' + value.data + '</p>' +
                    '</div>'
                ]);
            })
        }

        $(document).on('documentReady', function () {
            var options = {
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSubmit: function (arr, $form, options) {
                    if (!$("#checarPanel").hasClass('invisible')) {
                        $("#resultado").children().remove();
                    }
                    $('#progress').attr('value', 0);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    $('#progress').attr('value', percentComplete);
                },
                success: function (response) {
                    exibeResposta(response);
                },
                error: function (response) {
                    if (response.errors) {
                        swal('Erro!', response.message, 'error');
                    }
                }
            };


            $('#checar').on('click', function (e) {
                e.preventDefault();

                $("#form-relatorio").ajaxForm(options);

                $("#form-relatorio").attr('action', "{{ route('sigea.confirmacao.relatorio.checar', $edital->id) }}");
                $("#form-relatorio").trigger('submit');
            });
            $("#gerar").on('click', function (e) {
                e.preventDefault();

                $("#form-relatorio").unbind('submit');

                $("#form-relatorio").attr('action', "{{route('sigea.confirmacao.relatorio.post', $edital->id)}}");
                $("#form-relatorio").trigger('submit');
            })
        });
    </script>
@endpush