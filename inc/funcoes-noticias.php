<?php
require_once "conecta.php";

/* Usada em noticia-insere.php */
function  inserirNoticias($conexao, $titulo, $texto, $resumo, $imagem, $idUsuarioLogado)
{
    $sql = "INSERT INTO noticias(titulo, texto, resumo, imagem, usuario_id) VALUES('$titulo', '$texto', '$resumo', '$imagem', $idUsuarioLogado)";

    mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
} // fim inserirNoticias

/* Usadaem noticia-insere.php e noticia-atualiza.php */
function upload($arquivo)
{

    /* Array contendo a lista de formatos de imagem válidos */
    $tiposValidos = ["image/png", "image/jpeg", "image/gif", "image/svg+xml"];

    /* Validação do formato de imagem
    Se o formato do arquivo enviado NÂO ESTIVER LISTADO dentro do array $tiposValidos, para tudo e informe o usuário (dizendo que é um formato inválido) */
    if (!in_array($arquivo['type'], $tiposValidos)) {
        echo "<script>alert('Formato inválido!'); history.back();</script>";
        exit;
    }

    //Extraindo do arquivo apenas o "name" dele
    $nome = $arquivo['name'];

    //Extraindo do srquivo apanas o diretótio/nome TEMPORÁRIO
    $temporario = $arquivo['tmp_name'];

    //Definindo a pasta final/destino dentro do nosso site
    //Usamos . para concatenar o caminho com o nome do arquivo
    $destino = "../imagem/" . $nome;

    //Mover o arquivo enviado da area temporaria no servidor, para a pasta de destino final dentro do site
    move_uploaded_file($temporario, $destino);
} // fim upload

//Usada em noticias.php
function lerNoticias($conexao, $idUsuarioLogado, $tipoUsuarioLogado)
{
    if ($tipoUsuarioLogado == 'admin') {
        $sql = "SELECT noticias.id, noticias.titulo, noticias.data, usuarios.nome
            FROM noticias INNER JOIN usuarios
            ON noticias.usuario_id = usuarios.id
            ORDER BY data DESC";
    } else {
        /* SQL do editor: pode carregar/ver  tudo APENAS DELE */
        $sql = "SELECT * FROM noticias WHERE usuario_id = $idUsuarioLogado ORDER BY data DESC";
    }

    // SQL PROVISÓRIO

    $resultado = mysqli_query($conexao, $sql) or
        die(mysqli_error($conexao));
    //Array vazio
    $noticias = [];

    /* Enquanto houver dados de cada noticia no resultado fo SELECT SQL,
    guarde cada uma das noticias e seus dados em uma variavel ($noticia) */
    while ($noticia = mysqli_fetch_assoc($resultado)) {
        array_push($noticias, $noticia);
    }

    /* Retornar a matriz de noticias */
    return $noticias;
} //fim de lerNoticias

/* Usada em noticias.php e paginas da area publica */
function formataData($data)
{
    return date("d/m/Y H:i", strtotime($data));
} // fim formataData

/* Usada em noticia-atualiza.php */
function lerUmaNOticia($conexao, $idNoticia, $idUsuarioLogado, $tipoUsuarioLogado)
{

    if ($tipoUsuarioLogado == 'admin') {
        /* SQL do admin: carrega os dados de qualquer noticia */
        $sql = "SELECT * FROM noticias WHERE id = $idNoticia";
    } else {
        /* SQL do editor: carrega os dados SOMENTE da noticia dele */
        $sql = "SELECT * FROM noticias WHERE id = $idNoticia
            AND usuario_id = $idUsuarioLogado";
    }

    $resultado = mysqli_query($conexao, $sql)
        or die(mysqli_error($conexao));

    return mysqli_fetch_assoc($resultado);
} // fim lerUmaNoticia

/* Usada em noticia-atualiza.php */
function atualizaNoticia(
    $conexao,
    $titulo,
    $texto,
    $resumo,
    $imagem,
    $idNoticia,
    $idUsuarioLogado,
    $tipoUsuarioLogado
) {

    if ($tipoUsuarioLogado == 'admin') {
        $sql = "UPDATE noticias SET 
        titulo = '$titulo', texto = '$texto', 
        resumo = '$resumo', imagem = '$imagem'
        WHERE id = $idNoticia";
    } else {
        /* SQL do editor: pode atualizar somente sua propria noticia */
        $sql = "UPDATE noticias SET
        titulo = '$titulo', texto = '$texto', 
        resumo = '$resumo', imagem = '$imagem'
        WHERE id = $idNoticia AND usuario_id = $idUsuarioLogado";
    }
    mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
} // fim atualizarNoticia

function excluirNoticia($conexao, $idNoticia, $idUsuarioLogado, $tipoUsuarioLogado)
{

    if ($tipoUsuarioLogado == 'admin') {
        /* SQL doadmin: pode apagar qualquer noticia pelo id */
        $sql = "DELETE FROM noticias WHERE id = $idNoticia";
    } else {
        /* SQL do editor: pode apagar SOMENTE suas proprias noticias (pelo id da noticia e pelo seu proprio id)  */
        $sql = "DELETE FROM noticias WHERE id = $idNoticia
                AND usuario_id = $idUsuarioLogado";
    }

    mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

} // fim excluirNoticia

function lerTodasNoticias($conexao){
    //Montando o comando SQL SELECT para leitura dos usuarios
    $sql = "SELECT * FROM noticias ORDER BY data DESC";

     // Guardando o resultado da operação de consulta SELECT
    $resultado = mysqli_query($conexao, $sql ) 
    or die(mysqli_error($conexao));

    /* Criando um array vazio que receberá outros arrays contendo os dados de cada usuário */
    $noticias = [];

    /* Loop while (enquanto) que a cada ciclo de repetição, erá extrair os dados de cada usuário provenientes do resultado da consulta. Essa extração é feita pela função mysqli_fetch_assoc e é guardada na variável $usuario. */
    while($noticia = mysqli_fetch_assoc($resultado)){

        /* Pegamos os dados de cada $noticia (array),
        e os colocamos dentro (array_push)
        do grande array $noticias. */
        array_push($noticias, $noticia);
    }

    /* Levamos para fora da função a matriz $usuarios, contendo os dados de cada $usuario*/
    return $noticias;

}

/* Usada em noticias.php */
function lerDetalhes($conexao, $id){
    $sql = "SELECT
    noticias.id,
    noticias.titulo,
    noticias.data,
    noticias.imagem,
    noticias.texto,
    usuarios.nome
    FROM noticias INNER JOIN usuarios ON noticias.usuario_id = usuarios.id
    WHERE noticias.id = $id";

    $resultado = mysqli_query($conexao, $sql)
                 or die(mysqli_error($conexao));

    return mysqli_fetch_assoc($resultado);             

} // fim lerDetalhes

/* Usada em resultados.php */
function busca($conexao, $termo){
    $sql = "SELECT * FROM noticias WHERE 
                titulo LIKE '%$termo%' OR
                texto LIKE '%$termo%' OR
                resumo LIKE '%$termo%' OR
            ORDER BY data DESC/

    $resultado = mysqli_query($conexao, $sql)
                 or die(mysqli_error($conexao));

     $noticias = [];
     
     while($noticia = mysqli_fetch_assoc($resultado)){
            array_push($noticias, $noticia);
     }

     return $noticias;

}  //fim busca