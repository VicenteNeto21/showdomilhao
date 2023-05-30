<?php

// Verifica se o usuário está logado, se não estiver, redireciona para a página de login
session_start();
$user_id = $_SESSION['user_id'];

// Conecta ao banco de dados
include 'conexao.inc';

// Obtém o ID do usuário logado

// Consulta os dados do usuário no banco de dados
$query = "SELECT * FROM usuarios WHERE id = $user_id";
$resultado = mysqli_query($conn, $query);

// Obtém os dados do usuário
$usuario = mysqli_fetch_assoc($resultado);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-/Y6pD6pU4a8vI6+OGtoEwGpFdJQ9B8MWvALM2Q6QcYs/RwU8Q1a1TGyoozGksdqr" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js" integrity="sha512-jvH9eTzkjKq3+gJW8WevS+bSAmnOUul+M05VLG4FFJv4h4xFsZsYKfBkW8zta/wr6tzmk0COU69kr6aWbfIv+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Yvckj+OnVuNS6LZ+m6UwNR6J2I6rAxr6Uy7V5C5X5orLFG1/IObY2Jqrgw5b1g7V" crossorigin="anonymous"></script>
    <link rel="icon" href="images/Icons/Vector.png" type="image/x-icon">
    <style>
        body {
            background-image: url("images/background_perguntas.png");
            min-height: 100vh;
            background-size: cover;
            background-position: sticky;
            background-repeat: repeat;
        }

        .principal {
            color: rgba(38, 13, 51, 1);
        }

        .card {
            background-color: rgba(169, 164, 179, 1);
            text-align: center;
            justify-content: center;
        }

        .Icon_com_texto {
            align-items: center;
            justify-content: center;
            margin-top: 25px;
            color: rgba(38, 13, 51, 1);
        }

        .informacoes {
            margin-top: 25px;
            margin-bottom: 25px;
        }

        .divisoria {
            border: none;
            border-top: 1px solid;
            margin-top: 20px;
            margin-bottom: 20px;
            width: 400px;
            border-color: rgba(38, 13, 51, 1);
        }

        a {
            color: rgba(38, 13, 51, 1);
            text-decoration: none;
            font-style: italic;
        }

        a:hover {
            text-decoration: none;
            color: rgba(21, 122, 140, 1);
        }

        .btn-primary {
            text-align: center;
            border-radius: 15px;
            background-color: rgba(21, 122, 140, 1);
            color: rgba(38, 13, 51, 1);
            font-size: 14pt;
            display: block;
            width: 300px;
            height: 50px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 25px;
        }

        .btn-primary:hover {
            background-color: rgba(38, 13, 51, 1);
            color: rgba(21, 122, 140, 1);
        }

        img {
            height: 200px;
            width: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 5px;
            border: 8px solid white;
        }
    </style>
</head>

<body>
    <div class="principal">
        <div class="card" style="width: 500px; height: auto; margin: 50px auto; border-radius: 25px;">
            <div class="Icon_com_texto">
                <a href="tela_cadastro.html">

                    <?php
                    if ($usuario['avatar'] == '') {
                        echo '<img src="image/default-avatar.png">';
                    } else {
                        echo '<img src="uploaded_img/' . $usuario['avatar'] . '">';
                    }
                    ?>
                </a>
                </div>
            <div class="informacoes">
                <h1><?php echo $usuario['nome']; ?></h1>
                <h6>ID: <?php echo $usuario['id'] ?></h6>
                <hr class="divisoria">
                <h3>Estatísticas</h3>
                Perguntas enviadas: <b><?php echo $usuario['quant_perguntas_enviadas'] ?></b><br>
                Partidas jogadas: <b><?php echo $usuario['partidas_jogadas'] ?></b> <br>
                Perguntas aceitas: <b><?php echo $usuario['perguntas_aceitas'] ?></b> <br>
                Perguntas não aceitas: <b><?php echo $usuario['perguntas_nao_aceitas'] ?></b> <br>
                Dinheiro ganho: R$ <b><?php echo $usuario['premiacao_total'] ?></b> <br>
                <a href="#" id="verMaisEstatisticas">Ver mais estatísticas</a>
                <div id="EstatisticasExtras" style="display: none;">
                </div>
                <hr class="divisoria">
                <div class="botoes">
                    <a href="alterar_dados.php"><button type="button" class="btn btn-primary" style="border-radius: 25px;"><b>Alterar
                                informações</b></button><a> <!--esse botão leva para a tela de cadastro, fazer com que as informações retornem e fiquem nauquela tela
                                                        a rota tbm nao esta feita, implemnetar pf-->
                            <a href="home.php">
                                <button type="button" class="btn btn-primary" style="border-radius: 25px;"><b>Voltar</b></button> <!-- o estilo ta errado aqui-->
                            </a>
                </div>
            </div>
        </div>
    </div>
    <?php
    include 'rodape.php';
    ?>