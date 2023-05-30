<?php
include 'conexao.inc';

$result = mysqli_query($conn, "SELECT * FROM perguntas WHERE revisao = 1 ORDER BY RAND()");
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Yvckj+OnVuNS6LZ+m6UwNR6J2I6rAxr6Uy7V5C5X5orLFG1/IObY2Jqrgw5b1g7V" crossorigin="anonymous"></script>
  <link rel="icon" href="images/Icons/Vector.png" type="image/x-icon">
  <style>
    body {
      background-image: url("images/background_perguntas.png");
      background-size: cover;
      background-position: sticky;
      background-repeat: repeat;
      background-size: cover;
      color: rgba(38, 13, 51, 1);
      transition: opacity 0.3s ease-in-out;
    }

    .principal {
      height: 100vh;
      filter: blur(0);
      /* Inicialmente sem desfoque */
      transition: filter 0.3s ease-in-out;
    }

    /* Estilos para as páginas de sobreposição */
    .telaDenuncia,
    .tela_saida,
    .telapontuacao,
    .telaconfirmacaosaida,
    .tela-temcerteza {
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

    /* Estilos para animar a transição */
    .telaDenuncia.active,
    .tela_saida.active,
    .telapontuacao.active,
    .telaconfirmacaosaida.active,
    .tela-temcerteza.active {
      opacity: 1;
      visibility: visible;
      transition: opacity 0.3s ease-in-out, visibility 0s linear;
    }

    /* Estilos para o conteúdo das páginas de sobreposição */
    .telaDenuncia-content,
    .tela-saida-cont,
    .telapontuacao-cont,
    .telaconfirmacaosaida-cont,
    .tela-temcerteza-cont {
      background-color: rgb(211, 211, 211);
      width: 100%;
      padding: 20px;
      /*border-radius: 5px;*/
      text-align: center;
      /* border-radius: 25px; */
      justify-content: center;
    }

    .card {
      background-color: rgba(169, 164, 179, 1);
    }

    .btn-primary {
      text-align: left;
      border-radius: 50px;
      background-color: rgba(21, 122, 140, 1);
      color: rgba(38, 13, 51, 1);
      font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
      font-size: 14pt;
      width: auto;
      height: auto;
      margin-top: 25px;
    }

    .btn-primary:hover {
      background-color: rgba(38, 13, 51, 1);
      color: rgba(21, 122, 140, 1);
    }

    .navbar {
      background-color: rgba(0, 0, 0, 0.5);
    }

    .btn-outline-info {
      text-align: left;
      border-radius: 50px;
      margin-right: 5px;
      border: 1px solid rgba(21, 122, 140, 1);
    }

    .btn-outline-info:hover {
      background-color: rgba(21, 122, 140, 1);
      color: rgba(38, 13, 51, 1);
    }

    .btn-outline-danger {
      border-radius: 25px;
      margin-right: 5px;
    }

    span {
      color: rgba(38, 13, 51, 1)
    }

    .tabela {
      margin-top: 20px;
      margin-left: 300px;
      margin-right: 300px;
    }

    .subhead,
    .botoesdedenuncia {
      margin-top: 20px;
    }

    .exe-button {
      width: auto;
      height: 50px;
      border: 3px solid rgba(21, 122, 140, 1);
      margin-top: 15px;
      color: rgba(38, 13, 51, 1);
      border-radius: 45px;
      transition: all 0.3s;
      cursor: pointer;
      background: rgba(21, 122, 140, 1);
      font-size: 1.2em;
      font-weight: 550;
      font-family: 'Montserrat', sans-serif;
    }

    .exe-button:hover {
      background: rgba(38, 13, 51, 1);
      color: rgba(21, 122, 140, 1);
      font-size: 1.3em;
    }

    .sessaodebotoes {
      margin-top: 15px;
    }
  </style>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var telaDenuncia = document.querySelector(".telaDenuncia"); //tela de denuncia
      var telaSaida = document.querySelector(".tela_saida"); // tela de saida
      var telaPont = document.querySelector(".telapontuacao"); //tela de pontuacao
      var telaperdeu = document.querySelector(".telaconfirmacaosaida"); //tela de confirmação de saida
      var telacerteza = document.querySelector(".tela-temcerteza"); //tela de certza de saida

      var fecharBtns = document.querySelectorAll(".fechar-btn"); //funcao pra fechar telas
      var principal = document.querySelector(".principal"); //tela principal

      var abrirdenuncia = document.querySelector(".btn-denuncia"); //botão de denuncia
      var sairBtn = document.querySelector(".btn-saida"); //botao de saida
      var abrirPont = document.querySelector(".btn-pontuacao"); //botao de pontuacao
      var incerteza = document.querySelector(".incerteza-btn"); //botao da incerteza
      var desistencia = document.querySelector(".desistencia-btn"); //botao de sim na tela de sair


      abrirdenuncia.addEventListener("click", function() {
        telaDenuncia.classList.add("active"); //exibe a tela de denuncia
        principal.style.filter = "blur(5px)"; // Aplica o desfoque ao fundo
      });

      sairBtn.addEventListener("click", function() {
        telaSaida.classList.add("active"); // Exibe a tela de saída
        principal.style.filter = "blur(5px)"; // Aplica o desfoque ao fundo
      });

      abrirPont.addEventListener("click", function() {
        telaPont.classList.add("active"); //exibe a tela de saída
        principal.style.filter = "blur(5px)"; //Aplica o desfoque ao fundo
      });

      incerteza.addEventListener("click", function() {
        telacerteza.classList.add("active"); //exibe a tela de incerteza
        telaSaida.classList.remove("active"); // Esconde a tela de saída

      })

      desistencia.addEventListener("click", function() {
        telaperdeu.classList.add("active"); //exibe tela de desistencia
        telacerteza.classList.remove("active");
        principal.style.filter = "blur(5px)"; //Aplica o desfoque ao fundo
      })

      fecharBtns.forEach(function(btn) { //função para que todos os btn-fechar fechem os conteudos
        btn.addEventListener("click", function() {
          principal.style.filter = "blur(0)"; // Remove o desfoque do fundo
          telaDenuncia.classList.remove("active"); //esconde a tela de denuncia
          telaSaida.classList.remove("active"); // Esconde a tela de saída
          telaPont.classList.remove("active"); // esconde a tela de pontuação
          telacerteza.classList.remove("active"); //esconde a tela de incerteza
        });
      });

    });
  </script>
</head>

<body>
  <!--
    tela principal aqui
  -->
  <div class="principal">
    <nav class="navbar">
      <a class="navbar-brand">
        <img src="images/Show do Milhãobranco.png" width="90" height="30"></a>
      <form class="form-inline">
        <button class="btn btn-sm btn-outline-info btn-pontuacao" type="button">Pontuação Atual - R$???K</button>
        <button class="btn btn-sm btn-outline-danger btn-denuncia" type="button">Denuncia</button>
        <button class="btn btn-sm btn-outline-danger btn-saida" type="button">Terminar Partida</button>

      </form>
    </nav>

    <div class="card" style="width: 1080px; height: auto; margin: 50px auto; border-radius: 25px;">
      <div class="card-body" style="filter: blur(0); transition: filter 0.3s ease-in-out;">
        <!-- conteúdo a partir daqui -->
        <div class="card" style="width: auto; height: auto; background-color: rgb(190, 190, 200); border-radius: 15px;">
          <?php
          $perguntaNumero = 1; // Variável para contar o número da pergunta

          while ($row = mysqli_fetch_assoc($result)) {
            $pergunta = $row['enunciado'];
            $alternativaA = $row['alternativa1'];
            $alternativaB = $row['alternativa2'];
            $alternativaC = $row['alternativa3'];
            $alternativaD = $row['alternativa4'];

            echo '<div class="card" style="width: auto; height: auto; background-color: rgb(190, 190, 200); border-radius: 15px;">';
            echo '<div class="card-body">';
            echo '<h4>Pergunta ' . $perguntaNumero . '/7</h4>';
            echo '<div class="pergunta-container">';
            echo $pergunta;
            echo '</div>';
            echo '</div>';
            echo '</div>';

            echo '<div class="sessaodebotoes">';
            echo '<div style="display: flex; align-items: center;">';
            echo '<button type="button" class="btn exe-button opcaoA">';
            echo 'A) ' . $alternativaA;
            echo '</button>';
            echo '</div>';

            echo '<div style="display: flex; align-items: center;">';
            echo '<button type="button" class="btn exe-button opcaoB">';
            echo 'B) ' . $alternativaB;
            echo '</button>';
            echo '</div>';

            echo '<div style="display: flex; align-items: center;">';
            echo '<button type="button" class="btn exe-button opcaoC">';
            echo 'C) ' . $alternativaC;
            echo '</button>';
            echo '</div>';

            echo '<div style="display: flex; align-items: center;">';
            echo '<button type="button" class="btn exe-button opcaoD">';
            echo 'D) ' . $alternativaD;
            echo '</button>';
            echo '</div>';

            echo '</div>';

            $perguntaNumero++; // Incrementa o número da pergunta
          }
          ?>
          <div class="telapontuacao">
            <div class="telapontuacao-cont">
              <!--Div para o cabeçalho todo-->
              <div class="headerpont">
                <h2>Pontuação atual: R$???.???,??</h2>
                <!--Div apenas paraeditar estilos da subheader-->
                <div class="subhead">
                  <h4>Pergunta Atual: ?/7</h4>
                </div>
              </div>
              <!--Começo do duv e conteudo da tabela-->
              <div class="tabela">
                <table class="table table-striped table-hover table-sm">
                  <thead>
                    <tr class="table-roxo">
                      <th scope="col">N° pergunta</th>
                      <th scope="col">Acertar</th>
                      <th scope="col">Parar</th>
                      <th scope="col">Errar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">1</th>
                      <td>R$1 mil</td>
                      <td>R$0</td>
                      <td>R$0</td>
                    </tr>
                    <tr>
                      <th scope="row">2</th>
                      <td>R$5 mil</td>
                      <td>R$1 mil</td>
                      <td>R$500</td>
                    </tr>
                    <tr>
                      <th scope="row">3</th>
                      <td>R$50 mil</td>
                      <td>R$5 mil</td>
                      <td>R$2,5 mil</td>
                    </tr>
                    <tr>
                      <th scope="row">4</th>
                      <td>R$100 mil</td>
                      <td>R$50 mil</td>
                      <td>R$25 mil</td>
                    </tr>
                    <tr>
                      <th scope="row">5</th>
                      <td>R$300 mil</td>
                      <td>R$100 mil</td>
                      <td>R$50 mil</td>
                    </tr>
                    <tr>
                      <th scope="row">6</th>
                      <td>R$500 mil</td>
                      <td>R$300 mil</td>
                      <td>R$150 mil</td>
                    </tr>
                    <tr>
                      <th scope="row">5</th>
                      <td>R$1 milhão</td>
                      <td>R$500 mil</td>
                      <td>R$0</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <button class="btn btn-outline-danger btn-lg fechar-btn">fechar</button>
            </div>
          </div>

          <!--
    tela de denuncia
  -->
          <div class="telaDenuncia">
            <div class="telaDenuncia-content">
              <h2>Gostaria de denunciar essa pergunta?</h2>
              <div class="botoesdedenuncia">
                <button class="btn btn-outline-info btn-lg sim-btn fechar-btn">Sim</button>
                <!--Quando clicar neste botão, realizar a denuncia e usar um alerta de bootstrap para notificar-->
                <button class="btn btn-outline-info btn-lg nao-btn fechar-btn">Não</button>
              </div>
            </div>
          </div>

          <!--
    tela de saida
  -->
          <div class="tela_saida">
            <div class="tela-saida-cont">
              <h2>Você deseja desistir?</h2>
              <h4>
                Seu prêmio está estimado em R$???.????,?? <br>
              </h4>
              <button class="btn btn-outline-info btn-lg sim-btn incerteza-btn">Sim</button>
              <button class="btn btn-outline-info btn-lg nao-btn fechar-btn">Não</button>
            </div>
          </div>

          <!--
    tela de "vc tem certeza que quer sair?"
  -->
          <div class="tela-temcerteza">
            <div class="tela-temcerteza-cont">
              <h2>Você tem certeza?</h2>
              <button class="btn btn-outline-info btn-lg nao-btn fechar-btn">Não</button>
              <button class="btn btn-outline-info btn-lg sim-btn desistencia-btn">Sim</button>
            </div>
          </div>

          <!--
    tela de confimação de saida
  -->
          <div class="telaconfirmacaosaida">
            <div class="telaconfirmacaosaida-cont">
              <h1>Você Perdeu!</h1>
              <h4>Seu prêmio: R$???.???,??</h4>
              <a href="tela_principal.html">
                <button type="button" class="btn btn-primary btn-lg" style="border-radius: 25px;"><b>Voltar para o
                    menu</b></button>
              </a>
            </div>
          </div>
</body>

</html>