// --- Internationalización ampliada (ES/EN) para index.php ---
const i18n = {
    es: {
        // Home
        'home.rules': 'Reglas',
        'home.account': 'Mi Cuenta',
        'home.tracking': 'Modo seguimiento',
        'home.play': 'Modo Juego Digitalizado',

        // Common
        'common.exit': 'Salir',
        'common.cancel': 'Cancelar',
        'common.error': 'Error',
        'common.networkError': 'Error de red',

        // Rules
        'rules.welcome.h2': '¡Bienvenido!',
        'rules.welcome.text': 'Presentamos a Draftosaurus Tracker, un sistema que sirve como una herramienta auxiliar para facilitar la puntuación y la aplicación de reglas, mejorando la experiencia de los jugadores',
        'rules.players.h3': 'Jugadores',
        'rules.players.tooltip2': '2 jugadores: Retira 2 dinosaurios de cada especie (12 dinosaurios se quedan en la caja, 48 van al juego)',
        'rules.players.tooltip3': '3 jugadores: Retira 4 dinosaurios de cada especie. (24 dinosaurios se quedan en la caja, 36 van al juego)',
        'rules.players.tooltip4': '4 jugadores: Retira 2 dinosaurios de cada (12 dinosaurios se quedan en la caja, 48 van al juego)',
        'rules.players.tooltip5': '5 jugadores: se utiliza 60 dinosaurios (todos)',
        'rules.dice.h3': 'El dado de colocación',
        'rules.dice.forest': 'El Bosque: Los dinosaurios deben colocarse en cualquier recinto del área de Bosque del parque.',
        'rules.dice.plains': 'Llanura: Los dinosaurios deben colocarse en cualquier recinto del área de Llanura del parque.',
        'rules.dice.wc': 'Baños: Los dinosaurios deben colocarse únicamente en los recintos que se encuentren a la derecha del Río.',
        'rules.dice.cafe': 'Cafetería: Los dinosaurios deben colocarse únicamente en los recintos que se encuentren a la izquierda del Río.',
        'rules.dice.empty': 'Recinto Vacío: Los dinosaurios deben colocarse en un recinto vacío del parque.',
        'rules.dice.trex': '¡Cuidado con el T-Rex!: Los dinosaurios deben colocarse en un recinto que no contenga previamente un T-Rex. Se puede jugar un T-Rex este turno, siempre que el recinto donde vaya a ser colocado no contenga previamente otro T-Rex.',
        'rules.prep.h3': 'Preparación',
        'rules.prep.item1': 'Elegir la cantidad del jugadores.',
        'rules.prep.item2': 'Elegir modo del tablero (verano o invierno).',
        'rules.prep.item3': 'El jugador más joven pone el dado de colocación.',
        'rules.how.h3': 'Cómo se juega',
        'rules.how.item1': 'Draftosaurus se juega en dos rondas. Cada ronda se compone de seis turnos.',
        'rules.how.item2': 'Al comienzo de cada ronda, los jugadores reciben sin mirar seis dinosaurios.',
        'rules.how.item3': 'Todos los jugadores colocan un dinosaurio en su zoológico.',
        'rules.how.item4': 'Todos los jugadores excepto el jugador que tiró el dado deben cumplir la condición impuesta por el dado (o poner un dinosaurio en el río).',
        'rules.how.item5': 'Otros dinosaurios se pasan al otro jugador',
        'rules.manual.title': 'Manual del Juego',
        'rules.exit': 'Salir',

        // Tracking
        'tracking.h2': 'Preparación de la partida',
        'tracking.selectPlayers.h3': 'Seleccione cantidad de jugadores:',
        'tracking.player2': '2 jugadores',
        'tracking.player3': '3 jugadores',
        'tracking.player4': '4 jugadores',
        'tracking.player5': '5 jugadores',
        'tracking.selectMode.h3': 'Seleccione el modo de tablero:',
        'tracking.cancel': 'Cancelar',

        // Play
        'play.new': 'Juego Nuevo',
        'play.saved': 'Juego Guardado',
        'play.exit': 'Salir',

        // Results
        'results.title': 'Puntos',
        'results.equality': '<b>El Bosque de la Semejanza:</b> 2-4-8-12-18-24 puntos',
        'results.three': '<b>El Trío Frondoso:</b> llena = 7 puntos',
        'results.love': '<b>La Pradera del Amor:</b> 5 puntos x pareja',
        'results.king': '<b>El Rey de la Selva:</b> tienes más dino de esta especie que otros = 7 puntos',
        'results.diversity': '<b>El Prado de la Diferencia:</b> 1-2-6-10-15-21 puntos',
        'results.one': '<b>La Isla Solitaria:</b> un dino único en tu parque = 7 puntos',
        'results.river': '<b>El Río:</b> 1 punto x dino',
        'results.trex': '<b>Bonus T-Rex:</b> 1 punto x recinto',
        'results.exit': 'Salir',

        // New Game
        'newGame.h2': 'Configuración de nueva partida',
        'newGame.addPlayers.h3': 'Añadir jugadores (2-5 jugadores):',
        'newGame.email.placeholder': 'Email del jugador',
        'newGame.addButton': 'Añadir',
        'newGame.playerCount': 'Jugadores añadidos: {count}/5',
        'newGame.noPlayers': 'No hay jugadores añadidos',
        'newGame.playersList.h3': 'Jugadores en la partida:',
        'newGame.selectMode.h3': 'Seleccione el modo de tablero:',
        'newGame.summer': 'Verano',
        'newGame.winter': 'Invierno',
        'newGame.cancel': 'Cancelar',
        'newGame.removePlayer': 'Eliminar',
        // New Game alerts/errors
        'newGame.alert.enterEmail': 'Por favor, ingrese un email',
        'newGame.alert.validEmail': 'Por favor, ingrese un email válido',
        'newGame.alert.alreadyAdded': 'Este jugador ya está añadido a la partida',
        'newGame.alert.maxPlayers': 'No se pueden añadir más de 5 jugadores',
        'newGame.alert.needMinPlayers': 'Necesitas al menos 2 jugadores para comenzar la partida',
        'newGame.alert.maxPlayersGame': 'No puedes tener más de 5 jugadores',
        'newGame.user.notFound': 'Usuario no encontrado. El jugador debe estar registrado en el sistema.',
        'newGame.user.verifyError': 'Error al verificar el usuario. Por favor, intente nuevamente.',
        'newGame.leave.confirm': '¿Estás seguro de que quieres salir? Se perderá la configuración de la partida.',

        // Board
        'board.finish': 'Fin',

        // Saved Game
        'saved.h2': 'Juegos Guardados',
        'saved.message': 'Funcionalidad en desarrollo.\nPronto podrás guardar y cargar tus partidas.',
        'saved.back': 'Volver'
        ,
        // Account - Logged in (profile)
        'account.profile.welcome': '¡Bienvenido/a, {name}!',
        'account.profile.name.label': 'Nombre:',
        'account.profile.birthday.label': 'Fecha de Nacimiento:',
        'account.profile.email.label': 'Email:',
        'account.profile.update': 'Actualizar',
        'account.profile.delete': 'Eliminar cuenta',
        'account.profile.delete.confirm': '¿Seguro que deseas eliminar tu cuenta? Esta acción es irreversible.',
        'account.profile.logout': 'Cerrar sesión',
        // Account - Results
        'account.results.h2': 'Resultados de partidas',
        'account.results.empty': 'No hay resultados',
        // Account - Admin
        'account.admin.users.h3': 'Administración de usuarios',
        'account.admin.users.create': 'Crear',
        'account.admin.users.loading': 'Cargando usuarios...',
        'account.admin.users.empty': 'No hay usuarios',
        'account.admin.users.search.placeholder': 'Buscar por nombre o email',
        'account.admin.users.table.id': 'ID',
        'account.admin.users.table.name': 'Nombre',
        'account.admin.users.table.birthday': 'Nacimiento',
        'account.admin.users.table.email': 'Email',
        'account.admin.users.table.password': 'Password',
        'account.admin.users.table.actions': 'Acciones',
        'account.admin.users.update': 'Actualizar',
        'account.admin.users.delete': 'Eliminar',
        'account.admin.users.updated': 'Actualizado',
        'account.admin.users.delete.confirm': '¿Eliminar usuario #{id}?',
        'account.admin.games.h3': 'Administración de partidas',
        'account.admin.games.loading': 'Cargando partidas...',
        'account.admin.games.empty': 'No hay partidas',
        'account.admin.games.item': 'Partida #{id}',
        'account.admin.games.delete': 'Eliminar',
        'account.admin.games.delete.confirm': '¿Eliminar partida #{id}?',
        'account.admin.logout': 'Cerrar sesión',
        'account.admin.form.name.placeholder': 'Nombre',
        'account.admin.form.birthday.placeholder': 'Fecha de Nacimiento',
        'account.admin.form.email.placeholder': 'Email',
        'account.admin.form.password.placeholder': 'Password',
        // Account - Registration/Login (logged out)
        'account.register.h2': 'Crear cuenta',
        'account.register.name.labelHtml': 'Nombre:<font color="red">*</font>',
        'account.register.birthday.labelHtml': 'Fecha de Nacimiento:<font color="red">*</font>',
        'account.register.email.labelHtml': 'Email:<font color="red">*</font>',
        'account.register.password.labelHtml': 'Password:<font color="red">*</font>',
        'account.register.submit': 'Enviar',
        'account.login.h2': '¿Ya ha registrado? Ingresar',
        'account.login.email.label': 'Email:',
        'account.login.password.label': 'Password:',
        'account.login.submit': 'Ingresar'
        ,
        // Validation (drag & drop)
        'validation.error.unknownType': 'Error: No se pudo identificar el tipo de dinosaurio',
        'validation.limit.total12': 'No se pueden colocar más de 12 dinosaurios en el parque',
        'validation.equality.limit': 'En el área de Igualdad no se pueden colocar más de 6 dinosaurios',
        'validation.equality.mismatch': 'En el área de Igualdad solo se pueden colocar dinosaurios del mismo tipo',
        'validation.three.limit': 'En el área de Tres no se pueden colocar más de 3 dinosaurios',
        'validation.love.limit': 'En el área del Amor no se pueden colocar más de 6 dinosaurios',
        'validation.king.limit': 'En el área del Rey solo se puede colocar 1 dinosaurio',
        'validation.diversity.limit': 'En el área de la Diversidad no se pueden colocar más de 6 dinosaurios',
        'validation.diversity.duplicate': 'En el área de la Diversidad no se pueden colocar dinosaurios del mismo tipo',
        'validation.one.limit': 'En el área de Uno solo se puede colocar 1 dinosaurio',
        'validation.need12': '¡Atención! Necesitas colocar exactamente 12 dinosaurios en el parque para finalizar la partida. Actualmente tienes {count} dinosaurios.',
        'king.prompt': 'Tienes {count} {dino}. ¿Otros jugadores tienen menos? Y/N',
        // Scoring labels
        'score.finalTitle': 'Puntuación Final',
        'score.label.equality': 'Igualdad',
        'score.label.three': 'Tres',
        'score.label.love': 'Amor',
        'score.label.king': 'Rey',
        'score.label.diversity': 'Diversidad',
        'score.label.one': 'Uno',
        'score.label.river': 'Río',
        'score.label.trexBonus': 'Bonus T-Rex',
        'score.label.total': 'TOTAL',
        'score.units.points': 'puntos',
        'score.console.detailed': 'Puntuación detallada:'
        ,
        // Standalone pages
        'confirm.h2': 'Registro Exitoso',
        'confirm.text': '¡Gracias! Hemos recibido sus datos correctamente.',
        'confirm.back': 'Volver al inicio',
        'reject.h2': 'Error al Enviar',
        'reject.text': 'Hubo un problema. Por favor, inténtelo nuevamente.',
        'reject.back': 'Volver al inicio'
    },
    en: {
        // Home
        'home.rules': 'Rules',
        'home.account': 'My Account',
        'home.tracking': 'Tracking Mode',
        'home.play': 'Digital Game Mode',

        // Common
        'common.exit': 'Exit',
        'common.cancel': 'Cancel',
        'common.error': 'Error',
        'common.networkError': 'Network error',

        // Rules
        'rules.welcome.h2': 'Welcome!',
        'rules.welcome.text': 'Presenting Draftosaurus Tracker, a helper tool to simplify scoring and rule application, enhancing the players\' experience',
        'rules.players.h3': 'Players',
        'rules.players.tooltip2': '2 players: Remove 2 dinosaurs of each species (12 stay in the box, 48 go to the game)',
        'rules.players.tooltip3': '3 players: Remove 4 dinosaurs of each species (24 stay in the box, 36 go to the game)',
        'rules.players.tooltip4': '4 players: Remove 2 dinosaurs of each (12 stay in the box, 48 go to the game)',
        'rules.players.tooltip5': '5 players: Use 60 dinosaurs (all)',
        'rules.dice.h3': 'Dice',
        'rules.dice.forest': 'Forest: Dinosaurs must be placed in any enclosure in the Forest area of the park.',
        'rules.dice.plains': 'Plain: Dinosaurs must be placed in any enclosure in the Plain area of the park.',
        'rules.dice.wc': 'Restrooms: Dinosaurs must be placed only in enclosures to the right of the River.',
        'rules.dice.cafe': 'Cafeteria: Dinosaurs must be placed only in enclosures to the left of the River.',
        'rules.dice.empty': 'Empty Enclosure: Dinosaurs must be placed in an empty enclosure of the park.',
        'rules.dice.trex': 'Beware of the T-Rex!: Dinosaurs must be placed in an enclosure that does not already contain a T-Rex. You may play a T-Rex this turn as long as the enclosure does not already contain another T-Rex.',
        'rules.prep.h3': 'Setup',
        'rules.prep.item1': 'Choose the number of players.',
        'rules.prep.item2': 'Choose the board mode (summer or winter).',
        'rules.prep.item3': 'The youngest player rolls the placement die.',
        'rules.how.h3': 'How to play',
        'rules.how.item1': 'Draftosaurus is played over two rounds. Each round has six turns.',
        'rules.how.item2': 'At the start of each round, players receive six dinosaurs without looking.',
        'rules.how.item3': 'All players place one dinosaur in their zoo.',
        'rules.how.item4': 'All players except the one who rolled the die must obey the die condition (or place a dinosaur in the river).',
        'rules.how.item5': 'Other dinosaurs are passed to the next player.',
        'rules.manual.title': 'Game Manual',
        'rules.exit': 'Exit',

        // Tracking
        'tracking.h2': 'Game setup',
        'tracking.selectPlayers.h3': 'Select number of players:',
        'tracking.player2': '2 players',
        'tracking.player3': '3 players',
        'tracking.player4': '4 players',
        'tracking.player5': '5 players',
        'tracking.selectMode.h3': 'Select board mode:',
        'tracking.cancel': 'Cancel',

        // Play
        'play.new': 'New Game',
        'play.saved': 'Saved Game',
        'play.exit': 'Exit',

        // Results
        'results.title': 'Points',
        'results.equality': '<b>Forest of Similarity:</b> 2-4-8-12-18-24 points',
        'results.three': '<b>Leafy Trio:</b> full = 7 points',
        'results.love': '<b>Plain of Love:</b> 5 points per pair',
        'results.king': '<b>King of the Jungle:</b> you have more of this species than others = 7 points',
        'results.diversity': '<b>Meadow of Difference:</b> 1-2-6-10-15-21 points',
        'results.one': '<b>Lonely Island:</b> a unique dino in your park = 7 points',
        'results.river': '<b>River:</b> 1 point per dino',
        'results.trex': '<b>T-Rex Bonus:</b> 1 point per enclosure',
        'results.exit': 'Exit',

        // New Game
        'newGame.h2': 'New game setup',
        'newGame.addPlayers.h3': 'Add players (2-5 players):',
        'newGame.email.placeholder': 'Player email',
        'newGame.addButton': 'Add',
        'newGame.playerCount': 'Players added: {count}/5',
        'newGame.noPlayers': 'No players added',
        'newGame.playersList.h3': 'Players in the game:',
        'newGame.selectMode.h3': 'Select board mode:',
        'newGame.summer': 'Summer',
        'newGame.winter': 'Winter',
        'newGame.cancel': 'Cancel',
        'newGame.removePlayer': 'Remove',
        // New Game alerts/errors
        'newGame.alert.enterEmail': 'Please enter an email',
        'newGame.alert.validEmail': 'Please enter a valid email',
        'newGame.alert.alreadyAdded': 'This player is already added to the game',
        'newGame.alert.maxPlayers': 'You cannot add more than 5 players',
        'newGame.alert.needMinPlayers': 'You need at least 2 players to start the game',
        'newGame.alert.maxPlayersGame': 'You cannot have more than 5 players',
        'newGame.user.notFound': 'User not found. The player must be registered in the system.',
        'newGame.user.verifyError': 'Error verifying the user. Please try again.',
        'newGame.leave.confirm': 'Are you sure you want to leave? Game setup will be lost.',

        // Board
        'board.finish': 'Finish',

        // Saved Game
        'saved.h2': 'Saved Games',
        'saved.message': 'Feature in development.\nSoon you will be able to save and load your games.',
        'saved.back': 'Back'
        ,
        // Account - Logged in (profile)
        'account.profile.welcome': 'Welcome, {name}!',
        'account.profile.name.label': 'Name:',
        'account.profile.birthday.label': 'Date of Birth:',
        'account.profile.email.label': 'Email:',
        'account.profile.update': 'Update',
        'account.profile.delete': 'Delete account',
        'account.profile.delete.confirm': 'Are you sure you want to delete your account? This action is irreversible.',
        'account.profile.logout': 'Log out',
        // Account - Results
        'account.results.h2': 'Game results',
        'account.results.empty': 'No results',
        // Account - Admin
        'account.admin.users.h3': 'User administration',
        'account.admin.users.create': 'Create',
        'account.admin.users.loading': 'Loading users...',
        'account.admin.users.empty': 'No users',
        'account.admin.users.search.placeholder': 'Search by name or email',
        'account.admin.users.table.id': 'ID',
        'account.admin.users.table.name': 'Name',
        'account.admin.users.table.birthday': 'Birthday',
        'account.admin.users.table.email': 'Email',
        'account.admin.users.table.password': 'Password',
        'account.admin.users.table.actions': 'Actions',
        'account.admin.users.update': 'Update',
        'account.admin.users.delete': 'Delete',
        'account.admin.users.updated': 'Updated',
        'account.admin.users.delete.confirm': 'Delete user #{id}?',
        'account.admin.games.h3': 'Game administration',
        'account.admin.games.loading': 'Loading games...',
        'account.admin.games.empty': 'No games',
        'account.admin.games.item': 'Game #{id}',
        'account.admin.games.delete': 'Delete',
        'account.admin.games.delete.confirm': 'Delete game #{id}?',
        'account.admin.logout': 'Log out',
        'account.admin.form.name.placeholder': 'Name',
        'account.admin.form.birthday.placeholder': 'Date of Birth',
        'account.admin.form.email.placeholder': 'Email',
        'account.admin.form.password.placeholder': 'Password',
        // Account - Registration/Login (logged out)
        'account.register.h2': 'Create account',
        'account.register.name.labelHtml': 'Name:<font color="red">*</font>',
        'account.register.birthday.labelHtml': 'Date of Birth:<font color="red">*</font>',
        'account.register.email.labelHtml': 'Email:<font color="red">*</font>',
        'account.register.password.labelHtml': 'Password:<font color="red">*</font>',
        'account.register.submit': 'Submit',
        'account.login.h2': 'Already registered? Log in',
        'account.login.email.label': 'Email:',
        'account.login.password.label': 'Password:',
        'account.login.submit': 'Log in'
        ,
        // Validation (drag & drop)
        'validation.error.unknownType': 'Error: Could not identify the dinosaur type',
        'validation.limit.total12': 'You cannot place more than 12 dinosaurs in the park',
        'validation.equality.limit': 'Equality area cannot have more than 6 dinosaurs',
        'validation.equality.mismatch': 'Equality area can only contain dinosaurs of the same species',
        'validation.three.limit': 'Three area cannot have more than 3 dinosaurs',
        'validation.love.limit': 'Love area cannot have more than 6 dinosaurs',
        'validation.king.limit': 'King area can contain only 1 dinosaur',
        'validation.diversity.limit': 'Diversity area cannot have more than 6 dinosaurs',
        'validation.diversity.duplicate': 'Diversity area cannot contain dinosaurs of the same species',
        'validation.one.limit': 'One area can contain only 1 dinosaur',
        'validation.need12': 'Attention! You must place exactly 12 dinosaurs in the park to finish. You currently have {count} dinosaurs.',
        'king.prompt': 'You have {count} {dino}. Do other players have fewer? Y/N',
        // Scoring labels
        'score.finalTitle': 'Final Score',
        'score.label.equality': 'Equality',
        'score.label.three': 'Three',
        'score.label.love': 'Love',
        'score.label.king': 'King',
        'score.label.diversity': 'Diversity',
        'score.label.one': 'One',
        'score.label.river': 'River',
        'score.label.trexBonus': 'T-Rex Bonus',
        'score.label.total': 'TOTAL',
        'score.units.points': 'points',
        'score.console.detailed': 'Detailed score:'
        ,
        // Standalone pages
        'confirm.h2': 'Registration Successful',
        'confirm.text': 'Thank you! We have received your data successfully.',
        'confirm.back': 'Back to home',
        'reject.h2': 'Submission Error',
        'reject.text': 'There was a problem. Please try again.',
        'reject.back': 'Back to home'
    }
};

let currentLang = 'es';
function t(key, params) {
    const langDict = i18n[currentLang] || i18n.es || {};
    let value = langDict[key] || (i18n.es && i18n.es[key]) || key;
    if (params) {
        for (const token in params) {
            value = value.replace(new RegExp('\\{' + token + '\\}', 'g'), String(params[token]));
        }
    }
    return value;
}
function setText(el, text) { if (el) { el.textContent = text; } }
function setHTML(el, html) { if (el) { el.innerHTML = html; } }

function applyLanguage(lang) {
    currentLang = i18n[lang] ? lang : 'es';
    try { localStorage.setItem('lang', currentLang); } catch (e) {}

    // Home
    const homeButtons = document.querySelectorAll('#home .button');
    if (homeButtons && homeButtons.length >= 4) {
        homeButtons[0].textContent = t('home.rules');
        homeButtons[1].textContent = t('home.account');
        homeButtons[2].textContent = t('home.tracking');
        homeButtons[3].textContent = t('home.play');
    }

    // Language flag
    const langEl = document.querySelector('.language');
    if (langEl) {
        langEl.classList.remove('spanish', 'english');
        langEl.classList.add(currentLang === 'en' ? 'english' : 'spanish');
    }

    // Rules section
    setText(document.querySelector('#rules .rules-section.rule.about .welcome'), t('rules.welcome.h2'));
    setText(document.querySelector('#rules .rules-section.rule.about .text'), t('rules.welcome.text'));

    const rulesPlayersBlocks = document.querySelectorAll('#rules .players-number');
    if (rulesPlayersBlocks && rulesPlayersBlocks.length >= 2) {
        // First block: players count
        const playersBlock = rulesPlayersBlocks[0];
        setText(playersBlock.querySelector('h3'), t('rules.players.h3'));
        const tooltips = playersBlock.querySelectorAll('.icon-wrapper .tooltip');
        if (tooltips && tooltips.length >= 4) {
            setText(tooltips[0], t('rules.players.tooltip2'));
            setText(tooltips[1], t('rules.players.tooltip3'));
            setText(tooltips[2], t('rules.players.tooltip4'));
            setText(tooltips[3], t('rules.players.tooltip5'));
        }

        // Second block: placement die
        const diceBlock = rulesPlayersBlocks[1];
        setText(diceBlock.querySelector('h3'), t('rules.dice.h3'));
        const diceTips = diceBlock.querySelectorAll('.icon-wrapper .tooltip');
        if (diceTips && diceTips.length >= 6) {
            setText(diceTips[0], t('rules.dice.forest'));
            setText(diceTips[1], t('rules.dice.plains'));
            setText(diceTips[2], t('rules.dice.wc'));
            setText(diceTips[3], t('rules.dice.cafe'));
            setText(diceTips[4], t('rules.dice.empty'));
            setText(diceTips[5], t('rules.dice.trex'));
        }
    }

    // Rules: Preparation and How to play
    const ruleTextBlocks = document.querySelectorAll('#rules .subsection-column .rules-section.rule');
    if (ruleTextBlocks && ruleTextBlocks.length >= 2) {
        // Filter out the about block if present
        const filtered = Array.from(ruleTextBlocks).filter(el => !el.classList.contains('about'));
        if (filtered.length >= 2) {
            const prepBlock = filtered[0];
            setText(prepBlock.querySelector('h3'), t('rules.prep.h3'));
            const prepLis = prepBlock.querySelectorAll('li');
            if (prepLis && prepLis.length >= 3) {
                setText(prepLis[0], t('rules.prep.item1'));
                setText(prepLis[1], t('rules.prep.item2'));
                setText(prepLis[2], t('rules.prep.item3'));
            }

            const howBlock = filtered[1];
            setText(howBlock.querySelector('h3'), t('rules.how.h3'));
            const howLis = howBlock.querySelectorAll('li');
            if (howLis && howLis.length >= 5) {
                setText(howLis[0], t('rules.how.item1'));
                setText(howLis[1], t('rules.how.item2'));
                setText(howLis[2], t('rules.how.item3'));
                setText(howLis[3], t('rules.how.item4'));
                setText(howLis[4], t('rules.how.item5'));
            }
        }
    }
    setText(document.querySelector('#rules .manual-title'), t('rules.manual.title'));
    // Update rulebook images per language
    try {
        const slides = document.querySelectorAll('#rules .carousel-slide img.manual-page');
        slides.forEach(function(img, idx){
            const page = idx + 1;
            if (currentLang === 'en') {
                img.src = `../assets/rulebook/page${page}.png`;
                img.alt = `Rulebook page ${page}`;
            } else {
                img.src = `../assets/manual/page${page}.jpg`;
                img.alt = `Página ${page} del manual`;
            }
        });
    } catch (e) {}
    setText(document.querySelector('#rules > .button'), t('rules.exit'));

    // Tracking section
    setText(document.querySelector('#tracking .tracking-section-h2'), t('tracking.h2'));
    const trackingPlayersBlock = document.querySelector('#tracking .players-number');
    if (trackingPlayersBlock) {
        setText(trackingPlayersBlock.querySelector('h3'), t('tracking.selectPlayers.h3'));
        const wrappers = trackingPlayersBlock.querySelectorAll('.icon-wrapper');
        if (wrappers && wrappers.length >= 4) {
            setText(wrappers[0].querySelector('div:last-child'), t('tracking.player2'));
            setText(wrappers[1].querySelector('div:last-child'), t('tracking.player3'));
            setText(wrappers[2].querySelector('div:last-child'), t('tracking.player4'));
            setText(wrappers[3].querySelector('div:last-child'), t('tracking.player5'));
        }
    }
    const trackingModeSel = document.querySelector('#tracking .mode-selection');
    if (trackingModeSel) {
        setText(trackingModeSel.querySelector('h3'), t('tracking.selectMode.h3'));
    }
    setText(document.querySelector('#tracking > .button'), t('tracking.cancel'));

    // Play section
    const playButtons = document.querySelectorAll('#play .button');
    if (playButtons && playButtons.length >= 3) {
        playButtons[0].textContent = t('play.new');
        playButtons[1].textContent = t('play.saved');
        playButtons[2].textContent = t('play.exit');
    }

    // New Game section
    setText(document.querySelector('#new-game .tracking-section-h2'), t('newGame.h2'));
    setText(document.querySelector('#new-game .player-addition h3'), t('newGame.addPlayers.h3'));
    const emailInput = document.getElementById('player-email');
    if (emailInput) { emailInput.placeholder = t('newGame.email.placeholder'); }
    const addBtn = document.querySelector('#new-game .player-addition .button');
    setText(addBtn, t('newGame.addButton'));
    const playerCount = document.getElementById('player-count');
    if (playerCount) {
        const count = (typeof gamePlayers !== 'undefined' && Array.isArray(gamePlayers)) ? gamePlayers.length : 0;
        playerCount.textContent = t('newGame.playerCount', { count });
    }
    setText(document.querySelector('#new-game .players-list h3'), t('newGame.playersList.h3'));
    const newGameModeSel = document.getElementById('new-game-mode-selection');
    if (newGameModeSel) {
        setText(newGameModeSel.querySelector('h3'), t('newGame.selectMode.h3'));
        const modeButtons = newGameModeSel.querySelectorAll('.mode-buttons .icon-wrapper');
        if (modeButtons && modeButtons.length >= 2) {
            setText(modeButtons[0].querySelector('div:last-child'), t('newGame.summer'));
            setText(modeButtons[1].querySelector('div:last-child'), t('newGame.winter'));
        }
    }
    setText(document.querySelector('#new-game > .button'), t('newGame.cancel'));

    // Board section button (finish)
    const boardFinishBtn = document.querySelector('#board > .button');
    if (boardFinishBtn) setText(boardFinishBtn, t('board.finish'));

    // Saved Game section
    setText(document.querySelector('#saved-game .tracking-section-h2'), t('saved.h2'));
    const savedMsg = document.querySelector('#saved-game .saved-games-container p');
    if (savedMsg) { savedMsg.textContent = t('saved.message'); }
    setText(document.querySelector('#saved-game > .button'), t('saved.back'));

    // Results section
    setText(document.querySelector('#results h2'), t('results.title'));
    const resultsLis = document.querySelectorAll('#results .results-section li');
    if (resultsLis && resultsLis.length >= 8) {
        setHTML(resultsLis[0], t('results.equality'));
        setHTML(resultsLis[1], t('results.three'));
        setHTML(resultsLis[2], t('results.love'));
        setHTML(resultsLis[3], t('results.king'));
        setHTML(resultsLis[4], t('results.diversity'));
        setHTML(resultsLis[5], t('results.one'));
        setHTML(resultsLis[6], t('results.river'));
        setHTML(resultsLis[7], t('results.trex'));
    }
    setText(document.querySelector('#results > .button'), t('results.exit'));

    // Refresh dynamic lists using current language
    try { updatePlayersDisplay(); } catch (e) {}

    // Standalone pages: confirmacion.php / rechazo.php
    try {
        const path = (window.location && window.location.pathname) || '';
        const isConfirm = /confirmacion\.php$/i.test(path);
        const isReject = /rechazo\.php$/i.test(path);
        if (isConfirm || isReject) {
            const msg = document.querySelector('.message');
            if (msg) {
                const h2 = msg.querySelector('h2');
                const p = msg.querySelector('p');
                const a = msg.querySelector('a');
                if (isConfirm) {
                    setText(h2, t('confirm.h2'));
                    setText(p, t('confirm.text'));
                    setText(a, t('confirm.back'));
                } else if (isReject) {
                    setText(h2, t('reject.h2'));
                    setText(p, t('reject.text'));
                    setText(a, t('reject.back'));
                }
            }
        }
    } catch (e) {}

    // Account section
    const accountExitBtn = document.querySelector('#account > .button');
    if (accountExitBtn) { setText(accountExitBtn, t('common.exit')); }

    // Logged-in profile (non-admin)
    const profile = document.querySelector('#account .profile');
    if (profile) {
        const nameInput = profile.querySelector('#name');
        const userName = nameInput ? nameInput.value : '';
        setText(profile.querySelector('h2'), t('account.profile.welcome', { name: userName }));
        setText(profile.querySelector('label[for="name"]'), t('account.profile.name.label'));
        setText(profile.querySelector('label[for="birthday"]'), t('account.profile.birthday.label'));
        setText(profile.querySelector('label[for="email"]'), t('account.profile.email.label'));
        setText(profile.querySelector('button.submit'), t('account.profile.update'));
        const deleteLink = profile.querySelector('a.button[onclick]');
        if (deleteLink) {
            setText(deleteLink, t('account.profile.delete'));
            deleteLink.onclick = function() {
                if (confirm(t('account.profile.delete.confirm'))) {
                    const form = document.getElementById('delete-account-form');
                    if (form) form.submit();
                }
            };
        }
        const logoutLink = profile.querySelector('a.button[href*="logout.php"]');
        setText(logoutLink, t('account.profile.logout'));
    }

    // Logged-in results
    const resultBlock = document.querySelector('#account .result');
    if (resultBlock) {
        setText(resultBlock.querySelector('h2'), t('account.results.h2'));
        const misResultados = document.getElementById('misResultados');
        if (misResultados && misResultados.children.length === 0) {
            misResultados.textContent = t('account.results.empty');
        }
    }

    // Admin area
    const adminRow = document.querySelector('#account .admin-row');
    if (adminRow) {
        const adminCards = adminRow.querySelectorAll('.admin-card');
        if (adminCards.length >= 1) {
            const usersCard = adminCards[0];
            setText(usersCard.querySelector('h3'), t('account.admin.users.h3'));
            const adminForm = usersCard.querySelector('#admin-create-user');
            if (adminForm) {
                const nameInputAdmin = adminForm.querySelector('input[name="name"]');
                const birthdayInputAdmin = adminForm.querySelector('input[name="birthday"]');
                const emailInputAdmin = adminForm.querySelector('input[name="email"]');
                const passwordInputAdmin = adminForm.querySelector('input[name="password"]');
                if (nameInputAdmin) nameInputAdmin.placeholder = t('account.admin.form.name.placeholder');
                if (birthdayInputAdmin) birthdayInputAdmin.placeholder = t('account.admin.form.birthday.placeholder');
                if (emailInputAdmin) emailInputAdmin.placeholder = t('account.admin.form.email.placeholder');
                if (passwordInputAdmin) passwordInputAdmin.placeholder = t('account.admin.form.password.placeholder');
                const createBtn = adminForm.querySelector('button.button');
                setText(createBtn, t('account.admin.users.create'));
            }
            const usersList = document.getElementById('admin-users-list');
            if (usersList) {
                // Si ya hay tabla generada por admin.js, traducimos cabecera, placeholders y botones
                const searchInput = document.getElementById('admin-user-search');
                if (searchInput) searchInput.placeholder = t('account.admin.users.search.placeholder');

                const headerCells = usersList.querySelectorAll('table.admin-users-table tr:first-child th');
                if (headerCells && headerCells.length >= 6) {
                    setText(headerCells[0], t('account.admin.users.table.id'));
                    setText(headerCells[1], t('account.admin.users.table.name'));
                    setText(headerCells[2], t('account.admin.users.table.birthday'));
                    setText(headerCells[3], t('account.admin.users.table.email'));
                    setText(headerCells[4], t('account.admin.users.table.password'));
                    setText(headerCells[5], t('account.admin.users.table.actions'));
                }

                // Placeholder del password opcional
                usersList.querySelectorAll('input[type="password"][id^="u_password_"]').forEach(function(inp){
                    inp.placeholder = '(opcional)';
                });

                // Botones Actualizar/Eliminar
                usersList.querySelectorAll('table.admin-users-table tr td:last-child .button').forEach(function(btn){
                    if (/adminUpdateUser\(/.test(btn.getAttribute('onclick')||'')) {
                        setText(btn, t('account.admin.users.update'));
                    } else if (/adminDeleteUser\(/.test(btn.getAttribute('onclick')||'')) {
                        setText(btn, t('account.admin.users.delete'));
                    }
                });

                // Mensajes vacíos/cargando
                const txt = usersList.textContent.trim();
                if (txt === '' || /Cargando usuarios\.|Loading users\./i.test(txt)) {
                    setText(usersList, t('account.admin.users.loading'));
                } else if (/No hay usuarios|No users/i.test(txt)) {
                    setText(usersList, t('account.admin.users.empty'));
                }
            }
        }
        if (adminCards.length >= 2) {
            const gamesCard = adminCards[1];
            setText(gamesCard.querySelector('h3'), t('account.admin.games.h3'));
            const gamesList = document.getElementById('admin-games-list');
            if (gamesList) {
                const txt = gamesList.textContent.trim();
                if (txt === '' || /Error de red|Network error|Cargando partidas|Loading games/i.test(txt)) {
                    setText(gamesList, t('account.admin.games.loading'));
                } else if (/No hay partidas|No games/i.test(txt)) {
                    setText(gamesList, t('account.admin.games.empty'));
                }

                // Items y botones de lista
                gamesList.querySelectorAll('li').forEach(function(li){
                    const match = li.textContent.match(/#(\d+)/);
                    const id = match ? match[1] : '';
                    if (id) {
                        const btn = li.querySelector('button.button');
                        if (btn && /adminDeleteGame\(/.test(btn.getAttribute('onclick')||'')) {
                            setText(btn, t('account.admin.games.delete'));
                        }
                        li.childNodes.forEach(function(node){
                            if (node.nodeType === Node.TEXT_NODE) {
                                node.textContent = t('account.admin.games.item', { id });
                            }
                        });
                    }
                });
            }
        }
        const adminLogout = document.querySelector('#account .admin-logout');
        setText(adminLogout, t('account.admin.logout'));
    }

    // Registration/Login (logged out)
    const registration = document.querySelector('#account .registration');
    if (registration) {
        setText(registration.querySelector('h2'), t('account.register.h2'));
        const regNameLabel = registration.querySelector('label[for="name"]');
        const regBirthLabel = registration.querySelector('label[for="birthday"]');
        const regEmailLabel = registration.querySelector('label[for="email"]');
        const regPassLabel = registration.querySelector('label[for="password"]');
        if (regNameLabel) regNameLabel.innerHTML = t('account.register.name.labelHtml');
        if (regBirthLabel) regBirthLabel.innerHTML = t('account.register.birthday.labelHtml');
        if (regEmailLabel) regEmailLabel.innerHTML = t('account.register.email.labelHtml');
        if (regPassLabel) regPassLabel.innerHTML = t('account.register.password.labelHtml');
        const regSubmit = registration.querySelector('button.button[type="submit"], .registration .button');
        setText(regSubmit, t('account.register.submit'));
    }
    const login = document.querySelector('#account .login');
    if (login) {
        setText(login.querySelector('h2'), t('account.login.h2'));
        setText(login.querySelector('label[for="email"]'), t('account.login.email.label'));
        setText(login.querySelector('label[for="password"]'), t('account.login.password.label'));
        const loginSubmit = login.querySelector('button.button[type="submit"], .login .button');
        setText(loginSubmit, t('account.login.submit'));
    }
}

function changeLanguage() {
    let current = 'es';
    try { current = localStorage.getItem('lang') || 'es'; } catch (e) {}
    const next = current === 'es' ? 'en' : 'es';
    applyLanguage(next);
}

// Expose to window (optional safety)
window.i18n = i18n;
window.t = t;
window.applyLanguage = applyLanguage;
window.changeLanguage = changeLanguage;
window.setText = setText;
window.setHTML = setHTML;


// Aplicar idioma guardado en cualquier página y habilitar toggle por icono
document.addEventListener('DOMContentLoaded', function(){
    try {
        var savedLang = localStorage.getItem('lang') || 'es';
        applyLanguage(savedLang);
    } catch (e) {}
    try {
        var langEls = document.querySelectorAll('.language');
        langEls.forEach(function(el){ el.onclick = changeLanguage; });
    } catch (e) {}
});


