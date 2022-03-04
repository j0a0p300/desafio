<?php
/** @var $pedidoAjax */
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class PessoaModel extends MainModel{

}