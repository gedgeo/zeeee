<?php

session_start();

require_once __DIR__ . '/../Modeles/modele.inc.php';
require_once __DIR__ . '/../Modeles/modele_utilisateurs.inc.php';

// Vérifie que la requête est bien de type GET
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET') {

    header('Content-Type: application/json');

// Récupère et sécurise le paramètre "action"
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// Routeur des actions
    switch ($action) {
        case 'getUsers':
            echo json_encode(getAllUsers());
            break;

         case 'deleteUser':
              $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
             echo json_encode(delUser($id));
             // Exemple futur pour supprimer un utilisateur
             break;

        default:

            echo json_encode(['error' => "Action inconnue : $action"]);
    }
}