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
<img class="logo-cadastro" src="images/logo-sdm.png" alt="">
<div class="card-cadastro" style="width: 600px; height: auto; margin: 100px auto; border-radius: 25px;">
  <div class="card-body">
    <!-- conteúdo a partir daqui -->
    <form action="" method="post" enctype="multipart/form-data">
      <?php
      if (isset($message)) {
        foreach ($message as $message) {
          echo '<div class="alert alert-danger" role="alert">
          <strong>'.$message.'</strong>
              </div>';
        }
      }
      ?>

      <div class="form-group">
        <label for="email">Endereço de email</label>
        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Seu email">
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