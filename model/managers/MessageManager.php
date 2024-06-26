<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;
use Model\Managers\UserManager;
use Model\Entities\Message;


class MessageManager extends Manager{
    protected $className = "Model\Entities\Message";
    protected $tableName = "message";

    public function __construct(){
        parent :: connect();
    }
    
}
