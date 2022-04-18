# Configuration app EcoIt

***

## Installer XAMPP

* telecharger l'[installeur XAMPP](https://www.apachefriends.org/fr/index.html)
* desactiver votre antivirus le temps de l'installation
* lors du choix des outils, Apache, MySQL et PHP doivent être cochés

***

## Installer postgresql

* telecharger [PostgreSQL](https://www.enterprisedb.com/downloads/postgres-postgresql-downloads)
* lors du choix du répertoire d'installation, choisissez C:\xampp\pgsql\(version de postgresql). Le dossier pgsql devra etre créer.
* lors des composants, PostgreSQL Server, pgAdmin4 et Command Line Tools sont obligatoires
* garder votre mot de passe et le port utilisé (5432 par défaut) de côté, ils seront utiles pour bous connecter a votre base de donnéees dans l'application
* garder local par defaut puis terminer
* une fois l'installation fini, lancer pgAdmin4

***

## Configuration base de données

* connecté vous grâce à votre mot de passe
* onglet object -> register -> server
* donner lui un nom puis dans l'onglet Connection, Host -> localhost (si vous avez bien laissé local par defaut), verifier que le port correspond bien au port de la configuration (5432 par defaut), entrer le password (mot de passe enregistré lors de l'installation) puis valider
* votre server devrait apparaitre sur le côté gauche avec son nom
* clique droit dessus ->  create -> database puis choisissez un nom puis valider. Un message d'erreur peut apparaître
* vérifier sa création avec clique droit sur votre server puis refresh
* il devrait y avoir deux databases, la vôtre et postgres
* clique droit sur votre database -> CREATE script
* une fenêtre souvrira nommée Query Editor
* nettoyer le script a l'intérieur puis copier le script sql du fichier 'bdd-Ecoit.sql' que vous avez dans le dossier récuperer
* appuyer sur Execute (bouton play noir dans barre d'outil)
* clique droit EcoIt -> refresh puis vérifier que les tables ont bien été créées (Schemas -> public -> Tables)

***

## Configurer xamp pour postgresql

* ouvrer le fichier php.ini  localisé dans C:\xampp\php.
* enlever les ; devant les lignes extension=pgsql et extension=pdo_pgsql
* ajouter en bas du fichier httpd.conf qui se trouve dans C:\xampp\apache\conf, le ligne : LoadFile "C:\xampp\php\libpq.dll"
* copier le dossier EcoIt dans C:\xampp\htdocs
* configurer le fichier config.php avec vos parametres
* lancer XAMPP Panel Control puis lancer Apache
* lancer votre navigateur et taper http://localhost/ecoit/ (ecoit et le nom du dossier contenant l'application)
* afin de faciliter la suite de l'utilisation de l'application, enregistrer votre administrateur en premier
* pour se faire, aller sur pgAdmin4, clique droit sur votre database -> CREATE script
* dans le Query Editor, nettoyer la fenêtre des anciens script si il y a puis copier le script du fichier 'admin.sql' que vous avez dans le dossier récuperer

***

### Vous pouvez maintenant essayer l'application
