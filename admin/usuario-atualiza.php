<?php 
require_once "../inc/cabecalho-admin.php";
require_once "../inc/funcoes-usuarios.php";
/* Capturamos o parametro da URL */
$id = $_GET["id"];

/*  Chamamos a função (passando a conexão e o id do usuario),
e apos o termino da execução da função, recebemos um array associativo contendo os dados do usuario */
$usuario = lerUmUsuario($conexao, $id);
/* Detectar quando o botão/formulario é acionado */
if(isset($_POST['atualizar'])){
	
	/* Caoturando os dados digitados/existentes */

$nome = $_POST['nome'];
$email = $_POST['email'];
$tipo = $_POST['tipo'];
/* Logica para senha
Se o campo SENHA do formulario estiver vazio OU se a senha
digitada for igual à existente no banco de dados, significa que o usuario não alterou a senha.*/
	if(empty($_POST['senha']) || password_verify($_POST['senha'], $usuario['senha']) ) {
	//Então, mantenha a mesma senha ja existente no banco
	$senha = $usuario['senha'];
} else {
	//Senão, pegue a nova senha e a codifique (hash)
	$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

} //fim if/else senha

//Chamamos a função para atualizar e passamos os dados capturados
atualizarUsuario ($conexao, $id, $nome, $senha, $tipo, $email);

/* Redirecionamos para pagina com a lista de usuario */

header("location:usuarios.php"); 



} //fim if/isset botão
?>



<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		
		<h2 class="text-center">
		Atualizar dados do usuário
		</h2>
				
		<form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">

			<div class="mb-3">
				<label class="form-label" for="nome">Nome:</label>
				<input value="<?=$usuario['nome']?>"
				class="form-control" type="text" id="nome" name="nome" required>
			</div>

			<div class="mb-3">
				<label class="form-label" for="email">E-mail:</label>
				<input  value="<?=$usuario['email']?>"
				class="form-control" type="email" id="email" name="email" required>
			</div>

			<div class="mb-3">
				<label class="form-label" for="senha">Senha:</label>
				<input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
			</div>

			<div class="mb-3">
				<label class="form-label" for="tipo">Tipo:</label>
				<select class="form-select" name="tipo" id="tipo" required>
					<option value=""></option>
					<option value="editor" <?php if($usuario['tipo'] == "editor")echo "selected";?>
					>Editor</option>
					<option value="admin" <?php if($usuario['tipo'] == "admin")echo "selected";?>>Administrador</option>
				</select>
			</div>
			
			<button class="btn btn-primary" name="atualizar"><i class="bi bi-arrow-clockwise"></i> Atualizar</button>
		</form>
		
	</article>
</div>


<?php 
require_once "../inc/rodape-admin.php";
?>

