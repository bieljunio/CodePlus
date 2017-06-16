<?php
    require 'validationlogin.php';
    require_once 'dict.inc.php';
?>
<!DOCTYPE html>
<html lang="pt_br">

    <head>
        <title>Cadastro</title>
        
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
           $(document).ready(function(){
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
                    <li><a href="funcionarios.php">COLABORADORES</a></li>
                    <li><a href="dadosFrequenciaUser.php">CONSULTAR FREQUÊNCIA</a></li>
                    <li><a href="form_cadastro.php">NOVO CADASTRO</a></li>
                </ul>
            </nav>

        </section>
        
        <section class="cont">
            <div id="interface">
             
         <form id="formNovoCad" name="formNovoCad" method="post" action="cadastro.php">
             <br>
        <h3>Dados Pessoais</h3>
        
        <section id="dados_pessoais" class="form">
                
            Nome:<input required maxlength="100" type="text" size="45" name="nome" placeholder="Ex: Luís Felipe Faria">
            CPF: <input required size="14" type="text" name="cpf" placeholder="Ex: 123.456.789-10">
            RG: <input required size="13" type="text" name="rg" placeholder="Ex: 12.315.678-1">
            <br/>Sexo:
            <select name="sexo"> 
                <option name="masculino" value="M">Masculino</option>
                <option name="feminino" value="F">Feminino</option>
                <option name="outro" value="O">Outro</option>
            </select>
            Data de Nascimento: <input required type="date" name="data_nascimento" size="12" placeholder="Ex: DD/MM/AA">
            Estado civil: <select name="estado_civil">
                <option name="1°" value="1">Solteiro</option>
                <option name="2°" value="2">Casado</option>
                <option name="3°" value="3">Divorciado</option>                
            </select>
            <br/>Nome do Pai: <input required type="text" maxlength="100" size="45" name="nome_pai" placeholder="Ex: Roberto Faria"> 
            Nome da Mãe: <input required type="text" maxlength="100" size="45" name="nome_mae" placeholder="Ex: Arlete Faria">
                 
        </section>
        <br>
         <h3>Endereço</h3>
    
        <section class="form">
            
            Endereço:
            <input required type="text" maxlength="80" size="40" name="endereco" placeholder="Ex: Rua do Comércio">
            Número:
            <input required size="5" type="text" name="numero" placeholder="Ex: 1234">
            Complemento:
            <input type="text" maxlength="30" size="33" name="complemento" placeholder="Ex: Fundos">
            <br/>Bairro:
            <input required type="text" maxlength="30" size="40" name="bairro" placeholder="Ex: Maria da Glória">
            CEP: <input required size="10" type="text" name="cep" placeholder="Ex: 12345-000">
            Estado:
            <select name="estado">
                 
                <option name="Paraná" value="PR">Paraná</option> 
                
            </select>
            Cidade: <select name="cidade">
                <option name="1°" value="1">Ampére</option>
                <option name="2°" value="2">Barracão</option>
                <option name="3°" value="3">Bela Vista do Caroba</option>
                <option name="4°" value="4">Boa Esperança do Iguaçu</option>
                <option name="5°" value="5">Bom Jesus do Sul</option>
                <option name="6°" value="6">Bom sucesso do Sul</option>
                <option name="7°" value="7">Capanema</option>
                <option name="8°" value="8">Chopinzinho</option>
                <option name="9°" value="9">Clevelândia </option>
                <option name="10°" value="10">Coronel Domingos Soares</option>
                <option name="11°" value="11">Coronel Vivida</option>
                <option name="12°" value="12">Cruzeiro do Iguaçu</option>
                <option name="13°" value="13">Dois Vizinhos</option>
                <option name="14°" value="14">Enéas Marques</option>
                <option name="15°" value="15">Flor da Serra do Sul</option>
                <option name="16°" value="16">Francisco Beltrão</option>
                <option name="17°" value="17">Honório Serpa</option>
                <option name="18°" value="18">Itapejara do Oeste</option>
                <option name="19°" value="19">Manfrinópolis</option>
                <option name="20°" value="20">Mangueirinha</option>
                <option name="21°" value="21">Mariópolis</option>
                <option name="22°" value="22">Marmeleiro</option>
                <option name="23°" value="23">Nova Esperança do Sudoeste</option>
                <option name="24°" value="24">Palmas</option>
                <option name="25°" value="25">Pato Branco</option>
                <option name="26°" value="26">Pérola do Oeste</option>
                <option name="27°" value="27">Pinhal de São Bento</option>
                <option name="28°" value="28">Planalto</option>
                <option name="29°" value="29">Pranchita</option>
                <option name="30°" value="30">Realeza</option>
                <option name="31°" value="31">Renascença</option>
                <option name="32°" value="32">Salgado Filho</option>
                <option name="33°" value="33">Salto do Lontra</option>
                <option name="34°" value="34">Santa Izabel do Oeste</option>
                <option name="35°" value="35">Santo Antônio do Sudoeste</option>
                <option name="36°" value="36">São João</option>
                <option name="37°" value="37">São Jorge do Oeste</option>
                <option name="38°" value="38">Saudade do Iguaçu</option>
                <option name="39°" value="39">Sulina</option>
                <option name="40°" value="40">Verê</option>
                <option name="41°" value="41">Vitorino</option>
               
            </select>   
                        
        </section>
        <br>
         <h3>Contatos</h3>
    
        <section class="form">

                    
            Facebook:
            <input type="text" name="facebook" placeholder="Ex: facebook.com\lealluisf">
            Skype:
            <input type="text" name="skype" placeholder="Ex: *Luís Felipe Leal">
            LinkedIn:
            <input type="text" name="linkedin" placeholder="Ex: *Luís Felipe Leal">
            <br/>Telefone:   
            <input required size="15" type="text" name="telefone" placeholder="Ex: (99) 99999-9999">
            Telefone Alternativo:    
            <input required size="15" type="text" name="telefone_alternativo" placeholder="Ex: (99) 99999-9999">
            <br/>E-mail:
            <input required type="email" name="email" maxlength="100" size="25" placeholder="Ex: luisfelipeleal@outlook.com">
            E-mail Alternativo:
            <input  type="email" name="email_alternativo" maxlength="30" size="25" placeholder="Ex: luisfelipeleal@outlook.com">  
                
        </section>
        <br>
         <h3>Dados Acadêmicos</h3>
    
        <section class="form">    
            
            
            Período:
            <select name="periodo">
                <option name="1°" value="1">1° Período</option>
                <option name="2°" value="2">2° Período</option>
                <option name="3°" value="3">3° Período</option>
                <option name="4°" value="4">4° Período</option>
                <option name="5°" value="5">5° Período</option>
                <option name="6°" value="6">6º Período</option>
                <option name="7°" value="7">7° Período</option>
                <option name="8°" value="8">8º Período</option>
            </select>
            R.A:
            <input required size="8" type="text" name="ra" placeholder="Ex: 1234567"> 
            Coeficiente:
            <input required size="6" type="text" name="coeficiente" placeholder="Ex: 0.1234">
            Data de Admissão:
            <input required type="date" name="data_admissao" placeholder="Ex: DD/MM/AA">
            
            
            </section>
            <br>
             <h3>Dados Empresariais</h3>
            
            <section class="form">
                
            Vínculo: <select name="vinculo">
                <option name="1°" value="1">Trainee</option>
                <option name="2°" value="2">Efetivo</option>                
            </select>
            
            Cargo: <select name="cargo">
                <option name="1°" value="1">Funcionário</option>
                <option name="2°" value="2">Gestor</option>
                <option name="3°" value="3">Diretor</option>                
            </select>
            
            Setor: <select name="setor">
                <option name="1°" value="1">Marketing</option>
                <option name="2°" value="2">Qualidade</option>
                <option name="3°" value="3">RH</option>
                <option name="1°" value="4">ADM/Financeiro</option>
                <option name="2°" value="5">Vice-Presidência</option>
                <option name="3°" value="6">Presidência</option>   
            </select>
            
            </section>

            <input id="botao" type="submit" name="Entrar" value="Finalizar"/>
            
            </form>
                
            
                
      </div>
    </section>

    <div id="rodape">
        
            <br>
            <p>Copyright &copy; 2017 - CodePlus</p>
        
        </div>
    
    </body>


</html>
