<?php
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
?>

<html>
	<head>
		<title>Atividade 10</title>
	</head>
	<body>
		<?php
			function teste_login($login){
				if(strlen($login) > 30){
					return 0;
				}
				$conexao = mysqli_connect("localhost", "root", "", "avengerz");
				$query = "SELECT * FROM usuario where login = '$login'";
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
			$name_err = $email_err = $genero_err = $date_err = $login_err = $senha_err = $csenha_err = $personagem_err = $classe_err = $termos_err = "";
			$name = $email = $genero = $date = $login = $senha = $csenha = $personagem = $classe = $termos = "";
			$fail = false;
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$name = $_POST["nome"];
				$sobrenome = $_POST["sobrenome"];
				$classe = $_POST["classe"];
				$date = $_POST["nascimento"];
				$email = $_POST["email"];
				$genero = $_POST["genero"];
				$login = $_POST["login"];
				$senha = $_POST["senha"];
				$csenha = $_POST["csenha"];
				$personagem = $_POST["personagem_name"];
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
				if(empty($personagem)){
					$personagem = "Campo obrigatório";
					$fail = true;
				} else {
					$res = teste_personagem($personagem);
					if($res === 0){
						$personagem_err = "Nome inválido";
						$fail = true;
					}
				}
				if($fail == false){
					$conexao = mysqli_connect("localhost", "root", "", "avengerz");
					$query = "insert into usuario (id, nome, sobrenome, data_nascimento, email, genero, login, senha, nome_personagem, classe, noticias)
							values ('', '$name', '$sobrenome', '$date', '$email', '$genero', '$login', '$senha', '$personagem', '$classe', 0)";
					$result = mysqli_query($conexao, $query);
					if($result){
						header('Location: sucess.php'); 
						exit;
					} else {
						header('Location: fail.php');
						exit;
					}
				}
			}
		?>		
		
		<h1 align = "center">Cadastro de novo usuário</h1>
		<form name = "formulario" method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			Dados pessoais
			<hr>
			Nome: <input type = "text" name = "nome"><span class = "error"> *<?php echo $name_err;?></span><br>
			Sobrenome: <input type = "text" name = "sobrenome"><br>
			Data de nascimento: <input type = "date" name = "nascimento"><span class = "error"> *<?php echo $date_err;?></span><br>
			Gênero:
			<select name = "genero">
				<option value = "masculino">Masculino</option>
				<option value = "feminino">Feminino</option>
				<option value = "outro">Outro</option>
			</select><span class = "error"> *<?php echo $genero_err;?></span><br>
			Email: <input type = "email" name = "email"><span class = "error"> *<?php echo $email_err;?></span><br>
			<br><br>
			<hr>
			Dados de login
			<hr>
			<div style = "width: 70%; float: left; margin: 10px">
			Usuário: <input type = "text" name = "login"> max. 30 carac.<span class = "error"> *<?php echo $login_err;?></span><br>
			Senha: <input type = "password" name = "senha"> min. 6 max. 30 carac.<span class = "error"> *<?php echo $senha_err;?></span><br>
			Confirme sua senha: <input type = "password" name = "csenha"><span class = "error"> *<?php echo $csenha_err;?></span><br>
			Nome do personagem: <input type = "text" name = "personagem_name"> max. 30 carac.<span class = "error"> *<?php echo $personagem_err;?></span><br>
			</div>
			<div style = "width: 25%; float: right; margin: 10px">
				Classe:<span class = "error"> *<?php echo $classe_err;?></span><br>
				<input type = "radio" name = "classe" value = "guerreiro" checked> Guerreiro<br>
				<input type = "radio" name = "classe" value = "mago"> Mago<br>
				<input type = "radio" name = "classe" value = "arqueiro"> Arqueiro<br>
			</div>
			<div style = "width: 100%; float: left; margin: 10px">
				<input type = "checkbox" name = "termos" value = "termos"> Concordo com os <a href = "termos.html" target = "blank">termos</a> de compromisso<span class = "error"> *<?php echo $termos_err;?></span><br>
				<input type = "checkbox" name = "noticias" value = "noticias"> Desejo receber novidades sobre o jogo<br><br>
				<input type = "submit" value = "Cadastrar">&emsp;<input type = "reset" value = "Limpar">
			</div>
		</form>
	</body>
</html>
