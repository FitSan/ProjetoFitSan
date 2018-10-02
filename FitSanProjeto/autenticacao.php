<?php
ob_start(); //gravar todas as saídas de texto em um local temporário antes de jogar para o navegador.
session_start(); 

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_STRICT & ~E_DEPRECATED);// Definindo para mostrar todos os erros exceto notificações, avisos, interoperabilidade e obsoletos. 

ini_set('default_charset', 'utf-8');
ini_set('default_mimetype', 'text/html');

require_once './bancodedados/conectar.php';

/**
 * 
 * @param $username será o identificador da sessão
 */
function logar($email, $tipo = null, $nome = null, $id = null) {
    if (is_array($email)){
        foreach ($email as $campo => $valor){
            if ($campo == 'senha') continue;
            $_SESSION[$campo] = $valor;
        }
    } else {
        $_SESSION['email'] = $email;
        $_SESSION['tipo'] = $tipo;
        $_SESSION['nome'] = $nome;
        $_SESSION['id'] = $id;
    }
    iniciarTempoSessao();
}

function deslogar() {
    session_destroy();
}

function estaLogado() {
    return isset($_SESSION['email']);
}

function getTipo() {
    if (empty($_SESSION['tipo'])) return 'admin';
    return $_SESSION['tipo'];
}

function tipoLogado() {
    $tipos = func_get_args();
    if (is_array($tipos[0])) $tipos = $tipos[0];
    $logado = getTipo();
    foreach ($tipos as $tipo) {
        if ($logado == $tipo) return true;
    }
    return false;
}

function sessaoExpirada() {
    if ($_SESSION['tempo'] < time()) {
        //esta dentro do tempo da sessao
        return true;
    } else {
        //reiniciar a sessao 
        iniciarTempoSessao();
        return false;
    }
}

function autenticar() {
    //se NAO estaLogado ou sessaoExpirada 
    if (!estaLogado() || sessaoExpirada()) {
        header('Location: form_login.php');
    } else {
        return true;
    }
}

function exibirName($completo = false) {
    if ($completo){
        return ($_SESSION['nome'] . ' ' . $_SESSION['sobrenome']);
    } else {
        return $_SESSION['nome'];
    }
}

function iniciarTempoSessao() {
    $_SESSION['tempo'] = time() + 10000;
}

function calculaidade($datanasc) {
    $datanasc = dataParse($datanasc);
    $idade = time() - $datanasc;
    return floor($idade / 31557600);
}

/* REMOVER ESTA FUNÇÃO E COLOCAR A DE BAIXO
function converte_data($datanasc) {
    if (strstr($datanasc, "/")) {
        $A = explode("/", $datanasc);
        $V_data = $A[2] . "-" . $A[1] . "-" . $A[0];
    } else {
        $A = explode("-", $datanasc);
        $V_data = $A[2] . "/" . $A[1] . "/" . $A[0];
    }
    return $V_data;
}
*/

// Converte a data em string para data do PHP
function dataParse($data) {

    // Data no formato unixtime usado no PHP
    if (is_numeric($data)) return intval($data);

    // Limpa espaços antes e depois do texto
    $data = trim($data);

    // Expressão regular para interpretar data e hora no formato DD/MM/YYYY HH:MM:SS (Ex.: 12/12/2018 15:00:00)
    if (preg_match('{^(?P<d>\d{2})\D+(?P<m>\d{2})\D+(?P<y>\d{4})\D+(?P<h>\d{2})\D+(?P<i>\d{2})\D+(?P<s>\d{2}).*$}', $data, $match)) $dt = $match;

    // Expressão regular para interpretar data e hora no formato YYYY-MM-DD HH:MM:SS (Ex.: 12/12/2018 15:00:00)
    elseif (preg_match('{^(?P<y>\d{4})\D+(?P<m>\d{2})\D+(?P<d>\d{2})\D+(?P<h>\d{2})\D+(?P<i>\d{2})\D+(?P<s>\d{2}).*$}', $data, $match)) $dt = $match;

    // Expressão regular para interpretar data e hora no formato DD/MM/YYYY HH:MM (Ex.: 12/12/2018 15:00)
    elseif (preg_match('{^(?P<d>\d{2})\D+(?P<m>\d{2})\D+(?P<y>\d{4})\D+(?P<h>\d{2})\D+(?P<i>\d{2}).*$}', $data, $match)) $dt = $match;

    // Expressão regular para interpretar data e hora no formato YYYY-MM-DD HH:MM (Ex.: 12/12/2018 15:00)
    elseif (preg_match('{^(?P<y>\d{4})\D+(?P<m>\d{2})\D+(?P<d>\d{2})\D+(?P<h>\d{2})\D+(?P<i>\d{2}).*$}', $data, $match)) $dt = $match;

    // Expressão regular para interpretar data no formato DD/MM/YYYY (Ex.: 12/12/2018)
    elseif (preg_match('{^(?P<d>\d{2})\D+(?P<m>\d{2})\D+(?P<y>\d{4}).*$}', $data, $match)) $dt = $match;

    // Expressão regular para interpretar data no formato YYYY-MM-DD (Ex.: 12/12/2018)
    elseif (preg_match('{^(?P<y>\d{4})\D+(?P<m>\d{2})\D+(?P<d>\d{2}).*$}', $data, $match)) $dt = $match;

    // Expressão regular para interpretar hora no formato HH:MM:SS (Ex.: 15:00:00)
    elseif (preg_match('{^(?P<h>\d{2})\D+(?P<i>\d{2})\D+(?P<s>\d{2}).*$}', $data, $match)) $dt = $match;

    // Expressão regular para interpretar hora no formato HH:MM (Ex.: 15:00)
    elseif (preg_match('{^(?P<h>\d{2})\D+(?P<i>\d{2}).*$}', $data, $match)) $dt = $match;

    // Formato não reconhecido
    else $dt = array();

    // Converte a data para o unixtime usado no PHP
    return mktime(
        isset($dt['h']) ? intval($dt['h']) : 0,
        isset($dt['i']) ? intval($dt['i']) : 0,
        isset($dt['s']) ? intval($dt['s']) : 0,
        isset($dt['m']) ? intval($dt['m']) : 0,
        isset($dt['d']) ? intval($dt['d']) : 0,
        isset($dt['y']) ? intval($dt['y']) : 0
    );

}

function numeroParse($numero){
    if (is_int($numero)) return $numero; // Se for do tipo inteiro retorna o número
    if (is_float($numero)) return $numero; // Se for do tipo fracionado retorna o número
    if (!is_string($numero)) return 0; // Se não for caracter retorna 0
    if (preg_match('{^\d+(,\d)+\.\d+$}', $numero)) return floatval(strtr($numero, array(',' => ''))); // Se for caracter no formato inglês com separador de milhar, limpa e converte para fracionado
    if (preg_match('{^\d+(\.\d)+,\d+$}', $numero)) return floatval(strtr($numero, array('.' => '', ',' => '.'))); // Se for caracter no formato brasileiro com separador de milhar, limpa e converte para fracionado
    if (preg_match('{^\d+,\d+$}', $numero)) return floatval(strtr($numero, array(',' => '.'))); // Se for caracter no formato brasileiro, limpa e converte para fracionado
    if (preg_match('{^\d+\.\d+$}', $numero)) return floatval($numero); // Se for caracter no formato inglês, limpa e converte para fracionado
    if (is_numeric($numero)) return floatval ($numero); // Se for caracter que tenha apenas números converte para fracionado
    return 0; // Se for em um formato inválido retorna 0
}

function numeroFormatar($number, $decimals = -2, $dec_point = ',', $thousands_sep = '.'){
    $num = number_format($number, abs($decimals), $dec_point, $thousands_sep);
    if ($decimals < 0) $num = rtrim(rtrim($num, '0'), $dec_point);
    return $num;
}

// Converte um valor em texto para a consulta SQL
function mysqliEscaparTexto($valor, $tipo = null) {
    if (is_null($valor) || ($tipo == 'null'))
        return 'NULL'; // Retorna null do SQL
    if ($tipo == 'date')
        return "'".date('Y-m-d', dataParse($valor))."'"; // Formata a data para o SQL
    if ($tipo == 'time')
        return "'".date('H:i:s', dataParse($valor))."'"; // Formata a hora para o SQL
    if ($tipo == 'datetime')
        return "'".date('Y-m-d H:i:s', dataParse($valor))."'"; // Formata a data e hora para o SQL
    if (is_int($valor) || ($tipo == 'int'))
        return number_format(numeroParse($valor), 0, '.', ''); // formata o numero inteiro para o padrao do SQL
    if (is_float($valor) || ($tipo == 'float'))
        return rtrim(rtrim(number_format(numeroParse($valor), 10, '.', ''), '0'), '.'); // formata o numero real para o SQL
    if (is_string($valor) || ($tipo == 'string'))
        return ("'" . addcslashes($valor, "\r\n\t\0\\'") . "'"); // Formata o string para o SQL
    if (is_bool($valor) || ($tipo == 'bool'))
        return ($valor ? '1' : '0'); // Formata o booleano para o SQL
    return "''"; // Se nao for nenhuma das opcoes anteriores
}

function criarNotificacao($status, $texto, $profissional_id = null, $aluno_id = null, $dados = null) {
    if ($dados !== null) $dados = serialize($dados);
    $sql = "insert into notificacao (data, lido, status, texto, profissional_id, aluno_id, dados) value (now(),'N', " . mysqliEscaparTexto($status) . ", " . mysqliEscaparTexto($texto) . ", " . mysqliEscaparTexto($profissional_id) . ", " . mysqliEscaparTexto($aluno_id) . ", " . mysqliEscaparTexto($dados) . ")";
    global $conexao; //importar variavel de fora da função.
    if (!$conexao)
        die('deu erro');
    if (mysqli_query($conexao, $sql)) {
        return mysqli_insert_id($conexao);
    } else {
        return null;
    }
}

function consultarNotificacao($lido = null) {
    $sql = "select n.*, p.nome AS prof_nome, p.sobrenome AS prof_sobrenome, a.nome AS al_nome, a.sobrenome AS al_sobrenome from notificacao n left join usuario p on p.id = n.profissional_id left join usuario a on a.id = n.aluno_id where ";
    if ($lido !== null)
        $sql .= "lido = '" . mysqliEscaparTexto($lido) . "' and (";
    else
        $sql .= "lido = 'N' and (";
    if (tipoLogado('profissional')) {
        $sql .= "profissional_id = " . mysqliEscaparTexto($_SESSION['id']);
    } else {
        $sql .= "aluno_id = " . mysqliEscaparTexto($_SESSION['id']);
    }
    $sql .= " or (profissional_id is null and aluno_id is null)) order by data, id";
    global $conexao; //importar variavel de fora da função.
    $retorno = array();
    if (!$conexao)
        return $retorno;
    if ($resultado = mysqli_query($conexao, $sql)) {
        while ($linha = mysqli_fetch_array($resultado)) {
            $linha['texto'] = preg_replace_callback('{(href=["\'][^"\']+)(["\'])}i', function ($match) use ($linha) {//Adicionando código da notificação em todos os links do texto
                return ($match[1] . ((strpos($match[0], '?') !== false) ? '&' : '?') . 'notificacao=' . $linha['id'] . $match[2]);
            }, $linha['texto']);
            if (!empty($linha['dados']) || is_numeric($linha['dados'])) $linha['dados'] = unserialize($linha['dados']);
            $retorno[] = $linha;
        }
    }
    return $retorno;
}

function totalNotificacao($lido = null) {
    $sql = "select count(id) as total from  notificacao where ";
    if ($lido !== null)
        $sql .= "lido = '" . mysqliEscaparTexto($lido) . "' and (";
    else
        $sql .= "lido = 'N' and (";
    if (tipoLogado('profissional')){
        $sql .= "profissional_id = " . mysqliEscaparTexto($_SESSION['id']);
    } else {
        $sql .= "aluno_id = " . mysqliEscaparTexto($_SESSION['id']);
    }
    $sql .= " or (profissional_id is null and aluno_id is null)) order by data, id";
    global $conexao; //importar variavel de fora da função.
    if (!$conexao)
        return 0;
    if ($resultado = mysqli_query($conexao, $sql)) {
        if ($linha = mysqli_fetch_array($resultado)) {
            return intval($linha['total']);
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function leituraNotificacao($id, $lido = null, $dados = null) {
    if ($lido === null) $lido = 'L';
    $where = ["lido != " . mysqliEscaparTexto($lido)];
    if ($id) $where[] = "id = ".mysqliEscaparTexto($id);
    if ($dados !== null){
        $where[] = "dados = ".mysqliEscaparTexto(serialize($dados));
    }
    $sql = "update notificacao set lido = " . mysqliEscaparTexto($lido) . " where ".implode(' and ', $where);
    global $conexao; //importar variavel de fora da função.
    mysqli_query($conexao, $sql) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$sql.PHP_EOL.print_r(debug_backtrace(), true));
}

//Esta função levará $ _SERVER ['REQUEST_URI'] e construirá uma trilha atual com base no caminho atual do usuário
function breadcrumbs($separator = ' &raquo; ', $home = 'Home') {

// Isso obtém o REQUEST_URI (/path/to/file.php), divide a string (usando '/') em uma matriz e, em seguida, filtra todos os valores vazios
    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));

// Isso criará nosso "URL base" ... Também conta para HTTPS :)
    $base = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';


// Inicialize um array temporário com nossos breadcrumbs. (começando com a nossa home page, que eu suponho que seja o URL base)
    $breadcrumbs = Array("<a href=\"$base\">$home</a>");

    
// Descobrir o índice do último valor em nosso array de caminho
    $last = end(array_keys($path));

// Construa o restante
    foreach ($path AS $x => $crumb) {
        
        
// Nosso "título" é o texto que será exibido (retire o arquivo .php e gire '_' em um espaço)
        $title = ucwords(str_replace(Array('.php', '_'), Array('', ' '), $crumb));

        // If we are not on the last index, then display an <a> tag
        if ($x != $last)
            $breadcrumbs[] = "<a href=\"$base$crumb\">$title</a>";
        // Otherwise, just display the title (minus)
        else
            $breadcrumbs[] = $title;
    }

    // Build our temporary array (pieces of bread) into one big string :)
    return implode($separator, $breadcrumbs);
}
    function listar_usuario_para_avaliacao() {
        $usuarios = array();
        $query = "select * from usuario join vinculo on usuario.id=vinculo.aluno_id where profissional_id=$_SESSION[id]";
        $retorno = mysqli_query($conexao, $query);
        while ($linha = mysqli_fetch_array($retorno)) {
            array_push($usuarios, $linha);
        }
        return $usuarios;
    }



?>
    
