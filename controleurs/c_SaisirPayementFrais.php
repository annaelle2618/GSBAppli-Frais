<?php
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {

case 'SaisirPayement':
        $visiteur = $pdo->GetFicheVisiteur();
        include 'vues/v_saisirlespayement.php';
        break;

    case 'FicheForfait':
        $lemois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
        $levisiteur = filter_input(INPUT_POST, 'visiteur', FILTER_SANITIZE_STRING);
        $lesFraisForfait = $pdo->getLesFraisForfait($levisiteur, $lemois);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($levisiteur, $lemois);
        include 'vues/v_FraisForfait.php';
        break;

    case 'modifierstatut':
        $lemois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
        $levisiteur = filter_input(INPUT_GET, 'visiteur', FILTER_SANITIZE_STRING);
        $pdo-> majEtatFicheFrais($levisiteur,$lemois,"MP");
        include 'vues/v_modifierstatut.php';
}