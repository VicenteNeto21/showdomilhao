<?php
include 'conexao.inc';
session_start();
$user_id = $_SESSION['user_id'];

$select = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE id = '$user_id'") or die('query failed');
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
}

if (isset($_POST['update_profile'])) {
    $update_nickname = mysqli_real_escape_string($conn, $_POST['update_nickname']);

    mysqli_query($conn, "UPDATE `usuarios` SET nome = '$update_nome', email = '$update_email' WHERE id = '$user_id'") or die('query failed');

    $old_pass = isset($_POST['old_pass']) ? $_POST['old_pass'] : '';
    $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

    if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        if ($update_pass != $old_pass) {
            $message[] = 'old password not matched!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'confirm password not matched!';
        } else {
            mysqli_query($conn, "UPDATE `usuarios` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
            $message[] = 'password updated successfully!';
        }
    }

    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image = $_FILES['update_image']['name'];
    $update_image_folder = 'uploaded_img/' . $update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'image is too large';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE `usuarios` SET avatar = '$update_image' WHERE id = '$user_id'") or die('query failed');
            if ($image_update_query) {
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
            }
            $message[] = 'image updated succssfully!';
        }
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show do Milhão - Tela inicial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="icon" href="images/Icons/Vector.png" type="image/x-icon">
    <style>
        body {
            background-image: url("images/img-fundo.png");
            background-size: cover;
            background-position: sticky;
            background-repeat: repeat;
        }

        .card {
            background-color: rgba(169, 164, 179, 1);
        }

        img#logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 70px;
        }

        .form-control {
            background-color: rgba(169, 164, 179, 1);
        }

        .form-control:disabled {
            background-color: rgb(156, 151, 165);
        }

        input[type=text],
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

        input[type=text]:focus,
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

        .btn-primary {
            text-align: center;
            border-radius: 25px;
            background-color: rgba(21, 122, 140, 1);
            color: rgba(38, 13, 51, 1);
        }

        .btn-primary:hover {
            background-color: rgba(38, 13, 51, 1);
            color: rgba(21, 122, 140, 1);
        }

        .btn-danger {
            border-radius: 25px;
            margin-top: 20px;
        }

        .btn-tam {
            width: 110px;
        }

        .card-body img {
            height: 200px;
            width: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 5px;
            border: 8px solid white;
            margin-left: 35%;
        }

        input {
            display: block;
            border-radius: 10px;
            border: 2px solid #4d4d4d;
            height: 100%;
            width: 100%;
            padding: 5px;
        }
    </style>
</head>

<body>
    <img id="logo" src="images/logo-sdm.png" alt="" width="300" height="90">
    <div class="card" style="width: 600px; height: auto; margin: 100px auto; border-radius: 25px;">
        <div class="card-body">
            <?php
            if ($fetch['avatar'] == '') {
                echo '<img src="images/default-avatar.png">';
            } else {
                echo '<img src="uploaded_img/' . $fetch['avatar'] . '">';
            }
            ?>
            <!-- conteúdo a partir daqui -->
            <form action="" method="post" enctype="multipart/form-data">
                <fieldset disabled>
                    <div class="form-group">
                        <label class="text-left" for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" value="<?php echo $fetch['nome'] ?>">
                    </div><!--desativar-->

                    <div class="form-group">
                        <label class="text-left" for="email">Endereço de email</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?php echo $fetch['email'] ?>">
                    </div><!--desativar-->

                </fieldset>

                <div class="form-group mb-4">
                    <label for="Nickname">Nickname</label>
                    <input name="update_nickname" type="text" class="form-control" id="Nickname" value="<?php echo $fetch['nickname'] ?>">
                </div>

                <div class="form-group">
                    <label>Escolha uma imagem: </br></label>
                    <input name="image" type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                </div>

                <div class="form-group">
                    <label class="text-left" for="Senha">Alterar senha</label>
                    <input name="new_pass" type="password" class="form-control" id="Senha" placeholder="Digite sua nova senha">
                </div>

                <div class="form-group">
                    <label class="text-left" for="ConfirmarSenha">Confirmar senha</label>
                    <input name="confirm_pass" type="password" class="form-control" id="ConfirmarSenha" placeholder="Confirmar nova senha">
                </div>

                <div class="text-center">
                    <a href="tela_principal.html">
                        <button name="update_profile" type="submit" class="btn btn-tam btn-primary font-weight-bold" onclick="validateForm()">Salvar</button>
                    </a> <br>
                    <a href="home.php"><button type="button" class="btn btn-tam btn-danger">Cancelar</button></a>
                </div>
            </form>
        </div>
    </div>
    <script>
        var input = document.querySelectorAll("input[type=text],input[type=password],input[type=email]");

        function validateForm() {
            var password = document.getElementById("Senha");
            var confirmPassword = document.getElementById("ConfirmarSenha");

            if (password.value != confirmPassword.value) {
                confirmPassword.setCustomValidity("As senhas não coincidem");
            } else {
                confirmPassword.setCustomValidity("");
            }
        }
    </script>
</body>

</html>

<!--
  fazer com que ao clicar em enviar, pegar as informações e voltar para a tela_login
-->