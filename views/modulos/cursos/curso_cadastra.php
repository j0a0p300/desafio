<?php
require_once "./controllers/CursoController.php";
$cursoObj = new CursoController();

$id = $_GET['id'] ?? null;
$cursos = $cursoObj->getCurso($id);
?>
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
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/CursoAjax.php"
                          role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarCurso" : "cadastrarCurso" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="curso_id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="curso">Nome</label>
                                    <input type="text" id="nome" name="nome" class="form-control" required>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="curso">Duração(Em meses)</label>
                                    <input type="text" id="duracao" name="duracao" class="form-control" required>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <a href="<?=SERVERURL?>cursos/curso_lista">
                                <button type="button" class="btn btn-default">Voltar</button>
                            </a>
                            <button type="submit" name="cadastrarCurso" id="cadastrarCurso" class="btn btn-primary float-right">
                                Cadastrar
                            </button>
                        </div>
                        <div class="resposta-ajax"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
