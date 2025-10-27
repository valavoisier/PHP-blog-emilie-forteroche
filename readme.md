## Blog d'Emilie Forteroche
Projet réalisé dans le cadre de la formation "Développez votre site web avec PHP et MySQL" sur OpenClassrooms. Travail sur le code dévelopé par un autre développeur et enrichissement de la partie administration. Création d'un tableau de bord avec tri dynamique des articles et gestion des commentaires.

## Pour utiliser ce projet : 

- Commencer par cloner le projet. 
- installez le projet chez vous, dans un dossier exécuté par un serveur local (type MAMP, WAMP, LAMP, etc...)
- Une fois installé chez vous, créez un base de données vide appelée : "blog_forteroche"
- Importez le fichier _blog_forteroche.sql_ dans votre base de données.

## Lancez le projet ! 

le fichier config.php (dans le dossier config) contient notamment les informations de connextion à la base de données. 

Pour vous connecter en partie admin, le login est "Emilie" et le mot de passe est "password" (attention aux majuscules)

## Problèmes courants :

Il est possible que la librairie intl ne soit pas activée sur votre serveur par défaut. Cette librairie sert notamment à traduire les dates en francais. Dans ce cas, vous pouvez soit utiliser l'interface de votre serveur local pour activer l'extention (wamp), soit aller modifier directement le fichier _php.ini_. 

Ce projet a été réalisé avec PHP 8.2. Bien que d'autres versions de PHP puissent fonctionner, il n'est pas garanti que le projet fonctionne avec des versions antérieures.

## Copyright : 

Projet utilisé dans le cadre d'une formation Openclassrooms. 
