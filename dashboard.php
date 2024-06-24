<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="10"> <!-- Atualiza a página a cada 20 segundos -->
    <title>Dados de Monitoramento</title>
    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .vazio {
            background-color: green;
            color: white;
        }
        .precisa-atencao {
            background-color: yellow;
            color: black;
        }
        .entupido {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>

<h2>Dados do Sensor Em Tempo Real</h2>

<!-- Div para exibir o contador -->
<div id="contador"></div>

<!-- Tabela para o último dado do bueiro -->
<table id="tabelaBueiro">
    <caption>Último Dado do Bueiro</caption>
    <thead>
        <tr>
            <th>ID Medição</th>
            <th>ID Sensor</th>
            <th>ID Bueiro</th>
            <th>Distância (cm)</th>
            <th>Timestamp</th>
            <th>Nível de Detritos</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script>
    // Função para iniciar o contador de 20 segundos
    function iniciarContador() {
        var segundos = 10;
        var contador = setInterval(function() {
            document.getElementById('contador').innerText = 'Próxima atualização em ' + segundos + ' segundos';
            segundos--;

            // Se o contador chegar a 0, reinicia
            if (segundos < 0) {
                clearInterval(contador);
                iniciarContador(); // Reinicia o contador
            }
        }, 1000); // Atualiza a cada 1 segundo
    }

    // Iniciar o contador quando a página carregar
    window.onload = function() {
        iniciarContador();
        buscarDados();
    };

    // Função para buscar dados do servidor
    function buscarDados() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var dados = JSON.parse(xhr.responseText);
                mostrarDados(dados);
            }
        };
        xhr.open("GET", "buscar_dados.php", true);
        xhr.send();
    }

    // Função para exibir os dados na tabela
    function mostrarDados(dados) {
        var tabelaBueiro = document.getElementById("tabelaBueiro").getElementsByTagName('tbody')[0];
        tabelaBueiro.innerHTML = ""; // Limpar a tabela

        if (dados.combinado.length > 0) {
            var ultimoDado = dados.combinado[0]; // Pegar o dado mais recente

            var linha = document.createElement("tr");

            linha.innerHTML = `
                <td>${ultimoDado.id_medicao}</td>
                <td>${ultimoDado.id_sensor}</td>
                <td>${ultimoDado.id_bueiro}</td>
                <td>${ultimoDado.distancia}</td>
                <td>${ultimoDado.timestamp}</td>
                <td class="${obterClasseNivel(ultimoDado.nivel_detritos)}">${ultimoDado.nivel_detritos}</td>
            `;

            tabelaBueiro.appendChild(linha);
        }
    }

    // Função para obter a classe CSS de acordo com o nível de detritos
    function obterClasseNivel(nivel) {
        if (nivel === 'Vazio') {
            return 'vazio';
        } else if (nivel === 'Precisa de Atenção') {
            return 'precisa-atencao';
        } else if (nivel === 'Entupido') {
            return 'entupido';
        }
        return '';
    }
</script>

</body>
</html>
