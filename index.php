<?php
header('Content-Type: text/html; charset=utf-8');

/* 
 * Idée d'origine
 * http://conceptionwebsite.fr/blog/2011/parser-un-calendrier-ics-en-php/
*/

include_once("./classes_ics.php");
$liste_json = new agregateur;

$calendrier = $liste_json->liste_agenda("./annuaire.json");


// Expressions régulières
$regExpSommaire =  '/SUMMARY:(.*)/';
$regExpDate = '/DTSTART;(.*)/';
$regExpDesc = '/DESCRIPTION:(.*)/';
$regExpLocation = "/[^\-]LOCATION:(.*)/";

$n = preg_match_all($regExpSommaire, $calendrier, $sommaireTableau, PREG_PATTERN_ORDER);
preg_match_all($regExpDate, $calendrier, $dateTableau, PREG_PATTERN_ORDER);
preg_match_all($regExpDesc, $calendrier, $descTableau, PREG_PATTERN_ORDER);
preg_match_all($regExpLocation, $calendrier, $locationTableau, PREG_PATTERN_ORDER);

//Suppression de la référence au fuseau horaire.
$dateTableau = $liste_json->date_tableau($dateTableau);

//tableau associatif pour gérer les informations concernant les événements.
$tableau_agenda = array();

for ($j=0 ; $j < $n ; ++$j)
{
    // Récupération des données
    $annee = substr( $dateTableau[$j], 0, 4);
    $mois = substr( $dateTableau[$j], 4, 2);
    $jour = substr( $dateTableau[$j], 6, 2);
    $heure = substr( $dateTableau[$j], 9, 2);
    $min = substr( $dateTableau[$j], 11, 2);
    $sommaire = substr( $sommaireTableau[0][$j], 8);

    $desc = substr( $descTableau[0][$j], 12);
    if (!empty($locationTableau[0][$j])){
        $location = substr($locationTableau[0][$j], 10);
    } else {
        $location = NULL;
    }

    // Mise en forme
    $date = $jour. "/".$mois. "/".$annee;
    $date_tri = $annee."/".$mois."/".$jour;
    $horaire = $heure. "h".$min;

    $sous_tableau_agenda['titre'] = $sommaire;
    $sous_tableau_agenda['date'] = $date;
    $sous_tableau_agenda['date_tri'] = $date_tri;
    $sous_tableau_agenda['horaire'] = $horaire;
    $sous_tableau_agenda['description'] = $desc;
    $sous_tableau_agenda['lieu'] = $location;

    array_push($tableau_agenda, $sous_tableau_agenda);

}
//tri des données par ordre chronologique.
foreach ($tableau_agenda as $key => $value) {
    $date_tableau[$key] = $value["date_tri"];
    $horaire_tableau[$key] = $value["horaire"];
}

array_multisort($date_tableau,SORT_DESC, $horaire_tableau, SORT_DESC, $tableau_agenda);

$liste_json->affichage($tableau_agenda);

?>