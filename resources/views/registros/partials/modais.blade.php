<!-- Modais -->
<div class="modal fade" id="modalHistorico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Atualizar históricos</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('sigea.historicos.update') }}" id="form-historicos" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="arquivo">Selecione o arquivo:</label>
                        <input class="form-control-file" type="file" accept="text/csv" name="arquivo" id="arquivo">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" form="form-historicos" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalCr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Atualizar Coeficientes de Rendimento</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('sigea.atualizar.cr') }}" id="form-Cr" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="arquivo">Selecione o arquivo:</label>
                        <input class="form-control-file" type="file" accept="text/csv" name="arquivo" id="arquivo">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" form="form-Cr" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
{{--
<div class="modal fade" id="modalMatriculaId" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Atualizar históricos</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('sigea.historicos.update') }}" id="form-historicos" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="arquivo">Selecione o arquivo:</label>
                        <input class="form-control-file" type="file" accept="text/csv" name="arquivo" id="arquivo">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" form="form-historicos" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>--}}
