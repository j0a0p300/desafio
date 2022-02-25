<?php
if (isset($pedidoAjax)) {
    if ($pedidoAjax) {
        require_once "../models/DbModel.php";
    } else {
        require_once "./models/DbModel.php";
    }
} else {
    require_once "../../models/DbModel.php";
}

class MainModel extends DbModel
{
    /** <p> Verifica se o valor existe dentro de uma matriz</p>
     * @param mixed $needle
     * <p>Valor a ser procurado</p>
     * @param array $haystack
     * <p>Matriz onde sera procurado o valor</p>
     * @param bool $strict [opcional]
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, verifica também se o tipo é igual</p>
     * @return bool
     * <p>Retorna <strong>TRUE</strong> se o valor é encontrado. Se não, retorna <strong>FALSE</strong></p>
     */
    protected function in_array_r($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }

    /**
     * <p>Encripta a mensagem usando o "openssl_encrypt"</p>
     * @param string $string
     * <p>Mensagem a ser encriptada</p>
     * @return string
     * <p>Retorna o valor já encriptado</p>
     */
    public function encryption($string)
    {
        $output = false;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    /**
     * <p>checa se o campo do parâmetro possuí algum dado, caso não possua, ele retorna "Não cadastrado"
     * @param $campo
     * @return string
     */
    public function checaCampo($campo):string
    {
        if ($campo == NULL || $campo == '') {
            return "Não cadastrado";
        } else {
            return $campo;
        }
    }

    /**
     * <p>Transforma data padrão sql para BR</p>
     * @param string $data
     * <p>Valor deve estar no padrão AAAA-MM-DD</p>
     * @return string
     * <p>Retorna a data no padrão BR. DD/MM/YYYY</p>
     * @throws Exception
     */
    public function dataParaBR($data)
    {
        $novaData = new DateTime($data);
        return $novaData->format('d/m/Y');
    }

    public function dataHora($data)
    {
        $novaData = new DateTime($data);
        return $novaData->format('d/m/Y H:i:s');
    }

    public function hora($hora)
    {
        $timestamp = strtotime($hora);
        return date('H:i', $timestamp);
    }

    public function dataParaSQL($data)
    {
        $data = DateTime::createFromFormat('d/m/Y', $data);
        return $data->format('Y-m-d');
    }

    public function dataHoraParaSQL($data)
    {
        $data = DateTime::createFromFormat('d/m/Y H:i:s', $data);
        return $data->format('Y-m-d H:i:s');
    }

    public function retornaMes($mes){
        switch ($mes) {
            case "01":
                return "Janeiro";
                break;
            case "02":
                return "Fevereiro";
                break;
            case "03":
                return "Março";
                break;
            case "04":
                return "Abril";
                break;
            case "05":
                return "Maio";
                break;
            case "06":
                return "Junho";
                break;
            case "07":
                return "Julho";
                break;
            case "08":
                return "Agosto";
                break;
            case "09":
                return "Setembro";
                break;
            case "10":
                return "Outubro";
                break;
            case "11":
                return "Novembro";
                break;
            case "12":
                return "Dezembro";
                break;
        }
    }

    public function dinheiroParaBr($valor)
    {
        $valor = number_format($valor, 2, ',', '.');
        return $valor;
    }

    public function dinheiroDeBr($valor)
    {
        $valor = str_ireplace(".", "", $valor);
        $valor = str_ireplace(",", ".", $valor);
        return $valor;
    }

    function valorPorExtenso($valor = 0)
    {
        //retorna um valor por extenso
        $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
        $z = 0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        for ($i = 0; $i < count($inteiro); $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];
        $rt = "";

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : " ";
            if ($valor == "000") $z++; elseif ($z > 0) $z--;
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) $r .= (($z > 1) ? " de " : "") . $plural[$t];
            if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : "") . $r;
        }
        return ($rt ? $rt : "zero");
    }

    /**
     * <p>Decripta uma mensagem encriptada com a função "encryption"</p>
     * @param string $string
     * <p>Mensagem a ser decriptada</p>
     * @return string
     * <p>Retorna a mensagem decriptada</p>
     */
    protected function decryption($string)
    {
        if (strlen($string) > 10) {
            $key = hash('sha256', SECRET_KEY);
            $iv = substr(hash('sha256', SECRET_IV), 0, 16);
            $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
            return $output;
        }

        return $string;
    }

    public function gravarLog($descricao)
    {
        self::log($descricao);
    }

    /**
     * Insere registro na tabela "log" do banco de dados
     * @param string $descricao
     * <p>Registramos o comando SQL de <strong>UPDATE</strong> ou <strong>INSERT</strong>,
     * se o usuário <strong>FEZ LOGIN</strong>, ou <strong>FEZ LOGOUT</strong></p>
     */
    protected function log($descricao)
    {
        $dadosLog = [
            'usuario_id' => $_SESSION['usuario_id_s'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'data' => date('Y-m-d H:i:s'),
            'descricao' => $descricao
        ];

        DbModel::insert('log', $dadosLog);
    }

    /**
     * <p>Executa uma série de comandos de tratamento da string para inserção no banco de dados</p>
     * @param string $string
     * <p>Mensagem que será tratada</p>
     * @return mixed|string
     * <p>Retorna a mensagem já tratada</p>
     */
    protected function limparString($string)
    {
        $string = trim($string);
        $string = stripslashes($string);
        $string = str_ireplace("<script>", "", $string);
        $string = str_ireplace("</script>", "", $string);
        $string = str_ireplace("<script src", "", $string);
        $string = str_ireplace("<script type=", "", $string);
        $string = str_ireplace("SELECT * FROM", "", $string);
        $string = str_ireplace("DELETE FROM", "", $string);
        $string = str_ireplace("INSERT INTO", "", $string);
        $string = str_ireplace("--", "", $string);
        $string = str_ireplace("^", "", $string);
        $string = str_ireplace("[", "", $string);
        $string = str_ireplace("]", "", $string);
        $string = str_ireplace("==", "", $string);

        return $string;
    }

    public function exibeModalClassificacaoIndicativa()
    {
        echo "
        <div class='modal fade' id='modal-default'>
    <div class='modal-primary modal-dialog'>
        <div class='modal-content'  style='width: 130%'>
            <div class='modal-header'>
                <h4 class='modal-title'><strong>Classificação Indicativa</strong></h4>
               <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span></button>
            </div>
            <div class='modal-body'>
                <div class='card card-info card-outline'>
                    <table class='table table-responsive'>
                    <tr>
                        <td><img src='../views/dist/img/classificacao/livre.png' width='100px' alt='livre'
                                 class='img-responsive'></td>
                        <td>
                            <p><b>Livre Para Todos Os Públicos</b></p>
                            <p>São admitidos com essa classificação obras que contenham predominantemente
                                conteúdos sem inadequações, como os elencados abaixo:</p>
                            <ul style='list-style-type: none;'>
                                <li><b>Violência:</b> Violência fantasiosa; presença de armas sem violência;
                                    mortes sem violência; ossadas e esqueletos sem violência.
                                </li>

                                <li><b>Sexo e Nudez:</b> Nudez não erótica; ou mesmo sem a presença de nudez;
                                    sem a presença de conteúdo sexual.
                                </li>

                                <li>
                                    <b>Drogas:</b> Consumo moderado ou insinuado de drogas lícitas sem
                                    relevância para a obra.
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td><img src='../views/dist/img/classificacao/10.png' width='100px' alt='livre'
                                 class='img-responsive'></td>
                        <td>
                            <p><b>Não Recomendado Para Menores de Dez Anos</b></p>
                            <p>São admitidos com essa classificação obras que contenham predominantemente
                                conteúdos com inadequações leves, como os elencados abaixo:</p>
                            <ul style='list-style-type: none;'>
                                <li><b>Violência:</b> Presença de armas com intuito de violência; medo/tensão;
                                    angústia; ossadas e esqueletos com resquícios de ato de violência; atos
                                    criminosos sem violência; linguagem depreciativa.
                                </li>

                                <li><b>Sexo e Nudez:</b> Conteúdos educativos sobre sexo.
                                </li>

                                <li>
                                    <b>Drogas:</b> Descrições verbais do consumo de drogas lícitas; discussão
                                    sobre o tema “tráfico de drogas”; uso medicinal de drogas ilícitas.
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td><img src='../views/dist/img/classificacao/12.png' width='100px' alt='livre'
                            ></td>
                        <td>
                            <p><b>Não Recomendado Para Menores de Doze Anos
                                </b></p>
                            <p>São admitidos com essa classificação obras que contenham predominantemente
                                conteúdos com inadequações relativamentes leves, como os elencados abaixo:
                            </p>
                            <ul style='list-style-type: none;'>
                                <li><b>Violência:</b> Ato violento; lesão corporal; descrição de violência;
                                    presença de sangue; sofrimento da vítima; morte natural ou acidental com
                                    violência; ato violento contra animais; exposição ao perigo; exposição de
                                    pessoas em situações constrangedoras ou degradantes; agressão verbal;
                                    obscenidade; bullying; exposição de cadáver; assédio sexual;
                                    supervalorização da beleza física; supervalorização do consumo.
                                </li>

                                <li><b>Sexo e Nudez:</b> Nudez velada; insinuação sexual; carícias sexuais;
                                    masturbação não explícita; palavrões; linguagem de conteúdo sexual;
                                    simulações de sexo; apelo sexual.
                                </li>

                                <li>
                                    <b>Drogas:</b> Consumo de drogas lícitas; indução ao uso de drogas lícitas;
                                    consumo irregular de medicamentos; menção a drogas ilícitas.
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td><img src='../views/dist/img/classificacao/14.png' width='100px' alt='livre'
                                 class='img-responsive'></td>
                        <td>
                            <p><b>Não Recomendado Para Menores de Catorze Anos
                                </b></p>
                            <p>São admitidos com essa classificação obras que contenham predominantemente
                                conteúdos com inadequações moderadas, como os elencados abaixo:

                            </p>
                            <ul style='list-style-type: none;'>
                                <li><b>Violência:</b> Morte intencional; preconceito.
                                </li>

                                <li><b>Sexo e Nudez:</b> Nudez moderada; erotização; vulgaridade; relação
                                    sexual; prostituição.
                                </li>

                                <li>
                                    <b>Drogas:</b> Insinuação do consumo de drogas ilícitas; bebidas alcoólicas;
                                    descrições verbais do consumo e tráfico de drogas ilícitas; discussão sobre
                                    “descriminalização de drogas ilícitas”.
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td><img src='../views/dist/img/classificacao/16.png' width='100px' alt='livre'
                                 class='img-responsive'></td>
                        <td>
                            <p><b>Não Recomendado Para Menores de Dezesseis Anos
                                </b></p>
                            <p>São admitidos com essa classificação obras que contenham predominantemente
                                conteúdos com inadequações intensas, como os elencados abaixo:


                            </p>
                            <ul style='list-style-type: none;'>
                                <li><b>Violência:</b> Exploração sexual; coação sexual; estupro; suicídio;
                                    tortura; mutilação; desmembramento; violência gratuita/banalização da
                                    violência; aborto; pena de morte; eutanásia.
                                </li>

                                <li><b>Sexo e Nudez:</b> Nudez total; relação sexual intensa/de longa duração.
                                </li>

                                <li>
                                    <b>Drogas:</b> Produção ou tráfico de qualquer droga ilícita; consumo de
                                    drogas ilícitas; indução ao consumo de drogas ilícitas.
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td><img src='../views/dist/img/classificacao/18.png' width='100px' alt='livre'
                                 class='img-responsive'></td>
                        <td>
                            <p><b>Não Recomendado Para Menores de Dezoito Anos


                                </b></p>
                            <p>São admitidos com essa classificação obras que contenham predominantemente
                                conteúdos com inadequações extremas, como os elencados abaixo:
                            </p>
                            <ul style='list-style-type: none;'>
                                <li><b>Violência:</b> Violência de forte impacto; elogio ou apologia da
                                    violência; crueldade; crimes de ódio; pedofilia.
                                </li>

                                <li><b>Sexo e Nudez:</b> Sexo explícito; situações sexuais complexas/de forte
                                    impacto (incesto, sexo grupal, fetiches violentos e Pornografia).
                                </li>

                                <li>
                                    <b>Drogas:</b> Elogio ou apologia ao uso de drogas ilícitas.
                                </li>
                            </ul>
                        </td>
                    </tr>
                </table>
                </div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-primary' data-dismiss='modal'>Fechar</button>
            </div>
        </div>
    </div>
</div>";
    }

    /**
     * <p>Executa a função "limparString" em um array</p>
     * @param array $post
     * <p>Array de dados que deve ser tratado</p>
     * @return array
     * <p>Retorna os dados já tratados</p>
     */
    protected function limpaPost($post)
    {
        $dados = [];
        foreach ($post as $campo => $value) {
            $dados[$campo] = self::limparString($value);
        }
        return $dados;
    }

    /**
     * <p>Gera options para a tag <i>select</i> a partir dos registros de uma tabela</p>
     * @param string $tabela
     * <p>Nome da tabela que deve ser consultada</p>
     * @param string $selected [opcional]
     * <p>Valor a qual deve vir selecionado</p>
     * @param bool $publicado [opcional]
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, busca valores onde a coluna <i>publicado</i> seja 1</p>
     * @param bool $orderPorId [opcional]
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, ordena a lista por ordem de ID</p>
     * @param bool $capac [opcional]
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, faz a consulta no banco de dados do sistema CAPAC</p>
     */
    public function geraOpcao($tabela, $selected = "", $publicado = false, $orderPorId = false, $capac = false)
    {
        $publicado = $publicado ? 'WHERE publicado = 1' : '';
        $order = $orderPorId ? 1 : 2;
        $sql = "SELECT * FROM $tabela $publicado ORDER BY $order";
        $consulta = DbModel::consultaSimples($sql, $capac);
        if ($consulta->rowCount() >= 1) {
            foreach ($consulta->fetchAll() as $option) {
                if ($option[0] == $selected) {
                    echo "<option value='" . $option[0] . "' selected >" . $option[1] . "</option>";
                } else {
                    echo "<option value='" . $option[0] . "'>" . $option[1] . "</option>";
                }
            }
        }
    }

    public function geraOpcaoVigencia($tabela, $selected = "", $capac = false)
    {
        $sql = "SELECT * FROM $tabela WHERE publicado = 1";
        $consulta = DbModel::consultaSimples($sql, $capac);
        if ($consulta->rowCount() >= 1) {
            foreach ($consulta->fetchAll() as $option) {
                if ($option[0] == $selected) {
                    echo "<option value='" . $option[0] . "' selected >" . $option[2] . "</option>";
                } else {
                    echo "<option value='" . $option[0] . "'>" . $option[2] . "</option>";
                }
            }
        }
    }

    public function geraOpcaoContratacao($selected = "", $capac = false)
    {
        $sql = "SELECT * FROM tipos_contratacoes WHERE id >= 8";
        $consulta = DbModel::consultaSimples($sql, $capac)->fetchAll(PDO::FETCH_OBJ);
        foreach ($consulta as $option) {
            if ($option->id == $selected) {
                echo "<option value='" . $option->id . "' selected >" . $option->tipo_contratacao . "</option>";
            } else {
                echo "<option value='" . $option->id . "'>" . $option->tipo_contratacao . "</option>";
            }
        }
    }

    public function geraOpcaoUsuario($selected = "", $fiscal, $orderPorId = false, $capac = false)
    {
        $order = $orderPorId ? 1 : 2;
        $fiscal = isset($fiscal) ? "AND fiscal = 1" : "";
        $sql = "SELECT * FROM usuarios WHERE publicado = 1 $fiscal ORDER BY $order";
        $consulta = DbModel::consultaSimples($sql, $capac);
        if ($consulta->rowCount() >= 1) {
            foreach ($consulta->fetchAll() as $option) {
                if ($option[0] == $selected) {
                    echo "<option value='" . $option[0] . "' selected >" . $option[1] . "</option>";
                } else {
                    echo "<option value='" . $option[0] . "'>" . $option[1] . "</option>";
                }
            }
        }
    }

    /**
     * <p>Transforma os registros de uma tabela em inputs tipo checkbox, ajustados em duas colunas</p>
     * @param string $tabela
     * <p>Tabela para qual os registros deve ser os checkboxes.
     * <strong>Importante:</strong> o valor desta variável será
     * o valor do atributo <i>name</i> dos inputs</p>
     * @param string $tabelaRelacionamento
     * <p>Tabela de relacionamento onde deve procurar os valores
     * já cadastrados para determinado Evento / Atração</p>
     * @param string $colunaEntidadeForte
     * <p>Nome da coluna que representa a <strong>entidade forte</strong> na tabela de relacionamento</p>
     * @param null|int $idEntidadeForte [opcional]
     * <p>ID da entidade forte. <b>NULL</b> por padrão, quando informado,
     * busca os registros na tabela de relacionamento</p>
     * @param bool $publicado [opcional]
     * <p><b>FALSE</b> por padrão. Quando <b>TRUE</b>,
     * adiciona a clausula <i>"WHERE publicado = 1"
     * na listagem dos registros do checkbox</i></p>
     */
    public function geraCheckbox($tabela, $tabelaRelacionamento, $colunaEntidadeForte, $idEntidadeForte = null, $publicado = false)
    {
        $publicado = $publicado ? "WHERE publicado = '1'" : "";
        $sql = "SELECT * FROM $tabela $publicado ORDER BY 2";
        $consulta = DbModel::consultaSimples($sql);

        // Parte do relacionamento
        $sqlConsultaRelacionamento = "SELECT * FROM $tabelaRelacionamento WHERE $colunaEntidadeForte = '$idEntidadeForte'";
        $relacionamentos = DbModel::consultaSimples($sqlConsultaRelacionamento)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($consulta->fetchAll(PDO::FETCH_NUM) as $checkbox) {
            foreach ($relacionamentos as $key => $item) {
                if (isset($item[$colunaEntidadeForte])) {
                    unset($relacionamentos[$key][$colunaEntidadeForte]);
                }
            }
            ?>
            <div class='checkbox-grid-2'>
                <div class='form-check'>
                    <input class='form-check-input <?= $tabela ?>' type='checkbox' name='<?= $tabela ?>[]'
                           value='<?= $checkbox[0] ?>' <?= self::in_array_r($checkbox[0], $relacionamentos) ? "checked" : "" ?>>
                    <label class='form-check-label'><?= $checkbox[1] ?></label>
                </div>
            </div>
            <?php
        }
    }

    /**
     * <p>Exibe um alerta da Tanair</p>
     * @param array $dados
     * <p>Um array que deve conter os seguintes índices:</p>
     *  <li>alerta - deve conter os valores: <strong>simples</strong>, <strong>sucesso</strong>,
     * <strong>limpar</strong> ou <strong>arquivos</strong></li>
     *  <li>titulo - Texto que será usado como título do alerta</li>
     *  <li>texto - Texto que será usado no corpo do alerta</li>
     *  <li>tipo - Tipo do alerta. Deve conter os valores: <strong>success</strong>, <strong>error</strong>,
     * <strong>warning</strong>, <strong>info</strong> ou <strong>question</strong></li>
     * <li>location - Caso o alerta seja <strong>sucesso</strong> ou <strong>arquivos</strong>,
     * este índice deve conter a página para qual o usuário
     * será retornado</li>
     * @return string
     * <p>Retorna o alerta</p>
     */
    protected function sweetAlert($dados)
    {
        if ($dados['alerta'] == "simples") {
            $alerta = " <script> 
                            Swal.fire(
                                '{$dados['titulo']}',
                                '{$dados['texto']}',
                                '{$dados['tipo']}'
                            ); 
                        </script>
                        ";


        } elseif ($dados['alerta'] == "sucesso") {
            $redireciona = isset($dados['redirecionamento']) ? "window.open('{$dados['redirecionamento']}','_blank')" : '';
            $alerta = "
                    <script>
                        Swal.fire({
                          title: '{$dados['titulo']}',
                          html: '{$dados['texto']}',
                          type: '{$dados['tipo']}',
                          allowOutsideClick: false,
                            allowEscapeKey: false,
                            showCancelButton: false,
                          confirmButtonText: 'Confirmar'
                        }).then(function() {
                            {$redireciona};
                            window.location.href = '{$dados['location']}';
                        });
                    </script>
                ";
        } elseif ($dados['alerta'] == "limpar") {
            $alerta = "
                    <script>
                        Swal.fire({
                          title: '{$dados['titulo']}',
                          text: '{$dados['texto']}',
                          type: '{$dados['tipo']}',
                          confirmButtonText: 'Confirmar'
                        }).then(function() {
                          $('.FormularioAjax')[0].reset;
                        });
                    </script>
                ";
        } elseif ($dados['alerta'] == "arquivos") {
            $alerta = sprintf("
                    <script>
                        Swal.fire({
                          title: '{$dados['titulo']}',
                          html: %s,
                          type: '{$dados['tipo']}',
                          allowOutsideClick: false,
                            allowEscapeKey: false,
                            showCancelButton: false,
                          confirmButtonText: 'Confirmar'
                        }).then(function() {
                          window.location.href = '{$dados['location']}';
                        });
                    </script>
                ",
                is_array($dados['texto']) ? implode(" + ", $dados['texto']) . " + 'Os demais arquivos foram enviados!'" : "'{$dados['texto']}'"
            );
        }

        return $alerta;
    }

    /**
     * Verifica a tabela de relacionamento passada e atualiza conforme os dados informados
     * @param string $tabela <p>Nome da tabela de relacionamento</p>
     * @param string $entidadeForte <p>Nome da coluna que representa a entidade forte <i>(tabela principal)</i></p>
     * @param int $idEntidadeForte <p>ID da entidade forte</p>
     * @param string $entidadeFraca <p>Nome da coluna que representa a entidade fraca <i>(tabela auxiliar)</i></p>
     * @param int|array $idsEntidadeFraca <p>Array com os IDs da entidade fraca</p>
     * @return bool
     */
    protected function atualizaRelacionamento($tabela, $entidadeForte, $idEntidadeForte, $entidadeFraca, $idsEntidadeFraca, $capac = false)
    {
        /* Consulta a tabela de relacionamento
        para verificar se existe algum registro
        para a entidade forte informada */
        $sqlConsultaRelacionamento = "SELECT $entidadeFraca FROM $tabela WHERE $entidadeForte = '$idEntidadeForte'";
        $relacionamento = DbModel::consultaSimples($sqlConsultaRelacionamento, $capac);

        /* Se não existe nenhum registro,apenas insere um para cada id de entidade fraca */
        if ($relacionamento->rowCount() == 0) {
            /* Verifica se o ID da entidade fraca está em um array */
            if (is_array($idsEntidadeFraca)) {
                foreach ($idsEntidadeFraca as $checkbox) {
                    $dadosInsert = [
                        $entidadeForte => $idEntidadeForte,
                        $entidadeFraca => $checkbox
                    ];
                    $insert = DbModel::insert($tabela, $dadosInsert, $capac);
                    if ($insert->rowCount() == 0) {
                        return false;
                    }
                }
            } else {
                $dadosInsert = [
                    $entidadeForte => $idEntidadeForte,
                    $entidadeFraca => $idsEntidadeFraca
                ];
                $insert = DbModel::insert($tabela, $dadosInsert, $capac);
                if ($insert->rowCount() == 0) {
                    return false;
                }
            }
            return true;
        } else {
            $relacionamentos = $relacionamento->fetchAll(PDO::FETCH_COLUMN);
            /* Se existe registros, primeiro, verifica se
            na tabela existe algum que não tenha sido
            passado nos IDs da entidade fraca.
            Cada registro que não possui ID passado é excluído */
            if (is_array($idsEntidadeFraca)) {
                foreach ($relacionamentos as $item) {
                    if (!in_array($item, $idsEntidadeFraca)) {
                        $delete = DbModel::consultaSimples("DELETE FROM $tabela WHERE $entidadeForte = '$idEntidadeForte' AND $entidadeFraca = $item", $capac);
                        if ($delete->rowCount() == 0) {
                            return false;
                        }
                    }
                }

                /* Após excluir os registros que não possuem ID passado,
                verifica se dos IDs informados, existe algum que não
                tenha registro. Caso sim, insere um novo */
                foreach ($idsEntidadeFraca as $checkbox) {
                    if (!in_array($checkbox, $relacionamentos)) {
                        $dadosInsert = [
                            $entidadeForte => $idEntidadeForte,
                            $entidadeFraca => $checkbox
                        ];
                        $insertNovo = DbModel::insert($tabela, $dadosInsert, $capac);
                        if ($insertNovo->rowCount() == 0) {
                            return false;
                        }
                    }
                }
            } else {
                if (!in_array($idsEntidadeFraca, $relacionamentos)) {
                    $delete = DbModel::consultaSimples("DELETE FROM $tabela WHERE $entidadeForte = '$idEntidadeForte'", $capac);
                    if ($delete->rowCount() == 0) {
                        return false;
                    }
                    $dadosInsert = [
                        $entidadeForte => $idEntidadeForte,
                        $entidadeFraca => $idsEntidadeFraca
                    ];
                    $insert = DbModel::insert($tabela, $dadosInsert, $capac);
                    if ($insert->rowCount() == 0) {
                        return false;
                    }
                }
            }

            return true;
        }
    }

    protected function retiraAcentos($string)
    {
        $newstring = preg_replace("/[^a-zA-Z0-9_.]/", "", strtr($string, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
        return $newstring;
    }

    public function verificaCenica($idEvento)
    {
        $idEvento = MainModel::decryption($idEvento);
        $acoes = DbModel::consultaSimples("SELECT aa.acao_id FROM atracoes AS at INNER JOIN acao_atracao aa on at.id = aa.atracao_id WHERE at.publicado = 1 AND at.evento_id = '$idEvento'")->fetchAll(PDO::FETCH_ASSOC);
        $i = false;
        foreach ($acoes as $acao) {
            if ($acao['acao_id'] == 2 || $acao['acao_id'] == 3 || $acao['acao_id'] == 11) {
                $i = true;
            }
        }
        return $i;
    }

    public function existeErro($erros)
    {
        $erro = MainModel::in_array_r(true, $erros, true);
        if ($erro) {
            foreach ($erros as $key => $item) {
                if ($erro != false) {
                    if ($item['bol']) {
                        $validacao[] = $item['motivo'];
                    }
                }
            }
            return $validacao;
        } else {
            return false;
        }
    }

    public function gerarProtocolo($id, $edital)
    {
        $edit = $this->decryption($edital);
        return date("Ymd") . "." . $id . "-" . $edit;
    }

    //gerar protocolo para evento, formação e emia
    function geraProtocoloEFE($id)
    {
        $date = date('Ymd');
        $preencheZeros = str_pad($id, 5, '0', STR_PAD_LEFT);
        return $date . '.' . $preencheZeros;
    }

    public function formataValidacaoErros($erros)
    {
        $erro = MainModel::in_array_r(true, $erros, true);
        if ($erro) {
            foreach ($erros as $key => $erro) {
                if ($erro != false) {
                    foreach ($erro as $item) {
                        if ($item['bol']) {
                            $validacao[$key][] = $item['motivo'];
                        }
                    }
                }
            }
            return $validacao;
        } else {
            return false;
        }
    }

    public function validaData($data, $hora = false):string
    {
        if ($hora == true){
            if ($data == "0000-00-00 00:00:00" || $data == null){
                $retornaData = "não cadastrado";
            } else{
                $retornaData = date('d/m/Y H:i:s', strtotime($data));
            }
        } else{
            if ($data == "0000-00-00" || $data == null){
                $retornaData = "não cadastrado";
            } else{
                $retornaData = date('d/m/Y', strtotime($data));
            }
        }
        return $retornaData;
    }

    //retorna sim para campos valo = 1 e não para campos valor=0
    public function simNao($campo):string
    {
        if ($campo == 1 ) {
            return "Sim";
        } else {
            return "Não";
        }
    }
}