<?php
include 'cabelhaco.php';
include 'conexao.inc';
//validar o login
// include 'i_validCookie.inc';

session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

//Destruido o login

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:login.php');
}

//Excluir conta do usuario do banco de dados

if (isset($_POST['delete'])) {
    $delete = mysqli_query($conn, "DELETE FROM `usuarios` WHERE id = '$user_id'") or die('query failed');
    unset($user_id);
    session_destroy();
}

$select = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE id = '$user_id'") or die('query failed');
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
    $nome = $fetch['nome'];
    $avatar = $fetch['avatar'];
} else {
    $nome = '';
    $avatar = '';
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show do Milhão</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-/Y6pD6pU4a8vI6+OGtoEwGpFdJQ9B8MWvALM2Q6QcYs/RwU8Q1a1TGyoozGksdqr" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js" integrity="sha512-jvH9eTzkjKq3+gJW8WevS+bSAmnOUul+M05VLG4FFJv4h4xFsZsYKfBkW8zta/wr6tzmk0COU69kr6aWbfIv+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Yvckj+OnVuNS6LZ+m6UwNR6J
        2I6rAxr6Uy7V5C5X5orLFG1/IObY2Jqrgw5b1g7V" crossorigin="anonymous"></script>
    <link rel="icon" href="images/Icons/Vector.png" type="image/x-icon">
    <style>
        body {
            background-image: url("images/background_perguntas.png");
            background-size: cover;
            background-position: sticky;
            background-repeat: repeat;
            background-size: cover;
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
            margin-top: 15px;
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
            color: rgba(21, 122, 140, 1);
            text-decoration: none;
        }

        .btn-primary,
        .btn-custom {
            text-align: center;
            border-radius: 15px;
            background-color: rgba(21, 122, 140, 1);
            color: rgba(38, 13, 51, 1);
            font-size: 14pt;
            display: block;
            width: 250px;
            height: auto;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
        }

        .btn-primary:hover,
        .btn-custom:hover {
            background-color: rgba(38, 13, 51, 1);
            color: rgba(21, 122, 140, 1);
        }

        .btn-danger {
            text-align: center;
            border-radius: 15px;
            font-size: 14pt;
            display: block;
            width: 250px;
            height: auto;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
        }

        img {
            border-radius: 50%;
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 8px solid white;
        }
    </style>
</head>

<body>
    <div class="principal">
        <div class="card" style="width: 500px; height: auto; margin: 50px auto; border-radius: 25px;">
            <div class="Icon_com_texto">

                <?php
                if (empty($avatar)) {
                    echo '<img src="images/Icons/avatar.png">';
                } else {
                    echo '<img src="uploaded_img/' . $avatar . '">';
                }
                ?>

            </div>
            <div class="informacoes">
                <h1><?php echo $nome; ?></h1>
                <div class="botoes">
                    <a href="jogar.php">
                        <button type="button" class="btn btn-custom" style="border-radius: 25px;"><b>Jogar</b></button>
                    </a>

                    <a href="perfil.php">
                        <button type="button" class="btn btn-primary" style="border-radius: 25px;"><b>Perfil</b></button>
                    </a>

                    <a href="Ranking.php"></a>
                    <button type="button" class="btn btn-primary" style="border-radius: 25px;"><b>Ranking</b></button>

                    <a href="enviar_perguntas.php">
                        <button type="button" class="btn btn-primary" style="border-radius: 25px;"><b>Enviar
                                perguntas</b></button>
                    </a>

                    <a href="login.php?logout=<?php echo $user_id; ?>">
                        <button type="button" class="btn btn-danger" style="border-radius: 25px;"><b>Sair</b></button>
                    </a>

                </div>
            </div>
        </div>
    </div>
</body>

</html>