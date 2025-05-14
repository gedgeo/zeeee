<?php
session_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION['user'] != "admin") {
        header('Location: jeu.php');
    }
} else {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Quiz</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">   
        <!-- jQuery -->
        <script src="libs/jquery/jquery.min.js" ></script>

        <!-- Bootstrap 5 CSS -->
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="libs/bootstrap/js/bootstrap.bundle.min.js" ></script>


        <!-- DataTables CSS & JS -->
        <link href="libs/datatables/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css"/>
        <script src="libs/datatables/js/jquery.dataTables.min.js" ></script>
        <script src="libs/datatables/js/dataTables.bootstrap5.min.js" ></script>
        <script src="admin_questions.js"></script>
        <style>
            .mod{
                color: blue;
                cursor: pointer;
            }
            .supp{
                color: red;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Admin Quiz</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarAdmin">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link " href="admin_questions.php" id="navCategories">Catégories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="admin_questions.php" id="navQuestions">Questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="jeu.php" id="navJeu">Jeu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="navDeconnexion">Deconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="mb-3">
                <label for="lstComp" class="form-label">Sélectionnez une catégorie</label>
                <select id="lstComp" class="form-select">
                    <!-- Options générées dynamiquement -->
                </select>
            </div>
            <h1 class="text-center mb-4">Gestion des questions pour la catégorie </h1>
            <h3  class="text-center mb-4"><span id="compet" class="text-primary"> </span></h3>

            <table id="table_question" class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th  class=" text-center">id</th>
                        <th  class=" text-center">Question</th>
                        <th  class=" text-center">Réponse</th>                        
                        <th class="text-center">Action &nbsp;<span class="text-success ms-3" id="ajouter" style="cursor: pointer;">&#43;</span></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <!-- Modal pour ajouter une question -->
        <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addQuestionModalLabel">Ajouter une question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addQuestionForm">

                            <div class="mb-3">
                                <label for="nomAdd" class="form-label">Texte de la question</label>
                                <input type="text" class="form-control" id="nomAdd" placeholder="Exemple : Gérer un projet" required>
                            </div>
                            <div class="mb-3">
                                <label for="repAdd" class="form-label">Réponse à la question</label>
                                <input type="text" class="form-control" id="repAdd" placeholder="Exemple : 1997" required>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="ajout">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal pour modifier une question -->
        <div class="modal fade" id="modQuestionModal" tabindex="-1" aria-labelledby="modQuestionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modQuestionModalLabel">Modifier une question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="modQuestionForm">

                            <div class="mb-3">
                                <label for="nomMod" class="form-label">Texte de la question</label>
                                <input type="text" class="form-control" id="nomMod" placeholder="Exemple : Gérer un projet" required>
                            </div>
                            <div class="mb-3">
                                <label for="repMod" class="form-label">Réponse à la question</label>
                                <input type="text" class="form-control" id="repMod" placeholder="Exemple : 1997" required>
                            </div>

                            <input type="hidden" id="idQuestionMod" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="modif">Mettre à jour</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour supprimer une question -->
        <div class="modal fade" id="delQuestionModal" tabindex="-1" aria-labelledby="delQuestionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="delQuestionModalLabel">Supprimer une question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="delQuestionForm">
                            <div class="mb-3">
                                <b id="supCompTxt"></b><br/>
                                Supprimer cette question ?
                            </div>
                            <input type="hidden" id="idQuestionSup" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-danger" id="delComp">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>


        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    </body>
</html>
