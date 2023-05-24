<?php
require "inc/cabecalho.php";
require_once "inc/funcoes-usuarios.php";
require_once "inc/funcoes-sessao.php";

/* Programação das mensagens de feedback */
/* Se ouver o parâmetro "campos_obrigatorios" na URL, significa que o usuário
não preencheu e-mail. e senha, */
if (isset($_GET["campos_obrigatorios"])) {
	//Portanto, exibiremos esta mensagem
	$mensagem = "Você deve preencher e-mail e senha!";
} elseif(isset($_GET["dados_incorretos"])){
	$mensagem = "Dados incorretos, verifique e-mail e/ou senha!";
} elseif(isset($_GET['logout'])){
	$mensagem = "Você saiu do sistema!";
}

?>

<div class="row">
	<div class="bg-white rounded shadow col-12 my-1 py-4">
		<h2 class="text-center fw-light">Acesso à área administrativa</h2>

		<form action="" method="post" id="form-login" name="form-login" class="mx-auto w-50" autocomplete="off">

			<?php if(isset($mensagem)){ ?>
				<!-- Mostramos! -->
			<p class="my-2 alert alert-warning text-center">
				<?=$mensagem?>
			</p>
					<?php } ?>
					
			<div class="mb-3">
				<label for="email" class="form-label">E-mail:</label>
				<input class="form-control" type="email" id="email" name="email">
			</div>
			<div class="mb-3">
				<label for="senha" class="form-label">Senha:</label>
				<input class="form-control" type="password" id="senha" name="senha">
			</div>

			<button class="btn btn-primary btn-lg" name="entrar" type="submit">Entrar</button>

		</form>
		<?php
		if (isset($_POST["entrar"])) {
			/* Verificar se os campos foram preenchidos */
			if (empty($_POST["email"]) || empty($_POST["senha"])) {
				header("location:login.php?campos_obrigatorios");
				exit; //ou die()
			} //fim if validação
		
			//Capturar o e-mail e senha digitados
			$email = $_POST['email'];
			$senha = $_POST['senha'];

			/* Buscando no banco de dados usuário de acordo 
			com o e-mail informado */
			$dadosUsuario = buscaUsuario($conexao, $email);

			/* Verificação de senha */
			if($dadosUsuario != null && password_verify($senha, $dadosUsuario['senha'])){
				login(
					$dadosUsuario['id'],
					$dadosUsuario['nome'],
					$dadosUsuario['tipo']
				);
				header("location:admin/index.php");
				exit;

			} else {
				//Caso contrário, fique no login e avise o usuário
				header("location:login.php?dados_incorretos");
				exit;
			}

		} //fim if isset entrar

		?>


	</div>


</div>

<?php
require_once "inc/rodape.php";
?>