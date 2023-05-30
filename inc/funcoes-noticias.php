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