<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;
use Model\Managers\CategoryManager;

class CategoryManager extends Manager
{
    protected $className = "Model\Entities\Category";
    protected $tableName = "category";

    public function __construct(){
        parent::connect();
    }
    
    //function et requet pour listes les topic via categorie
    public function showTopicsByCategory($Id_category){
        $sql = "SELECT
            t.id_topic,
            t.title,
            t.content,
            u.pseudo AS user_pseudo,
            c.nameCategory AS category_name
            FROM topic t
            JOIN category c ON t.category_id = c.id_category
            JOIN user u ON t.user_id = u.id_user
            WHERE c.id_category = :id_category;";
    
        return $this->getMultipleResults(
            DAO::select($sql, [':id_category' => $Id_category]), 
            $this->className
        );

       

    }

}
