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

    public function insereUsuario() {
        $erro = false;
        $dados = [];
        $camposIgnorados = ["senha2", "_method"];
        foreach ($_POST as $campo => $post) {
            if (!in_array($campo, $camposIgnorados)) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }

        $perfil_id = parent::getPerfil($dados['perfil']);
        unset($dados['perfil']);

        if ($perfil_id) {
            $dados['perfil_id'] = $perfil_id;
        } else {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "Código informado não existe no sistema",
                'tipo' => "error"
            ];
        }

        // Valida Senha
        if ($_POST['senha'] != $_POST['senha2']) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "As senhas inseridas não conferem. Tente novamente",
                'tipo' => "error"
            ];
        }

        // Valida email unique
        $consultaEmail = DbModel::consultaSimples("SELECT email FROM usuarios WHERE email = '{$dados['email']}'");
        if ($consultaEmail->rowCount() >= 1) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "Email inserido já cadastrado. Tente novamente.",
                'tipo' => "error"
            ];
        }

        if (strpos($dados['usuario'],'d') === 0){
            $dados['fiscal'] = 1;
        }

        if (!$erro) {
            $dados['senha'] = MainModel::encryption($dados['senha']);
            $insereUsuario = DbModel::insert('usuarios', $dados);
            if ($insereUsuario) {
                $usuario_id = DbModel::connection()->lastInsertId();
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Usuário Cadastrado!',
                    'texto' => 'Usuário cadastrado com Sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL
                ];
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => "Erro!",
                    'texto' => "Erro ao inserir os dados no sistema. Tente novamente",
                    'tipo' => "error"
                ];
            }
        }
        return MainModel::sweetAlert($alerta);
    }
   
}
