<?php

session_start();
require_once __DIR__ . '/../Modeles/modele_questions.inc.php';
require_once __DIR__ . '/../Modeles/modele_joueurs.inc.php';

function sendJson($data, $numericCheck = true) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, $numericCheck ? JSON_NUMERIC_CHECK : 0);
    exit;
}

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

if ($method === 'GET') {
    $action = filter_input(INPUT_GET, 'action');

    switch ($action) {
        case 'getPseudo':
            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
            } else {
                $user = "pas de session";
            }
            sendJson($user);
            break;
        // Catégories
        case 'getCategories':
            sendJson(getCategories());
            break;

        case 'addCategorie':
            sendJson(ajouterCategorie(
                            filter_input(INPUT_GET, 'nom')
            ));
            break;

        case 'delCategorie':
            supprimerCategorie(filter_input(INPUT_GET, 'id'));
            sendJson('ok', false);
            break;

        case 'updateCategorie':
            sendJson(modifierCategorie(
                            filter_input(INPUT_GET, 'id'),
                            filter_input(INPUT_GET, 'nom')
            ));
            break;
            ;

        // Questions
        case 'getQuestions':
            sendJson(getQuestions(filter_input(INPUT_GET, 'idCat')));
            break;

        case 'addQuestion':
            sendJson(ajouterQuestion(
                            filter_input(INPUT_GET, 'idCat'),
                            filter_input(INPUT_GET, 'nom'),
                            filter_input(INPUT_GET, 'reponse')
            ));
            break;

        case 'delQuestion':
            supprimerQuestion(filter_input(INPUT_GET, 'id'));
            sendJson('ok', false);
            break;

        case 'updateQuestion':
            sendJson(modifierQuestion(
                            filter_input(INPUT_GET, 'id'),
                            filter_input(INPUT_GET, 'nom'),
                            filter_input(INPUT_GET, 'reponse')
            ));
            break;
        case 'getQuestionsQuiz':
            sendJson(getQuestionsQuiz(filter_input(INPUT_GET, 'idCat')));
            break;
    }
}




if ($method === 'POST') {
    $action = filter_input(INPUT_POST, 'action');

    switch ($action) {

        case 'login':
            $log = filter_input(INPUT_POST, 'pseudo');
            $mdp = filter_input(INPUT_POST, 'password');
            sendJson(verifLogin($log, $mdp));
            break;
        case 'register':
            $log = filter_input(INPUT_POST, 'pseudo');
            $mdp = filter_input(INPUT_POST, 'password');
            sendJson(inscription($log, $mdp));
            break;
        case 'majScore':
            $sc = filter_input(INPUT_POST, 'score');
            $cat = filter_input(INPUT_POST, 'idCat');
            sendJson(majScore($sc, $cat));
            break;
        case 'deconnexion':
            unset( $_SESSION['user']);
            unset( $_SESSION['idUser']);
            sendJson("bye");
            break;
    }
}