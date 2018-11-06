<?php
	require 'Mensagens.php';

	if (isset($_POST) && sizeof($_POST) > 0) {
	  $dados = new Mensagens();
	  $id = $dados->enviar($_POST);
	  echo $id;
	}
?>