function chargerTableau() {
    var urlComplete = window.location.href;
    var basePath = urlComplete.substring(0, urlComplete.lastIndexOf("/") + 1);
    var urlJsonFr = basePath + "/libs/datatables/fr-FR.json";
    var idCat = $("#lstComp option:selected").val();
     if ($.fn.DataTable.isDataTable('#table_question')) {
        $('#table_question').DataTable().clear().destroy();
    }
    if (idCat != -1)
    {
        $("#compet").text($("#lstComp option:selected").text());
        $.getJSON(
                '../Controleurs/controleur.php',
                {action: 'getQuestions',
                    idCat: idCat}
        )
                .done(function (donnees, stat, xhr) {
                    
                    // Initialisation de DataTable avec Bootstrap 5
                    $('#table_question').DataTable({
                        data: donnees,
                        columns: [
                            {
                                title: "id",
                                name: "id"

                            },
                            {title: "question",
                                name: "question"
                            },
                            {title: "reponse",
                                name: "response"
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
                                target : 3,
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
}

function ajouterQuestion()
{
    var nom = $("#nomAdd").val();
    var reponse = $("#repAdd").val();
    var errorContainer = $("#addQuestionError");
    var idCat=$("#lstComp").val();
    // Réinitialiser le message d'erreur
    errorContainer.addClass("d-none");
    if (nom !== "" && reponse !== "" && idCat!="-1")
    {
        $.getJSON(
                '../Controleurs/controleur.php',
                {
                    action: 'addQuestion',
                    nom: nom,
                    reponse: reponse,
                    idCat : idCat
                }
        )
                .done(function (donnees, stat, xhr) {
                    var id = donnees;   // id de l'entree dans la bdd
                    if (id != -1)
                    {
                        // ajouter la ligne au datatable
                        var table = $('#table_question').DataTable();
                        table.row.add([id, nom, reponse,
                            '<span class="text-primary mod">&#9998;</span>' +
                                    '<span class="text-danger ms-5 supp">&#128465;</span>'
                        ]).draw(false);

                        // Fermer la modal
                        $("#addQuestionModal").modal('hide');
                        // Réinitialiser le formulaire
                        $("#addQuestionForm")[0].reset();
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

function modifierQuestion()
{
    var nom = $("#nomMod").val();
    var reponse = $("#repMod").val();
    // Récupérer l'ID de la première colonne (index 0)
    var id = $("#idQuestionMod").val();
    var errorContainer = $("#modQuestionError");
    // Réinitialiser le message d'erreur
    errorContainer.addClass("d-none");
    if (nom !== "" && id !== "" && reponse !== "")
    {
        $.getJSON(
                '../Controleurs/controleur.php',
                {
                    action: 'updateQuestion',
                    nom: nom,
                    id: id,
                    reponse: reponse
                }
        )
                .done(function (donnees, stat, xhr) {
                    if (donnees != -1) {
                        // Récupérer le DataTable
                        var table = $('#table_question').DataTable();

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
                            rowData[2] = reponse;          // Mettre à jour la colonne "nom" (index 1)

                            // Appliquer les modifications
                            row.data(rowData).draw(false); // Mettre à jour la ligne sans redessiner tout le tableau
                        }

                        // Fermer la modal
                        $("#modQuestionModal").modal('hide');
                        // Réinitialiser le formulaire
                        $("#modQuestionForm")[0].reset();
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
function supprimerQuestion()
{

    // Récupérer l'ID de la première colonne (index 0)
    var id = $("#idQuestionSup").val();

    console.log("ID de la compétence à supprimer :", id);
    $.getJSON(
            '../Controleurs/controleur.php',
            {
                action: 'delQuestion',
                id: id
            }
    )
            .done(function (donnees, stat, xhr) {
                // supprimer la ligne au datatable
                // Récupérer le DataTable
                var table = $('#table_question').DataTable();

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
                $("#delQuestionModal").modal('hide');
                // Réinitialiser le formulaire
                $("#delQuestionForm")[0].reset();


            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}

function chargerListeCategories() {
    $.getJSON(
            '../Controleurs/controleur.php',
            {action: 'getCategories'}
    )
            .done(function (donnees, stat, xhr) {
                // Ajouter l'option par défaut avec Bootstrap
                $("#lstComp").append($("<option>", {value: "-1", class: "text-muted"}).text("Choisissez une catégorie"));
                //$("#lstCompMod").append($("<option>", {value: "-1", class: "text-muted"}).text("Choisissez une compétence"));

                // Ajouter les options pour chaque compétence
                $.each(donnees, function (index, ligne) {
                    $("#lstComp").append($("<option>", {value: ligne[0], class: "text-dark"}).text(ligne[1]));
                    //  $("#lstCompMod").append($("<option>", {value: ligne[0], class: "text-dark"}).text(ligne[1]));
                });
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
    chargerListeCategories();
        $(document).on('click', '#navDeconnexion', deconnexion);

    $(document).on('change', '#lstComp', chargerTableau);
    // Afficher la modal lorsqu'on clique sur "ajouter"
    $(document).on('click', '#ajouter', function () {
        $("#addQuestionModal").modal('show');
    });
    $(document).on('click', '#ajout', ajouterQuestion);
    $(document).on('click', '.supp', function () {
        var ligneCliquee = $(this).closest('tr');
        // Récupérer la table DataTable
        var table = $('#table_question').DataTable();
        // Utiliser DataTable pour récupérer les données associées à cette ligne
        var donneesLigne = table.row(ligneCliquee).data();

        // Récupérer l'id de la compétence (colonne 1 -> index0)
        var id = donneesLigne[0];
        // on met l'id dans le champs cachée de la modale de suppression
        $("#idQuestionSup").val(id);
        // Récupérer le texte de la 2nd colonne (index 1)
        var txtComp = donneesLigne[1];

        $("#supCompTxt").text(txtComp);
        $("#delQuestionModal").modal('show');
    });
    $(document).on('click', '#delComp', supprimerQuestion);

    $(document).on('click', '.mod', function () {
        var ligneCliquee = $(this).closest('tr');
        // Récupérer la table DataTable
        var table = $('#table_question').DataTable();
        // Utiliser DataTable pour récupérer les données associées à cette ligne
        var donneesLigne = table.row(ligneCliquee).data();

        // Récupérer l'id de la compétence (colonne 1 -> index0)
        var id = donneesLigne[0];
        // on met l'id dans le champs cachée de la modale de suppression
        $("#idQuestionMod").val(id);
        // Récupérer le texte de la 2nd colonne (index 1)
        var nom = donneesLigne[1];
// Récupérer le texte de la 3e colonne (index 1)
        var reponse = donneesLigne[2];

        $("#nomMod").val(nom);
        $("#repMod").val(reponse);
        $("#modQuestionModal").modal('show');
    });
    $(document).on('click', '#modif', modifierQuestion);

});