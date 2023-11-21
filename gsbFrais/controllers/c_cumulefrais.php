<?php
/** @var PdoGsb $pdo */
include 'views/v_sommaire.php';
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){
	case 'selectionnerMois':{
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste,
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		include("views/v_listeMois.php");
		break;
	}
	case 'voirEtatFrais':{
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $leMois;
		include("views/v_listeMois.php");
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		
		//Gestion des dates
		@list($annee,$mois,$jour) = explode('-',$dateModif);
		$dateModif = "$jour"."/".$mois."/".$annee;

		//$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("views/v_etatFrais.php");
	}
	
    case 'cumulefrais':{
		$typeFrais=$pdo->getTypeDeFrais();
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		//$moisASelectionner = $leMois;
		include("views/v_cumulefrais.php");
		break;
	}

	case 'voirCumuleFrais':{
		$typeFrais=$pdo->getTypeDeFrais();
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		//$moisASelectionner = $leMois;
		include("views/v_cumulefrais.php");
		$idFraisForfait=$_REQUEST['tfrais'];
		$mois = $_REQUEST['lstMois'];
		//$idFraisForfait=$pdo->getTypeDeFrais();
		$montant=$pdo->getCumuleEtatFrais($idVisiteur,$mois,$idFraisForfait);
		//$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("views/v_voirCumuleFrais.php");
		break;
	}

	case 'fraisVisiteur':{
		$visiteurs=$pdo->getIdVisiteur();
		$leVisiteur=$_REQUEST['numero'];
		$typeFrais=$pdo->getTypeDeFrais();
		//$moisASelectionner = $leMois;
		include("views/v_fraisVisiteur.php");
		break;
	}

	case 'voirFraisVisiteur':{
		$visiteurs=$pdo->getIdVisiteur();
		$leVisiteur=$_REQUEST['numero'];
		$typeFrais=$pdo->getTypeDeFrais();
		//$moisASelectionner = $leMois;
		include("views/v_fraisVisiteur.php");
		$idFraisForfait=$_REQUEST['tfrais'];
		$mois = $_REQUEST['lstMois'];
		//$idFraisForfait=$pdo->getTypeDeFrais();
		$montant=$pdo->getFraisVisiteur($idVisiteur,$mois,$idFraisForfait);
		//$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("views/v_voirFraisVisiteur.php");
		break;
	}



}
