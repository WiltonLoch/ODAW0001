<html>
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<link rel="stylesheet" type="text/css" media="screen" href="estilos.css">
		<title>Perfil</title>
	</head>
	<body>
		<H2>Informações do usuário<H2>
        <table>
            <?php
                $conexao = mysqli_connect("localhost", "root", "abc123", "tutorias");
                $query = "SELECT * FROM usuarios WHERE id = " .$_GET['id'];
                $result = mysqli_query($conexao, $query);
                $linha = mysqli_fetch_array($result, MYSQLI_ASSOC);
                echo "<tr><td><strong>Nome</strong></td> <td>" .$linha['nome']. " " .$linha['sobrenome']. "</td></tr>" ;
                echo "<tr><td><strong>Email</strong></td> <td>" .$linha['email']. "</td></tr>";
                echo "<tr><td><strong>Universidade</strong></td> <td>" .$linha['universidade']. "</td></tr>";
                echo "<tr><td><strong>CPF</strong></td> <td>" .$linha['cpf']. "</td></tr>";
                echo "<tr><td><strong>Telefone</strong></td> <td>" .$linha['telefone']. "</td></tr>";
                echo "<tr><td><strong>Nascimento</strong></td> <td>" .$linha['nascimento']. "</td></tr>";
                echo "<tr><td><strong>Usuario</strong></td> <td>" .$linha['usuario']. "</td></tr>";
                echo "<tr><td><strong>Genero</strong></td> <td>" .$linha['genero']. "</td></tr>";
                echo "<tr><td><strong>Facebook</strong></td> <td> www.facebook.com/" .$linha['facebook']. "</td></tr>";
                echo "<tr><td><strong>Descricao</strong></td> <td>" .$linha['descricao']. "</td></tr>";
            ?>
        </table>
		<br>
        <form method = "GET" action = "editar_bd.php">
            <a href = "pagina_inicial.php?id=<?php echo $_GET['id']; ?>&tema="><input type = "button" class = "botao" value = "Voltar"></a>
            <input type = "hidden" id = "id" name = "id" value = "<?php echo $_GET['id']?>">
            <input type = "submit" class = "botao" value = "Editar informações">
        </form>
	</body>
</html>