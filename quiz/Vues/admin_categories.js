function chargerTableau() {
    var urlComplete = window.location.href;
    var basePath = urlComplete.substring(0, urlComplete.lastIndexOf("/") + 1);
    var urlJsonFr = basePath + "/libs/datatables/fr-FR.json";
    $.getJSON(
            '../Controleurs/controleur.php',
            {action: 'getCategories'}
    )
            .done(function (donnees, stat, xhr) {
                // Initialisation de DataTable avec Bootstrap 5
                $('#table_categorie').DataTable({
                    data: donnees,
                    columns: [
                        {
                            title: "id",
                            name: "id"

                        },
                        {title: "Catégories",
                            name: "nom"
                        },                       
                        {title: "Action &nbsp;<span class=\"text-success ms-3\" id=\"ajouter\" style=\"cursor: pointer;\">&#43;</span>"}
                    ],
                    columnDefs: [
                        {
                            targets: 0, // Masquer la première colonne (id)
                            visible: false,
                            searchable: false
                        },
                        {
                                target : 2,
                                orderable:false
                            }
                    ],
                    paging: true, // Activer la pagination
                    searching: true, // Activer la recherche
                    ordering: true, // Activer le tri
                    language: {
                        url: urlJsonFr // Traduction en français
                    }
                });
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}

function ajouterCategorie()
{
    var nom = $("#nomAdd").val();
    var errorContainer = $("#addCategorieError");
    // Réinitialiser le message d'erreur
    errorContainer.addClass("d-none");
    if (nom !== "" )
    {
        $.getJSON(
                '../Controleurs/controleur.php',
                {
                    action: 'addCategorie',
                    nom: nom
                }
        )
                .done(function (donnees, stat, xhr) {
                    var id = donnees;   // id de l'entree dans la bdd
                    if (id != -1)
                    {
                        // ajouter la ligne au datatable
                        var table = $('#table_categorie').DataTable();
                        table.row.add([id, nom,
                            '<span class="text-primary mod">&#9998;</span>' +
                                    '<span class="text-danger ms-5 supp">&#128465;</span>'
                        ]).draw(false);

                        // Fermer la modal
                        $("#addCategorieModal").modal('hide');
                        // Réinitialiser le formulaire
                        $("#addCategorieForm")[0].reset();
                    } else {
                        // Afficher le message d'erreur
                        errorContainer.removeClass("d-none");
                        errorContainer.text("La somme des pondérations est incorrecte. Veuillez vérifier les valeurs.");
                    }


                })
                .fail(function (xhr, text, error) {
                    console.log("param : " + JSON.stringify(xhr));
                    console.log("status : " + text);
                    console.log("error : " + error);
                });
    }

}

function modifierCategorie()
{
    var nom = $("#nomMod").val();
    // Récupérer l'ID de la première colonne (index 0)
    var id = $("#idCategorieMod").val();
    var errorContainer = $("#modCategorieError");
    // Réinitialiser le message d'erreur
    errorContainer.addClass("d-none");
    if (nom !== "" && id !== "")
    {
        $.getJSON(
                '../Controleurs/controleur.php',
                {
                    action: 'updateCategorie',
                    nom: nom,
                    id: id
                }
        )
                .done(function (donnees, stat, xhr) {
                    if (donnees != -1) {
                        // Récupérer le DataTable
                        var table = $('#table_categorie').DataTable();

                        // modifier directement la colonne 1 et 2 pour la ligne avec l'ID
                        var row = table.row(function (idx, data, node) {
                            return data[0] == id; // Trouver la ligne où l'ID correspond
                        });
                        if (row.length) {
                            // Récupérer les données actuelles de la ligne
                            var rowData = row.data();
                            console.log(rowData);
                            // Mettre à jour les colonnes 1 et 2
                            rowData[1] = nom;          // Mettre à jour la colonne "nom" (index 1)

                            // Appliquer les modifications
                            row.data(rowData).draw(false); // Mettre à jour la ligne sans redessiner tout le tableau
                        }

                        // Fermer la modal
                        $("#modCategorieModal").modal('hide');
                        // Réinitialiser le formulaire
                        $("#modCategorieForm")[0].reset();
                    } else {
                        // Afficher le message d'erreur
                        errorContainer.removeClass("d-none");
                        errorContainer.text("La somme des pondérations est incorrecte. Veuillez vérifier les valeurs.");
                    }


                })
                .fail(function (xhr, text, error) {
                    console.log("param : " + JSON.stringify(xhr));
                    console.log("status : " + text);
                    console.log("error : " + error);
                });
    }

}
function supprimerCategorie()
{

    // Récupérer l'ID de la première colonne (index 0)
    var id = $("#idCategorieSup").val();

    console.log("ID de la compétence à supprimer :", id);
    $.getJSON(
            '../Controleurs/controleur.php',
            {
                action: 'delCategorie',
                id: id
            }
    )
            .done(function (donnees, stat, xhr) {
                // supprimer la ligne au datatable
                // Récupérer le DataTable
                var table = $('#table_categorie').DataTable();

                // Supprimer directement la ligne avec l'ID
                var row = table.row(function (idx, data, node) {
                    return data[0] == id; // Trouver la ligne où l'ID correspond
                });

                if (row.length) {
                    row.remove().draw(); // Supprimer la ligne et redessiner le tableau
                    console.log("Ligne supprimée avec succès.");
                } else {
                    console.log("Impossible de trouver la ligne avec l'ID :", id);
                }
                // Fermer la modal
                $("#delCategorieModal").modal('hide');
                // Réinitialiser le formulaire
                $("#delCategorieForm")[0].reset();


            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}
function deconnexion()
{
    $.ajax({
        type: 'POST',
        url: '../Controleurs/controleur.php',
        data: {
            action: 'deconnexion'
        },
        success: function (response) {
            window.location.href = "index.php";
        },
        error: function () {
            showMessage("Erreur lors de l'inscription.", "danger");
        }
    });
}
$(document).ready(function () {
    chargerTableau();
        $(document).on('click', '#navDeconnexion', deconnexion);

    // Afficher la modal lorsqu'on clique sur "ajouter"
    $(document).on('click', '#ajouter', function () {
        $("#addCategorieModal").modal('show');
    });
    $(document).on('click', '#ajout', ajouterCategorie);
    $(document).on('click', '.supp', function () {
        var ligneCliquee = $(this).closest('tr');
        // Récupérer la table DataTable
        var table = $('#table_categorie').DataTable();
        // Utiliser DataTable pour récupérer les données associées à cette ligne
        var donneesLigne = table.row(ligneCliquee).data();

        // Récupérer l'id de la compétence (colonne 1 -> index0)
        var id = donneesLigne[0];
        // on met l'id dans le champs cachée de la modale de suppression
        $("#idCategorieSup").val(id);
        // Récupérer le texte de la 2nd colonne (index 1)
        var txtComp = donneesLigne[1];

        $("#supCompTxt").text(txtComp);
        $("#delCategorieModal").modal('show');
    });
    $(document).on('click', '#delComp', supprimerCategorie);

    $(document).on('click', '.mod', function () {
        var ligneCliquee = $(this).closest('tr');
        // Récupérer la table DataTable
        var table = $('#table_categorie').DataTable();
        // Utiliser DataTable pour récupérer les données associées à cette ligne
        var donneesLigne = table.row(ligneCliquee).data();

        // Récupérer l'id de la compétence (colonne 1 -> index0)
        var id = donneesLigne[0];
        // on met l'id dans le champs cachée de la modale de suppression
        $("#idCategorieMod").val(id);
        // Récupérer le texte de la 2nd colonne (index 1)
        var nom = donneesLigne[1];


        $("#nomMod").val(nom);

        $("#modCategorieModal").modal('show');
    });
    $(document).on('click', '#modif', modifierCategorie);

});