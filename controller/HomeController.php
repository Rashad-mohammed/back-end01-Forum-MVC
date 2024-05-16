<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    
    class HomeController extends AbstractController implements ControllerInterface{
        // Cette méthode gère l'action par défaut pour la page d'accueil 
        //important ne laissez pas cette function est vide car en index : define('DEFAULT_CTRL', 'Home'); //nom du contrôleur par défaut
        public function index(){
          
            $topicManager = new TopicManager();          // Créer une instance de TopicManager pour interagir avec les sujets dans la base de données

            $topics= $topicManager->findAll();          // Récupérer tous les sujets de la base de données
           
            $categoryManager = new CategoryManager();          // Créer une instance de CategoryManager pour interagir avec les categories
            $categories = $categoryManager->findAll(["nameCategory", "DESC"]);          // Récupérer tous les categories de la base de
                return [                                // Retourner un tableau avec des informations pour le rendu de la vue
                    "view" => VIEW_DIR."home.php",      // Le chemin vers le fichier de vue
                    "data" => [
                        "topics" => $topics,             // Les données à transmettre à la vue, dans ce cas, un tableau de sujets
                        "categories" => $categories, // Les données à transmettre à la vue,
                    ]
                ];
        }
        ////////////////////////////////////////////////////////////////
        public function users(){
            $this->restrictTo("ROLE_USER");             // Restreindre l'accès à cette action aux utilisateurs ayant le rôle 'ROLE_USER'

            $manager = new UserManager();               // Créer une instance de UserManager pour interagir avec les données utilisateur dans la base de données
            $users = $manager->findAll(['registerdate', 'DESC']);    // Récupérer tous les utilisateurs de la base de données, triés par date d'inscription par ordre décroissant

            return [                                     // Retourner un tableau avec des informations pour le rendu de la vue
                "view" => VIEW_DIR."security/users.php",// Le chemin vers le fichier de vue
                "data" => [                             // Les données à transmettre à la vue, dans ce cas, un tableau d'utilisateurs
                    "users" => $users
                ]
            ];
        }
        ////////////////////////////////////////////////////////////////
        public function forumRules(){
            
            return [
                "view" => VIEW_DIR."rules.php"
            ];
        }

        /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
    }
