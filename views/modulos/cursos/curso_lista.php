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
                                </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($cursos as $curso):?>
                                <tr>
                                    <td><?=$curso->nome?></td>
                                    <td><?=$curso->duracao?> meses</td>
                                    <td><?=$curso->nome_pessoa?></td>
                                    <td><?=$curso->semestre?>° Semestre</td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>Duração(Em meses)</th>
                                    <th>Pessoa Física</th>
                                    <th>Semestre</th>
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
