<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\TopicManager;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }
        ///////////////////////////////////////
        // finds the topics Posted by one user 

        public function TopicUser($id){
            $sql = "SELECT *
                FROM topic t
                JOIN user u ON u.id_user = t.user_id
                WHERE u.id_user = :id_user
                ORDER BY YEAR(creationdate) DESC, MONTH(creationdate) DESC, DAY(creationdate) DESC";

            return $this->getMultipleResults(
                DAO::select($sql, [':id_user' => $id]),
                $this->className
            );
        }
      
        ///////////////////////////////////////    
        // finds the topics of one category 
        public function TopicCategory($id){

            $sql = "SELECT *
                    FROM " . $this->tableName . " a
                    WHERE a.category_id = :id
                    ORDER BY YEAR(creationdate) DESC, MONTH(creationdate) DESC,  DAY(creationdate) DESC
                    ";
                
            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id], true), 
                $this->className
            );

        }
        ///////////////////////////////////////
        // finds if the user is an admin        
        public function findIfAdmin($userId) {
            $sql = 'SELECT * FROM user WHERE id_user = :id_user AND role = "ROLE_ADMIN"';
            return $this->getOneOrNullResult(
                DAO::select($sql, [':id_user' => $userId], true),
                $this->className
            );
        }
        ///////////////////////////////////////
        //delete the The topic
        public function deleteTopic($id){
            $sql = "DELETE FROM `topic` 
                WHERE id_topic = :id_topic";

            try {
                $params = [':id_topic' => $id];

                DAO::delete($sql, $params);

                // Optionally handle success or return a result
                return true;
            } catch (\Exception $e) {
                // Handle the exception or log an error message
                echo $e->getMessage();
                return false;
            }
        }
        ///////////////////////////////////////
        // lock the topic
        public function addLock($idTopic){
            $sql = "update topic 
            SET lockTopic = 1
            WHERE id_topic = ?
            ";
    
            return $this->getOneOrNullResult(
                DAO::select($sql, [$idTopic], false), 
                $this->className
            );
        }
        ///////////////////////////////////////
        // remove the lock topic
        public function removeLock($idTopic){
            $sql = "update topic 
            SET lockTopic = 0
            WHERE id_topic = ?
            ";
    
            return $this->getOneOrNullResult(
                DAO::select($sql, [$idTopic], false), 
                $this->className
            );
        }
        //////////////////////////////////////
        // see the topic status
        public function lockStatus($idTopic){
            $sql = "SELECT *
            FROM topic 
            WHERE lockTopic = 0
            and id_topic = ?
            ";
    
            return $this->getOneOrNullResult(
                DAO::select($sql, [$idTopic], false), 
                $this->className
            );
        }

       
    }