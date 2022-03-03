<?php


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
                                    <th>Duração</th>
                                    <th>Pessoa Física</th>
                                    <th>Semestre</th>
                                    <th>Local</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>Duração</th>
                                    <th>Pessoa Física</th>
                                    <th>Semestre</th>
                                    <th>Local</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="<?=SERVERURL?>contrato/pesquisa_contratos" class="btn btn-default">
                                    Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
