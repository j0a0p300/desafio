<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {

    require_once "../controllers/CursoController.php";
    $cursoObj = new CursoController();

    switch ($_POST['_method']) {
        case "cadastrarCurso":
            echo $cursoObj->insereCurso($_POST);
            break;
        case "apagaCurso":
            echo $cursoObj->apagaCurso($_POST);
            break;
        case "editarPessoa":
            echo $cursoObj->editaCurso($_POST);
            break;
    }
}else {
    include_once "../config/destroySession.php";
}