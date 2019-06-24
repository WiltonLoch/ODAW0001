<?php
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
?>

<html>
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<link rel="stylesheet" type="text/css" media="screen" href="estilos.css">
		<title>Editar informações</title>
	</head>
	<body>
		<?php
			function teste_login($login){
				if(strlen($login) > 30){
					return 0;
				}
				$conexao = mysqli_connect("localhost", "root", "abc123", "tutorias");
				$query = "SELECT * FROM usuarios where usuario = ".$login." and id <> ".$_POST['$id'];
				$result = mysqli_query($conexao, $query);
				$num_rows = mysqli_num_rows($result);
				if($num_rows > 0){
					return 4;
				}
				return 1;
			}
			
			function teste_senha($senha){
				if(strlen($senha) < 6 || strlen($senha) > 30){
					return 0;
				}
				return 1;
			}
			function teste_csenha($senha, $csenha){
				if($senha != $csenha){
					return 0;
				}
				return 1;
			}
			function teste_personagem($personagem){
				if(strlen($personagem) > 30){
					return 0;
				}
				return 1;
			}
		?>
		
		<?php
			$name_err = $email_err = $genero_err = $date_err = $login_err = $senha_err = $csenha_err = $fb_err = $cpf_err = $termos_err = "";
			$name = $email = $genero = $date = $login = $senha = $csenha = $facebook = $descricao = $cpf = $termos = "";
			$id = "";
			$fail = false;
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$id = $_POST["id"];
				$name = $_POST["nome"];
				$sobrenome = $_POST["sobrenome"];
				$date = $_POST["nascimento"];
				$email = $_POST["email"];
				$genero = $_POST["genero"];
				$login = $_POST["login"];
				$senha = $_POST["senha"];
				$csenha = $_POST["csenha"];
				$CPF = $_POST["cpf"];
				$facebook = $_POST["facebook"];
				$descricao = $_POST["descricao"];
				if(empty($name)){
					$name_err = "Campo obrigátorio";
					$fail = true;
				}
				if(empty($date)){
					$date_err = "Campo obrigatório";
					$fail = true;
				}
				if(empty($email)){
					$email_err = "Campo obrigatório";
					$fail = true;
				}
				if(empty($genero)){
					$genero_err = "Campo obrigatório";
					$fail = true;
				}
				if(empty($login)){
					$login_err = "Campo obrigatório";
					$fail = true;
				} else {
					$res = teste_login($login);
					if($res == 4){
						$login_err = "Login já existe";
						$fail = true;
					} else if($res == 0){
						$login_err = "Login inválido";
						$fail = true;
					}
				}
				if(empty($senha)){
					$senha_err = "Campo obrigatório";
					$fail = true;
				} else if(teste_senha($senha) == 0){
					$senha_err = "Senha inválida";
					$fail = true;
				} else if(teste_csenha($senha, $csenha) == 0){
					$csenha_err = "Diferente da senha";
					$fail = true;
				}
				if($fail == false){
					$conexao = mysqli_connect("localhost", "root", "abc123", "tutorias");
					$query = "UPDATE usuario SET nome = '$name', sobrenome = '$sobrenome', nascimento = '$date',
								email = '$email', genero = '$genero', usuario = '$login', senha = '$senha',
					            WHERE id = $id;";
					$result = mysqli_query($conexao, $query);
					if($result){
						header('Location: sucess.php'); 
						exit;
					} else {
						header('Location: fail.php');
						exit;
					}
				}
			} else {
				$id = $_GET["id"];
			
				$conexao = mysqli_connect("localhost", "root", "abc123", "tutorias");
				$query = "SELECT * FROM usuarios WHERE id = '$id'";
				$result = mysqli_query($conexao, $query);
				$linha = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$name = $linha['nome'];
				$sobrenome = $linha['sobrenome'];
				$date = $linha['nascimento'];
				$email = $linha['email'];
				$login = $linha['usuario'];
				$senha = $linha['senha'];
				$cpf = $linha['cpf'];
				$facebook = $linha['facebook'];
				$descricao = $linha['descricao'];
			}			
			
		?>
				
		
		<h1 align = "center">Editar usuário</h1>
		<form name = "formulario" method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			Dados pessoais
			<input type = "hidden" name = "id_consultado" value = <?php echo "$id";?>>
			<hr>
			Nome: <input type = "text" name = "nome" id = "nome" value = <?php echo "$name"?>><span class = "error"> *<?php echo $name_err;?></span><br>
			Sobrenome: <input type = "text" name = "sobrenome" id = "sobrenome" value = <?php echo "$sobrenome"?>><br>
			Data de nascimento: <input type = "date" name = "nascimento" id = "nascimento" value = <?php echo "$date"?>><span class = "error"> *<?php echo $date_err;?></span><br>
			Gênero:
			<select name = "genero">
				<option value = "masculino">Masculino</option>
				<option value = "feminino">Feminino</option>
				<option value = "outro">Outro</option>
			</select><span class = "error"> *<?php echo $genero_err;?></span><br>
			Email: <input type = "email" name = "email" value = <?php echo "$email"?>><span class = "error"> *<?php echo $email_err;?></span><br>
			CPF: <input type = "text" name = "cpf" id = "cpf" value = <?php echo "$cpf"?>> max. 30 carac.<span class = "error"> *<?php echo $cpf_err;?></span><br>
			Facebook: www.facebook.com/<input type = "text" name = "facebook" id = "facebook" value = <?php echo "$facebook"?>> max. 30 carac.<span class = "error"> *<?php echo $fb_err;?></span><br>
			Descricao: <input type = "text" name = "descricao" id = "descricao" value = <?php echo "$descricao"?>><br>
			<br><br>
			<hr>
			Dados de login
			<hr>
			<div style = "width: 70%; float: left; margin: 10px">
			Usuário: <input type = "text" name = "login" id = "login" value = <?php echo "$login"?>> max. 30 carac.<span class = "error"> *<?php echo $login_err;?></span><br>
			Senha: <input type = "password" name = "senha" id = "senha" value = <?php echo "$senha"?>> min. 6 max. 30 carac.<span class = "error"> *<?php echo $senha_err;?></span><br>
			Confirme sua senha: <input type = "password" name = "csenha" id = "csenha"><span class = "error"> *<?php echo $csenha_err;?></span><br>
			</div>
			<div style = "width: 100%; float: left; margin: 10px">
				<input type = "submit" value = "Editar">&emsp;<input type = "reset" value = "Limpar">
			</div>
		</form>
	</body>
</html>
