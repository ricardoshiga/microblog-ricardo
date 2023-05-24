<?php 
require_once "../inc/funcoes-usuarios.php";
require_once "../inc/cabecalho-admin.php";

//Se o USUARIO logado não for admin
if($_SESSION['tipo'] != "admin"){
	//Então redirecione para não-autorizado
	header("location:nao-autorizado.php");
}
/* Chamamos a função lerUsuarios, ao terminar de fazer os processos de comsulta, esta função retorna um array contendo os dados de cada usuário; e guardamos estes dados na variável abaixo. */
$usuarios = lerUsuarios($conexao);

?>



<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		
		<h2 class="text-center">
		Usuários <span class="badge bg-dark">X</span>
		</h2>

		<p class="text-center mt-5">
			<a class="btn btn-primary" href="usuario-insere.php">
			<i class="bi bi-plus-circle"></i>	
			Inserir novo usuário</a>
		</p>
				
		<div class="table-responsive">
		
			<table class="table table-hover">
				<thead class="table-light">
					<tr>
						<th>Nome</th>
						<th>E-mail</th>
						<th>Tipo</th>
						<th class="text-center">Operações</th>
					</tr>
				</thead>

				<tbody>

<!-- Começar o foreach -->

<?php foreach ($usuarios as $usuario) { ?>

					<tr>
						<td> <?= $usuario["id"] ?> <?= $usuario["nome"] ?> </td>
						<td> <?= $usuario["email"] ?>  </td>
						<td> <?= $usuario["tipo"] ?>  </td>
						<td class="text-center">
							<a class="btn btn-warning" 
							href="usuario-atualiza.php?id=<?=$usuario['id']?>">
							<i class="bi bi-pencil"></i> Atualizar
							</a>
						<!-- Paramentro de URL par acriação de um LINK DINAMICO -->
							<a class="btn btn-danger excluir" 
							href="usuario-exclui.php?id=<?=$usuario['id']?>">
							<i class="bi bi-trash"></i> Excluir
							</a>
						</td>
					</tr>
					<?php }
					?>
<!-- terminar o foreach -->
				</tbody>                
			</table>
	</div>
		
	</article>
</div>


<?php 
require_once "../inc/rodape-admin.php";
?>

