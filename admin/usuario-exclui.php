<?php
require_once "../inc/funcoes-usuarios.php";

/* Capturando o valor recebido pelo parametroid atraves da URL */
$id = $_GET["id"];

/* Chamando a funçãoa excluir usuario passando o id do usuario que ser aexcluido */
excluiUsuario($conexao, $id);

/* Voltando para a pagina com a tabela/lista de usuário */
header("location:usuarios.php");