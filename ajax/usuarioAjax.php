<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/UsuarioController.php";
    $insUsuario = new UsuarioController();

    if ($_POST['_method'] == "insereNovoUsuario"){
        if (isset($_POST['nome']) && (isset($_POST['senha']))) {
            echo $insUsuario->insereUsuario();
        }
    }

} else {
    include_once "../config/destroySession.php";
}