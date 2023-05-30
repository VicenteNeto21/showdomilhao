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
<img class="logo-cadastro" src="images/logo-sdm.png" alt="">
<div class="card-cadastro" style="width: 600px; height: auto; margin: 100px auto; border-radius: 25px;">
  <div class="card-body">
    <!-- conteúdo a partir daqui -->
    <form action="" method="post" enctype="multipart/form-data">
    <?php
            if(isset($message)){
                foreach($message as $message){
                    echo '<div class="message">'.$message.'</div>';
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
        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Seu email">
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
        <input name="cpassword" type="password" class="form-control" id="ConfirmarSenha" placeholder="Confirmar Senha">
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary font-weight-bold" name="submit">Enviar</button>
      </div>
    </form>
  </div>
</div>
<!-- <script>
    function validateForm() {
      var password = document.getElementById("Senha");
      var confirmPassword = document.getElementById("ConfirmarSenha");

      if (password.value != confirmPassword.value) {
        confirmPassword.setCustomValidity("As senhas não coincidem");
      } else {
        confirmPassword.setCustomValidity("");
      }
    }

  </script> -->

<?php
// Dados do footer
include 'rodape.php';
?>