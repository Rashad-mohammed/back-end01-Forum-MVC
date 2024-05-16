<?php
    namespace App;

    abstract class Entity{    // La méthode hydrate prend un tableau associatif de données en paramètre

        protected function hydrate($data){    // La méthode hydrate prend un tableau associatif de données en paramètre

            foreach($data as $field => $value){  //parcours du tableau associatif de données

                //field = marque_id
                //fieldarray = ['marque','id']
                $fieldArray = explode("_", $field);  //Le champ (field) est séparé en deux parties s'il contient "_"

                if(isset($fieldArray[1]) && $fieldArray[1] == "id"){     // Si la deuxième partie du champ est "id", cela indique une clé étrangère
                    $manName = ucfirst($fieldArray[0])."Manager";        // Construction du nom du gestionnaire de la classe associée

                    $FQCName = "Model\Managers".DS.$manName;
                    $manName = ucfirst($fieldArray[0]) . "Manager";   

                    $man = new $FQCName();                         // Instanciation du gestionnaire de la classe associée

                    $value = $man->findOneById($value);          // Récupération de l'objet associé en utilisant la méthode findOneById du gestionnaire

                }

                $method = "set".ucfirst($fieldArray[0]);          // Construction du nom de la méthode setter à appeler (ex: setMarque)

               
                if(method_exists($this, $method)){                // Vérification de l'existence de la méthode dans la classe

                    $this->$method($value);                    // Appel de la méthode setter pour définir la valeur de la propriété

                }

            }
        }
        
        // Méthode qui retourne le nom de la classe de l'objet
        public function getClass(){
            return get_class($this);
        }
    }