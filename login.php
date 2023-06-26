<?php
// Pagina para armazenar os dados de head e body
include 'cabelhaco.php';
// configuração de conexao com banco de dados
include 'conexao.inc';
// include 'i_validCookie.inc';

session_start();

// if($linha > 0){
//   $num=rand(100000, 900000); //gerando numero aleatório para o cookie
//   setcookie("numLogin", $num);//guardando o numero no cookie
//   header("Location: home.php?num1=$num");//direcionando para a pagina de logado
// }else{
//   //recarregando a pagina de login no caso de senha invalida;
//   header("Location: login.php");
// }

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $select_email = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email'") or die('query failed');
    if (mysqli_num_rows($select_email) == 0) {
        $message[] = 'E-mail não encontrado no banco de dados. Por favor, <a href="cadastro.php">cadastre-se</a>';
    } else {
        $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

        $select = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email' AND password = '$pass'") or die('query failed');

        if (mysqli_num_rows($select) > 0) {
            $row = mysqli_fetch_assoc($select);
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
        } else {
            $message[] = 'E-mail ou senha incorretos!';
        }
    }
}

?>

<!--
  podem colocar um icone com o fundo igual ao card e um png preto ou rgba(38, 13, 51, 1) se conseguirem
  e coloquem em algum canto, ai isso é o botao de ranking, evita de usar a tela_inicial e nem usar um botao
-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show do Milhão - Tela inicial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-/Y6pD6pU4a8vI6+OGtoEwGpFdJQ9B8MWvALM2Q6QcYs/RwU8Q1a1TGyoozGksdqr"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"
        integrity="sha512-jvH9eTzkjKq3+gJW8WevS+bSAmnOUul+M05VLG4FFJv4h4xFsZsYKfBkW8zta/wr6tzmk0COU69kr6aWbfIv+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Yvckj+OnVuNS6LZ+m6UwNR6J2I6rAxr6Uy7V5C5X5orLFG1/IObY2Jqrgw5b1g7V"
        crossorigin="anonymous"></script>
    <link rel="icon" href="images/Icons/Vector.png" type="image/x-icon">
    <style>
        body {
            background-image: url("images/background_perguntas.png");
            background-size: cover;
            background-position: sticky;
            background-repeat: repeat;
        }

        .card-cadastro {
            background-color: rgba(169, 164, 179, 1);
        }

        img#logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 30px;
        }

        input[type=password],
        input[type=email],
        textarea {
            border: 2px solid #4d4d4d;
            /* Cor da borda */
            border-radius: 10px;
            background-color: rgba(169, 164, 179, 1);
            /* Cor de fundo */
            transition: background-color 0.5s ease-in-out;
        }

        input[type=password]:focus,
        input[type=email]:focus textarea:focus {
            outline: none;
            border-color: #6c757d;
            /* Cor da borda ao clicar */
        }

        label {
            color: rgba(38, 13, 51, 1);
            font-size: large;
        }

        .btn-primary,
        .btn-custom:disabled {
            text-align: center;
            border-radius: 15px;
            background-color: rgba(21, 122, 140, 1);
            color: rgba(38, 13, 51, 1);
        }

        .btn-primary:hover {
            background-color: rgba(38, 13, 51, 1);
            color: rgba(21, 122, 140, 1);
        }

        a {
            color: rgba(38, 13, 51, 1);
            text-decoration: underline;
            font-style: italic;
            margin-bottom: 10px;
            text-align: center;
        }

        a:hover {
            color: rgba(21, 122, 140, 1);
        }
    </style>
</head>

<body>

    <img class="logo-cadastro" src="images/logo-sdm.png" alt="">
    <div class="card-cadastro" style="width: 600px; height: auto; margin: 100px auto; border-radius: 25px;">
        <div class="card-body">
            <!-- conteúdo a partir daqui -->
            <form action="" method="post" enctype="multipart/form-data">
                <?php
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '<div class="alert alert-danger" role="alert">
          <strong>' . $message . '</strong>
              </div>';
                    }
                }
                ?>

                <div class="form-group">
                    <label for="email">Endereço de email</label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp"
                        placeholder="Seu email">
                </div>

                <div class="form-group">
                    <label for="Senha">Senha</label>
                    <input name="password" type="password" class="form-control" id="Senha" placeholder="Senha">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary font-weight-bold" name="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    // Dados do footer
    include 'rodape.php';
    ?>
</body>