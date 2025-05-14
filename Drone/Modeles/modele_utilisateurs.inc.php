<?php

require_once __DIR__ . '/modele.inc.php';
/*
function obtenirDepartementsDeLaRegion($idRegion) {
    try {
        $bdd = connexionBdd();

        $requete = $bdd->prepare('SELECT departement_id, departement_nom FROM departements where departement_region_id = :id;');
        $requete->bindParam(":id", $idRegion);
        $requete->execute();

        $departements = array();
        while ($reponse = $requete->fetch(PDO::FETCH_ASSOC)) {
            array_push($departements, $reponse);
        }
        $requete->closeCursor();
        return $departements;
    } catch (PDOException $exc) {
        print(" Pb obtenirDepartementsDeLaRegion :" . $exc->getMessage());
        die();
    }
}
 * */
 
function getAllUsers()
{
    try {
        $bdd = connexionBdd();

        $requete = $bdd->query('SELECT * FROM UTILISATEURS;');

        $users = array();
        while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
            array_push($users, $ligne);
        }
        $requete->closeCursor();
        return $users;
    } catch (PDOException $exc) {
        print(" Pb obtenirDepartementsDeLaRegion :" . $exc->getMessage());
        die();
    }
    
}