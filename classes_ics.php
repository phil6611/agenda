<?php

/* 
 *Les classes nécessaires pour l'agrégateur d'agenda.
 * GPL v3 ‒ Philippe Poisse ‒ février 2014
 * 
 */

class agregateur {

//Sert à récupérer les fichiers ics listés dans le fichier JSON.
    function liste_agenda($fichier) {
        
        $json = file_get_contents($fichier);
        $agenda = json_decode($json, TRUE);
        $calendrier = NULL;
        
       	foreach($agenda as $n=>$l) {
            foreach($l as $row){
                $association=  $row['association'];
		$web = $row['web'];
                $ics = $row['ics'];
                $calendrier .= file_get_contents($ics);
            }
	}
        
        return $calendrier;
    }
    
//sert à supprimer la référence au fuseau horaire.
    function date_tableau($tableau) {
        $date_heure = array();
        foreach ($tableau as $key => $value) {
            foreach ($value as $k => $v) {
                $search = '/DTSTART(.*):/';
                $replace = NULL;
                $resultat = preg_replace($search, $replace, $v);
                array_push($date_heure, $resultat);
            }
            return $date_heure;
        }
        
    }
    
//sert pour l'affichage des données
    function affichage($tableau_evenement){
        //récupération de la langue.
        if(filter_input(INPUT_GET, 'langue', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-z]{3}$/")))){
            $langue = filter_input(INPUT_GET, 'langue', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-z]{3}$/")));
        } else {
            $langue = "fr";
        }

       //création du fichier gabarit à inclure.
        $gabarit = "./template/template_".$langue.".inc";
        $gabarit_inclusion = file_get_contents($gabarit);
        
        for ($index = 0; $index < count($tableau_evenement); $index++) {
            if (!empty($tableau_evenement[$index]["lieu"])){
                $lieu = $tableau_evenement[$index]["lieu"];
            } else {
                $lieu = "Non indiqué.";
            }
            $texte_titre = str_replace("{{titre}}", $tableau_evenement[$index]["titre"], $gabarit_inclusion);
            $texte_date = str_replace("{{date}}", $tableau_evenement[$index]["date"], $texte_titre);
            $texte_horaire = str_replace("{{horaire}}", $tableau_evenement[$index]["horaire"], $texte_date);
            $texte_description = str_replace("{{description}}", $tableau_evenement[$index]["description"], $texte_horaire);
            $texte_lieu = str_replace("{{lieu}}", $lieu, $texte_description);

            echo $texte_lieu;
        }
        
    }
    
}

?>