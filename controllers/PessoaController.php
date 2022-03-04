<?php
/** @var $pedidoAjax */
if ($pedidoAjax) {
    require_once "../models/PessoaModel.php";
} else {
    require_once "./models/PessoaModel.php";
}

class PessoaController extends PessoaModel
{
    public function getPessoa()
    {
        $sql = "SELECT p.id, p.nome_pessoa, p.email, p.data_nascimento, p.telefone 
            FROM pessoas AS p";
        return DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    public function inserePessoa($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('pessoas', $dados);
        if ($insert->rowCount() >= 1) {
            $pessoa_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'pessoas/pessoa_cadastra&id=' . MainModel::encryption($pessoa_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
}