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
    significa que ele/ela NÃO ESTÁ logado no sostema. */
    if( !isset($_SESSION['id'])){

        //Destrua qualquer recurso de sessão
        session_destroy();

        //Redirecione para o formulário de login
        header("location:../login.php");
        exit; // ou die ()
    }

}