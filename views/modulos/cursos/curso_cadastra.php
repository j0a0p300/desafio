
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cadastrar Curso</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header with-border">
                        <h3 class="card-title">Curso</h3>
                    </div>
                    <form method="POST" action="curso_lista"
                          role="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="curso">Nome</label>
                                    <input type="text" id="nome" name="nome" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="curso">Pessoa Física</label>
                                    <input type="text" id="pf" name="pf" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="curso">Duração</label>
                                    <input type="text" id="duracao" name="duracao" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="curso">Local </label>
                                    <select name="locais" class="form-control" data-placeholder="Selecione uma local..." required>
                                        <option value="">Selecione...</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label for="curso">Semestre </label>
                                <select name="semestre" class="form-control" data-placeholder="Selecione uma semestre..." required>
                                    <option value="">Selecione...</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>

                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?=SERVERURL?>cursos/curso_lista">
                                <button type="button" class="btn btn-default">Voltar</button>
                            </a>
                            <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
                                Cadastrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
