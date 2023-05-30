<?php
include 'conexao.inc';
include 'cabelhaco.php';
?>

<!--Logo do game-->
<img class="logomarca" src="images/logo-sdm.png" alt="logomarca do jogo" />
<!--Card para entrar no game-->
<div class="card-inicial" style="width: 400px; height: auto; margin: 50px auto; border-radius: 25px">
  <div class="botoes">
    <a href="login.php" id="entrar">
      <button type="button" class="btn btn-primary">
        <b>Entrar</b>
      </button>
    </a>
    <button type="button" class="btn btn-primary" style="border-radius: 25px">
      <b>Ranking</b>
    </button>
    <button type="button" class="btn btn-primary" style="border-radius: 25px">
      <b>Conheça o game?</b>
    </button>
  </div>
  Não tem um Login? <a href="cadastro.php">Cadastre-se</a>
</div>

<?php
include 'rodape.php';
?>