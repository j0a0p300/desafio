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
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <div class="card-tools">
                        <a href="<?=SERVERURL?>cursos/curso_cadastra">
                            <button type="button" class="btn btn btn-success">
                                <i class="fas fa-plus"></i> Cadastrar Novo Curso
                            </button>
                        </a>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            Lista de Cursos
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Duração(Em meses)</th>
                                    <th>Pessoa Física</th>
                                    <th>Semestre</th>
                                    <th>Editar</th>
                                    <th>Apagar</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($cursos as $curso):?>
                                <tr>
                                    <td><?=$curso->nome?></td>
                                    <td><?=$curso->duracao?> meses</td>
                                    <td><?=$curso->nome_pessoa?></td>
                                    <td><?=$curso->semestre?>° Semestre</td>
                                    <td>
                                        <a href="<?= SERVERURL . "cursos/curso_cadastra&id=" . $cursoObj->encryption($curso->id) ?>"  class="btn bg-gradient-primary btn-sm">
                                            <input type="hidden" name="_method" value="editarCurso">
                                            <i class="fas fa-user-edit"></i> Editar
                                        </a>
                                    </td>
                                    <td>
                                        <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/cursoAjax.php" role="form" data-form="update">
                                            <input type="hidden" name="_method" value="apagaCurso">
                                            <input type="hidden" name="id" value="<?= $cursoObj->encryption($curso->id)?>">
                                            <button type="submit" class="btn bg-gradient-danger btn-sm">
                                                <i class="fas fa-trash"></i> Apagar
                                            </button>
                                            <div class="resposta-ajax"></div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>Duração(Em meses)</th>
                                    <th>Pessoa Física</th>
                                    <th>Semestre</th>
                                    <th>Editar</th>
                                    <th>Apagar</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
