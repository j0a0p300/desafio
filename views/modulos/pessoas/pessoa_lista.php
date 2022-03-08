<?php
require_once "./controllers/PessoaController.php";

$pessoaObj = new PessoaController();

$id = $_GET['id'] ?? null;
$pessoas = $pessoaObj->getPessoa($id);
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <div class="card-tools">
                        <a href="<?=SERVERURL?>pessoas/pessoa_cadastra">
                            <button type="button" class="btn btn btn-success">
                                <i class="fas fa-plus"></i> Cadastrar Nova Pessoa
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
                            Lista de Pessoas
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Data de Nascimento</th>
                                <th>Telefone</th>
                                <th>Editar</th>
                                <th>Apagar</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($pessoas as $pessoa):?>
                            <tr>
                                <td><?=$pessoa->nome_pessoa?></td>
                                <td><?=$pessoa->email?></td>
                                <td><?=$pessoaObj->dataParaBR($pessoa->data_nascimento)?></td>
                                <td><?=$pessoa->telefone?></td>
                                <td>
                                    <a href="<?= SERVERURL . "pessoas/pessoa_cadastra&id=" . $pessoaObj->encryption($pessoa->id) ?>"  class="btn bg-gradient-primary btn-sm">
                                        <input type="hidden" name="_method" value="editarPessoa">
                                        <i class="fas fa-user-edit"></i> Editar
                                    </a>
                                </td>
                                <td>
                                    <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/pessoaAjax.php" role="form" data-form="update">
                                        <input type="hidden" name="_method" value="apagaPessoa">
                                        <input type="hidden" name="id" value="<?= $pessoaObj->encryption($pessoa->id)?>">
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
                                <th>Email</th>
                                <th>Data de Nascimento</th>
                                <th>Telefone</th>
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
