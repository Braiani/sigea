@extends('layouts.master')

@section('title', 'Registro de rematrícula')

@section('content')
<div class="row">
    <div class="col-sm-10 col-md-8">
        <h3>Por favor, Selecione o estudante abaixo.</h3>
        <div class="form-group">
            <select id="aluno" name="aluno" class="form-control selectpicker">
                <option value=''>-- Selecione o aluno --</option>
                @foreach ($alunos as $aluno)
                    <option value="{{$aluno->id}}">{{$aluno->nome}} - {{$aluno->curso->nome}} - {{$aluno->matricula}}</option>
                @endforeach
            </select>
        </div>
        <a class="btn btn-primary btn-lg" id="btnRegistro" target="_blank" href="javascrip:void(0);">Registrar</a>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            //$('.select').select2();
            $('#aluno').on('change', function(){
                //alert($(this).val());
                if($(this).val() !== ""){
                    $('#btnRegistro').attr('href', 'registros/' + $(this).val());
                }else{                    
                    $('#btnRegistro').attr('href', 'javascrip:void(0);');
                }
            });
        });
    </script>
@endpush