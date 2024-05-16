<?php
    namespace App;

    class Session{

        private static $categories = ['error', 'success'];

        /**
        *   ajoute un message en session, dans la catégorie $categ
        */
        public static function addFlash($categ, $msg){
            $_SESSION[$categ] = $msg;
        }

        /**
        *   renvoie un message de la catégorie $categ, s'il y en a !
        */
        public static function getFlash($categ){
            
            if(isset($_SESSION[$categ])){
                $msg = $_SESSION[$categ];  
                unset($_SESSION[$categ]);
            }
            else $msg = "";
            
            return $msg;
        }

        /**
        *   met un user dans la session (pour le maintenir connecté)
        */
        public static function setUser($user){
            $_SESSION["user"] = $user;
        }

        public static function getUser(){
            return (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
        }

        public static function isAdmin()
        {
            if (self::getUser() && self::getUser()->hasRole("ROLE_ADMIN")) {
                return true;
            }
            return false;
        }

        /**
        * Fonction Token - Génère un token, l'associe à une session utilisateur et le retourne.
        *
        * @return string|bool Retourne le token généré s'il a été correctement défini dans la session, sinon retourne false.
        */

        public static function Token() {
            // Génère un token aléatoire de 32 octets et le convertit en une chaîne hexadécimale.
            $_SESSION['token'] = bin2hex(random_bytes(32));

            // Définit le moment d'expiration du token à 1 heure (3600 secondes) à partir du temps actuel.
             $_SESSION['token-exp'] = time() + 3600; // 1 heure

            // Retourne le token s'il a été correctement défini dans la session, sinon retourne false.
            return (isset($_SESSION['token'])) ? $_SESSION['token'] : false;
        }

    }