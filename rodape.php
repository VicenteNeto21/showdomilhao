<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-/Y6pD6pU4a8vI6+OGtoEwGpFdJQ9B8MWvALM2Q6QcYs/RwU8Q1a1TGyoozGksdqr" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js" integrity="sha512-jvH9eTzkjKq3+gJW8WevS+bSAmnOUul+M05VLG4FFJv4h4xFsZsYKfBkW8zta/wr6tzmk0COU69kr6aWbfIv+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Yvckj+OnVuNS6LZ+m6UwNR6J2I6rAxr6Uy7V5C5X5orLFG1/IObY2Jqrgw5b1g7V" crossorigin="anonymous"></script>
<script>
    // Seletor do link "Ver mais estatísticas"
    var verMaisEstatisticasLink = document.getElementById("verMaisEstatisticas");

    // Manipulador de evento de clique no link "Ver mais estatísticas"
    verMaisEstatisticasLink.addEventListener("click", function(event) {
        event.preventDefault(); // Impede o comportamento padrão do link

        // Exiba os dados das estatísticas extras
        var estatisticasExtrasDiv = document.createElement("div");
        estatisticasExtrasDiv.innerHTML = "Perguntas Respondidas: <b><?php echo $usuario['quant_perguntas_respondidas'] ?></b> <br> Eliminações usadas: <b><?php echo $usuario['quat_eliminacoes_usadas'] ?></b> </br> Derrotas por erro: <b><?php echo $usuario['numero_derrotas_erro'] ?></b> <br>";

        // Insira os dados abaixo do link
        verMaisEstatisticasLink.insertAdjacentElement("afterend", estatisticasExtrasDiv);
        
        // Remova o link "Ver mais estatísticas"
        verMaisEstatisticasLink.remove();
    });
</script>

    </body>
</html>