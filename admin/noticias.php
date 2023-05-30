<?php
require_once "../inc/cabecalho-admin.php";
require_once "../inc/funcoes-noticias.php";

//Recuperar (da sessão) o ID e o TIPO do usuario logado

$idUsuario = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];

/* Executando a função lerNoticia e guardando a matriz com 
os dados de cada uma das noticias */
$noticias = lerNoticias($conexao, $idUsuario, $tipoUsuario);

?>



<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">

		<h2 class="text-center">
			Notícias <span class="badge bg-dark"> <?= count($noticias) ?> </span>
		</h2>

		<p class="text-center mt-5">
			<a class="btn btn-primary" href="noticia-insere.php">
				<i class="bi bi-plus-circle"></i>
				Inserir nova notícia</a>
		</p>

		<div class="table-responsive">

			<table class="table table-hover">
				<thead class="table-light">
					<tr>
						<th>Título</th>
						<th>Data</th>
						<?php if ($tipoUsuario == 'admin') { ?>
							<th>Autor</th>
						<?php } ?>
						<th class="text-center">Operações</th>
					</tr>
				</thead>

				<tbody>

					<?php foreach ($noticias as $noticia) { ?>
						<tr>
							<td> <?= $noticia["titulo"] ?> </td>
							<td> <?= formataData ($noticia["data"]) ?> </td>

							<?php if ($tipoUsuario == 'admin') { ?>
								<td><?= $noticia["nome"] ?></td>
							<?php } ?>

							<td class="text-center">
								<!-- parametro de url pro link dinamico -->
								<a class="btn btn-warning" 
								href="noticia-atualiza.php?id=<?=$noticia['id']?>">
									<i class="bi bi-pencil"></i> Atualizar
								</a>

								<a class="btn btn-danger excluir" href="noticia-exclui.php?id=<?=$noticia['id']?>">
									<i class="bi bi-trash"></i> Excluir
								</a>
							</td>
						</tr>

					<?php } ?>

				</tbody>
			</table>
		</div>

	</article>
</div>


<?php
require_once "../inc/rodape-admin.php";
?>