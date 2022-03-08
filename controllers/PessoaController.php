<?php
/** @var $pedidoAjax */
if ($pedidoAjax) {
    require_once "../models/PessoaModel.php";
} else {
    require_once "./models/PessoaModel.php";
}

class PessoaController extends PessoaModel
{
    public function getPessoa($id)
    {
        $sql = "SELECT p.id, p.nome_pessoa, p.email, p.data_nascimento, p.telefone 
            FROM pessoas AS p WHERE p.publicado = 1";
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
                'location' => SERVERURL . 'pessoas/pessoa_lista&id=' . MainModel::encryption($pessoa_id)
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

    public function apagaPessoa($id):string
    {
        $id = MainModel::decryption($id);
        $apaga = DbModel::apaga("pessoas", $id);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa',
                'texto' => 'Dados apagados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'pessoas/pessoa_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaPessoa(array $post):string
    {
        $pessoa_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('pessoas', $dados, $pessoa_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Linguagem',
                'texto' => 'Dados alterados com sucesso!',
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

    public function recuperaPessoa($id){
        $id = MainModel::decryption($id);
        return DbModel::getInfo('pessoas', $id)->fetchObject();
    }
}