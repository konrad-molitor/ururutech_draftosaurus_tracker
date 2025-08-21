
// cambiar la pantalla
function showScreen(screenId) {
  console.log('Switching to screen:', screenId); //Debug
  document.querySelectorAll('.screen').forEach(screen => {
    screen.classList.remove('active');
    console.log('Removed active from:', screen.id); // Debug
  });
  document.getElementById(screenId).classList.add('active');
  console.log('Added active to:', screenId); // Debug
}


//selección de jugadores
let numPlayers = 0;
let mode = "";

function setPlayers(n) {
    numPlayers = n;
    document.querySelector('.mode-selection').style.display = 'block';
}

//selección de modo del juego (verano)
function selectMode(selectedMode) {
    mode = selectedMode;
    showScreen('board');
}

// drag & drop handlers
let draggedElement = null;

function dragstartHandler(ev) {
    draggedElement = ev.target;
    ev.dataTransfer.setData("text/plain", ev.target.id);
    ev.dataTransfer.dropEffect = "move";
}

function dragoverHandler(ev) {
    ev.preventDefault();
    ev.dataTransfer.dropEffect = "move";
}

// Функция для получения типа динозавра / Función para obtener el tipo de dinosaurio
function getDinoType(element) {
    if (element.classList.contains('tRex')) return 'tRex';
    if (element.classList.contains('stegosaurus')) return 'stegosaurus';
    if (element.classList.contains('brontosaurus')) return 'brontosaurus';
    if (element.classList.contains('triceratops')) return 'triceratops';
    if (element.classList.contains('iguanodon')) return 'iguanodon';
    if (element.classList.contains('spinosaurus')) return 'spinosaurus';
    return null;
}

// Функция проверки правил для field-equality / Función de validación de reglas para field-equality
function validateEquality(dropZone, newDinoType) {
    const existingDinos = dropZone.querySelectorAll('.dino');
    
    // Проверяем лимит в 6 динозавров / Verificamos el límite de 6 dinosaurios
    if (existingDinos.length >= 6) {
        alert('En el área de Igualdad no se pueden colocar más de 6 dinosaurios');
        return false;
    }
    
    // Если есть динозавры, проверяем что новый того же типа / Si hay dinosaurios, verificamos que el nuevo sea del mismo tipo
    if (existingDinos.length > 0) {
        const firstDinoType = getDinoType(existingDinos[0]);
        if (firstDinoType !== newDinoType) {
            alert('En el área de Igualdad solo se pueden colocar dinosaurios del mismo tipo');
            return false;
        }
    }
    
    return true;
}

// Функция проверки правил для field-three / Función de validación de reglas para field-three
function validateThree(dropZone) {
    const existingDinos = dropZone.querySelectorAll('.dino');
    
    if (existingDinos.length >= 3) {
        alert('En el área de Tres no se pueden colocar más de 3 dinosaurios');
        return false;
    }
    
    return true;
}

// Функция проверки правил для field-love / Función de validación de reglas para field-love
function validateLove(dropZone) {
    const existingDinos = dropZone.querySelectorAll('.dino');
    
    if (existingDinos.length >= 6) {
        alert('En el área del Amor no se pueden colocar más de 6 dinosaurios');
        return false;
    }
    
    return true;
}

// Функция проверки правил для field-king / Función de validación de reglas для field-king
function validateKing(dropZone) {
    const existingDinos = dropZone.querySelectorAll('.dino');
    
    if (existingDinos.length >= 1) {
        alert('En el área del Rey solo se puede colocar 1 dinosaurio');
        return false;
    }
    
    return true;
}

// Функция проверки правил для field-diversity / Función de validación de reglas para field-diversity
function validateDiversity(dropZone, newDinoType) {
    const existingDinos = dropZone.querySelectorAll('.dino');
    
    if (existingDinos.length >= 6) {
        alert('En el área de la Diversidad no se pueden colocar más de 6 dinosaurios');
        return false;
    }
    
    // Проверяем, что новый динозавр не повторяется / Verificamos que el nuevo dinosaurio no se repita
    for (let dino of existingDinos) {
        const existingType = getDinoType(dino);
        if (existingType === newDinoType) {
            alert('En el área de la Diversidad no se pueden colocar dinosaurios del mismo tipo');
            return false;
        }
    }
    
    return true;
}

// Функция проверки правил для field-one / Función de validación de reglas para field-one
function validateOne(dropZone) {
    const existingDinos = dropZone.querySelectorAll('.dino');
    
    if (existingDinos.length >= 1) {
        alert('En el área de Uno solo se puede colocar 1 dinosaurio');
        return false;
    }
    
    return true;
}

// Функция для подсчета общего количества динозавров на поле / Función para contar el número total de dinosaurios en el campo
function getTotalDinosOnField() {
    const allZones = [
        '.field-equality',
        '.field-three', 
        '.field-love',
        '.field-king',
        '.field-diversity',
        '.field-one',
        '.table-center' // река / río
    ];
    
    let totalDinos = 0;
    for (const zoneSelector of allZones) {
        const zone = document.querySelector(zoneSelector);
        const dinosInZone = zone.querySelectorAll('.dino').length;
        totalDinos += dinosInZone;
    }
    
    return totalDinos;
}

// Общая функция валидации / Función general de validación
function validateDrop(dropZone, draggedElement) {
    const dinoType = getDinoType(draggedElement);
    
    if (!dinoType) {
        alert('Error: No se pudo identificar el tipo de dinosaurio');
        return false;
    }
    
    // Проверяем общее ограничение на количество динозавров (только при размещении из панели) / Verificamos limitación general de dinosaurios (solo al colocar desde panel)
    const isFromPanel = draggedElement.closest('.dinosaurs-panel');
    if (isFromPanel) {
        const currentTotal = getTotalDinosOnField();
        if (currentTotal >= 12) {
            alert('No se pueden colocar más de 12 dinosaurios en el parque');
            return false;
        }
    }
    
    // Проверяем правила в зависимости от поля / Verificamos reglas según el campo
    if (dropZone.classList.contains('field-equality')) {
        return validateEquality(dropZone, dinoType);
    } else if (dropZone.classList.contains('field-three')) {
        return validateThree(dropZone);
    } else if (dropZone.classList.contains('field-love')) {
        return validateLove(dropZone);
    } else if (dropZone.classList.contains('field-king')) {
        return validateKing(dropZone);
    } else if (dropZone.classList.contains('field-diversity')) {
        return validateDiversity(dropZone, dinoType);
    } else if (dropZone.classList.contains('field-one')) {
        return validateOne(dropZone);
    }
    return true;
}

function dropHandler(ev) {
    ev.preventDefault();
    
    if (draggedElement) {
        const dropZone = ev.target.closest('[ondrop]');
        if (dropZone && dropZone.id !== 'dinosaurs-panel') {
            
            // Валидируем размещение согласно правилам игры / Validamos la colocación según las reglas del juego
            if (!validateDrop(dropZone, draggedElement)) {
                draggedElement = null;
                return;
            }
            
            const isFromPanel = draggedElement.closest('.dinosaurs-panel');
            
            if (isFromPanel) {
                const dinoCopy = draggedElement.cloneNode(true);
                
                dinoCopy.setAttribute('draggable', 'true');
                dinoCopy.setAttribute('ondragstart', 'drag(event)');
                dinoCopy.classList.add('placed-dino');
                
                dropZone.appendChild(dinoCopy);
                
                draggedElement.style.position = '';
                draggedElement.style.left = '';
                draggedElement.style.top = '';
                draggedElement.style.transform = '';
                
            } else {
                // При перемещении между полями также проверяем правила / Al mover entre campos también verificamos reglas
                // Временно удаляем элемент для корректной проверки / Temporalmente removemos el elemento para verificación correcta
                const currentParent = draggedElement.parentNode;
                draggedElement.remove();
                
                if (validateDrop(dropZone, draggedElement)) {
                    dropZone.appendChild(draggedElement);
                } else {
                    // Возвращаем элемент обратно / Devolvemos el elemento de vuelta
                    currentParent.appendChild(draggedElement);
                    draggedElement = null;
                    return;
                }
            }
            
            const placedElement = dropZone.lastElementChild;
            placedElement.style.position = '';
            placedElement.style.left = '';
            placedElement.style.top = '';
            placedElement.style.transform = '';
            placedElement.style.margin = '';
            placedElement.style.width = '';
            placedElement.style.height = '';
            placedElement.style.lineHeight = '';
        }
    }
    
    draggedElement = null;
}

function removeDinoFromField(dino) {
    if (dino.classList.contains('placed-dino')) {
        dino.remove();
    } else {
        const panel = document.querySelector('.dinosaurs-panel');
        panel.appendChild(dino);
        
        dino.style.position = '';
        dino.style.left = '';
        dino.style.top = '';
        dino.style.transform = '';
        dino.style.margin = '';
        dino.style.width = '';
        dino.style.height = '';
        dino.style.lineHeight = '';
    }
}

function allowDrop(ev) {
    return dragoverHandler(ev);
}

function drag(ev) {
    return dragstartHandler(ev);
}

function drop(ev) {
    return dropHandler(ev);
}

// Функции подсчета очков / Funciones de cálculo de puntos

// Подсчет очков для field-equality / Cálculo de puntos para field-equality
function calculateEqualityPoints() {
    const equalityZone = document.querySelector('.field-equality');
    const dinosInZone = equalityZone.querySelectorAll('.dino').length;
    
    const pointsTable = {
        0: 0,
        1: 2,
        2: 4,
        3: 8,
        4: 12,
        5: 18,
        6: 24
    };
    
    return pointsTable[dinosInZone] || 0;
}

// Подсчет очков для field-three / Cálculo de puntos para field-three
function calculateThreePoints() {
    const threeZone = document.querySelector('.field-three');
    const dinosInZone = threeZone.querySelectorAll('.dino').length;
    
    // Если ровно 3 динозавра - 7 очков, иначе 0 очков / Si exactamente 3 dinosaurios - 7 puntos, sino 0 puntos
    if (dinosInZone === 3) {
        return 7;
    } else {
        return 0;
    }
}

// Подсчет очков для field-love / Cálculo de puntos para field-love
function calculateLovePoints() {
    const loveZone = document.querySelector('.field-love');
    const dinosInZone = loveZone.querySelectorAll('.dino');
    
    // Подсчитываем количество динозавров каждого типа / Contamos la cantidad de dinosaurios de cada tipo
    const dinoTypes = {};
    dinosInZone.forEach(dino => {
        const type = getDinoType(dino);
        if (type) {
            dinoTypes[type] = (dinoTypes[type] || 0) + 1;
        }
    });
    
    // Подсчитываем пары и очки / Contamos las parejas y los puntos
    let totalPoints = 0;
    for (const type in dinoTypes) {
        const count = dinoTypes[type];
        const pairs = Math.floor(count / 2); // Количество пар (округляем вниз) / Número de parejas (redondeamos hacia abajo)
        totalPoints += pairs * 5; // 5 очков за каждую пару / 5 puntos por cada pareja
    }
    
    return totalPoints;
}

// Подсчет очков для field-king (зона Rey) / Cálculo de puntos para field-king (zona Rey)
function calculateKingPoints() {
    const kingZone = document.querySelector('.field-king');
    const dinosInZone = kingZone.querySelectorAll('.dino');
    
    // Если нет динозавра в зоне - 0 очков / Si no hay dinosaurio en la zona - 0 puntos
    if (dinosInZone.length === 0) {
        return 0;
    }
    
    // Должен быть только один динозавр / Debe haber solo un dinosaurio
    if (dinosInZone.length !== 1) {
        return 0;
    }
    
    const dinoInKing = dinosInZone[0];
    const dinoType = getDinoType(dinoInKing);
    
    if (!dinoType) {
        return 0;
    }
    
    // Подсчитываем общее количество динозавров этого типа в парке игрока / Contamos el total de dinosaurios de este tipo en el parque del jugador
    const allZones = [
        '.field-equality',
        '.field-three', 
        '.field-love',
        '.field-king',
        '.field-diversity',
        '.field-one',
        '.table-center' // река / río
    ];
    
    let totalDinosOfType = 0;
    for (const zoneSelector of allZones) {
        const zone = document.querySelector(zoneSelector);
        const dinosInZone = zone.querySelectorAll('.dino');
        
        for (const dino of dinosInZone) {
            const currentDinoType = getDinoType(dino);
            if (currentDinoType === dinoType) {
                totalDinosOfType++;
            }
        }
    }
    
    // Получаем название динозавра на испанском / Obtenemos el nombre del dinosaurio en español
    const dinoNameSpanish = getDinoNameInSpanish(dinoType);
    
    // Задаем вопрос игроку / Hacemos una pregunta al jugador
    const question = `Tienes ${totalDinosOfType} ${dinoNameSpanish}. ¿Otros jugadores tienen menos? Y/N`;
    const answer = prompt(question);
    
    // Обрабатываем ответ / Procesamos la respuesta
    if (answer && (answer.toUpperCase() === 'Y' || answer.toUpperCase() === 'YES' || answer.toUpperCase() === 'SÍ' || answer.toUpperCase() === 'SI')) {
        return 7;
    } else {
        return 0;
    }
}

// Подсчет очков для field-diversity / Cálculo de puntos para field-diversity
function calculateDiversityPoints() {
    const diversityZone = document.querySelector('.field-diversity');
    const dinosInZone = diversityZone.querySelectorAll('.dino').length;
    
    const pointsTable = {
        0: 0,
        1: 1,
        2: 3,
        3: 6,
        4: 10,
        5: 15,
        6: 21
    };
    
    return pointsTable[dinosInZone] || 0;
}

// Функция для получения названия динозавра на испанском / Función para obtener el nombre del dinosaurio en español
function getDinoNameInSpanish(dinoType) {
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

// Подсчет очков для field-one / Cálculo de puntos para field-one
function calculateOnePoints() {
    const oneZone = document.querySelector('.field-one');
    const dinosInZone = oneZone.querySelectorAll('.dino');
    
    // Если нет динозавра в зоне - 0 очков / Si no hay dinosaurio en la zona - 0 puntos
    if (dinosInZone.length === 0) {
        return 0;
    }
    
    // Должен быть только один динозавр / Debe haber solo un dinosaurio
    if (dinosInZone.length !== 1) {
        return 0;
    }
    
    const dinoInOne = dinosInZone[0];
    const dinoType = getDinoType(dinoInOne);
    
    if (!dinoType) {
        return 0;
    }
    
    // Проверяем все остальные зоны на наличие динозавров того же типа / Verificamos todas las otras zonas para dinosaurios del mismo tipo
    const allZones = [
        '.field-equality',
        '.field-three', 
        '.field-love',
        '.field-king',
        '.field-diversity',
        '.table-center' // река / río
        // field-one не проверяем, так как мы уже знаем что там один динозавр / field-one no se verifica ya que sabemos que hay un dinosaurio
    ];
    
    for (const zoneSelector of allZones) {
        const zone = document.querySelector(zoneSelector);
        const dinosInOtherZone = zone.querySelectorAll('.dino');
        
        for (const dino of dinosInOtherZone) {
            const otherDinoType = getDinoType(dino);
            if (otherDinoType === dinoType) {
                // Найден другой динозавр того же типа - 0 очков / Se encontró otro dinosaurio del mismo tipo - 0 puntos
                return 0;
            }
        }
    }
    
    // Если динозавр единственный представитель своего вида в парке - 7 очков / Si el dinosaurio es el único representante de su especie en el parque - 7 puntos
    return 7;
}

// Подсчет очков для реки / Cálculo de puntos para el río
function calculateRiverPoints() {
    const riverZone = document.querySelector('.table-center');
    const dinosInZone = riverZone.querySelectorAll('.dino').length;
    
    // 1 очко за каждого динозавра в реке / 1 punto por cada dinosaurio en el río
    return dinosInZone;
}

// Подсчет дополнительных очков за Т-Рекса / Cálculo de puntos adicionales por T-Rex
function calculateTRexBonusPoints() {
    const allZones = [
        '.field-equality',
        '.field-three', 
        '.field-love',
        '.field-king',
        '.field-diversity',
        '.field-one',
        '.table-center' // река / río
    ];
    
    let bonusPoints = 0;
    
    for (const zoneSelector of allZones) {
        const zone = document.querySelector(zoneSelector);
        const dinosInZone = zone.querySelectorAll('.dino');
        
        // Проверяем, есть ли хотя бы один Т-Рекс в этой зоне / Verificamos si hay al menos un T-Rex en esta zona
        let hasTRex = false;
        for (const dino of dinosInZone) {
            if (getDinoType(dino) === 'tRex') {
                hasTRex = true;
                break;
            }
        }
        
        // Если в зоне есть хотя бы один Т-Рекс, добавляем 1 очко / Si hay al menos un T-Rex en la zona, agregamos 1 punto
        if (hasTRex) {
            bonusPoints += 1;
        }
    }
    
    return bonusPoints;
}

// Общий подсчет всех очков / Cálculo total de todos los puntos
function calculateTotalScore() {
    const equalityPoints = calculateEqualityPoints();
    const threePoints = calculateThreePoints();
    const lovePoints = calculateLovePoints();
    const kingPoints = calculateKingPoints();
    const diversityPoints = calculateDiversityPoints();
    const onePoints = calculateOnePoints();
    const riverPoints = calculateRiverPoints();
    const trexBonusPoints = calculateTRexBonusPoints();
    
    const totalScore = equalityPoints + threePoints + lovePoints + kingPoints + diversityPoints + onePoints + riverPoints + trexBonusPoints;
    
    // Выводим детальную информацию в консоль для отладки / Mostramos información detallada en la consola para depuración
    console.log('Puntuación detallada:');
    console.log(`Igualdad: ${equalityPoints} puntos`);
    console.log(`Tres: ${threePoints} puntos`);
    console.log(`Amor: ${lovePoints} puntos`);
    console.log(`Rey: ${kingPoints} puntos`);
    console.log(`Diversidad: ${diversityPoints} puntos`);
    console.log(`Uno: ${onePoints} puntos`);
    console.log(`Río: ${riverPoints} puntos`);
    console.log(`Bonus T-Rex: ${trexBonusPoints} puntos`);
    console.log(`TOTAL: ${totalScore} puntos`);
    
    return totalScore;
}

// Функция для завершения игры и подсчета очков / Función para finalizar el juego y calcular puntos
function finishGame() {
    // Проверяем, что на поле ровно 12 динозавров / Verificamos que haya exactamente 12 dinosaurios en el campo
    const totalDinosOnField = getTotalDinosOnField();
    
    if (totalDinosOnField !== 12) {
        alert(`¡Atención! Necesitas colocar exactamente 12 dinosaurios en el parque para finalizar la partida. Actualmente tienes ${totalDinosOnField} dinosaurios.`);
        return; // Не продолжаем, если не 12 динозавров / No continuamos si no hay 12 dinosaurios
    }
    
    const equalityPoints = calculateEqualityPoints();
    const threePoints = calculateThreePoints();
    const lovePoints = calculateLovePoints();
    const kingPoints = calculateKingPoints();
    const diversityPoints = calculateDiversityPoints();
    const onePoints = calculateOnePoints();
    const riverPoints = calculateRiverPoints();
    const trexBonusPoints = calculateTRexBonusPoints();
    const totalScore = equalityPoints + threePoints + lovePoints + kingPoints + diversityPoints + onePoints + riverPoints + trexBonusPoints;
    
    // Создаем детальный отчет / Creamos un informe detallado
    const detailedResults = `
        <h2>Puntuación Final</h2>
        <div style="text-align: left; max-width: 400px; margin: 0 auto;">
            <p><strong>Igualdad:</strong> ${equalityPoints} puntos</p>
            <p><strong>Tres:</strong> ${threePoints} puntos</p>
            <p><strong>Amor:</strong> ${lovePoints} puntos</p>
            <p><strong>Rey:</strong> ${kingPoints} puntos</p>
            <p><strong>Diversidad:</strong> ${diversityPoints} puntos</p>
            <p><strong>Uno:</strong> ${onePoints} puntos</p>
            <p><strong>Río:</strong> ${riverPoints} puntos</p>
            <p><strong>Bonus T-Rex:</strong> ${trexBonusPoints} puntos</p>
            <hr style="margin: 15px 0; border: 1px solid #666;">
            <p style="font-size: 1.2em;"><strong>TOTAL: ${totalScore} puntos</strong></p>
        </div>
    `;
    
    // Обновляем результат в интерфейсе / Actualizamos el resultado en la interfaz
    const resultElement = document.querySelector('.results-section');
    if (resultElement) {
        resultElement.innerHTML = detailedResults;
    }
    showScreen('results');
}

// Carousel functionality
let currentSlideIndex = 0;
const totalSlides = 8;

function showSlide(index) {
    const slides = document.querySelectorAll('.carousel-slide');
    const indicators = document.querySelectorAll('.indicator');
    
    // Скрываем все слайды / Ocultamos todos los slides
    slides.forEach(slide => slide.classList.remove('active'));
    indicators.forEach(indicator => indicator.classList.remove('active'));
    
    // Показываем нужный слайд / Mostramos el slide necesario
    if (slides[index]) {
        slides[index].classList.add('active');
        indicators[index].classList.add('active');
    }
    
    // Обновляем счетчик страниц / Actualizamos el contador de páginas
    const currentPageElement = document.getElementById('current-page');
    if (currentPageElement) {
        currentPageElement.textContent = index + 1;
    }
}

function changeSlide(direction) {
    currentSlideIndex += direction;
    
    // Цикличная прокрутка / Desplazamiento cíclico
    if (currentSlideIndex >= totalSlides) {
        currentSlideIndex = 0;
    } else if (currentSlideIndex < 0) {
        currentSlideIndex = totalSlides - 1;
    }
    
    showSlide(currentSlideIndex);
}

function currentSlide(index) {
    currentSlideIndex = index - 1; // Индекс начинается с 0 / El índice comienza en 0
    showSlide(currentSlideIndex);
}

// Добавляем поддержку клавиатуры для карусели / Agregamos soporte de teclado para el carrusel
function handleCarouselKeyboard(event) {
    // Проверяем, активен ли экран с правилами / Verificamos si está activa la pantalla de reglas
    const rulesScreen = document.getElementById('rules');
    if (!rulesScreen.classList.contains('active')) {
        return;
    }
    
    if (event.key === 'ArrowLeft') {
        changeSlide(-1);
    } else if (event.key === 'ArrowRight') {
        changeSlide(1);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Content Loaded'); // Отладка / Debug
    
    // Проверяем состояние всех секций при загрузке / Verificamos el estado de todas las secciones al cargar
    document.querySelectorAll('.screen').forEach(screen => {
        const isActive = screen.classList.contains('active');
        const computedStyle = window.getComputedStyle(screen);
        console.log(`Screen ${screen.id}: active=${isActive}, display=${computedStyle.display}`);
    });
    
    showScreen('home');
    
    // Инициализация карусели / Inicialización del carrusel
    const totalPagesElement = document.getElementById('total-pages');
    if (totalPagesElement) {
        totalPagesElement.textContent = totalSlides;
    }
    
    // Добавляем обработчики событий / Agregamos manejadores de eventos
    document.addEventListener('dblclick', (ev) => {
        if (ev.target.classList.contains('dino')) {
            const parentZone = ev.target.closest('[ondrop]');
            if (parentZone && parentZone.id !== 'dinosaurs-panel') {
                removeDinoFromField(ev.target);
            }
        }
    });
    
    // Добавляем поддержку клавиатуры / Agregamos soporte de teclado
    document.addEventListener('keydown', handleCarouselKeyboard);
    
    // Настраиваем обработчик для email input / Configuramos manejador para email input
    setupEmailInputHandler();
});

// Новые функции для управления игроками / Nuevas funciones para gestión de jugadores

// Массив для хранения добавленных игроков / Array para almacenar jugadores añadidos
let gamePlayers = [];

// Функция для добавления игрока / Función para añadir jugador
async function addPlayer() {
    const emailInput = document.getElementById('player-email');
    const email = emailInput.value.trim();
    
    // Валидация email / Validación de email
    if (!email) {
        alert('Por favor, ingrese un email');
        return;
    }
    
    if (!isValidEmail(email)) {
        alert('Por favor, ingrese un email válido');
        return;
    }
    
    // Проверяем, не добавлен ли уже этот игрок / Verificamos si el jugador ya está añadido
    if (gamePlayers.some(player => player.email === email)) {
        alert('Este jugador ya está añadido a la partida');
        return;
    }
    
    // Проверяем лимит на количество игроков / Verificamos el límite de jugadores
    if (gamePlayers.length >= 5) {
        alert('No se pueden añadir más de 5 jugadores');
        return;
    }
    
    try {
        // Проверяем существование пользователя в базе данных / Verificamos la existencia del usuario en la base de datos
        const response = await fetch('../back/check_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `email=${encodeURIComponent(email)}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Добавляем игрока в массив / Añadimos el jugador al array
            gamePlayers.push({
                name: data.user.name,
                email: data.user.email,
                id: data.user.id,
            });
            
            // Очищаем поле ввода / Limpiamos el campo de entrada
            emailInput.value = '';
            
            // Обновляем интерфейс / Actualizamos la interfaz
            updatePlayersDisplay();
            
        } else {
            alert(data.message || 'Usuario no encontrado. El jugador debe estar registrado en el sistema.');
        }
        
    } catch (error) {
        console.error('Error al verificar usuario:', error);
        alert('Error al verificar el usuario. Por favor, intente nuevamente.');
    }
}

// Функция для удаления игрока / Función para eliminar jugador
function removePlayer(email) {
    const index = gamePlayers.findIndex(player => player.email === email);
    if (index > -1) {
        gamePlayers.splice(index, 1);
        updatePlayersDisplay();
    }
}

// Функция для обновления отображения списка игроков / Función para actualizar visualización de lista de jugadores
function updatePlayersDisplay() {
    const playersContainer = document.getElementById('players-container');
    const playerCount = document.getElementById('player-count');
    const modeSelection = document.getElementById('new-game-mode-selection');
    
    // Обновляем счетчик игроков / Actualizamos el contador de jugadores
    playerCount.textContent = `Jugadores añadidos: ${gamePlayers.length}/5`;
    
    // Очищаем контейнер / Limpiamos el contenedor
    playersContainer.innerHTML = '';
    
    if (gamePlayers.length === 0) {
        playersContainer.innerHTML = '<div style="text-align: center; color: #999; padding: 20px;">No hay jugadores añadidos</div>';
        modeSelection.style.display = 'none';
    } else {
        // Добавляем каждого игрока в список / Añadimos cada jugador a la lista
        gamePlayers.forEach(player => {
            const playerItem = document.createElement('div');
            playerItem.className = 'player-item';
            playerItem.innerHTML = `
                <span class="player-email">${player.name} (${player.email})</span>
                <button class="remove-player-btn" onclick="removePlayer('${player.email}')">Eliminar</button>
            `;
            playersContainer.appendChild(playerItem);
        });
        
        // Показываем выбор режима, если достаточно игроков / Mostramos selección de modo si hay suficientes jugadores
        if (gamePlayers.length >= 2) {
            modeSelection.style.display = 'block';
        } else {
            modeSelection.style.display = 'none';
        }
    }
}

// Функция валидации email / Función de validación de email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Функция для выбора режима игры / Función para selección de modo de juego
function selectGameMode(selectedMode) {
    if (gamePlayers.length < 2) {
        alert('Necesitas al menos 2 jugadores para comenzar la partida');
        return;
    }
    
    if (gamePlayers.length > 5) {
        alert('No puedes tener más de 5 jugadores');
        return;
    }

    // собираем query-параметры jugadores=1,2,3... и modo=verano|invierno
    // переадресуем на front/game.php?query
    const jugadoresList = gamePlayers.map((jugador) => jugador.id).join(',');
    const params = new URLSearchParams({ jugadores: jugadoresList, modo: selectedMode });
    // Используем относительный путь от текущей страницы (front/index.php) к front/game.php
    window.location.href = `game.php?${params.toString()}`;
}

// Функция для сброса данных новой игры / Función para resetear datos de nueva partida
function resetNewGameData() {
    gamePlayers = [];
    const emailInput = document.getElementById('player-email');
    if (emailInput) {
        emailInput.value = '';
    }
    updatePlayersDisplay();
}

// Функция для добавления обработчика Enter в поле email / Función para agregar manejador Enter en campo email
function setupEmailInputHandler() {
    const emailInput = document.getElementById('player-email');
    if (emailInput) {
        emailInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                addPlayer();
            }
        });
    }
}

// Модифицируем функцию showScreen для сброса данных / Modificamos función showScreen para resetear datos
function showScreenWithGameManagement(screenId) {
    // Если переходим из new-game в другой экран, сбрасываем данные / Si salimos de new-game, reseteamos datos
    const currentScreen = document.querySelector('.screen.active');
    if (currentScreen && currentScreen.id === 'new-game' && screenId !== 'new-game') {
        const shouldReset = confirm('¿Estás seguro de que quieres salir? Se perderá la configuración de la partida.');
        if (shouldReset) {
            resetNewGameData();
        } else {
            return; // No переходим, если пользователь отменил / No cambiamos si el usuario canceló
        }
    }
    
    // Если переходим в new-game, сбрасываем данные / Si entramos a new-game, reseteamos datos
    if (screenId === 'new-game') {
        setTimeout(() => {
            resetNewGameData();
            setupEmailInputHandler();
        }, 100);
    }
    
    // Вызываем оригинальную логику переключения экранов / Llamamos lógica original de cambio de pantallas
    console.log('Switching to screen:', screenId); // Debug
    document.querySelectorAll('.screen').forEach(screen => {
        screen.classList.remove('active');
        console.log('Removed active from:', screen.id); // Debug
    });
    document.getElementById(screenId).classList.add('active');
    console.log('Added active to:', screenId); // Debug
}

// Переопределяем глобальную функцию / Redefinimos función global
showScreen = showScreenWithGameManagement;

