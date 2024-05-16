<?php

namespace Controller;
use App\DAO;
use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Entities\User;
use Model\Managers\MessageManager;

class SecurityController extends AbstractController {
    public function index() {}
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////        process    login         //////////////////////////////////////////////////
    public function processLogin() {
        if ($_POST) {
            // var_dump($_POST);die();
            $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';
            $password = isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : '';
            // $password = isset($_POST["password"]) ? $_POST["password"] : '';
            if ($email && $password) {
                $userManager = new UserManager();
    
                // Rechercher l'utilisateur en utilisant l'email et récupérer le mot de passe depuis la base de données
                $user = $userManager->findOneByEmailWithPassword($email, $password);
    
                // Vérifier si l'utilisateur a été trouvé
                if ($user) {
                    // Vérifier si le mot de passe saisi correspond au mot de passe stocké dans la base de données
                    if (password_verify($password, $user->getPassword())) {
                        // Authentification réussie, enregistrer l'utilisateur dans la session
                        $_SESSION["user"] = $user;
    
                        // Rediriger l'utilisateur vers la page profil.php
                        header("Location: index.php");
                        exit();
                        return[
                            "view" => VIEW_DIR."security/login.php",
                            "data" => [
                                "user" => $user
                            ]
                            ];
                    } else {
                        // Mot de passe incorrect
                        Session::addFlash("error", "Mot de passe incorrect");
                        return [
                            "view" => VIEW_DIR . "security/login.php",
                            "data" => null,
                        ];
                    }
                } else {
                    // Utilisateur non trouvé dans la base de données
                    Session::addFlash("error", "Adresse e-mail incorrecte");
                    return [
                        "view" => VIEW_DIR . "security/login.php",
                        "data" => null,
                    ];
                }
            } else {
                // Les champs email ou mot de passe sont vides
                Session::addFlash("error", "Veuillez remplir tous les champs");
                return [
                    "view" => VIEW_DIR . "security/login.php",
                    "data" => null,
                ];
            }
        }
    }
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////        process    register         //////////////////////////////////////////////////
    public function processRegister() {
        // Vérifier si le formulaire a été soumis
        if ($_POST) {
            // var_dump($_POST);die();
            // Récupérer les données du formulaire
            $pseudo = isset($_POST["pseudo"]) ? htmlspecialchars($_POST["pseudo"]) : '';
            $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';
            $confirmEmail = isset($_POST["confirmEmail"]) ? htmlspecialchars($_POST["confirmEmail"]) : '';
            $password = isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : '';
            $confirmPassword = isset($_POST["confirmPassword"]) ? htmlspecialchars($_POST["confirmPassword"]) : '';
    
            // Vérifier si les adresses email correspondent
            if ($email !== $confirmEmail) {
                echo "Les adresses email ne correspondent pas.";
                return;
            }
    
            // Vérifier si les mots de passe correspondent
            if ($password !== $confirmPassword) {
                echo "Les mots de passe ne correspondent pas.";
                return;
            }
    
            // Hasher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $userManager = new UserManager();
            $newUser = [
                        "pseudo" => $pseudo,
                        "email" => $email,
                        "password" => $hashedPassword,
                        "role" => json_encode("ROLE_USER"), 
                        ];

            $userManager->add($newUser);
            // var_dump($newUser);die();
          
            header("Location: view/security/login.php");
            exit();
            return[
                "view" => VIEW_DIR."security/register.php",
                "data" => null,
            ];
        }
    }
    
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////        process    profil         //////////////////////////////////////////////////
    public function processProfil() {
        // Vérifier si l'utilisateur est connecté
        if (Session::getUser()) {
            // Afficher la page du profil
            return [
                "view" => VIEW_DIR . "security/profil.php",
                "data" => null,
            ];
        } else {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            Session::addFlash("error", "Vous devez être connecté pour accéder à votre profil.");
            $this->redirectTo("security", "index");
        }
    }
     
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////        process    logout         //////////////////////////////////////////////////
    public function logout(){
        // Vérifier si une session est active avant de tenter de la démarrer
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        // Détruire la session
        session_destroy();
    
        // Ajouter un message de déconnexion
        Session::addFlash("success", "Déconnecté");
    
        // Retourner un tableau indiquant la redirection
        // return [
        //     "view" => VIEW_DIR . "security/login.php",
        //     "data" => null,
        // ];
        header("Location: index.php");
        exit();
    }
}

