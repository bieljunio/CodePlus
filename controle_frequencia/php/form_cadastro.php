<!DOCTYPE html>
<html lang="pt_br">

    <head>
    <meta charset="utf-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../css/cadastro.css">
    </head>
    
    <body>
       <header id="cabecalho"></header>
        
        <h1>CODE +</h1>
        
         <div id="interface">
        
        <section>
            
            <form id="formNovoCad" name="formNovoCad" method="post" action="cadastro.php">
                
            <h2>Novo Cadastro </h2>
            <h3>Dados pessoais</h3>
                
            <p>Nome: <input required maxlength="100" type="text" size="45" name="nome" placeholder="Ex: Luís Felipe Faria"> 
            CPF: <input required type="text" size="16" maxlength="14" name="cpf" placeholder="Ex: 123.456.789-01">
            RG: <input required type="text" maxlength="10" size="12" name="rg" placeholder="Ex: 123.456.78"> 
            </p>   
                
            <p>Sexo:
            <select name="sexo"> 
                <option name="masculino" value="M">Masculino</option>
                <option name="feminino" value="F">Feminino</option>
                <option name="outro" value="O">Outro</option>
            </select>
            Data de Nascimento: <input required type="text" name="data_nascimento" size="12" placeholder="Ex: DD/MM/AA">
            
            </p>
            <p>
            Nome do Pai: <input required type="text" maxlength="100" size="45" name="nome_pai" placeholder="Ex: Roberto Faria"> 
            Nome da Mãe: <input required type="text" maxlength="100" size="45" name="nome_mae" placeholder="Ex: Arlete Faria"> 
            </p>
                
            
            
        </section>
        
         <h4>Endereço</h4>
    
        <section>
            
            <p>Endereço:
            <input required type="text" maxlength="80" size="40" name="endereco" placeholder="Ex: Rua do Comércio">
            Número:
            <input required type="text" maxlength="5" size="8" name="numero" placeholder="Ex: 1500">
            Complemento:
            <input required type="text" maxlength="30" size="37" name="complemento" placeholder="Ex: Fundos">
            </p>
            <p>
            Bairro:
            <input required type="text" maxlength="30" size="40" name="bairro" placeholder="Ex: Maria da Glória">
            
            CEP: <input required type="text" name="cep" maxlength="9" size="12" placeholder="Ex: 85660-000">
            </p>
            <p>
            Estado:
            <select name="estado">
                 
                <option name="Paraná" value="PR">Paraná</option> 
                
            </select>
            Cidade: <select name="cidade">
                <option name="1°" value="1">Dois Vizinhos</option>
                <option name="2°" value="2">Pato Branco</option>
                <option name="3°" value="3">Francisco Beltrão</option>                
            </select>
            </p>
            
                        
        </section>
        
         <h5>Contatos</h5>
    
        <section>

                    
            <p>Facebook:
            <input type="text" name="facebook" placeholder="Ex: facebook.com\lealluisf">
            Skype:
            <input type="text" name="skype" placeholder="Ex: *Luís Felipe Leal">
            LinkedIn:
            <input type="text" name="linkedin" placeholder="Ex: *Luís Felipe Leal">
            E-mail:
            <input required type="text" name="email" maxlength="100" size="25" placeholder="Ex: luisfelipeleal@outlook.com">
            </p>
            <p>
            E-mail Alternativo:
            <input type="text" name="email_alternativo" maxlength="30" size="25" placeholder="Ex: luisfelipeleal@outlook.com">  
            Telefone:   
            <input required type="number" name="telefone" maxlength="14" size="15" placeholder="Ex: (11) 1 1111-1111">
            Telefone Alternativo:    
            <input type="text" name="telefone_alternativo" maxlength="14" size="15" placeholder="Ex: (11) 1 1111-1111">
                
        </section>
        
         <h6>Dados Acadêmicos</h6>
    
        <section>    
            
            <p>
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
            <input required type="text" name="ra" maxlength="7" size="7" placeholder="Ex: 0000000">  
            Coeficiente:
            <input required type="text" name="coeficiente" maxlength="6" size="5" placeholder="Ex: 0,0000">
            Data de Admissão:
            <input required type="text" name="data_admissao" size="10" placeholder="Ex: DD/MM/AA">
            
            </p>
            
            <br><br>
                  
            
                
            </section>


            Vínculo: <select name="vinculo">
                <option name="1°" value="1">Trainee</option>
                <option name="2°" value="2">Efetivo</option>
                <option name="3°" value="3">Conselheiro</option>                
            </select><br>
            Cargo: <select name="cargo">
                <option name="1°" value="1">Funcionário</option>
                <option name="2°" value="2">Gestor</option>
                <option name="3°" value="3">Diretor</option>                
            </select>
            Setor: <select name="setor">
                <option name="1°" value="1">Projeto</option>
                <option name="2°" value="2">Executivo</option>
                <option name="3°" value="3">Qualidade</option>                
            </select><br><br>

            Estado civil: <select name="estado_civil">
                <option name="1°" value="1">Casado</option>
                <option name="2°" value="2">Solteiro</option>
                <option name="3°" value="3">Ferrado</option>                
            </select>

            <input id="botao" type="submit" name="Entrar" value="Finalizar"/>
                
            </form>
                
      </div>
    </body>


</html>