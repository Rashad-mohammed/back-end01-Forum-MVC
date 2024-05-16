<?php
    namespace Model\Entities;

    use App\Entity;

    final class Category extends Entity{
        
        private $id;
        private $nameCategory;
     
        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        public function getNameCategory()
        {
                return $this->nameCategory;
        }

        public function setNameCategory($nameCategory)
        {
                $this->nameCategory= $nameCategory;

                return $this;
        }
    }
