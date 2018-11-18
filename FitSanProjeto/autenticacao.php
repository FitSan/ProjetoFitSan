<?php

ob_start(); //gravar todas as saídas de texto em um local temporário antes de jogar para o navegador.
session_start();

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_STRICT & ~E_DEPRECATED); // Definindo para mostrar todos os erros exceto notificações, avisos, interoperabilidade e obsoletos. 

ini_set('display_errors', true);
ini_set('default_charset', 'utf-8');
ini_set('default_mimetype', 'text/html');

date_default_timezone_set('America/Sao_Paulo') or
    date_default_timezone_set('Brazil/East') or
    date_default_timezone_set('Etc/GMT-3')
;
setlocale(LC_ALL, 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'pt_BR', 'Portuguese_Brazil.1252', 'portuguese', 'ptb_ptb', 'ptb');

require_once './bancodedados/conectar.php';

$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_BASE, DB_PORT);
mysqli_query($conexao, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
mysqli_query($conexao, "SET time_zone = '".date_default_timezone_get()."'") or
    mysqli_query($conexao, "SET time_zone = '".date('e')."'") or
    mysqli_query($conexao, "SET @@global.time_zone = '".date('P')."'")
;

/**
 * 
 * @param $username será o identificador da sessão
 */
function logar($email, $tipo = null, $nome = null, $id = null) {
    if (is_array($email)) {
        foreach ($email as $campo => $valor) {
            if ($campo == 'senha')
                continue;
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
    if (empty($_SESSION['tipo']))
        return 'admin';
    return $_SESSION['tipo'];
}

function tipoLogado() {
    $tipos = func_get_args();
    if (is_array($tipos[0]))
        $tipos = $tipos[0];
    $logado = getTipo();
    foreach ($tipos as $tipo) {
        if ($logado == $tipo)
            return true;
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
        header('Location: '.URL_SITE.'form_login.php');
    } else {
        return true;
    }
}

function exibirName($completo = false) {
    if ($completo) {
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

function verificarMeta() {
    $sql_meta = "select * from meta where status='ativa' and usuario_id=" . $_SESSION['id'] . " and data_final<=".mysqliEscaparTexto(time(), 'datetime');
    global $conexao;
    $resultado_meta = mysqli_query($conexao, $sql_meta);
    $linha_meta = mysqli_fetch_array($resultado_meta);
    if (mysqli_num_rows($resultado_meta) === 0) {
        return false;
    } else {
        $finalizar_meta = "update meta set status='finalizada' where status='ativa' and usuario_id=" . $_SESSION['id'];
        mysqli_query($conexao, $finalizar_meta);
        criarNotificacao('INFO', 'Sua meta foi finalizada na data ' . date('d M Y', dataParse($linha_meta['data_final'])) . '<br><a href="'.URL_SITE.'okMetaNot.php">Ver</a>', null, $_SESSION['id'], null);
    }
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
    if (is_numeric($data))
        return intval($data);

    // Limpa espaços antes e depois do texto
    $data = trim($data);

    // Expressão regular para interpretar data e hora no formato DD/MM/YYYY HH:MM:SS (Ex.: 12/12/2018 15:00:00)
    if (preg_match('{^(?P<d>\d{2})\D+(?P<m>\d{2})\D+(?P<y>\d{4})\D+(?P<h>\d{2})\D+(?P<i>\d{2})\D+(?P<s>\d{2}).*$}', $data, $match))
        $dt = $match;

    // Expressão regular para interpretar data e hora no formato YYYY-MM-DD HH:MM:SS (Ex.: 12/12/2018 15:00:00)
    elseif (preg_match('{^(?P<y>\d{4})\D+(?P<m>\d{2})\D+(?P<d>\d{2})\D+(?P<h>\d{2})\D+(?P<i>\d{2})\D+(?P<s>\d{2}).*$}', $data, $match))
        $dt = $match;

    // Expressão regular para interpretar data e hora no formato DD/MM/YYYY HH:MM (Ex.: 12/12/2018 15:00)
    elseif (preg_match('{^(?P<d>\d{2})\D+(?P<m>\d{2})\D+(?P<y>\d{4})\D+(?P<h>\d{2})\D+(?P<i>\d{2}).*$}', $data, $match))
        $dt = $match;

    // Expressão regular para interpretar data e hora no formato YYYY-MM-DD HH:MM (Ex.: 12/12/2018 15:00)
    elseif (preg_match('{^(?P<y>\d{4})\D+(?P<m>\d{2})\D+(?P<d>\d{2})\D+(?P<h>\d{2})\D+(?P<i>\d{2}).*$}', $data, $match))
        $dt = $match;

    // Expressão regular para interpretar data no formato DD/MM/YYYY (Ex.: 12/12/2018)
    elseif (preg_match('{^(?P<d>\d{2})\D+(?P<m>\d{2})\D+(?P<y>\d{4}).*$}', $data, $match))
        $dt = $match;

    // Expressão regular para interpretar data no formato YYYY-MM-DD (Ex.: 12/12/2018)
    elseif (preg_match('{^(?P<y>\d{4})\D+(?P<m>\d{2})\D+(?P<d>\d{2}).*$}', $data, $match))
        $dt = $match;

    // Expressão regular para interpretar hora no formato HH:MM:SS (Ex.: 15:00:00)
    elseif (preg_match('{^(?P<h>\d{2})\D+(?P<i>\d{2})\D+(?P<s>\d{2}).*$}', $data, $match))
        $dt = $match;

    // Expressão regular para interpretar hora no formato HH:MM (Ex.: 15:00)
    elseif (preg_match('{^(?P<h>\d{2})\D+(?P<i>\d{2}).*$}', $data, $match))
        $dt = $match;

    // Formato não reconhecido
    else
        $dt = array();

    // Converte a data para o unixtime usado no PHP
    return mktime(
            isset($dt['h']) ? intval($dt['h']) : 0, isset($dt['i']) ? intval($dt['i']) : 0, isset($dt['s']) ? intval($dt['s']) : 0, isset($dt['m']) ? intval($dt['m']) : 0, isset($dt['d']) ? intval($dt['d']) : 0, isset($dt['y']) ? intval($dt['y']) : 0
    );
}

function numeroParse($numero) {
    if (is_int($numero))
        return $numero; // Se for do tipo inteiro retorna o número
    if (is_float($numero))
        return $numero; // Se for do tipo fracionado retorna o número
    if (!is_string($numero))
        return 0; // Se não for caracter retorna 0
    if (preg_match('{^\d+(,\d)+\.\d+$}', $numero))
        return floatval(strtr($numero, array(',' => ''))); // Se for caracter no formato inglês com separador de milhar, limpa e converte para fracionado
    if (preg_match('{^\d+(\.\d)+,\d+$}', $numero))
        return floatval(strtr($numero, array('.' => '', ',' => '.'))); // Se for caracter no formato brasileiro com separador de milhar, limpa e converte para fracionado
    if (preg_match('{^\d+,\d+$}', $numero))
        return floatval(strtr($numero, array(',' => '.'))); // Se for caracter no formato brasileiro, limpa e converte para fracionado
    if (preg_match('{^\d+\.\d+$}', $numero))
        return floatval($numero); // Se for caracter no formato inglês, limpa e converte para fracionado
    if (is_numeric($numero))
        return floatval($numero); // Se for caracter que tenha apenas números converte para fracionado
    return 0; // Se for em um formato inválido retorna 0
}

function numeroFormatar($number, $decimals = -2, $dec_point = ',', $thousands_sep = '.') {
    $num = number_format($number, abs($decimals), $dec_point, $thousands_sep);
    if ($decimals < 0)
        $num = rtrim(rtrim($num, '0'), $dec_point);
    return $num;
}

// Converte um valor em texto para a consulta SQL
function mysqliEscaparTexto($valor, $tipo = null) {
    if (is_null($valor) || ($tipo == 'null'))
        return 'NULL'; // Retorna null do SQL
    if ($tipo == 'date')
        return "'" . date('Y-m-d', dataParse($valor)) . "'"; // Formata a data para o SQL
    if ($tipo == 'time')
        return "'" . date('H:i:s', dataParse($valor)) . "'"; // Formata a hora para o SQL
    if ($tipo == 'datetime')
        return "'" . date('Y-m-d H:i:s', dataParse($valor)) . "'"; // Formata a data e hora para o SQL
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
    if ($ret = dbquery("
        insert into notificacao (
            data, 
            lido, 
            status, 
            texto, 
            profissional_id, 
            aluno_id, 
            dados
        ) value (
            " . mysqliEscaparTexto(time(), 'datetime') . ",
            'N', 
            " . mysqliEscaparTexto($status) . ", 
            " . mysqliEscaparTexto($texto) . ", 
            " . mysqliEscaparTexto($profissional_id) . ", 
            " . mysqliEscaparTexto($aluno_id) . ", 
            " . mysqliEscaparTexto($dados) . "
        )
    ", 'id')) {
        return $ret;
    } else {
        return null;
    }
}

function consultarNotificacao($lido = null) {
    $sql = "
        select 
            n.*, 
            p.nome AS prof_nome, 
            p.sobrenome AS prof_sobrenome, 
            a.nome AS al_nome, 
            a.sobrenome AS al_sobrenome 
        from 
            notificacao n left join 
            usuario p on p.id = n.profissional_id left join 
            usuario a on a.id = n.aluno_id 
        where 
    ";
    if ($lido !== null)
        $sql .= "lido = '" . mysqliEscaparTexto($lido) . "' and (";
    else
        $sql .= "lido = 'N' and (";
    if (tipoLogado('profissional')) {
        $sql .= "profissional_id = " . mysqliEscaparTexto($_SESSION['id']);
    } else {
        $sql .= "aluno_id = " . mysqliEscaparTexto($_SESSION['id']);
    }
    $sql .= " or (profissional_id is null and aluno_id is null))
        order by
            data,
            id
    ";
    $retorno = array();
    if ($resultado = dbquery($sql)) {
        foreach ($resultado as $linha) {
            $linha['texto'] = preg_replace_callback('{(href=["\'][^"\']+)(["\'])}i', function ($match) use ($linha) {//Adicionando código da notificação em todos os links do texto
                return ($match[1] . ((strpos($match[0], '?') !== false) ? '&' : '?') . 'notificacao=' . $linha['id'] . $match[2]);
            }, $linha['texto']);
            if (!empty($linha['dados']) || is_numeric($linha['dados']))
                $linha['dados'] = unserialize($linha['dados']);
            $retorno[] = $linha;
        }
    }
    return $retorno;
}

function totalNotificacao($lido = null) {
    $sql = "
        select
            count(id) as total
        from
            notificacao
        where
            lido = ";
    if ($lido !== null){
        $sql .= mysqliEscaparTexto($lido);
    } else {
        $sql .= "'N'";
    }
    $sql .= " and
            (
                ";
    if (tipoLogado('profissional')) {
        $sql .= "profissional_id";
    } else {
        $sql .= "aluno_id";
    }
    $sql .= " = " . mysqliEscaparTexto($_SESSION['id']) . " or
                (profissional_id is null and aluno_id is null)
            )
        order by
            `data`,
            id
    ";
    if ($resultado = dbquery($sql, 'col', 'total')) {
        return intval($resultado);
    } else {
        return 0;
    }
}

function leituraNotificacao($id, $lido = null, $dados = null) {
    if ($lido === null) $lido = 'L';
    $where = ["lido != " . mysqliEscaparTexto($lido)];
    if ($id) $where[] = "id = " . mysqliEscaparTexto($id);
    if ($dados !== null) {
        $where[] = "dados = " . mysqliEscaparTexto(serialize($dados));
    }
    return dbquery("update notificacao set lido = " . mysqliEscaparTexto($lido) . " where " . implode(' and ', $where), 'affected');
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

// Faz uma consula ao banco usando um array com os parâmetros
//    dbquery($query[, $saida = true[[, $col = 0], $row = 0]])
// 
//    Parâmetros:
//       $query => a query que será executada. A query pode ser uma SQL ou um array conforme o modelo abaixo:
//          array(
//             // Coloque os campos
//             'select' => array(
//                'a.campo_da_tabela1',
//                'b.campo_da_tabela_2'
//             ),
//             // Coloque as tabelas
//             'from' => array(
//                'tabela1 a',
//                'tabela2 b',
//                'tabela1 c join tabela2 d on d.id = c.id_d'
//             ),
//             // Coloque as condições
//             'where' => array(
//                'b.campo_fk = a.campo_id',
//                'a.campo_da_tabela_3 = valor',
//                'c.campo_da_tabela_4 = valor or d.campo_da_tabela_4 = valor',
//             ),
//             // Coloque os campos para agrupar
//             'group' => array(
//                'b.campo_fk',
//                'a.campo_da_tabela_3',
//             ),
//             // Coloque os campos para ordenar
//             'order' => array(
//                'b.campo_fk asc',
//                'a.campo_da_tabela_3 desc',
//             ),
//             // Coloque as condições pós consulta
//             'having' => array(
//                'b.campo_fk = a.campo_id',
//                'a.campo_da_tabela_3 = valor',
//             ),
//             // Coloque outras instrucões aqui
//             'outro' => array(
//                'limit 1',
//                'offset 0',
//             ),
//          )
//       $saida => a forma como deve retornar a consulta conforme o valor usado abaixo:
//          true => retorna um array com o conteúdo (padrão)
//          false => retorna a saida da consulta diretamente
//          'row' => retorna apenas a linha indicada no parâmetro seguinte
//          'col' => retorna apenas a linha e coluna indicadas nos parâmetros seguintes
//          'id' => retorna apenas o último id (primary key) adicionado na tabela (apenas para INSERT INTO)
// 
//      Se $saida for 'row'
//          $row => posição (linha) onde o ítem se encontra na lista, se não for informado será retornado o primeiro (informe somente int)
// 
//      Se $saida for 'col'
//          $col => posição (coluna) ou nome do campo onde do ítem, se não for informado será retornado o primeiro (informe int ou string)
//          $row => posição (linha) onde o ítem se encontra na lista, se não for informado será retornado o primeiro (informe somente int)
// 
//    Exemplos de $query com array:
// 
//      1: select campo_da_tabela1, campo_da_tabela_2 from tabela where campo_da_tabela_3 = valor;
//         array(
//            'select' => 'campo_da_tabela1, campo_da_tabela_2',
//            'from' => 'tabela',
//            'where' => 'campo_da_tabela_3 = valor',
//         )
//      
//      2: select a.campo_da_tabela1, b.campo_da_tabela_2 from tabela1 a, tabela2 b where b.campo_fk = a.campo_id and a.campo_da_tabela_3 = valor;
//        array(
//           'select' => array(
//              'a.campo_da_tabela1',
//              'b.campo_da_tabela_2'
//           ),
//           'from' => array(
//              'tabela1 a',
//              'tabela2 b'
//           ),
//           'where' => array(
//              'b.campo_fk = a.campo_id',
//              'a.campo_da_tabela_3 = valor',
//           )
//        )
// 
//    Exemplos de chamada da função:
// 
//      Supondo que exista a tabela:
//          CREATE TABLE tabela (
//              id INT PRIMARY KEY AUTO_INCREMENT,
//              campo VARCHAR(5) NOT NULL,
//          );
// 
//      1: Consultando dados da tabela
//          dbquery("SELECT * FROM tabela")
//          dbquery("SELECT * FROM tabela", true)
// 
//          Isto deve retornar algo como:
//              array(
//                  array('id' => 1, 'campo' => 'valor'),
//              )
// 
//      2: Inserindo na tabela com um retorno direto
//          dbquery("INSERT INTO tabela (campo) VALUE ('valor')", false)
// 
//          Isto deve retornar algo como:
//              int(0) ou int(1) ou resource(...)
// 
//      3: Consultando na tabela e pegar apenas uma determinada linha
//          dbquery("SELECT * FROM tabela", 'row')
//          dbquery("SELECT * FROM tabela", 'row', 1)
// 
//          Isto deve retornar algo como:
//              array('id' => 1, 'campo' => 'valor')
// 
//      4: Consultando na tabela e pegando apenas o valor de um determinado campo e de uma determinada linha
//          dbquery("SELECT count(*) as total FROM tabela", 'col')
// 
//          Isto deve retornar algo como:
//              int(10)
//
//          dbquery("SELECT * FROM tabela", 'col', 1)
//          dbquery("SELECT * FROM tabela", 'col', 1, 2)
//          dbquery("SELECT * FROM tabela", 'col', 'campo')
//          dbquery("SELECT * FROM tabela", 'col', 'campo', 2)
// 
//          Isto deve retornar algo como:
//              string(5) 'valor'
// 
function dbquery() {
    global $conexao;

    $args = func_get_args();
    $query = array_shift($args);

    if (is_array($query)) {
        $sql = ("select " . trim(is_array($query['select']) ? implode(', ', $query['select']) : $query['select']) . " ");
        if (isset($query['from']))
            $sql .= ("from " . trim(is_array($query['from']) ? implode(', ', $query['from']) : $query['from']) . " ");
        if (isset($query['where']))
            $sql .= ("where " . trim(is_array($query['where']) ? implode(' and ', $query['where']) : $query['where']) . " ");
        if (isset($query['group']))
            $sql .= ("group by " . trim(is_array($query['group']) ? implode(', ', $query['group']) : $query['group']) . " ");
        if (isset($query['order']))
            $sql .= ("order by " . trim(is_array($query['order']) ? implode(', ', $query['order']) : $query['order']) . " ");
        if (isset($query['having']))
            $sql .= ("having " . trim(is_array($query['having']) ? implode(' and ', $query['having']) : $query['having']) . " ");
        if (isset($query['outro']))
            $sql .= trim(is_array($query['outro']) ? implode(' ', $query['outro']) : $query['outro']);
    } else {
        $sql = $query;
    }
    $res = mysqli_query($conexao, $sql) or die_mysql($sql, __FILE__, __LINE__);

    if (($saida = array_shift($args)) === null) $saida = true;
    if ($saida === 'id') {
        if ($ret = mysqli_insert_id($conexao)) return $ret;
    }
    if ($saida === 'affected') {
        if (($ret = mysqli_affected_rows($conexao)) != -1) return $ret;
    }
    if (!$saida) return $res;

    if (is_resource($res) || ($res instanceof mysqli_result)){
        $ret = array();
        while ($row = mysqli_fetch_array($res)) $ret[] = array_change_key_case($row, CASE_LOWER);
        mysqli_free_result($res);
    }

    if ($saida === true) return $ret;

    switch ($saida){
        case 'row':
            if (($row = array_shift($args)) === null) $row = 0;
            return isset($ret[$row]) ? $ret[$row] : null;
        case 'col':
            if (($col = array_shift($args)) === null) $col = 0;
            if (($row = array_shift($args)) === null) $row = 0;
            $item = (isset($ret[$row]) ? $ret[$row] : array());
            if (is_string($col)) return isset($item[$col]) ? $item[$col] : null;
            $item = array_values($item);
            return isset($item[$col]) ? $item[$col] : null;
        case 'id':
            $ret = mysqli_insert_id($conexao);
            return ($ret ? $ret : $res);
        case 'affected':
            $ret = mysqli_affected_rows($conexao);
            return (($ret != -1) ? $ret : $res);
        default:
            return $ret;
    }

}

// Encerra o processo mostrando a mensagem de erro
// 
//    Parâmetros:
//       $msg => mensagem de erro
//       $file => nome do arquivo atual (usar sempre __FILE__ )
//       $line => linha do arquivo atual (usar sempre __LINE__ )
// 
//    Exemplo:
//      die_debug('A mensagem de erro vai aqui', __FILE__, __LINE__);
//
function die_debug($msg, $file = false, $line = false) {
    $r = @ob_start();
    echo '*** ERRO ***' . PHP_EOL;
    if (($file !== false) && ($line !== false)) {
        printf('%s [%d]: %s', $file, $line, $msg);
    } elseif ($file !== false) {
        printf('%s: %s', $file, $msg);
    } elseif ($line !== false) {
        printf('%d: %s', $line, $msg);
    } else {
        echo $msg;
    }
    echo PHP_EOL;
    print_r(debug_backtrace());
    if ($r) echo '<pre style="position: fixed;z-index: 99999;top: 0px;left: 0px;width: 100%;height: 100vh;overflow: auto;">' . htmlentities(ob_get_clean()) . '</pre>';
    exit;
}

// Encerra o processo mostrando a mensagem de erro do banco de dados
// 
//    Parâmetros:
//       $msg => Informações do erro (SQL, parâmetros, etc)
//       $file => nome do arquivo atual (usar sempre __FILE__ )
//       $line => linha do arquivo atual (usar sempre __LINE__ )
// 
//    Exemplo:
//      mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
//
function die_mysql($msg = '', $file = false, $line = false) {
    global $conexao;
    if ($msg)
        $msg .= PHP_EOL;
    if (mysqli_errno($conexao)) {
        $msg .= mysqli_error($conexao);
    } else {
        $msg .= 'Ocorreu um erro desconhecido';
    }
    die_debug($msg, $file, $line);
}

// Obtém o endereço (a URL) chamada pelo navegador
//
//    Exemplo:
//      $url = url_current();
//          --> O retorno disso será semelhante à: http://localhost/FitSan/planilha.php?a=1&b=2
//
function url_current() {
    return (
       'http' .
       ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 's' : '') .
       '://' .
       $_SERVER['HTTP_HOST'] .
       $_SERVER['REQUEST_URI']
    );
}

// Ajusta uma URL
// 
//    Parâmetros:
//       $url => A URL que será ajustada
//       $params => Array com os parâmetros do ajuste
//          'scheme' => Indica o schema ou se deve ou não colocar o schema (ex.: http, https, etc)
//          'host' => Indica o host ou se deve ou não colocar o host (ex.: localhost)
//          'path' => Indica o caminho ou se deve ou não colocar o caminho (ex.: /FitSan/planilha.php)
//          'query' => Indica os parâmetros ou se deve ou não colocar o parâmetros (ex.: a=1&b=2 ou array('a' => '1', 'b' => '2'))
//          'fragment' => Indica o id de um elemento ou se deve ou não colocar o id de um elemento (ex.: #header)
//          'port' => Indica a porta ou se deve ou não colocar a porta (ex.: 80)
//          'user' => Indica o usuário ou se deve ou não colocar o usuário (ex.: karen)
//          'pass' => Indica a senha ou se deve ou não colocar a senha (ex.: 12345678)
// 
//    Exemplo 1: Adicionar um novo parâmetro na URL
//      url_adjust(url_current(), array('query' => array('c' => 1)));
//          --> O retorno disso será semelhante à: http://localhost/FitSan/planilha.php?a=1&b=2&c=1
//
//    Exemplo 2: Remover um parâmetro da URL
//      url_adjust(url_current(), array('query' => array('a' => null)));
//          --> O retorno disso será semelhante à: http://localhost/FitSan/planilha.php?b=2
//
//    Exemplo 3: Remover todos os parâmetro da URL
//      url_adjust(url_current(), array('query' => false));
//          --> O retorno disso será semelhante à: http://localhost/FitSan/planilha.php
//
function url_adjust($url, $params) {
    if ($url === null){
        $url = url_current();
    } elseif ($url === false){
        $url = URL_SITE;
    }
    if (!is_array($url)) $url = parse_url($url);

    $params = array_merge(array(
        'scheme' => true,
        'host' => true,
        'path' => true,
        'query' => true,
        'fragment' => true,
        'port' => true,
        'user' => true,
        'pass' => true,
    ), (array) $params);

    $ret = '';

    if ($params['scheme']) {
        if (is_string($params['scheme'])) {
            $ret = $params['scheme'];
        } else {
            $ret = (!empty($url['scheme']) ? $url['scheme'] : 'http');
        }
        $ret .= '://';
    }

    if ($params['user']) {
        if (is_string($params['user'])) {
            $user = $params['user'];
        } elseif (!empty($url['user'])) {
            $user = $url['user'];
        } else {
            $user = null;
        }
        if (is_string($params['pass'])) {
            $pass = $params['pass'];
        } elseif (!empty($url['pass'])) {
            $pass = $url['pass'];
        } else {
            $pass = null;
        }
        if ($user) $ret .= ($user . ($pass ? (':' . $pass) : '') . '@');
    }

    if ($params['host']) {
        if (is_string($params['host'])) {
            $ret .= $params['host'];
        } else {
            $ret .= (!empty($url['host']) ? $url['host'] : 'localhost');
        }
    }

    if (is_numeric($params['port'])) {
        $ret .= (':' . $params['port']);
    } elseif ($params['port'] && !empty($url['port'])) {
        $ret .= (':' . $url['port']);
    }

    if (is_string($params['path'])) {
        $ret .= ('/' . ltrim($params['path'], '/'));
    } elseif (is_int($params['path'])) {
        if ($params['path'] > 0) {
            $cmd = explode('/', !empty($url['path']) ? trim($url['path'], '/') : '');
            while ($params['path'] -- > 0)
                array_pop($cmd);
            $ret .= ('/' . (!empty($cmd) ? implode('/', $cmd) : ''));
        } else {
            $ret .= (!empty($url['path']) ? $url['path'] : '/');
        }
    } elseif ($params['path'] === true) {
        $ret .= (!empty($url['path']) ? $url['path'] : '/');
    } else {
        $ret .= '/';
    }

    if ($params['query'] === true) {
        if (!empty($url['query'])) $ret .= ('?' . $url['query']);
    } elseif ($params['query']) {
        if (is_string($params['query'])) {
            parse_str($params['query'], $params['query']);
        } elseif (!is_array($params['query'])) {
            $params['query'] = array();
        }
        if (!empty($url['query'])) {
            parse_str($url['query'], $arr);
        } else {
            $arr = array();
        }
        foreach ($params['query'] as $key => $value) {
            if ($value === null) {
                unset($arr[$key]);
            } else {
                $arr[$key] = $value;
            }
        }
        $ret .= ('?' . http_build_query($arr));
    }

    if (is_string($params['fragment'])) {
        $ret .= ('#' . $params['fragment']);
    } elseif ($params['fragment'] && !empty($url['fragment'])) {
        $ret .= ('#' . $url['fragment']);
    }

    return $ret;

}

// Adiciona e/ou remove parâmetros da URL
// 
//    Parâmetros:
//       $url => A URL que será ajustada
//       $query => Array com os parâmetros para alterar
// 
// 
//    Exemplo 1: Adicionar um novo parâmetro na URL
//      url_param_add(url_current(), 'c', 1);
//          --> O retorno disso será semelhante à: http://localhost/FitSan/planilha.php?a=1&b=2&c=1
//
//    Exemplo 2: Remover um parâmetro da URL
//      url_param_add(url_current(), 'a', null);
//          --> O retorno disso será semelhante à: http://localhost/FitSan/planilha.php?b=2
//
//    Exemplo 3: Adicionar mais de um parâmetro da URL
//      url_param_add(url_current(), array('c' => 5, 'b' => 7));
//          --> O retorno disso será semelhante à: http://localhost/FitSan/planilha.php?a=1&b=7&c=5
//
//    Exemplo 4: Remover mais de um parâmetro da URL
//      url_param_add(url_current(), array('a' => null, 'b' => null));
//          --> O retorno disso será semelhante à: http://localhost/FitSan/planilha.php
//
function url_param_add($url, $query, $value = null) {
    if (!is_array($query)) $query = array($query => $value);
    return url_adjust($url, array(
        'scheme' => true,
        'host' => true,
        'path' => true,
        'query' => $query,
        'fragment' => true,
        'port' => true,
        'user' => true,
        'pass' => true,
    ));
}



//function listar_usuario_para_avaliacao() {
//    $usuarios = array();
//    $query = "select * from usuario join vinculo on usuario.id=vinculo.aluno_id where profissional_id=$_SESSION[id]";
//    $retorno = mysqli_query($conexao, $query);
//    while ($linha = mysqli_fetch_array($retorno)) {
//        array_push($usuarios, $linha);
//    }
//    return $usuarios;
//}
