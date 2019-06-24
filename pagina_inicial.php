<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>

<?php
	$nome = $imagem = $mensagem = $tema = $usuario = $id_usuario = "";
	if($_SERVER["REQUEST_METHOD"] == "GET"){
		
		$conexao = mysqli_connect("localhost", "root", "abc123", "tutorias");
		$query = "SELECT id, nome, usuario, imagem FROM usuarios where id = '" .$_GET['id']. "'";
		$result = mysqli_query($conexao, $query);
		if(isset($_GET['tema']) and $_GET['tema'] != ""){
			$tema = $_GET['tema'];
			$mensagem = "Resultados de sua busca por '" .$tema. "':";
		}
		while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$id_usuario = $linha["id"];
			$nome = $linha["nome"];
			$usuario = $linha["usuario"];
			$imagem = $linha["imagem"];
		}
		if(isset($_GET['acao']) == 1){
			if($_GET['acao'] == "aceitar"){
				$query = "UPDATE tutorias SET status = 2 WHERE id = " .$_GET['id_tutoria'];
				echo "aaa";
			}
			else if($_GET['acao'] == "recusar"){
				$query = "UPDATE tutorias SET status = 0 WHERE id = " .$_GET['id_tutoria'];
			}

			if($result = mysqli_query($conexao, $query)) echo "bbbb";
			$destino = "Location: pagina_inicial.php?id=" .$id_usuario. "&tema=";
			header($destino);
		}
	}
?>

<html encoding = "utf8">
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<link rel="stylesheet" type="text/css" media="screen" href="estilos.css">
		<title>Página Inicial</title>
	</head>
	<body>
		<div id = "div_geral">

			<div id = "div_perfil"><h3>Informações Gerais</h3>
				<img src = "<?php echo $imagem?>" class = "avatar">
				<p>Bem vindo, <span><?php echo $nome; ?></span>!</p>
				<p><a href = "perfil.php?id=<?php echo $id_usuario?>"><input type = "button" class = "botao" id = "perfil" value = "Perfil"></a></p>
				<p><a href = "login.php"><input type = "button" class = "botao" id = "sair" value = "Sair"></a></p>				
			</div>

			<div id = "div_disciplinas"><h3>Disciplinas</h3>

				<form name = "busca_tema" method = "GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <input type = "hidden" id = "id" name = "id" value = "<?php echo $id_usuario?>">
                        Busca por nome: <input type = "text" id = "tema" name = "tema"> 
                        <input type = "submit" id = "enviar" value = "Buscar" class = "botao">
                        <a href = "<?php echo "pagina_inicial.php?id=" .$id_usuario. "&tema=" ?>"><input type = "button" id = "enviar" value = "Mostrar Todos" class = "botao"></a>
				</form>
				<span style = "align: left;"> <?php echo $mensagem; ?></span> 
				<table>						
					<?php
						$query = "SELECT COUNT(id_aluno) as total_tutorias FROM tutorias WHERE id_aluno = " .$id_usuario. "";
						$result = mysqli_query($conexao, $query);
						$linha = mysqli_fetch_array($result, MYSQLI_ASSOC);
						if($linha['total_tutorias'] == 5){
							echo "<h4>Você já atingiu o número máximo de tutorias ativas! finalize as atuais para poder pedir novas!</h4>";
						}else{
							echo "<tr>";
							echo "<th align = \"left\">Sigla</th>";
							echo "<th align = \"left\">Nome</th>";
							echo "<td> </td>";
							echo "</tr>";
							$query = "SELECT id, sigla, nome FROM disciplinas WHERE nome LIKE '%" .$tema. "%'";
							$result = mysqli_query($conexao, $query);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
							while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)){
								echo "<tr><td>" .$linha['sigla']. "</td><td>" .$linha['nome']. "</td><td> <a href=\"lista_tutores.php?usuario=" .$usuario. "&id=" .$linha['id']. "&tutor= \"><input type = \"button\" class = \"botao\" id = \"[]\" value = \"Consultar tutores\"></a> </td></tr>";
							}
						}
					?>
				</table>

			</div>

			<div id = "div_tutorias" class = "div_tutorias">
			<strong>Tutorias</strong>
				<table>
					<tr>
						<td>Aluno</td>
						<td>Disciplina</td>
						<td>Status</td>
					</tr>
					<?php
						$query = "SELECT * FROM tutorias WHERE id_tutor = " .$id_usuario. " AND status <> 0 AND status <> 3 LIMIT 5";
						$result = mysqli_query($conexao, $query);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
						while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)){
							echo "<tr>";
								
								$query_interna = "SELECT nome FROM usuarios where id = " .$linha['id_aluno'];
								$result_interno = mysqli_query($conexao, $query_interna);
								$linha_interna = mysqli_fetch_array($result_interno, MYSQLI_ASSOC);
								echo "<td>" .$linha_interna['nome']. "</td>";
								
								$query_interna = "SELECT nome FROM disciplinas where id = " .$linha['id_disciplina'];
								$result_interno = mysqli_query($conexao, $query_interna);
								$linha_interna = mysqli_fetch_array($result_interno, MYSQLI_ASSOC);
								echo "<td>" .$linha_interna['nome']. "</td>";

								if($linha['status'] == 1){
									echo "<td>";
									echo "<a href = pagina_inicial.php?id=" .$id_usuario. "&acao=aceitar&id_tutoria=" .$linha['id']. ">";
										echo "<img id = \"aceitar\" src = \"recursos/aceitar.png\" style = \"top: -5px; width:20px; height:auto;\">";
									echo "</a>";

									echo "<a href = pagina_inicial.php?id=" .$id_usuario. "&acao=recusar&id_tutoria=" .$linha['id']. ">";
										echo "<img id = \"rejeitar\" src = \"recursos/rejeitar.png\" style = \"width:25px; height:auto;\"></td>";							
									echo "</a>";
								}else if($linha['status'] == 2){
									echo "<td>Ativa/Esperando avaliação</td>";							
								}

							echo "</tr>";
						}
					?>
				</table>				
			</div>

			<div id = "div_aulas" class = "div_tutorias" style = "top: 50%;">
			<strong>Aulas</strong>
				<table>
					<tr>
						<td>Tutor</td>
						<td>Disciplina</td>
						<td>Status</td>
					</tr>
					<?php
						$query = "SELECT * FROM tutorias WHERE id_aluno = " .$id_usuario. " AND status <> 3 LIMIT 5";
						$result = mysqli_query($conexao, $query);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
						while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)){
							echo "<tr>";
								
								$query_interna = "SELECT nome FROM usuarios where id = " .$linha['id_tutor'];
								$result_interno = mysqli_query($conexao, $query_interna);
								$linha_interna = mysqli_fetch_array($result_interno, MYSQLI_ASSOC);
								echo "<td>" .$linha_interna['nome']. "</td>";
								
								$query_interna = "SELECT nome FROM disciplinas where id = " .$linha['id_disciplina'];
								$result_interno = mysqli_query($conexao, $query_interna);
								$linha_interna = mysqli_fetch_array($result_interno, MYSQLI_ASSOC);
								echo "<td>" .$linha_interna['nome']. "</td>";
								
								if(!$linha['status']){
									echo "<td>Pedido negado</td>";							
									$query_interna = "DELETE FROM tutorias WHERE id =" .$linha['id'];
									$result_interno = mysqli_query($conexao, $query_interna);
								}else if($linha['status'] == 1){
									echo "<td> Esperando confirmação</td>";							
								}else{
									echo "<td>";
										echo "<a href = \"info_tutor.php?id_tutor=" .$linha['id_tutor']. "&id_aluno=" .$id_usuario. "\">";
										echo "<input type = \"button\" class = \"botao\" id = \"[]\" value = \"Contato tutor\"></a>";
										
										echo "<a href = \"avaliar.php?id=" .$linha['id']. "\">";
										echo "<input type = \"button\" class = \"botao\" id = \"[]\" value = \"Avaliar tutoria\"></a>";
									echo "</td>";							
								}
							echo "</tr>";
						}
					?>
				</table>				
			</div>
		</div>
	</body>	
</html>
