<?php
require 'headers.php';
require 'bd.php';
require 'validationlogin.php';
echo $id = filter_input(INPUT_POST, 'id');
echo $periodoInicio = $_POST['periodoInicio'];
echo $periodoFinal = $_POST['periodoFinal'];
//verifica se há algum valor atribuído as variaveis se houver, faz a pesquisa no período informado
/*if ($periodoInicio == null && $periodoFinal == null)
    echo "<script>alert('Insira um período válido!');</script>";
else {*/
    $sql = <<<HEREDOC
    SELECT TO_CHAR(DATA, 'DD/MM/YYYY'), ENTRADA, SAIDA
        FROM PONTO_FUNCIONARIO
        WHERE CPF = '{$_SESSION['busca'][$id]['user']}'
            AND DATA BETWEEN '{$periodoInicio}' AND '{$periodoFinal}'
    -- FIM QUERY
HEREDOC;
    $sql = pg_query($sql);
    if (pg_num_rows($sql)) {
        echo "<tbody>";
        while ($result = pg_fetch_array($sql)) {
            echo "<tr>
                <td>$result[0]</td>
                <td>$result[1]</td>
                <td>$result[2]</td>
                </tr>";
        }
    }
    echo "</tbody>";
//}
?>