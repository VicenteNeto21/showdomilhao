<?php
// Pagina para armazenar os dados de head e body
include 'cabelhaco.php';
// configuração de conexao com banco de dados
include 'conexao.inc';

if (isset($_POST['submit'])) {
  $nome = mysqli_real_escape_string($conn, $_POST['nome']);
  $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
  $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
  $image = $_FILES['image']['name'];
  $image_size = $_FILES['image']['size'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_folder = 'uploaded_img/' . $image;

  // Verificar se o email já existe no banco de dados
  $select = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email'") or die('query failed');

  if (mysqli_num_rows($select) > 0) {
    $message[] = 'Este email já está sendo utilizado por outro usuário.';
  } else {
    if ($pass != $cpass) {
      $message[] = 'As senhas não correspondem!';
    } elseif ($image_size > 2000000) {
      $message[] = 'O tamanho da imagem é muito grande!';
    } else {
      $insert = mysqli_query($conn, "INSERT INTO `usuarios`(nome, nickname, email, password, avatar) VALUES('$nome', '$nickname', '$email', '$pass', '$image')") or die('query failed');

      if ($insert) {
        move_uploaded_file($image_tmp_name, $image_folder);
        $select = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email'") or die('query failed');
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['nome'];
        header('location:index.php');
      } else {
        $message[] = 'O cadastro falhou!';
      }
    }
  }
}

?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show do Milhão - Tela inicial</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="icon" href="images/Icons/Vector.png" type="image/x-icon">
  <style>
    body {
      background-image: url("images/background_perguntas.png");
      background-size: cover;
      background-position: sticky;
      background-repeat: repeat;
      transition: opacity 0.3s ease-in-out;
    }

    .principal {
      height: 100vh;
      filter: blur(0);
      /* Inicialmente sem desfoque */
      transition: filter 0.3s ease-in-out;
    }

    .confirmacao {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease-in-out, visibility 0s linear 0.3s;
    }

    .confirmacao.active {
      opacity: 1;
      visibility: visible;
      transition: opacity 0.3s ease-in-out, visibility 0s linear;
    }

    .confirmacao-cont {
      background-color: rgb(211, 211, 211);
      width: 100%;
      text-align: center;
      justify-content: center;
    }

    .subtextoconfirmacao {
      background-color: rgba(38, 13, 51, 1);
      color: rgba(169, 164, 179, 1);
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

    input {
      display: block;
      border-radius: 10px;
      border: 2px solid #4d4d4d;
      height: 100%;
      width: 100%;
      padding: 5px;
    }

    label {
      color: rgba(38, 13, 51, 1);
      font-size: large;
    }

    .btn-primary {
      text-align: center;
      border-radius: 15px;
      background-color: rgba(21, 122, 140, 1);
      color: rgba(38, 13, 51, 1);
    }

    .btn-primary:hover {
      background-color: rgba(38, 13, 51, 1);
      color: rgba(21, 122, 140, 1);
    }
  </style>
</head>

<body>
  <div class="principal">

    <img class="logo-cadastro" src="images/logo-sdm.png" alt="">
    <div class="card-cadastro" style="width: 600px; height: auto; margin: 100px auto; border-radius: 25px;">
      <div class="card-body">
        <!-- conteúdo a partir daqui -->
        <form action="" method="post" enctype="multipart/form-data">
          <?php
          if (isset($message)) {
            foreach ($message as $message) {
              echo '<div class="message">' . $message . '</div>';
            }
          }
          ?>
          <div class="form-group">
            <label class="text-left" for="nome">Nome</label>
            <input name="nome" type="text" class="form-control" id="nome" placeholder="Digite seu nome completo">
          </div>

          <div class="form-group mb-4">
            <label for="Nickname">Nickname</label>
            <input name="nickname" type="text" class="form-control" id="Nickname" placeholder="Digite seu Nickname">
          </div>

          <div class="form-group">
            <label class="text-left" for="email">Endereço de email</label>
            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp"
              placeholder="Seu email">
          </div>

          <div class="form-group">
            <label>Escolha uma imagem: </br></label>
            <input name="image" type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
          </div>

          <div class="form-group">
            <label class="text-left" for="Senha">Senha</label>
            <input name="password" type="password" class="form-control" id="Senha" placeholder="Senha">
          </div>

          <div class="form-group">
            <label class="text-left" for="ConfirmarSenha">Confirmar Senha</label>
            <input name="cpassword" type="password" class="form-control" id="ConfirmarSenha"
              placeholder="Confirmar Senha">
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-prox font-weight-bold" name="submit">Enviar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--Tela de confirmação-->
  <div class="confirmacao">
    <div class="confirmacao-cont">
      <span>
        <img src="images/feitocomcirculogrosso-menor-cut (1).png" alt="">
      </span>
      <span>
        <h3 style="display: inline; margin-left: 25px;">Cadastro realizado com sucesso</h3>
      </span>
      <div class="subtextoconfirmacao">
        <small>Clique em qualquer lugar para fechar a tela e voltar para o login</small>
      </div>
    </div>
  </div>
  
     <script>
    
    document.addEventListener("DOMContentLoaded", function () {
      var principal = document.querySelector(".principal")
      var telaconfirmacao = document.querySelector(".confirmacao")

      var btnprox = document.querySelector(".btn-prox")

      btnprox.addEventListener("click", function () {
        principal.style.filter = "blur(5px)"
        telaconfirmacao.classList.add("active")
      })

      telaconfirmacao.addEventListener("click", function () {
        telaconfirmacao.classList.remove("active")
        principal.style.filter = "blur(0)"
        window.location.href = 'tela_login.html'
      })
    })
  </script>

  <?php
  // Dados do footer
  include 'rodape.php';
  ?>
</body>