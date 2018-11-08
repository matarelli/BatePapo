<?php
	require 'Mensagens.php';

	$dados = new Mensagens();
	$dados->conectar();

	if (!isset($_GET['id'])) {
		echo 'Id não informado';
		exit;
	}

	$mensagens = $dados->getTodasMensagensAPartirDe($_GET['id']);

	header('Content-Type: application/json');
	echo json_encode($mensagens->fetchAll());