Install Symfony : 
http://symfony.com/installer

cmd :
 php symfony.phar new projetformation


Ligne de commande symfony : php bin/console : recueil de ligne de commande.


Lancer le serveur interne de symfony : 
php bin/console server:run

(utilise le port 8000 : on accede donc au projet symfony en mettant localhost:8000)

plugin à installer avec phpstorm :
"symfony plugin" et "php annotation"




comment ca se passe: requete http => lu par app-dev.php (controller de vue dans le dossier web) qui route et donc appelle le bon controller qui appelle le modele et renvoie les données à la vue (aussi appelée "réponse http")
	
composer.json à la racine qui utilise l'autoload en psr-4 (nom de dossier = nom des class) qui utilise le dossier src comme base

Creation de service :
1] dossier services (ou autre) dans le Bundle
2] on créé la class PHP
3] on enregistre services.yml


{{asset dans twig recherche la ressource à partir du dossier web}}



INSTALLER DES EXTENSIONS DE TWIG :

http://twig.sensiolabs.org/doc/extensions/index.html

taper dans la ligne de commande à la racine du site : composer require twig/extensions
Ensuite il faut activer l'extension : aller dans le config/service.yml



Creer database avec symfony : on utilise doctrine (grosse bibliotheque mise en service par symfony)

configurer avec parameters.yml
puis créer la base avec les lignes de commande :
 php bin/console doctrine:database:create (prends en parametre le fichier parameters.yml)

créer les tables avec doctrine qui fait le mappage de la base: 
php bin/console generate:doctrine:entity
apres il créé les tables :
NomBundle:NomEntité (entité = table ) et on choisit les champs qu'on veut dans la table

Ca créer deux dossiers dans le dossier src (entity et repository) qui font le mappage avec la bdd : ils contiennent les class qui sont liées à la table
pour créer la table correspondante, faire la ligne de commande suivante : php bin/console doctrine:schema:update --force




Créer une class de formulaire a partir d'une entité : 

 php bin/console generate:doctrine:form AppBundle:Category : créé une class de formulaire dans un nouveau dossier "Form"
 On va plus tard faire une vue de ce formulaire




form theme : pré-styler un formulaire
rajouter dans le config.yml cette clé
dans le # Twig Configuration
twig:
	form_themes: ["bootrstrap_3_layout.html.twig"] 

ce fichier est rangé dans /sites/cinefan/vendor/symfony/symfony/src/Symfony/Bridge/Twig/Resources/views/Form
Ca utilise les class bootstrap, c'est du préformage de formulaire, on peut en rajouter mais il faut les mettre dans le dossier src

A la création de service, on fait un construct de ce service quand il appelle un parametre qui est passé au constructeur dans le fichier service.yml (exemple du service CategoryListener)



relations entre entités avec doctrine
http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/association-mapping.html

quand on modifie une entité : penser à faire php console doctrine:generate:entities AppBundle:Movie   pour modifier aussi les getter et setter générés dans l'entité





Les contraintes de formulaires qui sont mis dans l'entité sont toujours la, on ne peut pas les mettre soit lors de l'update soit lors de l'insert. Pour faire une contrainte lors de l'insert seulement, il faut les mettre dans le ... subscripteur. De meme on supprime le champ dans la class de formulaire 'movietype'

subscripteur : on ecoute plusieurs evenement (pour les formulaires - plus optimisé)
ecouteur :     on ecoute un evenement (listener d'event) (pour les entites)

formHandler : gestionnaire  de formulaire

le preinsert, preupdate: evenement d'entité
la gestion de fichier du formulaire : evenement de formulaire



Pour installer un bundle, suivre la doc, add avec le composer le bundle et le mettre dans le fichier AppKernel.php
Pour mettre des données par defaut: 
Il faut installer ces deux bundle :
doctrine fixture bundlle
alice bundlle (pas la 2, mais la 1.quelquechose)
la bibliotheque utilisée dans alice est faker, qui est une bibliotheque php : elle est utilisée dans les yml du dossier appbundle/datafixtures/orm/

une fois que nos bundle sont installés et que les yml sont la il faut lancer la ligne de commande suivante: 
php bin/console hautelook_alice:doctrine:fixtures:load --no-interaction --purge-with-truncate




rajouter des fonctions mysql : c'est le bundle 
beberlei/DoctrineExtensions (https://packagist.org/packages/beberlei/DoctrineExtensions)
descritpion de ce bundle : 
A set of extensions to Doctrine 2 that add support for additional query functions available in MySQL and Oracle.
une fois installé, il faut mettre mysql.yml dans le dossier App/config (mysql.yml qu'on peut trouver ici : https://raw.githubusercontent.com/beberlei/DoctrineExtensions/7b5e5ef31e606e6bcd18a6bb7cc6f5b9bbd1fede/config/mysql.yml)
Une fois l'extension mysql.yml installée, il faut aller dans le config.yml et rajouter la ligne suivante : - { resource: mysql.yml } dans la section import


Pour faire les requetes, on va faire une class d'abstraction DQL qu'on stocke dans le dossier repository: il possède les methodes pour créer la vraie requête SQL 

POUR QUE PHPSTORM NOUS AIDE POUR LES TESTS UNITAIRE, IL FAUT DL PHPUNIT.phar QU'on met à la racine de symfony


http://cinema.jeuxactu.com/news-serie-tv-les-series-qu-il-ne-fallait-pas-louper-en-2016-28359.htm
