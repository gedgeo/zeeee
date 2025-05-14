<?php

require_once __DIR__ . '/modele.inc.php';

/* * ************* gestion categories ********************* */

function getCategories() {
    try {
        // connexion à la base de données
        $bdd = connexionBdd();
        $requete = $bdd->query("SELECT id as idCategorie, nom_type as nomCategorie from type_questions; ");
        $tabCategories = array();
        // execution de la requete
        while ($ligne = $requete->fetch()) {
            array_push($tabCategories, array(
                $ligne['idCategorie'],
                $ligne['nomCategorie'],
                "<span class=\"text-primary mod\" id=\"modifier_{$ligne['idCategorie']}\">&#9998;</span>
                  <span class=\"text-danger ms-5 supp\" id=\"supprimer_{$ligne['idCategorie']}\">&#128465;</span>"
            ));
        }
        // libération de la ressource
        $requete->closeCursor();
        return $tabCategories;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function ajouterCategorie($nom) {
    try {

        // connexion à la base de données
        $bdd = connexionBdd();
        $requete = $bdd->prepare("INSERT INTO type_questions (nom_type) values (:n); ");
        $requete->bindParam(":n", $nom);
        $requete->execute();
        $id = $bdd->lastInsertId();

        return $id;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function supprimerCategorie($id) {
    try {
        // connexion à la base de données
        $bdd = connexionBdd();
        $requete = $bdd->prepare("DELETE FROM type_questions WHERE id = :id ; ");
        $requete->bindParam(":id", $id);
        $requete->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function modifierCategorie($id, $nom) {
    try {
        // la somme des pondérations est elle correcte ?

        $ok = 1;
        // connexion à la base de données
        $bdd = connexionBdd();
        $requete = $bdd->prepare("UPDATE type_questions SET nom_type = :n  WHERE id = :id; ");
        $requete->bindParam(":n", $nom);
        $requete->bindParam(":id", $id);
        $requete->execute();

        return $ok;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

/* * ************* gestion questions ********************* */

function ajouterQuestion($idCat, $nom, $rep) {
    try {

        // connexion à la base de données
        $bdd = connexionBdd();
        $requete = $bdd->prepare("INSERT INTO questions (id_type,intitule,reponse) values (:id,:n,:int); ");
        $requete->bindParam(":id", $idCat);
        $requete->bindParam(":n", $nom);
        $requete->bindParam(":int", $rep);
        $requete->execute();
        $id = $bdd->lastInsertId();

        return $id;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function supprimerQuestion($id) {
    try {
        // connexion à la base de données
        $bdd = connexionBdd();
        $requete = $bdd->prepare("DELETE FROM questions WHERE id = :id ; ");
        $requete->bindParam(":id", $id);
        $requete->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function modifierQuestion($id, $nom, $reponse) {
    try {
        // la somme des pondérations est elle correcte ?

        $ok = 1;
        // connexion à la base de données
        $bdd = connexionBdd();
        $requete = $bdd->prepare("UPDATE questions SET intitule = :n , reponse = :rep  WHERE id = :id; ");
        $requete->bindParam(":n", $nom);
        $requete->bindParam(":rep", $reponse);
        $requete->bindParam(":id", $id);
        $requete->execute();

        return $ok;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function getQuestions($idCat) {
    try {
        // connexion à la base de données
        $bdd = connexionBdd();
        $requete = $bdd->prepare("SELECT id , intitule,reponse from questions where id_type=:idt; ");
        $requete->bindParam(":idt", $idCat);
        $requete->execute();
        $tabCategories = array();
        // execution de la requete
        while ($ligne = $requete->fetch()) {
            array_push($tabCategories, array(
                $ligne['id'],
                $ligne['intitule'],
                $ligne['reponse'],
                "<span class=\"text-primary mod\" id=\"modifier_{$ligne['idCategorie']}\">&#9998;</span>
                  <span class=\"text-danger ms-5 supp\" id=\"supprimer_{$ligne['idCategorie']}\">&#128465;</span>"
            ));
        }
        // libération de la ressource
        $requete->closeCursor();
        return $tabCategories;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function getQuestionsQuiz($idCat) {
    try {
        // connexion à la base de données
        $bdd = connexionBdd();
        $requete = $bdd->prepare("SELECT id , intitule,reponse from questions where id_type=:idt order by rand() LIMIT 5; ");
        $requete->bindParam(":idt", $idCat);
        $requete->execute();
        $tabCategories = array();
        // execution de la requete
        while ($ligne = $requete->fetch()) {
            array_push($tabCategories, array(
                "id" => $ligne['id'],
                "texte" => $ligne['intitule'],
                "reponse" => $ligne['reponse']
            ));
        }
        // libération de la ressource
        $requete->closeCursor();
        return $tabCategories;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}
