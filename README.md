# ExtraMémoire 

ExtraMémoire est une application web de cartes mémoire virtuelles développée avec Symfony 4.3. 
[Formation Développeur Web Junior d'OpenClassrooms, projet 5]

## Le projet

ExtraMémoire est une application web qui vous permet de créer et modifier vos cartes mémoire en toute simplicité.
Le but est de faire travailler sa mémoire à long terme et d'apprendre efficacement grâce au principe de la répétition espacée. 
Une carte mémoire se présente sous la forme d'une carte de question-réponse, associée à un ensemble de boutons représentant la difficulté de la question (exemple ci-dessous).
![Un exemple de carte mémoire, avec en haut à gauche le tag associé, en haut à droite le nombre de cartes à travailler et en bas l'ensemble des boutons représentant la difficulté de la question](https://extramemoire.pablobuisson.fr/img/flashcard-exemple.png)

## Fonctionnement 

Après vous êtes inscrit, vous êtes dirigé vers un tableau de bord, d'où vous pourrez créer et modifier vos cartes et vos tags. Après avoir ajouté une carte, revenez sur la page d'accueil, et tentez de répondre avec précision à la carte affichée. Selon le bouton de difficulté choisi, la carte reviendra à intervalles réguliers sur votre page d'accueil. 
Ainsi, voyez la page d'accueil comme l'interface de l'application ; n'oubliez pas de vous y rendre quotidiennement !

## Installation (dev)

### Environnement
* Symfony 4.3.1
* PHP 7.2 minimum
* Composer

### Bundles/Extensions
* EasyAdminBundle
* SecurityBundle
* Faker
* DoctrineExtensions
* DoctrineFixturesBundle
* WebServerBundle

### Installation
* Clonez/Téléchargez le projet
* Ouvrez le projet [ cd openclassrooms-dwj-projet-5/ ]
* Dans votre éditeur de code ou depuis votre console, tapez : composer install
* Duppliquez votre .env.dist et renommez-le .env
* Créez votre base de données
* Modifiez votre .env pour renseigner les identifiants de votre base de données [ DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name ]
* Faites une migration [ php bin/console make:migration ] puis [ php bin/console doctrine:migrations:migrate ]
* Veillez à ce que la ligne 23 de l'index.php [ public/index.php ] corresponde au bon environnement 
* En cas de problème ou d'éventuelles questions, [contactez-moi !](mailto:pablo.buisson@gmail.com)