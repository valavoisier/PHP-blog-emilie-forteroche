## Blog d'Emilie Forteroche

## Pour utiliser ce projet : 

- Commencer par cloner le projet. 
- installez le projet chez vous, dans un dossier exécuté par un serveur local (type MAMP, WAMP, LAMP, etc...)
- Une fois installé chez vous, créez un base de données vide appelée : "blog_forteroche"
- Importez le fichier "blog_forteroche.sql" dans votre base de données.

## Lancez le projet ! 

Pour la configuration du projet vous pouvez aller voir dans config/config.php. 
Ce fichier contient notamment les informations de connextion à la base de donnée. 

Pour vous connecter en partie admin, le login est "Emilie" et le mot de passe est "password". 

## Problèmes courants :

Il est possible que la librairie intl ne soit pas activée sur votre serveur par défaut. Cette librairie sert notamment à traduire les dates en francais. Dans ce cas, vous pouvez soit utiliser l'interface de votre serveur local pour activer l'extention, soit aller modifier directement le fichier php.ini. 

Ce projet a été réalisé avec PHP 8.2. Bien que d'autres versions de PHP puissent fonctionner, nous ne pouvons garantir son bon fonctionnement avec des versions antérieures.

## Copyright : 

Projet utilisé dans le cadre d'une formation Openclassrooms. 