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
                <div class="card-body ">
                    <div class="table-full-width">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" checked value="">
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>Sign contract for "What are conference organizers afraid of?"</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-link">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-link">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="now-ui-icons loader_refresh spin"></i> Updated 3 minutes ago
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

        $('[rel="tooltip"]').tooltip();
    });
</script>
@endpush
