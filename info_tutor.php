<html>
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    	<link rel="stylesheet" type="text/css" media="screen" href="estilos.css">
		<title>Perfil</title>
	</head>
	<body>
		<H2>Informações do usuário<H2>
        <table>
            <?php
                $conexao = mysqli_connect("localhost", "root", "abc123", "tutorias");
                $query = "SELECT * FROM usuarios WHERE id = " .$_GET['id_tutor'];
                $result = mysqli_query($conexao, $query);
                $linha = mysqli_fetch_array($result, MYSQLI_ASSOC);
                echo "<tr><td><strong>Nome</strong></td> <td>" .$linha['nome']. " " .$linha['sobrenome']. "</td></tr>" ;
                echo "<tr><td><strong>Email</strong></td> <td>" .$linha['email']. "</td></tr>";            
                echo "<tr><td><strong>Telefone</strong></td> <td>" .$linha['telefone']. "</td></tr>";
                echo "<tr><td><strong>Facebook</strong></td> <td><a href = \"https://www.facebook.com/" .$linha['facebook']. "\" target = \"blank\">www.facebook.com/" .$linha['facebook']. "</a></td></tr>";
                
            ?>
        </table>
		<br>        
        <a href = "pagina_inicial.php?id=<?php echo $_GET['id_aluno']; ?>&tema="><input type = "button" class = "botao" value = "Voltar"></a>
            
	</body>
</html>