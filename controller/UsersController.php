<?php
namespace controller;

use App\AbstractController;
use App\Session;
use Model\Managers\UserManager;

class UsersController extends AbstractController {

    public function index() {
        // Vérifier si l'utilisateur est connecté
        if (Session::getUser()) {
            // Afficher la page du profil
            return[
                "view" => VIEW_DIR. "security/profil.php",
                "data" => [
                    "user" => Session::getUser()
                ]
                ];
        } else {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            Session::addFlash("error", "Vous devez être connecté pour accéder à votre profil.");
            $this->redirectTo("security", "index");
        }
    }
    

    public function affichListeUsers() {
        $manager = new UserManager();
        $users = $manager->findAll();  // Un générateur est retourné
    
        // Convertir le générateur en tableau
        $usersArray = iterator_to_array($users);
    
        // var_dump($usersArray);  // Maintenant, c'est un tableau ordinaire
    
        return [
            "view" => VIEW_DIR . "security/listUsers.php",
            "data" => [
                "users" => $usersArray
            ]
        ];
    }
    

}
