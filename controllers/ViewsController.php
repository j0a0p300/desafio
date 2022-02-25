<?php
require_once "./models/ViewsModel.php";

class ViewsController extends ViewsModel
{
    private function recuperaViewAtiva()
    {
        $url = explode("/", $_GET['views']);

        $rota = [
            "view" => $url[1] ?? "",
            "modulo" => $url[0] ?? ""
        ];

        return $rota;
    }

    public function exibirTemplate()
    {
        include "views/template/master.php";
    }

    public function navbar()
    {
        include "views/template/navbar.php";
    }

    public function sidebar()
    {
        return "views/template/sidebar.php";
    }

    public function footer()
    {
        include "views/template/footer.php";
    }

    public function exibirViewController()
    {
        if (isset($_GET['views'])) {
            $url = explode("/", $_GET['views']);

            $rota = [
                "view" => $url[1] ?? "",
                "modulo" => $url[0] ?? ""
            ];

            $resposta = ViewsModel::exibirViewModel($rota['view'], $rota['modulo']);
        } else {
            $resposta = "index";
        }
        return $resposta;
    }

    public function exibirMenuController()
    {
        if (isset($_GET['views'])) {
            $url = explode("/", $_GET['views']);

            $rota = [
                "view" => $url[1] ?? "",
                "modulo" => $url[0] ?? ""
            ];

            $resposta = ViewsModel::exibirMenuModel($rota['modulo']);
        } else {
            $resposta = "menuPadrao";
        }
        return $resposta;
    }

    public function retornaMenuAtivo()
    {
        $rota = self::recuperaViewAtiva();
        if ($rota['view'] == "") {
            $ativo = "inicio";
        } else {
            $ativo = $rota['view'];
        }

        $script = "<script type='application/javascript'>
                        $(document).ready(function () {
                        let alvo = $('#$ativo');
                        let elemPai = alvo.parent().parent().parent();
                        
                        $('.nav-link').removeClass('active');
                        
                        if (elemPai.children('a .nav-link')) {
                            elemPai.addClass('menu-open');
                            elemPai.children('a').addClass('active');    
                        }
                        
                        alvo.addClass('active');
                    });
                    </script>";

        return $script;
    }

    public function listaModulos($perfil_id)
    {
        return parent::recuperaModulos($perfil_id);
    }

    public function getCor($cor_id)
    {
        return (new DbModel)->consultaSimples("SELECT `text-color` FROM cores WHERE id = '$cor_id'")->fetch(PDO::FETCH_ASSOC)['text-color'];
    }

    public function listaAvisos()
    {
        return (new DbModel)->consultaSimples("SELECT * FROM avisos WHERE publicado = '1'")->fetchAll(PDO::FETCH_OBJ);
    }

    public function exibeJivoChat($view)
    {
        $naoExibir = ['index', 'login', 'cadastro', 'recupera_senha', 'resete_senha'];
        if (!in_array($view, $naoExibir)) {
            return '<script src="//code.jivosite.com/widget/eOXbKuMDQM" async></script>';
        } else {
            return '';
        }
    }
    public function recuperaDescModulos($sigla)
    {
        if($sigla != 'fomentos' && $sigla != 'inicio')
            return parent::recuperaDescModulos($sigla)->descricao;
        else
            return $sigla;
    }

}