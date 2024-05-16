<?php
    namespace Model\Entities;

    use App\Entity;

    final class User extends Entity{
        private $id;
        private $email;
        private $pseudo;
        private $password;
        private $role;
     

        public function __construct($data){         
            $this->hydrate($data);        
        }


        // //////////////////////////////////////////////////////////////////
        /**
         * Get the value of id
         */ 
        public function getId(){

                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id){
        
                $this->id = $id;

                return $this;
        }

        // ///////////////////////////////

        /**
         * Get the value of email
         */ 
        public function getEmail(){
        
                return $this->email;
        }
        /**
         * Set the value of email
         *
         * @return  self
         */
        public function setEmail($email){
        
                $this->email = $email;
                return $this;
        }

        // ///////////////////////////////

        /**
         * Get the value of pseudo
         */
        public function getPseudo()
        {
        return $this->pseudo;
        }

        /////////////////////////////// 
        /**
         * Set the value of pseudo
         *
         * @return  self
         */
        public function setPseudo($pseudo)
        {
                $this->pseudo = $pseudo;
                return $this;
        }

        ///////////////////////////////
        /**
        * Get the value of password
        * 
        * @return  string|null
        */
        public function getPassword() {
        return $this->password;
        }

        ///////////////////////////////

        /**
        * Set the value of password
        *
        * @param string $password
        * @return  self
        */
        public function setPassword($password) {
        $this->password = $password;
        return $this;
        }
        
        ///////////////////////////////
   /**
     * Get the value of role
     */
    public function getRole()
    {
        return json_decode($this->role);
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = json_encode($role);

        return $this;
    }

    public function hasRole($role)
    {
        $result = $this->getRole() == json_encode($role);
        return $result;
    }
}
    

      
