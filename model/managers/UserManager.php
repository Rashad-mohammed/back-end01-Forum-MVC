<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;
use Model\Managers\UserManager;
use Model\Entities\Message;
use Model\Managers\MessageManager;

class UserManager extends Manager
{
    protected $className = "Model\Entities\User";
    protected $tableName = "user";


    public function __construct(){
        parent::connect();
    }
    
    public function findOneByEmailWithPassword($email, $password){

        $sql = "SELECT u.email, u.password , u.role , u.id_user
        FROM user u
        WHERE u.email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, [':email' => $email], false),
            $this->className
        );
    }
   
    //////////////////////////////////////
    //finds the topicss of one user
    public function detailsTopicByUser($id){
        $sql ="SELECT *
        FROM topic t
        JOIN user u ON u.id_user = t.user_id
        WHERE id_user= :id_user;
        ";

        $result = DAO::select($sql, [':id_user' => $id], false);
        return $result;
    }
   
    
}
