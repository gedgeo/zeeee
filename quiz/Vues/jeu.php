<?php
session_start();
if (!isset($_SESSION['user'])) {

    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Quiz</title>
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
        <script src="jeu.js"></script>

    </head>
    <body>
        <div class="container container-fluid">
            <h2 id="pseudo" class="text-center">Bonjour </h2>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Quiz</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarJeu">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="jeu.php" id="navJeu">Jouer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="navDeconnexion">Deconnexion</a>
                        </li>
                         
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <section id="choixCat">
                <div class="mb-3">
                    <label for="lstCategories" class="form-label">Sélectionnez une catégorie</label>
                    <select id="lstCategories" class="form-select">
                        <!-- Options générées dynamiquement -->
                    </select>
                </div>
                <div class="btn btn-primary" id="start">Commencer le quiz</div>
            </section>
            <form>
                <div id="question"></div>
                <input type="hidden" id="user" />
            </form>
        </div>
    </body>
</html>