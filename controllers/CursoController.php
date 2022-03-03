<?php
/** @var $pedidoAjax */
if ($pedidoAjax) {
    require_once "../models/CursoModel.php";
} else {
    require_once "./models/CursoModel.php";
}

class CursoController extends CursoModel
{
    public function getCurso()
    {
        $sql = "SELECT c.id, c.nome, c.duracao, cp.semestre, p.nome_pessoa
            FROM cursos AS c
            INNER JOIN cursos_pessoas AS cp ON c.id = cp.cursos_id
            INNER JOIN pessoas AS p ON p.id = cp.pessoa_fisicas_id";

        return DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);
    }
}