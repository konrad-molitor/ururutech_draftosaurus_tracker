<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draftosaurus Tracker</title>
    <link rel="icon" href="../assets/icons/trex.png" type="image/png">
    <link rel="stylesheet" href="../css/style.css?v=1.1">
    <link rel="stylesheet" href="../css/game.css?v=1.1">
    <script src="../js/lang.js?v=1.0" defer></script>
    <script src="../js/index.js?v=1.1" defer></script>
    <script src="../js/game.js?v=1.1" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php
        // Obtener información de jugadores por IDs recibidos en query (?jugadores=1,2,3)
        $players = [];
        // Obtener "modo" de la query y normalizar
        $modoParam = $_GET['modo'] ?? '';
        $modoParam = strtolower($modoParam);
        $modo = ($modoParam === 'invierno') ? 'invierno' : 'verano';

        try {
            $idsParam = $_GET['jugadores'] ?? '';
            $rawIds = explode(',', $idsParam);
            $ids = [];
            foreach ($rawIds as $rawId) {
                $rawId = trim($rawId);
                if ($rawId !== '' && ctype_digit($rawId)) {
                    $intId = (int)$rawId;
                    if ($intId > 0) {
                        $ids[$intId] = $intId; // usar como índice para evitar duplicados
                    }
                }
            }

            if (!empty($ids)) {
                $ids = array_values($ids);
                $safeIds = implode(',', $ids);

                $servername = "localhost";
                $username = "root";
                $db_password = "";
                $dbname = "DRAFTOSAURUS";

                $conn = new mysqli($servername, $username, $db_password, $dbname);
                if ($conn->connect_error) {
                    throw new Exception("Conexión fallida: " . $conn->connect_error);
                }

                $sql = "SELECT id, name, email FROM USERS WHERE id IN ($safeIds)";
                $result = $conn->query($sql);
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $players[] = [
                            'id' => (int)$row['id'],
                            'name' => $row['name'],
                            'email' => $row['email']
                        ];
                    }
                    $result->free();
                }

                $conn->close();
            }
        } catch (Exception $e) {
            error_log("front/game.php jugadores fetch error: " . $e->getMessage());
        }
    ?>
    <script>
        window.gamePlayers = <?php echo json_encode($players, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
        window.gameModo = <?php echo json_encode($modo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    </script>
</head>
<body>
    <div class="container">

        <!-- Main Navigation -->
        <nav>
            <h1>Draftosaurus Tracker</h1>
            <div class="language"></div>
        </nav>

        <main class="main">
            <div class="game-content">
                <div class="subsection-row" style="align-items: stretch;">
                    <aside class="rules-section game-info">
                        <h2 style="color: black; text-shadow: none;">Información de Juego</h2>
                        <div class="game-stat"><strong>Ronda:</strong> <span id="game-round">1</span></div>
                        <div class="game-stat"><strong>Turno:</strong> <span id="game-turn">1</span></div>
                        <hr>
                        <div class="game-player">
                            <div><strong>Jugador actual:</strong></div>
                            <div id="game-player-name">-</div>
                            <div id="game-player-email">-</div>
                        </div>
                        <hr>
                        <div class="dice-display">
                            <div class="icon-img" id="dice-icon"></div>
                            <div id="dice-text"></div>
                        </div>
                    </aside>

                    <div class="table">
                        <div class="table-side" id="cafe-side">
                            <div class="field-equality taiga cafe-side" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                            <div class="field-three taiga cafe-side" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                            <div class="field-love pampa cafe-side" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        </div>
                        <div class="table-center" id="river" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div class="table-side" id="wc-side">
                            <div class="field-king taiga wc-side" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                            <div class="field-diversity pampa wc-side" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                            <div class="field-one pampa wc-side" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        </div>
                    </div>
                </div>

                <div class="dinosaurs-panel" id="dinosaurs-panel">
                    <!-- Chips del jugador actual se insertarán dinámicamente -->
                </div>
                <button class="button" id="finish-turn-btn" disabled>Finalizar turno</button>
            </div>
        </main>
        <footer>
            <div>3ME UruRuTech</div>
        </footer>
    </div>
</body>
</html>