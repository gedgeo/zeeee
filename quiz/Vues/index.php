<?php
session_start();
 if (isset($_SESSION['user'])){
     if ($_SESSION['user']!="admin")
     {
                 header('Location: jeu.php');
     }
     else
     {
                 header('Location: admin_categories.php');
     }
 }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Authentification/inscription</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">   
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="libs/bootstrap/js/bootstrap.min.js"></script>
        <script src="libs/jquery/jquery.min.js" ></script>        
        <script src="auth.js" ></script>
    </head>
    <body>

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <!-- BOUTONS DE BASCULE -->
                    <div class="text-center mb-4">
                        <button id="showLogin" class="btn btn-primary">Connexion</button>
                        <button id="showRegister" class="btn btn-secondary">Inscription</button>
                    </div>

                    <!-- FORMULAIRE DE CONNEXION -->
                    <div id="loginForm">
                        <h3 class="text-center">Connexion</h3>
                        <form id="formLogin">
                            <div class="mb-3">
                                <label for="loginPseudo" class="form-label">Pseudo</label>
                                <input type="text" class="form-control" id="loginPseudo" required>
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="loginPassword" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Se connecter</button>
                            </div>
                        </form>
                    </div>

                    <!-- FORMULAIRE D'INSCRIPTION -->
                    <div id="registerForm" style="display:none;">
                        <h3 class="text-center">Inscription</h3>
                        <form id="formRegister">
                            <div class="mb-3">
                                <label for="registerPseudo" class="form-label">Pseudo</label>
                                <input type="text" class="form-control" id="registerPseudo" required>
                            </div>
                            <div class="mb-3">
                                <label for="registerPassword" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="registerPassword" required>
                            </div>
                            <div class="mb-3">
                                <label for="registerPasswordConfirm" class="form-label">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" id="registerPasswordConfirm" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">S'inscrire</button>
                            </div>
                        </form>
                    </div>

                    <div id="messageBox" class="alert d-none" role="alert"></div>

                </div>
            </div>
        </div>

    </body>
</html>