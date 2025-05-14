<?php

require_once __DIR__ . '/modele.inc.php';

function verifLogin($log, $mdp) {
    try {

        // connexion à la base de données
        $bdd = connexionBdd();
        $requete = $bdd->prepare("select id from joueurs where pseudo=:log and mdp=:mdp; ");
        $requete->bindParam(":log", $log);
        $requete->bindParam(":mdp", $mdp);
        $requete->execute();
        $retour = "bad log/pass";
        $nb = $requete->rowCount();

        if ($nb == 1) {
            $_SESSION['user'] = $log;
            $_SESSION['idUser'] = $requete->fetchColumn();
            if ($log != "admin") {
                $retour = "user";
            } else {
                $retour = "admin";
            }
        } else {
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
                unset($_SESSION['idUser']);
            }
        }

        return $retour;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function inscription($log, $mdp) {
    try {
        // connexion à la base de données
        $bdd = connexionBdd();

        // vérifier si le pseudo existe déjà
        $requete = $bdd->prepare("SELECT id FROM joueurs WHERE pseudo = :log;");
        $requete->bindParam(":log", $log);
        $requete->execute();
        $retour = "admin";
        if ($requete->rowCount() > 0) {
            $retour = "existe";
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
                unset($_SESSION['idUser']);
            }
        } else {
            $_SESSION['user'] = $log;
            
            if ($log != "admin") {
                $retour = "user";
            }
        }

        // insérer le nouveau joueur
        $insert = $bdd->prepare("INSERT INTO joueurs (pseudo, mdp) VALUES (:log, :mdp);");
        $insert->bindParam(":log", $log);
        $insert->bindParam(":mdp", $mdp);
        $insert->execute();
        $_SESSION['idUser'] = $bdd->lastInsertId();
        return $retour;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}
function majScore($score,$idCat)
{
     try {
        // connexion à la base de données
        $bdd = connexionBdd();

        $idJoueur=$_SESSION['idUser'];

        // insérer le nouveau joueur
        $insert = $bdd->prepare("INSERT INTO scores (id_type,id_joueur,score,horodatage) VALUES (:cat, :user,:score,now());");
        $insert->bindParam(":cat", $idCat);
        $insert->bindParam(":user", $idJoueur);
        $insert->bindParam(":score", $score);
        $insert->execute();
        
        return "ok";
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
    
}
