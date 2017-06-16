<?php
require 'headers.php';
require 'bd.php';
require 'validationlogin.php';
date_default_timezone_set('America/Sao_Paulo');
//recupera o id
$id = filter_input(INPUT_POST, 'id');
if($_SESSION['busca'][$id] == null) {
    echo "<script> location.href='home.php' </script>";
} else {
    $date = date('Y-m-d');
    $lastMounth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
    //$_SESSION['busca'][$i] esta e a sessao que armazena os dados do usuário selecionado
    $sql = <<<HEREDOC
SELECT TO_CHAR(DATA, 'DD/MM/YYYY'), ENTRADA, SAIDA
    FROM PONTO_FUNCIONARIO
    WHERE CPF = '{$_SESSION['busca'][$id]['user']}'
        AND DATA BETWEEN '{$lastMounth}' AND '{$date}'
-- FIM QUERY
HEREDOC;
    $sql = pg_query($sql);
        echo "<tbody>";
        while ($result = pg_fetch_array($sql)) {
        echo "<tr>
                <td>$result[0]</td>
                <td>$result[1]</td>
                <td>$result[2]</td>
            </tr>";
        }
    echo "</tbody>";
}