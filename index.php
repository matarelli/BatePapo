<?php
	require 'Mensagens.php';
	$dados = new Mensagens();
	$dados->conectar();
	$mensagens = $dados->getTodasMensagens();
	foreach ($mensagens as $msg) {
	    echo "<h3>" .$msg['remetente']. " escreveu (ID: " .$msg['id']. "):</h3>";
	    echo "<p>";
	    echo nl2br($msg['texto']);
	    echo "</p>";
	}
?>

<form action="enviar.php" method="POST">
	<label for="remetente">Remetente:</label>
	<input type="text" id="remetente" name="remetente">
	<label for="texto">Mensagem:</label>
	<input type="text" id="texto" name="texto">
	<button type="submit" name="enviar">Enviar (Enter)</button>
</form>

<script type="text/javascript">
	var form = document.querySelector('form');
	var remetente = document.querySelector('#remetente');
	var texto = document.querySelector('#texto');

	function enviarViaAJAX(e) {
	    e.preventDefault();

	    var dados = new FormData(form);
	    
	    var xhr = new XMLHttpRequest();
	    xhr.onload = function() {
		    mostrarMensagem(remetente.value, texto.value, xhr.responseText);
		    ultimoId = xhr.responseText;
		    limparForm();
	    };

	    xhr.open('POST', 'enviar.php');
	    xhr.send(dados);
  	}

	form.onsubmit = enviarViaAJAX;

	function mostrarMensagem(id) {
		var h3 = document.createElement('h3');
		h3.textContent = remetente.value + ' escreveu (ID: ' + id + '):';
		var p = document.createElement('p');
		p.textContent = texto.value;
		form.parentNode.insertBefore(form, h3);
		form.parentNode.insertBefore(form, p);
	}
	function limparForm() {
		remetente.value = '';
		texto.value = '';
	}
	function buscarMensagens() {
		var xhr = new XMLHttpRequest();

		xhr.onload = function() {
			var msgs = JSON.parse(xhr.responseText);
			msgs.forEach(m => mostrarMensagem(m.remetente, m.texto, m.id));
			ultimoId = msgs.length ? msgs.pop().id : ultimoId;
			setTimeout(buscarMensagens, 1000);
		}

		xhr.open('GET', 'buscar.php?id=' + ultimoId);
		xhr.send();
	}
	function mostrarMensagem(remetente, texto, id) {
	    var h3 = document.createElement('h3');
	    h3.textContent = remetente + ' escreveu (ID: ' + id + '):';
	    var p = document.createElement('p');
	    p.textContent = texto;
	    form.parentNode.insertBefore(h3, form);
	    form.parentNode.insertBefore(p, form);
  	}

	window.onload = buscarMensagens;
	var ultimoId = 0;
</script>