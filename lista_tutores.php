<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>

<?php
	$nome = $imagem = $mensagem = $nome_tutor = $id_usuario = $id_disciplina = $tema = "";
	if($_SERVER["REQUEST_METHOD"] == "GET"){
		$conexao = mysqli_connect("localhost", "root", "abc123", "tutorias");
		$query = "SELECT id, nome, imagem FROM usuarios where usuario = '" .$_GET['usuario']. "'";
		$result = mysqli_query($conexao, $query);		
		while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$id_usuario = $linha["id"];
			$nome = $linha["nome"];
			$imagem = $linha["imagem"];
        }
        $query = "SELECT id, nome FROM disciplinas where id = '" .$_GET['id']. "'";
		$result = mysqli_query($conexao, $query);	
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $id_disciplina = $linha["id"];
            $tema = $linha["nome"];
        }
        $tutor = $_GET['tutor'];
        if($tutor != ""){
			$mensagem = "Resultados de sua busca por '" .$tutor. "':";
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
				<p><a href = "perfil.php"><input type = "button" class = "botao" id = "perfil" value = "Perfil"></a></p>
				<p><a href = "login.php"><input type = "button" class = "botao" id = "sair" value = "Sair"></a></p>				
			</div>

            <div id = "div_disciplinas" style = "width: 77%;">
                    
            <a href = "<?php echo "pagina_inicial.php?id=" .$id_usuario. "&tema=" ?>"><img src = "recursos/seta.png" align = "left" style = "width:20px; height:auto;"></a> Tutores disponíveis para <?php echo $tema?><br><br>

				<form name = "busca_tema" method = "GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <input type = "hidden" id = "usuario" name = "usuario" value = "<?php echo $_GET['usuario']?>">
                        <input type = "hidden" id = "id" name = "id" value = "<?php echo $id_disciplina?>">
                        Busca por nome: <input type = "text" id = "tutor" name = "tutor"> 
                        <input type = "submit" class = "botao" id = "enviar" value = "Buscar">
                        <a href = "<?php echo "lista_tutores.php?usuario=" .$nome. "&id=" .$id_disciplina. "&tutor=" ?>"><input type = "button" class = "botao" id = "enviar" value = "Mostrar Todos"></a>
				</form>
				<span style = "align: left;"> <?php echo $mensagem; ?></span> 
				<table style = "text-align: center;">
                        <th>Nome</th>
						<th>Universidade</th>
						<th>Avaliação</th>
						<th>Tutorias realizadas</th>
						<th></th>
						<?php							
							$query = "SELECT u.id, u.nome, u.universidade FROM usuarios as u JOIN usuarios_disciplinas as ud on u.id = ud.id_usuario WHERE u.nome LIKE '%" .$_GET['tutor']. "%' AND ud.id_disciplina = " .$_GET['id']. " AND u.id <>" .$id_usuario;
							$result = mysqli_query($conexao, $query);
							$registros = false;
                            while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)){
									$registros = true;
									$query_interna = "SELECT COUNT(id) as avaliacoes, AVG(avaliacao) as avaliacao FROM tutorias WHERE id_tutor = " .$linha['id']. " AND id_disciplina = " .$_GET['id']. " AND status = 3";
									$result_interno = mysqli_query($conexao, $query_interna);
									$linha_interna = mysqli_fetch_array($result_interno, MYSQLI_ASSOC);

									echo "<tr><td>" .$linha['nome']. "</td><td>" .$linha['universidade']. "</td><td>";
									if($linha_interna['avaliacao']){
										echo $linha_interna['avaliacao'];
									}else{
										echo 0;
									}
									echo " <img src = \"recursos/estrela.png\" style = \" vertical-align: top; width:18px; height:auto;\"></td>";
									echo "<td>" .$linha_interna['avaliacoes']. "</td>";
									echo "<td>";
									echo "<a href = \"insere_tutoria.php?tutor=" .$linha['id']. "&aluno=" .$id_usuario. "&tema=" .$id_disciplina. "\">";
									echo "<input type = \"button\" class = \"botao\" id = \"[]\" value = \"Pedir tutoria\"></a></td></tr>";
                            }
							if(!$registros) echo "<h4>Infelizmente não foram encontrados tutores disponíveis.</h4>";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
						?>
				</table>

			</div>
		</div>
	</body>	
</html>
