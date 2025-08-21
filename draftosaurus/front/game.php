<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draftosaurus Tracker</title>
    <link rel="stylesheet" href="../css/style.css?v=1.1">
    <link rel="stylesheet" href="../css/game.css?v=1.1">
    <script src="../js/index.js?v=1.1" defer></script>
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
       
        const getDado = () => {
            return Math.floor(Math.random() * 6) + 1;
        }

        const getPlayer = (player, seqNumber, chips) => {
            return {
                id: player.id,
                name: player.name,
                email: player.email,
                givenChips: chips,
                seqNumber,
                status: seqNumber === 1 ? 'play' : 'wait',
                didMove: false,
                field: {
                    equality: [],
                    three: [],
                    love: [],
                    king: [],
                    diversity: [],
                    one: [],
                    river: []
                }
            }
        }

        const getChips = (numPlayers) => {
            const dinos = ['stegosaurus', 'brontosaurus', 'triceratops', 'iguanodon', 'spinosaurus', 'tRex'];

            let chips = [];
            if (numPlayers === 2 || numPlayers === 4) {
                chips = dinos.map(dino => {
                    return Array(8).fill(dino);
                });
            }

            if (numPlayers === 3) {
                chips = dinos.map(dino => {
                    return Array(6).fill(dino);
                });
            }

            if (numPlayers === 5) {
                chips = dinos.map(dino => {
                    return Array(10).fill(dino);
                });
            }

            return chips.flat();
        }

        const getRandomChips = () => {
            const randomChips = [];
            for (let i = 0; i < 6; i++) {
                const randomIndex = Math.floor(Math.random() * window.gameChips.length);
                randomChips.push(window.gameChips[randomIndex]);
                window.gameChips.splice(randomIndex, 1);
            }
            return randomChips;
        }

        function initGame() {
            console.log('Modo Juego - jugadores (desde PHP):', window.gamePlayers);
            console.log('Modo Juego - modo (desde PHP):', window.gameModo);
            console.log('Iniciando juego...');

            window.gameChips = getChips(window.gamePlayers.length);

            window.gameState = {
                modo: window.gameModo,
                jugadorActual: 1,
                ronda: 1,
                turno: 1,
                dado: getDado(),
                jugadores: window.gamePlayers.map((player, index) => getPlayer(player, index + 1, getRandomChips())),
            }

            console.log('Estado del juego:', window.gameState);

            renderGame();
        }

        function renderGame() {
            const judadorName = document.getElementById('game-player-name');
            const judadorEmail = document.getElementById('game-player-email');
            const ronda = document.getElementById('game-round');
            const turno = document.getElementById('game-turn');

            judadorName.textContent = window.gameState.jugadores[window.gameState.jugadorActual - 1].name;
            judadorEmail.textContent = window.gameState.jugadores[window.gameState.jugadorActual - 1].email;
            ronda.textContent = window.gameState.ronda;
            turno.textContent = window.gameState.turno;

            // Render del dado (solo imagen)
            const diceIcon = document.getElementById('dice-icon');
            if (diceIcon) {
                const dice = window.gameState.dado;
                const diceMap = {
                    1: { cls: 'forest' },
                    2: { cls: 'planes' },
                    3: { cls: 'wc' },
                    4: { cls: 'cafe' },
                    5: { cls: 'empty' },
                    6: { cls: 'trex' }
                };
                const face = diceMap[dice] || { cls: '' };
                diceIcon.className = 'icon-img ' + face.cls;
            }

            const panel = document.getElementById('dinosaurs-panel');
            if (panel) {
                panel.innerHTML = '';
                const currentPlayer = window.gameState.jugadores[window.gameState.jugadorActual - 1];
                const chips = Array.isArray(currentPlayer.givenChips) ? currentPlayer.givenChips : [];
                chips.forEach(function(chipType) {
                    const chipEl = document.createElement('div');
                    chipEl.className = 'dino ' + chipType;
                    const isDisabled = !!currentPlayer.didMove;
                    chipEl.setAttribute('draggable', isDisabled ? 'false' : 'true');
                    if (!isDisabled) {
                        chipEl.setAttribute('ondragstart', 'drag(event)');
                    }
                    panel.appendChild(chipEl);
                });
            }

            // Mostrar/ocultar el botón de finalizar turno
            const finishBtn = document.getElementById('finish-turn-btn');
            if (finishBtn) {
                const currentPlayer = window.gameState.jugadores[window.gameState.jugadorActual - 1];
                if (currentPlayer && currentPlayer.didMove) {
                    finishBtn.style.display = '';
                    finishBtn.removeAttribute('disabled');
                } else {
                    finishBtn.style.display = 'none';
                    finishBtn.setAttribute('disabled', 'true');
                }
            }

            // Volcar el tablero del jugador actual desde el estado
            renderBoardForCurrentPlayer();
        }

        function renderBoardForCurrentPlayer() {
            if (!window.gameState) return;
            const currentPlayer = window.gameState.jugadores[window.gameState.jugadorActual - 1];
            if (!currentPlayer || !currentPlayer.field) return;

            const zones = {
                equality: document.querySelector('.field-equality'),
                three: document.querySelector('.field-three'),
                love: document.querySelector('.field-love'),
                king: document.querySelector('.field-king'),
                diversity: document.querySelector('.field-diversity'),
                one: document.querySelector('.field-one'),
                river: document.getElementById('river')
            };

            Object.values(zones).forEach(function(zoneEl) {
                if (zoneEl) zoneEl.innerHTML = '';
            });

            const createDinoEl = function(dinoType) {
                const el = document.createElement('div');
                el.className = 'dino ' + dinoType;
                el.setAttribute('draggable', 'false');
                return el;
            };

            (currentPlayer.field.equality || []).forEach(function(type) {
                if (zones.equality) zones.equality.appendChild(createDinoEl(type));
            });
            (currentPlayer.field.three || []).forEach(function(type) {
                if (zones.three) zones.three.appendChild(createDinoEl(type));
            });
            (currentPlayer.field.love || []).forEach(function(type) {
                if (zones.love) zones.love.appendChild(createDinoEl(type));
            });
            (currentPlayer.field.king || []).forEach(function(type) {
                if (zones.king) zones.king.appendChild(createDinoEl(type));
            });
            (currentPlayer.field.diversity || []).forEach(function(type) {
                if (zones.diversity) zones.diversity.appendChild(createDinoEl(type));
            });
            (currentPlayer.field.one || []).forEach(function(type) {
                if (zones.one) zones.one.appendChild(createDinoEl(type));
            });
            (currentPlayer.field.river || []).forEach(function(type) {
                if (zones.river) zones.river.appendChild(createDinoEl(type));
            });
        }

        // --- Juego digital: colocación y estado ---
        function mapDropZoneToFieldKey(dropZone) {
            if (!dropZone || !dropZone.classList) return null;
            if (dropZone.classList.contains('field-equality')) return 'equality';
            if (dropZone.classList.contains('field-three')) return 'three';
            if (dropZone.classList.contains('field-love')) return 'love';
            if (dropZone.classList.contains('field-king')) return 'king';
            if (dropZone.classList.contains('field-diversity')) return 'diversity';
            if (dropZone.classList.contains('field-one')) return 'one';
            if (dropZone.classList.contains('table-center')) return 'river';
            return null;
        }

        // Validación adicional según el dado: bosque/llanura/cafetería/baños
        function isAllowedByDice(dropZone) {
            if (!window.gameState || !dropZone) return true;
            const dice = window.gameState.dado;
            // Siempre permitir el río
            if (dropZone.id === 'river' || dropZone.classList.contains('table-center')) {
                return true;
            }
            switch (dice) {
                case 1: // Bosque
                    return dropZone.classList.contains('taiga');
                case 2: // Llanura
                    return dropZone.classList.contains('pampa');
                case 3: // Baños (lado derecho)
                    return dropZone.classList.contains('wc-side');
                case 4: // Cafetería (lado izquierdo)
                    return dropZone.classList.contains('cafe-side');
                case 5: { // Recinto vacío (excepto río)
                    const hasAnyDino = !!dropZone.querySelector('.dino');
                    return !hasAnyDino;
                }
                case 6: { // ¡Cuidado con el T-Rex! (excepto río)
                    if (dropZone.id === 'river' || dropZone.classList.contains('table-center')) {
                        return true;
                    }
                    const dinos = dropZone.querySelectorAll('.dino');
                    for (let i = 0; i < dinos.length; i++) {
                        const type = (typeof getDinoType === 'function') ? getDinoType(dinos[i]) : null;
                        if (type === 'tRex') {
                            return false;
                        }
                    }
                    return true;
                }
                default:
                    return true;
            }
        }

        function dropGameHandler(ev) {
            ev.preventDefault();

            // draggedElement y validateDrop definidos en index.js
            if (typeof draggedElement === 'undefined' || !draggedElement) {
                return;
            }

            const dropZone = ev.target.closest('[ondrop]');
            if (!dropZone || dropZone.id === 'dinosaurs-panel') {
                return;
            }

            const currentPlayerIndex = (window.gameState && window.gameState.jugadorActual) ? (window.gameState.jugadorActual - 1) : 0;
            const currentPlayer = window.gameState ? window.gameState.jugadores[currentPlayerIndex] : null;

            // Si el jugador ya hizo su movimiento, no permitimos más acciones
            if (currentPlayer && currentPlayer.didMove) {
                window.draggedElement = null;
                return;
            }

            // Validación de reglas por zona (común)
            if (typeof validateDrop === 'function') {
                if (!validateDrop(dropZone, draggedElement)) {
                    // Reset del arrastre actual
                    window.draggedElement = null;
                    return;
                }
            }

            // Validación adicional por dado
            if (!isAllowedByDice(dropZone)) {
                alert('Colocación no permitida por el dado');
                window.draggedElement = null;
                return;
            }

            const isFromPanel = !!draggedElement.closest('.dinosaurs-panel');

            // Mover desde el panel al tablero (sin duplicar)
            if (isFromPanel) {
                dropZone.appendChild(draggedElement);
            } else {
                // Si no se arrastra desde el panel, se ignora
                return;
            }

            // Limpiar estilos en línea para visualización correcta
            const placedElement = dropZone.lastElementChild;
            if (placedElement) {
                placedElement.style.position = '';
                placedElement.style.left = '';
                placedElement.style.top = '';
                placedElement.style.transform = '';
                placedElement.style.margin = '';
                placedElement.style.width = '';
                placedElement.style.height = '';
                placedElement.style.lineHeight = '';
            }

            // Actualizar el estado del juego: campo del jugador y sus fichas
            if (currentPlayer) {
                if (typeof getDinoType === 'function') {
                    const dinoType = getDinoType(draggedElement);
                    const zoneKey = mapDropZoneToFieldKey(dropZone);
                    if (dinoType && zoneKey && currentPlayer.field && Array.isArray(currentPlayer.field[zoneKey])) {
                        currentPlayer.field[zoneKey].push(dinoType);
                    }
                    // Eliminar esta ficha de las entregadas (para que no vuelva al panel al renderizar)
                    if (Array.isArray(currentPlayer.givenChips)) {
                        const idx = currentPlayer.givenChips.findIndex(function(ch) { return ch === dinoType; });
                        if (idx > -1) {
                            currentPlayer.givenChips.splice(idx, 1);
                        }
                    }
                    currentPlayer.didMove = true;
                }
            }

            // El botón de finalizar turno se activa si el jugador ya jugó
            const finishBtn = document.getElementById('finish-turn-btn');
            if (finishBtn && currentPlayer && currentPlayer.didMove) {
                finishBtn.style.display = '';
                finishBtn.removeAttribute('disabled');
            }

            // Limpiar la referencia al elemento arrastrado
            window.draggedElement = null;
        }

        function dragGameHandler(ev) {
            const currentPlayerIndex = (window.gameState && window.gameState.jugadorActual) ? (window.gameState.jugadorActual - 1) : 0;
            const currentPlayer = window.gameState ? window.gameState.jugadores[currentPlayerIndex] : null;
            // Bloquear inicio de arrastre si el turno ya fue realizado
            if (currentPlayer && currentPlayer.didMove) {
                ev.preventDefault();
                return false;
            }
            // Delegar al manejador base
            if (typeof dragstartHandler === 'function') {
                return dragstartHandler(ev);
            }
        }
        
        // --- Finalización de turno y transiciones ---
        function passTurnToNextPlayer(nextPlayerNumber) {
            console.log('Pasar turno al siguiente jugador:', nextPlayerNumber);
        }

        function startNextTurn(nextTurnNumber) {
            console.log('Pasar al siguiente turno:', nextTurnNumber);
        }

        function startNextRound() {
            console.log('Pasar a la ronda 2, turno 1');
        }

        // --- Cálculo de puntos para el modo juego ---
        function getDinoNameInSpanishForScore(dinoType) {
            const dinoNames = {
                'tRex': 'T-Rex',
                'stegosaurus': 'Estegosaurio',
                'brontosaurus': 'Brontosaurio',
                'triceratops': 'Triceratops',
                'iguanodon': 'Iguanodón',
                'spinosaurus': 'Espinosaurio'
            };
            return dinoNames[dinoType] || dinoType;
        }

        function calculatePlayerScore(player, allPlayers) {
            const fields = player.field || {};
            const equality = Array.isArray(fields.equality) ? fields.equality : [];
            const three = Array.isArray(fields.three) ? fields.three : [];
            const love = Array.isArray(fields.love) ? fields.love : [];
            const king = Array.isArray(fields.king) ? fields.king : [];
            const diversity = Array.isArray(fields.diversity) ? fields.diversity : [];
            const one = Array.isArray(fields.one) ? fields.one : [];
            const river = Array.isArray(fields.river) ? fields.river : [];

            // Igualdad
            const equalityPointsTable = { 0:0, 1:2, 2:4, 3:8, 4:12, 5:18, 6:24 };
            const equalityPoints = equalityPointsTable[equality.length] || 0;

            // Tres (exactamente 3)
            const threePoints = (three.length === 3) ? 7 : 0;

            // Amor: 5 puntos por pareja del mismo tipo
            const loveTypeCount = {};
            love.forEach(t => { loveTypeCount[t] = (loveTypeCount[t] || 0) + 1; });
            let lovePoints = 0;
            Object.keys(loveTypeCount).forEach(t => { lovePoints += Math.floor(loveTypeCount[t] / 2) * 5; });

            // Rey: 1 dino; 7 puntos si este jugador tiene estrictamente más dinos de ese tipo que cada otro jugador (sin preguntar)
            let kingPoints = 0;
            let kingComparison = null;
            if (king.length === 1) {
                const type = king[0];
                const zonesThis = [equality, three, love, king, diversity, one, river];
                const countFor = (playerObj) => {
                    const f = playerObj.field || {};
                    const z = [
                        f.equality || [],
                        f.three || [],
                        f.love || [],
                        f.king || [],
                        f.diversity || [],
                        f.one || [],
                        f.river || []
                    ];
                    let c = 0;
                    z.forEach(zone => zone.forEach(d => { if (d === type) c++; }));
                    return c;
                };
                const thisCount = countFor(player);
                const others = (Array.isArray(allPlayers) ? allPlayers : []).filter(p => p !== player);
                const otherCounts = others.map(op => ({ name: op.name, email: op.email, count: countFor(op) }));
                const strictlyGreater = otherCounts.every(oc => thisCount > oc.count);
                if (strictlyGreater) kingPoints = 7;
                kingComparison = { type, thisCount, others: otherCounts };
            }

            // Diversidad: tabla por cantidad
            const diversityPointsTable = { 0:0, 1:1, 2:3, 3:6, 4:10, 5:15, 6:21 };
            const diversityPoints = diversityPointsTable[diversity.length] || 0;

            // Uno: exactamente 1 dino y único en el parque
            let onePoints = 0;
            if (one.length === 1) {
                const type = one[0];
                const otherZones = [equality, three, love, king, diversity, river];
                let found = false;
                for (const zone of otherZones) {
                    if (zone.some(z => z === type)) { found = true; break; }
                }
                if (!found) onePoints = 7;
            }

            // Río: 1 punto por dino
            const riverPoints = river.length;

            // Bonus T-Rex: 1 punto por recinto/zone con al menos un T-Rex
            let trexBonusPoints = 0;
            const zonesForBonus = [equality, three, love, king, diversity, one, river];
            zonesForBonus.forEach(zone => { if (zone.some(z => z === 'tRex')) trexBonusPoints += 1; });

            const total = equalityPoints + threePoints + lovePoints + kingPoints + diversityPoints + onePoints + riverPoints + trexBonusPoints;
            return {
                equalityPoints,
                threePoints,
                lovePoints,
                kingPoints,
                kingComparison,
                diversityPoints,
                onePoints,
                riverPoints,
                trexBonusPoints,
                total
            };
        }

        function finishGameAndScore() {
            if (!window.gameState || !Array.isArray(window.gameState.jugadores)) return;
            console.log('Juego finalizado. Calculando puntuaciones...');
            const results = window.gameState.jugadores.map(p => {
                const score = calculatePlayerScore(p, window.gameState.jugadores);
                return { player: p, score };
            });

            // Determinar la puntuación máxima
            const maxTotal = Math.max(...results.map(r => r.score.total));
            // Logs con destacados de ganador(es) y detalles
            results.forEach(({ player, score }) => {
                const winnerMark = score.total === maxTotal ? '<< WINNER' : '';
                console.log(`Jugador: ${player.name} (${player.email}) TOTAL=${score.total} ${winnerMark}`);
                console.log('  Detalle:', {
                    Igualdad: score.equalityPoints,
                    Tres: score.threePoints,
                    Amor: score.lovePoints,
                    Rey: score.kingPoints,
                    Diversidad: score.diversityPoints,
                    Uno: score.onePoints,
                    Río: score.riverPoints,
                    BonusTRex: score.trexBonusPoints
                });
                if (score.kingComparison) {
                    const typeName = getDinoNameInSpanishForScore(score.kingComparison.type);
                    console.log(`  Rey comparativa (${typeName}): este jugador=${score.kingComparison.thisCount}, otros=`, score.kingComparison.others);
                }
            });
            console.log('Resultados finales (ordenados):', results
                .slice()
                .sort((a, b) => b.score.total - a.score.total)
                .map(r => ({ name: r.player.name, email: r.player.email, total: r.score.total }))
            );

            // Mostrar resultados directamente en la página (sin modal)
            const gameContent = document.querySelector('.game-content');
            if (gameContent) {
                // Limpiar todo el contenido de la pantalla de juego
                gameContent.innerHTML = '';
                const sorted = results.slice().sort((a, b) => b.score.total - a.score.total);
                const winnerTotal = sorted[0] ? sorted[0].score.total : 0;
                const wrapper = document.createElement('div');
                wrapper.className = 'rules-section results-text';
                wrapper.style.marginTop = '10px';
                let html = '<h2 style="color:black; text-shadow:none; text-align:center;">Resultados finales</h2>';
                html += sorted.map(({ player, score }) => {
                    const isWinner = score.total === winnerTotal;
                    return `
                        <div class=\"results-section results-text\" style=\"margin-top: 10px; ${isWinner ? 'border-color: gold;' : ''}\">
                            <h2 style=\"color: black; text-shadow: none; text-align: center;\">${player.name} (${player.email}) ${isWinner ? '<span style=\"color: goldenrod;\">WINNER</span>' : ''}</h2>
                            <li><b>El Bosque de la Semejanza:</b> ${score.equalityPoints} puntos</li>
                            <li><b>El Trío Frondoso:</b> ${score.threePoints} puntos</li>
                            <li><b>La Pradera del Amor:</b> ${score.lovePoints} puntos</li>
                            <li><b>El Rey de la Selva:</b> ${score.kingPoints} puntos</li>
                            <li><b>El Prado de la Diferencia:</b> ${score.diversityPoints} puntos</li>
                            <li><b>La Isla Solitaria:</b> ${score.onePoints} puntos</li>
                            <li><b>El Río:</b> ${score.riverPoints} puntos</li>
                            <li><b>Bonus T-Rex:</b> ${score.trexBonusPoints} puntos</li>
                            <hr style=\"margin: 10px 0; border: 1px solid #666;\">
                            <p style=\"font-size: 1.1em; text-align: center;\"><strong>TOTAL: ${score.total} puntos</strong></p>
                        </div>
                    `;
                }).join('');
                wrapper.innerHTML = html;
                gameContent.appendChild(wrapper);

                // Botón para volver al inicio
                const backBtn = document.createElement('a');
                backBtn.href = 'index.php';
                backBtn.className = 'button';
                backBtn.textContent = 'Volver al inicio';
                backBtn.style.display = 'block';
                backBtn.style.margin = '10px auto';
                gameContent.appendChild(backBtn);
            }
        }

        function rotateGivenChipsToNextPlayer() {
            if (!window.gameState || !Array.isArray(window.gameState.jugadores)) return;
            const players = window.gameState.jugadores;
            const n = players.length;
            if (n === 0) return;
            const bags = players.map(p => Array.isArray(p.givenChips) ? p.givenChips : []);
            for (let i = 0; i < n; i++) {
                const nextIndex = (i + 1) % n;
                players[nextIndex].givenChips = bags[i];
            }
            console.log('Pasar fichas restantes al siguiente jugador en círculo.');
        }

        function finishTurn() {
            const gs = window.gameState;
            if (!gs) return;
            const currentIndex = gs.jugadorActual - 1;
            const jugador = gs.jugadores[currentIndex];
            if (!jugador || !jugador.didMove) {
                alert('Debes colocar un dinosaurio antes de finalizar el turno');
                return;
            }

            // 1-2. Confirmar jugada y marcar como "finished"
            jugador.status = 'finished';

            const isLastPlayer = gs.jugadorActual === gs.jugadores.length;

            if (!isLastPlayer) {
                // 3. Pasar turno al siguiente jugador
                gs.jugadorActual += 1;
                gs.jugadores.forEach((p, i) => {
                    if (i === gs.jugadorActual - 1) {
                        p.status = 'play';
                    } else if (p.status !== 'finished') {
                        p.status = 'wait';
                    }
                });
                passTurnToNextPlayer(gs.jugadorActual);
            } else {
                // Último jugador en el orden
                if (gs.ronda === 1 && gs.turno === 6) {
                    // 4. Ir a ronda 2 turno 1
                    startNextRound();
                    gs.ronda = 2;
                    gs.turno = 1;
                    gs.dado = getDado();
                    console.log('Nuevo dado (ronda 2, turno 1):', gs.dado);
                    gs.jugadorActual = 1;
                    gs.jugadores.forEach((p, i) => {
                        p.didMove = false;
                        p.status = (i === 0) ? 'play' : 'wait';
                        // Entregar nuevo set de fichas para la segunda ronda del pool restante
                        p.givenChips = getRandomChips();
                    });
                } else if (gs.turno < 6) {
                    // 5. Pasar al siguiente turno
                    startNextTurn(gs.turno + 1);
                    gs.turno += 1;
                    gs.dado = getDado();
                    console.log('Nuevo dado (siguiente turno):', gs.dado);
                    // Pasar las fichas restantes al siguiente jugador por seqNumber
                    rotateGivenChipsToNextPlayer();
                    gs.jugadorActual = 1;
                    gs.jugadores.forEach((p, i) => {
                        p.didMove = false;
                        p.status = (i === 0) ? 'play' : 'wait';
                    });
                } else if (gs.ronda === 2 && gs.turno === 6) {
                    // 6. Fin del juego
                    finishGameAndScore();
                } else {
                    // Rama de seguridad: si el estado no está contemplado
                    console.log('Estado de fin de turno no reconocido:', { ronda: gs.ronda, turno: gs.turno });
                }
            }

            // Tras el cambio de jugador/turno ocultar el botón y re-renderizar
            const finishBtn = document.getElementById('finish-turn-btn');
            if (finishBtn) {
                finishBtn.style.display = 'none';
                finishBtn.setAttribute('disabled', 'true');
            }
            renderGame();
        }
            

        document.addEventListener('DOMContentLoaded', function() {
            // Reasignar manejadores para el modo juego
            window.drop = dropGameHandler;
            window.drag = dragGameHandler;
            const finishBtn = document.getElementById('finish-turn-btn');
            if (finishBtn) {
                finishBtn.addEventListener('click', finishTurn);
            }
            initGame();
        });
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