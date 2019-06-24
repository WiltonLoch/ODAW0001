<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>

<?php
	$erro_login = "";
	$id_usuario = "";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$conexao = mysqli_connect("localhost", "root", "abc123", "tutorias");
		$query = "SELECT id, usuario, senha FROM usuarios";
		$result = mysqli_query($conexao, $query);		
		$erro = true;	
		while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			 if($_POST["login"] == $linha["usuario"]){
				if($_POST["senha"] == $linha["senha"]){
					$erro = false;
					$id_usuario = $linha["id"];
					break;
				}
			 }
		}
		if($erro == FALSE){
			$destino = "Location: pagina_inicial.php?id=" .$id_usuario. "&tema=";
			header($destino);
			// echo $id;
		}else{
			$erro_login = "*usuário ou senha incorretos!";
		}
	}
?>

<html>
	<head>
		<title>Login</title>
	</head>
	<body align = "center">
		<br><br><br><br><h2>Logar</h2>
		<form name = "login" method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<span class = "error"><?php echo $erro_login;?></span><br>
			Login: <input type = "text" name = "login"><br>
			Senha: <input type = "password" name = "senha"><br>
			<br><input type = "submit" value = "Logar">
		</form>
	</body>	
</html>
