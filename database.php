<?php
	mysqli_report(MYSQLI_REPORT_STRICT);

	function open_database() {
		try {
			$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			return $conn;
		} catch (Exception $e) {
			//echo $e->getMessage();
			return null;
		}
	}
	function close_database($conn) {
		try {
			mysqli_close($conn);
		} catch (Exception $e) {
			// echo $e->getMessage();
		}
	}

	function busca( $tabela = null, $id = null ) {

		$database = open_database();
		$found = null;
		try {
		  	if ($id) {
			    $sql = "SELECT * FROM " . $tabela . " WHERE id = " . $id . " ORDER BY nome ";
		    	$result = $database->query($sql);

			    if ($result->num_rows > 0) {
			      	$found = $result->fetch_assoc();
			    }
		  	} else {
		    	$sql = "SELECT * FROM " . $tabela . " ORDER BY nome ";
		    	$result = $database->query($sql);

			    if ($result->num_rows > 0) {
			    	while($row=$result->fetch_assoc()) { $found[] = $row; }
			    }
		  	}
		} catch (Exception $e) {
			global $_SESSION;
		  	$_SESSION['mensagem'] = $e->GetMessage();
		  	$_SESSION['type'] = 'danger';
	  	}

		close_database($database);
		return $found;
	}

	function busca_tudo( $tabela ) {
  		return busca($tabela);
	}

	function adicionar() {
	    save('produtos', $_POST);
	    echo " ";
	    header('location: index.php');
	}

	function save($table = null, $data = null) {
	  	$database = open_database();
	  	$columns  = null;
	  	$values   = null;

	  	foreach ($data as $key => $value) {
	    	$columns .= trim($key, "'") . ",";
	    	$values .= "'$value',";
	  	}

	  	$columns = rtrim($columns, ',');
	  	$values = rtrim($values, ',');

		$sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";
	  	try {
			$database->query($sql);
			global $_SESSION;
	    	$_SESSION['mensagem'] = 'Produto cadastrado com sucesso.';
	    	$_SESSION['type'] = 'success';

	  	} catch (Exception $e) {
	  		global $_SESSION;
	    	$_SESSION['mensagem'] = 'Não foi possivel realizar a operação.';
	    	$_SESSION['type'] = 'danger';
	  	}

	  	close_database($database);
	}

	function editar() {
	  	if (isset($_GET['id'])) {
	    	$id = $_GET['id'];
	      	global $produto;
	      	$produto = busca('produtos', $id);
	  	} else {
	  		echo " ";
	    	header('location: index.php');
	  	}
	}

	function editar_salvar() {
		$id = $_POST['id'];
	    atualizar('produtos', $id, $_POST);
	    echo " ";
	    header('location: index.php');
	}

	function atualizar($table = null, $id = 0, $data = null) {
  		$database = open_database();
  		$items = null;

  		foreach ($data as $key => $value) {
    		$items .= trim($key, "'") . "='$value',";
  		}

  		$items = rtrim($items, ',');
  		$sql  = "UPDATE " . $table;
  		$sql .= " SET $items";
  		$sql .= " WHERE id=" . $id . ";";

  		try {
    		$database->query($sql);
    		global $_SESSION;
    		$_SESSION['mensagem'] = 'Produto atualizado com sucesso.';
    		$_SESSION['type'] = 'success';
  		} catch (Exception $e) {
  			global $_SESSION;
    		$_SESSION['mensagem'] = 'Nao foi possivel realizar a operacao.';
    		$_SESSION['type'] = 'danger';
  		}
  		close_database($database);
	}

	function apagar($id = null) {
  		global $produto;
  		$produto = remover( 'produtos', $id );
  		echo " ";
  		header('location: index.php');
	}

	function remover($table = null, $id = null ) {
	  	$database = open_database();

	  	try {
		    if ($id) {
	      		$sql = "DELETE FROM " . $table . " WHERE id = " . $id;
	      		$result = $database->query($sql);
		      	if ($result = $database->query($sql)) {
		      		global $_SESSION;
		        	$_SESSION['mensagem'] = "Produto removido com sucesso.";
		        	$_SESSION['type'] = 'success';
		      	}
	    	}
	  	} catch (Exception $e) {
	   		global $_SESSION;
	   		$_SESSION['mensagem'] = $e->GetMessage();
	    	$_SESSION['type'] = 'danger';
	  	}
	  	close_database($database);
	}
