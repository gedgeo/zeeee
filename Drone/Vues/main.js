$(document).ready(initApp);

function initApp() {
    loadUserTable();
}

function loadUserTable() {
    $.ajax({
        url: '../Controleurs/controleur_utilisateur.php',
        method: 'GET',
        data: { action: 'getUsers' },
        dataType: 'json',
        success:
                function(donnees){
                 renderUserTable(donnees);
                },
                
        error: function (jqXHR, textStatus, errorThrown) {
            showAjaxError(jqXHR, textStatus, errorThrown)
        }
                
                
    });
}

function renderUserTable(users) {
    const $container = $('#user-table-container');
    $container.empty();

    if (!Array.isArray(users) || users.length === 0) {
        $container.html("<div class='alert alert-info'>Aucun utilisateur trouvé.</div>");
        return;
    }

    const $table = $('<table>').addClass('table table-bordered');
    const $thead = $(`
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Classe</th>
                <th>Actions</th>
            </tr>
        </thead>
    `);
    const $tbody = $('<tbody>');

    users.forEach(user => {
        const $row = $(`
            <tr>
                <td>${user.id_utilisateur}</td>
                <td>${escapeHtml(user.nom)}</td>
                <td>${escapeHtml(user.prenom)}</td>
                <td>${escapeHtml(user.nom_classe || 'Non assignée')}</td>
                <td>
                    <a href="modifier.php?id=${user.id_utilisateur}" class="btn btn-warning">Modifier</a>
                    <a href="supp.php?id=${user.id_utilisateur}" class="btn btn-danger">Supprimer</a>
                </td>
            </tr>
        `);
        $tbody.append($row);
    });

    $table.append($thead, $tbody);
    $container.append($table);
}

function showAjaxError(xhr, status, error) {
    $('#user-table-container').html(`<div class='alert alert-danger'>Erreur AJAX : ${error}</div>`);
}

function escapeHtml(str) {
    return $('<div>').text(str).html();
}
