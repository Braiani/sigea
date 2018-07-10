@extends('layouts.master')

@section('title', 'Registro de rematrícula')

@push('css')
<link href="{{asset('/css/ajax-bootstrap-select.css')}}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-sm-10 col-md-8">
        <h3>Por favor, Selecione o estudante abaixo.</h3>
        <div class="form-group">
            <select id="aluno" name="aluno" class="form-control selectpicker" data-style="btn-info"
                data-live-search="true">
            </select>
        </div>
        <a class="btn btn-info btn-lg" id="btnRegistro" target="" href="#">Registrar</a>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('/js/plugins/ajax-bootstrap-select.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/plugins/i18n/ajax-bootstrap-select.pt-BR.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            var options = {
                ajax          : {
                    headers   : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url     : '{{ route("sigea.registros.getAlunos") }}',
                    type    : 'POST',
                    dataType: 'json',
                    data    : {
                        q: '@{{{q}}}'
                    }
                },
                locale        : {
                    emptyTitle: 'Digite para procurar...'
                },
                log           : 3,
            };
            $('.selectpicker').selectpicker().ajaxSelectPicker(options);
            $('select').trigger('change');
            $('#aluno').on('change', function(){
                if($(this).val() !== ""){
                    $('#btnRegistro').attr('href', 'registros/' + $(this).val());
                    $('#btnRegistro').attr('target', '_Blank');
                }else{
                    $('#btnRegistro').attr('href', '#');
                    $('#btnRegistro').attr('target', '');
                }
            });
        });
    </script>
@endpush
