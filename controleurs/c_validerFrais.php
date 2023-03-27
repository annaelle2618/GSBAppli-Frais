<?php

/**
 * Gestion des frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */




$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
    case 'choisirFrais':

        $visiteur = $pdo->GetFicheVisiteur();
        $moisVisiteur = $pdo->getLesMoisVisiteur();

        include 'vues/v_validerFrais.php';
        break;

    case 'detailFiche':
        $levisiteur = filter_input(INPUT_POST, 'visiteur', FILTER_SANITIZE_STRING);
        $lesFraisForfait = $pdo->getLesFraisForfait($levisiteur, "202212");
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($levisiteur, "202212");
        include 'vues/v_validerDetail.php';
        break;

    case 'modifierforfait':
        $levisiteur = filter_input(INPUT_GET, 'visiteur', FILTER_SANITIZE_STRING);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($levisiteur,"202212");
        $pdo->majFraisForfait($levisiteur, "202212", $_POST);
        break;

    case 'supprimerhorsforfait':
        $levisiteur = filter_input(INPUT_GET, 'visiteur', FILTER_SANITIZE_STRING);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($levisiteur,"202212");
        var_dump($lesFraisHorsForfait);
        $nb=count($lesFraisHorsForfait);
        echo "<hr>".$nb."</hr>";
        for ($i=1; $i<=$nb; $i++){
            if(isset($_POST['id'.$i])){
                echo "test";
                $libelle=$pdo->getlibelle($_POST['id'.$i]);
                $nvlibelle= "REFUSE :".$libelle;
                $idl=$_POST['id'.$i];
                $pdo->majFraisHorsForfait($nvlibelle,$idl);
                echo "<hr>".$nvlibelle."<hr>";
                echo "<hr>".$idl."<hr>";

            }
        }
        
        break;

    case 'validerfiche':
        $levisiteur = filter_input(INPUT_GET, 'id_visiteur', FILTER_SANITIZE_STRING);
        $pdo-> majEtatFicheFrais($levisiteur,"202212","VA"); //Modifie le statut
        include 'vues/v_statutValider.php';
        break;
}


