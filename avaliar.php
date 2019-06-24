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
        <?php
            $conexao = mysqli_connect("localhost", "root", "abc123", "tutorias");
            $query = "SELECT u.id as usuario FROM usuarios as u join tutorias as t on u.id = t.id_aluno WHERE t.id = " .$_GET['id'];
            $result = mysqli_query($conexao, $query);
            $linha = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $id_usuario = $linha['usuario'];
            if(isset($_GET['rating'])){
                $query = "UPDATE tutorias SET avaliacao = " .$_GET['rating']. ", status = 3 WHERE id = " .$_GET['id'];
                if($result = mysqli_query($conexao, $query)){
                    $destino = "Location: pagina_inicial.php?id=" .$id_usuario. "&tema=";
			        header($destino);
                }else{
                    echo "Houve um erro na avaliação, por favor tente mais tarde!";
                }
            }else if(isset($_GET['pular'])){
                $query = "UPDATE tutorias SET status = 3 WHERE id = " .$_GET['id'];
                if($result = mysqli_query($conexao, $query)){
                    $destino = "Location: pagina_inicial.php?id=" .$id_usuario. "&tema=";
			        header($destino);
                }
            }else{
                echo "<h2>O que você achou da tutoria de ";
                $query = "SELECT u.nome as tutor, d.nome as disciplina FROM tutorias as t join usuarios as u on t.id_tutor = u.id join disciplinas as d on t.id_disciplina = d.id WHERE t.id = " .$_GET['id'];
                $result = mysqli_query($conexao, $query);
                $linha = mysqli_fetch_array($result, MYSQLI_ASSOC);
                echo $linha['tutor']. " sobre " .$linha['disciplina']. "</h2>";
            }                   
                
        ?>
		<br>
        <form method = "GET" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h3>Dê uma nota de 1 a 5 abaixo:</h3>
            <fieldset class="rating">
                <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Excelente - 5 estrelas"></label>
                <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Excelente - 4.5 estrelas"></label>
                <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Bom - 4 estrelas"></label>
                <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Bom - 3.5 estrelas"></label>
                <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Regular - 3 estrelas"></label>
                <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Regular - 2.5 estrelas"></label>
                <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Insuficiente - 2 estrelas"></label>
                <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Insuficiente - 1.5 estrelas"></label>
                <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Ruim - 1 estrela"></label>
                <input type="radio" id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Ruim - 0.5 estrelas"></label>
            </fieldset>
            <!-- 1 <img src = "recursos/estrela.png" style = "vertical-align: top; width:18px; height:auto;"> 
            <input type="range" min="1" max="5" value="5" class="slider" id="myRange">
            5 <img src = "recursos/estrela.png" style = "vertical-align: top; width:18px; height:auto;"> -->
            <br><br><br>
            <a href = "pagina_inicial.php?id=<?php echo $id_usuario; ?>&tema="><input type = "button" class = "botao" value = "Voltar"></a>
            <input type = "hidden" id = "id" name = "id" value = "<?php echo $_GET['id']?>">
            <input type = "submit" class = "botao" value = "Avaliar">
            <a href = "avaliar.php?id=<?php echo $_GET['id']; ?>&pular=1"><input type = "button" class = "botao" value = "Não desejo Avaliar"></a>
        </form>
	</body>
</html>