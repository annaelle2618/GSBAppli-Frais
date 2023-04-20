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

        $levisiteur = $pdo->GetFicheVisiteur();
        $moisVisiteur = $pdo->getLesMoisVisiteur();

        include 'vues/v_validerFrais.php';
        break;

    case 'detailFiche':
        $lemois = filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_STRING);
        $levisiteur = filter_input(INPUT_POST, 'visiteur', FILTER_SANITIZE_STRING); 

        //Créer une session user et mois qui va stoker les données en session
        $_SESSION['user']=$levisiteur;
        $_SESSION['mois']=$lemois;

        if ($pdo->estPremierFraisMois($levisiteur, $lemois)) {
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait( $levisiteur, $lemois);
        $lesFraisForfait = $pdo->getLesFraisForfait( $levisiteur,  $lemois);

        include 'vues/v_validerDetail.php';
        }
        else{ 
            $error_message="aucune fiche pour cette date !";
            $levisiteur = $pdo->getVisiteur();
            $moisVisiteur= $pdo->getLesMoisVisiteur();
            include 'vues/v_validerFrais.php';
        }
        
        break;

    case 'modifierforfait':
        //$lemois = filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_STRING);
        //$levisiteur = filter_input(INPUT_GET, 'visiteur', FILTER_SANITIZE_STRING);

        $levisiteur=$_SESSION['user'];
        $mois=$_SESSION['mois'];
        
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($levisiteur,$mois);
        $lesFraisForfait = $pdo->getLesFraisForfait($levisiteur,$mois);
        $pdo->majFraisForfait($levisiteur, $mois, $_POST);
        include 'vues/v_validerDetail.php';
        break;

    case 'supprimerhorsforfait':
        //$lemois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
        //$levisiteur = filter_input(INPUT_GET, 'visiteur', FILTER_SANITIZE_STRING);

        $levisiteur=$_SESSION['user'];
        $lemois=$_SESSION['mois'];
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($levisiteur,$lemois);
        $nb=count($lesFraisHorsForfait);
        for ($i=1; $i<=$nb; $i++){
            if(isset($_POST['id'.$i])){
                
                //Recupere la date du jour
                
                // Vérifie le cas ou les dates sont supérieur au 10 du mois

                // MAJ de l'etat
                // Fin du if
                // SI NON 
                //$getleJour=$pdo->getleJour($dateJour);
                //$dateJour= $pdo->getleJour($_POST['id'.$i]);
                //$dateJour>10;

                $libelle=$pdo->getlibelle($_POST['id'.$i]);
                if (strstr($libelle,'REFUSE')==false){
                $nvlibelle= "REFUSE :".$libelle;
                $idl=$_POST['id'.$i];
                $pdo->majFraisHorsForfait($nvlibelle,$idl);
                echo "<hr>".$nvlibelle."<hr>";
                }else{
                    echo "frais déjà supprimé";
                }
              
                 
           
            
        }
    }
        
        break;

    case 'validerfiche':
        $lemois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
        $levisiteur = filter_input(INPUT_GET, 'id_visiteur', FILTER_SANITIZE_STRING);
        $pdo-> majEtatFicheFrais($levisiteur,$lemois,"VA"); //Modifie le statut
        include 'vues/v_statutValider.php';
        break;
    
        
}



