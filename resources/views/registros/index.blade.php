@extends('layouts.master')

@section('title', 'Registro de rematrícula')

@section('content')
<div class="row">
    <div class="col-sm-10 col-md-8">
        <h3>Por favor, Selecione o estudante abaixo.</h3>
        <div class="form-group">
            <select id="aluno" name="aluno" class="form-control selectpicker" data-style="btn-info">
                <option value=''>-- Selecione o aluno --</option>
                @foreach ($alunos as $aluno)
                    <option value="{{$aluno->id}}">{{$aluno->nome}} - {{$aluno->curso->nome}} - {{$aluno->matricula}}</option>
                @endforeach
            </select>
        </div>
        <a class="btn btn-info btn-lg" id="btnRegistro" target="" href="#">Registrar</a>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
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
