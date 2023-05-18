<?php
/* Parâmetros de acesso ao servidos de banco de dados MySQL */
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "microblog-ricardo";

/* usando a função mysqli_connect para conectar ao servidor */
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

/* Definindo o chatset UTF8 tambem para a comunicação com o banco de dados */
mysqli_set_charset($conexao, "utf8");

if( !$conexao ) {
    die(mysqli_connect_error($conexao));
} else {
    //Senão, deu tudo certo!
    echo "<p>Beleza, banco conectado!</p>";
}

