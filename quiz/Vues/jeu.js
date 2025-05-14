var tabQuestions = [];
var indexQuestion = 0;
var tabReponses = [];

function chargerListeCategories() {
    $.getJSON(
            '../Controleurs/controleur.php',
            {action: 'getCategories'}
    )
            .done(function (donnees, stat, xhr) {
                // Ajouter l'option par défaut avec Bootstrap
                $("#lstCategories").append($("<option>", {value: "-1", class: "text-muted"}).text("Choisissez une catégorie"));

                // Ajouter les options pour chaque compétence
                $.each(donnees, function (index, ligne) {
                    $("#lstCategories").append($("<option>", {value: ligne[0], class: "text-dark"}).text(ligne[1]));
                });
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}

function afficherQuestion()
{
    if (indexQuestion >= 0 && indexQuestion < 5)
    {
        $("#question").text("Question " + (1 + indexQuestion) + " / 5");
        $("#question").append("<br>" + tabQuestions[indexQuestion].texte);
        $("#question").append("<br><input type=\"text\" placeholder=\"votre réponse\">");
        $("#question").append("<input type=\"hidden\" value=\"" + tabQuestions[indexQuestion].id + "\">");
        $("#question").append("<span class=\"btn btn-primary valide\">Valider</span>");
        $("#question input[type='text']").focus();

    }

}
function ajouterReponse(e)
{
    e.preventDefault();
    function normaliserTexte(texte) {
        return texte
                .trim() // retirer les espaces
                .toLowerCase() // mettre en minuscule
                .normalize("NFD") // décomposer les lettres accentuées
                .replace(/[\u0300-\u036f]/g, ""); // supprimer les diacritiques (accents)
    }
    var reponse = $('input[type="text"]').val();
    var id = $('input[type="hidden"]').val();
    tabReponses.push({id: id, reponse: reponse});
    indexQuestion++;
    if (indexQuestion == 5)
    {
        indexQuestion = 0;
        //console.log(tabQuestions);
        //console.log(tabReponses);
        // fin de quizz
        // calculer scores
        var score = 0;
        $.each(tabQuestions, function (index, question) {
            // trouver la réponse correspondant à la question
            var rep = tabReponses.find(r => r.id == question.id);

            if (
                    rep &&
                    normaliserTexte(rep.reponse) ==
                    normaliserTexte(String(question.reponse))
                    ) {
                score++;
            }


        });
        console.log("score : " + score);
        $("#choixCat").show();
        $("#question").text("Votre score est de " + score + " / 5 ");
        var idCat = $("#lstCategories option:selected").val();

        majScore(score, idCat);
    } else
    {
        afficherQuestion();
    }
}
function chargerQuestions()
{
    var idCat = $("#lstCategories option:selected").val();
    var nomCat = $("#lstCategories option:selected").text();
    if (idCat != -1)
    {
        $("#choixCat").hide();
        $.getJSON(
                '../Controleurs/controleur.php',
                {action: 'getQuestionsQuiz',
                    idCat: idCat}
        )
                .done(function (donnees, stat, xhr) {

                    $("#question").text("");

                    $.each(donnees, function (index, ligne) {
                        tabQuestions.push(ligne);
                    });
                    indexQuestion = 0;
                    afficherQuestion();

                })
                .fail(function (xhr, text, error) {
                    console.log("param : " + JSON.stringify(xhr));
                    console.log("status : " + text);
                    console.log("error : " + error);
                });
    }

}
function majScore(score, idCat)
{
    $.ajax({
        type: 'POST',
        url: '../Controleurs/controleur.php',
        data: {
            action: 'majScore',
            score: score,
            idCat: idCat
        },
        success: function (response) {
            tabQuestions = [];
            tabReponses = [];
        },
        error: function () {
            showMessage("Erreur lors de l'inscription.", "danger");
        }
    });
}
function getPseudo()
{
    $.getJSON(
            '../Controleurs/controleur.php',
            {action: 'getPseudo'
            }
    )
            .done(function (donnees, stat, xhr) {

                $("#pseudo").append(donnees);
                $("#user").val(donnees);
                if (donnees == "admin")
                {
                    $("#navbarJeu ul").append('<li class="nav-item"><a class="nav-link" href="admin_categories.php" id="navAdm">Admin</a>                        </li>')
                }

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
    //$(document).on('change', '#lstCategories', chargerQuestions);
    $(document).on('click', '#start', chargerQuestions);
    $(document).on('click', '.valide', ajouterReponse);
    $(document).on('click', '#navDeconnexion', deconnexion);
    $(document).on('submit', 'form', ajouterReponse);
    getPseudo();

});

