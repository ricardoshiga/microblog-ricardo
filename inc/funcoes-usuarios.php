<?php
/* Careegando o script de acesso ao servidor de BD */
require "conecta.php";

//Usada em admin/usuario-insere.php
function inserirUsuario($conexao, $nome, $email, $senha, $tipo){

    /* Variavel montada com o comando SQL para INSERT dos 
    dasos capturados através do formulário */
   $sql = "INSERT INTO usuarios(nome, email, senha, tipo) VALUES('$nome', '$email', '$senha', '$tipo')";

   /* Executando o comando SQL montado acima */
   mysqli_query($conexao, $sql) or die(mysqli_error($conexao));


} //fim inserirUsuario

// USada em usuarios.php
function lerUsuarios($conexao){
    //Montando o comando SQL SELECT para leitura dos usuarios
    $sql = "SELECT id, nome, email, tipo FROM usuarios ORDER BY nome";

     // Guardando o resultado da operação de consulta SELECT
    $resultado = mysqli_query($conexao, $sql ) 
    or die(mysqli_error($conexao));

    /* Criando um array vazio que receberá outros arrays contendo os dados de cada usuário */
    $usuarios = [];

    /* Loop while (enquanto) que a cada ciclo de repetição, erá extrair os dados de cada usuário provenientes do resultado da consulta. Essa extração é feita pela função mysqli_fetch_assoc e é guardada na variável $usuario. */
    while($usuario = mysqli_fetch_assoc($resultado)){

        /* Pegamos os dados de cada $usuario (array),
        e os colocamos dentro (array_push)
        do grande array $usuarios. */
        array_push($usuarios, $usuario);
    }

    /* Levamos para fora da função a matriz $usuarios, contendo os dados de cada $usuario*/
    return $usuarios;

} //fim de lerUsuarios


//Usada em usuario-exclui.php
function excluiUsuario($conexao, $id){
/* Montando o comando de exclusão (DELETE) paassando como condição (WHERE) o id do usuário quue será excluido. */
    $sql = "DELETE FROM usuarios WHERE id = $id";

    /* Executando o comando sql */
    mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
} //fim excluiUsuario


//Usada em usuario-atualiza.php
//Função para carregamento e/exebição dos dados de UM USUARIO
function lerUmUsuario($conexao, $id){
    //Comando SQL para carregamento dos dadosde um determinado usuario pelo id
    $sql = "SELECT * FROM usuarios WHERE id = $id";

    /* Executamos a query (resultado) e, em caso de sucesso, guardamos o resultado em memoria. Obs: este resultado ainda não esta pronto par aser usando diretamente na aplicação (ou seja, dentro do formulario/pagina HTML) */
    $resultado = mysqli_query($conexao, $sql) 
                 or die(mysqli_error($conexao));

    /* Extraimos de dentro do resultado so o que nos interessa: os dados do usuario selecionado, ja estruturados como um ARRAY ASSOCIATIVO. */


    return mysqli_fetch_assoc($resultado);
} //fim lerUmUsuario

//Usada em usuario-atualiza.php
function atualizarUsuario($conexao, $id, $nome, $senha, $tipo, $email){
    $sql = "UPDATE usuarios SET nome = '$nome', email  = '$email', senha = '$senha', tipo = '$tipo' WHERE id = $id";

    //Executamos o comando
    mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

} //fim atualizarUsuario