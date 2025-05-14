<?php
session_start();
 if (isset($_SESSION['user'])){
     if ($_SESSION['user']!="admin")
     {
                 header('Location: jeu.php');
     }     
 }
 else
 {
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
        <script src="admin_categories.js"></script>
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
                            <a class="nav-link active" href="admin_categories.php" id="navCategories">Catégories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_questions.php" id="navQuestions">Questions</a>
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

            <!-- Gestion des catégories -->
            <div id="sectionCategories">
                <h2>Gestion des Catégories 
                    
                </h2>
                <table id="table_categorie" class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th  class=" text-center">id</th>
                        <th  class=" text-center">Catégorie</th>                        
                        <th class="text-center">Action &nbsp;<span class="text-success ms-3" id="ajouter" style="cursor: pointer;">&#43;</span></th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>

            </div>

             <!-- Modal pour ajouter une categorie -->
        <div class="modal fade" id="addCategorieModal" tabindex="-1" aria-labelledby="addCategorieModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategorieModalLabel">Ajouter une categorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addCategorieForm">
                           
                            <div class="mb-3">
                                <label for="nomAdd" class="form-label">Nom de la categorie</label>
                                <input type="text" class="form-control" id="nomAdd" placeholder="Exemple : Gérer un projet" required>
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
        <!-- Modal pour modifier une categorie -->
        <div class="modal fade" id="modCategorieModal" tabindex="-1" aria-labelledby="modCategorieModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modCategorieModalLabel">Modifier une categorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="modCategorieForm">
                           
                            <div class="mb-3">
                                <label for="nomMod" class="form-label">Nom de la categorie</label>
                                <input type="text" class="form-control" id="nomMod" placeholder="Exemple : Gérer un projet" required>
                            </div>
                            
                            <input type="hidden" id="idCategorieMod" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="modif">Mettre à jour</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour supprimer une categorie -->
        <div class="modal fade" id="delCategorieModal" tabindex="-1" aria-labelledby="delCategorieModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="delCategorieModalLabel">Supprimer une categorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="delCategorieForm">
                            <div class="mb-3">
                                <b id="supCompTxt"></b><br/>
                                Supprimer cette categorie ?
                            </div>
                            <input type="hidden" id="idCategorieSup" />
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
