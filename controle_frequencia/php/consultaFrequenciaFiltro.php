<?php
require 'headers.php';
require 'bd.php';
require 'validationlogin.php';
$id = filter_input(INPUT_POST, 'id');
echo $periodoInicio = filter_input(INPUT_POST, 'inicio');
echo $periodoFinal = filter_input(INPUT_POST, 'final');
//verifica se há algum valor atribuído as variaveis se houver, faz a pesquisa no período informado
if ($periodoInicio == null && $periodoFinal == null)
    echo "<script>alert('Insira um período válido!');</script>";
else if($periodoInicio != $periodoFinal){
    $sql = <<<HEREDOC
    SELECT TO_CHAR(DATA, 'DD/MM/YYYY'), ENTRADA, SAIDA
        FROM PONTO_FUNCIONARIO
        WHERE CPF = '{$_SESSION['busca'][$id]['user']}'
            AND DATA BETWEEN '$periodoInicio' AND '$periodoFinal'
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
} else if($periodoInicio == $periodoFinal){
    $sql = <<<HEREDOC
    SELECT TO_CHAR(DATA, 'DD/MM/YYYY'), ENTRADA, SAIDA
        FROM PONTO_FUNCIONARIO
        WHERE CPF = '{$_SESSION['busca'][$id]['user']}'
            AND DATA = '{$periodoInicio}'
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
} else if ($periodoInicio > $periodoFinal)
    echo "<script>alert('Insira um período válido!');</script>";
else
    echo "<script>alert('Insira um período válido!');</script>";
?>