<?php
$openweathermap_api_key = "acdad291e0f75e7fa065d9bbfa9af52c"; 
include 'conexao.php';

$pais_id = $_GET['id'] ?? 0;

if (!is_numeric($pais_id) || $pais_id <= 0) {
    die("ID de país inválido.");
}

// banco do pais
$sql_pais = "SELECT nome FROM Paises WHERE id = ?";
$stmt_pais = $conexao->prepare($sql_pais);
$stmt_pais->bind_param("i", $pais_id);
$stmt_pais->execute();
$result_pais = $stmt_pais->get_result();
$pais_db = $result_pais->fetch_assoc();

if (!$pais_db) {
    die("País não encontrado no banco de dados.");
}

$nome_pais_pt = $pais_db['nome']; // Nome em português 

// api para tradução
$pais_api_data = null;
$url_rest_countries = "https://restcountries.com/v3.1/translation/" . urlencode($nome_pais_pt );

$context = stream_context_create(['http' => ['ignore_errors' => true]] );
$json_data = file_get_contents($url_rest_countries, false, $context);

if (strpos($http_response_header[0], "200 OK" ) !== false) {
    $response_data = json_decode($json_data, true);
    if (!empty($response_data)) {
        $pais_api_data = $response_data[0];
    }
}

// busca a cidade cadastrada do pais
$sql_cidades = "SELECT nome, populacao FROM Cidades WHERE pais = ? ORDER BY nome ASC";
$stmt_cidades = $conexao->prepare($sql_cidades);
$stmt_cidades->bind_param("i", $pais_id);
$stmt_cidades->execute();
$result_cidades = $stmt_cidades->get_result();

$stmt_pais->close();
$stmt_cidades->close();
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes de <?= htmlspecialchars($nome_pais_pt) ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    
    <a href="index.php" class="back-link">Voltar para a busca</a>
    <div class="card">
        <div class="card-header">
            <?php if ($pais_api_data && isset($pais_api_data['flags']['png'])): ?>
                <img src="<?= htmlspecialchars($pais_api_data['flags']['png']) ?>" alt="Bandeira de <?= htmlspecialchars($nome_pais_pt) ?>" class="flag-img">
            <?php endif; ?>
            <div>
                <h1><?= htmlspecialchars($nome_pais_pt) ?></h1>
                <?php if ($pais_api_data): ?>
                    <p style="margin: 5px 0 0 0;">
                        <strong>Capital:</strong> <?= htmlspecialchars($pais_api_data['capital'][0] ?? 'N/A') ?>   
                        <br>
                        <strong>Moeda:</strong> <?= htmlspecialchars(current($pais_api_data['currencies'])['name'] ?? 'N/A') ?> 
                        (<?= htmlspecialchars(current($pais_api_data['currencies'])['symbol'] ?? '') ?>)
                    </p>
                <?php else: ?>
                    <p style="margin: 5px 0 0 0; color: #888;">Não foi possível carregar dados adicionais do país.</p>
                <?php endif; ?>
            </div>
        </div>

        <hr>
        <div class="card-cidade">          
            <h2>Cidades Cadastradas</h2>
            <?php if ($result_cidades->num_rows > 0): ?>
                <ul>
                    <?php while ($cidade = $result_cidades->fetch_assoc()): 
                        $nome_cidade_slug = htmlspecialchars(str_replace(' ', '-', $cidade['nome']));
                        $nome_cidade = htmlspecialchars($cidade['nome']);
                    ?>
                        <li class="city-item" id="city-<?= $nome_cidade_slug ?>">
                            <div style="margin-right: 10px;">
                                <strong><?= $nome_cidade ?></strong> - 
                                População: <?= number_format($cidade['populacao'], 0, ',', '.') ?>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <button class="weather-btn" onclick="getWeather('<?= $nome_cidade ?>', '<?= $nome_pais_pt ?>', '<?= $nome_cidade_slug ?>')">
                                    <i class="bi bi-thermometer-sun"></i> Ver Clima
                                </button>
                                <div class="loader" id="loader-<?= $nome_cidade_slug ?>"></div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Nenhuma cidade cadastrada para este país.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        async function getWeather(cidade, pais, cidadeSlug) {
            const apiKey = '<?= $openweathermap_api_key ?>';
            const cityItem = document.getElementById(`city-${cidadeSlug}`);
            const loader = document.getElementById(`loader-${cidadeSlug}`);
            const existingWeatherInfo = cityItem.querySelector('.weather-info');

            if (existingWeatherInfo) {
                existingWeatherInfo.remove();
                return;
            }

            loader.style.display = 'inline-block';

            try {
                const url = `https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(cidade )},${encodeURIComponent(pais)}&appid=${apiKey}&units=metric&lang=pt_br`;
                
                const response = await fetch(url);
                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || `Erro na API (Status: ${response.status})`);
                }

                const weatherHTML = `
                    <div class="weather-info">
                        <strong>Clima em ${data.name}:</strong> ${data.weather[0].description}, ${Math.round(data.main.temp)}°C. 
                        Sensação térmica: ${Math.round(data.main.feels_like)}°C.
                    </div>
                `;
                
                cityItem.insertAdjacentHTML('beforeend', weatherHTML);

            } catch (error) {
                console.error("Erro ao buscar clima:", error);
                const errorHTML = `<div class="weather-info" style="background-color: #fdd; color: #a00;">Erro: ${error.message}.</div>`;
                cityItem.insertAdjacentHTML('beforeend', errorHTML);
            } finally {
                loader.style.display = 'none';
            }
        }
    </script>
</body>
</html>
