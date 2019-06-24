<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
	$resultado = "";
    $conexao = mysqli_connect("localhost", "root", "abc123", "tutorias");
    $query = "INSERT INTO tutorias(id_tutor, id_aluno, id_disciplina, status) VALUES (" .$_GET['tutor']. ", " .$_GET['aluno'].", " .$_GET['tema']. ", 1)";
    $result = mysqli_query($conexao, $query);
    if($result){
        $resultado = "Pedido de tutoria enviado com sucesso";
        $query = "SELECT usuario FROM usuarios where id = " .$_GET['aluno']. "";
        $result = mysqli_query($conexao, $query);
        $linha = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }else{
        $resultado = "Houve um erro no envio do pedido! Por favor, tente mais tarde!";
    }
?>

<html>
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<link rel="stylesheet" type="text/css" media="screen" href="estilos.css">
		<title>Pedido de tutoria</title>
	</head>
	<body>
        <h1><?php echo $resultado?></h1>
		<form name = "formulario-sucesso" method = "GET" action = "pagina_inicial.php">            
            <input type = "hidden" id = "id" name = "id" value = "<?php echo $_GET['aluno']; ?>">
            <input type = "hidden" id = "tema" name = "tema" value = "">
			<input type = "submit" class = "botao" value = "Voltar para página principal" />
		</form>
	</body>
</html>
