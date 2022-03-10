<?php
/** @var $pedidoAjax */
if ($pedidoAjax) {
    require_once "../models/CursoModel.php";
} else {
    require_once "./models/CursoModel.php";
}

class CursoController extends CursoModel
{
    public function getCurso($id)
    {
        $sql = "SELECT c.id, c.nome, c.duracao, cp.semestre, p.nome_pessoa
            FROM cursos AS c
            INNER JOIN cursos_pessoas AS cp ON c.id = cp.cursos_id
            INNER JOIN pessoas AS p ON p.id = cp.pessoa_fisicas_id
            WHERE c.publicado = 1";

        return DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    public function insereCurso($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('cursos', $dados);
        if ($insert->rowCount() >= 1) {
            $curso_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Curso Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'cursos/curso_cadastra&id=' . MainModel::encryption($curso_id)
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

    public function insereSemestre($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('cursos_pessoas', $dados);
        if ($insert->rowCount() >= 1) {
            $curso_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Curso Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'cursos/curso_cadastra&id=' . MainModel::encryption($curso_id)
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

    public function apagaCurso($id):string
    {
        $id = MainModel::decryption($id);
        $apaga = DbModel::apaga("cursos", $id);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Curso',
                'texto' => 'Dados apagados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'cursos/curso_lista'
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

    public function editaCurso(array $post):string
    {
        $curso_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('cursos', $dados, $curso_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Curso',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'cursos/curso_cadastra&id=' . MainModel::encryption($curso_id)
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

    public function recuperaCurso($id){
        $id = MainModel::decryption($id);
        $sql = "SELECT c.id, c.nome, cp.semestre, p.nome_pessoa, c.duracao
                FROM cursos AS c 
                INNER JOIN cursos_pessoas AS cp ON cp.cursos_id
                INNER JOIN pessoas AS p ON p.id = cp.pessoa_fisicas_id
                WHERE c.id = $id GROUP BY c.id";
        return DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);
    }

}