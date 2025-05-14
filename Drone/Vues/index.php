<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="main.js" ></script>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="acceuil.php">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="historique.php">Historique</a></li>
            <li class="nav-item"><a class="nav-link" href="stat.php">Statistiques</a></li>
            <li class="nav-item"><a class="nav-link" href="ajouter.php">Ajout élève</a></li>
            <li class="nav-item"><a class="nav-link" href="connection.php">Connexion</a></li>
        </ul>
    </nav>

    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>Liste des Utilisateurs</h1>
            <div><a href="creer.php" class="btn btn-primary">Ajouter un Utilisateur</a></div>
        </header>

        <div id="user-table-container"></div>
    </div>
</body>
</html>
