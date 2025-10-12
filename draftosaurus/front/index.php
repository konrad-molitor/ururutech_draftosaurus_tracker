<?php
session_start();
$action = $_GET['action'] ?? '';
$sessionUser = $_SESSION['user'] ?? null;
$email = $sessionUser['email'] ?? '';
$userRole = strtolower(trim($sessionUser['role'] ?? 'player'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draftosaurus Tracker</title>
    <link rel="icon" href="../assets/icons/trex.png" type="image/png">
    <link rel="stylesheet" href="../css/style.css?v=1.1">
    <script src="../js/lang.js?v=1.0" defer></script>
    <script src="../js/index.js?v=1.1" defer></script>
    <script src="../js/admin.js?v=1.0" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">

        <!-- Main Navigation -->
        <nav>
            <h1>Draftosaurus Tracker</h1>
            <div class="language spanish" onclick="changeLanguage()"></div>
        </nav>

        <main class="main">
            <!-- Content Sections -->
            <section id="home" class="section screen active">
                <button class="button" onclick="showScreen('rules')">Reglas</button>
                <button class="button" onclick="showScreen('account')">Mi Cuenta</button>
                <button class="button" onclick="showScreen('tracking')">Modo seguimiento</button>
                <button class="button" onclick="showScreen('play')">Modo Juego Digitalizado</button>
            </section>

            <!-- Section Rules -->
            <section id="rules" class="section screen">
                <div class="rules-subsection-dark">
                    <div class="subsection-row">
    
                        <div class="subsection-column">
                            <div class="rules-section rule about">
                                <h2 class="welcome">¡Bienvenido!</h2>
                                <div class="text">Presentamos a Draftosaurus Tracker, un sistema que sirve como una herramienta auxiliar para facilitar la puntuación y la aplicación de reglas, mejorando la experiencia de los jugadores</div>
                            </div>
                            
                            <div class="subsection-row">
                                <div class="rules-section players-number" style="margin-right: 5px;">
                                    <h3>Jugadores</h3>
                                    <div class="player-icons">
                                        <div class="icon-wrapper">
                                            <div class="icon-img icon-img-2"></div>
                                            <div class="tooltip">2 jugadores: Retira 2 dinosaurios de cada especie 
                                                (12 dinosaurios se quedan en la caja, 48 van al juego)
                                            </div>
                                        </div>
                                        <div class="icon-wrapper">
                                            <div class="icon-img icon-img-3"></div>
                                            <div class="tooltip">3 jugadores: Retira 4 dinosaurios de cada especie.
                                                (24 dinosaurios se quedan en la caja, 36 van al juego)
                                            </div>
                                        </div>
                                        <div class="icon-wrapper">
                                            <div class="icon-img icon-img-4"></div>
                                            <div class="tooltip">4 jugadores: Retira 2 dinosaurios de cada (12 dinosaurios se quedan en la caja, 48 van al juego)</div>
                                        </div>
                                        <div class="icon-wrapper">
                                            <div class="icon-img icon-img-5"></div>
                                            <div class="tooltip">5 jugadores: se utiliza 60 dinosaurios (todos)</div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="rules-section players-number" style="margin-left: 5px;">
                                <h3>El dado de colocación</h3>
                                <div class="player-icons">
                                    <div class="icon-wrapper">
                                        <div class="icon-img forest"></div>
                                        <div class="tooltip">El Bosque: 
                                            Los dinosaurios deben colocarse en cualquier recinto 
                                            del área de Bosque del parque.
                                        </div>
                                    </div>
                                    <div class="icon-wrapper">
                                        <div class="icon-img planes"></div>
                                        <div class="tooltip">Llanura: 
                                            Los dinosaurios deben colocarse en cualquier recinto 
                                            del área de Llanura del parque.
                                        </div>
                                    </div>
                                    <div class="icon-wrapper">
                                        <div class="icon-img wc"></div>
                                        <div class="tooltip">Baños: 
                                            Los dinosaurios deben colocarse únicamente en los recintos 
                                            que se encuentren a la derecha del Río.
                                        </div>
                                    </div>
                                    <div class="icon-wrapper">
                                        <div class="icon-img cafe"></div>
                                        <div class="tooltip">Cafetería: 
                                            Los dinosaurios deben colocarse únicamente en los recintos 
                                            que se encuentren a la izquierda del Río.
                                        </div>
                                    </div>
                                    <div class="icon-wrapper">
                                        <div class="icon-img empty"></div>
                                        <div class="tooltip">Recinto Vacío: 
                                            Los dinosaurios deben colocarse en un recinto vacío 
                                            del parque.
                                        </div>
                                    </div>
                                    <div class="icon-wrapper">
                                        <div class="icon-img trex"></div>
                                        <div class="tooltip">¡Cuidado con el T-Rex!: 
                                            Los dinosaurios deben colocarse en un recinto 
                                            que no contenga previamente un T-Rex. 
                                            Se puede jugar un T-Rex este turno, 
                                            siempre que el recinto donde vaya a ser colocado 
                                            no contenga previamente otro T-Rex.
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="subsection-column">
                            <div class="rules-section rule">
                                <h3>Preparación</h3>
                                <li>Elegir la cantidad del jugadores.</li>
                                <li>Elegir modo del tablero (verano o invierno).</li>
                                <li>El jugador más joven pone el dado de colocación.</li>
                            </div>
                            
                            <div class="rules-section rule">
                                <h3>Cómo se juega</h3>
                                <li>Draftosaurus se juega en dos rondas. Cada ronda se compone de seis turnos.</li>
                                <li>Al comienzo de cada ronda, los jugadores reciben sin mirar seis dinosaurios.</li> 
                                <li>Todos los jugadores colocan un dinosaurio en su zoológico.</li> 
                                <li>Todos los jugadores excepto el jugador que tiró el dado deben cumplir la condición impuesta por el dado (o poner un dinosaurio en el río).</li>     
                                <li>Otros dinosaurios se pasan al otro jugador</li>
                            </div>
                        </div>

                    </div>
                    
                    <!-- Rulebook in carousel -->
                    <div class="manual-carousel-container">
                        <h2 class="manual-title">Manual del Juego</h2>
                        <div class="manual-carousel">
                            <div class="carousel-wrapper">
                                <div class="carousel-slide active">
                                    <img src="../assets/manual/page1.jpg" alt="Página 1 del manual" class="manual-page">
                                </div>
                                <div class="carousel-slide">
                                    <img src="../assets/manual/page2.jpg" alt="Página 2 del manual" class="manual-page">
                                </div>
                                <div class="carousel-slide">
                                    <img src="../assets/manual/page3.jpg" alt="Página 3 del manual" class="manual-page">
                                </div>
                                <div class="carousel-slide">
                                    <img src="../assets/manual/page4.jpg" alt="Página 4 del manual" class="manual-page">
                                </div>
                                <div class="carousel-slide">
                                    <img src="../assets/manual/page5.jpg" alt="Página 5 del manual" class="manual-page">
                                </div>
                                <div class="carousel-slide">
                                    <img src="../assets/manual/page6.jpg" alt="Página 6 del manual" class="manual-page">
                                </div>
                                <div class="carousel-slide">
                                    <img src="../assets/manual/page7.jpg" alt="Página 7 del manual" class="manual-page">
                                </div>
                                <div class="carousel-slide">
                                    <img src="../assets/manual/page8.jpg" alt="Página 8 del manual" class="manual-page">
                                </div>
                            </div>
                            
                            <!-- Buttons of carousel -->
                            <button class="carousel-btn prev-btn" onclick="changeSlide(-1)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="carousel-btn next-btn" onclick="changeSlide(1)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            
                            <!-- Page indicators -->
                            <div class="carousel-indicators">
                                <span class="indicator active" onclick="currentSlide(1)"></span>
                                <span class="indicator" onclick="currentSlide(2)"></span>
                                <span class="indicator" onclick="currentSlide(3)"></span>
                                <span class="indicator" onclick="currentSlide(4)"></span>
                                <span class="indicator" onclick="currentSlide(5)"></span>
                                <span class="indicator" onclick="currentSlide(6)"></span>
                                <span class="indicator" onclick="currentSlide(7)"></span>
                                <span class="indicator" onclick="currentSlide(8)"></span>
                            </div>
                            
                            <!-- Page counter -->
                            <div class="page-counter">
                                <span id="current-page">1</span> / <span id="total-pages">8</span>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="button" onclick="showScreen('home')">Salir</button>
            </section>
            
             <!--Section tracking-->
            <section id="tracking" class="section screen">
                <div class="rules-subsection-dark">
                    <div class="subsection-column players-modo-tracking">
                        <h2 class="tracking-section-h2">Preparación de la partida</h2>

                        <div class="players-number">
                            <h3>Seleccione cantidad de jugadores:</h3>
                            <div class="player-icons">
                                <div class="icon-wrapper" onclick="setPlayers(2)">
                                    <div class="icon-img icon-img-2"></div>
                                    <div>2 jugadores</div>
                                </div>
                                <div class="icon-wrapper" onclick="setPlayers(3)">
                                    <div class="icon-img icon-img-3"></div>
                                    <div>3 jugadores</div>
                                </div>
                                <div class="icon-wrapper" onclick="setPlayers(4)">
                                    <div class="icon-img icon-img-4"></div>
                                    <div>4 jugadores</div>
                                </div>
                                <div class="icon-wrapper" onclick="setPlayers(5)">
                                    <div class="icon-img icon-img-5"></div>
                                    <div>5 jugadores</div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="mode-selection" style="display: none;">
                            <h3>Seleccione el modo de tablero:</h3>

                            <div class="icon-wrapper" onclick="selectMode('verano')">
                                <div class="icon-img icon-summer-button"></div>
                            </div>

                            <div class="icon-wrapper">
                                <div class="icon-img icon-winter-button"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <button class="button" onclick="showScreen('home')">Cancelar</button>
            </section>

             <!--Section Board-->
            <section id="board" class="section screen">
                <div class="game-content">
                    <div class="table">
                        <div class="table-side" id="cafe-side">
                            <div class="field-equality" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                            <div class="field-three" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                            <div class="field-love" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        </div>
                        <div class="table-center" id="river" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div class="table-side" id="wc-side">
                            <div class="field-king" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                            <div class="field-diversity" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                            <div class="field-one" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        </div>
                        
                    </div>

                    <div class="dinosaurs-panel">
                        <div class="dino tRex" draggable="true" ondragstart="drag(event)"></div>
                        <div class="dino stegosaurus" draggable="true" ondragstart="drag(event)"></div>
                        <div class="dino brontosaurus" draggable="true" ondragstart="drag(event)"></div>
                        <div class="dino triceratops" draggable="true" ondragstart="drag(event)"></div>
                        <div class="dino iguanodon" draggable="true" ondragstart="drag(event)"></div>
                        <div class="dino spinosaurus" draggable="true" ondragstart="drag(event)"></div>
                    </div>
                </div>

                <button class="button" onclick="finishGame()">Fin</button>
            </section>

            <!--Section Results-->
            <section id="results" class="section screen">
                <div class="results-section results-text">
                    <!-- Заполняется динамически через finishGame() -->
                </div>
                <button class="button" onclick="showScreen('home')">Salir</button>
            </section>

            <!--Section Play-->
            <section id="play" class="section screen">
                <!-- Главное меню игры / Menú principal del juego -->
                <button class="button" onclick="showScreen('new-game')">Juego Nuevo</button>
                <button class="button" onclick="showScreen('saved-game')">Juego Guardado</button>
                <button class="button" onclick="showScreen('home')">Salir</button>
                
            </section>

            <!--Section New Game-->
            <section id="new-game" class="section screen">
                <div class="rules-subsection-dark">
                    <div class="subsection-column players-modo-tracking">
                        <h2 class="tracking-section-h2">Configuración de nueva partida</h2>
                        
                        <!-- Player Addition Section -->
                        <div class="player-addition">
                            <h3>Añadir jugadores (2-5 jugadores):</h3>
                            <div class="add-player-form">
                                <input type="email" id="player-email" placeholder="Email del jugador" maxlength="100">
                                <button class="button" onclick="addPlayer()">Añadir</button>
                            </div>
                            <div id="player-count" class="player-count">Jugadores añadidos: 0/5</div>
                        </div>

                        <!-- Players List Section -->
                        <div class="players-list" id="players-list">
                            <h3>Jugadores en la partida:</h3>
                            <div id="players-container" class="players-container">
                                <!-- Players will be added here dynamically -->
                            </div>
                        </div>

                        <!-- Mode Selection (hidden initially) -->
                        <div class="mode-selection" id="new-game-mode-selection" style="display: none;">
                            <h3>Seleccione el modo de tablero:</h3>
                            <div class="mode-buttons">
                                <div class="icon-wrapper" onclick="selectGameMode('verano')">
                                    <div class="icon-img icon-summer-button"></div>
                                    <div>Verano</div>
                                </div>
                                <div class="icon-wrapper">
                                    <div class="icon-img icon-winter-button"></div>
                                    <div>Invierno</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="button" onclick="showScreen('play')">Cancelar</button>
            </section>

            <!--Section Saved Game-->
            <section id="saved-game" class="section screen">
                <div class="rules-subsection-dark">
                    <div class="subsection-column players-modo-tracking">
                        <h2 class="tracking-section-h2">Juegos Guardados</h2>
                        
                        <div class="saved-games-container">
                            <p style="color: black; text-align: center; padding: 50px;">
                                Funcionalidad en desarrollo.<br>
                                Pronto podrás guardar y cargar tus partidas.
                            </p>
                        </div>
                    </div>
                </div>

                <button class="button" onclick="showScreen('play')">Volver</button>
            </section>

            <!--Section Account-->
            <section id="account" class="section screen">
                <div class="account-subsection-row">
                    <!--Section User Profile-->
                    <?php if ($email){ ?>
                        <?php
                            // Obtener datos del usuario de seccion
                            $user = $sessionUser;
                            $userId = $user['id'] ?? null;
                            if (!$userId) {
                                header("Location: ../front/rechazo.php"); // Redirigir a página de rechazo
                            }
                        ?>
                            <script>
                                if (<?php echo $action == 'profile' ? 'true' : 'false' ?>) {
                                        window.addEventListener('DOMContentLoaded', () => {
                                        showScreen('account');
                                    })
                                }    
                            </script>
                            <?php if ($userRole !== 'admin') { ?>
                            <div class="profile">
                                <h2>¡Bienvenido/a, <?php echo $user['name'] ?>!</h2> 
                                
                                <form action="../back/update_user.php" method="POST" enctype="multipart/form-data">
                                    <label for="name">Nombre:</label>
                                    <input type="text" id="name" name="name" value="<?php echo $user['name'] ?>">
                        
                                    <label for="birthday">Fecha de Nacimiento:</label>
                                    <input type="date" id="birthday" value="<?php echo $user['birthday'] ?>" disabled>
                                
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" value="<?php echo $user['email'] ?>" disabled>
                                
                                    <button class="button submit" type="submit">Actualizar</button>
                                </form>
                                <form id="delete-account-form" action="../back/delete_user.php" method="POST" style="display:none;"></form>
                                <a class="button" onclick="(function(){ if (confirm('¿Seguro que deseas eliminar tu cuenta? Esta acción es irreversible.')) { document.getElementById('delete-account-form').submit(); } })()">Eliminar cuenta</a>
                                <a class="button" href="../back/logout.php">Cerrar sessión</a>
                            </div>
                            <div class="result">
                                <h2>Resultados de partidas</h2>
                                <!-- Contenedor de resultados de partidas de BD-->
                                <div id="misResultados" style="margin-top: 20px;">
                                    No hay resultados
                                </div>
                            </div>
                            <?php } ?>
                            
                            <?php if ($userRole === 'admin') { ?>
                                <div class="admin-row">
                                    <div class="rules-section admin-card">
                                        <h3>Administración de usuarios</h3>
                                        <!-- Formulario de admin para usuarios de BD -->
                                        <form id="admin-create-user" onsubmit="return false;" style="margin-bottom: 10px;">
                                            <input type="text" name="name" placeholder="Nombre" required>
                                            <input type="date" name="birthday" placeholder="Fecha de Nacimiento">
                                            <input type="email" name="email" placeholder="Email" required>
                                            <input type="password" name="password" placeholder="Password" required>
                                            <button class="button" onclick="adminCreateUser()">Crear</button>
                                        </form>
                                        <div id="admin-users-list">Cargando usuarios...</div>
                                    </div>
                                    <!-- <div class="rules-section admin-card"> -->
                                    <!-- <h3>Administración de partidas</h3> -->
                                        <!-- Formulario de admin para partidas de BD -->
                                    <!-- <div id="admin-games-list">Cargando partidas...</div> -->
                                    <!--</div>-->
                                </div>
                                <a class="button admin-logout" href="../back/logout.php">Cerrar sessión</a>
                            <?php } ?>
                            
                    <!--Section Registracion-->
                    <?php } else { ?>
                        <div class="registration">
                            <h2>Crear cuenta</h2>
                            <form action="../back/user.php" method="POST">
                            <label for="name">Nombre:<font color="red">*</font></label>
                            <input type="text" id="name" name="name" required minlength="2" maxlength="50">
                    
                            <label for="birthday">Fecha de Nacimiento:<font color="red">*</font></label>
                            <input type="date" id="birthday" name="birthday">
                    
                            <label for="email">Email:<font color="red">*</font></label>
                            <input type="email" id="email" name="email" required minlength="3" maxlength="50">

                            <label for="password">Password:<font color="red">*</font></label>
                            <input type="password" id="password" name="password" required minlength="6" maxlength="50">
                    
                            <button type="submit" class="button">Enviar</button>
                            </form>
                        </div>
            
                        <div class="login">
                            <h2>¿Ya ha registrado? Ingresar</h2>
                            <form action="../back/login.php" method="POST">
                            <label for="email">Email:</label>
                            <input type="email" id="login-email" name="email" maxlength="100">

                                <label for="password">Password:</label>
                                <input type="password" id="login-password" name="password" required minlength="6" maxlength="50">
                            
                                <button type="submit" class="button">Ingresar</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>   
                <?php if ($userRole !== 'admin') { ?>
                <button class="button" onclick="showScreen('home')">Salir</button>
                <?php } ?>
            </section>
            
        </main>
        <footer>
            <div>3ME UruRuTech</div>
        </footer>
        
    </div>
</body>
</html>
