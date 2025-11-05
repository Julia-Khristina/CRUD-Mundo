
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banner e Barra de Pesquisa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .banner {
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
        }

        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 30px 20px;
            min-height: calc(100vh - 70px); 
        }

        .search-container {
            width: 100%;
            max-width: 60%;
        }

        .search-box {
            position: relative;
            display: flex;
            align-items: center;
            background: white;
            border: 1px solid #961b80;
            border-radius: 24px;
            padding: 12px 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .search-box:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            border-color: #961b80;
        }

        .search-box:focus-within {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            border-color: #961b80;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 16px;
            color: #333333;
            background: transparent;
            padding: 8px 0;
        }

        .search-input::placeholder {
            color: #999999;
        }

        .search-box button {
            flex-shrink: 0;
            width: 20px;
            height: 20px;
            margin-left: 12px;
            cursor: pointer;
            outline: none;
            box-shadow: none;
            padding: 0;
            background: none;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.6;
            transition: opacity 0.3s ease;
        }

        .search-box button:hover {
            opacity: 1;
        }

        .search-box button:focus {
            outline: none;
        }

        .search-icon svg {
            width: 100%;
            height: 100%;
            stroke: #999999;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .search-box button i {
            color: #999999;
            font-size: 18px;
        }

        .content {
            margin-top: 40px;
            text-align: center;
            color: #666;
        }

        @media (max-width: 768px) {
            .search-box {
                padding: 10px 16px;
            }

            .search-input {
                font-size: 14px;
            }

            .search-container {
                max-width: 95%;
            }

            .main-container {
                padding: 20px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="banner">
        <img src="./adm/img/frontImg.jpg" alt="Flores Decorativas">
    </div>

    <div class="main-container">
        <div class="search-container">
            <form class="search-box" onsubmit="handleSearch(event)">
                <input 
                    type="text" 
                    class="search-input" 
                    placeholder="Explore o mundo começando por um país..."
                    aria-label="Campo de pesquisa"
                >
                <button type="submit" aria-label="Enviar pesquisa">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <div class="content">
            <p>A barra de pesquisa está posicionada logo abaixo do banner.</p>
        </div>
    </div>

    <script>
        function handleSearch(event) {
            event.preventDefault();
            const searchTerm = event.target.querySelector('.search-input').value;
            if (searchTerm.trim()) {
                console.log('Pesquisa realizada:', searchTerm);
                // lógica de pesquisa
                alert('Pesquisando por: ' + searchTerm);
            }
        }
    </script>
</body>
</html>
