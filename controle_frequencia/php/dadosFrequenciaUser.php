<?php
require 'headers.php';
require 'bd.php';
require 'validationlogin.php';
//declaração da data atual
date_default_timezone_set('America/Sao_Paulo');
//$_SESSION['busca'][$i] esta e a sessao que armazena os dados do usuário selecionado
//Dentro da session busca, existe o array(nome, setor, cpf)
$date = date('d, M/Y');
$cpf = $_SESSION['user'];
$nome = pg_fetch_result(pg_query("SELECT nome FROM funcionario WHERE cpf='$cpf'"), 0, 0);
$idsetor = pg_fetch_result(pg_query("SELECT id_setor FROM funcionario WHERE cpf='$cpf'"), 0, 0);
$setor = pg_fetch_result(pg_query("SELECT nome FROM setor WHERE id_setor='$idsetor'"), 0, 0);

            $periodoInicio = filter_input(INPUT_POST, 'periodoInicio');
            $periodoFinal = filter_input(INPUT_POST, 'periodoFinal');
//verifica se há algum valor atribuído as variaveis se houver, faz a pesquisa no período informado
            if ($periodoInicio && $periodoFinal) {
                $sql = <<<HEREDOC
SELECT TO_CHAR(DATA, 'DD/MM/YYYY'), ENTRADA, SAIDA
    FROM PONTO_FUNCIONARIO
    WHERE CPF = '{$_SESSION['user']}'
        AND DATA BETWEEN '{$periodoInicio}' AND '{$periodoFinal}'
HEREDOC;
            } else { //se nao tiver periodo informado, faz a pesquisa dos ultimos 30 dias
                
                $date = date('Y-m-d');
                $lastMounth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
//$_SESSION['busca'][$i] esta e a sessao que armazena os dados do usuário selecionado
//Dentro da session busca, existe o array(nome, setor, cpf)
                $sql = <<<HEREDOC
SELECT TO_CHAR(DATA, 'DD/MM/YYYY'), ENTRADA, SAIDA
    FROM PONTO_FUNCIONARIO
    WHERE CPF = '{$_SESSION['user']}'
        AND DATA BETWEEN '{$lastMounth}' AND '{$date}'
-- FIM QUERY
HEREDOC;
            }
            ?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Favicon -->
        <link rel="icon" href="../img/favicon.png" type="image/png">
        <!-- inclusões iniciais do arquivo html -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- fontes do google -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Pacifico|Roboto+Slab:400,700" 
              rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../css/dadosFreq.css">


        <title>Frequencia</title>
        <meta charset="utf-8" />
        <!-- ajax e jquery--> 
        <script src="../javascript/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="../javascript/jquery.js"></script>
        <!--<script src="../javascript/consultaFrequencia.js" type="text/javascript"></script>-->
        <style>
            table{border:1px solid #000; opacity: 0;};
        </style>        

    </head>
    <body>
        <header>

            <section class="logomarca">
                <a href="dadosFrequenciaUser.php">
                    <img class="logo" src="../img/logo.png" alt="logo">
                </a>
            </section>

            <section>
                <nav id="registros">
                    <ul>
                        <li><a href="" onclick="return registerEntry();">Registrar Entrada</a></li>
                        <li><a href="" onclick="return registerExit();">Registrar Saída</a></li>
                    </ul>
                </nav>
            </section>

            <section class="box">
                <div class="dropdown">
                    <img class="seta" src="../img/seta.png" alt="seta" />
                    <img class="redondo" src="../img/perfil.png"   alt="Foto Perfil" />
                    <div class="dropdown_content">
                        <a class="ac_perfil" href="perfil.php">Acessar perfil</a>
                        <a class="al_senha" href="AlteracaoSenhaFront.php">Alterar senha</a>
                        <a class="sair" href="logout.php">Sair</a>
                    </div>
                </div>
            </section>

        </header>

        <section>

            <nav id="menu">
                <ul>
                    <li><a href="colaboradores.php">COLABORADORES</a></li>
                    <li><a href="dadosFrequenciaUser.php">CONSULTAR FREQUÊNCIA</a></li>
                    <li><a href="form_cadastro.php">NOVO CADASTRO</a></li>
                </ul>
            </nav>

        </section>

        <section id="dadosbusca">

            <div id="dadoscolab">
                <p><b>Nome:&nbsp;&nbsp;</b> <?php echo $nome; ?></p>
                <p class="user" id=""><b>Setor:&nbsp;&nbsp;</b> <?php echo $setor; ?></p>
                <p><?php echo $date = date('d, M/Y'); ?></p>
            </div>

            <div id="busca">
                <h3>FILTRAR BUSCA POR PERÍODO</h3>
                <form method="post" class="form" action="dadosFrequenciaUser.php">
                    <!-- colocar mask para data -->
                    <h4>Data Inicial:<input required type="date" name="periodoInicio" placeholder="Digite a data inicial" value="<?php echo $periodoInicio; ?>"></h4>
                    <h4>Data Final:<input id="ajuste" required type="date" name="periodoFinal" placeholder="Digite a data final" value="<?php echo $periodoFinal; ?>"></h4>
                    <input type="submit" value="Filtrar">   
                </form>
            </div>

        </section>

        <section id="consultresult">
            
            <table style="opacity: 1;">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Entrada</th>
                        <th>Saída</th>
                    </tr>
<?php
$sql = pg_query($sql);
if (pg_num_rows($sql)) {
    echo "<tbody>
        ";
    while ($result = pg_fetch_array($sql)) {
        echo "<tr>
                    <td>$result[0]</td>

                    <td>$result[1]</td>
          
                    <td>$result[2]</td>
                </tr>";
    }
}
echo "</tbody>";
?>
                </thead>
            </table>

                     <center><a onclick="window.print()" id="imprimir">Imprimir</a></center>

        </section>

        <div id="rodape">

            <br>
            <p>Copyright &copy; 2017 - CodePlus</p>

        </div>
    </body>
</html>