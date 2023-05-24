<?php
/* Sessões no PHP
Recurso usado para o controle de acesso à determinadas páginas e/ou recursos do site. 
Exemplo: área administrativa, área do cliente/aluno;

Nestas áreas, o acesso só é possível mediante alguma forma de autenticação. Exemplo: login/senha.*/

/* Se não existir uma sessão em funcionamento */
if( !isset($_SESSION)) {
    //então, inicie uma sessão
    session_start();
}
/* Usada em TODAS as páginas admin */
function verificaAcesso(){
    /* Se NÂO EXISTIR uma variável de SESSÃO baseada no id de usuário, 
    significa que ele/ela NÃO ESTÁ logado no sistema. */
    if( !isset($_SESSION['id'])){

        //Destrua qualquer recurso de sessão
        session_destroy();

        //Redirecione para o formulário de login
        header("location:../login.php");
        exit; // ou die ()
    }

}//fim verificaAcesso

function login($id, $nome, $tipo){
    /* Criação de variáveis de SESSSÃO */
    $_SESSION['id'] = $id;
    $_SESSION['nome'] = $nome;
    $_SESSION['tipo'] = $tipo;
    /* As variáveis de sessão ficam disponíveis para atualização durante toda a duração da sessão, ou seja, enquanto o navegador não for fechado ou o usuário estiver logado. */
} //fim login

//Usada em todas as páginas admin
function logout(){
    session_start();
    session_destroy();
    header("location:../login.php?logout");
    exit;
} //fim logout
