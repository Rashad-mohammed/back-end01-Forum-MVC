<?php
    namespace App;

    abstract class AbstractController{

        public function index(){}
        
        public function redirectTo($ctrl = null, $action = null, $id = null)
        {
            if ($ctrl != "home") {
                $url = $ctrl ? "?ctrl=" . $ctrl : "";
                $url .= $action ? "&action=" . $action : "";
                $url .= $id ? "&id=" . $id : "";
            } else $url = "/";
            header("Location: $url");
            die();
        }


        public function restrictTo($role){
            
            if(!Session::getUser() || !Session::getUser()->hasRole($role)){
                $this->redirectTo("security", "login");
            }
            return;
        }

    }

// Les espaces de noms sont des qualificatifs qui résolvent deux problèmes différents :
//Ils permettent une meilleure organisation en regroupant les classes qui travaillent ensemble pour réaliser une tâche
//Ils permettent d'utiliser le même nom pour plus d'une classe
//Le class AbstractController permet de définir des méthodes abstraite qui seront appelées dans cette classe pour les autres classes d'implémentation d'une tâche
