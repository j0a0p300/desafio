<?php
/** @var $pedidoAjax */
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class UsuarioModel extends MainModel
{
    protected function getUsuario($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM usuarios WHERE nome = :nome AND senha = :senha";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":nome", $dados['usuario']);
        $statement->bindParam(":senha", $dados['senha']);
        $statement->execute();
        return $statement;
    }
}