<?php
/** @var $pedidoAjax */
if ($pedidoAjax) {
    require_once "../models/UsuarioModel.php";
} else {
    require_once "./models/UsuarioModel.php";
}

class UsuarioController extends UsuarioModel
{
    /** <p>Para logar no sistema</p>
     * @param $modulo
     * @param $edital
     * @return string
     */
    public function iniciaSessao($modulo = false, $edital = null)
    {
        $email = MainModel::limparString($_POST['usuario']);
        $senha = MainModel::limparString($_POST['senha']);
        $senha = MainModel::encryption($senha);

        $dadosLogin = [
            'usuario' => $email,
            'senha' => $senha
        ];

        $consultaUsuario = UsuarioModel::getUsuario($dadosLogin);

        if ($consultaUsuario->rowCount() == 1) {
            $usuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);
            session_start(['name' => 'cursos']);
            $_SESSION['login_g'] = $usuario['nome'];
            $_SESSION['nome_g'] = $usuario['nome'];
            $_SESSION['usuario_id_g'] = $usuario['id'];

            if (!$modulo) {
                return $urlLocation = "<script> window.location='inicio/inicio' </script>";
            } else {
                if ($modulo == 8) {
                    $_SESSION['edital_s'] = $edital;
                    return $urlLocation = "<script> window.location='fomentos/inicio&modulo=$modulo' </script>";
                }
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Usuário / Senha incorreto',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    /**
     * <p>Para deslogar do sistema</p>
     * @return void
     */
    public function forcarFimSessao()
    {
        session_destroy();
        return header("Location: ".SERVERURL);
    }

    /**
     * <p>Retorna os dados do usuário</p>
     * @param $id
     * @return bool|PDOStatement
     */
    public function recuperaUsuario($id)
    {
        return DbModel::getInfo('usuarios',$id);
    }
   
}
