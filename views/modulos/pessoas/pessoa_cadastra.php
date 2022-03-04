<?php
require_once "./controllers/PessoaController.php";
$pessoaObj = new PessoaController();

$id = $_GET['id'] ?? null;
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cadastrar Pessoa</h1>
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
                        <h3 class="card-title">Pessoa</h3>
                    </div>
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="" role="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="curso">Nome</label>
                                    <input type="text" id="nome" name="nome" class="form-control"  required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="curso">Email</label>
                                    <input type="text" id="pf" name="pf" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="curso">Data de Nascimento</label>
                                    <input type="date" id="duracao" name="duracao" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="curso">Telefone </label>
                                    <input type="number" id="telefone" name="telefone" class="form-control" maxlength="12" required>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <a href="<?=SERVERURL?>pessoas/pessoa_lista">
                                <button type="button" class="btn btn-default">Voltar</button>
                            </a>
                            <button type="submit" name="cadastrar" id="cadastrar" class="btn btn-primary float-right">
                                Cadastrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
