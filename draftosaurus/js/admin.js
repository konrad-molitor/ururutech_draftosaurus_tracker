// Función para encriptar el formulario
function encForm(dataObj) {
    return Object.entries(dataObj).map(function(kv){return encodeURIComponent(kv[0]) + '=' + encodeURIComponent(kv[1]);}).join('&');
}

// Función para cargar la lista de usuarios
function adminLoadUsers() {
    var container = document.getElementById('admin-users-list');
    if (!container) return;
    fetch('../back/admin_list_users.php', { credentials: 'same-origin' })
        .then(function(r){ return r.json(); })
        .then(function(j){
            if (!j.success) { container.textContent = j.message || 'Error'; return; }
            if (!Array.isArray(j.users) || j.users.length === 0) { container.textContent = 'No hay usuarios'; return; }
            var html = ''+
                '<div class="admin-users-controls">'+
                    '<input id="admin-user-search" class="admin-user-search" type="text" placeholder="Buscar por nombre o email">'+
                '</div>'+
                '<table class="admin-users-table" style="width:100%; text-align:left; border-collapse:collapse;">'+
                '<tr><th class="col-id">ID</th><th>Nombre</th><th>Nacimiento</th><th>Email</th><th>Password</th><th>Acciones</th></tr>';
            j.users.forEach(function(u){
                html += '<tr>'+
                    '<td class="col-id">'+u.id+'</td>'+
                    '<td><input type="text" id="u_name_'+u.id+'" value="'+(u.name||'')+'"></td>'+
                    '<td><input type="date" id="u_birthday_'+u.id+'" value="'+(u.birthday||'')+'"></td>'+
                    '<td><input type="email" id="u_email_'+u.id+'" value="'+(u.email||'')+'"></td>'+
                    '<td><input type="password" id="u_password_'+u.id+'" placeholder="(opcional)"></td>'+
                    '<td>'+
                    '<button class="button" onclick="adminUpdateUser('+u.id+')">Actualizar</button> '+
                    '<button class="button" onclick="adminDeleteUser('+u.id+')">Eliminar</button>'+
                    '</td>'+
                '</tr>';
            });
            html += '</table>';
            container.innerHTML = html;
            var si = document.getElementById('admin-user-search');
            if (si) { si.addEventListener('input', filterAdminUsersList); }
        })
        .catch(function(){ container.textContent = 'Error de red'; });
}

// Función para filtrar la lista de usuarios
function filterAdminUsersList() {
    var search = document.getElementById('admin-user-search');
    if (!search) return;
    var q = (search.value || '').toLowerCase().trim();
    var rows = document.querySelectorAll('.admin-users-table tr');
    rows.forEach(function(row, idx){
        if (idx === 0) { return; }
        var cells = row.querySelectorAll('td');
        if (!cells || cells.length < 4) { row.style.display = ''; return; }
        var nameVal = (cells[1].querySelector('input') ? cells[1].querySelector('input').value : cells[1].textContent).toLowerCase();
        var emailVal = (cells[3].querySelector('input') ? cells[3].querySelector('input').value : cells[3].textContent).toLowerCase();
        var match = q === '' || nameVal.indexOf(q) !== -1 || emailVal.indexOf(q) !== -1;
        row.style.display = match ? '' : 'none';
    });
}

// Función para crear un usuario
function adminCreateUser() {
    var f = document.getElementById('admin-create-user');
    if (!f) return;
    var data = {
        name: f.name.value,
        birthday: f.birthday.value,
        email: f.email.value,
        password: f.password.value
    };
    fetch('../back/admin_create_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: encForm(data),
        credentials: 'same-origin'
    }).then(function(r){ return r.json(); })
      .then(function(j){ if (!j.success) { alert(j.message||'Error'); } adminLoadUsers(); f.reset(); });
}

// Función para actualizar un usuario
function adminUpdateUser(id) {
    var data = {
        id: id,
        name: document.getElementById('u_name_'+id).value,
        birthday: document.getElementById('u_birthday_'+id).value,
        email: document.getElementById('u_email_'+id).value,
        password: document.getElementById('u_password_'+id).value
    };
    fetch('../back/admin_update_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: encForm(data),
        credentials: 'same-origin'
    }).then(function(r){ return r.json(); })
      .then(function(j){ if (!j.success) { alert(j.message||'Error'); } else { alert('Actualizado'); } adminLoadUsers(); });
}

// Función para eliminar un usuario
function adminDeleteUser(id) {
    if (!confirm('¿Eliminar usuario #' + id + '?')) return;
    fetch('../back/admin_delete_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: encForm({ id: id }),
        credentials: 'same-origin'
    }).then(function(r){ return r.json(); })
      .then(function(j){ if (!j.success) { alert(j.message||'Error'); } adminLoadUsers(); });
}

// Función para cargar la lista de partidas
function adminLoadGames() {
    var container = document.getElementById('admin-games-list');
    if (!container) return;
    fetch('../back/admin_list_games.php', { credentials: 'same-origin' })
        .then(function(r){ return r.json(); })
        .then(function(j){
            if (!j.success) { container.textContent = j.message || 'Error'; return; }
            if (!Array.isArray(j.games) || j.games.length === 0) { container.textContent = 'No hay partidas'; return; }
            var html = '<ul style="list-style:none; padding-left:0;">';
            j.games.forEach(function(g){
                html += '<li style="margin-bottom:6px;">Partida #'+g.id+' '+
                    '<button class="button" onclick="adminDeleteGame('+g.id+')">Eliminar</button></li>';
            });
            html += '</ul>';
            container.innerHTML = html;
        })
        .catch(function(){ container.textContent = 'Error de red'; });
}

// Función para eliminar una partida
function adminDeleteGame(id) {
    if (!confirm('¿Eliminar partida #' + id + '?')) return;
    fetch('../back/admin_delete_game.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: encForm({ id: id }),
        credentials: 'same-origin'
    }).then(function(r){ return r.json(); })
      .then(function(j){ if (!j.success) { alert(j.message||'Error'); } adminLoadGames(); });
}

// Función para cargar los bloques de admin
document.addEventListener('DOMContentLoaded', function(){
    // Solo cargar si hay bloques de admin
    if (document.getElementById('admin-users-list')) {
        adminLoadUsers();
    }
    if (document.getElementById('admin-games-list')) {
        adminLoadGames();
    }
});


