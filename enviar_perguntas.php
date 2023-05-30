<?php
include 'conexao.inc';

session_start();
if (!isset($_SESSION['user_id'])) {
  header('location:login.php');
}

$message = []; // Inicializar a variável $message

if (isset($_POST['submit'])) {
  $enunciado = mysqli_real_escape_string($conn, $_POST['enunciado']);
  $alternativa1 = mysqli_real_escape_string($conn, $_POST['alternativa1']);
  $alternativa2 = mysqli_real_escape_string($conn, $_POST['alternativa2']);
  $alternativa3 = mysqli_real_escape_string($conn, $_POST['alternativa3']);
  $alternativa4 = mysqli_real_escape_string($conn, $_POST['alternativa4']);
  $resposta = mysqli_real_escape_string($conn, $_POST['resposta']);
  $criador_id = $_SESSION['user_id'];

  // Validar os campos
  if (empty($enunciado) || empty($alternativa1) || empty($alternativa2) || empty($alternativa3) || empty($alternativa4) || empty($resposta)) {
    $message[] = 'Todos os campos são obrigatórios!';
  } else {
    try {
      $insert = mysqli_query($conn, "INSERT INTO `perguntas`(`enunciado`, `alternativa1`, `alternativa2`, `alternativa3`, `alternativa4`, `resposta`,`revisao`, `criador_id`) VALUES ('$enunciado','$alternativa1','$alternativa2','$alternativa3','$alternativa4','$resposta',0,'$criador_id')");

      if ($insert) {
        $idPerguntas = mysqli_insert_id($conn);
        $message[] = 'Cadastro realizado com sucesso!';

        // Atualizar o valor de quant_perguntas_enviadas
        $update_quantidade = mysqli_query($conn, "UPDATE usuarios SET quant_perguntas_enviadas = quant_perguntas_enviadas + 1 WHERE id = $criador_id");

        $insert_revisao = mysqli_query($conn, "INSERT INTO `revisoes`(`id_pergunta`, `id_usuario`, `aprovada`) VALUES ('$idPerguntas', '$criador_id', 0)");

        if ($insert_revisao) {
          $message[] = 'Revisão cadastrada com sucesso!';
        } else {
          $message[] = 'O cadastro da revisão falhou!';
        }
      } else {
        $message[] = 'O cadastro falhou!';
      }
    } catch (mysqli_sql_exception $e) {
      $message[] = 'O cadastro falhou! Verifique se o seu id de usuário é válido e existente na tabela de usuários.';
      // opcional: você pode também imprimir a mensagem de erro original do mysqli
      // echo "Erro MySQL: " . $e->getMessage();
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-/Y6pD6pU4a8vI6+OGtoEwGpFdJQ9B8MWvALM2Q6QcYs/RwU8Q1a1TGyoozGksdqr" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js" integrity="sha512-jvH9eTzkjKq3+gJW8WevS+bSAmnOUul+M05VLG4FFJv4h4xFsZsYKfBkW8zta/wr6tzmk0COU69kr6aWbfIv+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Yvckj+OnVuNS6LZ+m6UwNR6J2I6rAxr6Uy7V5C5X5orLFG1/IObY2Jqrgw5b1g7V" crossorigin="anonymous"></script>
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

    input[type=text],
    .form-control,
    select.custom-select,
    textarea {
      border: 2px solid #4d4d4d;
      /* Cor da borda */
      border-radius: 10px;
      background-color: rgba(169, 164, 179, 1);
      /* Cor de fundo */
      transition: background-color 0.5s ease-in-out;
    }

    input[type=text]:focus,
    .form-control,
    textarea:focus {
      outline: none;
      border-color: #6c757d;
      /* Cor da borda ao clicar */
    }

    #ajudaPergunta {
      color: rgb(163, 22, 22);
      /*nao esta funcionando isso aqui por algum motivo*/
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

    select.custom-select {
      margin-top: 15pt;
      border: 2x solid #4d4d4d;
      background-color: rgba(169, 164, 179, 1);
    }
  </style>
</head>

<body>
  <img id="logo" src="images/logo-sdm.png" alt="" width="300" height="90">
  <div class="card" style="width: 600px; height: auto; margin: 100px auto; border-radius: 25px;">
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
        <fieldset disabled>
          <div class="form-group">
            <label for="disabledTextInput">ID da conta</label>
            <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
          </div>
        </fieldset>


        <div class="form-group">
          <label for="pergunta">Escreva a sua pergunta aqui</label>
          <textarea name="enunciado" class="form-control" id="pergunta" rows="3" maxlength="255" required></textarea>
          <small id="ajudaPergunta" class="form-text text-muted">
            A sua pergunta irá para uma avaliação antes de entrar no jogo.
            <br>Perguntas de conteúdo violento, que façam apologia a movimentos de ódio e afins <strong>NÃO SERÃO
              ACEITAS</strong> e o usuário pode ter a sua conta <strong>BANIDA</strong>.
          </small>
        </div>

        <div class="form-group">
          <label for="opcaoA"></label>
          <input name="alternativa1" type="text" class="form-control" id="opcaoA" placeholder="Opção A" onkeyup="updateSelectOptions()" required>
        </div>

        <div class="form-group">
          <label for="opcaoB"></label>
          <input name="alternativa2" type="text" class="form-control" id="opcaoB" placeholder="Opção B" onkeyup="updateSelectOptions()" required>
        </div>

        <div class="form-group">
          <label for="opcaoC"></label>
          <input name="alternativa3" type="text" class="form-control" id="opcaoC" placeholder="Opção C" onkeyup="updateSelectOptions()" required>
        </div>

        <div class="form-group">
          <label for="opcaoD"></label>
          <input name="alternativa4" type="text" class="form-control" id="opcaoD" placeholder="Opção D" onkeyup="updateSelectOptions()" required>
        </div>

        <div class="form-group">
          <select class="form-select" name="resposta" aria-label="Default select example" id="resposta-select">
            <option selected>Alternativa correta?</option>
          </select>
          <div class="invalid-feedback">Selecione a opção correta!</div>
        </div>

        <div class="text-center">
          <button name="submit" type="submit" class="btn btn-primary font-weight-bold">Enviar</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function updateSelectOptions() {
      var opcoes = document.querySelectorAll('input[name^="alternativa"]');
      var select = document.querySelector('#resposta-select');
      select.innerHTML = '<option selected>Alternativa correta?</option>';

      for (var i = 0; i < opcoes.length; i++) {
        if (opcoes[i].value.trim() !== '') {
          var option = document.createElement('option');
          option.text = opcoes[i].value;
          select.add(option);
        }
      }
    }
  </script>
</body>

</html>