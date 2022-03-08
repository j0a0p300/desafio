<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {

    require_once "../controllers/PessoaController.php";
    $pessoaObj = new PessoaController();

    switch ($_POST['_method']) {
        case "cadastrarPessoa":
            echo $pessoaObj->inserePessoa($_POST);
            break;
        case "apagaPessoa":
            echo $pessoaObj->apagaPessoa($_POST);
            break;
        case "editarPessoa":
            echo $pessoaObj->editaPessoa($_POST);
            break;
    }
}else {
    include_once "../config/destroySession.php";
}