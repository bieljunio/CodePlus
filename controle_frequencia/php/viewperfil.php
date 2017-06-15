<?php
require 'validationlogin.php';
require 'bd.php';

$c = $_GET['c'];
if (isset($_SESSION['busca'][$c])) {

    $cpfbusca = $_SESSION['busca'][$c];

    //SQL para retornar todos os dados cadastrais
    $sql = <<<HEREDOC
    			SELECT F.CPF,
    	   F.RG,
    	   F.NOME,
    	   F.NASCIMENTO,
    	   F.SEXO,
    	   F.NOME_PAI,
    	   F.NOME_MAE,
    	   F.ADMISSAO,
    	   F.FACEBOOK,
    	   F.SKYPE,
    	   F.LINKEDIN,
    	   F.EMAIL,
    	   F.TELEFONE,
    	   F.TELEFONE_ALT,
    	   F.EMAIL_ALT,
    	   F.RA,
    	   F.COEFICIENTE,
    	   F.PERIODO,
    	   F.END_RUA,
    	   F.END_BAIRRO,
    	   F.END_NUMERO,
    	   F.END_COMPLEMENTO,
    	   F.END_CEP,
    	   CIDADE.NOME AS CIDADE,
    	   E.NOME AS ESTADO,
    	   V.NOME AS VINCULO,
    	   C.NOME AS CARGO,
    	   S.NOME AS SETOR,
    	   ES.NOME AS ESTADO_CIVIL
    	FROM FUNCIONARIO F
    		INNER JOIN CIDADE
    			ON F.ID_CIDADE = CIDADE.ID_CIDADE
    			INNER JOIN ESTADO E
    				ON CIDADE.UF = E.UF
    				INNER JOIN VINCULO V
    					ON F.ID_VINCULO = V.ID_VINCULO
    					INNER JOIN CARGO C
    						ON F.ID_CARGO = C.ID_CARGO
    						INNER JOIN SETOR S
    							ON F.ID_SETOR = S.ID_SETOR
    							INNER JOIN ESTADO_CIVIL ES
    								ON F.ID_ESTADO_CIVIL = ES.ID_ESTADO_CIVIL
    		WHERE CPF = '$cpfbusca'
HEREDOC;
    //Query do sql
    $dados = pg_query($sql);
    $arraydados = pg_fetch_array($dados);

    $fem = "";
    $masc = "";
    $outro = "";
    if ($arraydados[4] === 'F')
        $fem = "selected";
    elseif ($arraydados[4] === 'M')
        $masc = "selected";
    elseif ($arraydados[4] === 'O')
        $outro = "selected";

} else {
    echo <<<HEREDOC
        <script>
            alert ("Faça uma nova busca.");
            location.href="home.php";
        </script>
HEREDOC;
}
?>

<!DOCTYPE html>
<html lang="pt_br">

    <head>
        <title>Editar perfil</title>

        <meta charset="utf-8">
        <!-- Favicon page -->
        <link rel="icon" href="../img/favicon.png" sizes="16x16" type="image/png">
        <!-- Folhas de estilos -->
        <link rel="stylesheet" type="text/css" href="../css/cadastro.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Pacifico|Roboto+Slab:400,700"
              rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../css/layout.css">
        <!-- Inserção de jquery -->
        <script src="../javascript/jquery-3.2.1.min.js"></script>
        <!--  Inserção de funções para os botões -->
        <script src="../javascript/jquery.js"></script>
        <!--Folha de estilo cadastro-->

        <!--Aplicação das máscaras de cadastro-->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
        <script>
            $(document).ready(function () {
                $("input[name='cpf']").mask('000.000.000-00');
                $("input[name='rg']").mask('00.000.000-0');
                $("input[name='cep']").mask('00000-000');
                $("input[name='numero']").mask('0000');
                $("input[name='telefone']").mask('(00) 00000-0000');
                $("input[name='telefone_alternativo']").mask('(00) 00000-0000');
                $("input[name='coeficiente']").mask('0.0000');
                $("input[name='ra']").mask('0000000');
            });
        </script>
    </head>

    <body>
        <header>

            <section class="logomarca">
                <a href="home.php">
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
                    <li><a href="#">FUNCIONÁRIOS</a></li>
                    <li><a href="#">CONSULTAR FREQUÊNCIA</a></li>
                    <li><a href="form_cadastro.php">NOVO CADASTRO</a></li>
                </ul>
            </nav>

        </section>

        <section class="cont">
            <div id="interface">

                <form id="formNovoCad" name="formNovoCad" method="post" action="updatecadastro.php">
                    <br>
                    <h3>Dados Pessoais</h3>

                    <section id="dados_pessoais" class="form">

                        Nome:<input required maxlength="100" type="text" size="45" name="nome" placeholder="Ex: Luís Felipe Faria" value="<?php echo $arraydados[2] ?>">
                        CPF: <input required size="14" type="text" name="cpf" value="<?php echo $arraydados[0] ?>" placeholder="Ex: 123.456.789-10">
                        RG: <input required size="13" type="text" name="rg" value="<?php echo $arraydados[1] ?>" placeholder="Ex: 12.315.678-1">
                        <br/>Sexo:
                        <select name="sexo">
                            <option <?php echo $masc ?> name="masculino" value="M">Masculino</option>
                            <option <?php echo $fem ?> name="feminino" value="F">Feminino</option>
                            <option <?php echo $outro ?> name="outro" value="O">Outro</option>
                        </select>
                        Data de Nascimento: <input required type="date" name="data_nascimento" size="12" placeholder="Ex: DD/MM/AA" value="<?php echo $arraydados[3] ?>">
                        Estado civil: <select name="estado_civil" selected="<?php echo $arraydados[28]; ?>">

                            <?php
                            //Seleciona estado civil cadastrado
                            if ($arraydados[28] == "SOLTEIRO(A)")
                                    $sol = "selected";
                                else
                                    $sol = "";
                            if ($arraydados[28] == "CASADO(A)")
                                    $cas = "selected";
                                else
                                    $cas = "";
                                        if ($arraydados[28] == "DIVORCIADO(A)")
                                    $div = "selected";
                                else
                                    $div = "";
                            ?>
                            <option <?php echo $sol ?>  name="1°" value="1">Solteiro</option>
                            <option <?php echo $cas ?> name="2°" value="2">Casado</option>
                            <option <?php echo $div ?> name="3°" value="3">Divorciado</option>
                        </select>
                        <br/>Nome do Pai: <input  required value="<?php echo $arraydados[5] ?>" type="text" maxlength="100" size="45" name="nome_pai" placeholder="Ex: Roberto Faria">
                        Nome da Mãe: <input required value="<?php echo $arraydados[6] ?>" type="text" maxlength="100" size="45" name="nome_mae" placeholder="Ex: Arlete Faria">

                    </section>
                    <br>
                    <h3>Endereço</h3>

                    <section class="form">

                        Endereço:
                        <input required value="<?php echo $arraydados[18] ?>" type="text" maxlength="80" size="40" name="endereco" placeholder="Ex: Rua do Comércio">
                        Número:
                        <input required value="<?php echo $arraydados[20] ?>" size="5" type="text" name="numero" placeholder="Ex: 1234">
                        Complemento:
                        <input value="<?php echo $arraydados[21] ?>" type="text" maxlength="30" size="33" name="complemento" placeholder="Ex: Fundos">
                        <br/>Bairro:
                        <input required value="<?php echo $arraydados[19] ?>" type="text" maxlength="30" size="40" name="bairro" placeholder="Ex: Maria da Glória">
                        CEP: <input required value="<?php echo $arraydados[22] ?>" size="10" type="text" name="cep" placeholder="Ex: 12345-000">
                        Estado:
                        <select name="estado">

                            <option name="Paraná" value="PR">Paraná</option>

                        </select>
                        <br>
                        Cidade:
                        <?php
                        //Busca as cidades cadastradas no banco
                        $sql = pg_query("SELECT nome FROM cidade ORDER BY id_cidade");
                        echo <<<HEREDOC
				<select name="cidade">
HEREDOC;
                        //Dropdown de cidades com cidade cadastrada pré-selecionada
                        $j = 1;
                        for ($i = 0; $i < pg_num_rows($sql) - 1; $i++) {
                            $array = pg_fetch_array($sql, $i, PGSQL_NUM);
                            $selected = "";
                            if ($arraydados[23] == $array[0])
                                $selected = "selected";
                            echo <<<HEREDOC
					<option $selected value="$j">$array[0]</option>
HEREDOC;
                            $j++;
                        }
                        echo "</select>";
                        ?>

                    </section>
                    <br>
                    <h3>Contatos</h3>

                    <section class="form">

                        Facebook:
                        <input type="text" value="<?php echo $arraydados[8] ?>" name="facebook" placeholder="Ex: facebook.com\lealluisf">
                        Skype:
                        <input type="text" value="<?php echo $arraydados[9] ?>" name="skype" placeholder="Ex: *Luís Felipe Leal">
                        LinkedIn:
                        <input type="text" value="<?php echo $arraydados[10] ?>" name="linkedin" placeholder="Ex: *Luís Felipe Leal">
                        <br/>Telefone:
                        <input required value="<?php echo $arraydados[12] ?>" size="15" type="text" name="telefone" placeholder="Ex: (99) 99999-9999">
                        Telefone Alternativo:
                        <input required value="<?php echo $arraydados[13] ?>" size="15" type="text" name="telefone_alternativo" placeholder="Ex: (99) 99999-9999">
                        <br/>E-mail:
                        <input required type="email" value="<?php echo $arraydados[11] ?>" name="email" maxlength="100" size="25" placeholder="Ex: luisfelipeleal@outlook.com">
                        E-mail Alternativo:
                        <input  type="email" value="<?php echo $arraydados[14] ?>" name="email_alternativo" maxlength="30" size="25" placeholder="Ex: luisfelipeleal@outlook.com">

                    </section>
                    <br>
                    <h3>Dados Acadêmicos</h3>

                    <section class="form">

                        Período:
                        <?php
                        echo "<select name='periodo'>";
                        //Dropdown com período cadastrado pré-selecionado
                        $j = 1;
                        for ($i = 0; $i < 8; $i++) {
                            $selected = "";
                            if ($arraydados[17] == $j) {
                                $selected = "selected";
                            }
                            echo <<<HEREDOC
					<option $selected value="$j">$j</option>
HEREDOC;
                            $j++;
                        }
                        echo "</select>";
                        ?>

                        R.A:
                        <input required value="<?php echo $arraydados[15] ?>" size="8" type="text" name="ra" placeholder="Ex: 1234567">
                        Coeficiente:
                        <input required value="<?php echo $arraydados[16] ?>" size="6" type="text" name="coeficiente" placeholder="Ex: 0.1234">


                    </section>
                    <br>
                    <h3>Dados Empresariais</h3>

                    <section class="form">
                        Vínculo:
                        <?php
                        //Dropdown vínculo
                        $sql = pg_query("SELECT nome FROM vinculo ORDER BY id_vinculo");
                        echo <<<HEREDOC
				<select name="vinculo">
HEREDOC;
                        $j = 1;
                        for ($i = 0; $i < 2; $i++) {
                            $array = pg_fetch_array($sql, $i, PGSQL_NUM);
                            $selected = "";
                            if ($arraydados[25] == $array[0]) {
                                $selected = "selected";
                            }
                            echo <<<HEREDOC
					<option $selected value="$j">$array[0]</option>
HEREDOC;
                            $j++;
                        }
                        echo "</select>";
                        ?>

                        Cargo:
                        <?php
                        //Dropdown cargo
                        $sql = pg_query("SELECT nome FROM cargo ORDER BY id_cargo");
                        echo <<<HEREDOC
				<select name="cargo">
HEREDOC;
                        $j = 1;
                        for ($i = 0; $i < 3; $i++) {
                            $array = pg_fetch_array($sql, $i, PGSQL_NUM);
                            $selected = "";
                            if ($arraydados[26] == $array[0]) {
                                $selected = "selected";
                            }
                            echo <<<HEREDOC
					<option $selected value="$j">$array[0]</option>
HEREDOC;
                            $j++;
                        }
                        echo "</select>";
                        ?>

                        Setor:
                        <?php
                        //Dropdown setor
                        $sql = pg_query("SELECT nome FROM setor ORDER BY id_setor");
                        echo <<<HEREDOC
				<select name="setor">
HEREDOC;
                        $j = 1;
                        for ($i = 0; $i < 6; $i++) {
                            $array = pg_fetch_array($sql, $i, PGSQL_NUM);
                            $selected = "";
                            if ($arraydados[27] == $array[0]) {
                                $selected = "selected";
                            }
                            echo <<<HEREDOC
					<option $selected value="$j">$array[0]</option>
HEREDOC;
                            $j++;
                        }
                        echo "</select>";
                        ?>
                        Data de Admissão:
                        <input required value="<?php echo $arraydados[7] ?>" type="date" name="data_admissao" placeholder="Ex: DD/MM/AA">

                    </section>
                    <input id="botao" type="submit" name="Entrar" value="Atualizar"/>

                </form>
            </div>
        </section>
        <div id="rodape">
            <br>
            <p>Copyright &copy; 2017 - CodePlus</p>
        </div>
    </body>
</html>
