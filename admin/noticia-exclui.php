<?php
require_once "../inc/funcoes-sessao.php";
require_once "../inc/funcoes-noticias.php";

verificaAcesso();

//Pegando o id da noticia vindo do parametro de URL
$idNoticia = $_GET['id'];

//Pegando o id e o tipo do usuario logado
$idUsuario = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];

excluirNoticia($conexao, $idNoticia, $idUsuario, $tipoUsuario);

//Voltando pra paginas das noticias
header("location:noticias.php");
