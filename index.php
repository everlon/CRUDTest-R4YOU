<?php
	include_once('config.php');
	include_once('database.php');

	$db = open_database();

	if ($_GET['p'] == 'adicionar') {
		(!$_POST['id']) ? adicionar() : editar_salvar() ;
	}
	elseif ($_GET['p'] == 'apagar') {
		if (isset($_GET['id'])) {
    		apagar($_GET['id']);
  		} else {
    		exit("ERRO: ID não definido.");
  		}
	}
?>

<!DOCTYPE html>
<html lang="en">
  	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	    <title>CRUD-Teste R4YOU</title>

	    <link href="<?php echo BASEURL; ?>assets/css/bootstrap.min.css" rel="stylesheet">
	    <link href="<?php echo BASEURL; ?>assets/css/custom.css" rel="stylesheet">
	    <link href="<?php echo BASEURL; ?>assets/css/font-awesome.min.css" rel="stylesheet">

    	<script type="text/javascript" src="http://code.jquery.com/jquery-3.0.0.min.js"></script>
	    <script type="text/javascript" src="assets/js/jquery.mask.min.js"></script>
  	</head>

	<body>
	    <div class="container">
			<div class="header clearfix">
			    <nav>
			      <ul class="nav nav-pills float-right">
			        <li class="nav-item">
			          	<a class="nav-link" href="<?php echo BASEURL; ?>">Produtos</a>
			        </li>
			        <li class="nav-item">
			          	<a class="nav-link btn-primary" href="<?php echo BASEURL; ?>?p=novo">Novo</a>
			        </li>
			      </ul>
			    </nav>
			    <h3 class="text-muted">CRUD Test - R4YOU</h3>
			</div>

			<?php if(!empty($_SESSION['mensagem'])) { ?>
				<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php echo $_SESSION['mensagem']; ?>
				</div>
				<?php } ?>

			<?php if (!$db) { ?>
			    <div class="alert alert-danger" role="alert">
			        <p><strong>ERRO:</strong> Não foi possível Conectar ao Banco de Dados!</p>
			    </div>
			<?php
				} else {
					if ($_GET['p'] == 'novo') {
						include_once('novo_item.php');
					}
					elseif ($_GET['p'] == 'editar') {
						editar();
						include_once('novo_item.php');
					}
					else {
						include_once('lista_itens.php');
					}
				}
			?>

			<footer class="footer"><p>&copy; Everlon Passos 2017</p></footer>
		</div>
	</body>
</html>
