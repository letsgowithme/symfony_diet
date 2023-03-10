#                                        Symfony_diet

                                           Contexte du projet
                                           
Sandrine Coupart est une diététicienne-nutritionniste dont le cabinet est situé à Caen. En tant que
professionnelle de santé, elle prend en charge des patients dans le cadre de consultations diététiques.
Madame Coupart anime également des ateliers de prévention et d’information sur la nutrition.
Son fonctionnement habituel était de transmettre par email à ses patients des recettes santé. N’ayant pas
de site web, elle voulait profiter de l’occasion pour partager, à l’avenir, quelques-unes de ses recettes à
un plus grand nombre de visiteurs.
De plus, madame Coupart désirerait qu’il y ait un système d’authentification sur son site, afin de proposer
pour chaque patient des recettes supplémentaires adaptées à son régime.
Chaque recette possédera :
 Un titre,
 Une description,
 Un temps de préparation,
 Un temps de repos,
 Un temps de cuisson,
 Les ingrédients,
 Les étapes,
 Une liste des allergènes possibles,
 Un ou plusieurs types de régime (végétarien, sans lactose, sans sel, etc.).

                                          `Fonctionnalités désirées`
US1. Se connecter
Utilisateurs concernés : Administrateur, Patients

US2. Créer un patient
Utilisateurs concernés : Administrateur

Il est important de préciser la liste des allergènes pouvant provoquer une réaction au patient.
Plusieurs types de régime peuvent lui être associés.

US3. Ajouter une recette
Utilisateurs concernés : Administrateur
Une case doit pouvoir être cochée afin que cette recette soit seulement accessible aux patients.

US4. Voir les recettes
Utilisateurs concernés : Administrateur, Visiteurs, Patients

Les visiteurs voient les recettes de base.
Les patients accèdent aux recettes supplémentaires. De plus, un filtrage est fait automatiquement
pour ne montrer que celles qui sont adaptées à son régime et allergènes à éviter.
Les patients peuvent écrire un avis et donner une note (de 1 à 5). Pour plus de dynamisme, la
soumission de l’avis ne devra pas recharger la page.

US5. Découvrir les services du cabinet
Plusieurs pages statiques devront être mises en place, et optimisées pour s’afficher correctement sur tout
support :
 Une page d’accueil avec au moins une section "À propos" et “Mes services”,
 Une page de contact,
 Une page de mentions légales (Obligatoire depuis 2004),
 Une page de politique de confidentialité (Obligatoire depuis le RGPD en 2018).
                                          

                           Procédure d'installation du projet:

Récupérer le dépôt git git clone https://github.com/letsgowithme/symfony_diet

Installation des dépendances: composer require

                         Pour créer d’un administrateur pour le back office

composer require admin
composer require easycorp/easyadmin-bundle
symfony console make:admin:dashboard
symfony console make:admin:crud

                          Pour Configurer une interface d'administration:
                            
https://symfony.com/doc/current/the-fast-track/fr/9-backend.html


