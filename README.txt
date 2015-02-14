Agenda partagé

version 0.2/022014 ‒ 17/02/2014
version 0.1/0214 ‒ 14/02/2014

L’application est fournie sous une double licence GPL v3 et CeCILL.

Fonctionnement
L’application Web est constituée de 3 fichiers :
Un fichier au format JSON, qui contient la liste des agendas à afficher (annuaire.json) ;
Un fichier PHP qui contient les classes à utiliser (classes_ics.php) ;
Un fichier PHP pour afficher les données (index.php).
L’application Web récupère des fichiers d’agenda au format Icalendar (fichier *.ics) les traite et affiche les données au format HTML. Il s’agit uniquement d’un système en lecture. Aucune mise à jour des agendas n’est possible directement depuis l’application.
L’application ne dispose d’aucun système d’accès à une base de données, ce qui garanti un certain niveau de sécurité.


Pré-requis
L’application Web nécessite PHP 5 (ou supérieur) avec le module JSON activé.


Installation
Le dossier contenant les fichiers peut être installé n’importe où sur le serveur. Le dit serveur n’a pas obligatoirement à être celui qui héberge le site Web de l’association.


Configuration
Le fichier « annuaire.json » doit être édité directement pour saisir les adresses des fichiers ics.
Le reste est automatisé.

Création du fichier ics
Les fichiers ics peuvent être créé automatiquement, via un script installé sur le serveur Web de l’association, ou créé manuellement depuis un logiciel tiers et mis en ligne ensuite.
Une liste de logiciels capable de créer des fichiers ics : http://en.wikipedia.org/wiki/List_of_applications_with_iCalendar_support

Affichage des données
Les données sont affichées au format HTML5 sous forme de texte.
Pour les afficher il suffit de créer une page Web et d’insérer le code suivant :
<iframe src="ADRESSE"></iframe>
La valeur ADRESSE correspond à l’url du fichier index.php.
Un exemple : <iframe src="http://www.philippe-poisse.eu/projets/agenda/index.php"></iframe>

Bugs connus
Si le fichier ics ne contient pas de référence au fuseau horaire (timezone) la date et l’heure ne s’affiche pas.


TODO
Rédiger une feuille de route
Mettre en place un outil d’administration.
Mettre en place un gestionnaire de version.
Passage complet à de la POO.
Trouver un nom pour l’application.
Tester le nouveau camion de pizza en bas de chez moi.
