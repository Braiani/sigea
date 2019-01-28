@extends('layouts.master')

@section('title', 'Registro de rematrícula')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('css/custom.css') }}">
    <style>
        .escondido {
            display: none;
        }
        .aprovado{
            text-decoration: none;
            color: rgba(32, 157, 13, 0.72) !important;
        }
        .reprovado{
            line-height: 1em;
            align-content: center !important;
            color: rgba(157, 32, 13, 0.72) !important;
        }
    </style>
@endpush

@section('content')
    @if(Auth::user()->isAdmin or Auth::user()->isCogea)
        <div class="row">
            <div class="col-sm-12 m-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalHistorico">
                    Atualizar históricos escolares
                </button>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalCr">
                    Atualizar CR
                </button>
                {{--<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalMatriculaId">
                    Atualizar Matrícula ID
                </button>--}}

                @include('registros.partials.modais')

            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Por favor, Selecione o estudante abaixo.</h4>
                </div>
                <div class="card-body">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <select id="aluno" name="aluno" class="form-control select2"></select>
                        </div>
                        {{--<a class="btn btn-info btn-lg" id="btnRegistro" target="" href="#">Registrar</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card escondido" id="disciplinas">
                <div class="card-header">
                    <h4 class="card-title text-center">Realizar rematrícula</h4>
                </div>
                <div class="card-body">
                    <form action="#" method="POST" target="_blank" id="form-rematricula">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="situacao">Situação do estudante:</label>
                                    <select id="situacao" name='situacao' class='form-control select2'
                                            title="Selecione a situação do estudante">
                                        <option value="1">Dependência</option>
                                        <option value="2">Retido</option>
                                        <option value="3">Regular</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="semestre">Semestre de rematrícula:</label>
                                    <select id="semestre" name='semestre' class='form-control select2'>
                                        <option value="20191">2019/1</option>
                                        <option value="20182" disabled>2018/2</option>
                                        <option value="20181" disabled>2018/1</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="disciplinas_curso"></div>
                    </form>
                </div>
                <div class="card-footer">
                    <hr>
                    <button type="submit" id="btn-form" form="form-rematricula" class="btn btn-success escondido">Registrar</button>
                    <a href="#" id="btn-editar" class="btn btn-warning escondido">Editar</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/pt-BR.js"></script>
    <script>
        function execAjax(method, url, data, callback) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: method,
                url: url,
                data: data
            }).then(function (response) {
                callback(response);
            });
        }

        function alunoRegular(aluno) {
            $('#situacao').val(aluno.situacao.id);
            $("#situacao").trigger('change');

            $("#disciplinas_curso div").remove();
            if (!$("#btn-form").hasClass('escondido')) {
                $("#btn-form").addClass('escondido');
                $("#btn-editar").addClass('escondido');
            }

            swal({
                title: 'Aluno regular!',
                text: 'Clique em OK para acessar o Siga.',
                showCancelButton: true,
                cancelButtonText: 'Fechar',
                type: 'success'
            });

            $('.swal2-confirm').on('click', function(){
                window.open('https://academico.ifms.edu.br/administrativo/alunos/panorama', '_blank');
            });
        }

        function alunoNaoRegular(aluno, disciplinas, registros) {
            var reprovado = ['Reprovado por Nota', 'Reprovado por Falta'];
            $('#situacao').val(aluno.situacao.id);
            $("#situacao").trigger('change');

            $("#form-rematricula").attr('action', '{{ route('sigea.registros.update', '__id') }}'.replace('__id', aluno.id));
            $("#btn-editar").attr('href', '{{ route('sigea.registros.show', ['__id', 'semestre' => '20191']) }}'.replace('__id', aluno.id));
            $("#disciplinas_curso div").remove();

            if ($("#btn-form").hasClass('escondido')) {
                $("#btn-form").removeClass('escondido');
                $("#btn-editar").removeClass('escondido');
            }

            for (i = 1; i < 8; i++) {
                $("#disciplinas_curso").append(
                    '<div class="col-sm-4">' +
                        '<div class="form-group border">' +
                            '<h4 class="card-title text-center">' + i + 'º Semestre</h4>' +
                            '<div class="m-2 p-2" id="semestre_' + i + '"></div>' +
                        '</div>' +
                    '</div>'
                );
                $.each(disciplinas, function (index, value) {
                    if (value.semestre === i) {
                        $("#semestre_" + i).append(
                            '<label class="reprovado">' +
                            '<input type="checkbox" name="disciplinas[]" value="' + value.id + '" '+ checked + '> ' +
                            value.nome + ' (' + value.pivot.status + ')' +
                            '</label> <br>'
                        );
                        // if ($.inArray(value.pivot.status, reprovado) > -1) {
                        //     var checked = '';
                        //     $.each(registros, function (i, v) {
                        //         if (value.id === v.id_disciplina_cursos){
                        //             checked = 'checked';
                        //             console.log('eba: ' + v.id_disciplina_cursos);
                        //         }
                        //     });
                        //     $("#semestre_" + i).append(
                        //         '<label class="reprovado">' +
                        //         '<input type="checkbox" name="disciplinas[]" value="' + value.id + '" '+ checked + '> ' +
                        //         value.nome + ' (' + value.pivot.status + ')' +
                        //         '</label> <br>'
                        //     );
                        // }else{
                        //     $("#semestre_" + i).append(
                        //         '<p class="card-category aprovado">' + value.nome + '</p>'
                        //     );
                        // }
                    }
                });
            }
        }

        function exibirRespostaBusca(response) {
            console.log(response);
            alunoNaoRegular(response.aluno, response.disciplinas, response.registros);
            // if (response.aluno.situacao !== null) {
            //     if (response.aluno.situacao.nome === "Regular") {
            //         alunoRegular(response.aluno);
            //     }else{
            //         alunoNaoRegular(response.aluno, response.historico, response.registros);
            //     }
            // }
        }

        $(document).on('pageReady', function () {
            $("#aluno").select2({
                language: "pt-BR",
                placeholder: "Selecione um aluno...",
                minimumInputLength: 3,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '{{ route('sigea.registros.getAlunos') }}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data,
                        }
                    },
                }
            });

            $("#aluno").on('change', function () {
                var aluno = $(this).select2('data')[0]['aluno'];
                window.location = "{{ route('sigea.registros.show', ['__id', 'semestre' => '20191']) }}".replace('__id', aluno.id);
                // if ($("#disciplinas").hasClass('escondido')) {
                //     $("#disciplinas").toggleClass('escondido');
                //     $('#disciplinas select').select2();
                // }
                // url = "{{ route('sigea.registros.edit', '__id') }}";
                // semestre = $("#semestre").val();

                // data = {
                //     id: aluno.id,
                //     semestre: semestre
                // };
                // execAjax('GET', url.replace('__id', aluno.id), data, exibirRespostaBusca);
            })
        });
    </script>
@endpush
